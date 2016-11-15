@extends('shared._public')

@section('title', 'Company Setup')

@section('styles')

@endsection

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-cogs"></span> Company Setup </a></h1>
		</div>
	</div>
</div>


<!-- list company setup -->
<div class="uk-container uk-container-center">
	<div class="categories">

	<div class="uk-grid">
		<div class="uk-width-1-4">
			<ul class="uk-nav uk-nav-side">
				<!-- class="uk-active" -->
				<li><a href="{{ url('home/admin/companysetup/details') }}">Company Details</a></li>
				<li><a href="{{ url('home/admin/companysetup/businessstructure') }}">Business Structure</a></li>
				<li><a href="{{ url('home/admin/companysetup/location') }}">Location</a></li>
				<li><a href="{{ url('home/admin/companysetup/employmenttype') }}">Employement Type</a></li>
				<li><a href="{{ url('home/admin/companysetup/salarygrade') }}">Salary Grade</a></li>
				<li><a href="{{ url('home/admin/companysetup/position') }}">Position</a></li>
			</ul>
		</div> <!-- list company setup-->
		
		<!-- company details -->
		<div class="uk-width" style="width:75%;">
			<form class="uk-form uk-form-horizontal" >
	        	<div class="uk-grid">
					<div class="uk-width-1-2">
					    <fieldset>
					        <h4 style="font-weight:bold;">Company Details</h4>
					        <div class="uk-form-row">
					        	<label class="uk-form-label">*Company</label>
					        	<div class="uk-form-controls">
									<input type="text" class="form-control" placeholder="Company...">
					        	</div>
					        </div>
					        <div class="uk-form-row">
					        	<label class="uk-form-label">Address</label>
					        	<div class="uk-form-controls">
									<input type="text" class="form-control" placeholder="Address...">
					        	</div>
					        </div>
					        <div class="uk-form-row">
					        	<label class="uk-form-label">City</label>
					        	<div class="uk-form-controls">
									<input type="text" class="form-control" placeholder="City...">
					        	</div>
					        </div>
					        <h4 style="font-weight:bold;">Government Registration</h4>
					        <div class="uk-form-row">
					        	<label class="uk-form-label">BIR</label>
					        	<div class="uk-form-controls">
									<input type="text" class="form-control" placeholder="BIR...">
					        	</div>
					        </div>
					        <div class="uk-form-row">
					        	<label class="uk-form-label">SSS</label>
					        	<div class="uk-form-controls">
									<input type="text" class="form-control" placeholder="SSS...">
					        	</div>
					        </div>
					        <div class="uk-form-row">
					        	<label class="uk-form-label">TIN</label>
					        	<div class="uk-form-controls">
									<input type="text" class="form-control" placeholder="TIN...">
					        	</div>
					        </div>
					</div> <!-- first column -->
					<div class="uk-width-1-2">
						<h4 style="font-weight:bold;"> &nbsp;</h4>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Region</label>
				        	<div class="uk-form-controls">
								<input type="text" class="form-control" placeholder="Region...">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Zip</label>
				        	<div class="uk-form-controls">
								<input type="text" class="form-control" placeholder="Zip...">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Contact Number</label>
				        	<div class="uk-form-controls">
								<input type="text" class="form-control" placeholder="Contact Number...">
				        	</div>
				        </div>
						<h4 style="font-weight:bold;"> &nbsp;</h4>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">PhilHealth</label>
				        	<div class="uk-form-controls">
								<input type="text" class="form-control" placeholder="PhilHealth...">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">HDMF Number</label>
				        	<div class="uk-form-controls">
								<input type="text" class="form-control" placeholder="HDMF Number...">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">RDO Number</label>
				        	<div class="uk-form-controls">
								<input type="text" class="form-control" placeholder="RDO Number...">
				        	</div>
				        </div>					        					        					        
					    </fieldset>
					</div> <!-- second column -->
				</div>
			    <div class="uk-modal-footer uk-text-right form-buttons">
			    	<button class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span> Save</button>
					<button class="uk-button uk-modal-close btn-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
			    </div>
			</form>
	    </div>

	    <div class=""
	</div>
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

		$(".btn-edit-location").click(function(){
			$("#edit_location_id").val($(this).attr('data-location_id'));
			$("#edit_location_code").val($(this).attr('data-location_code'));
			$("#edit_location_name").val($(this).attr('data-location_name'));
			$("#edit_address").val($(this).attr('data-address'));
			$("#edit_city").val($(this).attr('data-city'));
		});	

		$(".btn-edit-emptype").click(function(){
			$("#edit_emp_type_id").val($(this).attr('data-emp_type_id'));
			$("#edit_emp_type_name").val($(this).attr('data-emp_type_name'));
			$("#edit_min_hrs").val($(this).attr('data-min_hrs'));
			$("#edit_max_hrs").val($(this).attr('data-max_hrs'));
		});	

		$(".btn-edit-salgrade").click(function(){
			$("#edit_grade_id").val($(this).attr('data-grade_id'));			
			$("#edit_grade_name").val($(this).attr('data-grade_name'));
			$("#edit_minimum_salary").val($(this).attr('data-minimum_salary'));
			$("#edit_maximum_salary").val($(this).attr('data-maximum_salary'));
		});

		$(".btn-edit-position").click(function(){
			$("#edit_position_id").val($(this).attr('data-position_id'));			
			$("#edit_position_code").val($(this).attr('data-position_code'));
			$("#edit_description").val($(this).attr('data-description'));
		});	

	 $("#btn-del").click(function(){
        $(".chk-loc:checked").each(function(){
          	$('#div-del-inp').append('<input type="hidden" name="location[]" value="'+ $(this).val() +'" />');
        });
    });

    });
</script>
@endsection