<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller {
    public function auth(Request $request) {
        return response()->json($request->user(), 200);
    }
}
