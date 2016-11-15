@extends('shared._public')

@section('title', 'Payroll: Wage Order')

@section('styles')

@endsection

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-cogs"></span> Wage Order </a></h1>
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
						<li><a href="{{ url('home/payroll/payroll_parameter/earnings') }}">Earnings</a></li>
						<li><a href="{{ url('home/payroll/payroll_parameter/deductions') }}">Deductions</a></li>
					</ul>
				</li>
				<li><a href="{{ url('home/payroll/payroll_parameter/payroll_mode') }}">Payroll Mode</a></li>
				<li><a href="{{ url('home/payroll/payroll_parameter/payroll_period') }}">Payroll Period</a></li>
				<li><a href="{{ url('home/payroll/payroll_parameter/payroll_group') }}">Payroll Group</a></li>
				<li><a href="{{ url('home/payroll/payroll_parameter/payroll_template') }}">Payroll Template Parameter</a></li>
				<li><a href="{{ url('home/payroll/payroll_parameter/payroll_signatory') }}">Payroll Signatory</a></li>
				<li><a href="{{ url('home/payroll/payroll_parameter/overtime_paramenter') }}">Overtime Parameter</a></li>
				<li class="uk-active"><a href="{{ url('home/payroll/payroll_parameter/wage_order') }}">Wage Order</a></li>
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
				
				<table id="wage_order" class="uk-table uk-table-hover uk-table-striped payroll--table">
					<thead class="payroll--table_header">
						<tr> 
				            <th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
				            <th>Wage Order</th>
							<th>Region Name</th>
				            <th>Effective Date</th>
				            <th>Amount /Day</th>
				            <th>Amount / Month</th>
				            <th>Amount / Year</th>
				            <th>Factor</th>
						</tr>
					</thead>
					<tbody>
						@foreach($wage_orders as $wage_order)
							<tr>
				            	<td><label><input type="checkbox" id="select_all" class="chk-wageOrder" name="wageOrder_tbl[]" value="{{$wage_order->wage_order_id}}"></label></td>
						        <td><a class="btn-edit" data-uk-modal="{target:'#edit'}"  
								data-edit_wage_order_id="{{ $wage_order->wage_order_id}}"
								data-edit_region="{{ $wage_order->region}}"
								data-edit_description="{{ $wage_order->description}}"
								data-edit_wage_order="{{ $wage_order->wage_order}}"
								data-edit_effective_date="{{ $wage_order->effective_date}}"
								data-edit_per_day_amt="{{ $wage_order->per_day_amt}}"
								data-edit_per_month_amt="{{ $wage_order->per_month_amt}}"
								data-edit_per_year_amt="{{ $wage_order->per_year_amt}}"
								data-edit_factor="{{ $wage_order->factor}}">
								{{ $wage_order->wage_order }}</a></td>
						        <td>{{ $wage_order->description }}</td>
								 <td>{{ $wage_order->effective_date }}</td>
						        <td>{{ $wage_order->per_day_amt }}</td>
						        <td>{{ $wage_order->per_month_amt }}</td>
								<td>{{ $wage_order->per_year_amt }}</td>
						        <td>{{ $wage_order->factor }}</td>
							</tr>
						@endforeach
					</tbody>
				</table> <!-- wage order -->

			</article>
		</div>		
	</div> <!-- grid -->
</div> <!-- container -->

<!-- start: modal for add button -->
<div id="add" class="uk-modal">
<div class="uk-modal-dialog">
<button class="uk-modal-close uk-close"></button>
<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Wage Order</div>
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
<form class="uk-form uk-form-horizontal" method="post" action="{{url('home/payroll/payroll_parameter/wage_order')}}" >{{csrf_field()}}
    <fieldset>
        <div class="uk-form-row">
        	<label class="uk-form-label">Region</label>
        	<div class="uk-form-controls">
        		<input type="text" class="form-control" name ="region" placeholder="" value="{{old('region')}}">
        	</div>
        </div>
        <div class="uk-form-row">
        	<label class="uk-form-label">Description</label>
        	<div class="uk-form-controls">
        		<input type="text" class="form-control" name ="description" placeholder="" value="{{old('description')}}">
        	</div>
        </div>
        <div class="uk-form-row">
        	<label class="uk-form-label">Wage Order</label>
        	<div class="uk-form-controls">
        		<input type="text" class="form-control" name ="wage_order" placeholder="" value="{{old('wage_order')}}">
        	</div>
        </div>
        <div class="uk-form-row">
        	<label class="uk-form-label">Effective Date</label>
        	<div class="uk-form-controls date-calendar" data-uk-form-select>
        		<span class="uk-icon-calendar"></span>
        		<input class="form-control" name ="effective_date" placeholder="DD/MM/YYYY" type="text" data-uk-datepicker="{format:'DD/MM/YYYY'}" value="{{old('effective_date')}}">
        	</div>
        </div>
        <div class="uk-form-row">
        	<label class="uk-form-label">Daily Wage</label>
        	<div class="uk-form-controls">
        		<input type="text" class="form-control" name ="per_day_amt" placeholder="" value="{{old('per_day_amt')}}">
        	</div>
        </div>
        <div class="uk-form-row">
        	<label class="uk-form-label">Monthly Wage</label>
        	<div class="uk-form-controls">
        		<input type="text" class="form-control" name ="per_month_amt" placeholder="" value="{{old('per_month_amt')}}">
        	</div>
        </div>
        <div class="uk-form-row">
        	<label class="uk-form-label">Yearly Wage</label>
        	<div class="uk-form-controls">
        		<input type="text" class="form-control" name ="per_year_amt" placeholder="" value="{{old('per_year_amt')}}">
        	</div>
        </div>
        <div class="uk-form-row">
        	<label class="uk-form-label">Factor</label>
        	<div class="uk-form-controls">
        		<input type="text" class="form-control" name ="factor" placeholder="" value="{{old('factor')}}">
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
<div class="uk-modal-header"><span class="uk-icon-edit"></span>Edit Wage Order</div>
<form class="uk-form uk-form-horizontal" method="post" action="{{url('home/payroll/payroll_parameter/wage_order/put')}}" >{{csrf_field()}}
	<input type="hidden" name="wage_orders" value="{{old('wage_orders')}}" />		
    <fieldset>
             <div class="uk-form-row">
        	<label class="uk-form-label">Region</label>
        	<div class="uk-form-controls">
        		<input type="text" class="form-control" name ="region" id="edit_region" placeholder="" value="{{old('region')}}">
        	</div>
        </div>
        <div class="uk-form-row">
        	<label class="uk-form-label">Description</label>
        	<div class="uk-form-controls">
        		<input type="text" class="form-control" name ="description" id="edit_description" placeholder="" value="{{old('description')}}">
        	</div>
        </div>
        <div class="uk-form-row">
        	<label class="uk-form-label">Wage Order</label>
        	<div class="uk-form-controls">
        		<input type="text" class="form-control" name ="wage_order" id="edit_wage_order" placeholder="" value="{{old('wage_order')}}">
        	</div>
        </div>
        <div class="uk-form-row">
        	<label class="uk-form-label">Effective Date</label>
        	<div class="uk-form-controls date-calendar" data-uk-form-select>
        		<span class="uk-icon-calendar"></span>
        		<input class="form-control" name ="effective_date" id="edit_effective_date" placeholder="DD/MM/YYYY" type="text" data-uk-datepicker="{format:'DD/MM/YYYY'}" value="{{old('effective_date')}}">
        	</div>
        </div>
        <div class="uk-form-row">
        	<label class="uk-form-label">Daily Wage</label>
        	<div class="uk-form-controls">
        		<input type="text" class="form-control" name ="per_day_amt" id="edit_per_day_amt" placeholder="" value="{{old('per_day_amt')}}">
        	</div>
        </div>
        <div class="uk-form-row">
        	<label class="uk-form-label">Monthly Wage</label>
        	<div class="uk-form-controls">
        		<input type="text" class="form-control" name ="per_month_amt"  id="edit_per_month_amt" placeholder="" value="{{old('per_month_amt')}}">
        	</div>
        </div>
        <div class="uk-form-row">
        	<label class="uk-form-label">Yearly Wage</label>
        	<div class="uk-form-controls">
        		<input type="text" class="form-control" name ="per_year_amt" id="edit_per_year_amt" placeholder="" value="{{old('per_year_amt')}}">
        	</div>
        </div>
        <div class="uk-form-row">
        	<label class="uk-form-label">Factor</label>
        	<div class="uk-form-controls">
        		<input type="text" class="form-control" name ="factor"  id="edit_factor" placeholder="" value="{{old('factor')}}">
        	</div>
        </div>

    </fieldset>
    <div class="uk-modal-footer uk-text-right form-buttons">
    	<button class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span> Save Changes</button>

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
    	<form method="post" action="{{url('home/payroll/payroll_parameter/wage_order/put')}}" >{{csrf_field()}}
	    	<input type="hidden" name="isDelete" value="1"> 
	    	<div id="div-del-chk-wageOrder">
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
					$(".chk-wageOrder:checked").each(function(){
					$('#div-del-chk-wageOrder').append('<input type="hidden" name="wageOrder_tbl[]" value="'+ $(this).val() +'" />');
					});
				});
				
		
			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
				@elseif(Session::has('edit-failed'))
				$(".btn-edit").click();
				@endif
			
			$("input[name|=wage_orders]").val( $(this).attr('data-edit_wage_order_id') );
					$("#edit_region").val( $(this).attr('data-edit_region') );
					$("#edit_description").val( $(this).attr('data-edit_description') );
					$("#edit_wage_order").val( $(this).attr('data-edit_wage_order') );
					$("#edit_effective_date").val( $(this).attr('data-edit_effective_date') );
					$("#edit_per_day_amt").val( $(this).attr('data-edit_per_day_amt') );
					$("#edit_per_month_amt").val( $(this).attr('data-edit_per_month_amt') );
					$("#edit_per_year_amt").val( $(this).attr('data-edit_per_year_amt') );
					$("#edit_factor").val( $(this).attr('data-edit_factor') );
				});
				
				var dataTable = $('#wage_order').DataTable({
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