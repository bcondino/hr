@extends('shared._public')

@section('title', 'Payroll Reports')

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-file-text"></span> <strong>Payroll Reports</strong></h1>
		</div>
	</div>
</div>

<!-- content -->
<div class="uk-container uk-container-center">
	<div class="uk-grid">
		<aside class="uk-width-1-4">
			<ul class="uk-nav uk-nav-side uk-nav-parent-icon" data-uk-nav>
				<li><a href="{{ url('payrollmanagement/profile') }}">Payroll Profile</a></li>
				<li class="uk-parent"><a href="#">Earnings and Deductions </a>
					<ul class="uk-nav-sub">
						<li><a href="{{ url('payrollmanagement/rearningsdedn') }}">Recurring Earnings and Deductions</a></li>
						<li><a href="{{ url('payrollmanagement/nonrearningsdedn') }}">Non-recurring Earnings and Deductions</a></li>
					</ul>
				</li>
				<li><a href="{{ url('payrollmanagement/payrollprocess') }}">Payroll Process</a></li>
				<!-- 20161027 updated by Melvin Militante; Reason: To add payroll report interface -->
				<li class="uk-active"><a href="{{ url('payrollmanagement/report') }}">Reports</a></li>
			</ul>
		</aside>
		<div class="tm-main uk-width-3-4">
			<main>
	    		<!-- alerts -->
				@foreach(['add','put','del'] as $msg)
					@if(Session::has($msg.'-success'))
						<div class="uk-alert uk-alert-success">
							<span class="uk-icon uk-icon-check"></span> {{ Session::get($msg.'-success') }}
						</div>
					@endif
					@if(Session::has($msg.'-warning'))
						<div class="uk-alert uk-alert-warning">
							<span class="uk-icon uk-icon-warning"></span> {{ Session::get($msg.'-warning') }}
						</div>
					@endif
				@endforeach	

				<article class="uk-article">

					<!-- start main content table -->
					<form class="uk-form uk-form-horizontal"  method="post" action="{{ url('forms') }}" target="_blank">
					{{ csrf_field() }}
						<div class="uk-grid">
							<div class="uk-width-1-2">
								<fieldset>
									<div class="uk-form-row"><b>Select a Report</b></div>
									<div class="uk-form-row">
										<label class="uk-form-label">Report Name</label>
										<div class="uk-form-controls">
											<select id="cboForms" name="cboForms" required>
												<option value="">-- Select --</option>
												@foreach($reports as $key => $values)
													<optgroup label="{{ $key }}">
														@foreach($values as $value)
															<option value="{{ $value->report_id }}">{{ $value->report_name }}</option>
														@endforeach
													</optgroup>
												@endforeach
											</select>
										</div>
                                	</div>
                                	<div class="uk-form-row">Description:</div>
                                	<div class="uk-form-row">
                                		<p id="report_desc" style="text-indent: 30px"></p>
                                	</div>
                                </fieldset>
							</div>
							<div class="uk-width-1-2"  id="div_param">
							</div>
						</div>
						<div class="uk-text-right form-buttons">
                        	<button class="uk-button btn-save" type="submit">
                            	<span class="uk-icon uk-icon-check"></span>Submit
                        	</button>
                    	</div>
					</form>
				</article>
			</main>
		</div>
	</div>
</div>

@endsection

@section('scripts')

<script type="text/javascript" language="javascript" src="{{asset('js/table.js')}}"></script>
<script type="text/javascript" class="init">
	$(document).ready(
		function() {
			$("#cboForms").on('change', function(e){
			    var report_id = e.target.value;
				$.get('repdetail?report_id=' + report_id, function(data) {
					$("#report_desc").text("");
					$("#report_desc").text(data.description);
				});
				$.get('repparam?report_id=' + report_id, function(data) {
					$("#div_param").empty();
					$("#div_param").append(data);
				});
			});
		}
	);
</script>

@endsection