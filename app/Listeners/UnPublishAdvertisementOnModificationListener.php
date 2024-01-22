<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\AdvertisementCreatingOrUpdatingEvent;

class UnPublishAdvertisementOnModificationListener
{
    public function handle(AdvertisementCreatingOrUpdatingEvent $event): void
    {
        if ($event->advertisement->active !== false) {
            $event->advertisement->active = false;
        }
    }
}
