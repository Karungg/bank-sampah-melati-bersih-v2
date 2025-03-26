<?php

namespace App\Http\Controllers;

use App\Contracts\ProductServiceInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home');
    }
}
