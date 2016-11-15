<div class="ci">
	<div class="col-md-6">
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<label class="col-md-4">Address 1 :</label>
				<div class="col-md-8"><input type="text" name ="address1" class="form-control-custom " placeholder="Address 1..." value="{{$employee->address1 or null}}"  disabled/></div>
			</div>
		</div>
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<label class="col-md-4">Address 2 :</label>
				<div class="col-md-8"><input type="text" name="address2"  class="form-control-custom " placeholder="Address 2..." value="{{$employee->address2 or null}}"  disabled/></div>
			</div>
		</div>
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<label class="col-md-4">City :</label>
				<div class="col-md-8"><input type="text" name="city" class="form-control-custom " placeholder="City..." value="{{$employee->city}}"   disabled/></div>
			</div>
		</div>
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<label class="col-md-4">Region :</label>
				<div class="col-md-8"><input type="text" name="region"	 class="form-control-custom " placeholder="Region..." value="{{$employee->region}}" disabled/></div>
			</div>
		</div>
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<label class="col-md-4">Zip Code :</label>
				<div class="col-md-8"><input type="text" name="zip"  class="form-control-custom " placeholder="Zip Code..." value="{{$employee->zip}}"  disabled/></div>
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<div class="col-md-4"><label class="custom-right">E-mail :</label></div>
				<div class="col-md-8"><input type="text" name="e_mail" class="form-control-custom " value="{{$employee->e_mail or null}}"   placeholder="email..."  disabled/></div>
			</div>
		</div>
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<div class="col-md-4"><label class="custom-right">Mobile No. :</label></div>
				<div class="col-md-8"><input type="text" name="mobile_no" class="form-control-custom " placeholder="Mobile Number..."   value="{{$employee->mobile_no}}" disabled/></div>
			</div>
		</div>
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<div class="col-md-4"><label class="custom-right">Tel No. :</label></div>
				<div class="col-md-8"><input type="text" name="tel_no" class="form-control-custom "  placeholder="Tel Number..."  value="{{$employee->tel_no}}"  disabled  /></div>
			</div>
		</div>
	</div>
	
</div> <!-- /.ci -->