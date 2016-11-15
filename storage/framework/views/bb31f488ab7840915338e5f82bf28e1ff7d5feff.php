

<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('styles'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="uk-container uk-container-center">
	<div class="categories">
		<img src="<?php echo url('/img/trial123.png'); ?>">
	</div> <!-- categories -->
</div> <!-- content -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('shared._public', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>