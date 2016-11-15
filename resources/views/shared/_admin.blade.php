<!doctype html>
<html lang="en">
<head>

	<!--[if lt IE 9]>
      <script src="{{ asset('html5shiv-master/dist/html5shiv.js') }}"></script>
	  <script src="{{ asset('html5shiv-master/dist/html5shiv-printshiv.js') }}"></script>
      <script src="{{ asset('Respond-master/dest/respond.min.js') }}"></script>
	  <script src="{{ asset('Respond-master/src/respond.js') }}"></script>
    <![endif]-->
	
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>@yield('title') - Nuvem HR</title>
	
	<!-- primary styles -->
	<link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css') }}" />

	<link rel="stylesheet" type="text/css" href="{{ asset('tab-style/css/easy-responsive-tabs.css') }}" />
	<link href="{{ asset('tab-style/css/jquery.uls.css') }}" rel="stylesheet"/>
	<link href="{{ asset('tab-style/css/jquery.uls.grid.css') }}" rel="stylesheet"/>
	<link href="{{ asset('tab-style/css/jquery.uls.lcd.css') }}" rel="stylesheet"/>
	@yield('styles')

</head>
<body>

	<div class="header">		
		@include('main.shared._nav')
	</div>
	<!-- /.header -->

	<div name="container" class="container">
		@yield('content')	
	</div>
	

	<!-- <footer class="footer" style="position:fixed; bottom:0; width:100%; ">
		<div class="footer-bottom text-center">
			<div class="copyrights">
				<p> NuvemHR 1.0.1 | @ 2016 NuvemHR. All Rights Reserved</p>
			</div>
		</div>
	</footer>	 -->
	
	@yield('modal')
	
	<!-- primary scripts -->
	<script src="{{ asset('js/jquery-1.12.4.min.js') }}"></script>
	<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
	
	@yield('scripts')

</body>
</html>