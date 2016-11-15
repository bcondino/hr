<div class="dd">
	<div class="col-md-12">
		<div class="btn-group custom-right" role="group" aria-label="...">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".add-educbg-modal" onClick=enableAll()>Add</button>
			<!--<button type="button" class="btn btn-danger">Delete</button>-->
		</div>
	</div>
	
	<!-- dependents table -->
	<div class="col-md-12 bs-example">
		<table class="table table-hover">
			<thead>
				<tr>
					<th></th>
					<th>Education Level</th>
					<th>Degree</th>
					<th>School</th>
					<th>Date Attended</th>
					
				</tr>
			</thead>
			<tbody>
			@foreach($educ_backs as $educ_back)
				<tr>
					<td></td>
					<td><a href="" class="btn educ_edit_link" style="padding:0; font-size:12px;" data-toggle="modal" data-target=".edit-educbg-modal" data-educ_back_id="{{ $educ_back['educ_back_id'] }}" data-educ_type_id="{{ $educ_back['educ_type_id']  or null}}" data-degree_earned="{{ $educ_back['degree_earned']  or null}}"  data-school_name="{{ $educ_back['school_name']  or null}}" data-school_address="{{ $educ_back['school_address']  or null}}" data-period_attended_from="{{ $educ_back['period_attended_from']  or null}}" data-period_attended_to="{{ $educ_back['period_attended_to']  or null}}">{{$educ_back->educ_type_id }} </a></td>
					<td>{{$educ_back->degree_earned }} </td>
					<td>{{$educ_back->school_name }}</td>
					<td>{{$educ_back->period_attended_from}}    -  {{$educ_back->period_attended_to }}    </td>
					</td>
					
				</tr>
			@endforeach
			</tbody>
		</table>
	</div> <!-- /.employee table -->
</div> <!-- /.dd -->