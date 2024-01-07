<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use App\Models\User\Role;
use App\Models\User\UserType;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ResourceController extends Controller
{
    public function getGenders(): JsonResponse
    {
        try {
            $genders = Gender::orderBy('definition')->get();
            return ResponseService::success($genders, 'Success');
        } catch (Exception $e) {
            Log::error('Genders are not fetched.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching genders.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getRoles(): JsonResponse
    {
        try {
            $roles = Role::orderBy('definition')->get();
            return ResponseService::success($roles, 'Success');
        } catch (Exception $e) {
            Log::error('Roles are not fetched.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching roles.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUserTypes(): JsonResponse
    {
        try {
            $userTypes = UserType::orderBy('definition')->get();
            return ResponseService::success($userTypes, 'Success');
        } catch (Exception $e) {
            Log::error('User Types are not fetched.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching user types.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
