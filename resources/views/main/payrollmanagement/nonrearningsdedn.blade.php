@extends('shared._public')

@section('title', 'Non- Recurring Earnings and Deductions')

@section('styles')

@endsection

@section('content')

<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-file-text"></span> <strong>Non-Recurring Earnings and Deductions</strong></h1>
		</div>
	</div>
</div>

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
				<li><a href="{{ url('payrollmanagement/report') }}">Reports</a></li>
			</ul>
		</div>
		<div class="uk-width-3-4" >
			<article class="uk-article">

				<div class="button-container">

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
					<button class="uk-button btn-add" data-uk-modal="{target:'#add'}"><span class="uk-icon uk-icon-plus-circle"></span> Add</button>
					<button class="uk-button" data-uk-modal="{target:'#delete'}"><span class="uk-icon uk-icon-trash"></span>  Delete</button>
				</div>



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
								<td>
									<a class="row-nonrecurring" data-uk-modal="{target:'#edit'}"
										data-payroll_earndedn_id="{{ $nonrearningdedn->payroll_earndedn_id }}"
										data-employee_id="{{ $nonrearningdedn->employee_id }}"
										data-entry_type="{{ $nonrearningdedn->entry_type}}"
										data-payroll_element_id="{{ $nonrearningdedn->payroll_element_id }}"
										data-element_name="{{ $nonrearningdedn->element_name }}"
										data-year="{{ $nonrearningdedn->year }}"
										data-payroll_mode_id="{{ $nonrearningdedn->payroll_mode_id }}"
										data-payroll_mode="{{ $nonrearningdedn->payroll_mode }}"
										data-payroll_period_id="{{ $nonrearningdedn->payroll_period_id }}"
										data-payroll_period="{{ $nonrearningdedn->date_from.' to '.$nonrearningdedn->date_to }}"
										data-amount="{{ $nonrearningdedn->amount }}"
										data-special_run_flag="{{ $nonrearningdedn->special_run_flag }}"
									>
										{{ $nonrearningdedn->first_name.' '.$nonrearningdedn->last_name.' ('.$nonrearningdedn->employee_number.')'}}
									</a>
								</td>
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
	</div>
</div>


<div id="add" class="uk-modal">
    <div class="uk-modal-dialog modal-wide">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Non-Recurring Earnings and Deductions</div>

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
					</div>
					<div class="uk-width-1-2">
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Payroll Mode</label>
				        	<div class="uk-form-controls">
				        		<select class="form-control" name="payroll_mode_id" id="payroll_mode_id">
				        			<option value=""> -- Select -- </option>
				        		</select>
				        	</div>
				        </div>
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
				    </fieldset>
				</div>
			</div>
		    <div class="uk-modal-footer uk-text-right form-buttons">
		    	<button class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span> Add</button>
				<button class="uk-button uk-modal-close btn-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
		    </div>
		</form>
    </div>
</div>


<div id="edit" class="uk-modal">
    <div class="uk-modal-dialog modal-wide">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Edit Non-Recurring Earnings and Deductions</div>

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
        	{{ Form::hidden('payroll_earndedn_id', old('payroll_earndedn_id'), ['id' => 'put_payroll_earndedn_id']) }}
        	<div class="uk-grid">
				<div class="uk-width-1-2">
				    <fieldset>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Employee</label>
				        	<div class="uk-form-controls">
				        		{{ Form::select('employee_id'
				        			, [null => '-- Select --'] + $employee
 				        			, old('employee_id')
				        			, ['class' => 'form-control', 'id' => 'put_employee_id', 'disabled']) }}
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
				        		<select class="form-control" name="payroll_element_id" id="put_payroll_element_id">
				        			<option value=""> -- Select -- </option>
				        		</select>
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Year</label>
				        	<div class="uk-form-controls">
				        		<select class="form-control" name="payroll_year" id="put_year">
				        			<option value=""> -- Select -- </option>
				        		</select>
				        	</div>
				        </div>
					</div>
					<div class="uk-width-1-2">
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Payroll Mode</label>
				        	<div class="uk-form-controls">
				        		<select class="form-control" name="payroll_mode_id" id="put_payroll_mode_id">
				        			<option value=""> -- Select -- </option>
				        		</select>
				        	</div>
				        </div>
						<div class="uk-form-row">
							<label class="uk-form-label">Payroll Period</label>
							<div class="uk-form-controls date-calendar" data-uk-form-select>
								<select class="form-control" name="payroll_period_id" id="put_payroll_period_id">
					        		<option value=""> -- Select -- </option>
					        	</select>
							</div>
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label">Amount</label>
							<div class="uk-form-controls">
								{{ Form::text('amount', old('amount'), ['class' => 'form-control', 'id' => 'put_amount']) }}
							</div>
						</div>
						<div class="uk-form-row">
							<label class="uk-form-label">For Special Run</label>
							<div class="uk-form-controls">
								{{ Form::select('special_run_flag'
									, [null => '-- Select --', 'Y' => 'Yes', 'N' => 'No']
									, old('status')
									, ['class' => 'form-control', 'id' => 'put_special_run_flag']) }}
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
</div>

<div id="delete" class="uk-modal">
	<div class="uk-modal-dialog">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-trash"></span>Delete Confirmation</div>
    	<div class="uk-margin uk-modal-content">
    		Are you sure you want to delete the selected records?
    	</div>
    	<form method="post">
    		{{ csrf_field() }}
    		{{ Form::hidden('_method', 'delete') }}
	    	<div id="div-del-chk-nonrearndedn">
	    	</div>
		    <div class="uk-modal-footer uk-text-right form-buttons">
		    	<button id="btn-del" type="submit" class="uk-button btn-delete js-modal-confirm"><span class="uk-icon uk-icon-trash"></span> Delete</button>
		        <button type="button" class="uk-button uk-modal-close btn-cancel js-modal-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
		    </div>
		</form>
    </div>
</div>

@endsection

@section('scripts')

<script type="text/javascript" language="javascript" src="{{asset('js/table.js')}}"></script>
<script type="text/javascript" class="init">
	$(document).ready(
		function() {

			$("#btn-del").click(function(){
				$(".chk-nonrearningdedn:checked").each(function(){
					$('#div-del-chk-nonrearndedn').append('<input type="hidden" name="nonrearningdedns[]" value="'+ $(this).val() +'" />');
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

			$("#put_entry_type").on('change', function(e){
				console.log(e);
			    var entry_type = e.target.value;
				console.log(entry_type);

				$.get('recurring?entry_type=' + entry_type, function(data) {
					$('#put_payroll_element_id').empty();
					$('#put_payroll_element_id').append("<option value=''> -- Select -- </option>");
					$.each(data, function(index, payroll_element){
						$('#put_payroll_element_id').append(
							"<option value=" + 
								payroll_element.payroll_element_id +"> " +
								payroll_element.description + "</option>"
						);
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

			$("#put_employee_id").on('change', function(e){
				var employee_id = e.target.value;

				$.get('nonRecurringPayrollMode?employee_id=' + employee_id, function(data) {
					$('#put_payroll_mode_id').empty();
					$('#put_payroll_mode_id').append("<option value=''> -- Select -- </option>");
					$.each(data, function(index, payroll_mode){
						$('#put_payroll_mode_id').append("<option value=" + payroll_mode.payroll_mode_id + "> " + payroll_mode.description + "</option>");
					});
				});

				$.get('nonRecurringYear?employee_id=' + employee_id, function(data) {
					$('#put_payroll_year').empty();
					$('#put_payroll_year').append("<option value=''> -- Select -- </option>");
					$.each(data, function(index, payroll_year){
						$('#put_payroll_year').append("<option value=" + payroll_year.year + "> " + payroll_year.year + "</option>");
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

			$("#put_payroll_year").on('change', function (e) {
				var payroll_mode_id = $('#put_payroll_mode_id').val();
				var year = e.target.value;

				$.get('nonRecurringPayPeriod?payroll_mode_id=' + payroll_mode_id + '&year=' + year, function (data) {
					$('#put_payroll_period_id').empty();
					$('#put_payroll_period_id').append("<option value=''> -- Select -- </option>");
					$.each(data, function(index, payroll_period) {
						$('#put_payroll_period_id').append("<option value=" + payroll_period.payroll_period_id + "> " + 
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

			$("#put_payroll_mode_id").on('change', function (e) {
				var payroll_mode_id = e.target.value;
				var year = $('#put_payroll_year').val();

				$.get('nonRecurringPayPeriod?payroll_mode_id=' + payroll_mode_id + '&year=' + year, function (data) {
					$('#put_payroll_period_id').empty();
					$('#put_payroll_period_id').append("<option value=''> -- Select -- </option>");
					$.each(data, function(index, payroll_period) {
						$('#put_payroll_period_id').append("<option value=" + payroll_period.payroll_period_id + "> " + 
							payroll_period.date_from + " to " + payroll_period.date_to + "</option>");
					});
				});
			});

			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
			@elseif(Session::has('put-failed'))
				$(".row-nonrecurring").click();
			@endif

			$(".row-nonrecurring").click(function(){
				$("#put_payroll_earndedn_id").val($(this).attr('data-payroll_earndedn_id'));
				$("#put_employee_id").val($(this).attr('data-employee_id'));
				$("#put_entry_type").val($(this).attr('data-entry_type'));
				$("#put_payroll_element_id").empty();
				$("#put_payroll_element_id").append("<option value='" + $(this).attr('data-payroll_element_id') + "'>" + $(this).attr('data-element_name') + "</option>");
				$("#put_payroll_element_id").val($(this).attr('data-payroll_element_id'));
				$("#put_year").empty();
				$("#put_year").append("<option value='" + $(this).attr('data-year') + "'>" + $(this).attr('data-year') + "</option>");
				$("#put_year").val($(this).attr('data-year'));
				$("#put_payroll_mode_id").empty();
				$("#put_payroll_mode_id").append("<option value='" + $(this).attr('data-payroll_mode_id') + "'>" + $(this).attr('data-payroll_mode') + "</option>");
				$("#put_payroll_mode_id").val($(this).attr('data-payroll_mode_id'));
				$("#put_payroll_period_id").empty();
				$("#put_payroll_period_id").append("<option value='" + $(this).attr('data-payroll_period_id') + "'>" +$(this).attr('data-payroll_period') + "</option>");
				$("#put_payroll_period_id").val($(this).attr('data-payroll_period_id'));
				$("#put_amount").val($(this).attr('data-amount'));
				$("#put_special_run_flag").val($(this).attr('data-special_run_flag'));
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