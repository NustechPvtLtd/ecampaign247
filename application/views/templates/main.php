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
	<?php if(isset($css)) echo implode("\n", $css) . "\n";?>
	<script src="<?php echo base_url();?>assets/sites/js/jquery-1.8.3.min.js"></script>
</head>
<body class="skin-green">
    <header class="header">
            <a href="<?php echo site_url();?>" class="logo icon">
                <img src="<?php echo base_url();?>assets/img/logo.png" alt="Customer area" />            
			</a>
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- <li class="dropdown tasks-menu">
                            <a href="javascript;;" class="header-account-stats dropdown-toggle" data-url="<?php //echo site_url('account/usage');?>" data-toggle="dropdown" title="<?php //echo 'Account usage';?>">
                                <i class="fa fa-tasks"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header"><?php //echo 'Account usage';?></li>
                                <li>
                                    <ul class="menu">
                                        <li>
                                            <a href="#"><h3><?php //echo 'Please wait, processing...';?></h3></a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="javascript:;" class="header-account-stats-refresh"><?php //echo 'Refresh';?></a>
                                </li>
                            </ul>
                        </li> -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo ($fullName = ucwords(userdata( 'username' ))) ? $fullName : 'Welcome';?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header bg-light-blue">
                                    <img src="<?php //echo Yii::app()->customer->getModel()->getAvatarUrl(90, 90);?>" class="img-circle"/>
                                    <p>
                                        <?php echo ($fullName = ucwords(userdata( 'username' ))) ? $fullName : 'Welcome';?>
                                    </p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo site_url();?>" class="btn btn-default btn-flat"><?php echo 'Profile';?></a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo site_url('login/logout');?>" class="btn btn-default btn-flat"><?php echo 'Logout';?></a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <aside class="left-side sidebar-offcanvas">
                <section class="sidebar">
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php //echo Yii::app()->customer->getModel()->getAvatarUrl(90, 90);?>" class="img-circle" />
                        </div>
                        <div class="pull-left info">
                            <p><?php echo ($fullName = ucwords(userdata( 'username' ))) ? $fullName : 'Welcome';?></p>
                        </div>
                    </div>
                    <ul class="sidebar-menu">
                    <?php if ($this->ion_auth->in_group(array('end-user'))){
                        include_once 'user_menu.php';
                    } elseif ($this->ion_auth->in_group(array('comp-admin'))){
                        include_once 'user_menu.php';
                        include_once 'customer_menu.php';
                    }else {
                        include_once 'admin_menu.php';
                    }?>
                    </ul>
                    <?php //if (Yii::app()->options->get('system.common.show_customer_timeinfo', 'no') == 'yes' && version_compare(EC_VERSION, '1.3.4.4', '>=')) { ?> 
                    <div class="timeinfo">
                        <div class="pull-left"><?php echo 'Local time';?></div>
                        <div class="pull-right"><?php echo unix_to_human(time()); ?></div>
                        <div class="clearfix"><!-- --></div>
                        <div class="pull-left"><?php echo 'System time';?></div>
                        <div class="pull-right"><?php echo date('Y-m-d H:i:s');?></div>
                        <div class="clearfix"><!-- --></div>
                    </div> 
                    <?php //} ?>                    
                </section>
            </aside>
            <aside class="right-side">
                <section class="content-header">
                    <h1><?php echo !empty($pageHeading) ? $pageHeading : '&nbsp;';?></h1>
                    <?php
						echo create_breadcrumb();
                    ?>
                </section>
                <section class="content">
                    <?php echo $body;?>
                </section>
            </aside>
        </div>
        <footer>
            <div class="clearfix"><!-- --></div>
        </footer>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/knockout-3.1.0.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/notify.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/adminlte.js"></script>	
		<!--<script type="text/javascript" src="<?php //echo base_url();?>customer/assets/js/app.js"></script>-->
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/flot/jquery.flot.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/flot/jquery.flot.resize.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/flot/jquery.flot.categories.min.js"></script>
        <?php if(isset($js)) echo implode("\n", $js) . "\n";?>
    </body>
</html>