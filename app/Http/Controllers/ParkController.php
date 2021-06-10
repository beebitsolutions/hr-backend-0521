<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\DogPark;
use App\Models\Owner;
use App\Models\Park;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ParkController extends Controller
{
    /**
     * @param Request $request
     */
    public function addOwnerWithDogs(Request $request): void
    {
        $request->validate([
            'park_id' => 'exists:parks,id|required',
            'owner_id' => 'exists:owners,id|required',
            'dogs' => 'array',
            'dogs.*' => 'exists:dogs,id|integer',
        ]);

        $parkId = $request->park_id;
        $ownerId = $request->owner_id;
        $dogsId = $request->dogs;

        if (isset($dogsId) && !empty($dogsId)) {
            $ownerDogsIds = Dog::filterOwner($dogsId, $ownerId)->get()->pluck('id');
        } else {
            $owner = Owner::findOrFail($ownerId);
            $ownerDogsIds = $owner->dogs->pluck('id');
        }

        foreach ($ownerDogsIds as $dogId) {
            DogPark::firstOrCreate([
                'dog_id' => $dogId,
                'park_id' => $parkId,
                'leave' => 0
            ]);
            Cache::forget($parkId.'_owners');
        }
    }

    /**
     * @param Park $park
     * @return JsonResponse
     */
    public function listOwnersWithDogs(Park $park): JsonResponse
    {
        if (Cache::has($park->id.'_owners') ) {
            $ownersWithDog = Cache::get($park->id.'_owners');
        } else {
            $ownersWithDog = $park->getOwnersWithDogs();
            Cache::put($park->id.'_owners', $ownersWithDog);
        }

        $response = [
            "owners" => $ownersWithDog,
        ];

        return response()->json($response);
    }

    public function forceOwnersLeave(): void
    {
        $dateNow = Carbon::now();
        echo "Date: " . $dateNow->format("Y-m-d H:i:s") . PHP_EOL;
        $date = $dateNow->modify('-1 hour')->format("Y-m-d H:i:59");
        $park = DogPark::endsInDate($date)->get();
        $park->map(function ($item) {
            echo "Park: {$item->park_id} - Dog: {$item->dog_id} leave" . PHP_EOL;
            $item->leave();
        });
    }

    /**
     * @param Request $request
     * @return Park
     */
    public function create(Request $request): Park
    {
        $request->validate([
            'name' => 'required'
        ]);

        return Park::create([
            'name' => $request->name
        ]);
    }

    /**
     * @return Park[]|Collection
     */
    public function index()
    {
        return Park::all();
    }
}
