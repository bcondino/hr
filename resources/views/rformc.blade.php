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
	top: 124px;
	font-weight:bolder;
}
	.fld1 {
		left:123px;
	}
	.fld1a {
		left:166px;
	}
	.fld3 {
		left:510px;
	}

.section2 {
	top: 161px;
}
	.fld5 {
		left:38px;
	}
	.fld5a {
		left:105px;
	}
	.fld5b {
		left:171px;
	}
	.fld5c {
		left:236px;
	}
	.fld6 {
		right:265px;
	}

.section3{
	top:194px;
}
	}
	.fld8 {
		left:38px;
		letter-spacing:2px;
	}
	.fld9 {
		top: 193px;
		right:3px;
		letter-spacing:7px;
	}

.section4 {
	top:228px;
}
	.fld10 {
		left:38px;
		letter-spacing:0.5px;
	}
	.fld11 {
		right:8px;
	}


	.fld12 {
		top:255px;
		left:33px;
		font-weight:bolder;
		font-size:20px;
	}

.section1521B{
right:230px; 
letter-spacing:4px;
}
	.fld15 {
		top:308px;
	
	}
	.fld16 {
		top:330px;

	}
	.fld17 {
		top:353px;
		
	}
	.fld18 {
		top:376px;
	
	}
	.fld19 {
		top:398px;
	
	}
	.fld19a {
		top:398px;
	}
	
	.fld20 {
		top:385px;
	
	}
	.fld21 {
		top:404px;
		left:570px;
	}
	.fld22 {
		top:420px;
		left:570px;
	}
	.fld23 {
		top:435px;
		left:350px;
	}
	.fld24 {
		top:454px;
		left:350px;
	}
	.fld25 {
		top:475px;
		left:570px;
	}
	.fld26 {
		top:497px;
		left:570px;
	}
	.fld27 {
		top:530px;
		left:70px;
	}
	.fld28 {
		top:530px;
		left:220px;
	}
	.fld29 {
		top:530px;
		left:380px;
	}
	.fld30 {
		top:530px;
		left:570px;
	}
	.fld31 {
		top:550px;
		left:570px;
	}
	.fld32 {
		top:604px;
		left:20px;
		font-size:10px;
	}
	.fld32a {
		top:604px;
		left:70px;
		font-size:10px;
	}
	.fld33 {
		top:604px;
		left:175px;
		font-size:10px;
	}
	.fld33a {
		top:604px;
		left:210px;
		font-size:10px;
	}
	.fld33b {
		left:270px;
		top:604px;
		font-size:10px;
	}
	.fld34 {
		top:604px;
		left:400px;
		font-size:10px;
	}
	.fld35 {
		top:604px;
		left:560px;
		font-size:10px;
	}
	.fld36 {
		top:673px;
		left:5px;
		font-size:10px;
	}
	.fld37 {
		top:673px;
		left:180px;
		font-size:10px;
	}
	.fld38, .fld39 {
		top:673px;
		font-size:10px;
	}

	.fld38 {
		left:370px;
	}
	.fld39 {
		left:560px;
	}

.26a {
	top:790px;
	font-size:12px;
	letter-spacing:2px;
	font-weight:bolder;
}
	}
	.fld40 {
		left:130px;
	}	
	.fld41 {	
		left:470px;
	}

.26b {
	top:830px;
	font-size:10px;
	letter-spacing:2px;
	font-weight:bolder;
}

	.fld42 {
		left:85px;
	}

	.fld43 {
		left:250px;
	}
	.fld44 {
		left:450px;
	}

	.fld45, .fld46, .fld47, .fld48 {
	
		font-size:8px;
	}

	.fld45 {
		left:40px;
	}
	.fld46 {
		left:190px;
	}
	.fld47 {
		left:320px;
	}
	.fld48 {
		left:480px;
	}
	.fld49, .fld50, .fld51, .fld52, {
	
		letter-spacing:1px;
	}
	.fld49 {
		left:90px;
	}
	.fld50 {
		left:180px;
	}
	.fld51 {
		left:285px;
		letter-spacing:5px;
	}
	.fld52 {
		left:420px;
	}
	.fld53 {
		top:800px;
		left:80px;
	}
	.sheets {
		position:relative;
		top:1500px;
		visibility:hidden;
	}

	</style>
</head>
<body> 
	<div class ="container">
		<span class = "section1 fld1"> {{sprintf("%02d",$fld1)}} </span>
		<span class = "section1 fld1a"> {{$fld1a}} </span> 	
		<span class = "section1 fld3"> {{sprintf("%02d",$fld3)}} </span>
		<span class = "section2 fld5"> {{substr($fld5,0,3)}} </span>
		<span class = "section2 fld5a"> {{substr($fld5,4,3)}} </span>
		<span class = "section2 fld5b"> {{substr($fld5,8,3)}} </span>
		<span class = "section2 fld5c"> {{substr($fld5,12,5)}} </span>
		<span class = "section2 fld6"> {{$fld6}} </span>
		<span class = "section3 fld8"> {{strtoupper($fld8)}} </span>
		<span class = "section3 fld9"> {{$fld9}} </span>
		<span class = "section4 fld10"> {{strtoupper($fld10)}} </span>
		<span class = "section4 fld11"> {{$fld11}} </span>
		<span class = "fld12"> {{$fld12}} </span>  
		<span class = "section1521B fld15"> {{$fld15}} </span>
		<span class = "section1521B fld16"> {{$fld16}} </span>
		<span class = "section1521B fld17"> {{$fld17}} </span>
		<span class = "section1521B fld18"> {{$fld18}} </span>
		<span class = "section1521B fld19"> {{$fld19}} </span>
		<span class = "section1521B fld19a"> {{$fld19a}} </span>
		<span class = "fld20"> {{$fld20}} </span>
		<span class = "fld21"> {{$fld21}} </span>
		<span class = "fld22"> {{$fld22}} </span>
		<span class = "fld23"> {{$fld23}} </span>
		<span class = "fld24"> {{$fld24}} </span>
		<span class = "fld25"> {{$fld25}} </span>
		<span class = "fld26"> {{$fld26}} </span>
		<span class = "fld27"> {{$fld27}} </span>
		<span class = "fld28"> {{$fld28}} </span>
		<span class = "fld29"> {{$fld29}} </span>
		<span class = "fld30"> {{$fld30}} </span>
		<span class = "fld31"> {{$fld31}} </span>
		<span class = "fld32"> {{substr($fld32,0,2)}} </span>
		<span class = "fld32a"> {{substr($fld32,3,5)}} </span>
		<span class = "fld33"> {{substr($fld33,0,2)}} </span>
		<span class = "fld33a"> {{substr($fld33,3,2)}} </span>
		<span class = "fld33b"> {{substr($fld33,6,4)}} </span>
		<span class = "fld34"> {{$fld34}} </span>
		<span class = "fld35"> {{$fld35}} </span>
		<span class = "fld36"> {{$fld36}} </span>
		<span class = "fld37"> {{$fld37}} </span>
		<span class = "fld38"> {{$fld38}} </span>
		<span class = "fld39"> {{$fld39}} </span>
		<span class = "26a fld40"> {{$fld40}} </span>
		<span class = "26a fld41"> {{$fld41}} </span>
		<span class = "26b fld42"> {{$fld42}} </span>
		<span class = "26b fld43"> {{$fld43}} </span>
		<span class = "26b fld44"> {{$fld44}} </span>
		<span class = "fld45"> {{$fld45}} </span>
		<span class = "fld46"> {{$fld46}} </span>
		<span class = "fld47"> {{$fld47}} </span>
		<span class = "fld48"> {{$fld48}} </span>
		<span class = "fld49"> {{$fld49}} </span>
		<span class = "fld50"> {{$fld50}} </span>
		<span class = "fld51"> {{$fld51}} </span>
		<span class = "fld52"> {{$fld52}} </span>
		<span class = "fld53"> {{$fld53}} </span>
</div>
	<p class = "sheets"> {{$sheets}} </p>
</html>