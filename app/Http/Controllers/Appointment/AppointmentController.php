<?php

namespace App\Http\Controllers\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\SaveAppointmentRequest;
use App\Models\Appointment\Appointment;
use App\Models\Appointment\AppointmentTreatments;
use App\Models\Appointment\AppointmentType;
use App\Services\ResponseService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Nette\Schema\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AppointmentController extends Controller
{
    public function getAppointments(): JsonResponse
    {
        try {
            $appointments = Appointment::orderBy('appointment_date', 'desc')
                ->with(['assignedUser', 'patient', 'appointmentType', 'appointmentStatus', 'createdBy', 'updatedBy', 'deletedBy'])
                ->get();
            return ResponseService::success($appointments, 'Success');
        } catch (Exception $e) {
            Log::info('Appointments are not fetched.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching appointments.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAppointment($id): JsonResponse
    {
        try {
            $appointment = Appointment::findOrFail($id)
                ->load(['assignedUser', 'patient', 'appointmentType', 'appointmentStatus', 'createdBy', 'updatedBy', 'deletedBy']);
            return ResponseService::success($appointment, 'Success');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('Appointment is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Appointment is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            Log::info('Appointment is not fetched.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching appointment.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createAppointment(SaveAppointmentRequest $request): JsonResponse
    {
        try {
            $fields = $request->validated();
            DB::beginTransaction();
            $fields['created_by'] = auth()->user()->id;

            //Set the initial appointment price based on the appointment type
            $appointmentType = AppointmentType::findOrFail($fields['appointment_type_id']);
            $fields['price'] = $appointmentType->price;
            $fields['real_price'] = $appointmentType->price;

            $appointment = Appointment::create($fields);
            $logs[] = 'Appointment with the ID ' . $appointment->id . ' is created by ' . auth()->user()->id;

            if(isset($fields['treatment_id'])) {
                $this->addTreatmentToAppointment($appointment, $fields, $logs);
            }

            DB::commit();

            foreach ($logs as $log) {
                Log::info($log);
            }

            $appointment->load(['assignedUser', 'patient', 'appointmentType', 'appointmentStatus', 'createdBy', 'updatedBy', 'deletedBy']);
            return ResponseService::success($appointment, 'Appointment is created successfully.', Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::info('Appointment is not created.Error: ' . $e->getMessage());
            return ResponseService::fail($e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Appointment is not created.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while creating appointment.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateAppointment(SaveAppointmentRequest $request, $id): JsonResponse
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $fields = $request->validated();
            DB::beginTransaction();
            $fields['updated_by'] = auth()->user()->id;
            $appointment->update($fields);
            $logs[] = 'Appointment with the ID ' . $appointment->id . ' is updated by ' . auth()->user()->id;
            if(isset($fields['treatment_id'])) {
                $this->updateAppointmentTreatments($appointment,$fields,$logs);
            }
            DB::commit();
            $appointment->load(['assignedUser', 'patient', 'appointmentType', 'appointmentStatus', 'createdBy', 'updatedBy', 'deletedBy']);
            foreach ($logs as $log) {
                Log::info($log);
            }
            return ResponseService::success($appointment, 'Appointment is updated successfully.');
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::info('Appointment is not updated.Error: ' . $e->getMessage());
            return ResponseService::fail($e->getMessage());
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('Appointment is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Appointment is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Appointment is not updated.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while updating appointment.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteAppointment($id): JsonResponse
    {
        try {
            $appointment = Appointment::findOrFail($id);
            DB::beginTransaction();
            $appointment->deleted_by = auth()->user()->id;
            $appointment->delete();
            DB::commit();
            Log::info('Appointment with the ID ' . $id . ' is deleted by ' . auth()->user()->id);
            return ResponseService::success(null, 'Appointment is deleted successfully.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('Appointment is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Appointment is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Appointment is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while deleting appointment.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function calculatePrice($id): JsonResponse
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->calculateTotalPrice();
            $appointment->load(['assignedUser', 'patient', 'appointmentType', 'appointmentStatus', 'createdBy', 'updatedBy', 'deletedBy']);
            return ResponseService::success($appointment, 'Appointment price is calculated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Appointment price is not calculated.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while calculation appointment price.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function addTreatmentToAppointment($appointment, $fields, &$logs): void
    {
        $treatmentsApplied = $fields['treatment_id'];
        foreach ($treatmentsApplied as $treatment) {
            $appointmentTreatment = AppointmentTreatments::create([
                'appointment_id' => $appointment->id,
                'treatment_id' => $treatment,
                'user_id' => $fields['user_id'], //Responsible from the treatment (nurse,doctor etc)
            ]);
            $logs[] = 'Appointment treatment with the ID ' . $appointmentTreatment->id . ' is created by ' . auth()->user()->id;
        }
    }

    private function updateAppointmentTreatments($appointment,$fields,&$logs):void
    {
        foreach ($appointment->treatments as $treatment) {
            $treatment->delete();
        }
        $this->addTreatmentToAppointment($appointment, $fields, $logs);
    }
}
