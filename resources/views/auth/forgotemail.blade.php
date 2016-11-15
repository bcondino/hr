@extends('shared._public2')

@section('title', 'change password')

@section('styles')
	<link rel="stylesheet" href="{{ asset('logindesign/css/form-elements.css') }}">
	<link rel="stylesheet" href="{{ asset('logindesign/css/style.css') }}">
@endsection

@section('content')

<form role="form" action="{{ url('auth/changepassword2/'.$user_id) }}" method="get">
	{{ csrf_field() }}
	<p>You forgot your password!</p>
	<p>To change your existing password, please click the button below.</p>
	<button type="submit">Change</button>
	<p>If the button above doesn’t work, copy and paste the following link in your web browser</p>
	<a href="{{ url('auth/changepassword2/'.$user_id) }}"> {{ url('auth/changepassword2/'.$user_id) }}</a>
	<p>Nuvem HR 1.0.1</p>
	<p>@2016 Nuvem Inc. All rights reserved.</p>
</form>
@endsection
