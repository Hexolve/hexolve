<head>
    @section('head')
        @include('layouts.head')
        <style>
            body {
                color: #FFF;
                background: #262626;
            }

            ul {
                height: 100%;
                margin: 0;
                list-style-type: none;
            }

            .navbar {
                position: relative;
                width: 100%;
                height: 50px;
                background: #000;
            }

            .navbar .left {
                float: left;
                height: 100%;
                width: 65%;
            }

            .navbar .right {
                float: left;
                height: 100%;
                width: 35%;
            }

            .navbar ul li {
                height: 100%;
                float: left;
                line-height: 45px;
                padding: 0 5px;
            }

            .navbar img {
                position: absolute;
                height: 80%;
                top: 0;
                bottom: 0;
                margin: auto;
                margin-left: 5%;
            }

            /** Vuetify Overrided **/
            .input-group__details:before {
                background: #ccc;
            }
        </style>
    @show

</head>

<body>
    <div class="app">
        <div class="navbar">
            <div class="left">
                <img src="/images/logo.svg" />
            </div>

            <div class="right">
                <ul>
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li>
                        <a href="/forum">Forum</a>
                    </li>
                    @if(!$logged_in)
                        <li>
                            <a href="/login">Login</a>
                        </li>

                        <li>
                            <a href="/register">Register</a>
                        </li>
                    @else
                        <li>
                            <a href="/account/{{$user_id}}">Account</a>
                        </li>

                        <li>
                            <a href="/logout">Logout</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <v-snackbar
                v-model="error.show"
                :top="true"
                :error="true">
            @{{ error.message }}
            <v-btn flat class="pink--text" @click.native="error.show = false">Close</v-btn>
        </v-snackbar>

        @section('content')
            Hello World
        @show


    </div>


    @section('scripts')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        {{--<script src="https://unpkg.com/vue"></script>--}}
        <script src="https://unpkg.com/vue/dist/vue.js"></script>
        <script src="https://unpkg.com/vuetify/dist/vuetify.min.js"></script>
        <script>

            var Util = {
                clearErrors : function() {
                    $.each(App.data.inputs, function(ind, val) {
                        App.data.inputs[ind]['msg'] = '';
                    })
                }
            };

            var App = {
                data : {
                    user : {},
                    threads : {},
                    error : {
                        show : false,
                        message : 'Hello World'
                    },
                    show : false,
                    inputs : {
                        username : {
                            msg : ''
                        },
                        password : {
                            msg : ''
                        },
                        confirm_password : {
                            msg : ''
                        }
                    }
                }
            };

            Vue.config.devtools = true;

            var _text_input = Vue.component('text_input', {
                template: `
                            <v-layout row wrap>
                                <v-flex xs12>
                                    <v-text-field

                                        :label="label"
                                        :id="id"
                                        :type="type"
                                        :hint="hint"
                                        :error="getError"
                                        ></v-text-field>
                                </v-flex>
                            </v-layout>`,
                props: ['label', 'id', 'type', 'hint', 'error'],
                computed : {
                    getError : function() {
                        var hint = this.hint;
                        if(hint === undefined) {
                            hint = '';
                        }
                        return hint != '' ? true : false;
                    }
                }
            });

            Vue.component('thread-list', {
                props : ['thread', 'href'],
                template : `<div class="thread-row">
                        <p> <a :href="/thread/ + thread.id"> @{{thread.thread_name}}</a> - @{{ thread.date }}</p>
                        </div>`
            });

            new Vue({
                el: '.app',
                data : App.data
            });


        </script>

    @show
</body>