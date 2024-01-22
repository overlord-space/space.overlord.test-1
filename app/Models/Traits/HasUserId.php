<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * @property int $user_id
 * @property-read User $user
 */
trait HasUserId
{
    public static function bootHasUserId(): void
    {
        static::creating(function (Model $model) {
            /** @noinspection PhpUndefinedFieldInspection */
            $model->user_id = Auth::id();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
