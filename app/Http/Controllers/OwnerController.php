<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Http\Request;

class OwnerController extends BaseController
{
    public function __construct()
    {
        $this->main_model = new User();
        parent::__construct($this->main_model);
    }

    public function create(Request $request): Owner
    {
        $request->validate([
            'name' => 'required'
        ]);

        return parent::create($request);
    }
}
