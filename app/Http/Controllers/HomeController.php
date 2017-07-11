<?php

namespace App\Http\Controllers;

use DebugBar\DebugBar;
use DB;
use Event;
use Illuminate\Support\Facades\Session;
use View;

class HomeController extends Controller {

    public function index() {
        return View::make('home');
    }

}
