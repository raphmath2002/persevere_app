<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Professional};
use App\Http\Resources\{ProfessionalResource};
use Illuminate\Support\Facades\Hash;

class ProfessionalController extends Controller
{
    /**
     * Show professionals.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $professionals = Professional::all();
        return response()->json(ProfessionalResource::collection($professionals));
    }
}
