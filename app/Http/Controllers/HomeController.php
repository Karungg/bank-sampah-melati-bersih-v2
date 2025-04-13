<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    public function about(): View
    {
        return view('about');
    }

    public function products(): View
    {
        return view('products.index');
    }

    public function posts(): View
    {
        return view('posts.index');
    }
}
