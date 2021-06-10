<?php

namespace App\Repositories;

use App\Models\Dog;
use App\Models\Owner;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DogRepository implements DogRepositoryInterface
{
    protected $model;

    public function __construct(Dog $dog)
    {
        $this->model = $dog;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'owner_id' => 'required',
        ]);

        $owner = Owner::findOrFail($request->input('owner_id'));
        $dog = new Dog();
        $dog->name = $request->input('name');
        $dog->owner()->associate($owner);
        $dog->save();

        return $dog;
    }
}
