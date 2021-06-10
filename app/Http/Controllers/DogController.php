<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Repositories\Interfaces\DogRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class DogController extends Controller
{

    /** @var DogRepositoryInterface */
    private $dogRepository;

    /**
     * DogController constructor.
     * @param DogRepositoryInterface $dogRepository
     */
    public function __construct(DogRepositoryInterface $dogRepository)
    {
        $this->dogRepository = $dogRepository;
    }

    /**
     * @return Builder[]|Collection
     */
    public function index()
    {
        return $this->dogRepository->index();
    }

    /**
     * @param Request $request
     * @return Dog
     */
    public function create(Request $request): Dog
    {
        $request->validate([
            'name' => 'required',
            'owner_id' => 'exists:owners,id|required',
        ]);

        return $this->dogRepository->create($request->all());
    }
}
