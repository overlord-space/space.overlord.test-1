<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Advertisement;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdvertisementCreatingOrUpdatingEvent
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly Advertisement $advertisement,
    )
    {
    }
}
