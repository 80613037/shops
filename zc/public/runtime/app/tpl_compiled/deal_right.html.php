<!--右start-->
<div class="xqmain_right">
	<!--第一部分start-->
	<div class="box f_l">
		<div>
			<span class="box_title f_l">目前累计金额</span>
			<span class="zcz f_r">
			<?php if ($this->_var['deal_info']['begin_time'] > $this->_var['now']): ?>
			即将开始
			<?php elseif ($this->_var['deal_info']['end_time'] < $this->_var['now'] && $this->_var['deal_info']['end_time'] != 0): ?>
				<?php if ($this->_var['deal_info']['percent'] >= 100): ?>
			已成功
				<?php else: ?>
			筹资失败
				<?php endif; ?>	 
			<?php else: ?>
				<?php if ($this->_var['deal_info']['percent'] >= 100): ?>
					已成功
				<?php elseif ($this->_var['deal_info']['end_time'] == 0): ?>
			长期项目
				<?php else: ?>
			筹资中
				<?php endif; ?>
			<?php endif; ?>
			</span>	
		</div>
		<div class="blank0"></div>
		<span class="box_nu theme_fcolor f_l"><em class="f20">¥</em><?php echo $this->_var['deal_info']['total_virtual_price']; ?></span>
		<div class="blank"></div>
		<div class="jd">
			<div class="f_l" style="width:240px;*width:238px;margin-top:5px;">
			<?php if ($this->_var['deal_info']['begin_time'] > $this->_var['now']): ?>
				<div class="ui-progress" style="width:240px;*width:238px;">
					<span style="width:<?php echo $this->_var['deal_info']['percent']; ?>%;background:#ffae00;"></span>
				</div>
			<?php elseif ($this->_var['deal_info']['end_time'] < $this->_var['now'] && $this->_var['deal_info']['end_time'] != 0): ?>
				<?php if ($this->_var['deal_info']['percent'] >= 100): ?>				
				<div class="ui-success" style="width:240px;*width:238px;">
					<span class="theme_bgcolor" style="width:100%;"></span>
				</div>
				<?php else: ?>
				<div class="ui-progress" style="width:240px;*width:238px;">
					<span style="width:<?php echo $this->_var['deal_info']['percent']; ?>%;background:#4d4d4f;"></span>
				</div>
				<?php endif; ?>
			<?php else: ?>
				<?php if ($this->_var['deal_info']['percent'] >= 100): ?>
				<div class="ui-success" style="width:240px;*width:238px;">
					<span style="width:100%;"></span>
				</div>
				<?php else: ?>
					<?php if ($this->_var['deal_info']['end_time'] == 0): ?>
				<div class="ui-progress" style="width:240px;*width:238px;">
					<span class="theme_bgcolor" style="width:<?php echo $this->_var['deal_info']['percent']; ?>%;"></span>
				</div>
					<?php else: ?>
				<div class="ui-progress" style="width:240px;*width:238px;">
					<span class="theme_bgcolor" style="width:<?php echo $this->_var['deal_info']['percent']; ?>%;"></span>
				</div>
					<?php endif; ?>	
				<?php endif; ?>
			<?php endif; ?>
			</div>
	        <div class="f_r"><?php echo $this->_var['deal_info']['percent']; ?>%</div>
		</div>
		<div class="blank10"></div>
		<div class="jd1">
			<span class="zs f_l">目标</span>
			<span class="nu1 f_r"><?php echo $this->_var['deal_info']['limit_price_format']; ?>元</span>
		</div>
		<?php if ($this->_var['deal_info']['end_time'] != 0): ?>	
		<div class="jd1">
			<span class="zs f_l">剩余</span>
			<span class="nu1 f_r"><?php if ($this->_var['deal_info']['remain_days'] < 0): ?><?php if ($this->_var['deal_info']['percent'] > 100): ?>已成功<?php else: ?>已过期<?php endif; ?><?php else: ?><?php echo $this->_var['deal_info']['remain_days']; ?>天<?php endif; ?></span>
		</div>
		<?php endif; ?>
		<div class="jd1">
			<span class="zs f_l">支持者</span>
			<?php if ($this->_var['deal_info']['virtual_person'] == 0): ?>
			<span class="nu1 f_r"><?php echo $this->_var['deal_info']['support_count']; ?>人</span>
			<?php endif; ?>
			<?php if ($this->_var['deal_info']['virtual_person'] != 0): ?>
			<span class="nu1 f_r"><?php echo $this->_var['deal_info']['person']; ?>人</span>
			<?php endif; ?>
		</div>
		<div class="jd2 f_red">项目截止时间：<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['deal_info']['end_time'],
  'f' => 'Y年m月d日H时i分',
);
echo $k['name']($k['v'],$k['f']);
?></div>
	</div>
	<!--第一部分end-->
	<!--第二部分start-->
	<?php $_from = $this->_var['deal_item_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'deal_item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['deal_item']):
?>
	<div class="box2 f_l">
		<div class="box21">
			<span class="box2_title f_l">支持¥<?php echo $this->_var['deal_item']['price_format']; ?></span>
			<span class="f_r">已有<em class="f18 f_red"><?php echo $this->_var['deal_item']['virtual_person_list']; ?></em>位支持者</span>
		</div>
		<div class="box22">
			<span class="box22_1 f_l">
				<?php 
$k = array (
  'name' => 'nl2br',
  'v' => $this->_var['deal_item']['description'],
);
echo $k['name']($k['v']);
?>
			</span>
			<div class="blank1"></div>
			<span class="box22_2 f_l" style="width:100%">
			<div style="width:100%">
			<?php if ($this->_var['deal_item']['is_delivery'] == 1): ?>
				<?php if ($this->_var['deal_item']['delivery_fee'] == 0): ?>
				运费：包邮
				<?php else: ?>
				运费：¥<?php 
$k = array (
  'name' => 'round',
  'v' => $this->_var['deal_item']['delivery_fee'],
  'e' => '2',
);
echo $k['name']($k['v'],$k['e']);
?>
				<?php endif; ?>
				&nbsp;&nbsp;
			<?php endif; ?>
			<?php if ($this->_var['deal_item']['is_limit_user'] == 1): ?>
				<?php if ($this->_var['deal_item']['limit_user'] > 0): ?>
				限额：<?php echo $this->_var['deal_item']['limit_user']; ?>位&nbsp;&nbsp;&nbsp;
				剩余：<?php echo $this->_var['deal_item']['remain_person']; ?>位
				<?php endif; ?>
			<?php endif; ?>
			</div>
			<div class="deal_item_images" style="overflow:hidden;text-align:left">	
				<div class="blank5"></div>			
				<?php $_from = $this->_var['deal_item']['images']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'image');if (count($_from)):
    foreach ($_from AS $this->_var['image']):
?>
				<div class="image_item">
					<img src="<?php 
$k = array (
  'name' => 'get_spec_image',
  'v' => $this->_var['image']['image'],
  'w' => '50',
  'h' => '50',
  'g' => '1',
);
echo $k['name']($k['v'],$k['w'],$k['h'],$k['g']);
?>" rel="<?php 
$k = array (
  'name' => 'get_spec_image',
  'v' => $this->_var['image']['image'],
  'w' => '570',
  'h' => '430',
);
echo $k['name']($k['v'],$k['w'],$k['h']);
?>" width=50 height=50 />
				</div>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</div>
			<?php if ($this->_var['deal_item']['repaid_day'] > 0): ?>
			<div class="blank5"></div>
			<div>
				预计发放时间：项目成功结束后<?php echo $this->_var['deal_item']['repaid_day']; ?>天内
				</div>
			<?php endif; ?>
			</span>
			<?php if (( $this->_var['deal_info']['end_time'] > $this->_var['now'] || $this->_var['deal_info']['end_time'] == 0 ) && $this->_var['deal_info']['begin_time'] < $this->_var['now'] && $this->_var['deal_info']['is_effect'] == 1): ?>
			<?php if ($this->_var['deal_item']['support_count'] < $this->_var['deal_item']['limit_user'] || $this->_var['deal_item']['limit_user'] == 0): ?>
			<!--<a class="box22_3 theme_bgcolor" href="<?php
echo parse_url_tag("u:cart|"."id=".$this->_var['deal_item']['id']."".""); 
?>" target="_blank">-->
				<!--<div>-->
					<!--<span>支持¥<?php echo $this->_var['deal_item']['price_format']; ?></span>-->
				<!--</div>-->
			<!--</a>-->
			<?php else: ?>
			<div class="box22_3 bg_gray" disabled="disabled">已满额</div>
			<?php endif; ?>
			<?php else: ?>
			<div class="box22_3 bg_gray" disabled="disabled">支持¥<?php echo $this->_var['deal_item']['price_format']; ?></div>
			<?php endif; ?>
			<div class="blank0"></div>
		</div>
	</div>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	<!--第二部分end-->	
		<?php if ($this->_var['deal_info']['description_1'] != null): ?>
	<div class="blank"></div>
	<div class="box3" style="background:#fff9e9;">
		<div class="box31">付款与退款说明：</div>
		<div class="box32" style="padding-bottom:0">
				<?php echo $this->_var['deal_info']['description_1']; ?>
		</div>
	</div>
	<div class="blank"></div>
	<?php endif; ?>
	<!--第3部分-->
	<!--
	<div class="box3">
		<div class="box31">发起人信息</div>
		<div class="box32">
			<div class="box_image f_l">
				<?php 
$k = array (
  'name' => 'show_avatar',
  'p' => $this->_var['deal_info']['user_id'],
);
echo $k['name']($k['p']);
?>
			</div>
			<div class="f_l" style=" height:80px; overflow:hidden;">
				<span class="boxname"><?php echo $this->_var['deal_info']['user_name']; ?></span>
				<span class="boxtime">上次登录时间：<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['deal_info']['login_time'],
  'f' => 'Y/m/d',
);
echo $k['name']($k['v'],$k['f']);
?></span>
				<?php if ($this->_var['deal_info']['province'] != '' || $this->_var['deal_info']['city'] != ''): ?>
				<span class="boxaddress"><?php echo $this->_var['deal_info']['province']; ?>&nbsp;<?php echo $this->_var['deal_info']['city']; ?></span>
				<?php endif; ?>
				<a href="javascript:send_message(<?php echo $this->_var['deal_info']['user_id']; ?>);" class="boxmail">发信息</a>
				
			</div>
			
		</div>
	</div>-->
	<div class="blank"></div>
	<!--第3部分结束-->	
</div>
<!--右end-->