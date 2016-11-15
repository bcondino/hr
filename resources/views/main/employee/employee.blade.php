@extends('shared._public')

@section('title', 'Employees')

@section('styles')

@endsection

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title">
				<span class="uk-icon uk-icon-users"></span>
				<strong>
					Employees
				</strong>
			</h1>
		</div>
	</div>
</div>

<!-- content -->
<div class="uk-container uk-container-center">

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
		<button type="button" class="uk-button" data-uk-modal="{target:'#mass'}"><span class="uk-icon uk-icon-plus-circle"></span> Mass Upload</button>
		<button type="button" class="uk-button" data-uk-modal="{target:'#delete'}"><span class="uk-icon uk-icon-plus-circle"></span> Delete</button>
	</div>

	<!-- company table -->
	<div class="categories">
		<table id="employee" class="uk-table uk-table-hover uk-table-striped payroll--table">
			<thead class="payroll--table_header">
				<tr>
					<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
					<th>Employee Number</th>
					<th>Name</th>
					<th>Gender</th>
					<th>E-mail</th>
					<th>Mobile No.</th>
					<th>Date of Birth </th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				@foreach($employees as $employee)
					<tr>
						<td><input type="checkbox" class="chk-employee" name="employees[]" value="{{ $employee->employee_id }}"/></td>
						<td><a href="{{ url('employee/basicinformation/'.$employee->employee_id) }}" class="btn " >{{ $employee->employee_number }}</td>
						<td>{{ ucwords($employee->last_name) }}, {{ ucwords($employee->first_name) }}</td>
						<td>{{ ucwords($employee->gender) }} </td>
						<td>{{ $employee->e_mail }}</td>
						<td>{{ $employee->mobile_no }}</td>
						<td>{{ $employee->date_birth }}</td>
						<td>{{ $employee->active_flag }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<!-- add employee modal -->
<div id="add" class="uk-modal">
	<div class="uk-modal-dialog">
			<button class="uk-modal-close uk-close"></button>
	    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Employee</div>
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
			<form class="uk-form uk-form-horizontal" method="POST" action="{{url('employee/employees')}}">
				{{csrf_field()}}
				<fieldset>
					<div class="uk-form-row">
						<label class="uk-form-label"><span class="uk-text-danger">*</span> Employee Number :</label>
						<div class="uk-form-controls">
							<input type="text" class="form-control" name="employee_number" value="{{ old('employee_number') }}"/>
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label"><span class="uk-text-danger">*</span> Last Name :</label>
						<div class="uk-form-controls">
							<input type="text" class="form-control"  name="last_name" value="{{ old('last_name') }}"/>
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label"><span class="uk-text-danger">*</span> First Name :</label>
						<div class="uk-form-controls">
							<input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}"/>
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label"> &nbsp;&nbsp; Middle Name :</label>
						<div class="uk-form-controls">
							<input type="text" class="form-control" name="middle_name" value="{{ old('middle_name') }}" />
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label" > &nbsp;&nbsp; Gender :</label>
						<div class="uk-form-controls">
							{{ Form::select('gender'
								, [null => '-- Select --', 'M' => 'Male', 'F' => 'Female']
								, old('gender')
								, ['class' => 'form-control']) }}
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label"> &nbsp;&nbsp; Civil Status :</label>
						<div class="uk-form-controls">
							{{ Form::select('civil_stat'
								, [null => '-- Select --', 'S' => 'Single', 'M' => 'Married', 'W' => 'Widow', 'SP' => 'Seperated']
								, old('civi_stat')
								, ['class' => 'form-control']) }}
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label"> &nbsp;&nbsp; E-mail :</label>
						<div class="uk-form-controls">
							<input type="text" class="form-control" name="e_mail" value="{{ old('e_mail') }}"/>
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label"> &nbsp;&nbsp; Mobile Number :</label>
						<div class="uk-form-controls">
							<input type="text" class="form-control" name="mobile_no" value="{{ old('mobile_no') }}"/>
						</div>
					</div>
					<div class="uk-modal-footer uk-text-right form-buttons">
						<button type="submit" class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span>Save</button>
						<button type="button" class="uk-button uk-modal-close btn-cancel" type="submit"><span class="uk-icon uk-icon-times-circle"> Cancel</button>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div> <!-- /.add employee modal -->

<!-- mass employee modal -->
<div id="mass" class="uk-modal">
	<div class="uk-modal-dialog">
		<button class="uk-modal-close uk-close"></button>
		<div class="uk-modal-header"><span class="uk-icon uk-icon-plus-square"></span>Mass Upload for Employee</div>

	    	<!-- alerts -->
			@if(Session::has('mass-failed'))
				@if($errors->has())
					<div class="uk-alert uk-alert-danger ">
						@foreach ($errors->all() as $error)
							<p class="uk-text-left"> <span class="uk-icon-close"></span> {{ $error }} </p>
						@endforeach
					</div>
				@endif
			@endif

			<form role="form" action="{{ url('employee/importemployee') }}" method="post" class="uk-form uk-form-horizontal" enctype="multipart/form-data"> {{csrf_field()}}
				<fieldset>
			       <div class="uk-form-row">
					  	<label class="uk-form-label">Select File</label>
			        	<div class="uk-form-controls">
						    <div class="uk-form-file" value="">
						    	<button class="uk-button"><span class="uk-icon-file"></span>Select</button>
						    	<input id="import_emp_file" name="import_emp_file" type="file">
						    </div>
						</div>
			        </div>
			        <div class="uk-modal-footer uk-text-right form-buttons">
			        	<a href="{{ url('employee/exportemployee') }}" class="uk-button btn-downloadcsv" style="float:left;"><span class="uk-icon-download"></span>Download Template File</a>
						<button  class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span>Submit</button>
						<button type="button" class="uk-button uk-modal-close btn-cancel" ><span class="uk-icon uk-icon-times-circle"> Cancel</button>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div> <!-- /.mass employee modal -->

<!-- delete companies modal -->
<div id="delete" class="uk-modal">
    <div class="uk-modal-dialog">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-trash"></span>Delete Confirmation</div>
    	<div class="uk-margin uk-modal-content">
    		Are you sure you want to delete the selected records?
    	</div>
    	<form method="post" action="{{ url('employee/employees') }}">
	    	{{ csrf_field() }}
	    	{{ Form::hidden('_method', 'put') }}
	    	{{ Form::hidden('isDelete', '1') }}
	    	<div id="div-del-chk-employee">
	    	</div>
		    <div class="uk-modal-footer uk-text-right form-buttons">
		    	<button id="btn-del" type="submit" class="uk-button btn-delete js-modal-confirm"><span class="uk-icon uk-icon-trash"></span> Delete</button>
		        <button type="button" class="uk-button uk-modal-close btn-cancel js-modal-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
		    </div>
		</form>
    </div>
</div>
<!-- delete companies modal -->

@endsection

@section('scripts')

<script type="text/javascript" language="javascript" src="{{asset('js/table.js')}}"></script>
<script type="text/javascript" class="init">
	$(document).ready(
		function() {

			$("#btn-del").click(function(){
				$(".chk-employee:checked").each(function(){
					$('#div-del-chk-employee').append('<input type="hidden" name="employees[]" value="'+ $(this).val() +'" />');
				});
			});

			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
			@elseif(Session::has('mass-failed'))
				UIkit.modal('#mass').show();
			@endif

			var dataTable = $('#employee').DataTable({
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
