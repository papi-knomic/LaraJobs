<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Traits\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login( LoginRequest $request ) : JsonResponse
    {
        $userData = $request->validated();

        if (Auth::attempt($userData)) {
            $token = config('keys.token');
            $accessToken = Auth::user()->createToken($token)->plainTextToken;
            $data = auth()->user();
            return Response::successResponseWithData($data, 'Login successful', 200, $accessToken);
        }
        return Response::errorResponse('Invalid Login credentials', 400);
    }
}
