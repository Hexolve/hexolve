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

class AuthController extends Controller {
    public function renderRegister() {
        return View::make('register');
    }

    public function renderLogin() {
        return View::make('login');
    }

    public function login() {
        $validator = Validator::make($this->input, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $validator->validate();

        $username = trim($this->input['username']);
        $password = $this->input['password'];

        return Auth::login($username, $password);
    }

    public function logout() {
        Session::forget('user');
        return Redirect::to('/login');
    }

    public function register() {

        $validator = Validator::make($this->input, [
            'username' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8'
        ]);

        $validator->validate();

        $username = trim(Input::get('username'));
        $password = Input::get('password');
        $confirm_password = Input::get('confirm_password');

        // Check if user already exists
        $exists = Auth::getUser($username);
        if(!empty($exists)) {
            return Helper::throwError(['username' => 'Username already exists!']);
        }

        if($password != $confirm_password) {
            return Helper::throwError(['password' => 'Passwords do not match!']);
        }

        // Username and password are good, insert into database
        $hashed_pass = Hash::make($password);

        $check = DB::insert('INSERT INTO users (username, password) VALUES (:username, :password)', ['username' => $username, 'password' => $hashed_pass]);

        if($check) {
            return Auth::login($username, $password);
        }

    }
}
