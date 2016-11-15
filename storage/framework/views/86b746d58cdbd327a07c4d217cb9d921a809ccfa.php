<!doctype html>
<html lang="en">
	<head>
		<link rel="icon" type="image/png" href="<?php echo e(asset('images/logo.png')); ?>"/>
		<meta charset="utf-8">
		<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	    <!-- load font awesome -->
	    <link href="<?php echo e(asset('css/ubuntufont.css')); ?>" rel="stylesheet">
	    <link href="<?php echo e(asset('css/font-awesome.css')); ?>" rel="stylesheet">
	    <link href="<?php echo e(asset('css/reset.css')); ?>" rel="stylesheet">
	    <link href="<?php echo e(asset('css/uikit.min.css')); ?>" rel="stylesheet">
	    <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet">
	    <link href="<?php echo e(asset('css/table.css')); ?>" rel="stylesheet">
		<link href="<?php echo e(asset('css/form-file.css')); ?>" rel="stylesheet">
      	<link href="<?php echo e(asset('css/style.min.css')); ?>" rel="stylesheet">

		<!-- load js -->
		<script type="text/javascript" language="javascript" src="<?php echo e(asset('js/jquery-3.1.0.js')); ?>"></script>
		<script type="text/javascript" language="javascript" src="<?php echo e(asset('js/uikit.js')); ?>"></script>
		<script type="text/javascript" language="javascript" src="<?php echo e(asset('js/components/sticky.min.js')); ?>"></script>
		<script type="text/javascript" language="javascript" src="<?php echo e(asset('js/components/search.min.js')); ?>"></script>
		<script type="text/javascript" language="javascript" src="<?php echo e(asset('js/components/datepicker.js')); ?>"></script>
        <script type="text/javascript" language="javascript" src="<?php echo e(asset('js/jstree.min.js')); ?>"></script>

		<title>
			<?php echo $__env->yieldContent('title'); ?> - NuvemHR (<?php echo e(ucwords(\App\tbl_company_model::where('company_id', \App\tbl_user_company_model::where('user_id', Auth::user()->user_id)->where('default_flag', 'Y')->first()->company_id)->first()->company_name)); ?>)
		</title>
		<?php echo $__env->yieldContent('styles'); ?>
	</head>
	<body>
		<?php echo $__env->make('main.shared._nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

	<div name="container">
		<?php echo $__env->yieldContent('content'); ?>
	</div>

	<?php echo $__env->yieldContent('scripts'); ?>

</body>
</html>