@extends('shared._public')

@section('title', 'Payroll: Overtime Parameter')

@section('styles')

@endsection

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-file-text"></span><strong>Overtime Parameter</strong> </a></h1>
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
				<li class="uk-active"><a href="{{ url('payroll/overtimeparamenter') }}">Overtime Parameter</a></li>
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
				
				<!-- overtime parameter -->
				<table id="overtime_parameter" class="uk-table uk-table-hover uk-table-striped payroll--table">
					<thead class="payroll--table_header">
						<tr> 
				            <th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
				            <th>Description</th>
				            <th>Overtime Type</th>
				            <th>Overtime Category</th>
				            <th>Rate</th>
				            <th>Time from</th>
				            <th>Time to</th>
						</tr>
					</thead>
					<tbody>
					@foreach($overtimes as $overtime)
						<tr>
				            <td><label><input type="checkbox" id="select_all" class="chk-overtime" name="overtime_tbl[]" value="{{$overtime->overtime_id}}" /></label></td>
					        <td><a class="btn-edit" data-uk-modal="{target:'#edit'}" 
							data-edit_overtime_id="{{ $overtime->overtime_id}}"
							data-edit_description="{{ $overtime->description}}"
							data-edit_overtime_type_id="{{ $overtime->overtime_type_id}}"
							data-edit_overtime_category_id="{{ $overtime->overtime_category_id}}"
							data-edit_time_from="{{ $overtime->time_from}}"
							data-edit_time_to="{{ $overtime->time_to}}"
							data-edit_payroll_element_id="{{ $overtime->payroll_element_id}}"
							data-edit_first_hour="{{ $overtime->first_hour}}"
							data-edit_rate="{{ $overtime->rate}}"
							data-edit_date_overlap_flag="{{ $overtime->date_overlap_flag}}"
									
							>{{$overtime->description}}</a></td>
							<td>{{ \App\tbl_overtime_type_model::where('overtime_type_id', $overtime->overtime_type_id)->first()->overtime_type }}</td>
							
							<td>{{ \App\tbl_overtime_category_model::where('overtime_category_id', $overtime->overtime_category_id)->first()->description }}</td>

							
					        <td>{{$overtime->rate}}</td>
					        <td>{{$overtime->time_from}}</td>
					        <td>{{$overtime->time_to}}</td>
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
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Overtime Parameter</div>
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
         <form class="uk-form uk-form-horizontal" method="post" action="{{url('payroll/overtimeparamenter')}}">
         	{{ csrf_field() }}
		    <fieldset>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Description</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="description" placeholder="" value="{{old('description')}}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Overtime Type</label>
		        	<div class="uk-form-controls">
		        		{{ Form::select('overtime_type_id',  
							[null => '-- Select --'] + \App\tbl_overtime_type_model::first()->lists('description', 'overtime_type_id') -> toArray() ,old('overtime_type_id'), 
							array('class'=>'form-control')) }}
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Overtime Category</label>
		        	<div class="uk-form-controls">
		        	{{ Form::select('overtime_category_id',  
						[null => '-- Select --'] + \App\tbl_overtime_category_model::first()->lists('description', 'overtime_category_id') -> toArray() ,old('overtime_category_id'), 
						array('class'=>'form-control')) }}
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Time Covered</label>
		        	<div class="timecoverage uk-form-controls">
		        		<input class="timestart" type="text" name="time_from" data-uk-timepicker="{format:'12h'}" placeholder="00:00AM" value="{{old('time_from')}}"> <span class="timecoverage-separator">to</span>
		        		<input class="timeend" type="text" name="time_to" data-uk-timepicker="{format:'12h'}" placeholder="00:01AM" value="{{old('time_to')}}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Payroll Element</label>
		        	<div class="uk-form-controls">
		        		{{ Form::select('payroll_element_id'
		        		, [null => '-- Select --'] + 
							$payroll_elements
							->lists('description', 'payroll_element_id')
							->toArray()
						, old('payroll_element_id')
						, array('class'=>'form-control')) }}
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> First Hour</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="first_hour" placeholder="" value="{{old('first_hour')}}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Rate (in decimal)</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="rate" placeholder="" value="{{old('rate')}}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Is Date Overlap?</label>
		        	<div class="uk-form-controls">
		        		{{ Form::select('date_overlap_flag'
		        			, [null => '-- Select --', 'Y' => 'Yes', 'N' => 'No']
		        			, old('date_overlap_flag')
		        			, array('class'=>'form-control')) }}
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
    	<div class="uk-modal-header"><span class="uk-icon-edit"></span>Edit Overtime Parameter</div>
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
        <form class="uk-form uk-form-horizontal" method="post" action="{{ url('payroll/overtimeparamenter') }}">
			{{ csrf_field() }}
			{{ Form::hidden('_method', 'put') }}
		<input type="hidden" name="overtimes" value="{{old('overtimes')}}" />		   
		   <fieldset>
			    <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Description</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="description"  id="edit_description" placeholder="" value="{{old('description')}}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Overtime Type</label>
		        	<div class="uk-form-controls">
		        		{{ Form::select('overtime_type_id',  
							[null => '-- Select --'] + \App\tbl_overtime_type_model::first()->lists('description', 'overtime_type_id') -> toArray() ,old('overtime_type_id'), 
							array('class'=>'form-control','id'=>'edit_overtime_type_id')) }}
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label">Overtime Category</label>
		        	<div class="uk-form-controls">
		        	{{ Form::select('overtime_category_id',  
							[null => '-- Select --'] + \App\tbl_overtime_category_model::first()->lists('description', 'overtime_category_id') -> toArray() ,old('overtime_category_id'), 
							array('class'=>'form-control','id'=>'edit_overtime_category_id')) }}
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Time Covered</label>
		        	<div class="timecoverage uk-form-controls">
		        		<input class="timestart" type="text" name="time_from" id="edit_time_from" data-uk-timepicker="{format:'12h'}" placeholder="00:00AM" value="{{old('time_from')}}"> <span class="timecoverage-separator">to</span>
		        		<input class="timeend" type="text" name="time_to" id="edit_time_to" data-uk-timepicker="{format:'12h'}" placeholder="00:01AM" value="{{old('time_to')}}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Payroll Element</label>
		        	<div class="uk-form-controls">
		        		{{ Form::select('payroll_element_id',  
							[null => '-- Select --'] + \App\tbl_payroll_element_model::first()->lists('description', 'payroll_element_id') -> toArray() ,old('payroll_element_id'), 
							array('class'=>'form-control', 'id'=>'edit_payroll_element_id')) }}
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> First Hour</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="first_hour"  id="edit_first_hour" placeholder="" value="{{old('first_hour')}}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Rate (in decimal)</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="rate" id="edit_rate"placeholder="" value="{{old('rate')}}">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Is Date Overlap?</label>
		        	<div class="uk-form-controls">
		        		{{ Form::select('date_overlap_flag', [null => '-- Select --', 'Y' => 'Yes', 'N' => 'No'], 'Y',  array('class'=>'form-control', 'id'=>'edit_date_overlap_flag')) }}
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
    	<form method="post" action="{{url('payroll/overtimeparamenter')}}">
    		{{ csrf_field() }}
    		{{ Form::hidden('_method', 'put') }}
    		{{ Form::hidden('isDelete', '1') }}
	    	<div id="div-del-chk-overtime">
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
					$(".chk-overtime:checked").each(function(){
					$('#div-del-chk-overtime').append('<input type="hidden" name="overtime_tbl[]" value="'+ $(this).val() +'" />');
					});
				});
				
		
			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
				@elseif(Session::has('edit-failed'))
				$(".btn-edit").click();
				@endif
				
				$(".btn-edit").click(function(){
				
					$("input[name|=overtimes]").val( $(this).attr('data-edit_overtime_id') );
					$("#edit_description").val( $(this).attr('data-edit_description') );
					$("#edit_overtime_type_id").val( $(this).attr('data-edit_overtime_type_id') );
					$("#edit_overtime_category_id").val( $(this).attr('data-edit_overtime_category_id') );
					$("#edit_time_from").val( $(this).attr('data-edit_time_from') );
					$("#edit_time_to").val( $(this).attr('data-edit_time_to') );
					$("#edit_payroll_element_id").val( $(this).attr('data-edit_payroll_element_id') );
					$("#edit_first_hour").val( $(this).attr('data-edit_first_hour') );
					$("#edit_rate").val( $(this).attr('data-edit_rate') );
					$("#edit_date_overlap_flag").val( $(this).attr('data-edit_date_overlap_flag') );
				
				});
				var dataTable = $('#overtime_parameter').DataTable({
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