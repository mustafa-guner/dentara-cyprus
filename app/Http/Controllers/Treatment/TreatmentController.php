<?php

namespace App\Http\Controllers\Treatment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Treatment\SaveTreatmentRequest;
use App\Models\Treatment\Treatment;
use App\Services\ResponseService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Nette\Schema\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class TreatmentController extends Controller
{
    public function getTreatments(): JsonResponse
    {
        try {
            $treatments = Treatment::orderBy('created_at','desc')->get();
            return ResponseService::success($treatments, 'Success');
        } catch (Exception $e) {
            Log::info('Treatments are not fetched.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching treatments.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getTreatment($id): JsonResponse
    {
        try {
            $treatment = Treatment::findOrFail($id);
            return ResponseService::success($treatment, 'Success');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('Treatment is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Treatment is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            Log::info('Treatment is not fetched.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching treatment.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createTreatment(SaveTreatmentRequest $request): JsonResponse
    {
        try {
            $fields = $request->validated();
            DB::beginTransaction();
            $treatment = Treatment::create($fields);
            DB::commit();
            Log::info('Treatment with the ID ' . $treatment->id . ' is created by ' . auth()->user()->id);
            return ResponseService::success($treatment, 'Treatment is created successfully.', Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::info('Treatment is not created.Error: ' . $e->getMessage());
            return ResponseService::fail($e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Treatment is not created.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while creating treatment.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function updateTreatment(SaveTreatmentRequest $request, $id): JsonResponse
    {
        try {
            $treatment = Treatment::findOrFail($id);
            $fields = $request->validated();
            DB::beginTransaction();
            $treatment->update($fields);
            DB::commit();
            Log::info('Treatment with the ID ' . $treatment->id . ' is updated by ' . auth()->user()->id);
            return ResponseService::success($treatment, 'Treatment is updated successfully.');
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::info('Treatment is not updated.Error: ' . $e->getMessage());
            return ResponseService::fail($e->getMessage());
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('Treatment is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Treatment is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Treatment is not updated.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while updating treatment.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteTreatment($id): JsonResponse
    {
        try {
            $treatment = Treatment::findOrFail($id);
            DB::beginTransaction();
            $treatment->delete();
            DB::commit();
            Log::info('Treatment with the ID ' . $id . ' is deleted by ' . auth()->user()->id);
            return ResponseService::success(null, 'Treatment is deleted successfully.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('Treatment is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Treatment is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Treatment is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while deleting treatment.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
