<li class=""><a href="<?php echo site_url('services');?>"><i class="glyphicon glyphicon-dashboard"></i> <span>Services</span></a></li>
<li class=""><a href="<?php echo site_url('sites')?>"><i class="glyphicon glyphicon-file"></i> <span>Landing Pages</span></a></li>
<?php if(userdata( 'visitor_count' )!='inactive'):?>
<li><a href="<?php echo site_url('visitor');?>"><i class="glyphicon glyphicon-list-alt"></i> <span>Report</span></a></li>
<?php endif;?>
<li><a href="<?php echo site_url('seo');?>"><i class="glyphicon glyphicon-share"></i> <span>SEO</span></a></li>
<li><a href="<?php echo site_url('account/plans');?>"><i class="glyphicon glyphicon-briefcase"></i> <span>Account</span></a></li>
<?php if(userdata( 'premium_domain' )!='inactive'):?>
<li><a href="<?php echo site_url('domain');?>"><i class="glyphicon glyphicon-globe"></i> <span>Premium Domain</span></a></li>
<?php endif;?>
<li><a href="<?php echo site_url('services');?>"><i class="glyphicon glyphicon-bullhorn"></i> <span>Support</span></a></li>