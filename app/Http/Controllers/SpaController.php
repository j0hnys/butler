<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpaController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            $url = url('/login');
            $url = str_replace('public_backend', 'public', $url);
            return redirect()->to($url);
        }

        view()->addNamespace('vista', base_path('resources_backend'));

        return view('vista::views.iview');
    }
}