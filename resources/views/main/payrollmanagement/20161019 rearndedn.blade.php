@extends('shared._public')

@section('title', 'Recurring Earnings and Deductions')

@section('styles')

@endsection

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-file-text"></span> <strong>Recurring Earnings and Deductions</strong></h1>
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
				<table id="rearndedn" class="uk-table uk-table-hover uk-table-striped payroll--table">
					<thead class="payroll--table_header">
						<tr>
				            <th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
							<th>Employee</th>
							<th>Payroll Entry</th>
							<th>Payroll Detail</th>
							<th>Schedule</th>
							<th>Amount</th>
							<th>Effective Start Date</th>
							<th>Effective End Date</th>
						</tr>
				    </thead>
				    <tbody>
				    	@foreach($rearndedns as $rearndedn)
							<tr>
					            <td> <input type="checkbox" id="select_all" class="chk-earndedns" name="earndedns[]" value="{{ $rearndedn->payroll_earndedn_id }}"/></td>
								<td> <a class="btn-rearndedn" data-uk-modal="{target:'#edit'}"
										data-recur_earndedn_id = "{{ $rearndedn->recur_earndedn_id }}"
										data-employee_id = "{{ $rearndedn->employee_id }}"
										data-entry_type = "{{ \App\tbl_payroll_element_model::find($rearndedn->payroll_element_id)->entry_type }}"
										data-payroll_element_id = "{{ $rearndedn->payroll_element_id }}"
										data-schedule = "{{ $rearndedn->dbcr_mode }}"
										data-amount = "{{ $rearndedn->amount }}"
										data-effective_start_date = <?php
list($year, $month, $day) = explode('-', substr($rearndedn->date_start, 0, 10));
echo $month . '/' . $day . '/' . $year?>
										data-effective_end_date = <?php
list($year, $month, $day) = explode('-', substr($rearndedn->date_end, 0, 10));
echo $month . '/' . $day . '/' . $year?>
										data-status = "{{ $rearndedn->status }}"
										data-payment_ctr = "{{ $rearndedn->payment_ctr }}"> <?php
$first_name = \App\tbl_employee_model::find($rearndedn->employee_id)->first_name;
$last_name = \App\tbl_employee_model::find($rearndedn->employee_id)->last_name;
$employee_number = \App\tbl_employee_model::find($rearndedn->employee_id)->employee_number;
echo $first_name . ' ' . $last_name . ' (' . $employee_number . ')';
?> </a> </td>
								<td> <?php
switch (\App\tbl_payroll_element_model::find($rearndedn->payroll_element_id)->entry_type) {
case 'CR':echo "Credit";
	break;
case 'DB':echo "Debit";
	break;
case 'EE':echo "Employee Contribution";
	break;
}?></td>
								<td> {{ \App\tbl_payroll_element_model::find($rearndedn->payroll_element_id)->description }}</td>
								<td> <?php
switch ($rearndedn->dbcr_mode) {
case 1:echo "1st cut off";
	break;
case 2:echo "2nd cut off";
	break;
case 3:echo "Every pay run";
	break;
}?> </td>
								<td> {{ $rearndedn->amount }} </td>
								<td> <?php
list($year, $month, $day) = explode('-', substr($rearndedn->date_start, 0, 10));
echo $month . '/' . $day . '/' . $year?> </td>
								<td> <?php
list($year, $month, $day) = explode('-', substr($rearndedn->date_end, 0, 10));
echo $month . '/' . $day . '/' . $year?> </td>
							</tr>
						@endforeach
					</tbody>
				</table> <!-- payroll management profile -->
			</article>
		</div>
	</div> <!-- grid -->
</div> <!-- container -->

<!-- start: modal for add button -->
<div id="add" class="uk-modal">
    <div class="uk-modal-dialog modal-wide">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Recurring Earnings and Deductions</div>

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

        <form class="uk-form uk-form-horizontal" method="post" action="">
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
				        			, ['class' => 'form-control']) }}
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
				        	<label class="uk-form-label">Schedule</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('dbcr_mode'
				        			, [null => '-- Select --'] +
				        				[1 => '1st cut off', 2 => '2nd cut off', 3 => 'Every pay run']
				        			, ''
				        			, ['class' => 'form-control']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Amount</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" placeholder="" name="amount" value="{{ old('amount') }}">
				        	</div>
				        </div>
				    </div>
				<div class="uk-width-1-2">
					<div class="uk-form-row">
						<label class="uk-form-label">Effective Start Date</label>
						<div class="uk-form-controls date-calendar" data-uk-form-select>
							<span class="uk-icon-calendar"></span>
							<input class="form-control" type="text" data-uk-datepicker="{format:'MM/DD/YYYY'}" name="date_start" value="{{ old('date_start') }}">
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label">Effective End Date</label>
						<div class="uk-form-controls date-calendar">
							<span class="uk-icon-calendar"></span>
							<input class="form-control" type="text" data-uk-datepicker="{format:'MM/DD/YYYY'}" name="date_end" value="{{ old('date_end') }}">
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label">Status</label>
						<div class="uk-form-controls">
							{{ Form::select('status'
								, [null => '-- Select --', 'Y' => 'Active', 'N' => 'Inactive']
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
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Edit Recurring Earnings and Deductions</div>

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

        <form class="uk-form uk-form-horizontal" method="post" action="">
        	{{ csrf_field() }}
        	{{ Form::hidden('_method', 'put') }}
        	{{ Form::hidden('recur_earndedn_id', old('recur_earndedn_id'), ['id' => 'put_recur_earndedn_id']) }}
        	<div class="uk-grid">
				<div class="uk-width-1-2">
				    <fieldset>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Employee</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('employee_id'
				        			, [null => '-- Select --'] + $employee
 				        			, old('employee_id')
				        			, ['class' => 'form-control', 'id' => 'put_employee_id']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Payroll Entry</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('entry_type'
				        			, [null => '-- Select --', 'CR' => 'Credit', 'DB' => 'Debit']
				        			, old('entry_type')
				        			, ['class' => 'form-control', 'id' => 'put_entry_type']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Payroll Detail</label>
				        	<div class="uk-form-controls">
				        		<select class="form-control" id="put_payroll_element_id" name="payroll_element_id">
				        			<option value=""> -- Select -- </option>
				        			@foreach($payroll_element as $element)
					        			<option value="{{ $element->payroll_element_id }}"> {{ $element->description }} </option>
				        			@endforeach
				        		</select>
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Schedule</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('dbcr_mode'
				        			, [null => '-- Select --'] +
				        				[1 => '1st cut off', 2 => '2nd cut off', 3 => 'Every pay run']
				        			, ''
				        			, ['class' => 'form-control', 'id' => 'put_dbcr_mode']) }}
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Amount</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" placeholder="" name="amount" value="{{ old('amount') }}" id="put_amount">				        	</div>
				        </div>
				    </div>
				<div class="uk-width-1-2">
					<div class="uk-form-row">
						<label class="uk-form-label">Effective Start Date</label>
						<div class="uk-form-controls date-calendar" data-uk-form-select>
							<span class="uk-icon-calendar"></span>
							<input class="form-control" type="text" data-uk-datepicker="{format:'MM/DD/YYYY'}" name="date_start" value="{{ old('date_start') }}" id="put_date_start">
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label">Effective End Date</label>
						<div class="uk-form-controls date-calendar">
							<span class="uk-icon-calendar"></span>
							<input class="form-control" type="text" data-uk-datepicker="{format:'MM/DD/YYYY'}" name="date_end" value="{{ old('date_end') }}" id="put_date_end">
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label">Status</label>
						<div class="uk-form-controls">
							{{ Form::select('status'
								, [null => '-- Select --', 'Y' => 'Active', 'N' => 'Inactive']
								, old('status')
								, ['class' => 'form-control', 'id' => 'put_status']) }}
						</div>
					</div>
					 <div class="uk-form-row">
						<label class="uk-form-label">Payment Counter</label>
						<div class="uk-form-controls">
							<input type="text" class="form-control" placeholder="" name="payment_ctr" value="{{ old('payment_ctr') }}" id="put_payment_ctr">
						</div>
					</div>
				    </fieldset>
				</div>
			</div>
		    <div class="uk-modal-footer uk-text-right form-buttons">
		    	<button class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span> Save</button>
				<button class="uk-button uk-modal-close btn-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
		    </div>
		</form>
    </div>
</div> <!-- end: modal for edit button -->

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
			    var entry_type = e.target.value;
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

			$("#put_entry_type").on('change', function(e){
			    var entry_type = e.target.value;
				$.get('recurring?entry_type=' + entry_type, function(data) {
				//success data
				$('#put_payroll_element_id').empty();
				$('#put_payroll_element_id').append("<option value=''> -- Select -- </option>");
				$.each(data, function(index, payroll_element){
					$('#put_payroll_element_id').append(
						"<option value=" +
							payroll_element.payroll_element_id +"> " +
							payroll_element.description + "</option>");
					});
				});
			});

			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
			@elseif(Session::has('put-failed'))
				$(".btn_profile").click();
			@endif

			$(".btn-rearndedn").click(function(){
				$("#put_recur_earndedn_id").val($(this).attr('data-recur_earndedn_id'))
				$("#put_employee_id").val($(this).attr('data-employee_id'));
				$("#put_entry_type").val($(this).attr('data-entry_type'));
				$("#put_payroll_element_id").val($(this).attr('data-payroll_element_id'));
				$("#put_dbcr_mode").val($(this).attr('data-schedule'));
				$("#put_amount").val($(this).attr('data-amount'));
				$("#put_date_start").val($(this).attr('data-effective_start_date'));
				$("#put_date_end").val($(this).attr('data-effective_end_date'));
				$("#put_status").val($(this).attr('data-status'));
				$("#put_payment_ctr").val($(this).attr('data-payment_ctr'));
			});

			var dataTable = $('#rearndedn').DataTable({
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