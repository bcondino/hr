<div class="bi">
	<div class="col-md-6">
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<label class="col-md-4">Name :)</label>
				<div class="col-md-8"><input type="text" class="form-control-custom" name="comp_name" value="{{ $comp_name or null }}" readonly="readonly" /></div>
			</div>
		</div>
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<label class="col-md-4">Address :</label>
				<div class="col-md-8"><input type="text" class="form-control-custom " placeholder="Address..." value="{{ $address or null }}" /></div>
			</div>
		</div>
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<label class="col-md-4">City :</label>
				<div class="col-md-8"><input type="text" class="form-control-custom " placeholder="City..." value="{{ $city or null }}" /></div>
			</div>
		</div>			
	</div>
	
	<div class="col-md-6">
	<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<div class="col-md-4"><label class="custom-right"><span class="required-c " style="color:red;">*</span>Region :</label></div>
				<div class="col-md-8"><input type="text" class="form-control-custom " placeholder="Region..." value="{{ $region or null }}" /></div>
			</div>
		</div>
	<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<label class="col-md-4"><span class="required-c">*</span>Zip :</label>
				<div class="col-md-8"><input type="text" class="form-control-custom " placeholder="Zip..." value="{{ $zip or null }}" /></div>
			</div>
		</div>
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<label class="col-md-4"><span class="required-c">*</span>Contact No :</label>
				<div class="col-md-8"><input type="text" class="form-control-custom " placeholder="Contact No..." value="{{ $contact or null }}" /></div>
			</div>
		</div>				
	</div>
	
</div> <!-- /.bi -->