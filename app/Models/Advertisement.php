<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasUserId;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 *
 * @property string $title
 * @property bool $active
 *
 * @property-read EloquentCollection<Bid> $bids
 *
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read ?Carbon $deleted_at
 */
class Advertisement extends Model
{
    use SoftDeletes, HasUserId;

    protected $fillable = [
        'user_id',
        'title',
        'active',
    ];

    protected $with = [
        'user',
    ];

    protected $casts = [
        'active' => 'bool',
    ];

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }
}
