<div class="dd">
	<div class="col-md-12">
		<div class="btn-group custom-right" role="group" aria-label="...">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".add-dep-modal" onClick=enableAll()>Add</button>
		<!--	<button type="button" class="btn btn-danger" onClick="confirm('Press?')">Delete</button> -->
		</div>
	</div>
	
	<!-- dependents table -->
	<div class="col-md-12 bs-example">
		<table class="table table-hover">
			<thead>
				<tr>
					
					<th>Dependent Name</th>
					<th>Relationship</th>
					<th>Date of Birth</th>
					<th>Beneficiary</th>
					<th>Tax Dependent</th>
					<!--<th>Edit</th>-->
				</tr>
			</thead>
			<tbody>
							@foreach($dependents as $dependent)
				<tr>
					<!--<td><input type="checkbox" aria-label="..."></td>-->
					<td><a href="" class="btn dep_link-edit" style="padding:0; font-size:12px;" data-toggle="modal" data-target=".edit-dep-modal" data-id="{{ $dependent['dependent_id'] }}" data-dep_type="{{ $dependent['dependent_type'] or null }}" data-last_name="{{ $dependent['last_name'] or null }}" data-first_name="{{$dependent['first_name'] or null}}" data-mid_name="{{$dependent['mid_name'] or null}}" data-date_birth="{{$dependent['date_birth'] or null}}" data-civil_stat="{{$dependent['civil_stat'] or null}}" data-gender="{{$dependent['gender'] or null}}" data-address="{{$dependent['address'] or null}}" data-occupation="{{$dependent['occupation'] or null}}" data-is_benef="{{$dependent['is_benef'] or null}}"  data-is_tax_dep="{{$dependent['is_tax_dep'] or null}}" >{{$dependent->last_name }} , {{$dependent->first_name}}</td>
					<td>{{ $dependent->dependent_type}}</td>
					<td>{{ $dependent->date_birth}}</td>
					<td>{{ $dependent->is_benef}}</td>
					<td>{{ $dependent->is_tax_dep}}</td>
					</a>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div> <!-- /.employee table -->
</div> <!-- /.dd -->
<script>

</script>

