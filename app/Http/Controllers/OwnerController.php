<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\Owner;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class OwnerController extends BaseController
{
    protected $tableName = 'owners';

    public function getTableName(){
        return $this->tableName;
    }

    public function create(Request $request)
    {
        return $this->createEntity($request);
    }

    public function list() {
        return $this->listEntities();
    }
}
