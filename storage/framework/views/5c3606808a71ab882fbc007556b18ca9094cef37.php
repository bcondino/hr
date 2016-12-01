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
	top:58px;
}
	.fld1 {
		left:100px;
	}
	.fld2 {
		left:136px;
	}
	.shts {
		right:147px;
	}

.section2 {
	top:92.5px;
	letter-spacing:7px;
}
	.fld3 {
		left:18px;
	}
	.fld3a {
		left:83px;
	}
	.fld3b {
		left:144px;
	}
	.fld3c {
		left:207px;
		letter-spacing:4px;
	}
	.fld4 {
		right:290px;
	}
	.div2 {
		position:relative;
		top:1500px;	
	}

.section3 {
	top: 120px;
}
	.fld5 {
		letter-spacing:3px;
		left:18px;
	}
	.fld6 {
		letter-spacing:9.5px;
		right:-20px;
	}

.section4 {
	top:145px;
	font-size:10px;
}
	.fld7 {
		letter-spacing:3px;
		left:18px;
	}
	.fld8 {
		right:-20px;
	}

	.fld9 {
		font-weight:bolder;
		font-size:9px;
		top:170.2px;
		left:18px;
	}

	.sheets {
		position:relative;
		top:1500px;
		visibility:hidden;
	}

</style>
</head>

<body>
	<div class = "container"> 
		<span class = "section1 fld1"> <?php echo e(sprintf("%02d",$fld1)); ?> </span>
		<span class = "section1 fld2"> <?php echo e($fld2); ?> </span>
		<span class = "section1 shts"> <?php echo e(sprintf("%02d",$shts)); ?> </span>
		<span class = "section2 fld3"> <?php echo e(substr($fld3,0,3)); ?> </span>
		<span class = "section2 fld3a"> <?php echo e(substr($fld3,4,3)); ?> </span>
		<span class = "section2 fld3b"> <?php echo e(substr($fld3,8,3)); ?> </span>
		<span class = "section2 fld3c"> <?php echo e(substr($fld3,12,5)); ?> </span>
		<span class = "section2 fld4">  <?php echo e($fld4); ?> </span>
		<span class = "section3 fld5"> <?php echo e($fld5); ?> </span>
		<span class = "section3 fld6"> <?php echo e($fld6); ?> </span>
		<span class = "section4 fld7"> <?php echo e($fld7); ?> </span>
		<span class = "section4 fld8"> <?php echo e($fld8); ?> </span>
		<span class = "fld9"> <?php echo e($fld9); ?> </span>
	</div>
	<p class = "sheets"> <?php echo e($sheets); ?> </p>
</html>