@section('styles')
<style>
.col-md-4 { 
	color:red;
	
}

</style>
@endsection

<div class="ed">
	<div class="col-md-6">
			<div class="row custom-pad-5a">
				<div class="input-group col-md-12">
					<label class="col-md-4">Status :</label>
					<div class="col-md-8">
						<input type="hidden" class="form-control-custom " name = 'emp_type' value="{{$employee->emp_type_id or null}}"  /> 
						<input type="text" class="form-control-custom " id="emp_status" name = 'status' value="{{\App\tbl_employee_type_model::where('emp_type_id',$employee->emp_type_id)->first()['emp_type_name']}}" placeholder="Status"  read-only ="true" disabled  />	
					</div>
				</div>
			</div>
			
			<div class="row custom-pad-5a">
				<div class="input-group col-md-12">
						<label class="col-md-4"></label>
						<div class="col-md-8" id="emp_stat_select" hidden>
							<select class="form-control-custom" id="emp_type_name" name="status" disabled>
							@foreach($emp_type as $emp_types)
								<option >{{$emp_types -> emp_type_name}}</option>
							@endforeach
							</select>
						</div>
				</div>
			</div>
			
			<div class="row custom-pad-5a">
				<div class="input-group col-md-12">
					<label class="col-md-4">Date Hired:</label>
					<div class="col-md-8">
						<input type="text" class="form-control-custom"  id="date_hired"  name="date_hired" value="{{$employee->date_hired or null}}" disabled/>
					</div>
					<!--<input type="hidden" name="date_hired"  value="{{$employee->date_hired or null}}" />-->
				</div>
				<!--    ---------------------------------------------------------------   -->
					<div class="input-group col-md-12">
					
							<div class="col-md-4"><label class="custom"></label></div>
							<div class="col-md-8"> <select class="form-control-custom3" id="mo_toggle2" name="month_hire" hidden>
																		<option>Jan.</option><option>Feb.</option><option>Mar.</option><option>Apr.</option>
																		<option>May.</option><option>Jun.</option><option>Jul.</option><option>Aug.</option>
																		<option>Sep.</option><option>Oct.</option><option>Nov.</option><option>Dec.</option>					
																	</select> 
																	<select class="form-control-custom3" id="date_toggle2" name="date_hire" hidden>
																		<option>01</option><option>02</option><option>03</option><option>04</option>
																		<option>05</option><option>06</option><option>07</option><option>08</option>
																		<option>09</option><option>10</option><option>11</option><option>12</option>
																		<option>13</option><option>14</option><option>15</option><option>16</option>
																		<option>17</option><option>18</option><option>19</option><option>20</option>
																		<option>21</option><option>22</option><option>23</option><option>24</option>
																		<option>25</option><option>26</option><option>27</option><option>28</option>
																		<option>29</option><option>30</option><option>31</option>																					
																	</select>
																	<input type="text" class="form-control-custom3" maxlength="4" placeholder="yyyy.."  id="year_toggle2" name = "year_hire"  hidden/>
																	</div>
						</div>
		<!--    ---------------------------------------------------------------   -->
				
				
			</div>
	</div>
	
	<div class="col-md-6">
		
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<div class="col-md-4"><label class="custom-right">Position :</label></div>
				<div class="col-md-8"><input type="hidden" class="form-control-custom " name = 'emp_pos' value="{{$employee->position_id or null}}"  /><input type="text" class="form-control-custom "  id="emp_pos_code" value="{{\App\tbl_position_model::where('position_id', $employee->position_id)->first()['description']}}" placeholder="Position"  disabled  /></div>
			</div>
		</div>
		
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
				<div class="col-md-4"><label class="custom-right"></label></div>
				<div class="col-md-8" id="emp_pos_select" hidden >
					<select class="form-control-custom" id="emp_pos_name" name="position" disabled >
						@foreach($emp_pos as $emp_position)
							<option >{{$emp_position -> description}}</option>
						@endforeach
						
					</select> 
				</div>
			</div>
		</div>
		
		<div class="row custom-pad-5a">
			<div class="input-group col-md-12">
					<div class="col-md-4"><label class="custom-right" >Date Regular:</label></div>
					<div class="col-md-8">
						<input type="text" class="form-control-custom" id="date_regular"  name="date_regular" value="{{$employee->date_regular or null}}" disabled  />
						<!--<input type="hidden" name="date_regular"  value="{{$employee->date_regular or null}}" />-->
					</div>
			</div>	
			<!--    ---------------------------------------------------------------   -->
					<div class="input-group col-md-12 custom-pad-5a">
					
							<div class="col-md-4"><label class="custom-right"></label></div>
							<div class="col-md-8"> <select class="form-control-custom3" id="mo_toggle3" name="month_reg" hidden>
																		<option>Jan.</option><option>Feb.</option><option>Mar.</option><option>Apr.</option>
																		<option>May.</option><option>Jun.</option><option>Jul.</option><option>Aug.</option>
																		<option>Sep.</option><option>Oct.</option><option>Nov.</option><option>Dec.</option>					
																	</select> 
																	<select class="form-control-custom3" id="date_toggle3" name="date_reg" hidden>
																		<option>01</option><option>02</option><option>03</option><option>04</option>
																		<option>05</option><option>06</option><option>07</option><option>08</option>
																		<option>09</option><option>10</option><option>11</option><option>12</option>
																		<option>13</option><option>14</option><option>15</option><option>16</option>
																		<option>17</option><option>18</option><option>19</option><option>20</option>
																		<option>21</option><option>22</option><option>23</option><option>24</option>
																		<option>25</option><option>26</option><option>27</option><option>28</option>
																		<option>29</option><option>30</option><option>31</option>																					
																	</select>
																	<input type="text" class="form-control-custom3" maxlength="4" placeholder="yyyy.."  id="year_toggle3" name = "year_reg"  hidden/>
																	</div>
						</div>
		<!--    ---------------------------------------------------------------   -->
		</div>
	</div>
	
</div> <!-- /.ed -->
