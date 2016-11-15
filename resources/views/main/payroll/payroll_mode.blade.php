@extends('shared._public')

@section('title', 'Payroll: Mode')

@section('styles')

@endsection

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-file-text"></span> <strong>Payroll Mode</strong> </a></h1>
		</div>
	</div>
</div>

<!-- list payroll setup -->
<div class="uk-container uk-container-center">
	<div class="uk-grid main">
		<div class="uk-width-1-4">
			<ul class="uk-nav uk-nav-side uk-nav-parent-icon" data-uk-nav>
				<li><a href="{{ url('payroll/taxexemption') }}">Tax Exemption</a></li>
				<li><a href="{{ url('payroll/taxtable') }}">Tax Table</a></li>
				<li><a href="{{ url('payroll/annualtaxtable') }}">Annual Tax Table</a></li>
				<li><a href="{{ url('payroll/ssstable') }}">SSS Table</a></li>
				<li><a href="{{ url('payroll/pagibigtable') }}">Pagibig Table</a></li>
				<li><a href="{{ url('payroll/philhealthtable') }}">Philhealth Table</a></li>
				<li><a href="{{ url('payroll/paymentdisbursement') }}">Payment Disbursement</a></li>
				<li class="uk-parent"><a href="#">Payroll Details</a>
					<ul class="uk-nav-sub">
						<li><a href="{{ url('payroll/earnings') }}">Earnings</a></li>
						<li><a href="{{ url('payroll/deductions') }}">Deductions</a></li>
					</ul>
				</li>
				<li class="uk-active"><a href="{{ url('payroll/payrollmode') }}">Payroll Mode</a></li>
				<li><a href="{{ url('payroll/payrollperiod') }}">Payroll Period</a></li>
				<li><a href="{{ url('payroll/payrollgroup') }}">Payroll Group</a></li>
				<li><a href="{{ url('payroll/payrolltemplate') }}">Payroll Template Parameter</a></li>
				<li><a href="{{ url('payroll/payrollsignatory') }}">Payroll Signatory</a></li>
				<li><a href="{{ url('payroll/overtimeparamenter') }}">Overtime Parameter</a></li>
				<li><a href="{{ url('payroll/wageorder') }}">Wage Order</a></li>
			</ul>
		</div> <!-- payroll parameter list -->
		<div class="uk-width-3-4" >
			<article class="uk-article">

				<!-- buttons -->
				<div class="button-container">
					<!-- alerts -->
					@foreach(['add','edit','del'] as $msg)
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
				<!-- end buttons -->

				<!-- payroll mode -->
				<table id="payroll_mode" class="uk-table uk-table-hover uk-table-striped payroll--table">
					<thead class="payroll--table_header">
						<tr> 
							<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
				            <th>Code</th>
				            <th>Description</th>
				            <th>Number of Payments</th>
				            <th>Tax Mode</th>
						</tr>
					</thead>
					<tbody>
						@foreach($payroll_modes as $payroll_mode)
							<tr>
								 <td><input type="checkbox" id="select_all" class="chk-payroll_mode" name="payroll_mode[]" value="{{$payroll_mode->payroll_mode_id}}"/></td>
								<td><a class="btn-edit" data-uk-modal="{target:'#edit'}"
									data-edit_payroll_mode_id="{{ $payroll_mode->payroll_mode_id }}"
									data-edit_payroll_mode="{{ $payroll_mode->payroll_mode }}"
								data-edit_no_of_payment="{{ $payroll_mode->no_of_payment }}"
								data-edit_description="{{ $payroll_mode->description}}"
								data-edit_tax_mode="{{ $payroll_mode->tax_mode}}"
								>{{ $payroll_mode->payroll_mode }}</a></td>
								<td>{{ ucwords($payroll_mode->description) }}</td>
								<td>{{ $payroll_mode->no_of_payment }}</td>
								<td>{{ \App\tbl_tax_mode_model::where('tax_mode', $payroll_mode->tax_mode)->first()->description }}</td>
							</tr>
						@endforeach
					</tbody>
				</table> <!-- payroll mode -->
			</article>
		</div>		
	</div> <!-- grid -->
</div> <!-- container -->

<!-- start: modal for add button -->
<div id="add" class="uk-modal">
    <div class="uk-modal-dialog">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Payroll Mode</div>
			<!-- alerts -->
			@if(Session::has('add-failed'))
			@if($errors->has())
				<div class="uk-alert uk-alert-danger ">				
					@foreach ($errors->all() as $error)
						<p class="uk-text-left"> <span class="uk-icon-close"></span> {{ $error }} </p>
					@endforeach
					<!-- end alerts -->
				</div>
			@endif
			@endif
			<!-- end alerts -->
        <form class="uk-form uk-form-horizontal" method="post" action="{{url('payroll/payrollmode')}}">
        	{{csrf_field()}}
		    <fieldset>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Payroll Mode Code</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="payroll_mode" value="{{old('payroll_mode')}}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Description</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="description" value="{{old('description')}}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Number of Payment(s)</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="no_of_payment" value="{{old('no_of_payment')}}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Tax Mode</label>
		        	<div class="uk-form-controls">
		        		{{ Form::select('tax_mode'
		        			, [null => '-- Select --'] + 
								$tax_modes
								    ->lists('description', 'tax_mode')
								    ->toArray()
							, old('tax_mode')
							, array('class'=>'form-control')) }}
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
    	<div class="uk-modal-header"><span class="uk-icon-edit"></span>Edit Payroll Mode</div>
		<!-- alerts -->
			@if(Session::has('edit-failed'))
			@if($errors->has())
				<div class="uk-alert uk-alert-danger ">				
					@foreach ($errors->all() as $error)
						<p class="uk-text-left"> <span class="uk-icon-close"></span> {{ $error }} </p>
					@endforeach
				</div>
			@endif
			@endif
		<!-- end alerts -->
        <form class="uk-form uk-form-horizontal" method="post" action="{{url('payroll/payrollmode')}}">
        	{{ csrf_field() }}
        	{{ Form::hidden('_method', 'put') }}
		<input type="hidden" name="payroll_modes" value="{{old('payroll_modes')}}" />
		   <fieldset>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Payroll Mode Code</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="payroll_mode" id="edit_payroll_mode" placeholder="" value="{{old('payroll_mode')}}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Description</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="description" id="edit_description" placeholder="" value="{{old('description')}}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Number of Payment(s)</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="no_of_payment" id="edit_no_of_payment" placeholder="" value="{{old('no_of_payment')}}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Tax Mode</label>
		        	<div class="uk-form-controls">
		        		{{ Form::select('tax_mode',  
							[null => '-- Select --'] + \App\tbl_tax_mode_model::first()->lists('description', 'tax_mode') -> toArray() ,old('tax_mode'), 
							array('class'=>'form-control','id' => 'edit_tax_mode')) }}
		        	</div>
		        </div>
		    </fieldset>
		    <div class="uk-modal-footer uk-text-right form-buttons">
		    	<button class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span> Save </button>

			        <button class="uk-button uk-modal-close btn-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
		    </div>
		</form>
    </div>
</div> <!-- end: modal for edit button -->
<!-- delete modal -->
<div id="delete" class="uk-modal">
    <div class="uk-modal-dialog">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-trash"></span>Delete Confirmation</div>
    	<div class="uk-margin uk-modal-content">
    		Are you sure you want to delete the selected records?
    	</div>
    	<form method="post" action="{{url('payroll/payrollmode')}}">
    		{{ csrf_field() }}
    		{{ Form::hidden('_method', 'put') }}
    		{{ Form::hidden('isDelete', '1') }}
	    	<div id="div-del-chk-payroll_mode">
	    	</div>
		    <div class="uk-modal-footer uk-text-right form-buttons">
		    	<button id="btn-del" type="submit" class="uk-button btn-delete js-modal-confirm"><span class="uk-icon uk-icon-trash"></span> Delete</button>
		        <button type="button" class="uk-button uk-modal-close btn-cancel js-modal-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
		    </div>
		</form>	    
    </div>
</div> 
<!-- delete  modal -->

@endsection

@section('scripts')

<script type="text/javascript" language="javascript" src="{{asset('js/table.js')}}"></script>
<script type="text/javascript" class="init">
	$(document).ready(
		function() {
			
			$("#btn-del").click(function(){
					$(".chk-payroll_mode:checked").each(function(){
					$('#div-del-chk-payroll_mode').append('<input type="hidden" name="payroll_mode_tbl[]" value="'+ $(this).val() +'" />');
					});
				});
			
			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
				@elseif(Session::has('edit-failed'))
				$(".btn-edit").click();
				@endif
				
			$(".btn-edit").click(function(){
				
				$("input[name|=payroll_modes]").val( $(this).attr('data-edit_payroll_mode_id') );
				$("#edit_payroll_mode").val( $(this).attr('data-edit_payroll_mode') );
				$("#edit_no_of_payment").val( $(this).attr('data-edit_no_of_payment') );
				$("#edit_description").val( $(this).attr('data-edit_description') );
				$("#edit_tax_mode").val( $(this).attr('data-edit_tax_mode') );
				
				});
			var dataTable = $('#payroll_mode').DataTable({
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