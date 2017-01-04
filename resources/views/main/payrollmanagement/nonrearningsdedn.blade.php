@extends('shared._public')

@section('title', 'Non- Recurring Earnings and Deductions')

@section('styles')

@endsection

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-file-text"></span> <strong>Non-Recurring Earnings and Deductions</strong></h1>
		</div>
	</div>
</div>

<!-- list payroll profile setup -->
<div class="uk-container uk-container-center">
	<div class="uk-grid main">
		<div class="uk-width-1-4">
			<ul class="uk-nav uk-nav-side uk-nav-parent-icon" data-uk-nav>
				<li><a href="{{ url('payrollmanagement/profile') }}">Payroll Profile</a></li>
				<li class="uk-parent uk-active"><a href="#">Earnings and Deductions </a>
					<ul class="uk-nav-sub">
						<li><a href="{{ url('payrollmanagement/rearningsdedn') }}">Recurring Earnings and Deductions</a></li>
						<li><a href="{{ url('payrollmanagement/nonrearningsdedn') }}">Non-recurring Earnings and Deductions</a></li>
					</ul>
				</li>
				<li><a href="{{ url('payrollmanagement/payrollprocess') }}">Payroll Process</a></li>
				<!-- 20161027 updated by Melvin Militante; Reason: To add payroll report interface -->
				<li><a href="{{ url('payrollmanagement/report') }}">Reports</a></li>
			</ul>
		</div>
		<div class="uk-width-3-4" >
			<article class="uk-article">
				<!-- buttons -->
				<div class="button-container">
					<button class="uk-button btn-add" data-uk-modal="{target:'#add'}"><span class="uk-icon uk-icon-plus-circle"></span> Add</button>
					<button class="uk-button" data-uk-modal="{target:'#delete'}"><span class="uk-icon uk-icon-trash"></span>  Delete</button>
				</div> <!-- buttons -->

				<!-- recurrning earnings and reductions -->
				<table id="nonrearningsdedn" class="uk-table uk-table-hover uk-table-striped payroll--table">
				    <thead class="payroll--table_header">
				        <tr>
				            <th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
							<th>Employee</th>
							<th>Payroll Entry</th>
							<th>Payroll Detail</th>
							<th>Payroll Mode</th>
							<th>Amount</th>
							<th>Payroll Period</th>
				        </tr>
				    </thead>
					<tbody>
						@foreach($nonrearningsdedn as $nonrearningdedn)
							<tr>
					            <td> <input type="checkbox" id="select_all" class="chk-nonrearningdedn" name="nonrearningdedn[]" value="{{ $nonrearningdedn->payroll_earndedn_id }}"/></td>
								<td> {{ $nonrearningdedn->first_name.' '.$nonrearningdedn->last_name.' ('.$nonrearningdedn->employee_number.')'}}</td>
								@if ($nonrearningdedn->entry_type == 'CR')
									<td> Credit </td>
								@elseif ($nonrearningdedn->entry_type == 'DB')
									<td> Debit </td>
								@endif
								<td> {{ $nonrearningdedn->element_name }} </td>
								<td> {{ $nonrearningdedn->payroll_mode }} </td>
								<td> {{ $nonrearningdedn->amount }} </td>
								<td> {{ $nonrearningdedn->date_from.' to '.$nonrearningdedn->date_to }} </td>								
							</tr>
						@endforeach
					</tbody>
				</table>
			</article>
		</div>		
	</div> <!-- grid -->
</div> <!-- container -->

<!-- start: modal for add button -->
<div id="add" class="uk-modal">
    <div class="uk-modal-dialog modal-wide">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Non-recurring Deduction</div>

    	@if(Session::has('add-failed'))
			@if($errors->has())
				<div class="uk-alert uk-alert-danger ">
					@foreach ($errors->all() as $error)
						<p class="uk-text-left"> <span class="uk-icon-close"></span> {{ $error }} </p>
					@endforeach
				</div>
			@endif
		@endif

        <form class="uk-form uk-form-horizontal" action="nonrearningsdedn" method="post">
        	{{ csrf_field() }}
        	<div class="uk-grid">
				<div class="uk-width-1-2">
				    <fieldset>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Employee</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('employee_id'
				        			, [null => '-- Select --'] + $employee
 				        			, old('employee_id')
				        			, ['class' => 'form-control', 'id' => 'employee_id']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Payroll Entry</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('entry_type'
				        			, [null => '-- Select --', 'CR' => 'Credit', 'DB' => 'Debit']
				        			, old('entry_type')
				        			, ['class' => 'form-control', 'id' => 'entry_type']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Payroll Detail</label>
				        	<div class="uk-form-controls">
				        		<select class="form-control" name="payroll_element_id" id="payroll_element_id">
				        			<option value=""> -- Select -- </option>
				        		</select>
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Year</label>
				        	<div class="uk-form-controls">
				        		<select class="form-control" name="payroll_year" id="payroll_year">
				        			<option value=""> -- Select -- </option>
				        		</select>
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Payroll Mode</label>
				        	<div class="uk-form-controls">
				        		<select class="form-control" name="payroll_mode_id" id="payroll_mode_id">
				        			<option value=""> -- Select -- </option>
				        		</select>
				        	</div>
				        </div>
				    </div>
				<div class="uk-width-1-2">
					<div class="uk-form-row">
						<label class="uk-form-label">Payroll Period</label>
						<div class="uk-form-controls date-calendar" data-uk-form-select>
							<select class="form-control" name="payroll_period_id" id="payroll_period_id">
				        		<option value=""> -- Select -- </option>
				        	</select>
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label">Amount</label>
						<div class="uk-form-controls">
							{{ Form::text('amount', old('amount'), ['class' => 'form-control']) }}
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label">For Special Run</label>
						<div class="uk-form-controls">
							{{ Form::select('special_run_flag'
								, [null => '-- Select --', 'Y' => 'Yes', 'N' => 'No']
								, old('status')
								, ['class' => 'form-control']) }}
						</div>
					</div>
					 <div class="uk-form-row">
						<label class="uk-form-label">Payment Counter</label>
						<div class="uk-form-controls">
							<input type="text" class="form-control" placeholder="" name="payment_ctr" value="{{ old('payment_ctr') }}">
						</div>
					</div>
				    </fieldset>
				</div>
			</div>
		    <div class="uk-modal-footer uk-text-right form-buttons">
		    	<button class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span> Add</button>
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
				$(".chk-profile:checked").each(function(){
					$('#div-del-chk-profile').append('<input type="hidden" name="profiles[]" value="'+ $(this).val() +'" />');
				});
			});

			$("#entry_type").on('change', function(e){
				console.log(e);
			    var entry_type = e.target.value;
				console.log(entry_type);

			$.get('recurring?entry_type=' + entry_type, function(data) {
				//success data
				$('#payroll_element_id').empty();
				$('#payroll_element_id').append("<option value=''> -- Select -- </option>");
				$.each(data, function(index, payroll_element){
					$('#payroll_element_id').append(
						"<option value=" + 
							payroll_element.payroll_element_id +"> " +
							payroll_element.description + "</option>");			
					});
				});
			});

			$("#employee_id").on('change', function(e){
				var employee_id = e.target.value;

				$.get('nonRecurringPayrollMode?employee_id=' + employee_id, function(data) {
					$('#payroll_mode_id').empty();
					$('#payroll_mode_id').append("<option value=''> -- Select -- </option>");
					$.each(data, function(index, payroll_mode){
						$('#payroll_mode_id').append("<option value=" + payroll_mode.payroll_mode_id + "> " + payroll_mode.description + "</option>");
					});
				});

				$.get('nonRecurringYear?employee_id=' + employee_id, function(data) {
					$('#payroll_year').empty();
					$('#payroll_year').append("<option value=''> -- Select -- </option>");
					$.each(data, function(index, payroll_year){
						$('#payroll_year').append("<option value=" + payroll_year.year + "> " + payroll_year.year + "</option>");
					});
				});

			});

			$("#payroll_year").on('change', function (e) {
				var payroll_mode_id = $('#payroll_mode_id').val();
				var year = e.target.value;

				$.get('nonRecurringPayPeriod?payroll_mode_id=' + payroll_mode_id + '&year=' + year, function (data) {
					$('#payroll_period_id').empty();
					$('#payroll_period_id').append("<option value=''> -- Select -- </option>");
					$.each(data, function(index, payroll_period) {
						$('#payroll_period_id').append("<option value=" + payroll_period.payroll_period_id + "> " + 
							payroll_period.date_from + " to " + payroll_period.date_to + "</option>");
					});
				});
			});

			$("#payroll_mode_id").on('change', function (e) {
				var payroll_mode_id = e.target.value;
				var year = $('#payroll_year').val();

				$.get('nonRecurringPayPeriod?payroll_mode_id=' + payroll_mode_id + '&year=' + year, function (data) {
					$('#payroll_period_id').empty();
					$('#payroll_period_id').append("<option value=''> -- Select -- </option>");
					$.each(data, function(index, payroll_period) {
						$('#payroll_period_id').append("<option value=" + payroll_period.payroll_period_id + "> " + 
							payroll_period.date_from + " to " + payroll_period.date_to + "</option>");
					});
				});
			});

			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
			@elseif(Session::has('put-failed'))
				$(".btn_profile").click();
			@endif

			$(".btn_profile").click(function(){
				$("#payroll_profile_id").val($(this).attr('data-payroll_profile_id'));
				$("#payroll_group_id").val($(this).attr('data-payroll_group_id'));
				$("#tax_fix_amt").val($(this).attr('data-tax_fix_amt'));
				$("#add_tax_amt").val($(this).attr('data-add_tax_amt'));
				$("#sub_filling_flag").val($(this).attr('data-sub_filling_flag'));
				$("#ded_sss_flag").val($(this).attr('data-ded_sss_flag'));
				$("#ded_pagibig_flag").val($(this).attr('data-ded_pagibig_flag'));
				$("#ded_philhealth_flag").val($(this).attr('data-ded_philhealth_flag'));
				$("#pagibig_fix_amt").val($(this).attr('data-pagibig_fix_amt'));
				$("#ded_philhealth_flag").val($(this).attr('data-ded_philhealth_flag'));
				$("#ded_sss_basic_flag").val($(this).attr('data-ded_sss_basic_flag'));
				$("#ded_pagibig_basic_flag").val($(this).attr('data-ded_pagibig_basic_flag'));
				$("#ded_sss_sb_amt").val($(this).attr('data-ded_sss_sb_amt'));
				$("#ded_pagibig_sb_amt").val($(this).attr('data-ded_pagibig_sb_amt'));
				$("#ded_philhealth_sb_amt").val($(this).attr('data-ded_philhealth_sb_amt'));
			});

			var dataTable = $('#nonrearningsdedn').DataTable({
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