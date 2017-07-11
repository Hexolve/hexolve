<?php namespace App\Http\Libraries;

use DB;
use Hash;
use App\Http\Libraries\Helper;
use Illuminate\Support\Facades\Session;

class Auth {
    public function __construct() {

    }

    public static function login($username, $password) {
        // Get user by username and then validate hash
        $user = Auth::getUser($username);

        if(empty($user)) {
            return Helper::throwError(['username' => 'This user does not exist']);
        }

        $user = $user[0];

        $check = Hash::check($password, $user['password']);

        if(!$check) {
            return Helper::throwError(['password' => 'Invalid Password']);
        }

        // This user is legit bro
        unset($user['password']);
        Session::put('user', $user);
        return ['status' => 1, 'message' => 'User successfully logged in', 'user_id' => $user['id']];
    }

    public function register($username, $password, $confirm_password) {

    }

    public static function verifyUser() {
        return !empty(Session::get('user'));
    }

    public static function getUser($username) {
        return DB::select('SELECT * FROM users WHERE username ilike trim(lower(:username)) LIMIT 1', ['username' => trim(strtolower($username))]);
    }

}