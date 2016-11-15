@extends('shared._public')

@section('title', 'Payroll Process')

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-file-text"></span> <strong>Payroll Process</strong> </h1>
		</div>
	</div>
</div>

<!-- content -->
<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<aside class="uk-width-1-4">
			<ul class="uk-nav uk-nav-side uk-nav-parent-icon" data-uk-nav>
				<li><a href="{{ url('payrollmanagement/profile') }}">Payroll Profile</a></li>
				<li class="uk-parent"><a href="#">Earnings and Deductions </a>
					<ul class="uk-nav-sub">
						<li><a href="{{ url('payrollmanagement/rearningsdedn') }}">Recurring Earnings and Deductions</a></li>
						<li><a href="{{ url('payrollmanagement/nonrearningsdedn') }}">Non-recurring Earnings and Deductions</a></li>
					</ul>
				</li>
				<li class="uk-active"><a href="{{ url('payrollmanagement/payrollprocess') }}">Payroll Process</a></li>
				<!-- 20161027 updated by Melvin Militante; Reason: To add payroll report interface -->
				<li><a href="{{ url('payrollmanagement/report') }}">Reports</a></li>
			</ul>
		</aside>
		<div class="tm-main uk-width-3-4">
			<main>
	    	<!-- alerts -->
					@foreach(['add','put','del'] as $msg)
						@if(Session::has($msg.'-success'))
							<div class="uk-alert uk-alert-success">
								<span class="uk-icon uk-icon-check"></span> {{ Session::get($msg.'-success') }}
							</div>
						@endif
						@if(Session::has($msg.'-warning'))
							<div class="uk-alert uk-alert-warning">
								<span class="uk-icon uk-icon-warning"></span> {{ Session::get($msg.'-warning') }}
							</div>
						@endif
					@endforeach	

				<article class="uk-article">
					<div class="button-container">
						<button id="btn-regen" class="uk-button btn-generate" data-uk-modal="{target:'#regenerate'}">
							<span class="uk-icon uk-icon-refresh"> </span>
							Regenerate
						</button>
						<button class="uk-button btn-add" data-uk-modal="{target:'#generate'}">
							<span class="uk-icon uk-icon-plus-circle"></span>
							Add
						</button>
						<button class="uk-button btn-save" data-uk-modal="{target:'#final'}">
							<span class="uk-icon uk-icon-check-circle"></span>
							Finalize
						</button>
						<button class="uk-button" data-uk-modal="{target:'#delete'}">
							<span class="uk-icon uk-icon-trash"></span>
							Delete
						</button>
					</div>

					<!-- start main content table -->
					<table id="payrollprocess" class="uk-table uk-table-hover uk-table-striped payroll--table">
						<thead class="payroll--table_header">
							<tr>
								<th>
									<input type="checkbox" name="select_all" id="select_all" value="1" >
								</th>
								<th>
									<center>Year</center>
								</th>
								<th>
									<center>Pay Group</center>
								</th>
								<th>
									<center>Date From</center>
								</th>
								<th>
									<center>Date To</center>
								</th>
								<th>
									<center>Status</center>
								</th>
								<th>
									<center>No of Employee</center>
								</th>
								<th>
									<center>Date Generated</center>
								</th>
							</tr>
						</thead>
						<tbody>
							@foreach($pay_proc_rec as $pp_rec)
							<tr>
								<td>
									<center><input type="checkbox" id="items" class="chk-payrollprocess" name="payrollprocess[]" value="{{ $pp_rec->payroll_process_id }}"></center>
								</td>
								<td style="text-align: right">
									<a href="{{ url('payrollmanagement/payrollprocessdetails/'. $pp_rec->payroll_process_id) }}">
										{{ $pp_rec->year }}
									</a>
								</td>
								<td>
									<center>{{ \App\tbl_payroll_group_model::find($pp_rec->payroll_group_id)->description }}</center>
								</td>
								<td>
									<center>{{ date('F d, Y', strtotime($pp_rec->date_from)) }}</center>
								</td>
								<td>
									<center>{{ date('F d, Y', strtotime($pp_rec->date_to)) }}</center>
								</td>
								<td>
									<div style="width: 80px; height: 18px; background: #ddd; position: relative;">
										<div style="width: 
											@if ( trim($pp_rec->status) == 'Completed' || trim($pp_rec->status) == 'Final' || trim($pp_rec->status) == 'Failed' ) 100%
											@elseif ( trim($pp_rec->status) == 'In Process' )
												1%
											@else
												{{ ucwords($pp_rec->status) }}
											@endif
										; height: 18px; color: white;
										@if ( trim($pp_rec->status) == 'Failed' )
											background: #f94a4a;
										@else
											background: #80ce79;
										@endif
										"></div>
										<span style="position: absolute; top: -1px; z-index: 2; text-align: center; width: 100%;">{{ ucwords($pp_rec->status) }}</span>
									</div>
								</td>
								<td style="text-align: right">
									{{ DB::table('hr.tbl_payroll_process_emp')->where('payroll_process_id', $pp_rec->payroll_process_id)->count() }}
								</td>
								<td>
									<center>{{ date('F d, Y', strtotime($pp_rec->created_at)) }}</center>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</article>
			</main>
		</div>
	</div>
</div>

<!-- start: modal for finalize button -->
<div id="final" class="uk-modal">
    <div class="uk-modal-dialog">
			<button class="uk-modal-close uk-close"></button>
			<div class="uk-modal-header">
				<span class="uk-icon-check" />
				Finalize Confirmation
			</div>
    	<div class="uk-margin uk-modal-content">Finalized records cannot be regenerated again. Mark them as final?</div>
    	<form class="uk-form uk-form-horizontal"  action="{{ url('payrollmanagement/payrollprocess') }}" method="post">
	    	{{ csrf_field() }}
	    	{{ Form::hidden('_method', 'put') }}
			<div id="div-final-chk-pp"></div>
		    <div class="uk-modal-footer uk-text-right form-buttons">
		    	<button id="btn-final" type="submit" class="uk-button btn-save js-modal-confirm">
					<span class="uk-icon uk-icon-check-circle" />
					Confirm
				</button>
		        <button type="button" class="uk-button uk-modal-close btn-cancel js-modal-cancel">
					<span class="uk-icon uk-icon-times-circle" />
					Cancel
				</button>
		    </div>
		</form>	    
    </div>
</div> 
<!--end: modal for finalize button-->

<!-- start: modal for regenerate button -->
<div id="regenerate" class="uk-modal">
    <div class="uk-modal-dialog">
			<button class="uk-modal-close uk-close"></button>
			<div class="uk-modal-header">
				<span class="uk-icon-refresh" />
				Regenerate Confirmation
			</div>
    	<div id="div-regen-text" class="uk-margin uk-modal-content">Rerun payroll on the selected record(s)?</div>
    	<form class="uk-form uk-form-horizontal"  action="{{ url('payrollmanagement/payrollprocess') }}" method="post">
	    	{{ csrf_field() }}
	    	{{ Form::hidden('isAdd', '0') }}
			<div id="div-regen-chk-pp"></div>
		    <div class="uk-modal-footer uk-text-right form-buttons">
		    	<button id="btn-regen-confirm" type="submit" class="uk-button btn-save js-modal-confirm">
					<span class="uk-icon uk-icon-refresh" />
					Confirm
				</button>
		        <button type="button" class="uk-button uk-modal-close btn-cancel js-modal-cancel">
					<span class="uk-icon uk-icon-times-circle" />
					Cancel
				</button>
		    </div>
		</form>	    
    </div>
</div> 
<!--end: modal for regenerate button-->

<!-- start: modal for generate button -->
<div id="generate" class="uk-modal">
	<div class="uk-modal-dialog modal-wide">
		<button class="uk-modal-close uk-close"></button>
		<div class="uk-modal-header">
			<span class="uk-icon-refresh"></span>
			Generate Payroll Process
		</div>
		<form class="uk-form uk-form-horizontal"  action="{{ url('payrollmanagement/payrollprocess') }}" method="post">
			{{ csrf_field() }}
			{{ Form::hidden('isAdd', '1') }}

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

			<div class="uk-grid">
				<div class="uk-width-1-2">
					<fieldset>
						<div class="uk-form-row">
							<label class="uk-form-label">
								<span class="uk-text-danger">
									*
								</span>
								Year
							</label>
							<div class="uk-form-controls">
								<?php

									for($i = 2010; $i < date("Y")+1; $i++){
										$years[$i] = $i;
									}

									echo Form::select('year'
										, [null => '-- Select --'] + $years
										, old('year')
										, ['class' => 'form-control'])
								?>
							</div>
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label">
								<span class="uk-text-danger">
									*
								</span>
								Payroll Period
							</label>
							<div class="uk-form-controls">
								{{ Form::select('payroll_period_id'
									, [null =>'-- Select --'] + 
			             \App\tbl_payroll_period_model::
                      select(DB::raw("(date_from ||' to '|| date_to) as date_covered, payroll_period_id"))
                      ->where('active_flag', 'Y')
                      ->where('company_id', $company->company_id)
                      ->lists('date_covered', 'payroll_period_id')
                      ->toArray()
									, old('payroll_period_id')
									, ['class'=>'form-control']) }}
							</div>
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label">
								<span class="uk-text-danger">
									*
								</span>
								Payroll Group
							</label>
							<div class="uk-form-controls">
								{{ Form::select('payroll_group_id'
								, [null =>'-- Select --'] +
									\App\tbl_payroll_group_model::
									where('active_flag', 'Y')
									->where('company_id',$company->company_id)
									->get()->lists('description', 'payroll_group_id')
									->toArray()
								, old('payroll_group_id')
								, ['class'=>'form-control']) }}
							</div>
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label">
								&nbsp;&nbsp; Date of Credit
							</label>
							<div class="uk-form-controls date-calendar" data-uk-form-select>
								<span class="uk-icon-calendar">
								</span>
								<input name="date_payroll" class="form-control" type="text" data-uk-datepicker="{format:'MM/DD/YYYY'}" placeholder="MM/DD/YYYY"/>
							</div>
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label">
								&nbsp;&nbsp; Daily Time Records (DTR)
							</label>
							<div class="uk-form-controls uk-form-controls-text">
								<label>
									{{ Form::radio('with_dtr_flag', 'Y', (old('with_dtr_flag') == 'Y' or empty(old('with_dtr_flag')))? true:false) }} No DTR
								</label>
								<label>
									{{ Form::radio('with_dtr_flag', 'N') }} Use DTR
								</label>
								<br/>
							</div>
						</div>
						<hr/>
						<div class="uk-form-row">
							<label class="uk-form-label">
								&nbsp;&nbsp; Is a special run?
							</label>
							<div class="uk-form-controls">
								{{ Form::select('special_run_flag', ['Y' =>'Yes', 'N' =>'No'], empty(old('special_run_flag')) ? 'N': old('special_run_flag'), ['class' =>'form-control']) }}
							</div>
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label">
								&nbsp;&nbsp; Deduct SSS Contribution?
							</label>
							<div class="uk-form-controls">
								{{ Form::select('sss_flag', ['Y' =>'Yes', 'N' =>'No'], empty(old('sss_flag')) ? 'N': old('sss_flag'), ['class' =>'form-control']) }}
							</div>
						</div>
					</fieldset>
				</div>
				<div class="uk-width-1-2">
					<fieldset>
						<div class="uk-form-row">
							<label class="uk-form-label">
								Deduct Philhealth Contribution?
							</label>
							<div class="uk-form-controls">
								{{ Form::select('philhealth_flag', ['Y' =>'Yes', 'N' =>'No'], empty(old('philhealth_flag')) ? 'N': old('philhealth_flag'), ['class' =>'form-control']) }}
							</div>
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label">
								Deduct Pagibig Contribution?
							</label>
							<div class="uk-form-controls">
								{{ Form::select('pagibig_flag', ['Y' =>'Yes', 'N' =>'No'], empty(old('pagibig_flag')) ? 'N': old('pagibig_flag'), ['class' =>'form-control']) }}
							</div>
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label">
								Deduct Tax?
							</label>
							<div class="uk-form-controls">
								{{ Form::select('tax_flag', ['Y' =>'Yes', 'N' =>'No'], empty(old('tax_flag')) ? 'N': old('tax_flag'), ['class' =>'form-control']) }}
							</div>
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label">
								Deduct Loan?
							</label>
							<div class="uk-form-controls">
								{{ Form::select('loan_flag', ['Y' =>'Yes', 'N' =>'No'], empty(old('loan_flag')) ? 'N': old('loan_flag'), ['class' =>'form-control']) }}
							</div>
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label">
								Add Benefits?
							</label>
							<div class="uk-form-controls">
								{{ Form::select('benefits_flag', ['Y' =>'Yes', 'N' =>'No'], empty(old('benefits_flag')) ? 'N': old('benefits_flag'), ['class' =>'form-control']) }}
							</div>
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label">
								Include Overtime Earnings?
							</label>
							<div class="uk-form-controls">
								{{ Form::select('overtime_flag', ['Y' =>'Yes', 'N' =>'No'], empty(old('overtime_flag')) ? 'N': old('overtime_flag'), ['class' =>'form-control']) }}
							</div>
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label">
								Post to Ledger?
							</label>
							<div class="uk-form-controls">
								{{ Form::select('post_ledger_flag', ['Y' =>'Yes', 'N' =>'No'], empty(old('post_ledger_flag')) ? 'N': old('post_ledger_flag'), ['class' =>'form-control']) }}
							</div>
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label">
								Auto-refund?
							</label>
							<div class="uk-form-controls">
								{{ Form::select('auto_refund_flag', ['Y' =>'Yes', 'N' =>'No'], empty(old('auto_refund_flag')) ? 'N': old('auto_refund_flag'), ['class' =>'form-control']) }}
							</div>
						</div>
					</fieldset>
				</div>
			</div>
      <div class="uk-modal-footer uk-text-right form-buttons">
      	<button class="uk-button btn-save" type="submit">
      		<span class="uk-icon uk-icon-refresh">
      		</span>
      		Generate
      	</button>
      	<button class="uk-button uk-modal-close btn-cancel">
      		<span class="uk-icon uk-icon-times-circle">
      		</span>
      		Cancel
      	</button>
      </div>
    </form>
  </div>
</div>
<!--end: modal for generate button-->

<!-- start: modal for delete button -->
<div id="delete" class="uk-modal">
	<div class="uk-modal-dialog">
		<button class="uk-modal-close uk-close"></button>
		<div class="uk-modal-header"><span class="uk-icon-trash"></span>Delete Confirmation</div>
		<div class="uk-margin uk-modal-content">
			Are you sure you want to delete the selected records?
		</div>
		<form action="{{ url('payrollmanagement/payrollprocess') }}" method="post" >
			{{ csrf_field() }}
			{{ Form::hidden('_method', 'delete') }}
			<div id="div-delete-chk-pp"></div>
			<div class="uk-modal-footer uk-text-right form-buttons">
				<button id="btn-del" class="uk-button btn-delete js-modal-confirm" type="submit">
					<span class="uk-icon uk-icon-trash"></span>
					Delete
				</button>
				<button class="uk-button uk-modal-close btn-cancel js-modal-cancel">
					<span class="uk-icon uk-icon-times-circle"></span>
					Cancel
				</button>
			</div>
		</form>
	</div>
</div>
<!--end: modal for delete button-->

@endsection

@section('scripts')
<script type="text/javascript" language="javascript" src="{{asset('js/table.js')}}"></script>
<script type="text/javascript" class="init">
$(document).ready(function() {
	
	$("#btn-regen-confirm").click(function() {
		$(".chk-payrollprocess:checked").each(function() {
			$('#div-regen-chk-pp').append('<input type="hidden" name="payrollprocess[]" value="'+ $(this).val() +'" />');
		});
	});
	
	$("#btn-del").click(function() {
		$(".chk-payrollprocess:checked").each(function() {
			$('#div-delete-chk-pp').append('<input type="hidden" name="payrollprocess[]" value="'+ $(this).val() +'" />');
		});
	});
	
	$("#btn-final").click(function() {
		$(".chk-payrollprocess:checked").each(function() {
			$('#div-final-chk-pp').append('<input type="hidden" name="payrollprocess[]" value="'+ $(this).val() +'" />');
		});
	});
	
	@if(Session::has('add-failed'))
	UIkit.modal('#add').show();
	@elseif(Session::has('put-failed'))
	$(".btn_profile").click();
	@endif
	$(".btn_profile").click(function() {});
	var dataTable = $('#payrollprocess').DataTable({
		order: [],
		columnDefs: [{
			orderable: false,
			targets: [0]
		}]
	});
	$('#select_all').click(function() {
		$(':checkbox', dataTable.rows().nodes()).prop('checked', this.checked);
	});
});
</script>
@endsection
