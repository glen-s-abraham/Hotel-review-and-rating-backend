<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('logout');
    }
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->errorResponse('Invalid login details', 401);
        }
        $token = User::where('email', $request['email'])
            ->firstOrFail()
            ->createToken('auth_token')
            ->plainTextToken;
        return $this->successResponse(['access_token' => $token], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->successResponse('Logged Out Successfully', 200);
    }
}
