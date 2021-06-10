<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ReflectionClass;
use Carbon\Carbon;
use DB;
use Illuminate\Http\JsonResponse;

abstract class BaseController extends Controller
{
    abstract public function getTableName();

    public function createEntity(Request $request) : JsonResponse
    {
        $request->validate([
            'name' => 'required'
        ]);

        $childClass = (new ReflectionClass($this))->name;
        $childController = new $childClass();

        DB::table($childController->getTableName())->insert([
            'name' => $request->input('name'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        $response = ["status" => $request->input('name'). ' added succesfully'];

        return response()->json($response);
    }

    public function listEntities(): JsonResponse{
        $childClass = (new ReflectionClass($this))->name;
        $childController = new $childClass();

        $response = DB::table($childController->getTableName())->get();

        return response()->json($response);
    }
}
