<?php

declare(strict_types=1);

namespace App\Http\Requests\Advertisement;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdvertisementRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
        ];
    }
}
