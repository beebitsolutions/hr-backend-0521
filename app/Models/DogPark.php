<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method endsInDate(string $date)
 */
class DogPark extends Model
{
    protected $table = 'dog_park';

    protected $fillable = [
        'dog_id',
        'park_id',
        'leave',
    ];

    /**
     * @return BelongsTo
     */
    public function dog(): BelongsTo
    {
        return $this->belongsTo(Dog::class);
    }

    /**
     * @return BelongsTo
     */
    public function park(): BelongsTo
    {
        return $this->belongsTo(Park::class);
    }

    /**
     * @param Builder $query
     * @param $date
     * @return Builder
     */
    public function scopeEndsInDate(Builder $query, $date): Builder
    {
        return $query->where(self::CREATED_AT, '<=', $date)
            ->where('leave',0);
    }

    /**
     * @param Builder $query
     * @param $parkId
     * @return Builder
     */
    public function scopeInPark(Builder $query, $parkId): Builder
    {
        return $query->where('park_id', $parkId)
            ->where('leave',0);
    }

    public function leave(): void
    {
        $this->leave = true;
        $this->save();
    }
}
