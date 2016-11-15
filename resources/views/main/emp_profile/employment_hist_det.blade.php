<div class="dd">
	<div class="col-md-12">
		<div class="btn-group custom-right" role="group" aria-label="...">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".add-employhist-modal" onClick=enableAll()>Add</button>
			<!-- <button type="button" class="btn btn-danger">Delete</button> -->
		</div>
	</div>
	
	<!-- dependents table -->
	<div class="col-md-12 bs-example">
		<table class="table table-hover">
			<thead>
				<tr>
					<th></th>
					<th>Company Name</th>
					<th>Employment Period</th>
					<th>Position Held</th>
					
				</tr>
			</thead>
			<tbody>
				@foreach($emp_hist as $emp_hist)
				<tr>
					<td></td>
					<td><a href="" class="btn emphist_edit_link" style="padding:0; font-size:12px;" data-toggle="modal" data-target=".edit-employhist-modal" data-emp_hist_id="{{ $emp_hist['emp_hist_id'] }}"  data-company_name="{{ $emp_hist['company_name'] or null }}"  data-address="{{ $emp_hist['address'] or null }}" data-industry="{{ $emp_hist['industry'] or null }}" data-industry="{{ $emp_hist['industry'] or null }}" data-period_attended_from="{{ $emp_hist['period_attended_from']  or null}}" data-period_attended_to="{{ $emp_hist['period_attended_to']  or null}}" data-position_held="{{ $emp_hist['position_held'] or null }}" data-salary="{{ $emp_hist['salary'] or null }}" data-benefits="{{ $emp_hist['benefits'] or null }}" data-responsibilities="{{ $emp_hist['responsibilities'] or null }}" data-reason_leaving="{{ $emp_hist['reason_leaving'] or null }}">{{$emp_hist->company_name }} </a></td>
					<td>{{$emp_hist->period_attended_from }}   -   {{$emp_hist->period_attended_to}}</td>
					<td>{{$emp_hist->position_held }}</td>
					<td>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div> <!-- /.employee table -->
</div> <!-- /.dd -->