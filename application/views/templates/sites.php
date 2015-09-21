<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php if( isset($pageTitle) ){ echo $pageTitle; } else { echo $this->lang->line('alternative_page_title'); }?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="<?php echo base_url();?>assets/img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/ionicons.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/adminlte.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/skin-green.css" />
	
	<link href="<?php echo base_url();?>assets/sites/css/style.css" rel="stylesheet">
	<?php if( isset($builder) ):?>
	<link href="<?php echo base_url();?>assets/sites/less/flat-ui.css" rel="stylesheet"> 
	<link href="<?php echo base_url();?>assets/sites/css/builder.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/sites/css/spectrum.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/sites/css/chosen.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/sites/js/redactor/redactor.css" rel="stylesheet">
	<?php endif;?>
	
	
	<script src="<?php echo base_url();?>assets/sites/js/jquery-1.8.3.min.js"></script>
	<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
	<!--[if lt IE 9]>
	<script src="<?php echo base_url();?>assets/sites/js/html5shiv.js"></script>
	<script src="<?php echo base_url();?>assets/sites/js/respond.min.js"></script>
	<![endif]-->
	
	<!--[if lt IE 10]>
	<link href="<?php echo base_url();?>assets/sites/css/ie-masonry.css" rel="stylesheet">
	<script src="<?php echo base_url();?>assets/sites/js/masonry.pkgd.min.js"></script>
	<![endif]-->
	
	<?php if(isset($css)) echo implode("\n", $css) . "\n";?>
</head>
<body class="skin-green">
    <header class="header">
            <a href="<?php echo site_url();?>" class="logo icon">
                <img  class="img-responsive" src="<?php echo base_url();?>assets/img/logo.png" alt="Customer area" />            
			</a>
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <?php if($this->router->fetch_class()=='sites'):?>
                <ul class="nav navbar-nav">
                    <?php if( isset($siteData) || ( isset($page) && $page == 'newPage' ) ):?>

                        <?php if( isset($siteData) ):?>
                        <li class="active">
                            <a><span class="fui-home"></span> <span id="siteTitle"><?php echo $siteData['site']->sites_name?></span></a>
                        </li>
                        <?php endif;?>
                        <?php if( isset($page) && $page == 'newPage' ):?>
                        <li class="active">
                            <a><span class="fui-home"></span> <span id="siteTitle"><?php echo $this->lang->line('newsite_default_title')?></span> </a>
                        </li>
                        <?php endif;?>

                        <?php if( isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '' ):?>

                            <?php

                                //find out where we came from :)

                                $temp = explode("/", $_SERVER['HTTP_REFERER']);

                                if( array_pop($temp) == 'users' ) {

                                    $t = 'nav_goback_users';
                                    $to = site_url('users');

                                } else {

                                    $t = 'nav_goback_sites';
                                    $to = site_url('sites');

                                }

                            ?>

                            <li><a href="<?php echo site_url('services')?>" id="backButton"><span class="fui-arrow-left"></span> <?php echo 'Back to services';/*$this->lang->line( $t )*/?></a></li>

                        <?php else:?>

                            <li><a href="<?php echo site_url('services')?>" id="backButton"><span class="fui-arrow-left"></span> <?php echo 'Back to services';/*$this->lang->line('nav_goback_sites')*/?></a></li>

                        <?php endif;?>

                    <?php else:?>

                        <li <?php if( isset($page) && $page == "sites" ):?>class="active"<?php endif;?>><a href="<?php echo site_url('sites')?>"><span class="fui-windows"></span> <?php echo $this->lang->line('nav_sites')?></a></li>
                        <li <?php if( isset($page) && $page == "images" ):?>class="active"<?php endif;?>><a href="<?php echo site_url('sites/assets/images')?>"><span class="fui-image"></span> <?php echo $this->lang->line('nav_imagelibrary')?></a></li>
                        <?php if( $this->ion_auth->is_admin() ):?>
                        <!--<li <?php if( isset($page) && $page == "users" ):?>class="active"<?php endif;?>><a href="<?php echo site_url('users')?>"><span class="fui-user"></span> <?php echo $this->lang->line('nav_users')?></a></li>-->
                        <!--<li <?php if( isset($page) && $page == "settings" ):?>class="active"<?php endif;?>><a href="<?php echo site_url('settings')?>"><span class="fui-gear"></span> <?php echo $this->lang->line('nav_settings')?></a></li>-->
                        <?php endif;?>

                    <?php endif;?>
                </ul>
                <?php endif;?>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">

                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo ($fullName = ucwords(userdata( 'username' ))) ? $fullName : 'Welcome';?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header bg-light-blue">
                                    <img src="<?php echo (userdata('avatar'))? base_url('elements').'/images/uploads/'.userdata( 'user_id' ).'/'.userdata( 'avatar' ).'?'.time(): base_url('assets').'/sites/images/dude.png?'.time();?>" class="img-circle"/>
                                    <p>
                                        <?php echo ($fullName = ucwords(userdata( 'username' ))) ? $fullName : 'Welcome';?>
                                    </p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo site_url('user/profile')?>" class="btn btn-default btn-flat"><?php echo 'My Profile';?></a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo site_url('logout');?>" class="btn btn-default btn-flat"><?php echo 'Logout';?></a>
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
                            <img src="<?php echo (userdata('avatar'))? base_url('elements').'/images/uploads/'.userdata( 'user_id' ).'/'.userdata( 'avatar' ).'?'.time(): base_url('assets').'/sites/images/dude.png?'.time();?>" class="img-circle" />
                        </div>
                        <div class="pull-left info">
                            <p><?php echo ($fullName = ucwords(userdata( 'username' ))) ? $fullName : 'Welcome';?></p>
                        </div>
                    </div>
                    
                    <?php 
                    	if (isset($builder)){
                    		include_once 'builders_menu.php';
                    	}else {
                    		?>
                    		<ul class="sidebar-menu">
                    		<?php 
	                    		if ($this->ion_auth->in_group(array('individuals'))){
	                    			include_once 'user_menu.php';
	                    		} elseif ($this->ion_auth->in_group(array('comp-admin'))){
	                    			include_once 'user_menu.php';
//	                    			include_once 'customer_menu.php';
	                    		}else {
	                    			include_once 'admin_menu.php';
	                    		}
                    		?>
                    		</ul>
                    		<?php 
                    	}
                    ?>
                  
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
		<!-- Load JS here for greater good =============================-->
	    <script src="<?php echo base_url();?>assets/sites/js/jquery-ui.min.js" type="text/javascript" defer="defer"></script>
	    <script src="<?php echo base_url();?>assets/sites/js/jquery.ui.touch-punch.min.js" type="text/javascript" defer="defer"></script>
	    <script src="<?php echo base_url();?>assets/sites/js/bootstrap.min.js" type="text/javascript" defer="defer"></script>
	    <script src="<?php echo base_url();?>assets/sites/js/bootstrap-select.js" type="text/javascript" defer="defer"></script>
	    <script src="<?php echo base_url();?>assets/sites/js/bootstrap-switch.js" type="text/javascript" defer="defer"></script>
	    <script src="<?php echo base_url();?>assets/sites/js/flatui-checkbox.js" type="text/javascript" defer="defer"></script>
	    <script src="<?php echo base_url();?>assets/sites/js/flatui-radio.js" type="text/javascript" defer="defer"></script>
	    <script src="<?php echo base_url();?>assets/sites/js/jquery.tagsinput.js" type="text/javascript" defer="defer"></script>
	    <script src="<?php echo base_url();?>assets/sites/js/flatui-fileinput.js" type="text/javascript" defer="defer"></script>
	    <script src="<?php echo base_url();?>assets/sites/js/jquery.placeholder.js" type="text/javascript" defer="defer"></script>
	    <script src="<?php echo base_url();?>assets/sites/js/jquery.zoomer.js" type="text/javascript" defer="defer"></script>
	    <script src="<?php echo base_url();?>assets/sites/js/application.js" type="text/javascript" defer="defer"></script>
        <script src="<?php echo base_url();?>assets/js/adminlte.js" type="text/javascript" defer="defer"></script>
        <?php if(isset($js)) echo implode("\n", $js) . "\n";?>
        <script>
                var baseUrl = "<?php echo base_url();?>";
                var siteUrl = "<?php echo site_url('/');?>";

                <?php if( isset($siteData) ):?>
                var siteID = <?php echo $siteData['site']->sites_id;?>;
                <?php else:?>
                var siteID = 0;
                <?php endif;?>

                <?php if( isset($pagesData) ):?>
                var pagesData = <?php echo json_encode($pagesData);?>
                <?php endif;?>
               
        </script>
        <!--[if lt IE 10]>
        <script>
        $(function(){
        	var msnry = new Masonry( '#sites', {
    	    	// options
    	    	itemSelector: '.site',
    	    	"gutter": 20
    	    });
        
        })
        </script>
        <![endif]-->
    </body>
</html>