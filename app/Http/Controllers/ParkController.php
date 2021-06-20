<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\Owner;
use App\Models\Park;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ParkController extends BaseController
{
    public function addOwnerWithDogs(Request $request)
    {
        $request->validate([
            'park_id' => 'required',
            'dog_id' => 'required'
        ]);

        $parkID = $request->input('park_id');
        $dogID = $request->input('dog_id');

        $park = Park::find($parkID);
        $dog = Dog::find($dogID);
        if($park !== null && $dog !== null){
            $park->dogs()->attach($dogID);
            $response = 'Owner added correctly';
        }else{
            $response = 'Error';
        }

        return response()->json($response);
    }

    public function listOwnersWithDogs(Request $request, Park $park): JsonResponse
    {
        if(Cache::has($park->id.'_owners') && Cache::has($park->id.'_dogs')) {
            $response = ["owners" => Cache::get($park->id.'_owners'), "dogs" => Cache::get($park->id.'_dogs')];
        } else {

            $ownersInPark = []; //Completar
            $dogsInPark = $park->dogs()->get(); //Completar
            foreach ($dogsInPark as $dog){
                array_push($ownersInPark,$dog->owner);
            }
            Cache::put($park->id.'_owners', $ownersInPark);
            Cache::put($park->id.'_dogs', $dogsInPark);
            $response = ["owners" => $ownersInPark, "dogs" => $dogsInPark];

        }
        return response()->json($response);
    }

    /**
     * Esta función echa a los propietarios de perros a irse del parque cuando ha pasado más de una hora.
     */
    public function forceOwnersLeave()
    {
        $now = new Carbon();
        $allParks = Park::all();
        foreach ($allParks as $park){
            $dogsInPark = $park->dogs()->get();
            foreach ($dogsInPark as $dog){
                $createdAt = $dog->pivot->created_at;
                if($now->diffInHours($createdAt) > 1){
                    $park->dogs()->detach($dog->id);
                }
            }
        }
    }

    public function create(Request $request): Park
    {
        $request->validate([
            'name' => 'required'
        ]);

        $park = new Park();
        $park->name = $request->input('name');
        $park->save();

        return $park;
    }

    public function list() {
        $owner = new Park();
        return $this->_list($owner);
    }

    public function index(Request $request)
    {
        return Park::all();
    }
}
