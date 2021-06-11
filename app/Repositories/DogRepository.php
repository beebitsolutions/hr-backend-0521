<?php


namespace App\Repositories;

use Illuminate\Http\Request;

interface DogRepository
{
    public function index();
    public function create(Request $request);
    public function update(Request $request, $id);
    public function delete($id);
    public function find($id);
}
