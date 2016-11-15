@extends('shared._public')

@section('title', 'Setup: Employement Type')

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
					<li><a href="{{ url('companies/locations/'.$company->company_id) }}">Location</a></li>
					<li class="uk-active"><a href="{{ url('companies/employmenttypes/'.$company->company_id) }}">Employement Type</a></li>
					<li><a href="{{ url('companies/salarygrades/'.$company->company_id) }}">Salary Grade</a></li>
					<li><a href="{{ url('companies/classification/'.$company->company_id) }}">Classification</a></li>
					<li><a href="{{ url('companies/positions/'.$company->company_id) }}">Position</a></li>
				</ul>
			</div> <!-- list company setup-->
			
			<!-- employement type -->
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

				<table id="employementtype" class="uk-table uk-table-hover uk-table-striped payroll--table">
					<thead class="payroll--table_header">
						<tr>
							<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
							<th>Employment Type</th>
							<th>Minimum Hour(s)</th>
							<th>Maximum Hour(s)</th>
						</tr>
					</thead>
					<tbody>
						@foreach($employement_types as $employement_type)
							<tr>
								<td><input type="checkbox" id="select_all" class="chk-employementtype" name="employementtypes[]" value="{{$employement_type->emp_type_id}}"/></td>
								<td><a class="btn_emptype" data-uk-modal="{target:'#edit'}"
									data-emp_type_id="{{$employement_type->emp_type_id}}"
									data-emp_type_name="{{$employement_type->emp_type_name}}"
									data-min_hrs="{{$employement_type->min_hrs}}"
									data-max_hrs="{{$employement_type->max_hrs}}">
									{{$employement_type->emp_type_name}} </a></td>
								<td>{{$employement_type->min_hrs}}</td>
								<td>{{$employement_type->max_hrs}}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
		    </div> <!-- employement type -->

		</div>
	</div>
</div>
<!-- list company setup -->

<!-- add employment type modal -->
<div id="add" class="uk-modal">
	<div class="uk-modal-dialog">
		<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Employement Type</div>	

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

		<form class="uk-form uk-form-horizontal" method="post" action="{{ url('companies/employmenttypes/'.$company->company_id) }}">
			<fieldset>
				{{ csrf_field() }}
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Employement Type :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Employement Type..." name="emp_type_name" value="{{ old('emp_type_name') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Minimum Hours :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Minimum Hours..." name="min_hrs" value="{{ old('min_hrs') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Maximum Hours :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Maximum Hours..." name="max_hrs" value="{{ old('max_hrs') }}"/>	
					</div>
				</div>
				<div class="uk-modal-footer uk-text-right form-buttons">
					<button class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span>Save</button>
					<button class="uk-button uk-modal-close btn-cancel" type="submit"><span class="uk-icon uk-icon-times-circle"> Cancel</button>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- /.add employment type modal -->

<!-- edit employment type modal -->
<div id="edit" class="uk-modal">
	<div class="uk-modal-dialog">
		<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Edit Employement Type</div>

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

		<form class="uk-form uk-form-horizontal" method="post" action="{{ url('companies/employmenttypes/'.$company->company_id) }}">
			<fieldset>
				{{ csrf_field() }}
				{{ Form::hidden('_method', 'put') }}
				<div class="uk-form-row">
					<input type="hidden" name="put_emp_type_id" id="emp_type_id" value="{{ old('put_emp_type_id') }}">
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Employement Type :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Employement Type..." name="put_emp_type_name" id="emp_type_name" value="{{ old('put_emp_type_name') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Minimum Hours :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Minimum Hours..." name="put_min_hrs" id="min_hrs" value="{{ old('put_min_hrs') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Maximum Hours :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Maximum Hours..." name="put_max_hrs" id="max_hrs" value="{{ old('put_max_hrs') }}"/>	
					</div>
				</div>
				<div class="uk-modal-footer uk-text-right form-buttons">
					<button class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span>Save</button>
					<button class="uk-button uk-modal-close btn-cancel" type="submit"><span class="uk-icon uk-icon-times-circle"> Cancel</button>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- /.edit employment type modal -->

<!-- start: modal for delete button -->
<div id="delete" class="uk-modal">
    <div class="uk-modal-dialog">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-trash"></span>Delete Confirmation</div>
    	<div class="uk-margin uk-modal-content">
    		Are you sure you want to delete the selected records?
    	</div>
    	<form method="post" action="{{ url('companies/employmenttypes/'.$company->company_id) }}">
	    	{{ csrf_field() }}
	    	{{ Form::hidden('_method', 'put') }}
	    	{{ Form::hidden('isDelete', '1') }}
	    	<div id="div-del-chk-emptype">
	    	</div>
		    <div class="uk-modal-footer uk-text-right form-buttons">
		    	<button id="btn-del" type="submit" class="uk-button btn-delete js-modal-confirm"><span class="uk-icon uk-icon-trash"></span> Delete</button>
		        <button type="button" class="uk-button uk-modal-close btn-cancel js-modal-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
		    </div>
		</form>	    
    </div>
</div> 
<!-- end: modal for delete button -->

@endsection

@section('scripts')

<script type="text/javascript" language="javascript" src="{{asset('js/table.js')}}"></script>
<script type="text/javascript" class="init">
	$(document).ready(
		function() {

			$("#btn-del").click(function(){
				$(".chk-employementtype:checked").each(function(){
					$('#div-del-chk-emptype').append('<input type="hidden" name="employmenttypes[]" value="'+ $(this).val() +'" />');
				});
			});

			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
			@elseif(Session::has('put-failed'))
				$(".btn_emptype").click();
			@endif

			$(".btn_emptype").click(function(){
				$("#emp_type_id").val($(this).attr('data-emp_type_id'));
				$("#emp_type_name").val($(this).attr('data-emp_type_name'));
				$("#min_hrs").val($(this).attr('data-min_hrs'));
				$("#max_hrs").val($(this).attr('data-max_hrs'));
			});		

			var dataTable = $('#employementtype').DataTable({
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