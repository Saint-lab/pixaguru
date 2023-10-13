<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo html_escape($this->lang->line('ltr_auth_header_title')); ?></title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Script fonts (Google Fonts Calling) -->
		<link href="<?php echo base_url(); ?>assets/css/fonts.css" rel="stylesheet">
		<!-- Favicon  -->
        <link rel="shortcut icon" type="image/ico" href="<?php echo base_url(); ?>assets/images/favicon.png" />
	    <link rel="icon" type="image/ico" href="<?php echo base_url(); ?>assets/images/favicon.png" />
		<!-- Custom Style  -->
		<link href="<?php echo base_url(); ?>assets/css/datatables.min.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/css/auth.css?q=1" rel="stylesheet">
		<?php 
        $where = array('data_key' =>'google_analytics_header_script');
        $result_header_script = $this->Common_DML->get_data( 'theme_setting', $where);
        if(!empty($result_header_script[0]['data_value'])):
            echo $result_header_script[0]['data_value'];
        endif;
        ?> 
	</head>
	<body class="pg-auth-body">
		<!-- Preloader  -->
        <div class="pg-preloader-wrap">
            <div class="pg-preloader">
                <img src="<?php echo base_url(); ?>assets/images/preloader.gif" alt="">
            </div>
        </div>
		<!-- main wrapper start -->
		<div class="pg-auth-wrapper">
			<div class="pg-auth-container">
				<div class="pg-auth-row">
					<div class="pg-auth-form-row-inner">