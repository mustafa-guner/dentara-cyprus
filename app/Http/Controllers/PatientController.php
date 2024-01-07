<?php

namespace App\Http\Controllers;

use App\Http\Requests\SavePatientRequest;
use App\Models\Patient;
use App\Services\ResponseService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Nette\Schema\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class PatientController extends Controller
{
    public function getPatients(): JsonResponse
    {
        try {
            $patients = Patient::orderBy('name')->get();
            return ResponseService::success($patients, 'Success');
        } catch (Exception $e) {
            Log::info('Patients are not fetched.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching patients.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getPatient($id): JsonResponse
    {
        try {
            $patient = Patient::findOrFail($id);
            return ResponseService::success($patient, 'Success');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('Patient is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Patient is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            Log::info('Patient is not fetched.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching patient.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createPatient(SavePatientRequest $request): JsonResponse
    {
        try {
            $fields = $request->validated();
            DB::beginTransaction();
            $fields['created_by'] = auth()->user()->id;
            $patient = Patient::create($fields);
            DB::commit();
            Log::info('Patient with the ID ' . $patient->id . ' is created by ' . auth()->user()->id);
            return ResponseService::success($patient, 'Patient is created successfully.', Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::info('Patient is not created.Error: ' . $e->getMessage());
            return ResponseService::fail($e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Patient is not created.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while creating patient.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function updatePatient(SavePatientRequest $request, $id): JsonResponse
    {
        try {
            $patient = Patient::findOrFail($id);
            $fields = $request->validated();
            DB::beginTransaction();
            $fields['updated_by'] = auth()->user()->id;
            $patient->update($fields);
            DB::commit();
            Log::info('Patient with the ID ' . $patient->id . ' is updated by ' . auth()->user()->id);
            return ResponseService::success($patient, 'Patient is updated successfully.');
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::info('Patient is not updated.Error: ' . $e->getMessage());
            return ResponseService::fail($e->getMessage());
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('Patient is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Patient is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Patient is not updated.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while updating patient.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deletePatient($id): JsonResponse
    {
        try {
            $patient = Patient::findOrFail($id);
            DB::beginTransaction();
            $patient->deleted_by = auth()->user()->id;
            $patient->delete();
            DB::commit();
            Log::info('Patient with the ID ' . $id . ' is deleted by ' . auth()->user()->id);
            return ResponseService::success(null, 'Patient is deleted successfully.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('Patient is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Patient is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Patient is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while deleting patient.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
