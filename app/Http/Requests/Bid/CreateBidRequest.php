<?php

declare(strict_types=1);

namespace App\Http\Requests\Bid;

use App\Models\Advertisement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateBidRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'advertisement_id' => [
                'required', 'int',
                Rule::exists(Advertisement::class, 'id'),
            ],
        ];
    }
}
