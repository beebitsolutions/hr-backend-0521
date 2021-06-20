<?php

namespace App\Repositories;
use Illuminate\Http\Request;


interface RepositoryInterface
{
    public function index();

    public function create(Request $request);
}