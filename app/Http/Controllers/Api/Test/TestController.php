<?php

namespace App\Http\Controllers\Api\Test;

use App\Http\Controllers\Controller;
use App\Services\Auth\Traits\TraitController;

class TestController extends Controller
{

    use TraitController;

    public function index()
    {
        dd(1);
    }

}
