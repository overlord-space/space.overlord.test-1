<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\AdvertisementService;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('advertisement', AdvertisementService::class);
    }
}