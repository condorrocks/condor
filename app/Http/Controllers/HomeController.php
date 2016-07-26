<?php

namespace App\Http\Controllers;

use App\Condor\Panels\PanelsBuilder;
use Illuminate\Support\Collection;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = auth()->user()->accounts()->get();
        
        $panels = [];
        foreach ($accounts as $account) {
            $panels[] = with(new PanelsBuilder($account->boards))->get();
        }

        $panels = collect($panels)->collapse();

        return view('dashboard', compact('panels'));
    }
}
