@extends('shared._public')

@section('title', 'Setup: Salary Grade')

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
					<li><a href="{{ url('companies/employmenttypes/'.$company->company_id) }}">Employement Type</a></li>
					<li class="uk-active"><a href="{{ url('companies/salarygrades/'.$company->company_id) }}">Salary Grade</a></li>
					<li><a href="{{ url('companies/classification/'.$company->company_id) }}">Classification</a></li>
					<li><a href="{{ url('companies/positions/'.$company->company_id) }}">Position</a></li>
				</ul>
			</div> <!-- list company setup-->
			
			<!-- salary grade -->
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
				
				<table id="salarygrade" class="uk-table uk-table-hover uk-table-striped payroll--table">
					<thead class="payroll--table_header">
						<tr>
							<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
							<th>Salary Grade</th>
							<th>Minimum Salary</th>
							<th>Maximum Salary</th>
						</tr>
					</thead>
					<tbody>
						@foreach($salary_grades as $salary_grade)
							<tr>
								<td><input type="checkbox" class="chk-salarygrade" name="salarygrades[]" value="{{ $salary_grade->grade_id }}"/></td>
								<td><a class="btn_salgrade" data-uk-modal="{target:'#edit'}"
									data-grade_id		= "{{$salary_grade->grade_id}}"
									data-grade_name		= "{{$salary_grade->grade_name}}"
									data-maximum_salary	= "{{$salary_grade->maximum_salary}}"
									data-minimum_salary	= "{{$salary_grade->minimum_salary}}">
									{{$salary_grade->grade_name}} </a> </td>
								<td>{{$salary_grade->minimum_salary}}</td>
								<td>{{$salary_grade->maximum_salary}}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
		    </div> <!-- salary grade -->
		</div>
	</div>
</div>

<!-- add salary grade modal -->
<div id="add" class="uk-modal">
	<div class="uk-modal-dialog">
		<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Salary Grade</div>	

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

		<form class="uk-form uk-form-horizontal" method="post" action="{{ url('companies/salarygrades/'.$company->company_id) }}">
			<fieldset>
				{{ csrf_field() }}
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Salary Grade :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Salary Grade..." name="grade_name" value="{{ old('grade_name') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Minimum Salary :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Minimum Salary..." name="minimum_salary" value="{{ old('minimum_salary') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Maximum Salary :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Maximum Salary..." name="maximum_salary" value="{{ old('maximum_salary') }}"/>	
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


<!-- edit salary grade modal -->
<div id="edit" class="uk-modal">
	<div class="uk-modal-dialog">
		<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Edit Salary Grade</div>	
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
		<form class="uk-form uk-form-horizontal" method="post" action="{{ url('companies/salarygrades/'.$company->company_id) }}">
			<fieldset>
				{{ csrf_field() }}
				{{ Form::hidden('_method', 'put') }}
				<input type="hidden" name="put_grade_id" id="grade_id" value="{{ old('put_grade_id') }}">
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Salary Grade :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Salary Grade..." name="put_grade_name" id="grade_name" value="{{ old('put_grade_name') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Minimum Salary :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Minimum Salary..." name="put_minimum_salary" id="minimum_salary" value="{{ old('put_minimum_salary') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Maximum Salary :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Maximum Salary..." name="put_maximum_salary" id="maximum_salary" value="{{ old('put_maximum_salary') }}"/>	
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
<!-- /.edit salary grade modal -->

<!-- delete location modal -->
<div id="delete" class="uk-modal">
    <div class="uk-modal-dialog">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-trash"></span>Delete Confirmation</div>
    	<div class="uk-margin uk-modal-content">
    		Are you sure you want to delete the selected records?
    	</div>
    	<form method="post" action="{{ url('companies/salarygrades/'.$company->company_id) }}">
	    	{{ csrf_field() }}
	    	{{ Form::hidden('_method', 'put') }}
	    	{{ Form::hidden('isDelete', '1') }}
	    	<div id="div-del-chk-salgrade">
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
				$(".chk-salarygrade:checked").each(function(){
					$('#div-del-chk-salgrade').append('<input type="hidden" name="salarygrades[]" value="'+ $(this).val() +'" />');
				});
			});

			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
			@elseif(Session::has('put-failed'))
				$(".btn_salgrade").click();
			@endif

			$(".btn_salgrade").click(function(){
				$("#grade_id").val($(this).attr('data-grade_id'));			
				$("#grade_name").val($(this).attr('data-grade_name'));
				$("#minimum_salary").val($(this).attr('data-minimum_salary'));
				$("#maximum_salary").val($(this).attr('data-maximum_salary'));
			});

			var dataTable = $('#salarygrade').DataTable({
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