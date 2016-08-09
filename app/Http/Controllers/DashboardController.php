<?php

namespace App\Http\Controllers;

use App\Condor\Panels\Panels;
use Illuminate\Support\Collection;

class DashboardController extends Controller
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
        logger()->info(__METHOD__);

        $accounts = auth()->user()->accounts()->get();
        
        $panels = [];
        foreach ($accounts as $account) {
            $panels[] = with(new Panels($account->boards))->get();
        }

        $panels = collect($panels)->collapse();

        return view('dashboard', compact('panels'));
    }
}
