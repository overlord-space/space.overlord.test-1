<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Exceptions\AdvertisementException;
use App\Facades\AdvertisementCleanerFacade;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Throwable as Throwable;

class AdvertisementsDeleteOldCommand extends Command
{
    protected $signature = 'advertisements:delete-old {--D|date= : Date to delete advertisements}}';

    protected $description = 'Delete old advertisements';

    public function handle(): void
    {
        $date = $this->getDate();

        $this->log('Start deleting old advertisements, less than ' . $date->toDateString());

        try {
            $deletedCount = AdvertisementCleanerFacade::cleanOldAdvertisements($date);

            $this->log('Deleted ' . $deletedCount . ' advertisements');
        } catch (AdvertisementException $e) {
            $this->log($e->getMessage(), 'error');
        }
    }

    protected function getDate(): Carbon
    {
        $inputDate = $this->option('date');

        try {
            return Carbon::parse($inputDate);
        } catch (Throwable) {
            return Carbon::now()->subWeek()->setTime(0, 0);
        }
    }

    protected function log(string $message, string $type = 'info'): void
    {
        $method = match ($type) {
            'error' => 'error',
            default => 'info',
        };

        $this->{$method}($message);
        Log::{$method}('[AdvertisementCleaner] ' . $message);
    }
}
