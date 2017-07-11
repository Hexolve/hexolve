<?php

namespace App\Http\ViewComposers;

use App\Http\Libraries\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class WebComposer {

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct(){

    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view) {
        $view->with('logged_in', Auth::verifyUser());
        $view->with('user_id', Session::get('user')['id']);
    }
}