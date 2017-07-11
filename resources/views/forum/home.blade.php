@extends('layouts.master')

@section('head')
    @parent
    <style>
        .section-head {
            padding: 10px;
            font-weight: bold;
            text-decoration: underline;
        }

        .forum-parent {
            text-indent: 10px;
            padding: 5px;

        }

    </style>
@stop

@section('content')
    @foreach($sections as $k => $section)
        <div class="section-head">
            {{$section['section_name']}}
        </div>
        @foreach($forums[$section['id']] as $ok => $forum)
            <div class="forum-parent">
                <a href="/forum/{{ $forum['id'] }}">{{$forum['forum_name']}}</a>
            </div>
        @endforeach
    @endforeach

@stop