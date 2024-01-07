<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveEquipmentRequest;
use App\Models\Equipment;
use App\Models\Patient;
use App\Services\ResponseService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Nette\Schema\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class EquipmentController extends Controller
{
    public function getEquipments(): JsonResponse
    {
        try {
            $equipments = Equipment::orderBy('definition')->get();
            return ResponseService::success($equipments, 'Success');
        } catch (Exception $e) {
            Log::info('Equipments are not fetched.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching equipments.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getEquipment($id): JsonResponse
    {
        try {
            $equipment = Equipment::findOrFail($id);
            return ResponseService::success($equipment, 'Success');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('Equipment is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Equipment is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            Log::info('Equipment is not fetched.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching equipment.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createEquipment(SaveEquipmentRequest $request): JsonResponse
    {
        try {
            $fields = $request->validated();
            DB::beginTransaction();
            $fields['created_by'] = auth()->user()->id;
            $equipment = Equipment::create($fields);
            DB::commit();
            Log::info('Equipment with the ID ' . $equipment->id . ' is created by ' . auth()->user()->id);
            return ResponseService::success($equipment, 'Equipment is created successfully.', Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::info('Equipment is not created.Error: ' . $e->getMessage());
            return ResponseService::fail($e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Equipment is not created.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while creating equipment.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function updateEquipment(SaveEquipmentRequest $request, $id): JsonResponse
    {
        try {
            $equipment = Equipment::findOrFail($id);
            $fields = $request->validated();
            DB::beginTransaction();
            $fields['updated_by'] = auth()->user()->id;
            $equipment->update($fields);
            DB::commit();
            Log::info('Equipment with the ID ' . $equipment->id . ' is updated by ' . auth()->user()->id);
            return ResponseService::success($equipment, 'Equipment is updated successfully.');
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::info('Equipment is not updated.Error: ' . $e->getMessage());
            return ResponseService::fail($e->getMessage());
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('Equipment is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Equipment is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Equipment is not updated.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while updating equipment.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteEquipment($id): JsonResponse
    {
        try {
            $equipment = Equipment::findOrFail($id);
            DB::beginTransaction();
            $equipment->delete();
            DB::commit();
            Log::info('Equipment with the ID ' . $id . ' is deleted by ' . auth()->user()->id);
            return ResponseService::success(null, 'Equipment is deleted successfully.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('Equipment is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Equipment is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Equipment is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while deleting equipment.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
