<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveDiscountRequest;
use App\Http\Requests\Treatment\SaveTreatmentRequest;
use App\Models\Discount;
use App\Models\Treatment\Treatment;
use App\Services\ResponseService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Nette\Schema\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class DiscountController extends Controller
{
    public function getDiscounts(): JsonResponse
    {
        try {
            $discounts = Discount::orderBy('definition')->get();
            return ResponseService::success($discounts, 'Success');
        } catch (Exception $e) {
            Log::info('Discounts are not fetched.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching discounts.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getDiscount($id): JsonResponse
    {
        try {
            $discount = Discount::findOrFail($id);
            return ResponseService::success($discount, 'Success');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('Discount is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Discount is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            Log::info('Discount is not fetched.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching discount.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createDiscount(SaveDiscountRequest $request): JsonResponse
    {
        try {
            $fields = $request->validated();
            DB::beginTransaction();
            $discount = Discount::create($fields);
            DB::commit();
            Log::info('Discount with the ID ' . $discount->id . ' is created by ' . auth()->user()->id);
            return ResponseService::success($discount, 'Discount is created successfully.', Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::info('Discount is not created.Error: ' . $e->getMessage());
            return ResponseService::fail($e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Discount is not created.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while creating discount.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function updateDiscount(SaveDiscountRequest $request, $id): JsonResponse
    {
        try {
            $discount = Discount::findOrFail($id);
            $fields = $request->validated();
            DB::beginTransaction();
            $discount->update($fields);
            DB::commit();
            Log::info('Discount with the ID ' . $discount->id . ' is updated by ' . auth()->user()->id);
            return ResponseService::success($discount, 'Discount is updated successfully.');
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::info('Discount is not updated.Error: ' . $e->getMessage());
            return ResponseService::fail($e->getMessage());
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('Discount is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Discount is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Discount is not updated.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while updating discount.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteDiscount($id): JsonResponse
    {
        try {
            $discount = Discount::findOrFail($id);
            DB::beginTransaction();
            $discount->delete();
            DB::commit();
            Log::info('Discount with the ID ' . $id . ' is deleted by ' . auth()->user()->id);
            return ResponseService::success(null, 'Discount is deleted successfully.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('Discount is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Discount is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Discount is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while deleting discount.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
