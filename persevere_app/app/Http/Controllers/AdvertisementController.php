<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Advertisement};
use App\Http\Resources\{AdvertisementResource};
use Illuminate\Support\Facades\Hash;

class AdvertisementController extends Controller
{
    /**
     * Show advertisements.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $advertisements = Advertisement::all();
        return response()->json(AdvertisementResource::collection($advertisements));
    }
}
