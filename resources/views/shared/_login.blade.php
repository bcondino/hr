<!doctype html>
<html lang="en">
<head>
	
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>@yield('title') - Nuvem HR</title>
	
	<!-- primary styles -->
	<link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css') }}" />
	
	<!-- login designs -->
	<link rel="stylesheet" href="{{ asset('logindesign/css/form-elements.css') }}">	
	<link rel="stylesheet" href="{{ asset('logindesign/css/style.css') }}">

	@yield('styles')

</head>
<body>
	<div name="container">
		@yield('content')
	</div>

	@yield('modal')
		
	@yield('scripts')

</body>
</html>