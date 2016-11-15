@extends('shared._public')

@section('title', 'Movements')

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
					Movements of {{ ucwords($employee->last_name) }}, {{ ucwords($employee->first_name) }}
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
		<button type="button" class="uk-button" data-uk-modal="{target:'#delete'}"><span class="uk-icon uk-icon-plus-circle"></span> Delete</button>
	</div>

	<!-- company table -->
	<div class="categories">
		<table id="movementofemployee" class="uk-table uk-table-hover uk-table-striped payroll--table">
			<thead class="payroll--table_header">
				<tr>
					<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
					<th>Date Effective</th>
					<th>Remarks</th>
					<th>Business Unit</th>
					<th>Position</th>
					<th>Basic</th>
					<th>Salary Type</th>
					<th>Status</th>
					<th>Classification</th>
					<th>Active Flag</th>
				</tr>
			</thead>
			<tbody>
				@foreach($movementsofemployee as $movementofemployee)
					<tr>
						<td><input type="checkbox" class="chk-movementofemployee" name="movementsofemployee[]" value="{{ $movementofemployee->employee_id }}"/></td>
						<!-- 20161020 updated by Melvin Militante
							Reason: added salary type on the view
						-->
						<td><a  data-uk-modal="{target:'#edit'}" class="btn-edit"
								data-movement_id="{{ $movementofemployee->movement_id }}"
								data-company_id_from="{{ $movementofemployee->company_id_from }}"
								data-emp_status_from="{{ $movementofemployee->emp_status_from }}"
								data-business_unit_id_from="{{ $movementofemployee->business_unit_id_from }}"
								data-class_id_from="{{ $movementofemployee->class_id_from }}"
								data-position_id_from="{{ $movementofemployee->position_id_from }}"
								data-tax_code_from="{{ $movementofemployee->tax_code_from }}"
								data-grade_id_from="{{ $movementofemployee->grade_id_from }}"
								data-basic_from="{{ $movementofemployee->basic_from }}"
								data-company_id="{{ $movementofemployee->company_id }}"
								data-employee_status="{{ $movementofemployee->employee_status }}"
								data-business_unit_id="{{ $movementofemployee->business_unit_id }}"
								data-class_id="{{ $movementofemployee->class_id }}"
								data-position_id="{{ $movementofemployee->position_id }}"
								data-tax_code="{{ $movementofemployee->tax_code }}"
								data-grade_id="{{ $movementofemployee->grade_id }}"
								data-basic_amt="{{ $movementofemployee->basic_amt }}"
								data-salary_type="{{ $movementofemployee->salary_type }}"
								data-prepared_by="{{ $movementofemployee->prepared_by }}"
								data-recommend_by="{{ $movementofemployee->recommend_by }}"
								data-authorized_by="{{ $movementofemployee->authorized_by }}"
								data-effective_date="{{ DateTime::createFromFormat('Y-m-d', $movementofemployee->effective_date)->format('m/d/Y') }}"
						>{{ DateTime::createFromFormat('Y-m-d', $movementofemployee->effective_date)->format('m/d/Y') }}
						</td>
						
						<td>{{ $movementofemployee->remarks }}</td>
						<td>
						@if  ($movementofemployee-> business_unit_id != null )
							{{ \App\tbl_business_unit_model::where('business_unit_id',  $movementofemployee->business_unit_id)->first()->business_unit_name  }}
						@endif </td>
						<td>
						@if  ($movementofemployee-> position_id != null )
							{{\App\tbl_position_model::where('position_id',$movementofemployee->position_id )->first()->description }}
						@endif </td>
						<td>{{ $movementofemployee->basic_amt or null}} </td>
						
						<td>
							@if ($movementofemployee->salary_type == 'MO') Monthly
							@elseif ($movementofemployee->salary_type == 'DA') Daily
							@elseif ($movementofemployee->salary_type == 'HR') Hourly
							@else {{ null }}
							@endif
						</td>
						
						<td>
						@if  ($movementofemployee-> employee_status != null )
						{{\App\tbl_employee_type_model::where('emp_type_id',$movementofemployee->employee_status)->first()->emp_type_name }}
						@endif</td>
						<td>
						@if  ($movementofemployee-> class_id != null )
						{{ \App\tbl_classification_model::where('class_id',  $movementofemployee->class_id)->first()->class_name  }}
						@endif</td>
						<td>{{ $movementofemployee->active_flag or null}} </td>
							
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>


<!-- add modal -->
<div id="add" class="uk-modal">
    <div class="uk-modal-dialog modal-wide">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Movements</div>

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

        <form class="uk-form uk-form-horizontal" method="post" action="{{ url('employee/movementsofemployee/'.$movementofemployee->employee_id) }}">
        	{{csrf_field()}}
        	<div class="uk-grid">
				<div class="uk-width-1-2">
				    <fieldset>
						<div class="uk-form-row">
				        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Company </label>
				        	<div class="uk-form-controls">
				        		 {{ Form::select('company_id'
									 , [null => '-- Select --'] + 
                                       $company
                                            ->lists('company_name', 'company_id')
                                            ->toArray()
					        		, old('company_id')
                                    , ['class' =>'form-control']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Date Effectivity</label>
                            <div class="uk-form-controls date-calendar" data-uk-form-select>
                                <span class="uk-icon-calendar">
                                </span>
                                <input class="form-control" type="text" name="effective_date" data-uk-datepicker="{format:'MM/DD/YYYY'}" value="{{ old('effective_date') }}">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Employee Status </label>
				        	<div class="uk-form-controls">
				        		 {{ Form::select('emp_type_id'
									 , [null => '-- Select --'] + 
                                       $employee_types
                                            ->lists('emp_type_name', 'emp_type_id')
                                            ->toArray()
					        		, old('emp_type_id')
                                    , ['class' =>'form-control']) }}
				        	</div>
				        </div>
						 <div class="uk-form-row">
				        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Business Unit </label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('business_unit_id'
					        		, [null => '-- Select --'] +
					        			$buss_units
					        				->lists('business_unit_name', 'business_unit_id')
					        				->toArray()
					        		, old('business_unit_id')
					        		, ['class' => 'form-control']) }}
				        	</div>
				        </div>
						<div class="uk-form-row">
				        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Classification </label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('class_id'
					        		, [null => '-- Select --'] +
					        			$classifications
					        				->lists('class_name', 'class_id')
					        				->toArray()
					        		, old('class_id')
					        		, ['class' => 'form-control']) }}
				        	</div>
				        </div>
						
				        <div class="uk-form-row">
				        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Position </label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('position_id'
					        		, [null => '-- Select --'] +
					        			$positions
					        				->lists('description', 'position_id')
					        				->toArray()
					        		, old('position_id')
					        		, ['class' => 'form-control']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Tax Code </label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('tax_code'
					        		, [null => '-- Select --'] +
					        			$tax_codes
					        				->lists('description', 'tax_code')
					        				->toArray()
					        		, old('tax_code')
					        		, ['class' => 'form-control']) }}
				        	</div>
				        </div>
				     	
				    </div>
				<div class="uk-width-1-2">
						<div class="uk-form-row">
				        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Salary Grade</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('grade_id'
					        		, [null => '-- Select --'] +
					        			$sal_grades
					        				->lists('grade_name', 'grade_id')
					        				->toArray()
					        		, old('grade_id')
					        		, ['class' => 'form-control']) }}
				        	</div>
				        </div>
						
						<div class="uk-form-row">
				        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Basic Salary</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="basic_amt" value="{{ old('basic_amt') }}">
				        	</div>
				        </div>
						<div class="uk-form-row">
				        	<label class="uk-form-label"> Salary Type</label>
				        	<div class="uk-form-controls">
				        		<select name="put_salary_type">
									<option value="MO">Monthly</option>
									<option value="DA">Daily</option>
									<option value="HR">Hourly</option>
								</select>
				        	</div>
				        </div>
						<div class="uk-form-row">
				        	<label class="uk-form-label">Remarks</label>
				        	<div class="uk-form-controls">
				        		{{ Form::textarea('remarks','', ['rows' => 30]) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Prepared By</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('prepared_by'
									, [null => '-- Select --'] +
									$employee_list
					        		, old('employee_id')
									, ['class' => 'form-control']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Recommended By</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('recommend_by'
									, [null => '-- Select --'] +
									$employee_list
					        		, old('employee_id')
									, ['class' => 'form-control']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Authorized By</label>
				        	<div class="uk-form-controls">
				        	{{ Form::select('authorized_by'
									, [null => '-- Select --'] +
									$employee_list
					        		, old('employee_id')
									, ['class' => 'form-control']) }}
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

<!-- put modal -->
<div id="edit" class="uk-modal">
    <div class="uk-modal-dialog modal-wide">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>View Movements</div>

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

        <form class="uk-form uk-form-horizontal" method="post" action="{{ url('employee/movementsofemployee/'.$movementofemployee->employee_id) }}">
        	{{csrf_field()}}        	
			{{ Form::hidden('_method', 'put') }}
        	<div class="uk-grid">
				<div class="uk-width-1-2">
				    <fieldset>
						<input type="hidden" name="movement_id" id="movement_id" value="{{ old('movement_id') }}">
				         <div class="uk-form-row">
				        	<label class="uk-form-label">Date Effectivity</label>
                            <div class="uk-form-controls date-calendar" data-uk-form-select>
                                <span class="uk-icon-calendar">
                                </span>
                                <input class="form-control" type="text" name="put_effective_date" id="effective_date" data-uk-datepicker="{format:'MM/DD/YYYY'}" value="{{ old('effective_date') }}">
								
				        	</div>
				        </div>
						<div class="uk-form-row">
				        	<label class="uk-form-label"> Authorized By</label>
				        	<div class="uk-form-controls">
				        	{{ Form::select('put_authorized_by',
				        			$employee_list
				        			, $movementofemployee->authorized_by
				        			, ['class' => 'form-control', 'id' => 'authorized_by']) }}
									
				        	</div>
				        </div>
						<div class="uk-form-row">
				        	<label class="uk-form-label"> Company From</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('put_company_id_from',
				        			$company
				        				->lists('company_name', 'company_id')
				        				->toArray()
				        			, $movementofemployee->company_id_from
				        			, ['class' => 'form-control', 'id' => 'company_id_from']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"> Employee Status From</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('put_emp_status_from'
				        			, $employee_types ->
				        		
				        				lists('emp_type_name', 'emp_type_id')
				        				->toArray()
				        			, $movementofemployee->emp_status_from
				        			, ['class' => 'form-control', 'id' => 'emp_status_from']) }}
				        	</div>
				        </div>
						<div class="uk-form-row">
				        	<label class="uk-form-label"> Business Unit From</label>
				        	<div class="uk-form-controls">
							{{ Form::select('put_business_unit_id_from'
				        			, $buss_units
				        				->lists('business_unit_name', 'business_unit_id')
				        				->toArray()
				        			, $movementofemployee->business_unit_id_from
				        			, ['class' => 'form-control', 'id' => 'business_unit_id_from']) }}
				        	</div>
				        </div>
						<div class="uk-form-row">
				        	<label class="uk-form-label"> Classification From</label>
				        	<div class="uk-form-controls">
							{{ Form::select('put_class_id_from'
				        			, $classifications
				        				->lists('class_name', 'class_id')
				        				->toArray()
				        			, $movementofemployee->class_id_from
				        			, ['class' => 'form-control', 'id' => 'class_id_from']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"> Position From</label>
				        	<div class="uk-form-controls">
								{{ Form::select('put_position_id_from'
				        			, $positions
				        				->lists('description', 'position_id')
				        				->toArray()
				        			, $movementofemployee->position_id_from
				        			, ['class' => 'form-control', 'id' => 'position_id_from']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"> Tax Code From</label>
				        	<div class="uk-form-controls">
				        			{{ Form::select('put_tax_code_from'
				        			, $tax_codes
				        				->lists('description', 'tax_code')
				        				->toArray()
				        			, $movementofemployee->tax_code_from
				        			, ['class' => 'form-control', 'id' => 'tax_code_from']) }}
				        	</div>
				        </div>
						<div class="uk-form-row">
				        	<label class="uk-form-label">Salary Grade From</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('put_grade_id_from'
				        			, $sal_grades
				        				->lists('grade_name', 'grade_id')
				        				->toArray()
				        			, $movementofemployee->grade_id_from
				        			, ['class' => 'form-control', 'id' => 'grade_id_from']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"> Basic Salary From</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control"   id="basic_from" value="{{ old('basic_from') }}">
				        	</div>
				        </div>
				    </div>
				<div class="uk-width-1-2">
						<div class="uk-form-row">
				        	<label class="uk-form-label">Recommended By</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('put_recommend_by',
				        			$employee_list
				        			, $movementofemployee->recommend_by
				        			, ['class' => 'form-control', 'id' => 'recommend_by']) }}
							</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Prepared By</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('put_prepared_by',
				        			$employee_list
				        			, $movementofemployee->prepared_by
				        			, ['class' => 'form-control', 'id' => 'prepared_by']) }}
									
									
				        	</div>
				        </div>
						<div class="uk-form-row">
				        	<label class="uk-form-label"> Company To</label>
				        	<div class="uk-form-controls">
				        		
								{{ Form::select('put_company_id',
				        			$company
				        				->lists('company_name', 'company_id')
				        				->toArray()
				        			, $movementofemployee->company_id
				        			, ['class' => 'form-control', 'id' => 'company_id']) }}
									
									
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"> Employee Status To</label>
				        	<div class="uk-form-controls">
				        	{{ Form::select('put_emp_type_id'
				        			, $employee_types ->
				        		
				        				lists('emp_type_name', 'emp_type_id')
				        				->toArray()
				        			, $movementofemployee->employee_status
				        			, ['class' => 'form-control', 'id' => 'employee_status']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"> Business Unit To</label>
				        	<div class="uk-form-controls">
								 	{{ Form::select('put_business_unit_id'
				        			, $buss_units
				        				->lists('business_unit_name', 'business_unit_id')
				        				->toArray()
				        			, $movementofemployee->business_unit_id
				        			, ['class' => 'form-control', 'id' => 'business_unit_id']) }}
				        	</div>
				        </div>
						<div class="uk-form-row">
				        	<label class="uk-form-label"> Classification To</label>
				        	<div class="uk-form-controls">
								{{ Form::select('put_class_id'
				        			, $classifications
				        				->lists('class_name', 'class_id')
				        				->toArray()
				        			, $movementofemployee->class_id
				        			, ['class' => 'form-control', 'id' => 'class_id']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"> Position To</label>
				        	<div class="uk-form-controls">
								{{ Form::select('put_position_id'
				        			, $positions
				        				->lists('description', 'position_id')
				        				->toArray()
				        			, $movementofemployee->position_id
				        			, ['class' => 'form-control', 'id' => 'position_id']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"> Tax Code To</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('put_tax_code'
				        			, $tax_codes
				        				->lists('description', 'tax_code')
				        				->toArray()
				        			, $movementofemployee->tax_code
				        			, ['class' => 'form-control', 'id' => 'tax_code']) }}
				        	</div>
				        </div>
						<div class="uk-form-row">
				        	<label class="uk-form-label">Salary Grade To</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('put_grade_id'
				        			, $sal_grades
				        				->lists('grade_name', 'grade_id')
				        				->toArray()
				        			, $movementofemployee->grade_id
				        			, ['class' => 'form-control', 'id' => 'grade_id']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"> Basic Salary To</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="put_basic_amt" id="basic_amt"  value="{{ old('basic_amt') }}">
				        	</div>
				        </div>
						<div class="uk-form-row">
				        	<label class="uk-form-label"> Salary Type</label>
				        	<div class="uk-form-controls">
				        		<select name="put_salary_type" id="salary_type" value="{{ old('salary_type') }}">
									<option value="MO">Monthly</option>
									<option value="DA">Daily</option>
									<option value="HR">Hourly</option>
								</select>
				        	</div>
				        </div>
				    </div>
				    </fieldset>
				</div>
				<div class="uk-modal-footer uk-text-right form-buttons">
		    	<button class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span> Save</button>
				<button class="uk-button uk-modal-close btn-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
		    </div>
		    
		</form>
    </div>
</div> <!-- end: modal for add button -->

@endsection

@section('scripts')

<script type="text/javascript" language="javascript" src="{{asset('js/table.js')}}"></script>
<script type="text/javascript" class="init">
	$(document).ready(
		function() {

			$("#btn-del").click(function(){
				$(".chk-movement:checked").each(function(){
					$('#div-del-chk-employee').append('<input type="hidden" name="employees[]" value="'+ $(this).val() +'" />');
				});
			});

			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
			@elseif(Session::has('mass-failed'))
				UIkit.modal('#mass').show();
			@endif
			
			$(".btn-edit").click(function() {
				$("#movement_id").val( $(this).attr('data-movement_id') );
				$("#effective_date").val( $(this).attr('data-effective_date') );
				$("#authorized_by").val( $(this).attr('data-authorized_by') );
				$("#company_id_from").val( $(this).attr('data-company_id') );
				$("#emp_status_from").val( $(this).attr('data-emp_status_from') );
				$("#business_unit_id_from").val( $(this).attr('data-business_unit_id_from') );
				$("#class_id_from").val( $(this).attr('data-class_id_from') );
				$("#position_id_from").val( $(this).attr('data-position_id_from') );
				$("#tax_code_from").val( $(this).attr('data-tax_code_from') );
				$("#grade_id_from").val( $(this).attr('data-grade_id_from') );
				$("#basic_from").val( $(this).attr('data-basic_from') );
				
				$("#company_id").val( $(this).attr('data-company_id') );
				$("#employee_status").val( $(this).attr('data-employee_status') );
				$("#business_unit_id").val( $(this).attr('data-business_unit_id') );
				$("#class_id").val( $(this).attr('data-class_id') );
				$("#position_id").val( $(this).attr('data-position_id') );
				$("#tax_code").val( $(this).attr('data-tax_code') );
				$("#grade_id").val( $(this).attr('data-grade_id') );
				$("#basic_amt").val( $(this).attr('data-basic_amt') );
				$("#salary_type").val( $(this).attr('data-salary_type') );
				$("#prepared_by").val( $(this).attr('data-prepared_by') );
				$("#recommend_by").val( $(this).attr('data-recommend_by') );
				
				
			});
			
			var dataTable = $('#movementofemployee').DataTable({
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
