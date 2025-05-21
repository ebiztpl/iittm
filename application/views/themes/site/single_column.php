<?php
	// Use $theme_view to get access of views from specified theme folder in views=>layouts
	// as $this->load->view($theme_view.'your_view');
?>

<?php $this->load->view($theme_view.'header'); ?>
<?php echo $content; ?>

	
<!--  End: .content-wrapper -->
<?php $this->load->view($theme_view.'footer'); ?>
