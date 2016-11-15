<!doctype html>
<html lang="en">
<head>

	<!-- from categories -->
	<link rel="stylesheet" href="{{ asset('tab-style/css/bootstrap-select.css') }}">
	<link href="{{ asset('tab-style/css/style.css') }}" rel="stylesheet" type="text/css" media="all" />
	
	<link href="{{ asset('tab-style/css/jquery.uls.css') }}" rel="stylesheet"/>
	<link href="{{ asset('tab-style/css/jquery.uls.grid.css') }}" rel="stylesheet"/>
	<link href="{{ asset('tab-style/css/jquery.uls.lcd.css') }}" rel="stylesheet"/>
	
	<link rel="stylesheet" type="text/css" href="{{ asset('tab-style/css/easy-responsive-tabs.css') }}" />
	<!--  -->

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
	
	@yield('styles')

</head>
<body>
	<div name="container">
		@yield('content')
	</div>
	
	@yield('modal')
	
	<!-- primary scripts -->
	<script src="{{ asset('js/jquery-1.12.4.min.js') }}"></script>
	<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
	
	@yield('scripts')

</body>
</html>