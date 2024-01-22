<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasUserId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 *
 * @property int $advertisement_id
 * @property-read Advertisement $advertisement
 *
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class Bid extends Model
{
    use HasUserId;

    protected $fillable = [
        'user_id',
        'advertisement_id',
    ];

    protected $with = [
        'user',
    ];

    public function advertisement(): BelongsTo
    {
        return $this->belongsTo(Advertisement::class)
            ->withTrashed();
    }
}
