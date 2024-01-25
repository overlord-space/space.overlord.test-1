<?php

declare(strict_types=1);

namespace App\Facades;

use App\Services\AuthService;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin AuthService
 * @see \App\Providers\DomainServiceProvider
 */
class AuthFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'auth_service';
    }
}
