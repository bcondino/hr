<!-- navigation -->
<div class="uk-container uk-container-center wireframe">	
    <header class="header">
    	<div id="logo">
    		<a href="{{ url('home') }}"><img src="{{ asset('images/ui/logo.png') }}" /></a>
    	</div>
		<div class="header--user">
			<div class="uk-button-dropdown" data-uk-dropdown>	
				<div>
					<div class="header--user_welcome">
						<div class="header--user_message">Welcome {{ ucwords(Auth::user()->first_name) }} {{ ucwords(Auth::user()->last_name) }}</div>
						<div class="header--user_pos-log">
							<div class="header--user_position"> {{ ucwords(\App\tbl_company_model::where('company_id', \App\tbl_user_company_model::where('user_id', Auth::user()->user_id)->where('default_flag', 'Y')->first()->company_id)->first()->company_name) }} - {{ ucwords(\App\tbl_user_type_model::where('user_type_id', Auth::user()->user_type_id)->first()->user_type_name) }} </div>
							<div class="header--user_logdate"> Last logged in: 
								<?php
									/* 20161003 debugged by Melvin Militante */
									$date = empty(Auth::user()->date_last_login)? date("Y-m-d h:i:sa") : Auth::user()->date_last_login;
									//$date = substr(Auth::user()->date_last_login, 0, 10);
									list($year, $month, $day) = explode('-', substr($date, 0, 10));
									//list($year, $month, $day) = explode('-', $date);
									$month =  date('F', mktime(0, 0, 0, $month));
									$time = 'AM';
									//$date = substr(Auth::user()->date_last_login, 11, strlen(Auth::user()->date_last_login));
									list($hour, $minute, $second) = explode(':', substr($date,11,strlen($date)));
									//list($hour, $minute, $second) = explode(':', $date);
									/* 20161003 end of change */
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
						<div style="font-color:#155fa8;"> 
						@foreach(\App\tbl_company_model::
									whereIn('company_id', \App\tbl_user_company_model::
	                                    where('user_id', Auth::user()->user_id)
	                                    ->lists('company_id')
	                                    ->toArray())
                                ->where('active_flag', 'Y')
                                ->orderBy('updated_at', 'desc')
                                ->orderBy('company_id', 'desc')
                                ->take(3)
                                ->get() as $company)
							<li><a href="{{ url('companies/changecompany2/'. $company->company_id) }}" style="border:#4285c5 solid 1px"> <span class="uk-icon-building"></span> {{ $company->company_name }}</a></li>
						@endforeach
					</div>
						<hr></hr>
						<li><a href="{{ url('companies/changecompany') }}"><span class="uk-icon-gear"></span> Change Company</a></li>
						<li><a href="{{ url('users/changepassword') }}"><span class="uk-icon-unlock-alt"></span> Change Password</a></li>						
						<li><a href="{{ url('auth/logout') }}"><span class="uk-icon-sign-out"> </span> Logout</a></li>
					</ul>
				</div>
			</div>
		</div>

		<nav class="navbar">
		    <ul class="navbar-nav">
		        <li class="uk-parent" data-uk-dropdown><a style="cursor:default;">Admin <span class="uk-icon uk-icon-angle-down"></span></a>
		        	<div class="uk-dropdown uk-dropdown-navbar nav-payroll">
		                <ul class="uk-nav uk-nav-navbar">
		                    <li><a href="{{ url('companies/companies') }}">Companies</a></li>
		                    <li><a href="{{ url('users/users') }}">Users</a></li>
		                    <li><a href="{{ url('home/admin/audits') }}">Audits</a></li>
		                    <li><a href="{{ url('home/admin/annoucements') }}">Announcements</a></li>
		                </ul>
		            </div>
		        </li>
		        <li class="uk-parent" data-uk-dropdown><a style="cursor:default;">Employee <span class="uk-icon uk-icon-angle-down"></span></a>
		        	<div class="uk-dropdown uk-dropdown-navbar nav-payroll">
		                <ul class="uk-nav uk-nav-navbar">
					        <li><a href="{{ url('employee/employees') }}">Employees</a></li>
		                    <li><a href="{{ url('employee/movements') }}">Movements</a></li>
		                </ul>
		            </div>
		        </li>
		        <li><a href="{{ url('home/leave') }}">Leave</a></li>
		        <li><a href="{{ url('home/time') }}">Time</a></li>
		        <li class="uk-parent" data-uk-dropdown><a style="cursor:default;">Payroll <span class="uk-icon uk-icon-angle-down"></span></a>
		        	<div class="uk-dropdown uk-dropdown-navbar nav-payroll">
		                <ul class="uk-nav uk-nav-navbar">
		                    <li><a href="{{ url('payroll/taxexemption') }}">Payroll Parameter</a></li>
		                    <li><a href="{{ url('payrollmanagement/profile')}}">Payroll Management</a></li>
		                    <li><a href="#">Official Receipts Management</a></li>
							<!-- 20161027 updated by Melvin Militante
									-Reason: Remove "<li><a href="{{ url('reports') }}">Reports</a></li> ". It will now be included on Payroll Management
							-->
		                    <li><a href="#">Preferences</a></li>
		                </ul>
		            </div>
		        </li>
		    </ul>
		</nav>
    </header>
</div> <!-- end of wireframe -->
<!-- /navigation -->