<?php

declare(strict_types=1);

namespace App\Observers;

use App\Events\AdvertisementCreatingOrUpdatingEvent;
use App\Models\Advertisement;

class AdvertisementObserver
{
    public function creating(Advertisement $advertisement): void
    {
        event(new AdvertisementCreatingOrUpdatingEvent($advertisement));
    }

    public function updating(Advertisement $advertisement): void
    {
    }
}
