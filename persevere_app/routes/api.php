<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AdvertisementController,BillController,HorseController,JobController,UserController,PensionController,ProfessionalController,AppointmentController,OptionController,FacilityController,TicketController,MessageController,RoleController};

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

// Routes for advertisements
Route::get('/advertisements', [AdvertisementController::class, 'index']); 
Route::post('/advertisements/store', [AdvertisementController::class, 'store']);
Route::get('/advertisements/{advertisement}/edit', [AdvertisementController::class, 'edit']); 
Route::put('/advertisements/{advertisement}/update', [AdvertisementController::class, 'update']);
Route::delete('/advertisements/{advertisement}/destroy', [AdvertisementController::class, 'destroy']); 

// Routes for appointments
Route::get('/appointments', [AppointmentController::class, 'index']);
Route::post('/appointments/store', [AppointmentController::class, 'store']);
Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit']);
Route::put('/appointments/{appointment}/update', [AppointmentController::class, 'update']);
Route::delete('/appointments/{appointment}/destroy', [AppointmentController::class, 'destroy']);

// Routes for bills
Route::get('/bills', [BillController::class, 'index']); 
Route::post('/bills/store', [BillController::class, 'store']);
Route::get('/bills/{bill}/edit', [BillController::class, 'edit']); 
Route::put('/bills/{bill}/update', [BillController::class, 'update']);
Route::delete('/bills/{bill}/destroy', [BillController::class, 'destroy']); 

// Routes for facilities
Route::get('/facilities', [FacilityController::class, 'index']); 
Route::post('/facilities/store', [FacilityController::class, 'store']);
Route::get('/facilities/{facility}/edit', [FacilityController::class, 'edit']);
Route::put('/facilities/{facility}/update', [FacilityController::class, 'update']);
Route::delete('/facilities/{facility}/destroy', [FacilityController::class, 'destroy']);

// Routes for horses
Route::get('/horses', [HorseController::class, 'index']);
Route::post('/horses/store', [HorseController::class, 'store']);
Route::get('/horses/{horse}/edit', [HorseController::class, 'edit']);
Route::put('/horses/{horse}/update', [HorseController::class, 'update']);
Route::put('/horses/{horse}/update_photo', [HorseController::class, 'update_photo']);
Route::delete('/horses/{horse}/destroy', [HorseController::class, 'destroy']);

// Routes for messages
Route::get('/messages', [MessageController::class, 'index']);
Route::post('/messages/store', [MessageController::class, 'store']);
Route::get('/messages/{message}/edit', [MessageController::class, 'edit']);
Route::put('/messages/{message}/update', [MessageController::class, 'update']);
Route::delete('/messages/{message}/destroy', [MessageController::class, 'destroy']);

// Routes for options
Route::get('/options', [OptionController::class, 'index']);
Route::post('/options/store', [OptionController::class, 'store']);
Route::get('/options/{option}/edit', [OptionController::class, 'edit']);
Route::put('/options/{option}/update', [OptionController::class, 'update']);
Route::delete('/options/{option}/destroy', [OptionController::class, 'destroy']);

// Routes for pensions
Route::get('/pensions', [PensionController::class, 'index']);
Route::post('/pensions/store', [PensionController::class, 'store']);
Route::get('/pensions/{pension}/edit', [PensionController::class, 'edit']);
Route::put('/pensions/{pension}/update', [PensionController::class, 'update']);
Route::delete('/pensions/{pension}/destroy', [PensionController::class, 'destroy']);

// Routes for professionals
Route::get('/professionals', [ProfessionalController::class, 'index']);
Route::post('/professionals/store', [ProfessionalController::class, 'store']);
Route::get('/professionals/{professional}/edit', [ProfessionalController::class, 'edit']);
Route::put('/professionals/{professional}/update', [ProfessionalController::class, 'update']);
Route::delete('/professionals/{professional}/destroy', [ProfessionalController::class, 'destroy']);

// Routes for tickets
Route::get('/tickets', [TicketController::class, 'index']);
Route::post('/tickets/store', [TicketController::class, 'store']);
Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit']);
Route::put('/tickets/{ticket}/update', [TicketController::class, 'update']);
Route::delete('/tickets/{ticket}/destroy', [TicketController::class, 'destroy']);

// Routes for users
Route::get('/users', [UserController::class, 'index']);
Route::post('/users/store', [UserController::class, 'store']);
Route::get('/users/{user}/edit', [UserController::class, 'edit']);
Route::put('/users/{user}/update', [UserController::class, 'update']);
Route::put('/users/{user}/update_photo', [UserController::class, 'update_photo']);
Route::put('/users/{user}/update_password', [UserController::class, 'update_password']);
Route::delete('/users/{user}/destroy', [UserController::class, 'destroy']);
