@extends('shared._public')

@section('title', 'Profile: Government Details')

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
                    <li><a href="{{ url('employee/contactinformation/'. $employee->employee_id) }}"> Contact Information </a> </li>
                    <li><a href="{{ url('employee/employmentdetails/'. $employee->employee_id) }}"> Employment Details </a> </li>
                    <li class="uk-active"><a href="{{ url('employee/governmentdetails/'. $employee->employee_id) }}"> Government Details </a> </li>
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
	                    <span class="uk-icon uk-icon-check">
	                    </span>
	                    {{ Session::get('put-success') }}
	                </div>
		        @endif

				<form class="uk-form uk-form-horizontal" method="post" action="{{url('employee/governmentdetails/'. $employee->employee_id) }}" >
					{{ csrf_field() }}
					{{ Form::hidden('_method', 'put') }}
		        	<div class="uk-grid">
						<div class="uk-width-1-2">
						    <fieldset>
						        <div class="uk-form-row">
						        	<label class="uk-form-label">SSS</label>
						        	<div class="uk-form-controls">
										<input type="text" class="form-control" name="put_sss_no" placeholder="SSS..." value="{{ $employee->sss_no }}">
						        	</div>
						        </div>
						        <div class="uk-form-row">
						        	<label class="uk-form-label">TIN</label>
						        	<div class="uk-form-controls">
										<input type="text" class="form-control" name="put_tin_no" placeholder="TIN..." value="{{ $employee->tin_no }}">
									</div>
						        </div>
						        <div class="uk-form-row">
						        	<label class="uk-form-label">PhilHealth</label>
						        	<div class="uk-form-controls">
										<input type="text" class="form-control" name="put_philhealth_no" placeholder="PhilHealth..."  value="{{ $employee->philhealth_no }}">
						        	</div>
						        </div>
						</div> <!-- first column -->
						<div class="uk-width-1-2">
						        <div class="uk-form-row">
						        	<label class="uk-form-label">HDMF</label>
						        	<div class="uk-form-controls">
										<input type="text" class="form-control" name="put_hdmf_no" placeholder="HDMF..." value="{{ $employee->hdmf_no }}">
						        	</div>
						        </div>
						        <div class="uk-form-row">
						        	<label class="uk-form-label">RDO</label>
						        	<div class="uk-form-controls">
										<input type="text" class="form-control"  name="put_rdo_no" placeholder="RDO..." value="{{ $employee->rdo_no }}">
						        	</div>
						        </div>
						        <div class="uk-form-row">
						        	<label class="uk-form-label">Tax Code</label>
						        	<div class="uk-form-controls">
						        		{{ Form::select('put_tax_code'
						        			, [null => '-- Select --'] + \App\tbl_tax_code_model::
						        				  where('company_id', $employee->company_id)
						        				->where('active_flag', 'Y')
						        				->lists('tax_code', 'tax_code')
						        				->toArray()
						        			, $employee->tax_code
						        			, ['class' => 'form-control']) }}
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