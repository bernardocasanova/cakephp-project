<div class="page-error-404">

	<div class="error-symbol">
		<i class="entypo-attention"></i>
	</div>

	<div class="error-text">
		<h2>404</h2>
		<p><?php echo $message; ?></p>
	</div>

</div>

<?php
if (Configure::read('debug') > 0) {
	echo $this->element('exception_stack_trace');
}
?>
