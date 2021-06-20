<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    //
    public function _create(Request $request, Model $model): Model
    {
        $request->validate([
            'name' => 'required'
        ]);

        $model->name = $request->input('name');
        $model->save();

        return $model;
    }

    public function _list(Model $model) {
        return $model::with('dogs')->get();
    }
}
