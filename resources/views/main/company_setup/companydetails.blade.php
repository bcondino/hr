@extends('shared._public')

@section('title', 'Setup: Company Details')

@section('styles')

@endsection

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-cogs"></span> <b>{{ ucwords($company->company_name) }}</b> </h1>
		</div>
	</div>
</div>

<!-- list company setup -->
<div class="uk-container uk-container-center">
	<div class="categories">
		<div class="uk-grid">
			<div class="uk-width-1-4">
				<ul class="uk-nav uk-nav-side">
					<li class="uk-active"><a href="{{ url('companies/details/'.$company->company_id) }}">Company Details</a></li>
					<li><a href="{{ url('companies/business_structure/'.$company->company_id) }}">Business Structure</a></li>
					<li><a href="{{ url('companies/locations/'.$company->company_id) }}">Location</a></li>
					<li><a href="{{ url('companies/employmenttypes/'.$company->company_id) }}">Employement Type</a></li>
					<li><a href="{{ url('companies/salarygrades/'.$company->company_id) }}">Salary Grade</a></li>
					<li><a href="{{ url('companies/classification/'.$company->company_id) }}">Classification</a></li>
					<li><a href="{{ url('companies/positions/'.$company->company_id) }}">Position</a></li>
				</ul>
			</div> <!-- list company setup-->
			
			<!-- company details -->
			<div class="uk-width" style="width:75%;">

				<!-- alerts -->
				@if(Session::has('put-success'))
					<div class="uk-alert-success">
						<span class="uk-icon uk-icon-check"></span> {{ Session::get('put-success') }}
					</div> </br>
				@elseif(Session::has('put-failed'))
					@if($errors->has())
						<div class="uk-alert-danger ">				
							@foreach ($errors->all() as $error)
								<p class="uk-text-left"> <span class="uk-icon-close"></span> {{ $error }} </p>
							@endforeach
						</div>
					@endif
				@endif

				<form class="uk-form uk-form-horizontal" method="post" action="{{ url('companies/details/'.$company->company_id) }}">
			    	{{ csrf_field() }}
			    	{{ Form::hidden('_method', 'put') }}
		        	<div class="uk-grid">
						<div class="uk-width-1-2">
						    <fieldset>
						        <h4 style="font-weight:bold;">Company Details</h4>
						        <div class="uk-form-row">
						        	<label class="uk-form-label">Company</label>
						        	<div class="uk-form-controls">
										<input type="text" class="form-control" placeholder="Company..." name="put_company_name" value="{{ ucwords($company->company_name) }}">
						        	</div>
						        </div>
						        <div class="uk-form-row">
						        	<label class="uk-form-label">Address</label>
						        	<div class="uk-form-controls">
										<input type="text" class="form-control" placeholder="Address..." name="put_address" value="{{ ucwords($company->address) }}">
						        	</div>
						        </div>
						        <div class="uk-form-row">
						        	<label class="uk-form-label">City</label>
						        	<div class="uk-form-controls">
										<input type="text" class="form-control" placeholder="City..." name="put_city" value="{{ ucwords($company->city) }}">
						        	</div>
						        </div>
						        <h4 style="font-weight:bold;">Government Registration</h4>
						        <div class="uk-form-row">
						        	<label class="uk-form-label">BIR</label>
						        	<div class="uk-form-controls">
										<input type="text" class="form-control" placeholder="BIR..." name="put_bir_reg_no" value="{{ $company->bir_reg_no }}">
						        	</div>
						        </div>
						        <div class="uk-form-row">
						        	<label class="uk-form-label">SSS</label>
						        	<div class="uk-form-controls">
										<input type="text" class="form-control" placeholder="SSS..." name="put_sss_no" value="{{ $company->sss_no }}">
						        	</div>
						        </div>
						        <div class="uk-form-row">
						        	<label class="uk-form-label">TIN</label>
						        	<div class="uk-form-controls">
										<input type="text" class="form-control" placeholder="TIN..." name="put_tin_no" value="{{ $company->tin_no }}">
						        	</div>
						        </div>
						</div> <!-- first column -->
						<div class="uk-width-1-2">
							<h4 style="font-weight:bold;"> &nbsp;</h4>
					        <div class="uk-form-row">
					        	<label class="uk-form-label">Region</label>
					        	<div class="uk-form-controls">
									<input type="text" class="form-control" placeholder="Region..." name="put_region" value="{{ ucwords($company->region) }}">
					        	</div>
					        </div>
					        <div class="uk-form-row">
					        	<label class="uk-form-label">Zip</label>
					        	<div class="uk-form-controls">
									<input type="text" class="form-control" placeholder="Zip..." name="put_zip" value="{{ ucwords($company->zip) }}">
					        	</div>
					        </div>
					        <div class="uk-form-row">
					        	<label class="uk-form-label">Contact Number</label>
					        	<div class="uk-form-controls">
									<input type="text" class="form-control" placeholder="Contact Number..." name="put_contact_no" value="{{ $company->contact_no }}">
					        	</div>
					        </div>
							<h4 style="font-weight:bold;"> &nbsp;</h4>
					        <div class="uk-form-row">
					        	<label class="uk-form-label">PhilHealth</label>
					        	<div class="uk-form-controls">
									<input type="text" class="form-control" placeholder="PhilHealth..." name="put_philhealth_no" value="{{ $company->philhealth_no }}">
					        	</div>
					        </div>
					        <div class="uk-form-row">
					        	<label class="uk-form-label">HDMF Number</label>
					        	<div class="uk-form-controls">
									<input type="text" class="form-control" placeholder="HDMF Number..." name="put_hdmf_no" value="{{ $company->hdmf_no }}">
					        	</div>
					        </div>
					        <div class="uk-form-row">
					        	<label class="uk-form-label">RDO Number</label>
					        	<div class="uk-form-controls">
									<input type="text" class="form-control" placeholder="RDO Number..." name="put_bir_rdo_no" value="{{ $company->bir_rdo_no }}">
					        	</div>
					        </div>					        					        					        
						    </fieldset>
						</div> <!-- second column -->
					</div>
				    <div class="uk-text-right form-buttons">
				    	<button type="submit" class="uk-button btn-save"><span class="uk-icon uk-icon-edit"></span> Save</button>
						<a href="{{url('home/admin/companysetup')}}" class="uk-button uk-modal-close btn-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</a>
				    </div>
				</form>
		    </div>
		</div>
	</div>
</div>

@endsection

@section('scripts')

@endsection