<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    public function getMe()
    {
        return response()->json(Auth::user());
    }

    public function channels()
    {
        return response()->json(Auth::user()->channels()->latest()->get());
    }

    public function subscriptions()
    {
        return response()->json(Auth::user()->subscriptions()->with('channels')->get());
    }
}
