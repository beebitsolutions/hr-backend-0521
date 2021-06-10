<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed name
 * @mixin IdeHelperDog
 * @method static filterOwner($dogsId, $ownerId)
 */
class Dog extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_id',
    ];

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    /**
     * @param Builder $query
     * @param array $dogsId
     * @param int $ownerId
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeFilterOwner(Builder $query, array $dogsId, int $ownerId)
    {
        return $query->whereIn('id', array_unique($dogsId))
            ->where('owner_id', $ownerId);
    }
}
