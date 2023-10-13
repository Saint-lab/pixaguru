<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo html_escape($this->lang->line('ltr_err_exception_title')); ?>
<?php echo html_escape($this->lang->line('ltr_err_exception_type')); ?><?php echo get_class($exception), "\n"; ?>
<?php echo html_escape($this->lang->line('ltr_err_exception_msg')); ?><?php echo $message, "\n"; ?>
<?php echo html_escape($this->lang->line('ltr_err_exception_filename')); ?><?php echo $exception->getFile(), "\n"; ?>
<?php echo html_escape($this->lang->line('ltr_err_exception_line_num')); ?><?php echo $exception->getLine(); ?>
<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>
<?php echo html_escape($this->lang->line('ltr_err_exception_backtrace')); ?> 
<?php	foreach ($exception->getTrace() as $error): ?>
<?php		if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>
	<?php echo html_escape($this->lang->line('ltr_err_exception_file')); ?>  <?php echo $error['file'], "\n"; ?>
	<?php echo html_escape($this->lang->line('ltr_err_exception_line')); ?>  <?php echo $error['line'], "\n"; ?>
	<?php echo html_escape($this->lang->line('ltr_err_exception_function')); ?>  <?php echo $error['function'], "\n\n"; ?>
<?php		endif ?>
<?php	endforeach ?>
<?php endif ?>