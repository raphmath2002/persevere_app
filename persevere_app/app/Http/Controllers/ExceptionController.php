<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Exception};
use App\Http\Resources\{ExceptionResource};
use Illuminate\Support\Facades\Hash;

class ExceptionController extends Controller
{
    /**
     * Show exceptions.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $exceptions = Exception::all();
        return response()->json(ExceptionResource::collection($exceptions));
    }
}
