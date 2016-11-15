@extends('shared._public')

@section('title', 'Profile: Educational Background')

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
                    <li><a href="{{ url('employee/governmentdetails/'. $employee->employee_id) }}"> Government Details </a> </li>
                    <li><a href="{{ url('employee/dependent/'. $employee->employee_id) }}"> Dependent </a> </li>
                    <li class="uk-active"><a href="{{ url('employee/educbackground/'. $employee->employee_id) }}"> Educational Background </a> </li>
                    <li><a href="{{ url('employee/employmenthistory/'. $employee->employee_id) }}"> Employment History </a> </li>
                </ul>
			</div> <!-- list company setup-->

			<!-- basic information -->
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

				<!-- dependent table -->
				<table id="educational" class="uk-table uk-table-hover uk-table-striped payroll--table">
					<thead class="payroll--table_header">
						<tr>
							<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
							<th>Education Level</th>
							<th>School</th>
							<th>Address</th>
							<th>Date Attended</th>
						</tr>
					</thead>
					<tbody>
						@foreach($educ_backs as $educ_back)
						<tr>
							<td><input type="checkbox" class="chk-educ_back" name="educ_backs[]" value="{{ $educ_back->educ_back_id }}"/></td>
							<td><a class="btn-edit" data-uk-modal="{target:'#edit'}"
							data-educ_back_id="{{ $educ_back->educ_back_id }}" 
							data-educ_type_id="{{ $educ_back->educ_type_id }}" 
							data-degree_earned="{{ $educ_back->degree_earned }}"  
							data-school_name="{{ $educ_back->school_name }}" 
							data-school_address="{{ $educ_back->school_address }}" 
							data-period_attended_from="{{ $educ_back->period_attended_from }}" 
							data-period_attended_to="{{ $educ_back->period_attended_to }}" >{{ ucwords(\App\tbl_educ_type_model::where('educ_type_id', $educ_back->educ_type_id)->first()->educ_type_name) }} </a></td>
							<td>{{ ucwords($educ_back->school_name) }}</td>
							<td>{{ ucwords($educ_back->school_address) }}</td>
							<td>{{ ucwords($educ_back->period_attended_from) }} @if($educ_back->period_attended_from != null or $educ_back->period_attended_to != null)-@endif {{ ucwords($educ_back->period_attended_to) }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- employee profile education background -->

<!-- add education background modal -->
<div id="add" class="uk-modal">
	<div class="uk-modal-dialog">
		<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Education Background</div>

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

		<form class="uk-form uk-form-horizontal" method="post" action="{{ url('employee/educbackground/'.$employee->employee_id) }}" >
			{{ csrf_field() }}
			<fieldset>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Education Level :</label>
					<div class="uk-form-controls">
						{{ Form::select('educ_type_id'
							, [null => '-- Select --'] + 
								\App\tbl_educ_type_model::
								lists('educ_type_name', 'educ_type_id')
								->toArray()
							, old('educ_type_id')
							, ['class' => 'form-control']) }}
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Name of School :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="school_name" value="{{ old('school_name') }}" />	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; School Address :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="school_address" value="{{ old('school_address') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Date Attended From:</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name = "period_attended_from" value="{{ old('period_attended_from') }}"/>	
						<caption>
							e.g June 1990
						</caption>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Date Attended To:</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name = "period_attended_to" value="{{ old('period_attended_to') }}"/>	
						<caption>
							e.g March 1994
						</caption>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Degree Earned :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name = "degree_earned" value="{{ old('degree_earned') }}"/>	
					</div>
				</div>
				<div class="uk-modal-footer uk-text-right form-buttons">
					<button  class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span>Save</button>
					<button type="button" class="uk-button uk-modal-close btn-cancel"><span class="uk-icon uk-icon-times-circle"> Cancel</button>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- /.add educational background -->

<!-- edit education background modal -->

<div id="edit" class="uk-modal">
	<div class="uk-modal-dialog">
		<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Edit Education Background</div>
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
		<form class="uk-form uk-form-horizontal" method="post" action="{{ url('employee/educbackground/'. $employee->employee_id) }}" >
			{{ csrf_field() }}
			{{ Form::hidden('_method', 'put') }}
			<fieldset>
				<input type="hidden" name="put_educ_back_id" id="educ_back_id" value="{{ old('put_educ_back_id') }}"> 
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Education Level :</label>
					<div class="uk-form-controls">
						{{ Form::select('put_educ_type_id'
							, \App\tbl_educ_type_model::
								lists('educ_type_name', 'educ_type_id')
								->toArray()
							, old('put_educ_type_id')
							, ['class' => 'form-control', 'id' => 'educ_type_id']) }}
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Name of School :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="put_school_name" id="school_name" value="{{ old('put_school_name') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; School Address :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="put_school_address" id="school_address" value="{{ old('put_school_address') }}"/>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Date Attended From:</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name = "put_period_attended_from" id="period_attended_from" value="{{ old('put_period_attended_from') }}"/>	
						<caption>
							e.g June 1990
						</caption>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Date Attended To:</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name = "put_period_attended_to" id="period_attended_to" value="{{ old('put_period_attended_to') }}"/>	
						<caption>
							 e.g March 1994
						</caption>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Degree Earned :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name = "put_degree_earned" id="degree_earned" value="{{ old('put_degree_earned') }}"/>	
					</div>
				</div>				
				<div class="uk-modal-footer uk-text-right form-buttons">
					<button  class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span>Save</button>
					<button type="button" class="uk-button uk-modal-close btn-cancel"><span class="uk-icon uk-icon-times-circle"> Cancel</button>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- /.edit educational background -->

<!-- delete dependent modal -->
<div id="delete" class="uk-modal">
    <div class="uk-modal-dialog">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-trash"></span>Delete Confirmation</div>
    	<div class="uk-margin uk-modal-content">
    		Are you sure you want to delete the selected records?
    	</div>
    	<form method="post" action="{{ url('employee/educbackground/'. $employee->employee_id) }}">
	    	{{ csrf_field() }}
	    	{{ Form::hidden('_method', 'put')}}
	    	{{ Form::hidden('isDelete', '1') }}
	    	<div id="div-del-chk-educback">
	    	</div>
		    <div class="uk-modal-footer uk-text-right form-buttons">
		    	<button id="btn-del" type="submit" class="uk-button btn-delete js-modal-confirm"><span class="uk-icon uk-icon-trash"></span> Delete</button>
		        <button type="button" class="uk-button uk-modal-close btn-cancel js-modal-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
		    </div>
		</form>	    
    </div>
</div> 
<!-- delete dependent modal -->


@endsection

@section('scripts')

<script type="text/javascript" language="javascript" src="{{asset('js/table.js')}}"></script>
<script type="text/javascript" class="init">
	$(document).ready(
		function() {
			$("#btn-del").click(function(){
				$(".chk-educ_back:checked").each(function(){
					$('#div-del-chk-educback').append('<input type="hidden" name="educbacks[]" value="'+ $(this).val() +'" />');
				});
			});

			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
			@elseif(Session::has('put-failed'))
				$(".btn-edit").click();
			@endif

			$(".btn-edit").click(function(){		
				$("#educ_back_id").val( $(this).attr('data-educ_back_id') );
				$("#educ_type_id").val( $(this).attr('data-educ_type_id') );
				$("#school_name").val( $(this).attr('data-school_name') );
				$("#school_address").val( $(this).attr('data-school_address') );
				$("#degree_earned").val( $(this).attr('data-degree_earned') );
				$("#period_attended_from").val( $(this).attr('data-period_attended_from') );
				$("#period_attended_to").val( $(this).attr('data-period_attended_to') );
			});

			var dataTable = $('#educational').DataTable({
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