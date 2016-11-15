@extends('shared._login')

@section('title', 'Log In')

@section('styles')

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

<div class="top-content">
	<div>
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<div class="water-mark col-md-12">
						<img class="watermark" src="{{ asset('logindesign/img/backgrounds/2nuvem_logo.png') }}" />
					</div>
				</div>
				<div class="col-sm-2"></div>
				<div class="col-sm-4 flipper" id="">
					<div class="form-box front">
						<div class="form-top">
							<div class="form-top-left">
								<h3>Login</h3>
								<p>Enter username and password :</p>
							</div>
							<div class="form-top-right">
								<i class="fa fa-lock"></i>
							</div>
						</div>
						<div class="form-bottom">
							<form role="form" action="{{ url('auth/login') }}" method="post" class="login-form">
								{{ csrf_field() }}
								<div class="form-group">
									<input type="text" name="username" placeholder="Username..." class="form-control" id="form-username" required oninvalid="this.setCustomValidity('Username is required.')" oninput="setCustomValidity('')"/>
								</div>
								<div class="form-group">
									<input type="password" name="password" placeholder="Password..." class="form-control" id="form-password" required oninvalid="this.setCustomValidity(' is required.')" oninput="setCustomValidity('')"/>
								</div>
								<div class="form-group text-right">
									<a href="{{ url('auth/forgotpass') }}" style="color:#fff; font-size:15px">Forgot your password?</a>
									@if($errors->has('username'))
										<p class="text-danger" style="font-size:13px;"> {{ $errors->first('username') }} </p>
									@elseif($errors->has('token_error'))
										<p class="text-danger" style="font-size:13px;"> {{ $errors->first('token_error') }} </p>
									@endif
								</div>
								<button type="submit" class="btn">Sign in</button>
							</form>
							<div class="text-right">
								<hr />
								<span style="color:#a6a6a6; font-size:15px">Don't have an account? - </span>
								<a id="registerButton" href="{{ url('auth/register') }}" style="color:#fff;">Register</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> <!-- container -->
	</div> <!-- inner bg -->
</div> <!-- /.top content -->

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
</footer> <!-- /.Footer -->

@endsection

@section('scripts')

@endsection

