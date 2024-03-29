<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\UserRepository;
use App\Services\AdvertisementCleanerService;
use App\Services\AdvertisementService;
use App\Services\AuthService;
use App\Services\BidService;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        /** Services */
        $this->app->bind('advertisement_service', AdvertisementService::class);
        $this->app->bind('bid_service', BidService::class);
        $this->app->bind('advertisement_cleaner_service', AdvertisementCleanerService::class);
        $this->app->bind('auth_service', AuthService::class);

        /** Repositories */
        $this->app->bind('user_repository', UserRepository::class);
    }
}
