<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Appointement};
use App\Http\Resources\{AppointementResource};
use Illuminate\Support\Facades\Hash;

class AppointementController extends Controller
{
    /**
     * Show appointements.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $appointements = Appointement::all();
        return response()->json(AppointementResource::collection($appointements));
    }
}
