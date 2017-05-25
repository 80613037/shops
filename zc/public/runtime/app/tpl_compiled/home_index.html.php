<?php echo $this->fetch('inc/header.html'); ?> 
<?php
$this->_var['dpagecss'][] = $this->_var['TMPL_REAL']."/css/home.css";
$this->_var['dpagecss'][] = $this->_var['TMPL_REAL']."/css/deal.css";
$this->_var['dpagecss'][] = $this->_var['TMPL_REAL']."/css/deal.css";

?>
<link rel="stylesheet" type="text/css" href="<?php 
$k = array (
  'name' => 'parse_css',
  'v' => $this->_var['dpagecss'],
);
echo $k['name']($k['v']);
?>" />
<style>
	body{background:#fff;}
	#con_one_1{
		width:100%;
		display:block;
	}
</style>
<div id="J_wrap">
	<!--中间开始-->
	<?php echo $this->fetch('inc/home_user_info.html'); ?>
	<div class="nav_box" style="background:#f4f4f4;">
		<div class="nav_height">
			<div class="nav_hd wrap">
				<ul class="clearfix">
					<li <?php if (ACTION_NAME == 'home' || ACTION_NAME == 'index'): ?>class="nav_select"<?php endif; ?>><a href="<?php
echo parse_url_tag("u:home|"."id=".$this->_var['home_user_info']['id']."".""); 
?>">发起的项目(<?php echo $this->_var['deal_count']; ?>)</a></li>
					<li <?php if (ACTION_NAME == 'home' || ACTION_NAME == 'support'): ?>class="nav_select"<?php endif; ?>><a href="<?php
echo parse_url_tag("u:home#support|"."id=".$this->_var['home_user_info']['id']."".""); 
?>">支持的项目</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div style="border-bottom:1px solid #c6c6c6;height:1px; width:100%;margin-top:-2px"></div>
	<div class="wrap">
		<div class="blank20"></div>
		<div id="con_one_1" class="hover" style="">
			<div id="pin_box">
				<?php echo $this->fetch('inc/deal_list.html'); ?>
				<?php if ($this->_var['deal_list']): ?>
				<div class="blank20"></div>
				<div class="pages"><?php echo $this->_var['pages']; ?></div>
				<div class="blank20"></div>
				<?php endif; ?>
			</div>
			<div class="blank"></div>		
		</div>
		<div id="con_one_2" style="display: none;"> 支持的项目（12）</div>
		<div class="blank20"></div>	
	</div>
	<!--中间结束-->
</div>
<!--<div id="gotop" style="display: block;z-index:99;"></div>-->
<?php echo $this->fetch('inc/footer.html'); ?> 