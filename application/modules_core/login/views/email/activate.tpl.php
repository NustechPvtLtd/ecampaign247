<!DOCTYPE html>
<html><head><title><?php echo $this->config->item('site_title', 'ion_auth')?></title><meta content="utf-8" name="charset">
<style type="text/css">
#outlook a{padding:0;}
	body {width:100% !important; -webkit-text-size-adjust:none; margin:0; padding:0; font-family: 'Open Sans', sans-serif; background: #f5f5f5; font-size:12px;}
	img {border:0;height:auto;line-height:100%;outline:none;text-decoration:none;}
	table td{border-collapse:collapse;}
	a {color: #367fa9;text-decoration:none}
	a:hover {color: #367fa9;text-decoration:none;}
</style>
</head><body bgcolor="#f5f5f5" dir="undefined" style="width:100%;-webkit-text-size-adjust:none;margin:0;padding:0;font-family:'Open Sans',sans-serif;background:#f5f5f5;font-size:12px">
                
            <div style="background:#f5f5f5;padding:10px;">
<table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="-webkit-border-radius:5px;-moz-border-radius:5px;border-radius:5px;border:1px solid #1BBC9B;overflow:hidden;" width="600"><tbody><tr><td bgcolor="#1BBC9B" style="border-collapse:collapse;">
			<table border="0" cellpadding="0" cellspacing="20" width="100%"><tbody><tr><td style="font-size:25px;font-style:italic;border-collapse:collapse;"><font color="#FFFFFF"><span style="font-family:'Noto Sans', sans-serif;"><strong><?php echo $this->config->item('site_title', 'ion_auth')?></strong></span> <span style="font-size:50%;font-family:'Open Sans', sans-serif;">I can do it. You will do too!</span></font></td>
					</tr></tbody></table></td>
		</tr><tr><td style="border-collapse:collapse;">
			<table border="0" cellpadding="20" cellspacing="0" width="100%"><tbody><tr><td style="border-collapse:collapse;">&nbsp;</td>
					</tr><tr><td style="font-family:'Open Sans', sans-serif;font-size:12px;border-collapse:collapse;">	<h1><?php echo sprintf(lang('email_activate_heading'), $identity);?></h1>
	<p><?php echo sprintf(lang('email_activate_subheading'), anchor('login/activate/'. $id .'/'. $activation, lang('email_activate_link')));?></p></td>
					</tr><tr><td style="border-collapse:collapse;">&nbsp;</td>
					</tr></tbody></table></td>
		</tr><tr><td bgcolor="#1BBC9B" style="padding:10px;border-collapse:collapse;"><font color="#FFFFFF"><span style="font-size:10px;font-family:'Open Sans', sans-serif;">&copy; 2015 <?php echo $this->config->item('site_title', 'ion_auth')?>. All rights reserved</span></font></td>
		</tr></tbody></table></div></body></html>
