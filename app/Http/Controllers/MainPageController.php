<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use function compact;
use function view;

class MainPageController extends Controller
{
    public function index()
    {
        return view('index', compact([

        ]));
    }
}
