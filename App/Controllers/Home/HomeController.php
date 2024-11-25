<?php

namespace App\Controllers\Home;

use App\Models\User;

class HomeController
{
    public function index()
    {
        view('home.index');
    }
}
