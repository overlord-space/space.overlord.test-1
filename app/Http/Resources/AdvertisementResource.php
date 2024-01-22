<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Advertisement */
class AdvertisementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'title' => $this->title,
            'active' => $this->active,

            'user' => new UserResource($this->whenLoaded('user')),

            'bids' => BidResource::collection($this->whenLoaded('bids')),

            'created_at' => $this->created_at->format('d.m.Y H:i'),
            'updated_at' => $this->updated_at->format('d.m.Y H:i'),
        ];
    }
}
