<?php

namespace App\Controllers\Home;

use App\Controllers\Controllers;

class HomeController extends Controllers
{
    public function index()
    {
        view('home.index');
    }

    public function show($id)
    {
        dump($id);
    }
}
