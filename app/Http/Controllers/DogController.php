<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\Owner;
use Illuminate\Http\Request;
use App\Repositories\DogRepositoryInterface;

class DogController extends Controller
{
    private $repository;

    public function __construct(DogRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        return $this->repository->all();
    }

    public function create(Request $request)
    {
        return $this->repository->create($request);
    }
}
