<?php namespace App\Http\Libraries;

use DB;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;

class Helper {
    public static function throwError($messages) {
        return new JsonResponse($messages, 422);
    }
}