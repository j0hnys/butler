<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpaController extends Controller
{
    public function index()
    {
        view()->addNamespace('vista', base_path('resources_backend'));

        return view('vista::views.iview');
    }
}