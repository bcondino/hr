@extends('shared._public')

@section('title', 'Setup: Position')

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
					<li><a href="{{ url('companies/details/'.$company->company_id) }}">Company Details</a></li>
					<li><a href="{{ url('companies/business_structure/'.$company->company_id) }}">Business Structure</a></li>
					<li><a href="{{ url('companies/locations/'.$company->company_id) }}">Location</a></li>
					<li><a href="{{ url('companies/employmenttypes/'.$company->company_id) }}">Employement Type</a></li>
					<li><a href="{{ url('companies/salarygrades/'.$company->company_id) }}">Salary Grade</a></li>
					<li><a href="{{ url('companies/classification/'.$company->company_id) }}">Classification</a></li>
					<li class="uk-active"><a href="{{ url('companies/positions/'.$company->company_id) }}">Position</a></li>
				</ul>

			</div> <!-- list company setup-->
			
			<!-- position -->
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

				<table id="position" class="uk-table uk-table-hover uk-table-striped payroll--table">
					<thead class="payroll--table_header">
						<tr>
							<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
							<th>Position Code</th>
							<th>Position Name</th>
							<th>Business Unit</th>
							<th>Salary Grade</th>
							<th>Classification</th>
						</tr>					
					</thead>
					<tbody>
						@foreach($positions as $position)
							<tr>
								<td><input type="checkbox" class="chk-positions" name="positions[]" value="{{$position->position_id}}"></td>
								<td><a class="btn_position" data-uk-modal="{target:'#edit'}"
									data-position_id 		= "{{$position->position_id}}"
									data-description		= "{{$position->description}}"
									data-position_code		= "{{$position->position_code}}"
									data-business_unit_id	= "{{$position->business_unit_id}}"
									data-grade_id 			= "{{$position->grade_id}}"
									data-class_id			= "{{$position->class_id}}">
									{{ $position->position_code }} </a></td>
								<td>{{ $position->description }}</td>
								<td>{{ \App\tbl_business_unit_model::where('business_unit_id', $position->business_unit_id)->first()->business_unit_name}}</td>
								<td>{{ \App\tbl_salary_grade_model::where('grade_id', $position->grade_id)->first()->grade_name}}</td>
								<td>{{ \App\tbl_classification_model::where('class_id', $position->class_id)->first()->class_name}}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
		    </div> <!-- position -->

		</div>
	</div>
</div>

<!-- add position modal -->
<div id="add" class="uk-modal">
	<div class="uk-modal-dialog">
		<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Position</div>

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

		<form class="uk-form uk-form-horizontal" method="post" action="{{ url('companies/positions/'.$company->company_id) }}">
			<fieldset>
				{{ csrf_field() }}
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Position Code :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="position_code" value="{{ old('position_code') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Position Name :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="description" value="{{ old('description') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Business Unit :</label>
					<div class="uk-form-controls">
						{{ Form::select('business_unit_id'
							, [null => '-- Select --'] + 
								\App\tbl_business_unit_model::
									  where('active_flag', 'Y')
									->where('company_id', $company->company_id)
									->lists('business_unit_name', 'business_unit_id')->toArray()
							, old('business_unit_id')
							, array('class'=>'form-control')
							) }}
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Salary Grade :</label>
					<div class="uk-form-controls">
						{{ Form::select('grade_id'
							, [null => '-- Select --'] + 
								\App\tbl_salary_grade_model::
									  where('active_flag', 'Y')
									->where('company_id', $company->company_id)
									->lists('grade_name', 'grade_id')
									->toArray()
							, old('grade_id')
							, array('class'=>'form-control')
							) }}
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Classification :</label>
					<div class="uk-form-controls">
						{{ Form::select('class_id'
							, [null => '-- Select --'] + 
								\App\tbl_classification_model::
									  where('active_flag', 'Y')
									->where('company_id', $company->company_id)
									->orderBy('class_name')
									->lists('class_name', 'class_id')
									->toArray()
							, old('class_id')
							, array('class'=>'form-control')
							) }}
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
<!-- /.add salary grade modal -->

<!-- edit position modal -->
<div id="edit" class="uk-modal">
	<div class="uk-modal-dialog">
		<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Edit Position</div>

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

		<form class="uk-form uk-form-horizontal" method="post" action="{{ url('companies/positions/'.$company->company_id) }}">
			<fieldset>
				{{ csrf_field() }}
				{{ Form::hidden('_method', 'put') }}
				<input type="hidden" name="put_position_id" id="position_id" value="{{ old('put_position_id')}}">
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Position Code :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="put_position_code" id="position_code" value="{{ old('put_position_code') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Position Name :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="put_description" id="description" value="{{ old('put_description') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Business Unit :</label>
					<div class="uk-form-controls">
						{{ Form::select('put_business_unit_id'
							, \App\tbl_business_unit_model::
								  where('company_id', $company->company_id)
								->where('active_flag', 'Y')
								->lists('business_unit_name', 'business_unit_id')
								->toArray()
							, old('put_business_unit_id')
							, ['class'=>'form-control', 'id' => 'business_unit_id']
							) }}
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Salary Grade :</label>
					<div class="uk-form-controls">
						{{ Form::select('put_grade_id'
							, \App\tbl_salary_grade_model::
								  where('company_id', $company->company_id)
								->where('active_flag', 'Y')
								->lists('grade_name', 'grade_id')
								->toArray()
							, old('put_grade_id')
							, ['class'=>'form-control', 'id' => 'grade_id']
							) }}
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Classification :</label>
					<div class="uk-form-controls">
						{{ Form::select('put_class_id'
							, \App\tbl_classification_model::
									  where('company_id', $company->company_id)
								    ->where('active_flag', 'Y')
								    ->orderBy('class_name')
								    ->lists('class_name', 'class_id')
								    ->toArray()
							, old('put_class_id')
							, ['class'=>'form-control', 'id' => 'class_id']
							) }}
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
<!-- /.edit position modal -->

<!-- delete position modal -->
<div id="delete" class="uk-modal">
    <div class="uk-modal-dialog">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-trash"></span>Delete Confirmation</div>
    	<div class="uk-margin uk-modal-content">
    		Are you sure you want to delete the selected records?
    	</div>
    	<form method="post" action="{{ url('companies/positions/'.$company->company_id)}}">
	    	{{ csrf_field() }}
	    	{{ Form::hidden('_method', 'put') }}
	    	{{ Form::hidden('isDelete', '1') }}
	    	<div id="div-del-chk-pos">
	    	</div>
		    <div class="uk-modal-footer uk-text-right form-buttons">
		    	<button id="btn-del" type="submit" class="uk-button btn-delete js-modal-confirm"><span class="uk-icon uk-icon-trash"></span> Delete</button>
		        <button type="button" class="uk-button uk-modal-close btn-cancel js-modal-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
		    </div>
		</form>	    
    </div>
</div> 
<!-- delete position modal -->

@endsection

@section('scripts')

<script type="text/javascript" language="javascript" src="{{asset('js/table.js')}}"></script>
<script type="text/javascript" class="init">
	$(document).ready(
		function() {

			$("#btn-del").click(function(){
				$(".chk-positions:checked").each(function(){
					$('#div-del-chk-pos').append('<input type="hidden" name="positions[]" value="'+ $(this).val() +'" />');
				});
			});

			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
			@elseif(Session::has('put-failed'))
				$(".btn_position").click();
			@endif

			$(".btn_position").click(function(){
				$("#position_id").val($(this).attr('data-position_id'));			
				$("#position_code").val($(this).attr('data-position_code'));
				$("#description").val($(this).attr('data-description'));
				$("#business_unit_id").val($(this).attr('data-business_unit_id'));
				$("#grade_id").val($(this).attr('data-grade_id'));
				$("#class_id").val($(this).attr('data-class_id'));
			});

			var dataTable = $('#position').DataTable({
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