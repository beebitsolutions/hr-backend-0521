<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $main_model;

    public function __construct(Model $main_model)
    {
        $this->main_model = $main_model;
    }

    public function list() {
        return $this->main_model->all();
    }

    public function create(Request $request) {
        return $this->main_model->create(json_decode($request->getContent(),true));
    }
}
