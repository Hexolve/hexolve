<?php

namespace App\Http\Controllers;

use App\Http\Libraries\Auth;
use App\Http\Libraries\Forum;
use App\Http\Libraries\Helper;
use Illuminate\Support\Facades\Input;
use Hash;
use DB;
use Event;
use Illuminate\Support\Facades\Session;
use Validator;
use View;

class ForumController extends Controller {
    public function renderHome() {

        $tmp_forums = DB::select('SELECT * FROM forums f WHERE f.parent IS NULL AND f.section IS NOT NULL ORDER BY f.position ASC');
        $sections = DB::select('SELECT * FROM  sections s ORDER BY s.position ASC');

        $forums = [];
        foreach($tmp_forums as $k => $forum) {
            $section_id = $forum['section'];
            if(empty($forums[$section_id])) {
                $forums[$section_id] = [];
            }

            $forums[$section_id][] = $forum;
        }


        return View::make('forum.home')->with(['sections' => $sections, 'forums' => $forums]);
    }

    public function renderForum($forum_id) {
        $forums = Forum::getForums($forum_id);
        $threads = Forum::getThreads($forum_id);

        return View::make('forum.forum')->with(['forums' => $forums, 'threads' => $threads, 'forum_id' => $forum_id]);
    }

    public function submitThread() {
        $validator = Validator::make($this->input, [
            'thread_name' => 'required',
            'thread_body' => 'required'
        ]);

        $validator->validate();

        $thread_name = $this->input['thread_name'];
        $thread_body = $this->input['thread_body'];

        $author = Session::get('user.id');
        if(empty($author)) {
            $author = 1;
        }

        $check = DB::SELECT('INSERT INTO threads (thread_name, thread_body, author, forum) VALUES (:thread_name, :thread_body, :author, :forum) RETURNING *', [
            'thread_name' => $thread_name,
            'thread_body' => $thread_body,
            'author' => $author,
            'forum' => $this->input['forum_id']
        ]);

        if($check) {
            return ['status' => 1, 'message' => 'Thread successfully submitted.', 'thread' => $check[0]];
        }

    }

}