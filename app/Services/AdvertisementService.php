<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\AdvertisementException;
use App\Http\Resources\AdvertisementResource;
use App\Models\Advertisement;
use App\Models\Scopes\ActiveScope;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

class AdvertisementService
{
    protected array $requestData;
    protected Advertisement $advertisement;

    public function index(): AnonymousResourceCollection
    {
        return AdvertisementResource::collection(
            Advertisement::query()
                ->withGlobalScope('active', new ActiveScope())
                ->paginate()
        );
    }

    public function show(): AdvertisementResource
    {
        return new AdvertisementResource($this->getAdvertisement());
    }

    /**
     * @throws AdvertisementException
     */
    public function store(): static
    {
        $advertisement = new Advertisement($this->getRequestData());

        try {
            $advertisement->saveOrFail();
            $this->setAdvertisement($advertisement);
        } catch (Throwable $e) {
            throw new AdvertisementException('Failed to create advertisement', 500, $e);
        }

        return $this;
    }

    /**
     * @throws AdvertisementException
     */
    public function activate(): static
    {
        $this->advertisement->active = true;

        try {
            $this->advertisement->saveQuietly();
        } catch (Throwable $e) {
            throw new AdvertisementException('Failed to activate advertisement', 500, $e);
        }

        return $this;
    }

    /**
     * @throws AdvertisementException
     */
    public function update(): static
    {
        $this->advertisement->fill($this->getRequestData());

        try {
            $this->advertisement->saveOrFail();
        } catch (Throwable $e) {
            throw new AdvertisementException('Failed to update advertisement', 500, $e);
        }

        return $this;
    }

    /**
     * @throws AdvertisementException
     */
    public function destroy(): static
    {
        try {
            $this->advertisement->deleteOrFail();
        } catch (Throwable $e) {
            throw new AdvertisementException('Failed to delete advertisement', 500, $e);
        }

        return $this;
    }

    public function setAdvertisement(Advertisement $advertisement): static
    {
        $this->advertisement = $advertisement;
        return $this;
    }

    public function getAdvertisement(): Advertisement
    {
        return $this->advertisement->loadMissing('bids');
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
