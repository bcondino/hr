@extends('shared._public')

@section('title', 'Change Password')

@section('styles')

@endsection

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-users"></span> Change Password </a></h1>
		</div>
	</div>
</div>

<!-- content -->
<div class="uk-container uk-container-center">
	<div class="button-container">
		<!-- alerts -->
		@if(Session::has('change-success'))
			<div class="uk-alert uk-alert-success">
				<span class="uk-icon uk-icon-check"></span> {{ Session::get('change-success') }}
			</div>
		@elseif(Session::has('change-failed'))
			<div class="uk-alert uk-alert-danger">
				<span class="uk-icon uk-icon-close"></span> {{ Session::get('change-failed') }}
			</div>
		@endif
	</div>
	<form class="uk-form uk-form-horizontal" action="{{ url('users/changepassword') }}" method="post">
		<fieldset>
			{{ csrf_field() }}
			<div class="uk-width-1-2">
				<input type="hidden" class="form-control" name="old_password" value="{{ $user->pwd }}"/>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> New Password :</label>
					<div class="uk-form-controls">
						<input type="password" class="form-control" placeholder="New Password..." name="new_password"/>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Confirm New Password :</label>
					<div class="uk-form-controls">
						<input type="password" class="form-control" placeholder="Confirm New Password..." name="confirm_new_password"/>
					</div>
				</div>
				<div class="uk-modal-footer uk-text-right form-buttons">
					<button class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span>Save</button>
				</div>
			</div>
		</fieldset>
	</form>
</div>
<!-- content -->

@endsection

@section('scripts')

@endsection