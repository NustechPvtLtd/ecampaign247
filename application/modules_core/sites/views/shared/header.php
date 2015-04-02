<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php if( isset($pageTitle) ){ echo $pageTitle; } else { echo $this->lang->line('alternative_page_title'); }?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- Loading Bootstrap -->
	<link href="<?php echo base_url();?>bootstrap/css/bootstrap.css" rel="stylesheet">
	    
	<!--<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">-->
		
	<!-- Loading Flat UI -->
	<link href="<?php echo base_url();?>less/flat-ui.css" rel="stylesheet">
	<link href="<?php echo base_url();?>css/style.css" rel="stylesheet">
	<link href="<?php echo base_url();?>css/login.css" rel="stylesheet">
	
	<link href="<?php echo base_url();?>css/font-awesome.css" rel="stylesheet">
	
	<?php if( isset($builder) ):?>
	<link href="<?php echo base_url();?>css/builder.css" rel="stylesheet">
	<link href="<?php echo base_url();?>css/spectrum.css" rel="stylesheet">
	<link href="<?php echo base_url();?>css/chosen.css" rel="stylesheet">
	<link href="<?php echo base_url();?>js/redactor/redactor.css" rel="stylesheet">
	<?php endif;?>
	
	<link rel="shortcut icon" href="<?php echo base_url();?>images/favicon.ico">
	
	<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
	<!--[if lt IE 9]>
	<script src="<?php echo base_url();?>js/html5shiv.js"></script>
	<script src="<?php echo base_url();?>js/respond.min.js"></script>
	<![endif]-->
	<!--[if lt IE 10]>
	<link href="<?php echo base_url();?>css/ie-masonry.css" rel="stylesheet">
	<script src="<?php echo base_url();?>js/masonry.pkgd.min.js"></script>
	<![endif]-->
</head>