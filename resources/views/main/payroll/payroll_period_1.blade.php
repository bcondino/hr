@extends('shared._public')

@section('title', 'Payroll: Tax Exemption')

@section('styles')

@endsection

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-cogs"></span> Tax Exemption </a></h1>
		</div>
	</div>
</div>

<!-- list payroll setup -->
<div class="uk-container uk-container-center">
	<div class="uk-grid main">
		<div class="uk-width-1-4">
			<ul class="uk-nav uk-nav-side uk-nav-parent-icon" data-uk-nav>
				<li><a href="{{ url('home/payroll/payroll_parameter/tax_exemption') }}">Tax Exemption</a></li>
				<li><a href="{{ url('home/payroll/payroll_parameter/tax_table') }}">Tax Table</a></li>
				<li><a href="{{ url('home/payroll/payroll_parameter/annual_tax_table') }}">Annual Tax Table</a></li>
				<li><a href="{{ url('home/payroll/payroll_parameter/sss_table') }}">SSS Table</a></li>
				<li><a href="{{ url('home/payroll/payroll_parameter/pagibig_table') }}">Pagibig Table</a></li>
				<li><a href="{{ url('home/payroll/payroll_parameter/philhealth_table') }}">Philhealth Table</a></li>
				<li><a href="{{ url('home/payroll/payroll_parameter/payment_disbursement') }}">Payment Disbursement</a></li>
				<li class="uk-parent"><a href="#">Payroll Details</a>
					<ul class="uk-nav-sub">
						<li><a href="pp-payroll_element.html">Earnings</a></li>
						<li><a href="#">Deductions</a></li>
					</ul>
				</li>
				<li><a href="{{ url('home/payroll/payroll_parameter/payroll_mode') }}">Payroll Mode</a></li>
				<li class="uk-active"><a href="{{ url('home/payroll/payroll_parameter/payroll_period') }}">Payroll Period</a></li>
				<li><a href="{{ url('home/payroll/payroll_parameter/payroll_group') }}">Payroll Group</a></li>
				<li><a href="{{ url('home/payroll/payroll_parameter/payroll_template') }}">Payroll Template Parameter</a></li>
				<li><a href="{{ url('home/payroll/payroll_parameter/payroll_signatory') }}">Payroll Signatory</a></li>
				<li><a href="{{ url('home/payroll/payroll_parameter/overtime_paramenter') }}">Overtime Parameter</a></li>
				<li><a href="{{ url('home/payroll/payroll_parameter/wage_order') }}">Wage Order</a></li>
			</ul>
		</div> <!-- payroll parameter list -->
		<div class="uk-width-3-4" >
			<article class="uk-article">

				<!-- buttons -->
				<div class="button-container">
					<button class="uk-button btn-add" data-uk-modal="{target:'#add'}"><span class="uk-icon uk-icon-plus-circle"></span> Add</button>
					<button class="uk-button" data-uk-modal="{target:'#delete'}"><span class="uk-icon uk-icon-trash"></span>  Delete</button>
				</div> <!-- buttons -->

				<!-- tax exemption -->
				<table id="tax_exemption" class="uk-table uk-table-hover uk-table-striped payroll--table">
					<thead class="payroll--table_header">
						<tr> 
				            <th></th>
				            <th>Year</th>
				            <th>Payroll Mode</th>
				            <th>Days</th>
				            <th>Hours/Day</th>
				            <th>Hours/Payday</th>
				            <th>Days/Mon</th>
				            <th>Days/Year</th>
						</tr>
					</thead>
					<tbody>
						@foreach($payroll_periods as $payroll_period)
							<tr>
						        <td><a href="pp-payroll_period_details.html"></a></td>
						        <td>{{ $payroll_period->year }}</td>
						        <td>{{ \App\tbl_payroll_mode::where('payroll_mode', $payroll_period->mode)->first()->month }}</td>
						        <td>{{ $payroll_period->hrs_day }}</td>
						        <td>{{ $payroll_period->hrs_pay }}</td>
						        <td>{{ $payroll_period->days_mo }}</td>
						        <td>{{ $payroll_period->days_yrs }}</td>
							</tr>
						@endforeach
					</tbody>
				</table> <!-- tax exemption -->
			</article>
		</div>		
	</div> <!-- grid -->
</div> <!-- container -->

@endsection

@section('scripts')

<script type="text/javascript" language="javascript" src="{{asset('js/table.js')}}"></script>
<script type="text/javascript" class="init">
	$(document).ready(
		function() {
			$('#tax_exemption').DataTable();
		}
	);
</script>

@endsection