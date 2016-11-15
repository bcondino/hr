@extends('shared._public')

@section('title', 'Setup: Location')

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
<!-- header -->

<!-- list company setup -->
<div class="uk-container uk-container-center">
	<div class="categories">
		<div class="uk-grid">
			<div class="uk-width-1-4">
				<ul class="uk-nav uk-nav-side">
					<li><a href="{{ url('companies/details/'.$company->company_id) }}">Company Details</a></li>
					<li><a href="{{ url('companies/business_structure/'.$company->company_id) }}">Business Structure</a></li>
					<li class="uk-active"><a href="{{ url('companies/locations/'.$company->company_id) }}">Location</a></li>
					<li><a href="{{ url('companies/employmenttypes/'.$company->company_id) }}">Employement Type</a></li>
					<li><a href="{{ url('companies/salarygrades/'.$company->company_id) }}">Salary Grade</a></li>
					<li><a href="{{ url('companies/classification/'.$company->company_id) }}">Classification</a></li>
					<li><a href="{{ url('companies/positions/'.$company->company_id) }}">Position</a></li>
				</ul>
			</div> <!-- list company setup-->
			
			<!-- location -->
			<div class="uk-width" style="width:75%;">
				<!-- buttons -->
				<div class="button-container">
					<!-- alerts -->
					@foreach(['add','put','del'] as $msg)
						@if(Session::has($msg.'-success'))
							<div class="uk-alert uk-alert-success">
								<span class="uk-icon uk-icon-check"></span> {{ Session::get($msg.'-success') }}
							</div>
						@elseif(Session::has($msg.'-warning'))
							<div class="uk-alert uk-alert-warning">
								<span class="uk-icon uk-icon-warning"></span> {{ Session::get($msg.'-warning') }}
							</div>
						@endif
					@endforeach	
					<button type="button" class="uk-button btn-add" data-uk-modal="{target:'#add'}"><span class="uk-icon uk-icon-plus-circle"></span> Add</button>
					<button type="button" class="uk-button" data-uk-modal="{target:'#delete'}"><span class="uk-icon uk-icon-trash"></span>  Delete</button>
				</div>
					
				<table id="location" class="uk-table uk-table-hover uk-table-striped payroll--table">
					<thead class="payroll--table_header">
						<tr>
							<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
							<th>Location Code</th>
							<th>Location Name</th>
							<th>Address</th>
						</tr>
					</thead>
					<tbody>
						@foreach($locations as $location)
							<tr>
								<td><input type="checkbox" class="chk-location" name="locations[]" value="{{$location->location_id}}"/></td>
								<td><a class="btn_location" data-uk-modal="{target:'#edit'}" 
										data-location_id	= "{{$location->location_id}}"
										data-location_code	= "{{$location->location_code}}"
										data-location_name	= "{{$location->location_name}}"
										data-address		= "{{$location->address1}}"
										data-city			= "{{$location->city}}" >
										{{$location->location_code}}
									</a> </td>
								<td>{{$location->location_name}}</td>
								<td>{{$location->address1}}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
		    </div> <!-- location -->
		</div> <!-- grid -->
	</div> <!-- categories -->
</div> <!-- list company setup -->

<!-- add location modal -->
<div id="add" class="uk-modal">
	<div class="uk-modal-dialog">
		<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Location</div>

    	<!-- alerts -->
		@if(Session::has('add-failed'))
			@if($errors->has())
				<div class="uk-alert uk-alert-danger ">				
					@foreach ($errors->all() as $error)
						<p class="uk-text-left"> <span class="uk-icon-close"></span> {{ $error }} </p>
					@endforeach
				</div>
			@endif
		@endif

		<form class="uk-form uk-form-horizontal" method="post" action="{{ url('companies/locations/'. $company->company_id) }}">
			<fieldset>
				{{ csrf_field() }}
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Location Code :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Location Code..." name="location_code" value="{{ old('location_code') }}"/>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Location Name :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Location Name..." name="location_name" value="{{ old('location_name') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Address :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Address..." name="address" value="{{ old('address') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; City :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="City..." name="city" value="{{ old('city')}}"/>	
					</div>
				</div>
				<div class="uk-modal-footer uk-text-right form-buttons">
					<button class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span>Save</button>
					<button class="uk-button uk-modal-close btn-cancel" type="button"><span class="uk-icon uk-icon-times-circle"> Cancel</button>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- /.add location modal -->

<!-- edit location modal -->
<div id="edit" class="uk-modal">
	<div class="uk-modal-dialog">
		<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Edit Location</div>

    	<!-- alerts -->
		@if(Session::has('put-failed'))
			@if($errors->has())
				<div class="uk-alert uk-alert-danger ">				
					@foreach ($errors->all() as $error)
						<p class="uk-text-left"> <span class="uk-icon-close"></span> {{ $error }} </p>
					@endforeach
				</div>				
			@endif
		@endif

		<form class="uk-form uk-form-horizontal" method="post" action="{{ url('companies/locations/'.$company->company_id) }}">
			<fieldset>
				{{ csrf_field() }}
				{{ Form::hidden('_method', 'put') }}
				<input type="hidden" name="put_location_id" id="location_id" value="{{ old('put_location_id') }}"> 
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Location Code :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Location Code..." name="put_location_code" id="location_code" value="{{ old('put_location_code') }}" />
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Location Name :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Location Name..." name="put_location_name" id="location_name" value="{{ old('put_location_name') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Address :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Address..." name="put_address" id="address" value="{{ old('put_address') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; City :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="City..." name="put_city" id="city" value="{{ old('put_city')}}"/>	
					</div>
				</div>
				<div class="uk-modal-footer uk-text-right form-buttons">
					<button type="submit" class="uk-button btn-save"><span class="uk-icon uk-icon-edit"></span>Save</button>
					<button type="button" class="uk-button uk-modal-close btn-cancel"><span class="uk-icon uk-icon-times-circle"> Cancel</button>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- /.edit location modal -->

<!-- delete location modal -->
<div id="delete" class="uk-modal">
    <div class="uk-modal-dialog">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-trash"></span>Delete Confirmation</div>
    	<div class="uk-margin uk-modal-content">
    		Are you sure you want to delete the selected records?
    	</div>
    	<form method="post" action="{{ url('companies/locations/'.$company->company_id) }}">
	    	{{ csrf_field() }}
	    	{{ Form::hidden('_method', 'put') }}
	    	{{ Form::hidden('isDelete', '1') }}
	    	<div id="div-del-chk-loc">
	    	</div>
		    <div class="uk-modal-footer uk-text-right form-buttons">
		    	<button id="btn-del" type="submit" class="uk-button btn-delete js-modal-confirm"><span class="uk-icon uk-icon-trash"></span> Delete</button>
		        <button type="button" class="uk-button uk-modal-close btn-cancel js-modal-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
		    </div>
		</form>	    
    </div>
</div> 
<!-- delete location modal -->

@endsection

@section('scripts')


<script type="text/javascript" language="javascript" src="{{asset('js/table.js')}}"></script>
<script type="text/javascript" class="init">
	$(document).ready(
		function() {

			$("#btn-del").click(function(){
				$(".chk-location:checked").each(function(){
					$('#div-del-chk-loc').append('<input type="hidden" name="locations[]" value="'+ $(this).val() +'" />');
				});
			});

			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
			@elseif(Session::has('put-failed'))
				$(".btn_location").click();
			@endif

			$(".btn_location").click(function(){
				$("#location_id").val($(this).attr('data-location_id'));
				$("#location_code").val($(this).attr('data-location_code'));
				$("#location_name").val($(this).attr('data-location_name'));
				$("#address").val($(this).attr('data-address'));
				$("#city").val($(this).attr('data-city'));
			});

			var dataTable = $('#location').DataTable({
				order: [],
				columnDefs: [ { orderable: false, targets: [0] } ]
			});			

			$('#select_all').click(function () {
			 $(':checkbox', dataTable.rows().nodes()).prop('checked', this.checked);
			});

		}
	);
</script>

@endsection