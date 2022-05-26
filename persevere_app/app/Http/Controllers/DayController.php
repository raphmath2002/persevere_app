<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Day};
use App\Http\Resources\{DayResource,FacilityResource,DayFacilityResource};
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class DayController extends Controller
{
    public function index()
    {
        $days = Day::all();
        return response()->json(["success" => $days]);
    }
}