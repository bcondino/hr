@extends('shared._login')

@section('title', 'Register')

@section('styles')
	<!--link rel="stylesheet" href="{{ asset('logindesign/css/flipstyle.css') }}"-->			
<style>
	.changepw a{
		padding: 0;
		color: #fff;
	}
	
	.changepw a:hover{
		padding: 0;
		color: #fff;
		text-decoration: underline;
	}
</style>
	
@endsection

@section('content')

<!-- top content -->
<div class="top-content">
	<!-- <div class="inner-bg"> -->
	<div>
		<div class="container">
			
			<!--div class="row">
				<div class="col-sm-8 col-sm-offset-2 text">
					<h1><strong>Nuvem HR </strong>Login &amp; Register Forms</h1>
				</div>
			</div-->
			
			<div class="row">
				<div class="col-sm-6">
				
					<div class="water-mark col-md-12">
						<img class="watermark" src="{{ asset('logindesign/img/backgrounds/2nuvem_logo.png') }}" />
					</div>
				
				</div>
				
				<!--div class="col-sm-1 middle-border"></div-->
				<div class="col-sm-2"></div>
				
				<div class="col-sm-4">													
					<!-- start register -->
					<div class="form-box front">
						<div class="form-top">
							<div class="form-top-left">
								<h3>Sign up now</h3>
								<p>Fill in the form below :</p>
							</div>
							<div class="form-top-right">
								<i class="fa fa-pencil"></i>
							</div>
						</div>
						
						<div class="form-bottom">
							<form role="form" action="{{url('auth/register')}}" method="post" class="registration-form">
								{{ csrf_field() }}
								<div class="form-group">
									<input type="text" name="first_name" placeholder="First Name..." class="form-first-name form-control" id="form-first-name" required oninvalid="this.setCustomValidity('First Name is required.')" oninput="setCustomValidity('')"/>
								</div>								
								<div class="form-group">
									<input type="text" name="last_name" placeholder="Last Name..." class="form-last-name form-control" id="form-last-name" required oninvalid="this.setCustomValidity('Last Name is required.')" oninput="setCustomValidity('')"/>
								</div>
								<div class="form-group">
									<input type="text" name="email_address" placeholder="Email Address..." class="form-email-add form-control" id="form-email-add" required oninvalid="this.setCustomValidity('Email Address is required.')" oninput="setCustomValidity('')"/>
								</div>
								<div class="form-group">
									<input type="text" name="company_name" placeholder="Company Name..." class="form-company-name form-control" id="form-company-name" required oninvalid="this.setCustomValidity('Company Name is required.')" oninput="setCustomValidity('')"/>
								</div>
								<button type="submit" id="registerButtonNotify" class="btn">Register</button>
							</form>
								<div class="text-right">
								<hr />
								<span style="color:#a6a6a6; font-size:15px">Already have an account? - </span>	
								<a id="loginButton" href="{{ url('auth/login') }}" style="color:#fff;">Login</a>
								<br/>
							</div>
						</div>
					</div>
					<!-- end register -->
					
				</div>
			</div>
			
		</div> <!-- container -->
	</div> <!-- inner bg -->
</div>
<!-- /.top content -->

<!-- Footer -->
<footer>
	<div class="container">
		<div class="row">
			
			<div class="col-sm-8 col-sm-offset-2">
				<div class="footer-border"></div>
				<p>Nuvem HR 1.0.1</p>
				<p>@2016 Nuvem Inc. All rights reserved.</p>
			</div>
			
		</div>
	</div>
</footer>
<!-- /.Footer -->

@endsection

@section('scripts')
<script src="{{ asset('logindesign/js/flipjs.js') }}"></script>
<!--script src="{{ asset('logindesign/js/jquery.backstretch.min.js') }}"></script-->
<!--script src="{{ asset('logindesign/js/scripts.js') }}"></script-->

@endsection