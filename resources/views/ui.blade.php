<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}">
		<style type="text/css">
	/*	.container {
			border:red 2px solid;
		}
		.container > .col-sm-5 {
			border:yellow 2px solid;
		}
		.container > .col-sm-4 {
			border:green 2px solid;
		}
*/
		/*.form-control {
			width:80%;
		}*/

		</style>
	</head>
	<body>

		<div class="jumbotron text-center">
			<h1>Run Reports UI</h1>
			<p>Select Forms then input parameters</p>
		</div>


			<div class ="container">
				<div class ="col-sm-1">
				</div>
				<div class ="col-sm-4">
					<h4>Select Forms Here:</h4>
					<form action ="{{url('/forms')}}" method = "POST">
						<select name = "cboForms" class ="form-control">
							<optgroup label = "PDF Forms">
								<option value ="rformc">BIR Form 1601-C</option>
								<option value ="rforme">BIR Form 1601-E</option>
								<option value ="rformf">BIR Form 1601-F</option>
							</optgroup>
							<optgroup label = "EXCEL Forms">
								<option value ="sss">SSS Form</option>
								<option value ="hdmf">HDMF Form</option>
								<option value ="payroll">Payroll Register Form</option>
								<option value ="phform">PhilHealth RF-1 Form</option>
								<option value ="cbcacat">CBCACAT Template
							</optgroup>
						</select>
						<br>
						<br>
						<input type = "submit" class = "btn btn-primary btn-lg">
						{{ csrf_field() }}
				</div>
				<div class ="col-sm-1">
				</div>
				<div class ="col-sm-1">
				</div>
				<div class ="col-sm-4">

						<h4>User ID</h4>
						<input type ="text" class ="form-control" name="id">
						<h4>Column Name</h4>
						<input type = "text" class ="form-control" name="colname">
						<h4>Operator</h4>
						<input type ="text" class ="form-control" name="operator">
						<h4>Parameter</h4> 
						<input type = "text" class ="form-control" name="parameter">
						<br><br>				
					</form>
				</div>
				<div class ="col-sm-1">
				</div>
			</div>
	</body>
</html>




