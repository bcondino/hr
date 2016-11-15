@extends('shared._public2')

@section('title', 'Thank You')

@section('styles')
	<link rel="stylesheet" href="{{ asset('logindesign/css/form-elements.css') }}">
	<link rel="stylesheet" href="{{ asset('logindesign/css/style.css') }}">
@endsection

@section('content')

<form role="form" action="{{url('auth/activateverification/'.$email_address)}}" method="get">
	{{ csrf_field() }}
	<h3>Welcome to NuvemHR!</h3>
	<p>Thank you for signing up!</p>
	<p>To complete the registration process, please click the button below to verify your email address. Once verified, you can start setting up your company and payroll.</p>
	<p>Your default username is <b>{{$username}}</b> and password is <b>{{$pwd}}</b>.</p>
	<button type="submit">Activate</button>
	<p>If the button above doesn’t work, copy and paste the following link in your web browser</p>
	<a href="{{url('auth/activateverification/'.$email_address)}}">{{url('auth/activateverification/'.$email_address)}}</a>
	<p>Nuvem HR 1.0.1</p>
	<p>@2016 Nuvem Inc. All rights reserved.</p>
</form>

@endsection
