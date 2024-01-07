<?php

namespace App\Http\Controllers\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\SaveAppointmentTypeRequest;
use App\Models\Appointment\AppointmentType;
use App\Services\ResponseService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Nette\Schema\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AppointmentTypeController extends Controller
{
    public function getAppointmentTypes(): JsonResponse
    {
        try {
            $appointmentTypes = AppointmentType::orderBy('title')->get();
            return ResponseService::success($appointmentTypes, 'Success');
        } catch (Exception $e) {
            Log::info('Appointments types are not fetched.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching appointment types.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAppointmentType($id): JsonResponse
    {
        try {
            $appointmentType = AppointmentType::findOrFail($id);
            return ResponseService::success($appointmentType, 'Success');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('Appointment type is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Appointment type is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            Log::info('Appointment type is not fetched.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching appointment type.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createAppointmentType(SaveAppointmentTypeRequest $request): JsonResponse
    {
        try {
            $fields = $request->validated();
            DB::beginTransaction();
            $appointmentType = AppointmentType::create($fields);
            DB::commit();
            Log::info('Appointment type with the ID ' . $appointmentType->id . ' is created by ' . auth()->user()->id);
            return ResponseService::success($appointmentType, 'Appointment type is created successfully.', Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::info('Appointment type is not created.Error: ' . $e->getMessage());
            return ResponseService::fail($e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Appointment type is not created.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while creating appointment type.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function updateAppointmentType(SaveAppointmentTypeRequest $request, $id): JsonResponse
    {
        try {
            $appointmentType = AppointmentType::findOrFail($id);
            $fields = $request->validated();
            DB::beginTransaction();
            $appointmentType->update($fields);
            DB::commit();
            Log::info('Appointment type with the ID ' . $appointmentType->id . ' is updated by ' . auth()->user()->id);
            return ResponseService::success($appointmentType, 'Appointment type is updated successfully.');
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::info('Appointment type is not updated.Error: ' . $e->getMessage());
            return ResponseService::fail($e->getMessage());
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('Appointment type is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Appointment type is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Appointment type is not updated.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while updating appointment type.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteAppointmentType($id): JsonResponse
    {
        try {
            $appointmentType = AppointmentType::findOrFail($id);
            DB::beginTransaction();
            $appointmentType->delete();
            DB::commit();
            Log::info('Appointment type with the ID ' . $id . ' is deleted by ' . auth()->user()->id);
            return ResponseService::success(null, 'Appointment type is deleted successfully.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('Appointment type is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Appointment type is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Appointment type is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while deleting appointment type.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
