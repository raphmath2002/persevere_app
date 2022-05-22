<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{LoginController, AdvertisementController,BillController,HorseController,JobController,UserController,PensionController,ProfessionalController,AppointmentController,OptionController,FacilityController,TicketController,MessageController,RoleController};


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

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login/verifCode', [LoginController::class, 'verifCode'])->name('verif');


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
Route::middleware('auth:api')->delete('/appointments/{appointment}/destroy', [AppointmentController::class, 'destroy']);

// Routes for bills
Route::middleware('auth:api')->get('/bills', [BillController::class, 'index']); 
Route::middleware('auth:api')->post('/bills/store', [BillController::class, 'store']);
Route::middleware('auth:api')->get('/bills/{bill}/edit', [BillController::class, 'edit']); 
Route::middleware('auth:api')->put('/bills/{bill}/update', [BillController::class, 'update']);
Route::middleware('auth:api')->delete('/bills/{bill}/destroy', [BillController::class, 'destroy']); 

// Routes for facilities
Route::middleware('auth:api')->get('/facilities', [FacilityController::class, 'index']); 
Route::middleware('auth:api')->post('/facilities/store', [FacilityController::class, 'store']);
Route::middleware('auth:api')->get('/facilities/{facility}/edit', [FacilityController::class, 'edit']);
Route::middleware('auth:api')->put('/facilities/{facility}/update', [FacilityController::class, 'update']);
Route::middleware('auth:api')->delete('/facilities/{facility}/destroy', [FacilityController::class, 'destroy']);

// Routes for horses
Route::middleware('auth:api')->get('/horses', [HorseController::class, 'index']);
Route::middleware('auth:api')->post('/horses/store', [HorseController::class, 'store']);
Route::middleware('auth:api')->get('/horses/{horse}/edit', [HorseController::class, 'edit']);
Route::middleware('auth:api')->put('/horses/{horse}/update', [HorseController::class, 'update']);
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

// Routes for pensions
Route::middleware('auth:api')->get('/pensions', [PensionController::class, 'index']);
Route::middleware('auth:api')->post('/pensions/store', [PensionController::class, 'store']);
Route::middleware('auth:api')->get('/pensions/{pension}/edit', [PensionController::class, 'edit']);
Route::middleware('auth:api')->put('/pensions/{pension}/update', [PensionController::class, 'update']);
Route::middleware('auth:api')->delete('/pensions/{pension}/destroy', [PensionController::class, 'destroy']);

// Routes for professionals
Route::middleware('auth:api')->get('/professionals', [ProfessionalController::class, 'index']);
Route::middleware('auth:api')->post('/professionals/store', [ProfessionalController::class, 'store']);
Route::middleware('auth:api')->get('/professionals/{professional}/edit', [ProfessionalController::class, 'edit']);
Route::middleware('auth:api')->put('/professionals/{professional}/update', [ProfessionalController::class, 'update']);
Route::middleware('auth:api')->delete('/professionals/{professional}/destroy', [ProfessionalController::class, 'destroy']);

// Routes for tickets
Route::middleware('auth:api')->get('/tickets', [TicketController::class, 'index']);
Route::middleware('auth:api')->post('/tickets/store', [TicketController::class, 'store']);
Route::middleware('auth:api')->get('/tickets/{ticket}/edit', [TicketController::class, 'edit']);
Route::middleware('auth:api')->put('/tickets/{ticket}/update', [TicketController::class, 'update']);
Route::middleware('auth:api')->delete('/tickets/{ticket}/destroy', [TicketController::class, 'destroy']);

// Routes for users
Route::middleware('auth:api')->get('/users', [UserController::class, 'index']);
Route::middleware('auth:api')->post('/users/store', [UserController::class, 'store']);
Route::middleware('auth:api')->get('/users/{user}/edit', [UserController::class, 'edit']);
Route::middleware('auth:api')->put('/users/{user}/update', [UserController::class, 'update']);
Route::middleware('auth:api')->put('/users/{user}/update_photo', [UserController::class, 'update_photo']);
Route::middleware('auth:api')->put('/users/{user}/update_password', [UserController::class, 'update_password']);
Route::middleware('auth:api')->delete('/users/{user}/destroy', [UserController::class, 'destroy']);