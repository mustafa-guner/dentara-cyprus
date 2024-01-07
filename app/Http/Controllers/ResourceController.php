<?php

namespace App\Http\Controllers;

use App\Models\Appointment\AppointmentStatus;
use App\Models\Gender;
use App\Models\Payment\PaymentMethod;
use App\Models\Payment\PaymentStatus;
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

    public function getPaymentMethods(): JsonResponse
    {
        try {
            $paymentMethods = PaymentMethod::orderBy('definition')->get();
            return ResponseService::success($paymentMethods, 'Success');
        } catch (Exception $e) {
            Log::error('Payment Methods are not fetched.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching payment methods.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


        public function getPaymentStatuses(): JsonResponse
    {
        try {
            $paymentStatuses = PaymentStatus::orderBy('definition')->get();
            return ResponseService::success($paymentStatuses, 'Success');
        } catch (Exception $e) {
            Log::error('Payment Statuses are not fetched.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching payment statuses.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAppointmentStatuses(): JsonResponse
    {
        try {
            $appointmentStatuses = AppointmentStatus::orderBy('definition')->get();
            return ResponseService::success($appointmentStatuses, 'Success');
        } catch (Exception $e) {
            Log::error('Appointment Statuses are not fetched.Error: ' . $e->getMessage());
            return ResponseService::fail('Something went wrong while fetching appointment statuses.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
