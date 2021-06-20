<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\Owner;
use App\Repositories\DogRepositoryInterface;
use Illuminate\Http\Request;

class DogController extends Controller
{
    private $repository;

    /**
     * DogController constructor.
     * @param DogRepositoryInterface $repository
     */
    public function __construct(DogRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function show($dog)
    {
        return $this->repository->find($dog);
    }
}
