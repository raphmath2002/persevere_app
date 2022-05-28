<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{DayController,BillUserController,LoginController,HorsePensionController,HorseOptionController,AdvertisementUserController,FacilitiesImageController,DayFacilityController,ExceptionController,ExceptionFacilityController,AppointmentHorseController,FacilityHorseController,AdvertisementController,BillController,HorseController,JobController,UserController,PensionController,ProfessionalController,AppointmentController,OptionController,FacilityController,TicketController,MessageController,RoleController};


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Routes for login
Route::middleware('cors')->post('/login', [LoginController::class, 'login'])->name('login');
Route::middleware('cors')->post('/login/verifCode', [LoginController::class, 'verifCode'])->name('verif');

Route::middleware(['cors'])->group(function () {
    // Routes for advertisements
    Route::middleware('auth:api')->get('/advertisements', [AdvertisementController::class, 'index']); 
    Route::middleware('auth:api')->post('/advertisements/store', [AdvertisementController::class, 'store']);
    Route::middleware('auth:api')->get('/advertisements/{advertisement}/edit', [AdvertisementController::class, 'edit']); 
    Route::middleware('auth:api')->put('/advertisements/{advertisement}/update', [AdvertisementController::class, 'update']);
    Route::middleware('auth:api')->delete('/advertisements/{advertisement}/destroy', [AdvertisementController::class, 'destroy']); 

    // Routes for appointments
    Route::middleware('auth:api')->get('/appointments', [AppointmentController::class, 'index']);
    Route::middleware('auth:api')->post('/appointments/store', [AppointmentController::class, 'store']);
    Route::middleware('auth:api')->get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit']);
    Route::middleware('auth:api')->put('/appointments/{appointment}/update', [AppointmentController::class, 'update']);
    Route::middleware('auth:api')->post('/appointments/{appointment}/destroy', [AppointmentController::class, 'destroy']);

    // Routes for appointment horse
    Route::middleware('auth:api')->get('/bookings/user/{horse}', [AppointmentHorseController::class, 'getBookingsByUser']);

    Route::middleware('auth:api')->post('/appointmentHorse/{appointment}/{horse}/store', [AppointmentHorseController::class, 'store']);
    Route::middleware('auth:api')->put('/appointmentHorse/{appointmentHorse}/accept', [AppointmentHorseController::class, 'accept']);
    Route::middleware('auth:api')->put('/appointmentHorse/{appointmentHorse}/refuse', [AppointmentHorseController::class, 'refuse']);
    Route::middleware('auth:api')->put('/appointmentHorse/{appointmentHorse}/cancel', [AppointmentHorseController::class, 'cancel']);
    Route::middleware('auth:api')->put('/appointmentHorse/{appointmentHorse}/close', [AppointmentHorseController::class, 'close']);

    Route::middleware('auth:api')->get('/appointments/{appointment}/freeSchedules', [AppointmentHorseController::class, 'getFreeSchedules']);


    // Routes for bills
    Route::middleware('auth:api')->get('/bills', [BillController::class, 'index']); 
    Route::middleware('auth:api')->post('/bills/{user}/store', [BillController::class, 'store']);
    Route::middleware('auth:api')->delete('/bills/{bill}/destroy', [BillController::class, 'destroy']); 

    // Routes for bill user
    Route::middleware('auth:api')->get('/billUser/{user}/index', [BillUserController::class, 'index']); 

    // Routes for facilities
    Route::middleware('auth:api')->get('/facilities', [FacilityController::class, 'index']); 
    Route::middleware('auth:api')->post('/facilities/store', [FacilityController::class, 'store']);
    Route::middleware('auth:api')->get('/facilities/{facility}/edit', [FacilityController::class, 'edit']);
    Route::middleware('auth:api')->put('/facilities/{facility}/update', [FacilityController::class, 'update']);
    Route::middleware('auth:api')->delete('/facilities/{facility}/destroy', [FacilityController::class, 'destroy']);

    // Routes for facility horse
    Route::middleware('auth:api')->post('/facilityHorse/{facility}/{horse}/store', [FacilityHorseController::class, 'store']);
    Route::middleware('auth:api')->put('/facilityHorse/{facilityHorse}/cancel', [FacilityHorseController::class, 'cancel']);
    Route::middleware('auth:api')->put('/facilityHorse/{facilityHorse}/decline', [FacilityHorseController::class, 'decline']);


    // Routes for day facility
    Route::middleware('auth:api')->post('/dayFacility/{day}/{facility}/store', [DayFacilityController::class, 'store']);
    Route::middleware('auth:api')->delete('/dayFacility/{dayFacility}/destroy', [DayFacilityController::class, 'destroy']);

    // Routes for facilities images
    Route::middleware('auth:api')->post('/facilitiesImage/{facility}/store', [FacilitiesImageController::class, 'store']);
    Route::middleware('auth:api')->delete('/facilitiesImage/{facilitiesImage}/destroy', [FacilitiesImageController::class, 'destroy']);

    // Routes for horses
    Route::middleware('auth:api')->get('/horses', [HorseController::class, 'index']);
    Route::middleware('auth:api')->post('/horses/store', [HorseController::class, 'store']);
    Route::middleware('auth:api')->get('/horses/{horse}/edit', [HorseController::class, 'edit']);
    Route::middleware('auth:api')->put('/horses/{horse}/update', [HorseController::class, 'update']);
    Route::middleware('auth:api')->put('/horses/{horse}/update_photo', [HorseController::class, 'update_photo']);
    Route::middleware('auth:api')->delete('/horses/{horse}/destroy', [HorseController::class, 'destroy']);

    // Routes for messages
    Route::middleware('auth:api')->get('/messages', [MessageController::class, 'index']);
    Route::middleware('auth:api')->post('/messages/store', [MessageController::class, 'store']);
    Route::middleware('auth:api')->get('/messages/{message}/edit', [MessageController::class, 'edit']);
    Route::middleware('auth:api')->put('/messages/{message}/update', [MessageController::class, 'update']);
    Route::middleware('auth:api')->delete('/messages/{message}/destroy', [MessageController::class, 'destroy']);

    // Routes for options
    Route::middleware('auth:api')->get('/options', [OptionController::class, 'index']);
    Route::middleware('auth:api')->post('/options/store', [OptionController::class, 'store']);
    Route::middleware('auth:api')->get('/options/{option}/edit', [OptionController::class, 'edit']);
    Route::middleware('auth:api')->put('/options/{option}/update', [OptionController::class, 'update']);
    Route::middleware('auth:api')->delete('/options/{option}/destroy', [OptionController::class, 'destroy']);

    // Routes for horse option
    Route::middleware('auth:api')->post('/horseOption/{horse}/{option}/subscribe', [HorseOptionController::class, 'subscribe']);
    Route::middleware('auth:api')->put('/horseOption/{horseOption}/unsubscribe', [HorseOptionController::class, 'unsubscribe']);

    // Routs for days
    Route::middleware('auth:api')->get('/days', [DayController::class, 'index']);

    // Routes for pensions
    Route::middleware('auth:api')->get('/pensions', [PensionController::class, 'index']);
    Route::middleware('auth:api')->post('/pensions/store', [PensionController::class, 'store']);
    Route::middleware('auth:api')->get('/pensions/{pension}/edit', [PensionController::class, 'edit']);
    Route::middleware('auth:api')->put('/pensions/{pension}/update', [PensionController::class, 'update']);
    Route::middleware('auth:api')->delete('/pensions/{pension}/destroy', [PensionController::class, 'destroy']);

    // Routes for horse pension
    Route::middleware('auth:api')->post('/horsePension/{horse}/{pension}/subscribe', [HorsePensionController::class, 'subscribe']);
    Route::middleware('auth:api')->put('/horsePension/{horsePension}/unsubscribe', [HorsePensionController::class, 'unsubscribe']);

    // Routes for professionals
    Route::middleware('auth:api')->get('/professionals', [ProfessionalController::class, 'index']);
    Route::middleware('auth:api')->post('/professionals/store', [ProfessionalController::class, 'store']);
    Route::middleware('auth:api')->get('/professionals/{professional}/edit', [ProfessionalController::class, 'edit']);
    Route::middleware('auth:api')->put('/professionals/{professional}/update', [ProfessionalController::class, 'update']);
    Route::middleware('auth:api')->delete('/professionals/{professional}/destroy', [ProfessionalController::class, 'destroy']);

    Route::middleware('auth:api')->get('/professions', [ProfessionalController::class, 'getProfessions']);


    // Routes for tickets
    Route::middleware('auth:api')->get('/tickets', [TicketController::class, 'index']);
    Route::middleware('auth:api')->post('/tickets/store', [TicketController::class, 'store']);
    Route::middleware('auth:api')->get('/tickets/{ticket}/edit', [TicketController::class, 'edit']);
    Route::middleware('auth:api')->put('/tickets/{ticket}/update', [TicketController::class, 'update']);
    Route::middleware('auth:api')->delete('/tickets/{ticket}/destroy', [TicketController::class, 'destroy']);

    // Routes for ticket user
    Route::middleware('auth:api')->get('/tickets/user/{user}', [TicketController::class, 'getTicketByUser']);

    // Routes for users
    Route::middleware('auth:api')->get('/users', [UserController::class, 'index']);
    Route::middleware('auth:api')->post('/users/store', [UserController::class, 'store']);
    Route::middleware('auth:api')->get('/users/{user}/edit', [UserController::class, 'edit']);
    Route::middleware('auth:api')->put('/users/{user}/update', [UserController::class, 'update']);
    Route::middleware('auth:api')->put('/users/{user}/update_photo', [UserController::class, 'update_photo']);
    Route::middleware('auth:api')->put('/users/{user}/update_password', [UserController::class, 'update_password']);
    Route::middleware('auth:api')->delete('/users/{user}/destroy', [UserController::class, 'destroy']);

    // Routes for advertisement user
    Route::middleware('auth:api')->get('/users/{user}/advertisements', [AdvertisementUserController::class, 'index']);
    Route::middleware('auth:api')->get('/users/{user}/advertisements/{advertisement}/read', [AdvertisementUserController::class, 'store']);

    // Routes for exceptions
    Route::middleware('auth:api')->get('/exceptions', [ExceptionController::class, 'index']); 
    Route::middleware('auth:api')->post('/exceptions/{facility}/store', [ExceptionController::class, 'store']);
    Route::middleware('auth:api')->delete('/exceptions/{exception}/destroy', [ExceptionController::class, 'destroy']);

    // Routes for exception facility
    Route::middleware('auth:api')->post('/exceptionFacility/{exception}/{facility}/store', [ExceptionFacilityController::class, 'store']);
    Route::middleware('auth:api')->delete('/exceptionFacility/{exceptionFacility}/destroy', [ExceptionFacilityController::class, 'destroy']);
});
