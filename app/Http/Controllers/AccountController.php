<?php

namespace App\Http\Controllers;

use App\Http\Libraries\Auth;
use App\Http\Libraries\Helper;
use Illuminate\Support\Facades\Input;
use Hash;
use DB;
use Event;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Validator;
use View;

class AccountController extends Controller {
    public function renderAccount($id) {
        return View::make('account')->with(['account_id' => $id]);
    }

    public function getData() {
        $id = Input::get('id');

        $user = DB::select('SELECT * FROM users WHERE id = :id', ['id' => $id]);
        return $user[0];
    }

}

