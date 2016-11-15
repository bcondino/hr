<!-- add loc modal -->
<div class="modal fade" tabindex="-1" aria-labelledby="myLargeModalLabel" id="add-salgrade-modal">
	<div class="modal-dialog">
		<div class="modal-content">
		
			<form role="form" action="" method="POST" class="profile-form">
				<div class="modal-header btn-primary">
					<div class="col-md-11">
						<h3>Add Employment Type</h3>
					</div>
					<div class="col-md-1">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
				</div>
				
				<!--  -->
				<div class="modal-body">
					<div class="row">
						<div class="input-group col-md-12 custom-pad-5a">
							<div class="col-md-4"><label class="custom-right">Salary Code :</label></div>
							<div class="col-md-8"><input type="text" class="form-control-custom " placeholder="Salary Code..." /></div>
						</div>
					</div>
					<div class="row">
						<div class="input-group col-md-12 custom-pad-5a">
							<div class="col-md-4"><label class="custom-right">Salary Grade :</label></div>
							<div class="col-md-8"><input type="text" class="form-control-custom " placeholder="Salary Grade..." /></div>
						</div>
					</div>
					<div class="row">
						<div class="input-group col-md-12 custom-pad-5a">
							<div class="col-md-4"><label class="custom-right"><span class="required-c">*</span>Minimum Salary :</label></div>
							<div class="col-md-8"><input type="text" class="form-control-custom " placeholder="Minimum Salary..." /></div>
						</div>
					</div>
					<div class="row">
						<div class="input-group col-md-12 custom-pad-5a">
							<div class="col-md-4"><label class="custom-right"><span class="required-c">*</span>Maximum Salary :</label></div>
							<div class="col-md-8"><input type="text" class="form-control-custom " placeholder="Maximum Salary..." /></div>
						</div>
					</div>
				</div>
				<!--  -->
				
				<div class="modal-footer">
					<div class="btn-group" role="group" aria-label="...">
						<button type="button" class="btn btn-primary">Save changes</button>
						<button type="button" class="btn btn-default">Clear</button>
					</div>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
			
		</div>
	</div>
</div>
<!-- /.add loc modal -->

<!-- del loc modal -->
<div class="modal fade" tabindex="-1" aria-labelledby="DelLoc" id="del-salgrade-modal">
	<div class="modal-dialog">
		<div class="modal-content">
		
			<form role="form" action="" method="POST" class="profile-form">
				<div class="modal-header btn-danger">
					<div class="col-md-11">
						<h3>Delete Salary Grade</h3>
					</div>
					<div class="col-md-1">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
				</div>
				
				<!--  -->
				<div class="modal-body">
					<div class="row">
						<div class="input-group col-md-12 custom-pad-5a">
							<div class="col-md-4"><label class="custom-right">Salary Code</label></div>							
						</div>
					</div>					
				</div>
				<!--  -->
				
				<div class="modal-footer">
					<div class="btn-group" role="group" aria-label="...">
						<button type="button" class="btn btn-primary">Save changes</button>
						<button type="button" class="btn btn-default">Clear</button>
					</div>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</form>
			
		</div>
	</div>
</div>
<!-- /.del loc modal -->

<div class="dd">
	<div class="col-md-12">
		<div class="btn-group custom-right" role="group" aria-label="...">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-salgrade-modal">Add</button>
			<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#del-salgrade-modal">Delete</button>
		</div>
	</div>
	
	<!-- dependents table -->
	<div class="col-md-12 bs-example">
		<table class="table table-hover">
			<thead>
				<tr>
					<th></th>
					<th>Salary Code</th>
					<th>Salary Grade</th>
					<th>Minimum Salary</th>
					<th>Maximum Salary</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><input type="checkbox" name="salgrade[]" value="{{ $salgrade['id'] or null }}" aria-label="..."></td>
					<td>{{ $salgrade['code'] or null }}</td>
					<td>{{ $salgrade['grade'] or null }}</td>
					<td>{{ $salgrade['min_sal'] or null }}</td>
					<td>{{ $salgrade['max_sal'] or null }}</td>
				</tr>
			</tbody>
		</table>
	</div> <!-- /.employee table -->
</div> <!-- /.dd -->