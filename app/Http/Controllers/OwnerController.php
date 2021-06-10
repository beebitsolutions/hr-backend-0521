<?php

namespace App\Http\Controllers;

use App\Models\Owner;

class OwnerController extends BaseController
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Owner::class;
    }
}
