<?php

declare(strict_types=1);

namespace App\Facades;

use App\Services\AdvertisementCleanerService;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin AdvertisementCleanerService
 * @see \App\Providers\DomainServiceProvider
 */
class AdvertisementCleanerFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'advertisement_cleaner_service';
    }
}
