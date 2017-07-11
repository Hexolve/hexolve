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

        .thread-form-container {
            display: none;
        }

    </style>
@stop

@section('content')
    @foreach($forums as $k => $forum)
        <div class="forum-parent">
            <a href="/forum/{{ $forum['id'] }}">{{$forum['forum_name']}}</a>
        </div>
    @endforeach

    <p>Threads:</p>

    <v-btn class="add-thread" primary light>New Thread</v-btn>
    <div class="thread-form-container">
        <text_input label="Thread Title" id="thread_name" type="text" :hint="inputs.username.msg"></text_input>
        <text_input label="Thread Body" id="thread_body" type="text" :hint="inputs.username.msg"></text_input>

        <v-btn class="submit-thread" data-id="{{$forum_id}}" primary light>Submit</v-btn>
    </div>

    <div class="thread-container">
        <thread-list
        v-for="thread in threads"
        v-bind:thread="thread"
        v-bind:key="thread.id"
        v-bind:href="thread.id">
        </thread-list>
    </div>

@stop

@section('scripts')
    @parent
    <script>
        var forum = {

            threads : {!! json_encode($threads) !!},

            init : function() {
                var self = this;
                $(document).ready(function() {
                    self.bindActions();

                    App.data.threads = self.threads;

                });
            },

            bindActions : function() {
                var self= this;
                var $submit_thread = $('.submit-thread');
                $submit_thread.unbind();
                $submit_thread.on('click', function() {
                    var data = self.getData($('.thread-form-container'), ['thread_name', 'thread_body']);
                    data['forum_id'] = $(this).data('id');
                    $.ajax({
                        url : '/forum/api/submitThread',
                        data : data,
                        success : function(r) {
                            App.data.threads.unshift(r.thread);
                        }
                    })
                });

                var $add_thread = $('.add-thread');
                $add_thread.unbind();
                $add_thread.on('click', function() {
                    $('.thread-form-container').slideToggle();
                })

            },

            getData : function(c, fields) {
                if(!c instanceof jQuery) {
                    c = $(c);
                }

                var data = {};
                $.each(fields, function(ind, val) {
                    data[val] = $('[id="'+val+'"]', c).val();
                });

                return data;

            }
        }

        forum.init();
    </script>
@stop