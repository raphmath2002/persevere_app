<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Bill};
use App\Http\Resources\{BillResource};
use Illuminate\Support\Facades\Hash;

class BillController extends Controller
{
    /**
     * Show bills.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $bills = Bill::all();
        return response()->json(BillResource::collection($bills));
    }
}
