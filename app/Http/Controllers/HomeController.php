<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    public function index(Request $request)
    {
        $data = array(
            "drop1" => "",
            "drop2" => ""
        );
        if (isset($request->drop1)){
            $data = array(
                "drop1" => "Option ".$request->drop1,
                "drop2" => "Step ".$request->drop2
            );
        }
        return view('home', $data);
    }
}
