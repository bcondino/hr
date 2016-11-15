@extends('shared._login')

@section('title', 'Log In')

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

				<div class="col-sm-4 flipper" id="">

					<!-- start login -->
					<div class="form-box front">
						<div class="form-top">
							<div class="form-top-left">
								<h3>Can't sign in?</h3>
								<h3> Lost your password?</h3>
								<p>Please enter your email</p>
							</div>
							<div class="form-top-right">
								<i class="fa fa-question-circle-o"></i>
							</div>
						</div>

						<div class="form-bottom">
							<form role="form" method="post" class="login-form">
								{{ csrf_field() }}
								@if(Session::has('passwordreset'))
									<p class="text-danger" style="font-size:13px;"> {{ Session::get('passwordreset') }} </p>
								@endif
								<div class="form-group">
									<label class="sr-only" for="email">Email</label>
									<!-- <div class="input-group">									 -->
									<input type="text" name="email" placeholder="Email" class="form-email form-control" id="form-email" required/>
									<!-- <span class="input-group-addon">@email</span>
									</div> -->
								</div>
								<button type="submit" class="btn">Send Password Reset</button>
							</form>
							<div class="text-right">
								<hr />
								<a id="loginButton" href="{{ url('/') }}" style="color:#fff;">Back to Login</a>
								<br />
							</div>
						</div>
					</div>
					<!-- end login -->
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
<!-- <script src="{{ asset('logindesign/js/flipjs.js') }}"></script> -->
<!--script src="{{ asset('logindesign/js/jquery.backstretch.min.js') }}"></script-->
<!--script src="{{ asset('logindesign/js/scripts.js') }}"></script-->

@endsection