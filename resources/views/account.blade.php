@extends('layouts.master')

@section('head')
    @parent
    <style>
        .greeting {
            text-transform: capitalize;
        }
    </style>
@stop

@section('content')
    <v-layout row wrap class="account-wrapper">
        <v-flex xs8 offset-xs2>
            <div class="greeting">
                <h2 class="green--text darken-3">Hello @{{user.username}}</h2>
            </div>
        </v-flex>
    </v-layout>

@stop

@section('scripts')
    @parent
    <script>

        var id = '{{$user_id}}';

        var account = {
            data : {
                user : {}
            },
            init : function() {
                var self = this;
                $(document).ready(function() {
                    self.bindActions();
                    self.getAccount();
                });

            },

            bindActions : function() {

            },

            getAccount : function() {
                var self = this;
                var data = {
                    id : id
                };
                $.ajax({
                    url : '/account/api/getData',
                    data : data,
                    success : function(r) {
                        App.data.user = r;
                    }
                })
            }
        };

        account.init();
    </script>
@stop