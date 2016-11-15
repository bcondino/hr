@extends('shared._public')

@section('title', 'Payroll Process Employee Details')

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-file-text"></span> <strong>Payroll Process Employee Details</strong> </h1>
		</div>
	</div>
</div>

    <div class="uk-container uk-container-center">
        <div class="uk-grid main">
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
    			
    		<div class="tm-main uk-width-3-4" >
    			<main>
	    			<div class="button-container">
	    				<a href="{{ url('payrollmanagement/payrollprocessdetails/'. $payroll_process_id) }}"><button class="uk-button btn-cancel" data-uk-modal="{target:'#generate'}"><span class="uk-icon uk-icon-arrow-left"></span> Back</button></a>
	    			</div>
	    					
					<div class="clearfix"></div>
			    		<article class="uk-article">
			    				<!-- start main content table -->
			    				
			    				<div class="uk-grid">
			    					<div class="uk-width-1-2">
			    						<div class="employee-detail_pay-process">
				    						<p class="pay-process_title">Pay Process:</p>
				    						<div class="pay-process_input">
				    							<p>{{ date('F d, Y', strtotime($payslip[0]->date_payroll))}} </p>
				    						</div>
			    						</div>
			    					</div>
			    					<div class="uk-width-1-2">
			    						<div class="employee-detail_pay-period">
				    						<p class="pay-period_title">Pay Period:</p>
				    						<div class="pay-period_input">
				    							<p>{{ date('F d, Y', strtotime($payslip[0]->date_from))}} - {{ date('F d, Y', strtotime($payslip[0]->date_to))}}</p>
				    						</div>
				    					</div>
			    					</div>
			    				</div>
			    				<div class="clearfix"></div> <hr>

								<div class="uk-grid uk-grid-divider">
			    					<div class="uk-width-1-3">
			    						<div class="uk-panel uk-panel-header employee-detail">
			    							<h3 class="uk-panel-title employee-detail_name">{{$employee->employee_name}}</h3>
			    							<div class="employee-detail_id-number">{{$employee->employee_number}}</div>
			    							<div class="employee-detail_unit">{{$employee->business_unit_name}}</div>
			    							<div class="employee-detail_position">{{$employee->position_name}}</div>
			    						</div>
			    					</div>
			    					<div class="uk-width-2-3">
			    						<div>
			    							<div class="uk-panel uk-panel-header">
			    								<h3 class="uk-panel-title">Earnings</h3>
			    								<div class="uk-grid uk-grid-collapse employee-detail_earnings">
			    									<table class="uk-table uk-table-hover uk-table-condensed">
			    										<tbody>
			    										<input type="hidden" value="{{$earn_subtot = 0}}">
			    											@foreach($payslip as $rec)
			    												@if($rec->entry_type == 'CR')
			    													<input type="hidden" value="{{$earn_subtot = $earn_subtot + $rec->entry_amt}}">
														        <tr>
														            <td class="detail_text" >{{$rec->element_name}}</td>
														            <td class="uk-text-right">{{number_format($rec->entry_amt,2)}}</td>
														         </tr>
														         @endif
													        @endforeach
													        <tr class="subtotal">
													            <td class="detail_text">Sub-total</td>
													            <td class="subtotal uk-text-right">{{number_format($earn_subtot, 2)}}</td>
													        </tr>
													    </tbody>
			    									</table>
			    								</div>
			    							</div>

			    							<div class="uk-panel uk-panel-header">
			    								<h3 class="uk-panel-title">Deductions</h3>
			    								<div class="uk-grid uk-grid-collapse employee-detail_deductions">
			    									<table class="uk-table uk-table-hover uk-table-condensed">
			    										<tbody>
			    										<input type="hidden" value="{{$dedn_subtot = 0}}">
													        @foreach($payslip as $rec)
			    												@if($rec->entry_type == 'DB')
			    												<input type="hidden" value="{{$dedn_subtot = $dedn_subtot + $rec->entry_amt}}">
														        <tr>
														            <td class="detail_text">{{$rec->element_name}}</td>
														            <td class="uk-text-right">{{number_format($rec->entry_amt,2)}}</td>
														         </tr>
														         @endif
													        @endforeach
													        <tr class="subtotal">
													            <td class="detail_text">Sub-total</td>
													            <td class="subtotal uk-text-right">{{number_format($dedn_subtot, 2)}}</td>
													        </tr>
													    </tbody>
			    									</table>
			    								</div>
			    							</div>

			    							<div class="uk-panel net-total">
			    								<div class="uk-grid">
			    									<div class="uk-width-2-3">
			    										<div class="net-total-title">Net Total</div>
			    									</div>
			    									<div class="uk-width-1-3">
			    										<div class="net-total-detail uk-text-right">{{number_format(($earn_subtot - $dedn_subtot), 2)}}</div>
			    									</div>
			    								</div>
			    							</div>

				    					</div>
			    					</div>
			    				</div>			    				
			    			</article>
					</main>

    			</div> <!-- end of tm-main -->
        	</div> <!-- end of grid -->
    </div> <!-- end of container -->
    
@endsection