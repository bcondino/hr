@extends('shared._public')

@section('title', 'Payroll: Pagibig')

@section('styles')

@endsection

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-cogs"></span> <strong>Pagibig Table</strong </a></h1>
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
				<li class="uk-active"><a href="{{ url('payroll/pagibigtable') }}">Pagibig Table</a></li>
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

				<!-- pagibig table -->
				<table id="pagibigtable" class="uk-table uk-table-hover uk-table-striped payroll--table">
					<thead class="payroll--table_header">
						<tr> 
							<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
				            <th>Range From <br/ > (over or equal)</th>
				            <th>Range To <br/ > (less than)</th>
				            <th>Employee <br/ >Contribution</th>
				            <th>Employer <br/ >Contribution</th>
				            <th>Employee <br/ >Cont. (%)</th>
				            <th>TotEmployer <br/ >Cont. (%)</th>
						</tr>
					</thead>
					<tbody>
						@foreach($pagibigs as $pagibig)
							<tr>
					           <td><input type="checkbox" id="select_all" class="chk-pagibig_tbl" name="pagibig[]" value="{{$pagibig->pagibig_id}}"/></td>
					            <td><a class="btn-edit" data-uk-modal="{target:'#edit'}"
								data-edit_pagibig_id="{{ $pagibig->pagibig_id }}"
								data-edit_range_from="{{ $pagibig->range_from }}"
								data-edit_range_to="{{ $pagibig->range_to}}"
								data-edit_ee_cont="{{ $pagibig->ee_cont}}"
								data-edit_er_cont="{{ $pagibig->er_cont}}"
								data-edit_ee_cont_percent="{{ $pagibig->ee_cont_percent}}"
								data-edit_er_cont_percent="{{ $pagibig->er_cont_percent}}"
								>{{ number_format($pagibig->range_from, 2, ".", ",") }}</a></td>
					            <td>{{ number_format($pagibig->range_to, 2, ".", ",") }}</td>
					            <td>{{ number_format($pagibig->ee_cont, 2, ".", ",") }}</td>
					            <td>{{ number_format($pagibig->er_cont, 2, ".", ",") }}</td>
					            <td>{{ $pagibig->ee_cont_percent }}</td>
					            <td>{{ $pagibig->er_cont_percent }}</td>
							</tr>
						@endforeach
					</tbody>
				</table> <!-- tax exemption -->
			</article>
		</div>		
	</div> <!-- grid -->
</div> <!-- container -->

<!-- start: modal for add button -->
<div id="add" class="uk-modal">
    <div class="uk-modal-dialog">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Pagibig Table</div>
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
        <form class="uk-form uk-form-horizontal" method="post" action="{{ url('payroll/pagibigtable') }}">
        	{{csrf_field()}}
		    <fieldset>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Range From</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="range_from" value="{{old('range_from')}}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Range To</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="range_to" value="{{old('range_to')}}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Employee Contribution</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="ee_cont" value="{{old('ee_cont')}}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Employer Contribution</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="er_cont" value="{{old('er_cont')}}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Employee Contribution (%)</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="ee_cont_percent" value="{{old('ee_cont_percent')}}">
		        		<caption>Please enter with decimal (i.e. 0.01)</caption>
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Employer Contribution (%)</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="er_cont_percent" value="{{old('er_cont_percent')}}">
		        		<caption>Please enter with decimal (i.e. 0.01)</caption>
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
    	<div class="uk-modal-header"><span class="uk-icon-edit"></span>Edit Pagibig Table</div>
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
        <form class="uk-form uk-form-horizontal" method="post" action="{{url('payroll/pagibigtable')}}">
        	{{ csrf_field() }}
        	{{ Form::hidden('_method', 'put') }}
		<input type="hidden" name="pagibig" value="{{old('pagibig')}}" />
		    <fieldset>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Range From</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="range_from" id="edit_range_from" placeholder=""  value="{{old('range_from')}}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Range To</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control"  name="range_to"  id="edit_range_to" placeholder="" value="{{old('range_to')}}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Employee Contribution</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="ee_cont" id="edit_ee_cont" pplaceholder="" value="{{old('ee_cont')}}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Employer Contribution</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="er_cont" id="edit_er_cont" placeholder="" value="{{old('er_cont')}}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Employee Contribution (%)</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="ee_cont_percent" id="edit_ee_cont_percent"  placeholder="" value="{{old('edit_ee_cont_percent')}}">
		        		<caption>Please enter with decimal (i.e. 0.01)</caption>
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Employer Contribution (%)</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="er_cont_percent" id="edit_er_cont_percent" placeholder="" value="{{old('er_cont_percent')}}">
		        		<caption>Please enter with decimal (i.e. 0.01)</caption>
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
    	<form method="post" action="{{url('payroll/pagibigtable')}}">
    		{{ csrf_field() }}
    		{{ Form::hidden('_method', 'put') }}
    		{{ Form::hidden('isDelete', '1')}}
	    	<div id="div-del-chk-pagibig_tbl">
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
					$(".chk-pagibig_tbl:checked").each(function(){
					$('#div-del-chk-pagibig_tbl').append('<input type="hidden" name="pagibig_tbl[]" value="'+ $(this).val() +'" />');
					});
				});
			
			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
				@elseif(Session::has('edit-failed'))
				$(".btn-edit").click();
				@endif
				
			$(".btn-edit").click(function(){
				
				$("input[name|=pagibig]").val( $(this).attr('data-edit_pagibig_id') );
				$("#edit_range_from").val( $(this).attr('data-edit_range_from') );
				$("#edit_range_to").val( $(this).attr('data-edit_range_to') );
				$("#edit_ee_cont").val( $(this).attr('data-edit_ee_cont') );
				$("#edit_er_cont").val( $(this).attr('data-edit_er_cont') );
				$("#edit_ee_cont_percent").val( $(this).attr('data-edit_ee_cont_percent') );
				$("#edit_er_cont_percent").val( $(this).attr('data-edit_er_cont_percent') );
				});
				
				var dataTable = $('#pagibigtable').DataTable({
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