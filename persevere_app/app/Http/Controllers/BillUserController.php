<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{BillUser,User,Bill};
use App\Http\Resources\{BillResource};
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Auth;
use DB;

class BillUserController extends Controller
{
    /**
     * Show bill user.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(User $user)
    {
        $bills = $user->bills;

        return response()->json(["success" => BillResource::collection($bills)]);
    }
}
