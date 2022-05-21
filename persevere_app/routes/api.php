<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HorseController,JobController,UserController,PensionController,VisitController,OptionController,FacilityController,TicketController,MessageController,RoleController};

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

// Routes for horses
Route::get('/horses', [HorseController::class, 'index']); // OK
Route::post('/horses/store', [HorseController::class, 'store']); // OK without image
Route::get('/horses/{horse}/edit', [HorseController::class, 'edit']); // OK
Route::put('/horses/{horse}/update', [HorseController::class, 'update']); // OK without image
Route::delete('/horses/{horse}/destroy', [HorseController::class, 'destroy']); // OK

// Routes for jobs
Route::get('/jobs', [JobController::class, 'index']); // OK
Route::post('/jobs/store', [JobController::class, 'store']); // OK
Route::get('/jobs/{job}/edit', [JobController::class, 'edit']); // OK
Route::put('/jobs/{job}/update', [JobController::class, 'update']); // OK
Route::delete('/jobs/{job}/destroy', [JobController::class, 'destroy']); // OK

// Routes for users
Route::get('/users', [UserController::class, 'index']); // OK
Route::post('/users/store', [UserController::class, 'store']);
Route::get('/users/{user}/edit', [UserController::class, 'edit']);
Route::put('/users/{user}/update', [UserController::class, 'update']);
Route::delete('/users/{user}/destroy', [UserController::class, 'destroy']); // OK

// Routes for pensions
Route::get('/pensions', [PensionController::class, 'index']); // OK
Route::post('/pensions/store', [PensionController::class, 'store']); // OK
Route::get('/pensions/{pension}/edit', [PensionController::class, 'edit']); // OK
Route::put('/pensions/{pension}/update', [PensionController::class, 'update']); // OK
Route::delete('/pensions/{pension}/destroy', [PensionController::class, 'destroy']); // OK

// Routes for visits
Route::get('/visits', [VisitController::class, 'index']);
Route::post('/visits/store', [VisitController::class, 'store']);
Route::get('/visits/{visit}/edit', [VisitController::class, 'edit']);
Route::put('/visits/{visit}/update', [VisitController::class, 'update']);
Route::delete('/visits/{visit}/destroy', [VisitController::class, 'destroy']);

// Routes for options
Route::get('/options', [OptionController::class, 'index']); // OK
Route::post('/options/store', [OptionController::class, 'store']); // OK
Route::get('/options/{option}/edit', [OptionController::class, 'edit']); // OK
Route::put('/options/{option}/update', [OptionController::class, 'update']); // OK
Route::delete('/options/{option}/destroy', [OptionController::class, 'destroy']); // OK

// Routes for facilities
Route::get('/facilities', [FacilityController::class, 'index']); // OK 
Route::post('/facilities/store', [FacilityController::class, 'store']); // OK
Route::get('/facilities/{facility}/edit', [FacilityController::class, 'edit']); // OK
Route::put('/facilities/{facility}/update', [FacilityController::class, 'update']); // OK
Route::delete('/facilities/{facility}/destroy', [FacilityController::class, 'destroy']); // OK

// Routes for tickets
Route::get('/tickets', [TicketController::class, 'index']); // OK
Route::post('/tickets/store', [TicketController::class, 'store']); // Auth missing
Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit']); // OK
Route::put('/tickets/{ticket}/update', [TicketController::class, 'update']); // OK
Route::delete('/tickets/{ticket}/destroy', [TicketController::class, 'destroy']); // OK

// Routes for messages
Route::get('/messages', [MessageController::class, 'index']); // OK
Route::post('/messages/store', [MessageController::class, 'store']); // Auth missing
Route::get('/messages/{message}/edit', [MessageController::class, 'edit']); // OK
Route::put('/messages/{message}/update', [MessageController::class, 'update']); // OK
Route::delete('/messages/{message}/destroy', [MessageController::class, 'destroy']); // OK

// Routes for roles
Route::get('/roles', [RoleController::class, 'index']); // OK
