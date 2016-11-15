@extends('shared._public')

@section('title', 'Admin')

@section('styles')

	<link rel="stylesheet" href="{{ asset('custom-style/css/homestyle.css') }}" />

<style>
	.form-control-custom {
		display: block;
		width: 100%;
		/* height: 25px; */
		padding: 6px 5px;
		line-height: 1.42857;
		color: #555;
		background-color: #FFF;
		background-image: none;
		border: 1px solid #CCC;
		border-radius: 4px;
	}
	
	.custom-pad-5a {
		padding: 3px 0;
	}
	
	.required-c {
		color: red;
	}
	
</style>

@endsection

@section('content')
<div class="content container-fluid"><!-- 
	<div class="row">
		<div class="col-md-2">
			<div class="row">
				<div class="text-center">
					<img src="{!! asset('img/paypal.png') !!}" />
				</div>
				<div class="text-center">
					company name
				</div>
			</div>
			<div class="row">
				@include('company_setup._nav')
			</div>		
		</div>
		<div class="col-md-10">
			<div class="row">
				Company Information
				<div class="form-group">
					<label for="comp_name">Company Name</label>
					<input type="text" class="" name="comp_name" id="comp_name" />
				</div>
				<div class="form-group">
					<label for="address">Address</label>
					<input type="text" class="" name="address" id="address" />
				</div>
				<div class="form-group">
					<label for="city">City</label>
					<input type="text" class="" name="city" id="city" />
				</div>
				<div class="form-group">
					<label for="region">Region</label>
					<input type="text" class="" name="region" id="region" />
				</div>
				<div class="form-group">
					<label for="zip">zip</label>
					<input type="text" class="" name="zip" id="zip" />
				</div>
				<div class="form-group">
					<label for="contact_no">Contact No.</label>
					<input type="text" class="" name="contact_no" id="contact_no" />
				</div>
			</div>
		</div>	
	</div> -->
<div id="parentVerticalTab">
				<ul class="resp-tabs-list hor_1">
					<li>Company Details</li>
					<li>Business Structure</li>
					<li>Location</li>
					<li>Employment Type</li>
					<li>Salary Grade</li>
					<li>Positions</li>
				</ul>
				
				<div class="resp-tabs-container hor_1">
					<!-- category 1 personal details -->
					<div>
						<form role="form">
							<div class="row col-md-12">
								<h4>Company Information </h4>
								<hr />
								@include('company_setup.details')
							</div>
							<!-- /.basic information -->
							<br />
							<div class="row col-md-12">
								<h4 class="custom-pad-10-top">Goverment Registration</h4>
								<hr />
								@include('company_setup.gov_det')
							</div>
							<!-- /.contact information -->
							<div class="btn-group custom-right" style="padding-top: 50px" role="group" aria-label="...">
								<button type="button" class="btn btn-primary">Save changes :)</button>
								<button type="button" class="btn btn-default">Clear</button>
								<button type="button" class="btn btn-default">Edit</button>
							</div>
						</form>
					</div> <!-- /.category 1 -->
					
					<!-- category 2 employment -->
					<div>
						<form role="form">
							<div class="row col-md-12">
								<h4>Employment Details</h4>
								<hr />
								
								<!-- /.employment detail -->
							</div>														
							<div class="btn-group custom-right" style="padding-top: 50px" role="group" aria-label="...">
								<button type="button" class="btn btn-primary">Save changes :)</button>
								<button type="button" class="btn btn-default">Clear</button>
							</div>
						</form>
					</div> <!-- /.category 2 -->
					
					<!-- category 3 Location -->
					<div>
						<h4>Location Details</h4>
						<hr />
						@include('company_setup.location')
					</div> <!-- /.category 3 -->
					
					<!-- category 4  -->
					<div>
						<h4>Employment Type Details</h4>
						<hr />
						@include('company_setup.emptype')
					</div> <!-- /.category 4 -->
					
					<!-- category 5 -->
					<div>
						<h4>Salary Grade Details</h4>
						<hr />
						@include('company_setup.sal_grade')
					</div> <!-- /.category 5 -->

					<div>
						<h4>Positions</h4>
						<hr />					
						@include('company_setup.position')	
					</div>
					
				</div> <!-- resp tabs list -->
				
			</div> <!-- parent vertical tab -->

</div>
@endsection

@section('scripts')

<script src="{{ asset('tab-style/js/easyResponsiveTabs.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {

        //Vertical Tab
        $('#parentVerticalTab').easyResponsiveTabs({
            type: 'vertical', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            closed: 'accordion', // Start closed if in accordion view
            tabidentify: 'hor_1', // The tab groups identifier
            activate: function(event) { // Callback function if tab is switched
                var $tab = $(this);
                var $info = $('#nested-tabInfo2');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });
    });
</script>
@endsection