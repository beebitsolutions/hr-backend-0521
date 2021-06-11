<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\Owner;
use App\Repositories\DogRepository;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DogController extends Controller implements DogRepository
{
    protected $model;

    public function __construct(Dog $dog)
    {
        $this->model = $dog;
    }

    public function index()
    {
        return Dog::with('owner')->get();
    }

    public function create(Request $request): Dog
    {
        $request->validate([
            'name' => 'required',
            'owner_id' => 'required',
        ]);

        $owner = Owner::findOrFail($request->input('owner_id'));
        $dog = $this->model->create(json_decode($request->getContent(),true));
        $dog->owner()->associate($owner);
        $dog->save();

        return $dog;
    }

    public function update(Request $request, $id){
        return $this->model->where('id', $id)->update();
    }

    public function delete($id) {
        return $this->model->destroy($id);
    }

    public function find($id) {
        if (null == $dog = $this->model->find($id)) {
            throw new ModelNotFoundException("Dog not found");
        }

        return $dog;
    }
}
