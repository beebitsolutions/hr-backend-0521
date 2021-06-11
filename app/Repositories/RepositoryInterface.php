<?php

namespace App\Repositories;
use Illuminate\Http\Request;

interface RepositoryInterface
{
    public function all();

    public function create(Request  $request);
}
