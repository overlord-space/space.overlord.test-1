<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\BidException;
use App\Models\Advertisement;
use App\Models\Bid;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Throwable;

class BidService
{
    protected array $requestData;
    protected Bid $bid;

    public function index(): LengthAwarePaginator
    {
        return Bid::query()
            ->with(['advertisement'])
            ->paginate();
    }

    public function show(): Bid
    {
        return $this->bid->loadMissing('user', 'advertisement');
    }

    /**
     * @throws BidException
     */
    public function store(): static
    {
        $bid = new Bid($this->getRequestData());

        /** @var Advertisement $advertisement */
        $advertisement = Advertisement::query()->find($this->getRequestData()['advertisement_id']);

        if ($advertisement->active === false) {
            throw new BidException('This advertisement is not active.', 403);
        }
        $bid->advertisement()->associate($advertisement);

        try {
            $bid->saveOrFail();
        } catch (Throwable $e) {
            throw new BidException('Failed to create bid', 500, $e);
        }

        return $this;
    }

    public function setRequestData(array $requestData): static
    {
        $this->requestData = $requestData;
        return $this;
    }

    public function getRequestData(): array
    {
        return $this->requestData;
    }
}
