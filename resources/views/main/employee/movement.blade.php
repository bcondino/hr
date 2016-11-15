@extends('shared._public')

@section('title', 'Movements')

@section('styles')

@endsection

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title">
				<span class="uk-icon uk-icon-users"></span>
				<strong>
					Movements
				</strong>
			</h1>
		</div>
	</div>
</div>

<!-- content -->
<div class="uk-container uk-container-center">
	<br>
	<!-- company table -->
	<div class="categories">
		<table id="movements" class="uk-table uk-table-hover uk-table-striped payroll--table">
			<thead class="payroll--table_header">
				<tr>
					<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
					<th>Employee Number</th>
					<th>Employee Name</th>
					<th>Number of records</th>
				</tr>
			</thead>
			<tbody>
				@foreach($movements as $movement)
					<tr>
						<td><input type="checkbox" class="chk-movement" name="movements[]" value="{{ $movement->employee_id }}"/></td>
						<td><a href="{{ url('employee/movementsofemployee/'. $movement->employee_id) }}" class="btn" >{{ $movement->employee_number }}</td>
						<td>{{ ucwords($movement->last_name) }}, {{ ucwords($movement->first_name) }}</td>
						<td>{{ count(\App\tbl_movement_model::
											where('employee_id', $movement->employee_id)
											->get()) 
							}} </td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>


@endsection

@section('scripts')

<script type="text/javascript" language="javascript" src="{{asset('js/table.js')}}"></script>
<script type="text/javascript" class="init">
	$(document).ready(
		function() {

			$("#btn-del").click(function(){
				$(".chk-movement:checked").each(function(){
					$('#div-del-chk-employee').append('<input type="hidden" name="employees[]" value="'+ $(this).val() +'" />');
				});
			});

			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
			@elseif(Session::has('mass-failed'))
				UIkit.modal('#mass').show();
			@endif

			var dataTable = $('#movements').DataTable({
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
