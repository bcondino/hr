@extends('shared._public')

@section('title', 'Profile: Employement History')

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
                    <li><a href="{{ url('employee/educbackground/'. $employee->employee_id) }}"> Educational Background </a> </li>
                    <li class="uk-active"><a href="{{ url('employee/employmenthistory/'. $employee->employee_id) }}"> Employment History </a> </li>
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

				<!-- employement history table -->
				<table id="emphistory" class="uk-table uk-table-hover uk-table-striped payroll--table">
					<thead class="payroll--table_header">
						<tr>
							<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
							<th>Company Name</th>
							<th>Employment Period</th>
							<th>Position Held</th>
						</tr>
					</thead>
					<tbody>
						@foreach($emp_hist as $emp_hist)
						<tr>
							<td><input type="checkbox" class="chk-emphistory" name="emphistories[]" value="{{ $emp_hist->emp_hist_id }}"/></td>
							<td><a  class="btn-edit" data-uk-modal="{target:'#edit'}"
							data-emp_hist_id="{{ $emp_hist->emp_hist_id }}"  
							data-company_name="{{ $emp_hist->company_name }}"  
							data-address="{{ $emp_hist->address }}" 
							data-period_attended_from="{{ $emp_hist->period_attended_from }}" 
							data-period_attended_to="{{ $emp_hist->period_attended_to }}" 
							data-position_held="{{ $emp_hist->position_held }}"> {{ ucwords($emp_hist->company_name) }} </a></td>
							<td>{{ $emp_hist->period_attended_from }} @if($emp_hist->period_attended_from != null and $emp_hist->period_attended_to != null) - @endif {{ $emp_hist->period_attended_to }}</td>
							<td>{{$emp_hist->position_held }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>

		</div>
	</div>
</div>
<!-- employee profile history -->

<!-- add emp_history background modal -->
<div id="add" class="uk-modal">
	<div class="uk-modal-dialog">
		<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Employement History</div>	

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

		<form class="uk-form uk-form-horizontal" method="post" action="{{ url('employee/employmenthistory/'. $employee->employee_id) }}">
			<fieldset>
				{{ csrf_field() }}
				<div class="uk-form-row">
					<label class="uk-form-label"> <span class="uk-text-danger">*</span> Company Name :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="company_name" value="{{ old('company_name') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Address :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="address" value="{{ old('address') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Position Held :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="position_held" value="{{ old('position_held') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; <strong>Employement Period</strong></label>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Period From:</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="period_attended_from"  value="{{ old('period_attended_from') }}"/>
						<caption>
							e.g March 2006
						</caption>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Period To:</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="period_attended_to" value="{{ old('period_attended_to') }}"/>	
						<caption>
							e.g March 2015
						</caption>
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
<!-- /.add emp_history background -->

<!-- edit emp_history background modal -->
<div id="edit" class="uk-modal">
	<div class="uk-modal-dialog">
		<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Edit Employement History</div>	

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

		<form class="uk-form uk-form-horizontal" method="post" action="{{ url('employee/employmenthistory/'. $employee->employee_id) }}">
			{{ csrf_field() }}
			{{ Form::hidden('_method', 'put') }}
			<fieldset>
				<input type="hidden" name="put_emp_hist_id" id="emp_hist_id" value="{{ old('put_emp_hist_id') }}"> 
				<div class="uk-form-row">
					<label class="uk-form-label"> <span class="uk-text-danger">*</span> Company Name :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="put_company_name" id="company_name" value="{{ old('put_company_name') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Address :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="put_address" id="address" value="{{ old('put_address') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Position Held :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="put_position_held" id="position_held" value="{{ old('put_position_held') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; <strong>Employement Period</strong></label>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Period From:</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="put_period_attended_from"  id="period_attended_from" value="{{ old('put_period_attended_from') }}"/>	
						<caption>
							e.g March 2006
						</caption>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Period To:</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="put_period_attended_to" id="period_attended_to" value="{{ old('put_period_attended_to') }}"/>	
						<caption>
							e.g March 2015
						</caption>
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
<!-- /.edit emp_history background -->

<!-- delete dependent modal -->
<div id="delete" class="uk-modal">
    <div class="uk-modal-dialog">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-trash"></span>Delete Confirmation</div>
    	<div class="uk-margin uk-modal-content">
    		Are you sure you want to delete the selected records?
    	</div>
    	<form method="post" action="{{ url('employee/employmenthistory/'. $employee->employee_id) }}">
	    	{{ csrf_field() }}
	    	{{ Form::hidden('_method', 'put') }}
	    	{{ Form::hidden('isDelete', '1') }}
	    	<div id="div-del-chk-emphistory">
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
				$(".chk-emphistory:checked").each(function(){
					$('#div-del-chk-emphistory').append('<input type="hidden" name="emphistories[]" value="'+ $(this).val() +'" />');
				});
			});

			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
			@elseif(Session::has('put-failed'))
				$(".btn-edit").click();
			@endif

			$(".btn-edit").click(function(){
				$("#emp_hist_id").val( $(this).attr('data-emp_hist_id') );
				$("#company_name").val( $(this).attr('data-company_name') );
				$("#address").val( $(this).attr('data-address') );
				$("#period_attended_from").val( $(this).attr('data-period_attended_from'));
				$("#period_attended_to").val( $(this).attr('data-period_attended_to'));
				$("#position_held").val( $(this).attr('data-position_held') );
				
			});

			var dataTable = $('#emphistory').DataTable({
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