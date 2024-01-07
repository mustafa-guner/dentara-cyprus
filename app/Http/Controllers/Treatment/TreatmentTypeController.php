<?php

namespace App\Http\Controllers\Treatment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Treatment\SaveTreatmentTypeRequest;
use App\Models\Treatment\TreatmentType;
use App\Services\ResponseService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Nette\Schema\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class TreatmentTypeController extends Controller
{
    public function getTreatments(): JsonResponse
    {
        try {
            $treatmentTypes = TreatmentType::orderBy('title')->get();
            return ResponseService::success($treatmentTypes, 'Success');
        } catch (Exception $e) {
            Log::info('Treatment Types are not fetched.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching treatment types.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getTreatmentType($id): JsonResponse
    {
        try {
            $treatmentType = TreatmentType::findOrFail($id);
            return ResponseService::success($treatmentType, 'Success');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('Treatment type is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Treatment type is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            Log::info('Treatment type is not fetched.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching treatment type.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createTreatmentType(SaveTreatmentTypeRequest $request): JsonResponse
    {
        try {
            $fields = $request->validated();
            DB::beginTransaction();
            $treatmentType = TreatmentType::create($fields);
            DB::commit();
            Log::info('Treatment type with the ID ' . $treatmentType->id . ' is created by ' . auth()->user()->id);
            return ResponseService::success($treatmentType, 'Treatment is created successfully.', Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::info('Treatment type is not created.Error: ' . $e->getMessage());
            return ResponseService::fail($e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Treatment type is not created.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while creating treatment type.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function updateTreatmentType(SaveTreatmentTypeRequest $request, $id): JsonResponse
    {
        try {
            $treatmentType = TreatmentType::findOrFail($id);
            $fields = $request->validated();
            DB::beginTransaction();
            $treatmentType->update($fields);
            DB::commit();
            Log::info('Treatment type with the ID ' . $treatmentType->id . ' is updated by ' . auth()->user()->id);
            return ResponseService::success($treatmentType, 'Treatment type is updated successfully.');
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::info('Treatment type is not updated.Error: ' . $e->getMessage());
            return ResponseService::fail($e->getMessage());
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('Treatment type is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Treatment type is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Treatment type is not updated.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while updating treatment type.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteTreatmentType($id): JsonResponse
    {
        try {
            $treatmentType = TreatmentType::findOrFail($id);
            DB::beginTransaction();
            $treatmentType->delete();
            DB::commit();
            Log::info('Treatment type with the ID ' . $id . ' is deleted by ' . auth()->user()->id);
            return ResponseService::success(null, 'Treatment type is deleted successfully.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('Treatment type is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Treatment type is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Treatment type is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while deleting treatment type.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
