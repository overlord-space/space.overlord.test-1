<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\AdvertisementException;
use App\Models\Advertisement;
use Illuminate\Support\Carbon;
use Throwable;

class AdvertisementCleanerService
{
    /**
     * @return int rows deleted
     * @throws AdvertisementException
     */
    public function cleanOldAdvertisements(Carbon $actualDate): int
    {
        try {
            return Advertisement::query()
                ->whereDoesntHave('bids')
                ->whereDate('created_at', '<', $actualDate)
                ->delete();
        } catch (Throwable $e) {
            throw new AdvertisementException($e->getMessage(), 500, $e);
        }
    }
}
