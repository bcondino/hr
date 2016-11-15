@extends('shared._public')

@section('title', 'Companies')

@section('styles')

@endsection

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-university"></span> <strong>Companies</strong> </h1>
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
		<table id="company" class="uk-table uk-table-hover uk-table-striped payroll--table">
			<thead class="payroll--table_header">
				<tr>
					<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>				
					<th>Name</th>
					<th>Active Employees</th>
				</tr>
			</thead>
			<tbody>
				@foreach($companies as $company)
					<tr>
						<td><input type="checkbox" class="chk-companies" name="companies[]" value="{{ $company->company_id }}"/></td>
						<td><a href="{{ url('companies/details/'.$company->company_id) }}">{{ ucwords($company->company_name) }}</a></td>
						<td>{{ count(\App\tbl_employee_model::where('active_flag', 'Y')->where('company_id', $company->company_id)->get()) }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

<!-- add companies modal -->
<div id="add" class="uk-modal">
	<div class="uk-modal-dialog">
		<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Company</div>	

		@if(Session::has('add-failed'))
			<!-- alerts -->
			<div class="uk-alert-danger ">
				@foreach ($errors->all() as $error)
					<p class="uk-text-left"> <span class="uk-icon-close"></span> {{ $error }} </p>
				@endforeach
			</div> </br>			
		@endif

		<form class="uk-form uk-form-horizontal" action="{{ url('companies/companies') }}" method="post">
			<fieldset>
				{{ csrf_field() }}
				<input type="hidden" name="created_by" value="{{ Auth::user()->user_id }}" />
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Company :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="company_name" placeholder="Company..." value="{{ old('company_name') }}"/>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Address :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="address" placeholder="Address..." value="{{ old('address') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; City :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="city" placeholder="City..." value="{{ old('city') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Region :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="region" placeholder="Region..." value="{{ old('region') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Zip Code :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="zip" placeholder="Zip Code..." value="{{ old('zip') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Contact No :</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="contact_no" placeholder="Contact No..." value="{{ old('contact_no') }}"/>	
					</div>
				</div>
				<div class="uk-modal-footer uk-text-right form-buttons">
					<button class="uk-button btn-save" ><span class="uk-icon uk-icon-edit"></span>Save</button>
					<button class="uk-button uk-modal-close btn-cancel" ><span class="uk-icon uk-icon-times-circle"> Cancel</button>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- /.add companies modal -->

<!-- delete companies modal -->
<div id="delete" class="uk-modal">
    <div class="uk-modal-dialog">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-trash"></span>Delete Confirmation</div>
    	<div class="uk-margin uk-modal-content">
    		Are you sure you want to delete the selected records?
    	</div>
    	<form method="post" action="{{ url('companies/companies') }}">
	    	{{ csrf_field() }}
	    	{{ Form::hidden('_method', 'put') }}
	    	{{ Form::hidden('isDelete', '1') }}
	    	<div id="div-del-chk-company">
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
				$(".chk-companies:checked").each(function(){
					$('#div-del-chk-company').append('<input type="hidden" name="companies[]" value="'+ $(this).val() +'" />');
				});
			});


			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
			@endif
			
			var dataTable = $('#company').DataTable({
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
