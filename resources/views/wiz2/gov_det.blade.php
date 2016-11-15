<div class="uk-grid">
	<div class="uk-width-1-2">
		<fieldset class="uk-form-stacked">
			<div class="uk-form-row">
				<label class="uk-form-label">BIR No.</label>
				<div class="uk-form-controls">
					<input class="form-control" type="text" name="bus_reg_num" id="bus_reg_num" value="{{ $company['bus_reg_num'] or null }}"  maxlength="15" placeholder="BIR No" />   
					<!-- @if ($errors->has('bus_reg_num'))<p style="color:red;">{!!$errors->first('bus_reg_num')!!}</p>@endif  -->     
				</div>
			</div>
			<div class="uk-form-row">
				<label class="uk-form-label">SSS No.</label>
				<div class="uk-form-controls">
					<input type="text" class="form-control" name="sss_num" id="sss_num" value="{{ $company['sss_num'] or null }}" placeholder="SSS No"/>
				</div>
			</div>
			<div class="uk-form-row">
				<label class="uk-form-label">TIN No.</label>
				<div class="uk-form-controls">
					<input type="text" class="form-control" name="tin_num" id="tin_num" value="{{ $company['tin_num'] or null }}" placeholder="TIN No"/>
					<!-- @if ($errors->has('tin_num'))<p style="color:red;">{!!$errors->first('tin_num')!!}</p>@endif  -->
				</div>
			</div>
		</fieldset>
	</div>
	<div class="uk-width-1-2">
		<fieldset class="uk-form-stacked">
			<div class="uk-form-row">
				<label class="uk-form-label">PhilHealth No.</label>
				<div class="uk-form-controls">
					<input class="uk-width-1-1 uk-form-large" type="text" name="phil_health_num" id="phil_health_num" class="form-control" value="{{ $company['phil_health_num'] or null }}" placeholder="PhilHealth No"/>
                    <!-- @if ($errors->has('phil_health_num'))<p style="color:red;">{!!$errors->first('phil_health_num')!!}</p>@endif -->
				</div>
			</div>
			<div class="uk-form-row">
				<label class="uk-form-label">HDMF No.</label>
				<div class="uk-form-controls">
					<input type="text" class="form-control" name="hdmf_num" id="hdmf_num" value="{{ $company['hdmf_num'] or null }}" placeholder="HDMF No"/>
                      <!-- @if ($errors->has('hdmf_num'))<p style="color:red;">{!!$errors->first('hdmf_num')!!}</p>@endif -->
				</div>
			</div>
			<div class="uk-form-row">
				<label class="uk-form-label">RDO No.</label>
				<div class="uk-form-controls">
					<input type="text" class="form-control" name="bir_rdo_num" id="bir_rdo_num" value="{{ $company['bir_rdo_num'] or null }}" maxlength="3" placeholder="RDO No" />
                 <!--    @if ($errors->has('bir_rdo_num'))<p style="color:red;">{!!$errors->first('bir_rdo_num')!!}</p>@endif -->
				</div>
			</div>
		</fieldset>
	</div>
</div>


