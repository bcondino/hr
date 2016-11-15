@extends('shared._public')

@section('title', 'Profile: Contact Information')

@section('styles')

@endsection

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-user"></span> <b> {{ ucwords($employee->last_name) }}, {{ ucwords($employee->first_name) }} </b> </h1>
		</div>
	</div>
</div>

<!-- employee profile -->
<div class="uk-container uk-container-center">
	<div class="categories">	
		<div class="uk-grid">
			<div class="uk-width-1-4">
				<ul class="uk-nav uk-nav-side">
                    <li> <a href="{{ url('employee/basicinformation/'. $employee->employee_id) }}"> Basic Information </a> </li>
                    <li class="uk-active"><a href="{{ url('employee/contactinformation/'. $employee->employee_id) }}"> Contact Information </a> </li>
                    <li><a href="{{ url('employee/employmentdetails/'. $employee->employee_id) }}"> Employment Details </a> </li>
                    <li><a href="{{ url('employee/governmentdetails/'. $employee->employee_id) }}"> Government Details </a> </li>
                    <li><a href="{{ url('employee/dependent/'. $employee->employee_id) }}"> Dependent </a> </li>
                    <li><a href="{{ url('employee/educbackground/'. $employee->employee_id) }}"> Educational Background </a> </li>
                    <li><a href="{{ url('employee/employmenthistory/'. $employee->employee_id) }}"> Employment History </a> </li>
				</ul>
			</div> <!-- list company setup-->

			<!-- basic information -->
			<div class="uk-width" style="width:75%;">

				<!-- alerts -->
				@if(Session::has('put-success'))
					<div class="uk-alert uk-alert-success">
						<span class="uk-icon uk-icon-check"></span> {{ Session::get('put-success') }}
					</div> 
				@endif

				<form class="uk-form uk-form-horizontal"  method="post" action="{{ url('employee/contactinformation/'.$employee->employee_id) }}" >
					{{ csrf_field() }}
					{{ Form::hidden('_method', 'put') }}
		        	<div class="uk-grid">
						<div class="uk-width-1-2">
						    <fieldset>
						        <div class="uk-form-row">
						        	<label class="uk-form-label">Address 1 :</label>
						        	<div class="uk-form-controls">
										<input type="text" class="form-control" name="put_address1" value="{{ $employee->address1 }}">
						        	</div>
						        </div>
						        <div class="uk-form-row">
						        	<label class="uk-form-label">Address 2 :</label>
						        	<div class="uk-form-controls">
										<input type="text" class="form-control" name="put_address2" value="{{ $employee->address2 }}">
						        	</div>
						        </div>
						        <div class="uk-form-row">
						        	<label class="uk-form-label">City / Municipality :</label>
						        	<div class="uk-form-controls">
										<input type="text" class="form-control" name="put_city" value="{{ $employee->city }}">
						        	</div>
						        </div>
						        <div class="uk-form-row">
						        	<label class="uk-form-label">Region / Province:</label>
						        	<div class="uk-form-controls">
										<input type="text" class="form-control" name="put_region" value="{{ $employee->region }}">
						        	</div>
						        </div>
						        <div class="uk-form-row">
						        	<label class="uk-form-label">Zip Code :</label>
						        	<div class="uk-form-controls">
										<input type="text" class="form-control" name="put_zip" value="{{ $employee->zip }}">
						        	</div>
						        </div>
						</div> <!-- first column -->
						<div class="uk-width-1-2">
						        <div class="uk-form-row">
						        	<label class="uk-form-label">Personal Email :</label>
						        	<div class="uk-form-controls">
										<input type="text" class="form-control" name="put_e_mail" value="{{ $employee->e_mail }}">
						        	</div>
						        </div>
						        <div class="uk-form-row">
						        	<label class="uk-form-label">Mobile Number :</label>
						        	<div class="uk-form-controls">
										<input type="text" class="form-control" name="put_mobile_no" value="{{ $employee->mobile_no }}">
						        	</div>
						        </div>						        
						        <div class="uk-form-row">
						        	<label class="uk-form-label">Telephone Number :</label>
						        	<div class="uk-form-controls">
										<input type="text" class="form-control" name="put_tel_no" value="{{ $employee->tel_no }}">
						        	</div>
						        </div>
						    </fieldset>
						</div> <!-- second column -->
					</div>
				    <div class="uk-text-right form-buttons">
				    	<button class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span> Save</button>
						<a href="{{ url('employee/employees') }}" class="uk-button uk-modal-close btn-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</a>
				    </div>
				</form>
		    </div>

		</div>
	</div>
</div>

@endsection

@section('scripts')

@endsection