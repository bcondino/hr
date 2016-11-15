@extends('shared._public')

@section('title', 'Payroll: Tax Table')

@section('styles')

@endsection

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-file-text"></span> <strong>Tax Table </strong></h1>
		</div>
	</div>
</div>

<!-- list payroll setup -->
<div class="uk-container uk-container-center">
	<div class="uk-grid main">
		<div class="uk-width-1-4">
			<ul class="uk-nav uk-nav-side uk-nav-parent-icon" data-uk-nav>
				<li><a href="{{ url('payroll/taxexemption') }}">Tax Exemption</a></li>
				<li class="uk-active"><a href="{{ url('payroll/taxtable') }}">Tax Table</a></li>
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
				<li><a href="{{ url('payroll/payrollmode') }}">Payroll Mode</a></li>
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

				<!-- tax table -->
				<table id="tax_table" class="uk-table uk-table-hover uk-table-striped payroll--table">
				    <thead class="payroll--table_header">
				        <tr>
				            <th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
							<th>Tax ID</th>
				            <th>Tax Mode</th>
				            <th>Tax Code</th>
				            <th>Range From <br/ > (over or equal)</th>
				            <th>Range To <br/ > (less than)</th>
				            <th>Percentage</th>
				            <th>Fix Amount</th>
				        </tr>
				    </thead>
				    <tbody>
				    	@foreach($taxs as $tax)
					        <tr>
					            <td><input type="checkbox" id="select_all" class="chk-tax_table" name="tax_table[]" value="{{$tax->tax_id}}"/></td>
								<td><a class="btn-edit"   data-uk-modal="{target:'#edit'}"
								data-edit_tax_id="{{ $tax->tax_id }}"
								data-edit_tax_mode="{{ $tax->tax_mode }}"
								data-edit_tax_code="{{ $tax->tax_code }}"
								data-edit_range_from="{{ $tax->range_from }}"
								data-edit_range_to="{{ $tax->range_to}}"
								data-edit_percentage="{{ $tax->percentage}}"
								data-edit_fix_amount="{{ $tax->fix_amount}}"
								>{{ $tax->tax_id }}</td>
					            <td>{{ \App\tbl_tax_mode_model::where('tax_mode', $tax->tax_mode)->first()->description }}</td>
					            <td>{{ \App\tbl_tax_code_model::where('tax_code', $tax->tax_code)->first()->description }}</td>
					            <td>{{ number_format($tax->range_from, 2, ".", ",") }}</td>
					            <td>{{ number_format($tax->range_to, 2, ".", ",") }}</td>
					            <td>{{ $tax->percentage * 100 }}%</td>
					            <td>{{ number_format($tax->fix_amount, 2, ".", ",") }}</a></td>
					        </tr>
					    @endforeach
					</tbody>
				</table> <!-- tax table -->
			</article>
		</div>		
	</div> <!-- grid -->
</div> <!-- container -->

<!-- start: modal for add button -->
<div id="add" class="uk-modal">
    <div class="uk-modal-dialog">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Tax Table</div>
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
			<!-- end alerts -->
        <form class="uk-form uk-form-horizontal" method="post" action="{{ url('payroll/taxtable') }}">
        	{{csrf_field()}}
		    <fieldset>
		    	<div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Tax Mode</label>
		        	<div class="uk-form-controls">
						{{ Form::select('tax_mode'
							, [null => '-- Select --'] + 
								\App\tbl_tax_mode_model::
									orderBy('description')
									->lists('description', 'tax_mode')
									->toArray()
							, old('tax_mode')
							, array('class'=>'form-control')) }}
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Tax Code</label>
		        	<div class="uk-form-controls">
						{{ Form::select('tax_code'
							, [null => '-- Select --'] + 
								\App\tbl_tax_code_model::
									orderBy('description')
								    ->lists('description', 'tax_code')
								    ->toArray()
							, old('tax_code')
							, array('class'=>'form-control')) }}
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Range From</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="range_from" value="{{ old('range_from') }}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Range To</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="range_to" value="{{ old('range_to') }}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Percentage</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="percentage" value="{{ old('percentage') }}">
		        		<caption>Please enter with decimal (i.e. 0.01)</caption>
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Fix Amount</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="fix_amount" value="{{ old('fix_amount') }}">
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
    	<div class="uk-modal-header"><span class="uk-icon-edit"></span>Edit Tax Table </div>
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
        <form class="uk-form uk-form-horizontal" method="post" action="{{ url('payroll/taxtable')}}">
        	{{ csrf_field() }}
        	{{ Form::hidden('_method', 'put') }}
			<input type="hidden" name="edit_tax" value="{{old('edit_tax')}}" />
			    <fieldset>
			        <div class="uk-form-row">
			        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Tax Mode</label>
			        	<div class="uk-form-controls">
			        		{{ Form::select('tax_mode'
			        			, \App\tbl_tax_mode_model::
		        					orderBy('description')
		        				    ->lists('description', 'tax_mode')
		        				    ->toArray()
			        			, old('tax_mode')
			        			, array('class'=>'form-control', 'id' => 'edit_tax_mode')) }}
			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Tax Code</label>
			        	<div class="uk-form-controls">
			        		{{ Form::select('tax_code'
			        			, \App\tbl_tax_code_model::
			        				orderBy('description')
			        			    ->lists('description', 'tax_code')
			        			    ->toArray()
			        			, old('tax_code')
			        			, array('class'=>'form-control' , 'id' => 'edit_tax_code')) }}
			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Range From</label>
			        	<div class="uk-form-controls">
			        		<input type="text" class="form-control" name="range_from" id="edit_range_from" value="{{old('range_from')}}">
			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Range To</label>
			        	<div class="uk-form-controls">
			        		<input type="text" class="form-control" name="range_to" id="edit_range_to" value="{{old('range_to')}}">
			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Percentage</label>
			        	<div class="uk-form-controls">
			        		<input type="text" class="form-control" name="percentage" id="edit_percentage" value="{{old('percentage')}}">
			        		<caption>Please enter with decimal (i.e. 0.01)</caption>
			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Fix Amount</label>
			        	<div class="uk-form-controls">
			        		<input type="text" class="form-control" name="fix_amount"  id="edit_fix_amount" value="{{old('fix_amount')}}">
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

<!-- delete modal -->
<div id="delete" class="uk-modal">
    <div class="uk-modal-dialog">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-trash"></span>Delete Confirmation</div>
    	<div class="uk-margin uk-modal-content">
    		Are you sure you want to delete the selected records?
    	</div>
    	<form method="post" action="{{url('payroll/taxtable')}}">
    		{{ csrf_field() }}
    		{{ Form::hidden('_method', 'put') }}
    		{{ Form::hidden('isDelete', '1') }}
	    	<div id="div-del-chk-tax_table">
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
				$(".chk-tax_table:checked").each(function(){
					$('#div-del-chk-tax_table').append('<input type="hidden" name="tax_table[]" value="'+ $(this).val() +'" />');
				});
			});
			
			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
			@elseif(Session::has('edit-failed'))
				$(".btn-edit").click();
			@endif
			
			$(".btn-edit").click(function(){
				//var my_id = $(this).attr('data-edit_tax_id') ;
				$("input[name|=edit_tax]").val( $(this).attr('data-edit_tax_id') );
				$("#edit_tax_code").val( $(this).attr('data-edit_tax_code') );
				$("#edit_tax_mode").val( $(this).attr('data-edit_tax_mode') );
							
				$("#edit_range_from").val( $(this).attr('data-edit_range_from') );
				$("#edit_range_to").val( $(this).attr('data-edit_range_to') );
				$("#edit_percentage").val( $(this).attr('data-edit_percentage') );
				$("#edit_fix_amount").val( $(this).attr('data-edit_fix_amount') );
			//alert(my_id);
			});
			var dataTable = $('#tax_table').DataTable({
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