<div class="userhomehd">
	<div class="wrap userhomehd1">
		<div class="userbox1img f_l"><?php 
$k = array (
  'name' => 'show_avatar',
  'p' => $this->_var['home_user_info']['id'],
  't' => 'big',
);
echo $k['name']($k['p'],$k['t']);
?></div>
		<div class="homebox1main f_l">
			<span class="username"><?php echo $this->_var['home_user_info']['user_name']; ?></span>
			<a class="sentmail" href="javascript:void(0);" style="font-size:12px; margin-left:5px;"  onclick="send_message(<?php echo $this->_var['home_user_info']['id']; ?>);"></a>	
			<div class="blank10"></div>
			<div class="home_user_join" style="color: #404040">
				<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['home_user_info']['create_time'],
  'f' => 'Y年m月d日',
);
echo $k['name']($k['v'],$k['f']);
?> 加入 <?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'SITE_NAME',
);
echo $k['name']($k['v']);
?>
			</div>
			<div class="home_user_weibo">
				<div class="title" style="float:left;">博客或微博</div>
				<div class="blank"></div>
				<ul>
					<?php $_from = $this->_var['home_user_info']['weibo_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'weibo_item');if (count($_from)):
    foreach ($_from AS $this->_var['weibo_item']):
?>
					<li><a href="<?php echo $this->_var['weibo_item']['weibo_url']; ?>" target="_blank" class="linkgreen"><?php echo $this->_var['weibo_item']['weibo_url']; ?></a></li>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</ul>
			</div>
		</div>
	</div>
	<div class="blank"></div>
</div>