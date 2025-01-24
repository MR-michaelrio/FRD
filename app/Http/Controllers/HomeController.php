<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\anggota;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $jmlhanggota = anggota::all()->count();
        return view('template.master',compact('jmlhanggota'));
        // return redirect()->route('index');
        // return view("home");
    }
}
