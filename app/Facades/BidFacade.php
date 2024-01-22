<?php

declare(strict_types=1);

namespace App\Facades;

use App\Services\BidService;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin BidService
 * @see \App\Providers\DomainServiceProvider
 */
class BidFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'bid';
    }
}
