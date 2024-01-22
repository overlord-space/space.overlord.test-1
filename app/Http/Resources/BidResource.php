<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Bid */
class BidResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'user' => new UserResource($this->whenLoaded('user')),
            'advertisement' => new AdvertisementResource($this->whenLoaded('advertisement')),

            'created_at' => $this->created_at->format('d.m.Y H:i:s'),
        ];
    }
}
