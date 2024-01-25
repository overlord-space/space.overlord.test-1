<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Exceptions\UserRepositoryException;
use App\Facades\UserRepositoryFacade;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @property int $user_id
 * @property-read ?User $user
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

    public function user(): Attribute
    {
        return Attribute::get(function () {
            try {
                return UserRepositoryFacade::getById($this->user_id);
            } catch (UserRepositoryException) {
                return null;
            }
        });
    }
}
