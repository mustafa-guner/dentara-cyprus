<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveUserRequest;
use App\Models\User\User;
use App\Services\ResponseService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Nette\Schema\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function getUsers(): JsonResponse
    {
        try {
            $users = User::orderBy('name')->get();
            return ResponseService::success($users, 'Success');
        } catch (Exception $e) {
            Log::info('Users are not fetched.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching users.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUser($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            return ResponseService::success($user, 'Success');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('User is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('User is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            Log::info('User is not fetched.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching user.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createUser(SaveUserRequest $request): JsonResponse
    {
        try {
            $fields = $request->validated();
            DB::beginTransaction();
            $fields['created_by'] = auth()->user()->id;
            $newUser = User::create($fields);
            DB::commit();
            Log::info('User with the ID ' . $newUser->id . ' is created by ' . auth()->user()->id);
            return ResponseService::success($newUser, 'User is created successfully.',Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::info('User is not created.Error: ' . $e->getMessage());
            return ResponseService::fail($e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('User is not created.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while creating user.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function updateUser(SaveUserRequest $request, $id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            $fields = $request->validated();
            DB::beginTransaction();
            $fields['updated_by'] = auth()->user()->id;
            $user->update($fields);
            DB::commit();
            Log::info('User with the ID ' . $user->id . ' is updated by ' . auth()->user()->id);
            return ResponseService::success($user, 'User is updated successfully.');
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::info('User is not updated.Error: ' . $e->getMessage());
            return ResponseService::fail($e->getMessage());
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('User is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('User is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('User is not updated.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while updating user.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteUser($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            DB::beginTransaction();
            $user->deleted_by = auth()->user()->id;
            $user->delete();
            DB::commit();
            Log::info('User with the ID ' . $id . ' is deleted by ' . auth()->user()->id);
            return ResponseService::success(null, 'User is deleted successfully.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            Log::info('User is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('User is not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('User is not deleted.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while deleting user.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
