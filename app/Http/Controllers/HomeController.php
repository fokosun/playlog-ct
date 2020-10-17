<?php

namespace Playlog\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        return redirect('/feed');
    }
}
