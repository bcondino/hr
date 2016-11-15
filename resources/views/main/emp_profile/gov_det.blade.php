<div class="gd">
	<div class="col-md-6">
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<label class="col-md-4">SSS :</label>
				<div class="col-md-8"><input type="text" name="sss_no" class="form-control-custom " placeholder="SSS..." value="{{$employee->sss_no or null}}" disabled /></div>
			</div>
		</div>
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<label class="col-md-4">TIN :</label>
				<div class="col-md-8"><input type="text" name="tin_no" class="form-control-custom " placeholder="TIN..." value="{{$employee->tin_no or null}}" disabled /></div>
			</div>
		</div>
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<label class="col-md-4">PhilHealth :</label>
				<div class="col-md-8"><input type="text" name="philhealth" class="form-control-custom " placeholder="PhilHealth..." value="{{$employee->philhealth or null}}" disabled /></div>
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<div class="col-md-4"><label class="custom-right">HDMF No. :</label></div>
				<div class="col-md-8"><input type="text" name="hdmf" class="form-control-custom " placeholder="HDMF No...." value="{{$employee->hdmf or null}}" disabled /></div>
			</div>
		</div>
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<div class="col-md-4"><label class="custom-right">RDO :</label></div>
				<div class="col-md-8"><input type="text" name="rdo" class="form-control-custom " placeholder="RDO..." value="{{$employee->rdo or null}}" disabled /></div>
			</div>
		</div>
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<div class="col-md-4"><label class="custom-right">Tax Code :</label></div>
				<div class="col-md-8"><select class="form-control-custom" id="exampleSelect1" name="tax_code" disabled>
						@foreach($tax_code as $tax_codes)
						<option >{{$tax_codes -> tax_code}}</option>
						@endforeach
					</select></div>
			</div>
		</div>
	</div>
	
</div> <!-- /.gd -->