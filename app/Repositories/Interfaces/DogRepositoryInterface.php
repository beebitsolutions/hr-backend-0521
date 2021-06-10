<?php


namespace App\Repositories\Interfaces;


interface DogRepositoryInterface
{

    /**
     * @return mixed
     */
    public function index();

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);
}
