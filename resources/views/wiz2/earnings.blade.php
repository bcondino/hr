<!-- add earn modal -->
<div class="modal fade" tabindex="-1" aria-labelledby="myLargeModalLabel" id="add-earn-modal">
	<div class="modal-dialog">
		<div class="modal-content">
		
			<form role="form" action="" method="POST" class="profile-form">
				<div class="modal-header btn-primary">
					<div class="col-md-11">
						<h3>Add Earnings</h3>
					</div>
					<div class="col-md-1">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
				</div>
				
				<!--  -->
				<div class="modal-body">
					<div class="row">
						<div class="input-group col-md-12 custom-pad-5a">
							<div class="col-md-4"><label class="custom-right"><span class="required-c">*</span>Name :</label></div>
							<div class="col-md-8"><input type="text" class="form-control-custom " placeholder="Name..." /></div>
						</div>
					</div>
					<div class="row">
						<div class="input-group col-md-12 custom-pad-5a">
							<div class="col-md-4"><label class="custom-right"><span class="required-c">*</span>Type :</label></div>
							<div class="col-md-8"><input type="text" class="form-control-custom " placeholder="Type..." /></div>
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
<!-- /.add earn modal -->

<!-- del earn modal -->
<div class="modal fade" tabindex="-1" aria-labelledby="Delearn" id="del-earn-modal">
	<div class="modal-dialog">
		<div class="modal-content">
		
			<form role="form" action="" method="POST" class="profile-form">
				<div class="modal-header btn-danger">
					<div class="col-md-11">
						<h3>Delete Earnings</h3>
					</div>
					<div class="col-md-1">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
				</div>
				
				<!--  -->
				<div class="modal-body">
					<div class="row">
						<div class="input-group col-md-12 custom-pad-5a">
							<div class="col-md-4"><label class="custom-right">Earnings Code :</label></div>
							<div class="col-md-8"><input type="text" class="form-control-custom " placeholder="Earnings Code..." /></div>
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
<!-- /.del earn modal -->

<div class="dd">
	<div class="col-md-12">
		<div class="btn-group custom-right" role="group" aria-label="...">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-earn-modal">Add</button>
			<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#del-earn-modal">Delete</button>
		</div>
	</div>
	
	<!-- dependents table -->
	<div class="col-md-12 bs-example">
		<table class="table table-hover">
			<thead>
				<tr>
					<th></th>
					<th>Name</th>
					<th>Type</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><input type="checkbox" name="earn[]" value="{{ $earn['id'] or null }}" aria-label="..."></td>
					<td>{{ $earn['name'] or null }}</td>
					<td>{{ $earn['type'] or null }}</td>
				</tr>
			</tbody>
		</table>
	</div> <!-- /.employee table -->
</div> <!-- /.dd -->