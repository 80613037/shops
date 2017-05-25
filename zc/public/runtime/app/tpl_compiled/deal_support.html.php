<?php echo $this->fetch('inc/header.html'); ?> 
<style>
.support_avatar{float:left; width:60px; height:60px;}
.support_avatar img{width:60px; height:60px;}
.deal_item_images .image_item {
	float: left;
	border: #ccc solid 1px;
	display: inline-block;
	width: 50px;
	height: 50px;
	margin-right: 10px;
	cursor: url(http://localhost/zc_4/app/Tpl/fanwe_1/images/zoom.cur),auto;
}
</style>
<div class="blank"></div>
<!--中间开始-->
<div class="xqmain">
	<!--中间页面头部start-->	
	<?php echo $this->fetch('inc/deal_header.html'); ?>
	<!--中间页面头部end-->	
	<div class="xqmain_main">
		<!--左-->	
		<div class="xqmain_left">
			<?php $_from = $this->_var['support_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'support_item');if (count($_from)):
    foreach ($_from AS $this->_var['support_item']):
?>
			<div class="zcz_1 f_l">
				<div class="tu2 f_l support_avatar">
				<?php 
$k = array (
  'name' => 'show_avatar_nurl',
  'p' => $this->_var['support_item']['user_id'],
);
echo $k['name']($k['p']);
?>
				</div>
				<div class="nro f_l">
					<span class="nur_title"><a href="#"><?php echo $this->_var['support_item']['user_info']['user_name']; ?></a></span>
					<span class="nur_main">支持此项目<em class="f_money"> <?php 
$k = array (
  'name' => 'format_price',
  'v' => $this->_var['support_item']['price'],
);
echo $k['name']($k['v']);
?></em></span>
				</div>	
			</div>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			<div class="blank20"></div>
			<!--翻页-->
			<div class="page1"><?php echo $this->_var['pages']; ?></div>
		</div>
		<!--右-->
		<?php if ($this->_var['deal_info']['type'] == 0): ?>
			<?php echo $this->fetch('inc/deal_right.html'); ?>
		<?php endif; ?>
		<?php if ($this->_var['deal_info']['type'] == 1): ?>
			<?php echo $this->fetch('inc/deal_investor_right.html'); ?>
		<?php endif; ?>
		<!--右结束-->
	</div>
	<div class="blank"></div>
</div>
<!--中间结束-->
<div id="gotop" style="display: block;z-index:99;"></div>
<div class="blank"></div>
<?php echo $this->fetch('inc/footer.html'); ?> 