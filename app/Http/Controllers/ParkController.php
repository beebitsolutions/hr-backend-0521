<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Park;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;
use Carbon\Carbon;
use App\Http\Controllers\BaseController;

class ParkController extends BaseController
{
    protected $tableName = 'parks';

    public function getTableName(){
        return $this->tableName;
    }

    public function addOwnerWithDogs(Request $request)
    {
        $park_id = $request->park_id;
        $owner_id = $request->owner_id;

        try {
            $owner = Owner::findOrFail($owner_id);
            $park = Park::findOrFail($park_id);

            foreach ($owner->dogs as $dog) {
                DB::table('dog_park')->insert([
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                    'dog_id' => $dog->id,
                    'park_id' => $park_id
                ]);
            }

        } catch (ModelNotFoundException) {
            return "Owner or park don't exist";
        }


    }

    public function listOwnersWithDogs(Request $request, Park $park): JsonResponse
    {
        if(Cache::has($park->id.'_owners') && Cache::has($park->id.'_dogs')) {
            $response = ["owners" => Cache::get($park->id.'_owners'), "dogs" => Cache::get($park->id.'_dogs')];
        } else {

            $ownersInPark = []; //Completar
            $dogsInPark = []; //Completar
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
        //No me queda muy claro si tengo que echarlos cada hora aunque lleven 10 minutos
        //Yo he hecho que cada hora eche a los que llevan una hora
        //Lo más exacto aunque poco eficiente sería lanzar esta función cada minuto o cada 5 minutos
        $currentTime = Carbon::now();
        $dogsInPark = DB::table('dog_park')->get();
        foreach ($dogsInPark as $dogPark) {
            if($currentTime->diffInHours($dogPark->created_at) >= 1){
                DB::table('dog_park')->where('dog_id', $dogPark->dog_id)->delete();
            }
        }
        return "Owners forced to leave";
    }

    public function create(Request $request)
    {
        return $this->createEntity($request);
    }

    public function index(Request $request)
    {
        return $this->listEntities();
    }
}
