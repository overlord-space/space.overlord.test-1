<?php

declare(strict_types=1);

namespace App\Facades;

use App\Services\AdvertisementService;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin AdvertisementService
 * @see \App\Providers\DomainServiceProvider
 */
class AdvertisementFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'advertisement';
    }
}
