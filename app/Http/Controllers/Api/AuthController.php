<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Exceptions\AuthException;
use App\Facades\AuthFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            return response()->json([
                'token' => AuthFacade::setRequestData($request->validated())->login(),
                'message' => 'Successfully logged in',
            ], 201);
        } catch (AuthException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
