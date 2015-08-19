<!DOCTYPE html>
<html dir="ltr">
<head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $pageMetaDescription;?>">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="<?php echo base_url();?>assets/img/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/ionicons.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/adminlte.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/skin-green.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/common.css" />
	<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/customer/assets/css/style.css" />-->
</head>
    <body class="skin-green">
        <header class="header">
            <a href="<?php echo base_url();?>/index.php" class="logo icon">
                <img src="<?php echo base_url();?>assets/img/logo.png"  />            
			</a>
            <nav class="navbar navbar-static-top" role="navigation"></nav>
        </header>
        <div class="wrapper">
            <div class="row" style="height: 50px;"><!-- --></div>
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <?php echo $body; ?>
            </div>
            <div class="col-lg-4"></div>
            <div class="clearfix"><!-- --></div>
        </div>
        <footer>
            <?php //$hooks->doAction('layout_footer_html', $this);?>
            <div class="clearfix"><!-- --></div>
        </footer>
		<script src="<?php echo base_url();?>assets/sites/js/jquery-1.8.3.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/knockout-3.1.0.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/notify.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/adminlte.js"></script>
		<!--<script type="text/javascript" src="/gutoor/customer/assets/js/app.js"></script>
		<script type="text/javascript" src="/gutoor/customer/assets/js/guest.js"></script>-->
    </body>
</html>