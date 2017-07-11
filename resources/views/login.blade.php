@extends('layouts.master')

@section('content')

    <v-layout row wrap>
        <v-flex xs8 offset-xs2>

            <text_input label="Username" id="username" type="text" :hint="inputs.username.msg"></text_input>
            <text_input label="Password" id="password" type="password" :hint="inputs.password.msg"></text_input>

            <v-btn id="login" primary light>Login</v-btn>

        </v-flex>
    </v-layout>

@stop

@section('scripts')
    @parent
    <script>
        var register = {

            init : function() {
                var self = this;
                $(document).ready(function() {
                    self.bindActions();
                });

            },

            bindActions : function() {
                var self = this;

                var $login = $('#login');
                $login.unbind();
                $login.on('click', function() {
                    Util.clearErrors();
                    $.ajax({
                        url : '/auth/api/login',
                        data : self.getData($('body'), ['username', 'password']),
                        dataType: 'json',
                        success : function(r) {
                            if(r.status != 1) {
                                alert(r.message);
                            } else {
                                window.location.href = '/account/' + r.user_id;
                            }
                        },
                        error : function(r) {
                            msg = '';
                            $.each(r.responseJSON, function(field, message) {
                                msg += message + '\n';
                                App.data.inputs[field]['msg'] = message;
                            });

                            App.data.error.show = true;
                            App.data.error.message = msg;

                        }
                    });
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
        };

        register.init();
    </script>
@stop