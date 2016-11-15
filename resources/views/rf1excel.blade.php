<html>
<head>
	<style>
	body * {
		position:absolute;
		font-size:20px;
		font-weight:bolder;
		font-family:sans-serif;
		letter-spacing: 1.3px;
		color:red;
	}
	.fld1 {
		top:95px;
		left:125px;
	}
	.fld1a {
		top:95px;
		left:155px;
	}
	.fld1b {
		top:95px;
		left:273px;
	}
	.fld2 {
		top:125px;
		left:125px;
	}
	.fld2a {
		top:125px;
		left:168px;
	}
	.fld2b {
		top:125px;
		left:210px;
	}
	.fld2c {
		top:125px;
		left:251px;
	}
	.fld3,.fld4,.fld5 {
		letter-spacing:2px;
		font-size:12px;
	}
	.fld3 {
		top:160px;
		left:155px;
	}
	.fld4 {
		top:180px;
		left:155px;
	}
	.fld5 {
		top:225px;
		left:120px;
	}
	.fld6 {
		top:181px;
		left:358px;
	}
	.fld6a {
		top:207px;
		left:526px;
	}
	.fld7 {
		top:207px;
		left:650px;
		font-size:9px;
		letter-spacing:0px;
	}
	.fld8 {
		font-size:10px;
		letter-spacing:0px;
		top:866px;
		left:47px;
	}

	</style>
</head>
<body>
	<span class = "fld1">  {{substr($fld1,0,2)}}  </span>
	<span class = "fld1a"> {{substr($fld1,2,9)}}  </span>
	<span class = "fld1b"> {{substr($fld1,11,1)}} </span>
	<span class = "fld2">  {{substr($fld2,0,3)}}  </span>
	<span class = "fld2a"> {{substr($fld2,3,3)}}  </span>
	<span class = "fld2b"> {{substr($fld2,6,3)}}  </span>
	<span class = "fld2c"> {{substr($fld2,9,3)}}  </span>
	<span class = "fld3">  {{$fld3}}			  </span> 
	<span class = "fld4">  {{$fld4}}			  </span>
	<span class = "fld5">  {{$fld5}}			  </span>
	<span class = "fld6">  {{$fld6}}			  </span>
	<span class = "fld6a"> {{$fld6}}			  </span>
	<span class = "fld7">  {{$fld7}}			  </span>
	<span class = "fld8">  {{$fld8}}			  </span>
	
</body>
</html>