<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User\User;
use App\Services\ResponseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

            // Check if the input is a valid email address
            $isEmail = filter_var($fields['username_or_email'], FILTER_VALIDATE_EMAIL) !== false;

            // Find the user by email or username based on the input
            $user = User::where($isEmail ? 'email' : 'username', $fields['username_or_email'])->firstOrFail();

            if (!$user || !Hash::check($fields['password'], $user->password)) {
                return ResponseService::fail('Invalid credentials.', Response::HTTP_UNAUTHORIZED);
            }

            $token = $user->createToken('access-token', [], Carbon::tomorrow())->plainTextToken;

            return ResponseService::success([
                'token' => $token,
            ], 'Login successful', Response::HTTP_OK);

        } catch (ModelNotFoundException $e) {
            Log::error('User account is not found. Error: ' . $e->getMessage());
            return ResponseService::fail('User account with the provided credentials is not found.', Response::HTTP_NOT_FOUND);
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
