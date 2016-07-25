<?php

namespace App\Http\Controllers;

use Alariva\UptimeRobot\UptimeRobot;

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
        $upRobot = new UptimeRobot();

        $upRobot::configure('API-KEY', 1);

        $upRobot->setFormat('json'); //Define the format of responses (json or xml)

        /*
         * Get status of one monitor by her id
         */
        try {
            $uprobot = $upRobot->getMonitors(0000);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $collection = collect($uprobot->monitors->monitor);

        $collection->transform(function ($item, $key) {

            switch ($item->status) {
                default:
                case '0':
                case '1':
                    $item->statuslabel = 'default';
                    break;
                case '2':
                    $item->statuslabel = 'success';
                    break;
                case '8':
                    $item->statuslabel = 'warning';
                    break;
                case '9':
                    $item->statuslabel = 'danger';
                    break;
            }

            return $item;
        });

        $uprobot->monitors->monitor = $collection;

        $monitors = $uprobot->monitors->monitor;

        return view('home', compact('monitors'));
    }
}
