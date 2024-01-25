<?php

declare(strict_types=1);

namespace App\Facades;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin UserRepository
 * @see \App\Providers\DomainServiceProvider
 */
class UserRepositoryFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'user_repository';
    }
}
