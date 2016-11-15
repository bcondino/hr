<!doctype html>
<html lang="en">
	<head>
		<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}"/>
		<meta charset="utf-8">
		<meta name="csrf-token" content="{{ csrf_token() }}">
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

		<title>
			@yield('title') - NuvemHR ({{ ucwords(\App\tbl_company_model::where('company_id', \App\tbl_user_company_model::where('user_id', Auth::user()->user_id)->where('default_flag', 'Y')->first()->company_id)->first()->company_name) }})
		</title>
		@yield('styles')
	</head>
	<body>
		@include('main.shared._nav')

	<div name="container">
		@yield('content')
	</div>

	@yield('scripts')

</body>
</html>