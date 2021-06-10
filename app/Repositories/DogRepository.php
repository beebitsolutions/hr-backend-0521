<?php


namespace App\Repositories;

use App\Models\Dog;
use App\Models\Owner;
use App\Repositories\Interfaces\DogRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class DogRepository implements DogRepositoryInterface
{
    /**
     * @var Dog
     */
    protected $model;

    /**
     * DogRepository constructor.
     *
     * @param Dog $dog
     */
    public function __construct(Dog $dog)
    {
        $this->model = $dog;
    }

    /**
     * @return Builder[]|Collection
     */
    public function index()
    {
        return $this->model::with('owner')->get();
    }

    /**
     * @param array $data
     * @return Owner|Model
     */
    public function create(array $data)
    {
        return $this->model::firstOrCreate($data);
    }
}
