<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends BaseController
{
    public function create(Request $request): Owner
    {
        $owner = new Owner();
        return $this->_create($request, $owner);
    }

    public function list() {
        $owner = new Owner();
        return $this->_list($owner);
    }
}
