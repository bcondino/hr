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
				<!-- <div class="col-sm-6"> -->

					<div class="water-mark col-md-12">
						<img class="watermark" src="{{ asset('logindesign/img/backgrounds/2nuvem_logo.png') }}" />
					</div>

				<!-- </div> -->

				<!--div class="col-sm-1 middle-border"></div-->
				<!-- <div class="col-sm-2"></div> -->

				<!-- <div class="col-sm-4 " id=""> -->

					<!-- start login -->
					<form role="form" action="{{url('auth/resendverification/'.$email_address)}}" method="get">
					{{ csrf_field() }}

					<div class="form-box front col-sm-7" style="margin:70px auto;">
						<div class="form-top">
							<div class="form-top-left success">
								<h3>Thank you very much!</h3>
								<p>An email was sent to {{ $email_address }}. Please click the link in the message sent to activate your account.</p>
							</div>
							<div class="form-top-right">
								<i class="fa fa-thumbs-o-up"></i>
							</div>
							<!-- <div class="form-top-left error">
								<h3>Something wrong occurred</h3>
								<p>The call to the server did not complete within the timeout period. We are unsure of the result of this operation.  Please contact support.</p>
							</div>
							<div class="form-top-right">
								<i class="fa fa-exclamation-triangle"></i>
							</div>	 -->
						</div>
						<div class="form-bottom">
								<button type="submit" class="btn form-control">Resend Verification</button>
							<div class="text-right">
								<hr />
									<a id="loginButton" href="{{ url('auth/login') }}" style="color:#fff;">Back to Login</a>
								<br />
							</div>

						</div>
					</div>
					</form>
					<!-- end login -->
				<!-- </div> -->
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