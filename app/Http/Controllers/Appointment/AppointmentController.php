<?php

namespace App\Http\Controllers\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\SaveAppointmentRequest;
use App\Models\Appointment\Appointment;
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
            $appointments = Appointment::orderBy('appointment_date','desc')->get();
            return ResponseService::success($appointments, 'Success');
        } catch (Exception $e) {
            Log::info('Appointments are not fetched.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching appointments.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAppointment($id): JsonResponse
    {
        try {
            $appointment = Appointment::findOrFail($id);
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
            $appointment = Appointment::create($fields);
            DB::commit();
            Log::info('Appointment with the ID ' . $appointment->id . ' is created by ' . auth()->user()->id);
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
            DB::commit();
            Log::info('Appointment with the ID ' . $appointment->id . ' is updated by ' . auth()->user()->id);
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
}
