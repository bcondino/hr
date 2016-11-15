@extends('shared._public')

@section('title', 'Setup: Classification')

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
					<li><a href="{{ url('companies/salarygrades/'.$company->company_id) }}">Salary Grade</a></li>
					<li class="uk-active"><a href="{{ url('companies/classification/'.$company->company_id) }}">Classification</a></li>
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
					
				<table id="classification" class="uk-table uk-table-hover uk-table-striped payroll--table">
					<thead class="payroll--table_header">
						<tr>
							<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
							<th>Classification Name</th>
						</tr>
					</thead>
					<tbody>
						@foreach($classifications as $classification)
							<tr>
								<td><input type="checkbox" class="chk-classification" name="classifications[]" value="{{$classification->class_id}}"/></td>
								<td><a class="btn_classification" data-uk-modal="{target:'#edit'}" 
										data-class_id	= "{{$classification->class_id}}"
										data-class_name	= "{{$classification->class_name}}">
										{{$classification->class_name}}
									</a> </td>
							</tr>
						@endforeach
					</tbody>
				</table>
		    </div> <!-- location -->
		</div> <!-- grid -->
	</div> <!-- categories -->
</div> <!-- list company setup -->


<!-- start: modal for add button -->
<div id="add" class="uk-modal">
	<div class="uk-modal-dialog">
		<button class="uk-modal-close uk-close"></button>
		<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span> Add Classification</div>
		<form class="uk-form uk-form-horizontal" action="{{ url('companies/classification/'. $company->company_id) }}" method="post"> 
			{!! csrf_field() !!}
			<fieldset>
				<div >
					<!-- alerts -->
					@if(Session::has('add-failed'))
						@if($errors->has())
						<div class="uk-alert uk-alert-danger">				
							@foreach ($errors->all() as $error)
								<p class="uk-text-left"> <span class="uk-icon-close"></span> {{ $error }} </p>
							@endforeach
						</div>
						@endif
					@endif
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Classification Name</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="class_name" value="{{ old('class_name') }}"/>
					</div>
				</div>
			</fieldset>
			<div class="uk-modal-footer uk-text-right form-buttons">
				<button class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span> Save</button>
				<button class="uk-button uk-modal-close btn-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
			</div>
		</form>
	</div>
</div> <!-- end: modal for add button -->

<!-- start: modal for edit button -->
<div id="edit" class="uk-modal">
	<div class="uk-modal-dialog">
		<button class="uk-modal-close uk-close"></button>
		<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Edit Classification</div>
		<form class="uk-form uk-form-horizontal" action="{{ url('companies/classification/'. $company->company_id) }}" method="post">  
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="put">
			<input type="hidden" id="class_id" name="put_class_id" value="{{ old('put_class_id') }}">
			<fieldset>
				<div >
					<!-- alerts -->
					@if(Session::has('put-failed'))
						@if($errors->has())
						<div class="uk-alert uk-alert-danger">				
							@foreach ($errors->all() as $error)
								<p class="uk-text-left"> <span class="uk-icon-close"></span> {{ $error }} </p>
							@endforeach
						</div>
						@endif
					@endif
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Classification Name</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" id="class_name" name="put_class_name" />
					</div>
				</div>
			</fieldset>
			<div class="uk-modal-footer uk-text-right form-buttons">
				<button class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span> Save</button>
				<button class="uk-button uk-modal-close btn-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
			</div>
		</form>
	</div>
</div> <!-- end: modal for edit button -->

<!-- delete location modal -->
<div id="delete" class="uk-modal">
    <div class="uk-modal-dialog">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-trash"></span>Delete Confirmation</div>
    	<div class="uk-margin uk-modal-content">
    		Are you sure you want to delete the selected records?
    	</div>
    	<form method="post" action="{{ url('companies/classification/'.$company->company_id) }}">
	    	{{ csrf_field() }}
	    	{{ Form::hidden('_method', 'put') }}
	    	{{ Form::hidden('isDelete', '1') }}
	    	<div id="div-del-chk-classification">
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
					$('#div-del-chk-classification').append('<input type="hidden" name="classifications[]" value="'+ $(this).val() +'" />');
				});
			});

			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
			@elseif(Session::has('put-failed'))
				$(".btn_classification").click();
			@endif

			$(".btn_classification").click(function(){
				$("#class_id").val($(this).attr('data-class_id'));
				$("#class_name").val($(this).attr('data-class_name'));
			});

			var dataTable = $('#classification').DataTable({
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