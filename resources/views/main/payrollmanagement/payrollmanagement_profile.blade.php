@extends('shared._public')

@section('title', 'Payroll: Payroll Profile')

@section('styles')

@endsection

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-cogs"></span> Payroll Management: Payroll Profile</h1>
		</div>
	</div>
</div>

<!-- list payroll profile setup -->
<div class="uk-container uk-container-center">
	<div class="uk-grid main">
		<div class="uk-width-1-4">
			<ul class="uk-nav uk-nav-side uk-nav-parent-icon" data-uk-nav>
				<li class="uk-active"><a href="#">Payroll Profile</a></li>
				<li class="uk-parent"><a href="#">Earnings and Deductions </a>
					<ul class="uk-nav-sub">
						<li><a href="pm-recurring_ed.html">Recurring Earnings and Deductions</a></li>
						<li><a href="pm-nonrecurring_ed.html">Non-recurring Earnings and Deductions</a></li>
					</ul>
				</li>
				<li><a href="pm-payroll_process.html">Payroll Process</a></li>
			</ul>
		</div>
		<div class="uk-width-3-4" >
			<article class="uk-article">

				<!-- buttons -->
				<div class="button-container">
					<button class="uk-button btn-add" data-uk-modal="{target:'#add'}"><span class="uk-icon uk-icon-plus-circle"></span> Add</button>
					<button class="uk-button" data-uk-modal="{target:'#delete'}"><span class="uk-icon uk-icon-trash"></span>  Delete</button>
				</div> <!-- buttons -->

				<!-- tax exemption -->
				<table id="profile" class="uk-table uk-table-hover uk-table-striped payroll--table">
					<thead class="payroll--table_header">
						        <tr>
						            <th></th>
						            <th>Payroll Group</th>
						            <th>Fixed WT Amount</th>
						            <th>Additional WT Amount</th>
						            <th>Substitute Filling</th>
						            <th>SSS Deduction</th>
						            <th>Pagibig Deduction</th>
						            <th>Pagibig Fix Amount</th>
						            <th>Philhealth Deduction</th>
						        </tr>
						    </thead>
				    <tbody>
						        <tr>
						            <td>
						            	<label><input type="checkbox"></label>
						            </td>
						            <td>Confidential</td>
						            <td>0.00</td>
						            <td>0.00</td>
						            <td>Y</td>
						            <td>Y</td>
						            <td>Y</td>
						            <td>0.00</td>
						            <td>Y</td>
						        </tr>
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
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Payroll Profile</div>
        <form class="uk-form uk-form-horizontal" >
        	<div class="uk-grid">
				<div class="uk-width-1-2">
				    <fieldset>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Payroll Group</label>
				        	<div class="uk-form-controls">
				        		<select class="form-control">
				        			<option>--Select--</option>
				        			<option>Regular</option>
				        			<option>Confidential</option>
				        		</select>
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Fixed Withholding Tax</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" placeholder="">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Additional Withholding Tax</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" placeholder="">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Subtitute Filling</label>
				        	<div class="uk-form-controls">
				        		<select class="form-control">
				        			<option>Yes</option>
				        			<option>No</option>
				        		</select>
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">With SSS Deduction</label>
				        	<div class="uk-form-controls">
				        		<select class="form-control">
				        			<option>Yes</option>
				        			<option>No</option>
				        		</select>
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">With Pagibig Deduction </label>
				        	<div class="uk-form-controls">
				        		<select class="form-control">
				        			<option>Yes</option>
				        			<option>No</option>
				        		</select>
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Pagibig Fixed Amount</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" placeholder="">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Deduct Pagibig Deduction </label>
				        	<div class="uk-form-controls">
				        		<select class="form-control">
				        			<option>Yes</option>
				        			<option>No</option>
				        		</select>
				        	</div>
				        </div>
				</div>
				<div class="uk-width-1-2">
				        <h4 style="font-weight:bold;">Applicable only to Monthly Wage Earner</h4>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">SSS Deduction Based on Salary</label>
				        	<div class="uk-form-controls">
				        		<select class="form-control">
				        			<option>Yes</option>
				        			<option>No</option>
				        		</select>
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Pagibig Deduction Based on Salary</label>
				        	<div class="uk-form-controls">
				        		<select class="form-control">
				        			<option>Yes</option>
				        			<option>No</option>
				        		</select>
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Philhealth Deduction Based on Salary</label>
				        	<div class="uk-form-controls">
				        		<select class="form-control">
				        			<option>Yes</option>
				        			<option>No</option>
				        		</select>
				        	</div>
				        </div>

				        <h4 style="font-weight:bold;">Applicable only to Daily Wage Earner using Fixed Amount</h4>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">SSS Deduction Based on Fixed Salary Base</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" placeholder="">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Pagibig Deduction Based on Fixed Salary Base</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" placeholder="">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Philhealth Deduction Based on Fixed Salary Base</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" placeholder="">
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

@endsection

@section('scripts')

<script type="text/javascript" language="javascript" src="{{asset('js/table.js')}}"></script>
<script type="text/javascript" class="init">
	$(document).ready(
		function() {
			$('#profile').DataTable();
		}
	);
</script>

@endsection