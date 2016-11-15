<html>
<head>
	<style>

	.container {
		position:relative;
		width:100%;

	}

	body * {
		position:absolute;
		font-size:12px;
		font-weight:bold;
		font-family:sans-serif;
		letter-spacing:10px;
	}

.section1 {
	top:73px;
}
	.fld1 {
		left:105px;
	}
	.fld2 {
		left:152px;
	}
	.sheets {
		font-size:9px;
		top:80px;
		left:435px;
	}

.section2 {
	top:111px;
}
	.fld3 {
		left:15px;
	}
	.fld3a {
		left:87px;
	}
	.fld3b {
		left:159px;
	}
	.fld3c {
		left:232px;
	}
	.fld4 {
		right:263px;
	}

.section3 {
	top:140px;
}
	.fld5 {
		font-size:10px;
		left:15px;
		letter-spacing:2px;
	}
	.fld6 {
		font-size:10px;
		top:140px;
		letter-spacing:6px;
		right:0.5px;
	}

.section4 {
	top:166px;
	font-size:10px;
	
}
	.fld7 {
		letter-spacing:2px;
		left:15px;
	}
	.fld8 {
		letter-spacing:9px;
		right:1px;
	}


	.fld9 {
		font-size:15px;
		top:189px;
		left:14px;
	}



	.div2 {
		position:relative;
		top:1500px;
		visibility:hidden;

	}

	</style>
</head>
<body>
	<div class = "container">
		<span class = "section1 fld1"> {{sprintf("%02d",$fld1)}} </span>
		<span class = "section1 fld2"> {{$fld2}}</span>
		<span class = "section1 sheets"> {{sprintf("%02d",$sheets)}}</span>

		<span class = "section2 fld3"> {{substr($fld3,0,3)}} </span>
		<span class = "section2 fld3a"> {{substr($fld3,4,3)}} </span>
		<span class = "section2 fld3b"> {{substr($fld3,8,3)}} </span>
		<span class = "section2 fld3c"> {{substr($fld3,12,5)}} </span>
		<span class = "section2 fld4"> {{$fld4}} </span>

		<span class = "section3 fld5"> {{$fld5}} </span>
		<span class = "section3 fld6"> {{$fld6}} </span>

		<span class = "section4 fld7"> {{$fld7}} </span>
		<span class = "section4 fld8"> {{$fld8}} </span>

		<span class = "fld9"> {{$fld9}} </span>
		<span class = "div2"> {{$div2}} </span>

	</div>
</html>
