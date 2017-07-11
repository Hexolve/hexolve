<?php namespace App\Http\Libraries;

use DB;
use Hash;
use App\Http\Libraries\Helper;
use Illuminate\Support\Facades\Session;

class Forum {
    public function __construct() {

    }

    public static function getForums($parent) {
        $forums = DB::select('SELECT * FROM forums WHERE parent = :parent', ['parent' => $parent]);

        return $forums;
    }

    public static function getThreads($forum, $limit = 50, $offset = 0) {
        $threads = DB::select('SELECT 
                                t.*, u.username, f.forum_name 
                                FROM threads t 
                                INNER JOIN users u ON u.id = t.author
                                INNER JOIN forums f ON f.id = t.forum
                                WHERE t.forum = :forum ORDER BY date DESC, id DESC
                                LIMIT :limit
                                OFFSET :offset', [
                'forum' => $forum,
                'offset' => $offset,
                'limit' => $limit
            ]);

        return $threads;
    }


}