@extends('shared._public')

@section('title', 'Dependent')

@section('styles')

@endsection

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-user"></span> <strong> {{ ucwords($employee->last_name) }}, {{ ucwords($employee->first_name) }} </strong> </h1>
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
                    <li class="uk-active"><a href="{{ url('employee/dependent/'. $employee->employee_id) }}"> Dependent </a> </li>
                    <li><a href="{{ url('employee/educbackground/'. $employee->employee_id) }}"> Educational Background </a> </li>
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
				<table id="dependent" class="uk-table uk-table-hover uk-table-striped payroll--table">
					<thead class="payroll--table_header">
						<tr>
							<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
							<th>Dependent Name</th>
							<th>Relationship</th>
							<th>Date of Birth</th>
							<th>Beneficiary</th>
							<th>Tax Dependent</th>
						</tr>
					</thead>
					<tbody>
						@foreach($dependents as $dependent)
							<tr>
								<td><input type="checkbox" class="chk-dependent" name="dependents[]" value="{{ $dependent->dependent_id }}"/></td>
								<td><a class="btn-edit" data-uk-modal="{target:'#edit'}"
									data-dependent_id="{{ $dependent->dependent_id }}"
									data-dependent_type="{{ $dependent->dependent_type }}"
									data-last_name="{{ $dependent->last_name }}"
									data-first_name="{{$dependent->first_name }}"
									data-mid_name="{{$dependent->mid_name }}"
									data-date_birth="{{$dependent->date_birth }}"
									data-civil_stat="{{$dependent->civil_stat }}"
									data-gender="{{$dependent->gender }}"
									data-address="{{$dependent->address }}"
									data-occupation="{{$dependent->occupation }}"
									data-is_benef="{{$dependent->is_benef }}" 
									data-is_tax_dep="{{$dependent->is_tax_dep }}">
								{{ ucwords($dependent->last_name) }}, {{ ucwords($dependent->first_name) }} </a></td>
								<td>{{ ucwords(\App\tbl_dep_type_model::where('dependent_type_id',$dependent->dependent_type)->first()->dependent_type_name) }}</td>
								<td>{{ $dependent->date_birth}}</td>
								<td>{{ $dependent->is_benef == 'Y'? 'Yes' : 'No' }}</td>
								<td>{{ $dependent->is_tax_dep == 'Y'? 'Yes' : 'No' }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>

		</div>
	</div>
</div>
<!-- employee profile dependent-->

<!-- add modal -->
<div id="add" class="uk-modal">
    <div class="uk-modal-dialog modal-wide">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Dependents</div>

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

        <form class="uk-form uk-form-horizontal" method="post" action="{{ url('employee/dependent/'.$employee->employee_id) }}">
        	{{csrf_field()}}
        	<div class="uk-grid">
				<div class="uk-width-1-2">
				    <fieldset>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Last Name</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" >
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"><span class="uk-text-danger">*</span> First Name</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"> &nbsp;&nbsp; Middle Name</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="mid_name" value="{{ old('mid_name') }}">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Dependent Type</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('dependent_type_id'
				        			, [null => '-- Select --'] + 
				        				\App\tbl_dep_type_model::
				        					orderBy('dependent_type_name')
				        					->lists('dependent_type_name', 'dependent_type_id')
				        					->toArray()
				        			, old('dependent_type_id')
				        			, ['class' => 'form-control']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"> &nbsp;&nbsp; Gender</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('gender'
				        			, [null => '-- Select --', 'M' => 'Male', 'F' => 'Female']
				        			, old('gender')
				        			, ['class' => 'form-control']) }}
				        	</div>
				        </div>
				    </div>
				<div class="uk-width-1-2">
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Civil Status</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('civil_stat'
				        			, [null => '-- Select --', 'S' => 'Single', 'M' => 'Married', 'W' => 'Widow']
				        			, old('civil_stat')
				        			, ['class' => 'form-control']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Date of Birth</label>
				        	<div class="uk-form-controls date-calendar" data-uk-form-select>
								<span class="uk-icon-calendar"></span>
								<input class="form-control" type="text" name="date_birth" data-uk-datepicker="{format:'DD/MM/YYYY'}" value="{{ old('date_birth') }}" >
							</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Address</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="address" value="{{ old('address') }}">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Occupation</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="occupation" value="{{ old('occupation') }}">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Is Beneficial</label>
				        	<div class="uk-form-controls">		
							{{ Form::select('is_benef'
								, [null => '-- Select --', 'Y' => 'Yes', 'N' => 'No']
								, old('is_benef')
								, ['class'=>'form-control']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Is Tax Dependent</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('is_tax_dep'
				        			, [null => '-- Select --', 'Y' => 'Yes', 'N' => 'No']
				        			, old('is_tax_dep')
				        			, ['class'=>'form-control']) }}
				        	</div>
				        </div>
				    </fieldset>
				</div>
			</div>
		    <div class="uk-modal-footer uk-text-right form-buttons">
		    	<button class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span> Save</button>

			        <button class="uk-button uk-modal-close btn-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
		    </div>
		</form>
    </div>
</div> <!-- end: modal for add button -->

<!-- edit modal -->
<div id="edit" class="uk-modal">
    <div class="uk-modal-dialog modal-wide">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Edit Dependents</div>

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

        <form class="uk-form uk-form-horizontal" method="post" action="{{ url('employee/dependent/'. $employee->employee_id) }} " >
        	{{ csrf_field() }}
        	{{ Form::hidden('_method', 'put') }}
        	<div class="uk-grid">
				<div class="uk-width-1-2">
				    <fieldset>
				    	<input type="hidden" name="put_dependent_id" id="dependent_id" value="{{ old('put_dependent_id') }}"> 
				        <div class="uk-form-row">
				        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Last Name</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="put_last_name" id="last_name" value="{{ old('put_last_name') }}" >
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"><span class="uk-text-danger">*</span> First Name</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="put_first_name" id="first_name" value="{{ old('put_first_name') }}">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"> &nbsp;&nbsp; Middle Name</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="put_mid_name" id="mid_name" value="{{ old('put_mid_name') }}">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"> &nbsp;&nbsp; Dependent Type</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('put_dependent_type'
				        			, \App\tbl_dep_type_model::
				        				orderBy('dependent_type_name')
				        				->lists('dependent_type_name', 'dependent_type_id')
				        				->toArray()
				        			, old('put_dependent_type')
				        			, ['class' => 'form-control', 'id' => 'dependent_type']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"> &nbsp;&nbsp; Gender</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('put_gender'
				        			, ['M' => 'Male', 'F' => 'Female']
				        			, old('put_gender')
				        			, ['class' => 'form-control', 'id' => 'gender']) }}
				        	</div>
				        </div>
				    </div>
				<div class="uk-width-1-2">
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Civil Status</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('put_civil_stat'
				        			, ['S' => 'Single', 'M' => 'Married', 'W' => 'Widow']
				        			, old('put_civil_stat')
				        			, ['class' => 'form-control', 'id' => 'gender']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Date of Birth</label>
				        	<div class="uk-form-controls date-calendar" data-uk-form-select>
								<span class="uk-icon-calendar"></span>
								<input class="form-control" type="text" name="put_date_birth" id="date_birth" data-uk-datepicker="{format:'DD/MM/YYYY'}" value="{{ old('put_date_birth') }}" >
							</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Address</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="put_address" id="address" value="{{ old('put_address') }}">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Occupation</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="put_occupation" id="occupation" value="{{ old('put_occupation') }}">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Is Beneficial</label>
				        	<div class="uk-form-controls">			
							{{ Form::select('put_is_benef'
								, ['Y' => 'Yes', 'N' => 'No']
								, old('put_is_benef')
								, ['class'=>'form-control', 'id' => 'is_benef']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Is Tax Dependent</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('put_is_tax_dep'
				        			, ['Y' => 'Yes', 'N' => 'No']
				        			, old('put_is_tax_dep')
				        			, ['class'=>'form-control', 'id' => 'is_tax_dep']) }}
				        	</div>
				        </div>
				    </fieldset>
				</div>
			</div>
		    <div class="uk-modal-footer uk-text-right form-buttons">
		    	<button class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span> Save</button>
				<button class="uk-button uk-modal-close btn-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
		    </div>
		</form>
    </div>
</div> <!-- end: modal for edit button -->


<!-- delete dependent modal -->
<div id="delete" class="uk-modal">
    <div class="uk-modal-dialog">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-trash"></span>Delete Confirmation</div>
    	<div class="uk-margin uk-modal-content">
    		Are you sure you want to delete the selected records?
    	</div>
    	<form method="post" action="{{ url('employee/dependent/'. $employee->employee_id) }}">
	    	{{ csrf_field() }}
	    	{{ Form::hidden('_method', 'put') }}
	    	{{ Form::hidden('isDelete', '1') }}
	    	<div id="div-del-chk-dependent">
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
				$(".chk-dependent:checked").each(function(){
					$('#div-del-chk-dependent').append('<input type="hidden" name="dependents[]" value="'+ $(this).val() +'" />');
				});
			});

			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
			@elseif(Session::has('put-failed'))
				$(".btn-edit").click();
			@endif

			$(".btn-edit").click(function() {
				$("#dependent_id").val( $(this).attr('data-dependent_id') );
				$("#dependent_type").val( $(this).attr('data-dependent_type') );
				$("#last_name").val( $(this).attr('data-last_name') );
				$("#first_name").val( $(this).attr('data-first_name') );
				$("#mid_name").val( $(this).attr('data-mid_name') );
				$("#date_birth").val( $(this).attr('data-date_birth') );
				$("#civil_stat").val( $(this).attr('data-civil_stat') );
				$("#gender").val( $(this).attr('data-gender') );
				$("#address").val( $(this).attr('data-address') );
				$("#occupation").val( $(this).attr('data-occupation') );
				$("#is_benef").val( $(this).attr('data-is_benef') );
				$("#is_tax_dep").val( $(this).attr('data-is_tax_dep') );
			});

			var dataTable = $('#dependent').DataTable({
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