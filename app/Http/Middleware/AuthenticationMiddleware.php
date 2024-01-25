<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Exceptions\AuthException;
use App\Exceptions\UserRepositoryException;
use App\Facades\UserRepositoryFacade;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthenticationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = $this->getUserByToken($request->bearerToken());
        } catch (AuthException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        Auth::setUser($user);

        return $next($request);
    }

    /**
     * @throws AuthException
     */
    protected function getUserByToken(?string $token): User
    {
        if (is_null($token)) {
            throw new AuthException('Bearer token not provided', 403);
        }

        $personalToken = PersonalAccessToken::findToken($token);

        if (is_null($personalToken)) {
            throw new AuthException('Invalid token', 403);
        }

        /** @noinspection PhpUndefinedFieldInspection */
        if ($personalToken->tokenable_type !== User::class) {
            throw new AuthException('Invalid token', 403);
        }

        try {
            /** @noinspection PhpUndefinedFieldInspection */
            return UserRepositoryFacade::getById($personalToken->tokenable_id);
        } catch (UserRepositoryException) {
            throw new AuthException('User not found', 403);
        }
    }
}
