<form class="uk-form uk-form-horizontal" id="form-company" role="form" method="POST" action="{{ url('wiz2/company') }}">
	<!-- {{ csrf_field() }}
	<input type="hidden" name="user" id="user" value="{{ $user_id }}" />
	<input type="hidden" name="comp" id="company" value="{{ $company['id'] or null }}">
	<input type="hidden" name="_method" value="PUT" /> -->
	<div class="uk-grid">
		<div class="uk-width-1-2">
		    <fieldset>
		        <h4 style="font-weight:bold;">Company Details</h4>
		        <div class="uk-form-row">
		        	<label class="uk-form-label">Company</label>
		        	<div class="uk-form-controls">
						<input type="text" class="form-control" name="company_name" placeholder="Company..." >
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label">Address</label>
		        	<div class="uk-form-controls">
						<input type="text" class="form-control" name="address" placeholder="Address..." >
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label">City</label>
		        	<div class="uk-form-controls">
						<input type="text" class="form-control" name="city" placeholder="City...">
		        	</div>
		        </div>
		        <h4 style="font-weight:bold;">Government Registration</h4>
		        <div class="uk-form-row">
		        	<label class="uk-form-label">BIR</label>
		        	<div class="uk-form-controls">
						<input type="text" class="form-control" name="bir_reg_no" id="bus_reg_num" placeholder="BIR..." >
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label">SSS</label>
		        	<div class="uk-form-controls">
						<input type="text" class="form-control" name="sss_no" id="sss_num" placeholder="SSS..." >
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label">TIN</label>
		        	<div class="uk-form-controls">
						<input type="text" class="form-control" name="tin_no" id="tin_num" placeholder="TIN..." >
		        	</div>
		        </div>
		</div> <!-- first column -->
		<div class="uk-width-1-2">
			<h4 style="font-weight:bold;"> &nbsp;</h4>
	        <div class="uk-form-row">
	        	<label class="uk-form-label">Region</label>
	        	<div class="uk-form-controls">
					<input type="text" class="form-control" name="region" placeholder="Region..." >
	        	</div>
	        </div>
	        <div class="uk-form-row">
	        	<label class="uk-form-label">Zip</label>
	        	<div class="uk-form-controls">
					<input type="text" class="form-control" name="zip" placeholder="Zip..." >
	        	</div>
	        </div>
	        <div class="uk-form-row">
	        	<label class="uk-form-label">Contact Number</label>
	        	<div class="uk-form-controls">
					<input type="text" class="form-control" name="contact_no" placeholder="Contact Number..." >
	        	</div>
	        </div>
			<h4 style="font-weight:bold;"> &nbsp;</h4>
	        <div class="uk-form-row">
	        	<label class="uk-form-label">PhilHealth</label>
	        	<div class="uk-form-controls">
					<input type="text" class="form-control" name="philhealth_no" id="phil_health_num" placeholder="PhilHealth..." >
	        	</div>
	        </div>
	        <div class="uk-form-row">
	        	<label class="uk-form-label">HDMF Number</label>
	        	<div class="uk-form-controls">
					<input type="text" class="form-control" name="hdmf_no" id="hdmf_num" placeholder="HDMF Number..." >
	        	</div>
	        </div>
	        <div class="uk-form-row">
	        	<label class="uk-form-label">RDO Number</label>
	        	<div class="uk-form-controls">
					<input type="text" class="form-control" name="bir_rdo_no" name="bir_rdo_num" placeholder="RDO Number...">
	        	</div>
	        </div>					        					        					        
		    </fieldset>
		</div> <!-- second column -->
	</div>
    <div class="uk-text-right form-buttons">
		@include('wiz2.controls')
    </div>
</form>

@section('scripts')
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script>
	$(document).ready(function(){
		$('#btn-comp-sub').click(function(){
			$("form#form-company").submit();
		});

	  $.mask.definitions['h'] = "[A-Za-z0-9]";
	  $.mask.definitions['v'] = "[VN]";
	  $("#bus_reg_num").mask("?hhh-hhh-hhh-hhh");
	  $("#tin_num").mask("?999-999-999-9999"); // 20161007 debugged by Melvin Militante
	  $("#sss_num").mask("?999-99-9999");
	  $("#hdmf_num").mask("?9999-9999-9999");
	  $("#phil_health_num").mask("?9999-9999-9999");
     
      $('#save_loc').click(function(){          
       $('#form_location').submit();
      });

	});
</script>
@endsection