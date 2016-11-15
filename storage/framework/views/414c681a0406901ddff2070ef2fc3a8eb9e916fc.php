<!doctype html>
<html lang="en">
<head>
	
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title><?php echo $__env->yieldContent('title'); ?> - Nuvem HR</title>
	
	<!-- primary styles -->
	<link rel="stylesheet" href="<?php echo e(asset('bootstrap/css/bootstrap.min.css')); ?>" />
	<link rel="stylesheet" href="<?php echo e(asset('font-awesome/css/font-awesome.min.css')); ?>" />
	
	<!-- login designs -->
	<link rel="stylesheet" href="<?php echo e(asset('logindesign/css/form-elements.css')); ?>">	
	<link rel="stylesheet" href="<?php echo e(asset('logindesign/css/style.css')); ?>">

	<?php echo $__env->yieldContent('styles'); ?>

</head>
<body>
	<div name="container">
		<?php echo $__env->yieldContent('content'); ?>
	</div>

	<?php echo $__env->yieldContent('modal'); ?>
		
	<?php echo $__env->yieldContent('scripts'); ?>

</body>
</html>