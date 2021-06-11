<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Park;
use App\Models\Dog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ParkController extends BaseController
{

    public function __construct()
    {
        $this->main_model = new Park();
        parent::__construct($this->main_model);
    }

    public function addOwnerWithDogs(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $validator = \Validator::make($data, [
            'id_owner' => 'required',
            'id_park' => 'required',
        ]);

        $response = [
            'code' => 400,
            'message' => 'Error adding owner with dogs to park'
        ];

        if (!$validator->fails()) {
            $park = Park::find($data['id_park']);
            $owner = Owner::find($data['id_owner']);
            $dogs = $owner->dogs;
            if (is_object($park) && count($dogs) > 0) {
                foreach ($dogs as $dog) {
                    $park->dogs()->attach($dog->id);
                }
                $response = [
                    'code' => 200,
                    'message' => 'Owner with dogs added to park',
                    'owner' => $owner
                ];
            } else {
                $response = [
                    'code' => 400,
                    'message' => 'Owner has no dogs'
                ];
            }

        }
        return response()->json($response, $response['code']);
    }

    public function listOwnersWithDogs(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $parks = empty($data['id_park']) ? Park::all() : [Park::find($data['id_park'])];
        $response = [];

        foreach ($parks as $park) {
            if (Cache::has($park->id . '_owners') && Cache::has($park->id . '_dogs')) {
                $response[] = ["park" => $park->id, "owners" => Cache::get($park->id . '_owners'), "dogs" => Cache::get($park->id . '_dogs')];
            } else {
                $all_dogs_in_park = $park->dogs;
                $dogsInPark = collect($all_dogs_in_park)->unique();
                $ownersInPark = [];
                foreach ($all_dogs_in_park as $dog) {
                    $owner = $dog->owner;
                    if (!in_array($owner, $ownersInPark)) {
                        $ownersInPark[] = $owner;
                    }
                }
                Cache::put($park->id . '_owners', $ownersInPark);
                Cache::put($park->id . '_dogs', $dogsInPark);
                $response[] = [ "park" => $park->id, "owners" => $ownersInPark, "dogs" => $dogsInPark];
            }
        }

        if (empty($response)) {
            $response = ["code" => 400, "message" => "Parks not founded", "parks" => $parks];
        }

        return response()->json($response);
    }

    /**
     * Esta función echa a los propietarios de perros a irse del parque cuando ha pasado más de una hora.
     */
    public function forceOwnersLeave()
    {
        $parks = Park::all();
        $all_parks_empty = false;
        foreach ($parks as $park) {
            $park->dogs()->detach(Dog::all());
            $all_parks_empty = count($park->dogs) == 0;
        }

        if ($all_parks_empty) {
            $response = [
                'code' => 200,
                'message' => 'Todos han abandonado los parques'
            ];
        } else {
            $response = [
                'code' => 400,
                'message' => 'Error al desalojar los parques'
            ];
        }


        return response()->json($response, $response['code']);
    }

    public function create(Request $request): Park
    {
        $request->validate([
            'name' => 'required'
        ]);

        return parent::create($request);
    }
}
