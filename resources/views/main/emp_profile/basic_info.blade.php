<div class="bi">

	<div class="col-md-6">
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<label class="col-md-4">Number :</label>
				<div class="col-md-8"><label>{{$employee->employee_number or null}}</label></div>
			</div>
		</div>
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<label class="col-md-4">Salutation :</label>
				<div class="col-md-8">
				<select class="form-control-custom"  name="salutation" disabled>
						<option>-S-</option>
						<option value="Mr." {!! $employee->salutation == 'Mr.' ? 'selected' : null !!}>Mr.</option>
						<option value="Ms." {!! $employee->salutation == 'Ms.' ? 'selected' : null !!} >Ms.</option>
						
					</select></div>
			</div>
		</div>
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<label class="col-md-4"><span class="required-c">*</span>Last Name :</label>
				<div class="col-md-8"><input type="text" class="form-control-custom " name = 'last_name' value="{{$employee->last_name or null}}" placeholder="Last Name..."  disabled  /></div>
			</div>
		</div>
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<label class="col-md-4"><span class="required-c">*</span>First Name :</label>
				<div class="col-md-8"><input type="text"  class="form-control-custom  "  name = 'first_name' value="{{$employee->first_name or null}}"  placeholder="First Name..." disabled/></div>
			</div>
		</div>
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<label class="col-md-4"><span class="required-c">*</span>Middle Name :</label>
				<div class="col-md-8"><input type="text" class="form-control-custom " name = 'middle_name' value="{{$employee->middle_name or null}}" placeholder="Middle Name..."  disabled/></div>
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<div class="col-md-4"><label class="custom-right">Gender :</label></div>
				<div class="col-md-8">
					<select class="form-control-custom" id="exampleSelect1" name ='gender' disabled>
						<option>-- Select --</option>
						<option value="Male" {!! $employee->gender == 'Male' ? 'selected' : null !!}>Male</option>
						<option value="Female" {!! $employee->gender == 'Female' ? 'selected' : null !!}>Female</option>
						
					</select>
				</div>
			</div>
		</div>
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<div class="col-md-4"><label class="custom-right">Date of Birth :</label></div>
				<div class="col-md-8"><input type="text"  id="dobirth" class="form-control-custom4 "  maxlenght="10"  name='date_birth'  value="{{$employee->date_birth or null}}" disabled placeholder="mon.dd.yyyy" /></div>
			</div>
		</div>
		<!--    ---------------------------------------------------------------   -->
					<div class="input-group col-md-12 custom-pad-5a">
					
							<div class="col-md-4"><label class="custom-right"></label></div>
							<div class="col-md-8"> <select class="form-control-custom3" id="dob_toggle1" name="month_birth" disabled hidden>
																		<option>Jan.</option><option>Feb.</option><option>Mar.</option><option>Apr.</option>
																		<option>May.</option><option>Jun.</option><option>Jul.</option><option>Aug.</option>
																		<option>Sep.</option><option>Oct.</option><option>Nov.</option><option>Dec.</option>					
																	</select> 
																	<select class="form-control-custom3" id="dob_toggle2" name="date2_birth" disabled hidden>
																		<option>01</option><option>02</option><option>03</option><option>04</option>
																		<option>05</option><option>06</option><option>07</option><option>08</option>
																		<option>09</option><option>10</option><option>11</option><option>12</option>
																		<option>13</option><option>14</option><option>15</option><option>16</option>
																		<option>17</option><option>18</option><option>19</option><option>20</option>
																		<option>21</option><option>22</option><option>23</option><option>24</option>
																		<option>25</option><option>26</option><option>27</option><option>28</option>
																		<option>29</option><option>30</option><option>31</option>																					
																	</select>
																	<input type="text" class="form-control-custom3" maxlength="4" placeholder="yyyy.."  id="dob_toggle3" name = "year_birth" disabled hidden/>
																	</div>
						</div>
		<!--    ---------------------------------------------------------------   -->
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<div class="col-md-4"><label class="custom-right">Civil Stat:</label></div>
				<div class="col-md-8">
					<select class="form-control-custom" id="exampleSelect1" name='civil_stat'  disabled>
						<option>-- Select --</option>
						<option  value="Single" {!! $employee->civil_stat == 'Single' ? 'selected' : null !!}>Single</option>
						<option  value="Married" {!! $employee->civil_stat == 'Married' ? 'selected' : null !!}>Married</option>
					 	<option  value="Widow" {!! $employee->civil_stat == 'Widow' ? 'selected' : null !!}>Widow</option>
					</select>
				</div>
			</div>
		</div>
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<div class="col-md-4"><label class="custom-right">Nationality :</label></div>
				<div class="col-md-8"><input type="text" class="form-control-custom " name='nationality'  placeholder="Nationality..." value="{{$employee->nationality or null}}"  disabled/></div>
			</div>
		</div>
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<div class="col-md-4"><label class="custom-right">Is Active :</label></div>
				<div class="col-md-8">
					<select class="form-control-custom" id="exampleSelect1" name='active_flag'  disabled>
						<option>-- Select --</option>
						<option  value="Y" {!! $employee->active_flag == 'Y' ? 'selected' : null !!}>Y</option>
						<option   value="N" {!! $employee->active_flag == 'N' ? 'selected' : null !!}>N</option>
					</select>
				</div>
			</div>
		</div>
	</div>
	
</div> <!-- /.bi -->
<script>

</script>

