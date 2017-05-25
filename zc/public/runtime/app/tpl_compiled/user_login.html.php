<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if ($this->_var['page_title'] != ''): ?><?php echo $this->_var['page_title']; ?> - <?php endif; ?><?php echo $this->_var['site_name']; ?> - <?php echo $this->_var['seo_title']; ?></title>
<meta name="keywords" content="<?php if ($this->_var['page_seo_keyword'] != ''): ?><?php echo $this->_var['page_seo_keyword']; ?><?php else: ?><?php echo $this->_var['seo_keyword']; ?><?php endif; ?>" />
<meta name="description" content="<?php if ($this->_var['page_seo_description'] != ''): ?><?php echo $this->_var['page_seo_description']; ?><?php else: ?><?php echo $this->_var['seo_description']; ?><?php endif; ?>" />
<?php
$this->_var['pagecss'][] = $this->_var['TMPL_REAL']."/css/css/font-awesome.css";
$this->_var['pagecss'][] = $this->_var['TMPL_REAL']."/css/css/layout.css";
$this->_var['pagecss'][] = $this->_var['TMPL_REAL']."/css/css/style.css";
$this->_var['pagecss'][] = $this->_var['TMPL_REAL']."/css/weebox.css";
$this->_var['pagejs'][] = $this->_var['TMPL_REAL']."/js/jquery-1.8.2.min.js";
$this->_var['pagejs'][] = $this->_var['TMPL_REAL']."/js/jquery.bgiframe.js";
$this->_var['pagejs'][] = $this->_var['TMPL_REAL']."/js/jquery.weebox.js";
$this->_var['pagejs'][] = $this->_var['TMPL_REAL']."/js/jquery.pngfix.js";
$this->_var['pagejs'][] = $this->_var['TMPL_REAL']."/js/lazyload.js";
$this->_var['pagejs'][] = $this->_var['TMPL_REAL']."/js/script.js";
$this->_var['cpagejs'][] = $this->_var['TMPL_REAL']."/js/script.js";
if(app_conf("APP_MSG_SENDER_OPEN")==1)
{
$this->_var['pagejs'][] = $this->_var['TMPL_REAL']."/js/msg_sender.js";
$this->_var['cpagejs'][] = $this->_var['TMPL_REAL']."/js/msg_sender.js";
}
if(HAS_DEAL_NOTIFY>0)
{
$this->_var['notifypagejs'][] = $this->_var['TMPL_REAL']."/js/notify_sender.js";
$this->_var['cnotifypagejs'][] = $this->_var['TMPL_REAL']."/js/notify_sender.js";
}
$this->_var['pagejs'][] = $this->_var['TMPL_REAL']."/js/plupload/plupload.full.min.js";
$this->_var['cpagejs'][] = $this->_var['TMPL_REAL']."/js/plupload/plupload.full.min.js";
?>
<link rel="stylesheet" type="text/css" href="<?php 
$k = array (
  'name' => 'parse_css',
  'v' => $this->_var['pagecss'],
);
echo $k['name']($k['v']);
?>" />
<script type="text/javascript">
var APP_ROOT = '<?php echo $this->_var['APP_ROOT']; ?>';
var LOADER_IMG = '<?php echo $this->_var['TMPL']; ?>/images/lazy_loading.gif';
var ERROR_IMG = '<?php echo $this->_var['TMPL']; ?>/images/image_err.gif';
<?php if (app_conf ( "APP_MSG_SENDER_OPEN" ) == 1): ?>
var send_span = <?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'SEND_SPAN',
);
echo $k['name']($k['v']);
?>000;
<?php endif; ?>
</script>
<script type="text/javascript" src="<?php 
$k = array (
  'name' => 'parse_script',
  'v' => $this->_var['pagejs'],
  'c' => $this->_var['cpagejs'],
);
echo $k['name']($k['v'],$k['c']);
?>"></script>
<?php if (HAS_DEAL_NOTIFY > 0): ?>
<script type="text/javascript" src="<?php 
$k = array (
  'name' => 'parse_script',
  'v' => $this->_var['notifypagejs'],
  'c' => $this->_var['cnotifypagejs'],
);
echo $k['name']($k['v'],$k['c']);
?>"></script>
<?php endif; ?>

<!--[if IE 6]>
	<script src="<?php echo $this->_var['TMPL']; ?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
	<script>
	DD_belatedPNG.fix('.banner .btn_tit ul li.on , .banner .btn_tit ul li , .mx_1 , .mx_2 , .mx_3 , .mx_4 , .xzdq1 , .zcz , .timeline-left-gray , .deal_log_title .title , .timeline-comment-top , .timeline-start span , .pageleft a , .dz , .kj , .boxaddress , .xzdq , .con6 .sub , .fx i , .attention_focus_deal i , .head_down_icon , .banner .prev , .banner .next , .mxr_1 , .mxr_2 , .mxr_3 , .shenhe .shenhe_info li , .mod_title i , .box4 .mod_cont3 .leader_t , .box4 .mod_cont3 .leader_w , .box4 .mod_cont3 .leader_r , .box4 .mod_cont3 .leader_x , .box4 .mod_cont3 .leader_p , .step_box , .pageleft a i , .invester_all .col_a , .article_l li.on , .article_box .article_r_list h3');
	</script>
<![endif]-->
<style type="text/css">
	body{background:#f3f3f3;}
	.control-group {margin-left:37px;}
	.dlmain { background:url(<?php echo $this->_var['TMPL']; ?>/images/images/reglog_bg.gif) repeat-y; }
	.dlr1{margin-bottom:50px}
	.J_wrap{position:relative;z-index:3;}
	.my_shadow_bg{position:relative;z-index:2;}
</style>
</head>
<body>
<div class="head_1 z100" id="J_head">
	<div class="head_cont" style="background:#fff">
		<div class="wrap1000 constr clearfix">
			<div class="logo_1 f_l">
				<a class="link" href="<?php echo $this->_var['APP_ROOT']; ?>/">
					<?php
						$this->_var['logo_image'] = app_conf("SITE_LOGO");
					?>
					<?php 
$k = array (
  'name' => 'load_page_png',
  'v' => $this->_var['logo_image'],
);
echo $k['name']($k['v']);
?>
				</a>
			</div>
			<!--<?php if ($this->_var['MODULE_NAME'] == 'user'): ?>-->
			<div class="f_yahei no-nav-text"><?php if ($this->_var['ACTION_NAME'] == 'login'): ?>登录<?php elseif ($this->_var['ACTION_NAME'] == 'register'): ?>注册<?php endif; ?></div>
			<!--<?php endif; ?>-->
		</div>
	</div>
	<p class="head_bg"></p>
</div>
<div id="J_wrap">
	<div class="blank80"></div>
	<div class="my_shadow_bg" style="margin:0">
		<?php echo $this->fetch('inc/user_login_box.html'); ?>
	</div>
	<div class="blank80"></div>
</div>
<!-- footer static -->
<div class="footer" pbid="footer" id="J_footer">
	<div class="footer-copy">
		<div class="footer-wrap">
			<div class="blank10"></div>
			<div style="color:#a5a5a5;font:12px 'SimSun';line-height:24px; text-align:center;">
				<?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'SITE_LICENSE',
);
echo $k['name']($k['v']);
?>&nbsp;<?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'STATE_CDOE',
);
echo $k['name']($k['v']);
?><br />
				<?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'NETWORK_FOR_RECORD',
);
echo $k['name']($k['v']);
?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		resetWindowBox();
	});
</script>
</body>
</html>



