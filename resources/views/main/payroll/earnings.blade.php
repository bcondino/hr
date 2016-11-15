@extends('shared._public')

@section('title', 'Payroll: Details Earnings')

@section('styles')

@endsection

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-file-text"></span> <strong>Details Earnings</strong> </a></h1>
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
				<li  class="uk-parent uk-active"><a href="#">Payroll Details</a>
					<ul class="uk-nav-sub uk-active">
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

				<!-- payroll earnings -->
				<table id="earnings" class="uk-table uk-table-hover uk-table-striped payroll--table">
					<thead class="payroll--table_header">
						<tr> 
							<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
				            <th>Description</th>
				            <th>Taxable</th>
				            <th>Tax Deductibles</th>
				            <th>Fringe Benefits Tax</th>
				            <th>SSS</th>
				            <th>GSIS</th>
				            <th>HMDF</th>
				            <th>PhilHealth</th>
				            <th>Loan</th>
						</tr>
					</thead>
					<tbody>
						@foreach($earnings as $earning)
							<tr>
								<td>
										<input type="checkbox" class="chk-earnings" name="earnings_tbl[]" value="{{ $earning->payroll_element_id }}"/>
								</td>
								<td><a class="btn-edit" data-uk-modal="{target:'#edit'}"
									data-edit_payroll_element_id="{{ $earning->payroll_element_id}}"
									data-edit_description="{{ $earning->description}}"
									data-edit_tran_code="{{ $earning->tran_code}}"
									data-edit_taxable_flag="{{ $earning->taxable_flag}}"
									data-edit_regular_flag="{{ $earning->regular_flag}}"
									data-edit_tax_exempt_flag="{{ $earning->tax_exempt_flag}}"
									data-edit_fb_tax_flag="{{ $earning->fb_tax_flag}}"
									data-edit_deminimis_flag="{{ $earning->deminimis_flag}}"
									data-edit_sss_flag="{{ $earning->sss_flag}}"
									data-edit_pagibig_flag="{{ $earning->pagibig_flag}}"
									data-edit_philhealth_flag="{{ $earning->philhealth_flag}}"
									data-edit_loan_flag="{{ $earning->loan_flag}}"
									data-edit_show_payslip="{{ $earning->show_payslip}}"
								>{{ ucwords($earning->description) }}</a></td>
								<td> {{ $earning->taxable_flag == 'Y' ? 'Yes' : 'No' }} </td>
								<td> {{ $earning->tax_exempt_flag == 'Y' ? 'Yes' : 'No' }} </td>
								<td> {{ $earning->fb_tax_flag == 'Y' ? 'Yes' : 'No' }} </td>
								<td> {{ $earning->sss_flag == 'Y' ? 'Yes' : 'No' }} </td>
								<td> {{ $earning->gsis_flag == 'Y' ? 'Yes' : 'No' }} </td>
								<td> {{ $earning->pagibig_flag == 'Y' ? 'Yes' : 'No' }} </td>
								<td> {{ $earning->philhealth == 'Y' ? 'Yes' : 'No' }} </td>
								<td> {{ $earning->loan_flag == 'Y' ? 'Yes' : 'No' }} </td>
			
							</tr>
						@endforeach
					</tbody>
				</table> <!-- payroll earnings -->
			</article>
		</div>		
	</div> <!-- grid -->
</div> <!-- container -->

<!-- start: modal for add button -->
<div id="add" class="uk-modal">
    <div class="uk-modal-dialog modal-wide">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Payroll Detail: Earnings</div>
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
        <form class="uk-form uk-form-horizontal" method="post" action="{{url('payroll/earnings')}}" >
        	{{csrf_field()}}
        	<div class="uk-grid">
        		<div class="uk-width-1-2">
				    <fieldset class="uk-form-horizontal">
				    	<div class="uk-form-row">
				        	<label class="uk-form-label">Payroll Entry</label>
							<div class="uk-form-controls">
				        	<input type="text" class="form-control" name="entry_type" placeholder="Credit" value="CR" disabled>
							</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Element Name</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="description" placeholder="" value="{{old('description')}}">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Accounting Code</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="tran_code" placeholder="" value="{{old('tran_code')}}">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Is Taxable</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('taxable_flag'
				        			, ['Y' => 'Yes', 'N' => 'No']
				        			, old('taxable_flag') == null ? 'Y' : old('taxable_flag')
				        			,  array('class'=>'form-control')) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Is a regular compensation?</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('regular_flag'
				        			, ['Y' => 'Yes', 'N' => 'No']
				        			, old('regular_flag') == null ? 'N' : old('regular_flag')
				        			, array('class'=>'form-control')) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Is a tax deductible?</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('tax_exempt_flag'
				        			, ['Y' => 'Yes', 'N' => 'No']
				        			, old('tax_exempt_flag') == null ? 'N' : old('tax_exempt_flag')
				        			, array('class'=>'form-control')) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Subject to Fringe Benefit Tax?</label>
				        	<div class="uk-form-controls">
				        	{{ Form::select('fb_tax_flag'
				        		, ['Y' => 'Yes', 'N' => 'No']
				        		, old('fb_tax_flag') == null ? 'N' : old('fb_tax_flag')
				        		, array('class'=>'form-control')) }}
				        	</div>
				        </div>
				    </fieldset>
				</div>
				<div class="uk-width-1-2">
				    <fieldset class="uk-form-horizontal">
				        <div class="uk-form-row">
				        	<label class="uk-form-label">De minimis?</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('deminimis_flag'
				        		, ['Y' => 'Yes', 'N' => 'No']
				        		, old('deminimis_flag') == null ? 'N' : old('deminimis_flag')
				        		, array('class'=>'form-control')) }} 
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Subject to SSS?</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('sss_flag'
				        		, ['Y' => 'Yes', 'N' => 'No']
				        		, old('sss_flag') == null ? 'N' : old('sss_flag')
				        		, array('class'=>'form-control')) }} 
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Subject to Pagibig?</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('pagibig_flag'
				        		, ['Y' => 'Yes', 'N' => 'No']
				        		, old('pagibig_flag') == null ? 'N' : old('pagibig_flag')
				        		, array('class'=>'form-control')) }} 
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Subject to Philhealth?</label>
				        	<div class="uk-form-controls">
			        			{{ Form::select('philhealth_flag'
			        			, ['Y' => 'Yes', 'N' => 'No']
			        			, old('philhealth_flag') == null ? 'N' : old('philhealth_flag')
			        			, array('class'=>'form-control')) }} 
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Subject to Loan?</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('loan_flag'
				        		, [ 'Y' => 'Yes', 'N' => 'No']
				        		, old('loan_flag') == null ? 'N' : old('loan_flag')
				        		, array('class'=>'form-control')) }} 
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Subject to Payslip?</label>
				        	<div class="uk-form-controls">
				        	{{ Form::select('show_payslip'
				        	, ['Y' => 'Yes', 'N' => 'No']
				        	, old('show_payslip') == null ? 'N' : old('loan_flag')
				        	, array('class'=>'form-control')) }} 
				        	</div>
				        </div>
				    </fieldset>
				</div>
			</div> <!-- end of grid -->
			<div class="uk-modal-footer uk-text-right form-buttons">
		    	<button class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span> Save</button>
				<button class="uk-button uk-modal-close btn-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
			</div>
		</form>
    </div>
</div> <!-- end: modal for add button -->

<!-- start: modal for edit button -->
<div id="edit" class="uk-modal">
    <div class="uk-modal-dialog modal-wide">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-edit"></span>Edit Payroll Detail: Earnings</div>
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
		<form class="uk-form uk-form-horizontal" method="post" action="{{url('payroll/earnings')}}" >
		{{ csrf_field() }}
		{{ Form::hidden('_method', 'put') }}
		<input type="hidden" name="earning_s" value="{{old('earning_s')}}" />		   
        	<div class="uk-grid">
        		<div class="uk-width-1-2">
				    <fieldset class="uk-form-horizontal">
				    	<div class="uk-form-row">
				        	<label class="uk-form-label">Payroll Entry</label>
							<div class="uk-form-controls">
				        	<input type="text" class="form-control"  placeholder="Credit" value="Credit" disabled>
							</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Element Name</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="description" id="edit_description" placeholder="" value="{{old('description')}}">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Accounting Code</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="tran_code" id="edit_tran_code" placeholder="" value="{{old('tran_code')}}">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Is Taxable</label>
				        	<div class="uk-form-controls">
			        		{{ Form::select('taxable_flag'
			        		, ['Y' => 'Yes', 'N' => 'No']
			        		, old('taxable_flag') == null ? 'Y' : old('taxable_flag')
			        		, array('class'=>'form-control','id'=>'edit_taxable_flag')) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Is a regular compensation?</label>
				        	<div class="uk-form-controls">
				        	{{ Form::select('regular_flag'
				        	,  ['Y' => 'Yes', 'N' => 'No']
				        	, old('regular_flag') == null ? 'N' : old('regular_flag')
				        	,  array('class'=>'form-control','id'=>'edit_regular_flag')) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Is a tax deductible?</label>
				        	<div class="uk-form-controls">
			        		{{ Form::select('tax_exempt_flag'
			        		, ['Y' => 'Yes', 'N' => 'No']
			        		, old('tax_exempt_flag') == null ? 'N' : old('tax_exempt_flag')
			        		, array('class'=>'form-control' ,'id'=>'edit_tax_exempt_flag')) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Subject to Fringe Benefit Tax?</label>
				        	<div class="uk-form-controls">
				        	{{ Form::select('fb_tax_flag'
				        	, ['Y' => 'Yes', 'N' => 'No']
				        	, old('fb_tax_flag') == null ? 'N' : old('fb_tax_flag')
				        	,  array('class'=>'form-control' ,'id'=>'edit_fb_tax_flag')) }}
				        	</div>
				        </div>
				    </fieldset>
				</div>

				<div class="uk-width-1-2">
				    <fieldset class="uk-form-horizontal">
				        <div class="uk-form-row">
				        	<label class="uk-form-label">De minimis?</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('deminimis_flag'
				        		, ['Y' => 'Yes', 'N' => 'No']
				        		, old('deminimis_flag') == null ? 'N' : old('deminimis_flag')
				        		, array('class'=>'form-control' ,'id'=>'edit_deminimis')) }} 
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Subject to SSS?</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('sss_flag'
				        		, ['Y' => 'Yes', 'N' => 'No']
				        		, old('sss_flag') == null ? 'N' : old('sss_flag')
				        		,  array('class'=>'form-control' ,'id'=>'edit_sss_flag')) }} 
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Subject to Pagibig?</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('pagibig_flag'
				        		, ['Y' => 'Yes', 'N' => 'No']
				        		, old('pagibig_flag') == null ? 'N' : old('pagibig_flag')
				        		, array('class'=>'form-control' ,'id'=>'edit_pagibig_flag')) }} 
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Subject to Philhealth?</label>
				        	<div class="uk-form-controls">
			        			{{ Form::select('philhealth_flag'
			        			, ['Y' => 'Yes', 'N' => 'No']
			        			, old('philhealth_flag') == null ? 'N' : old('philhealth_flag')
			        			, array('class'=>'form-control' ,'id'=>'edit_philhealth_flag')) }} 
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Subject to Loan?</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('loan_flag'
				        		, ['Y' => 'Yes', 'N' => 'No']
				        		, old('loan_flag') == null ? 'N' : old('philhealth_flag')
				        		, array('class'=>'form-control' ,'id'=>'edit_loan_flag')) }} 
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Subject to Payslip?</label>
				        	<div class="uk-form-controls">
				        	{{ Form::select('show_payslip'
				        	, ['Y' => 'Yes', 'N' => 'No']
				        	, old('show_payslip') == null ? 'N' : old('show_payslip')
				        	, array('class'=>'form-control' ,'id'=>'edit_show_payslip')) }} 
				        	</div>
				        </div>
				    </fieldset>
				</div>
			</div> <!-- end of grid -->

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
    	<form method="post" action="{{url('payroll/earnings')}}" >
    		{{ csrf_field() }}
    		{{ Form::hidden('_method', 'put') }}
    		{{ Form::hidden('isDelete', '1') }}
	    	<div id="div-del-chk-earnings">
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
					$(".chk-earnings:checked").each(function(){
					$('#div-del-chk-earnings').append('<input type="hidden" name="earnings_tbl[]" value="'+ $(this).val() +'" />');
					});
				});
				
		
			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
				@elseif(Session::has('edit-failed'))
				$(".btn-edit").click();
				@endif
				
			$(".btn-edit").click(function(){
				
				$("input[name|=earning_s]").val( $(this).attr('data-edit_payroll_element_id') );
					$("#edit_description").val( $(this).attr('data-edit_description') );
					$("#edit_tran_code").val( $(this).attr('data-edit_tran_code') );
					$("#edit_taxable_flag").val( $(this).attr('data-edit_taxable_flag') );
					$("#edit_regular_flag").val( $(this).attr('data-edit_regular_flag') );
					$("#edit_tax_exempt_flag").val( $(this).attr('data-edit_tax_exempt_flag') );
					$("#edit_fb_tax_flag").val( $(this).attr('data-edit_fb_tax_flag') );
					$("#edit_deminimis_flag").val( $(this).attr('data-edit_deminimis_flag') );
					$("#edit_sss_flag").val( $(this).attr('data-edit_sss_flag') );
					$("#edit_pagibig_flag").val( $(this).attr('data-edit_pagibig_flag') );	
					$("#edit_philhealth_flag").val( $(this).attr('data-edit_philhealth_flag') );	
					$("#edit_loan_flag").val( $(this).attr('data-edit_loan_flag') );	
					$("#edit_show_payslip").val( $(this).attr('data-edit_show_payslip') );		
				
				});
				
			var dataTable = $('#earnings').DataTable({
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