<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Advertisement;
use App\Models\Bid;
use App\Policies\AdvertisementPolicy;
use App\Policies\BidPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
        Advertisement::class => AdvertisementPolicy::class,
        Bid::class => BidPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
