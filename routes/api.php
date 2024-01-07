<?php

use App\Http\Controllers\Appointment\AppointmentController;
use App\Http\Controllers\Appointment\AppointmentTypeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\Treatment\TreatmentController;
use App\Http\Controllers\Treatment\TreatmentTypeController;
use App\Http\Controllers\UserController;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * @URL: {{URL}}/api/v1/auth/*
 * @DESCRIPTION: Auth related routes
 */
Route::group(['prefix' => 'auth'], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::post('logout', 'logout');
            Route::get('me', 'me');
        });
    });
});


//------------------ Authenticated Routes ------------------//

Route::group(['middleware' => 'auth:sanctum'], function () {

    /**
     * @URL: {{URL}}/api/v1/*
     * @DESCRIPTION: Resource related routes for authenticated users
     */
    Route::controller(ResourceController::class)->group(function () {
        Route::get('genders', 'getGenders');
        Route::get('roles', 'getRoles');
        Route::get('user-types', 'getUserTypes');
        Route::get('payment-methods', 'getPaymentMethods');
        Route::get('appointment-statuses', 'getAppointmentStatuses');
        Route::get('payment-statuses', 'getPaymentStatuses');
    });


    //-------------------------------------------------------------------------------------------

    /**
     * @URL: {{URL}}/api/v1/users*
     * @DESCRIPTION: User related routes for managing system users
     */
    Route::group(['prefix' => '/users'], function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/', 'getUsers');
            Route::get('/{id}', 'getUser');
            Route::post('/create', 'createUser');
            Route::put('/update/{id}', 'updateUser');
            Route::delete('/delete/{id}', 'deleteUser');
        });
    });

    //---------------------------------------------------------------------------------------------

    /**
     * @URL: {{URL}}/api/v1/patients/*
     * @DESCRIPTION: Patient related routes for managing system patients
     */
    Route::group(['prefix' => '/patients'], function () {
        Route::controller(PatientController::class)->group(function () {
            Route::get('/', 'getPatients');
            Route::get('/{id}', 'getPatient');
            Route::post('/create', 'createPatient');
            Route::put('update/{id}', 'updatePatient');
            Route::delete('delete/{id}', 'deletePatient');
        });
    });


    //---------------------------------------------------------------------------------------------

    /**
     * @URL: {{URL}}/api/v1/appointments/*
     * @DESCRIPTION: Appointment related routes for managing system appointments
     */
    Route::group(['prefix' => '/appointments'], function () {
        Route::controller(AppointmentController::class)->group(function () {
            Route::get('/', 'getAppointments');
            Route::get('/{id}', 'getAppointment');
            Route::post('/create', 'createAppointment');
            Route::put('update/{id}', 'updateAppointment');
            Route::delete('delete/{id}', 'deleteAppointment');
        });

        /**
         * @URL: {{URL}}/api/v1/appointments/types/*
         */
        Route::group(['prefix' => '/types'], function () {
            Route::controller(AppointmentTypeController::class)->group(function () {
                Route::get('/', 'getAppointmentTypes');
                Route::get('/{id}', 'getAppointmentType');
                Route::post('/create', 'createAppointmentType');
                Route::put('/update/{id}', 'updateAppointmentType');
                Route::delete('delete/{id}', 'deleteAppointmentType');
            });
        });
    });


    //---------------------------------------------------------------------------------------------

    /**
     * @URL: {{URL}}/api/v1/treatments/*
     * @DESCRIPTION: Treatment related routes for managing system treatments
     */
    Route::group(['prefix' => '/treatments'], function () {
        Route::controller(TreatmentController::class)->group(function () {
            Route::get('/', 'getTreatments');
            Route::get('/{id}', 'getTreatment');
            Route::post('/create', 'createTreatment');
            Route::put('/update/{id}', 'updateTreatment');
            Route::delete('delete/{id}', 'deleteTreatment');
        });

        /**
         * @URL: {{URL}}/api/v1/treatments/types/*
         */
        Route::group(['prefix' => '/types'], function () {
            Route::controller(TreatmentTypeController::class)->group(function () {
                Route::get('/', 'getTreatmentTypes');
                Route::get('/{id}', 'getTreatmentType');
                Route::post('/create', 'createTreatmentType');
                Route::put('/update/{id}', 'updateTreatmentType');
                Route::delete('delete/{id}', 'deleteTreatmentType');
            });
        });
    });


    //---------------------------------------------------------------------------------------------

    /**
     * @URL: {{URL}}/api/v1/discounts/*
     * @DESCRIPTION: Equipment related routes for managing discounts
     */
    Route::group(['prefix' => '/discounts'], function () {
        Route::controller(DiscountController::class)->group(function () {
            Route::get('/', 'getDiscounts');
            Route::get('/{id}', 'getDiscount');
            Route::post('/create', 'createDiscount');
            Route::put('/update/{id}', 'updateDiscount');
            Route::delete('delete/{id}', 'deleteDiscount');
        });
    });


    //---------------------------------------------------------------------------------------------

    /**
     * @URL: {{URL}}/api/v1/equipments/*
     * @DESCRIPTION: Equipment related routes for managing equipments
     */
    Route::group(['prefix' => '/equipments'], function () {
        Route::controller(EquipmentController::class)->group(function () {
            Route::get('/', 'getEquipments');
            Route::get('/{id}', 'getEquipment');
            Route::post('/create', 'createEquipment');
            Route::put('/update/{id}', 'updateEquipment');
            Route::delete('delete/{id}', 'deleteEquipment');
        });
    });

});


Route::fallback(function () {
    return ResponseService::fail('404 - Service Not Found :(', Response::HTTP_NOT_FOUND);
});

Route::any('/{any}', function () {
    return ResponseService::fail('404 - Service Not Found :(', Response::HTTP_NOT_FOUND);
})->where('any', '.*');
