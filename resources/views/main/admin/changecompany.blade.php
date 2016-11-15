@extends('shared._public')

@section('title', 'Change Default Company')

@section('styles')

@endsection

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-users"></span> Change Company </a></h1>
		</div>
	</div>
</div>

<!-- content -->
<div class="uk-container uk-container-center">
	<form action="{{ url('companies/changecompany') }}" method="post">
		{{ csrf_field() }}
		<div class="button-container">
			<!-- alerts -->
			@if(Session::has('change-success'))
				<div class="uk-alert uk-alert-success">
					<span class="uk-icon uk-icon-check"></span> {{ Session::get('change-success') }}
				</div>
			@endif
		</div>		
		<!-- table -->
		<table id="changecompany" class="uk-table uk-table-hover uk-table-striped payroll--table">
			<thead class="payroll--table_header">
				<tr>
					<th>Default Company</th>
					<th>Company</th>
					<th>Active Employee</th>
				</tr>
			</thead>
			<tbody>
				@foreach($companies as $company)
					<tr>
						<td> @if(\App\tbl_user_company_model::
								  where('default_flag', 'Y')
								->where('company_id', $company->company_id)->first() != null ) 
								{{ Form::radio('new_company_id', $company->company_id, true ) }} 
								<input type="hidden" name="old_company_id" value="{{ $company->company_id }}">
							 @else 
								{{ Form::radio('new_company_id', $company->company_id ) }}
							 @endif </td>
						<td>{{ $company->company_name}}</td>
						<td>{{ count(\App\tbl_employee_model::where('company_id', $company->company_id)->get()) }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</form>
</div> <!-- content -->


@endsection

@section('scripts')

<script type="text/javascript" language="javascript" src="{{asset('js/table.js')}}"></script>
<script type="text/javascript" class="init">
	$(document).ready(
		function() {

			$('input[name=new_company_id]').change(function(){
				$('form').submit();
			});

   			var dataTable = $('#changecompany').DataTable({
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
