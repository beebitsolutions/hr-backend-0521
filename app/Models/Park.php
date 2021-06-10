<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property mixed id
 * @mixin IdeHelperPark
 */
class Park extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * @return BelongsToMany
     */
    public function dogs(): BelongsToMany
    {
        return $this->belongsToMany(Dog::class)
            ->withPivot('leave')
            ->where('leave','=',0)
            ->withTimestamps();
    }

    /**
     * @return Collection
     */
    public function getDogsWithOwner(): Collection
    {
        return $this->dogs()
            ->with('owner')
            ->get();
    }

    /**
     * @return Collection|\Illuminate\Support\Collection
     */
    public function getOwnersWithDogs()
    {
        $dogsByOwner = $this->getDogsWithOwner()->groupBy('owner_id');

        return $dogsByOwner->map(function ($dogs) {
            $owner = $dogs->last()->owner->toArray();
            foreach ($dogs as $dog) {
                unset($dog['owner']);
                $owner['dogs'][] = $dog;
            }

            return $owner;
        })->values();
    }
}
