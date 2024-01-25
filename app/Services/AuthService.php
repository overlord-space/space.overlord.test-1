<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\AuthException;
use App\Exceptions\UserRepositoryException;
use App\Facades\UserRepositoryFacade;

class AuthService
{
    protected array $requestData;

    /**
     * @throws AuthException
     */
    public function login(): string
    {
        try {
            $user = UserRepositoryFacade::getByEmail($this->requestData['email']);
        } catch (UserRepositoryException $e) {
            throw new AuthException($e->getMessage(), 401, $e);
        }

        if ($user->password !== $this->requestData['password']) {
            throw new AuthException('Invalid password', 401);
        }

        return $user->createToken('api-token')->plainTextToken;
    }

    public function setRequestData(array $requestData): AuthService
    {
        $this->requestData = $requestData;
        return $this;
    }

    public function getRequestData(): array
    {
        return $this->requestData;
    }
}
