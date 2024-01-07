<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User\User;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $fields = $request->validated();
            $user = User::where('email', $fields['email'])->first();

            if (!$user || !Hash::check($fields['password'], $user->password)) {
                return ResponseService::fail('Invalid credentials.', Response::HTTP_UNAUTHORIZED);
            }

            $token = $user->createAccessToken('authToken')->plainTextToken;

            return ResponseService::success([
                'token' => $token,
            ], 'Login successful', Response::HTTP_OK);

        } catch (Exception $e) {
            Log::error('User is not logged in. Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while logging in. Please try again.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function me(): JsonResponse
    {
        try {
            $user = auth()->user();
            return ResponseService::success($user, 'Success');
        } catch (Exception $e) {
            Log::error('User is not logged in. Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching user details. Please try again.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logout(): JsonResponse
    {
        try {
            auth()->user()->tokens()->delete();
            return ResponseService::success(null, 'Logged out successfully.', Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('User is not logged out.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while logging out. Please try again.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
