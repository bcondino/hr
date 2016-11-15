<html lang="en" class="uk-notouch">
    <head>
        <title> NUVEM HR | Payroll </title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
   

        <!-- load font awesome -->
        <link href="{{ asset('css/ubuntufont.css') }}" rel="stylesheet">        
        <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
        <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
        <link href="{{ asset('css/uikit.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/table.css') }}" rel="stylesheet">
        <link href="{{ asset('css/form-file.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.min.css') }}" rel="stylesheet">

        <!-- load js -->
        <script type="text/javascript" language="javascript" src="{{ asset('js/jquery-3.1.0.js') }}"></script>
        <script type="text/javascript" language="javascript" src="{{ asset('js/uikit.js') }}"></script>
        <script type="text/javascript" language="javascript" src="{{ asset('js/components/sticky.min.js') }}"></script>
        <script type="text/javascript" language="javascript" src="{{ asset('js/components/search.min.js') }}"></script>
        <script type="text/javascript" language="javascript" src="{{ asset('js/components/datepicker.js') }}"></script>
        <script type="text/javascript" language="javascript" src="{{ asset('js/jstree.min.js') }}"></script>

    </head>
    <body>
        <div class="uk-container uk-container-center wireframe">
            <header class="header">
                <div id="logo">
                    <a href="{{ url('home') }}"><img src="{{ asset('images/ui/logo.png') }}" /></a>
                </div>
                <div class="header--user">
                    <div class="uk-button-dropdown" data-uk-dropdown>   
                        <div>
                            <div class="header--user_welcome">
                                <div class="header--user_message">{{ ucwords(Auth::user()->first_name) }} {{ ucwords(Auth::user()->last_name) }}</div>
                                <div class="header--user_pos-log">
                                    <div class="header--user_position"> {{ ucwords(\App\tbl_company_model::where('company_id', \App\tbl_user_company_model::where('user_id', Auth::user()->user_id)->where('default_flag', 'Y')->first()->company_id)->first()->company_name) }} - {{ ucwords(\App\tbl_user_type_model::where('user_type_id', Auth::user()->user_type_id)->first()->user_type_name) }} </div>
                                    <div class="header--user_logdate"> Last logged in: 
                                        <?php
											/* 20161006 debugged by Melvin Militante */
											$date = empty(Auth::user()->date_last_login)? date("Y-m-d h:i:sa") : Auth::user()->date_last_login;
                                            //$date = substr(Auth::user()->date_last_login, 0, 10);
											list($year, $day, $month) = explode('-', substr($date, 0, 10));
                                            //list($year, $day, $month) = explode('-', $date);
                                            $month =  date('F', mktime(0, 0, 0, $month));
                                            $time = 'AM';
                                            //$date = substr(Auth::user()->date_last_login, 11, strlen(Auth::user()->date_last_login));
											list($hour, $minute, $second) = explode(':', substr($date,11,strlen($date)));
                                            //list($hour, $minute, $second) = explode(':', $date);
											/* 20161006 end of change */
                                            if ($hour > 12) {
                                                $hour -= 12;
                                                $time = 'PM';
                                            }
                                            echo $month.' '.$day.', '.$year.' '.$hour.':'.$minute.' '.$time;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <div class="user_welcome_image"></div>
                    </div>
                    <div class="uk-dropdown header--user_info">
                        <div class="header--user_message">{{ ucwords(Auth::user()->first_name) }} {{ ucwords(Auth::user()->last_name) }}</div>
                            <ul class="uk-nav uk-nav-dropdown">
                                <li><a href="{{ url('auth/logout') }}"><span class="uk-icon-sign-out"> </span> Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>
        </div> <!-- end of wireframe -->
    
        <div class="header--title_container">
            <div class="uk-container uk-container-center">
                <div class="container-title">
                    <h1 class="page-title"><span class="uk-icon uk-icon-file-text"></span> 
                        {{ ucwords(\App\tbl_company_model::where('company_id', \App\tbl_user_company_model::where('user_id', Auth::user()->user_id)->where('default_flag', 'Y')->first()->company_id)->first()->company_name) }}
                    </h1>
                </div>
            </div>
        </div>

    	@yield('content')

        @yield('modal')
    
        @yield('scripts')
        
    </body>
</html>