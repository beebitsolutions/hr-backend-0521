<?php

namespace App\Repositories;

use App\Models\Dog;
use App\Models\Owner;
use Illuminate\Http\Request;

class DogRepository implements DogRepositoryInterface
{
    protected $model;

    /**
     * PostRepository constructor.
     *
     * @param Dog $dog
     */
    public function __construct(Dog $dog)
    {
        $this->model = $dog;
    }

    public function index()
    {
        return $this->model->with('owner')->get();
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'owner_id' => 'required',
        ]);

        $owner = Owner::findOrNew($request->input('owner_id'));
        $this->model->create(['name'=>$request->input('name')]);
        $this->model->owner()->associate($owner);

        return $this->model;
    }
}