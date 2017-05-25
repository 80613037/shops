<style type="text/css">
.deal_item_box1 .div3 {
	width: 50%;
}
.div3 span.num {
	font-size: 15px;
	line-height: 15px;
	color: #555;
}
.div3 span.til {
	color: #999;
	font-size: 12px;
	line-height: 12px;
}
.item_type{
	background:#0099ff;
	font-family:'Microsoft YaHei';
}
</style>
<?php $_from = $this->_var['deal_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'deal_item');$this->_foreach['deal_items'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['deal_items']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['deal_item']):
        $this->_foreach['deal_items']['iteration']++;
?>
<div class="deal_item_box f_l <?php if ($this->_foreach['deal_items']['iteration'] % 4 == 1): ?>first<?php endif; ?>">
    <!--1-->
	<div class="deal_content_box">
		<a href="<?php
echo parse_url_tag("u:deal#show|"."id=".$this->_var['deal_item']['id']."".""); 
?>" title="<?php echo $this->_var['deal_item']['name']; ?>" target="_blank" style="display:block;overflow:hidden">
			<img src="<?php if ($this->_var['deal_item']['image'] == ''): ?><?php echo $this->_var['TMPL']; ?>/images/empty_thumb.gif<?php else: ?><?php 
$k = array (
  'name' => 'get_spec_image',
  'v' => $this->_var['deal_item']['image'],
  'w' => '282',
  'h' => '220',
  'g' => '1',
);
echo $k['name']($k['v'],$k['w'],$k['h'],$k['g']);
?><?php endif; ?>" alt="<?php echo $this->_var['deal_item']['name']; ?>" alt="<?php echo $this->_var['deal_item']['name']; ?>">
		</a>
		<div class="blank"></div>
		<a href="<?php
echo parse_url_tag("u:deal#show|"."id=".$this->_var['deal_item']['id']."".""); 
?>" title="<?php echo $this->_var['deal_item']['name']; ?>" class="deal_title" target="_blank"><?php 
$k = array (
  'name' => 'msubstr',
  'v' => $this->_var['deal_item']['name'],
  'b' => '0',
  'e' => '25',
);
echo $k['name']($k['v'],$k['b'],$k['e']);
?></a>
		<div class="blank"></div>
	</div>
	<?php if ($this->_var['deal_item']['type'] == 1): ?>
	<!--2-->
	<div class="paiduan" style="height:30px;padding:10px 12px 0 12px ;line-height: 20px;color: #A4A4A4;">
		<span class="caption-title"><?php if ($this->_var['deal_item']['type'] == 1): ?>已筹资<?php else: ?>已预购<?php endif; ?>：<em><i class="font-yen">¥</i><?php 
$k = array (
  'name' => 'round',
  'v' => $this->_var['deal_item']['support_amount'],
  'e' => '2',
);
echo $k['name']($k['v'],$k['e']);
?></em></span>
		<span class="f_r">
			<?php if ($this->_var['deal_item']['begin_time'] > $this->_var['now']): ?>
			<span class="common-begin">即将开始</span>
			<?php elseif ($this->_var['deal_item']['end_time'] < $this->_var['now'] && $this->_var['deal_item']['end_time'] != 0): ?>
			<span <?php if ($this->_var['deal_item']['percent'] >= 100): ?>class="common-success"<?php else: ?>class="common-fail"<?php endif; ?>><?php if ($this->_var['deal_item']['percent'] >= 100): ?>已成功<?php else: ?>筹资失败<?php endif; ?></span> 	 
			<?php else: ?>
			<?php if ($this->_var['deal_item']['percent'] >= 100): ?>
				<span class="common-success">已成功</span>
			<?php else: ?>
				<span class="common-sprite">
					<?php if ($this->_var['deal_item']['end_time'] == 0): ?>
					长期项目
					<?php else: ?>
						<?php if ($this->_var['deal_item']['type'] == 1): ?>
						融资中
						<?php else: ?>
						筹资中
						<?php endif; ?>
 					<?php endif; ?>
				</span>
			<?php endif; ?>
			<?php endif; ?>
		</span>
		<span class="f_r mr10">
			<span class="common-success item_type b">股</span>
		</span>
	</div>
	<!--3-->
	<div class="deal_content_box deal_item_box1" style="padding:0 12px 0 12px; ">             
		<?php if ($this->_var['deal_item']['begin_time'] > $this->_var['now']): ?>
			<div class="ui-progress">
				<span style="width:<?php echo $this->_var['deal_item']['percent']; ?>%;background:#ffae00;"><?php echo $this->_var['deal_item']['percent']; ?>%</span>
			</div>
		<?php elseif ($this->_var['deal_item']['end_time'] < $this->_var['now'] && $this->_var['deal_item']['end_time'] != 0): ?>
			<?php if ($this->_var['deal_item']['percent'] >= 100): ?>				
			<div class="ui-success">
				<span class="theme_bgcolor" style="width:100%;">100%</span>
			</div>
			<?php else: ?>
			<div class="ui-progress">
				<span style="width:<?php echo $this->_var['deal_item']['percent']; ?>%;background:#4d4d4f;"><?php if (( $this->_var['deal_item']['percent'] > 0 && $this->_var['deal_item']['percent'] < 100 )): ?><?php echo $this->_var['deal_item']['percent']; ?>%<?php endif; ?></span>
			</div>
			<?php endif; ?>
			
 		<?php else: ?>
 			<?php if ($this->_var['deal_item']['percent'] >= 100): ?>
				<div class="ui-success">
					<span style="width:100%;">100%</span>
				</div>
			<?php else: ?>
				<?php if ($this->_var['deal_item']['end_time'] == 0): ?>
				<div class="ui-progress">
					<span class="theme_bgcolor" style="width:<?php echo $this->_var['deal_item']['percent']; ?>%;"></span>
				</div>
				<?php else: ?>
				<div class="ui-progress">
					<span class="theme_bgcolor" style="width:<?php echo $this->_var['deal_item']['percent']; ?>%;"><?php if (( $this->_var['deal_item']['percent'] > 0 && $this->_var['deal_item']['percent'] < 100 )): ?><?php echo $this->_var['deal_item']['percent']; ?>%<?php endif; ?></span>
				</div>
				<?php endif; ?>	
			<?php endif; ?>
				
			
		<?php endif; ?>
		<div class="blank"></div>
		<?php if ($this->_var['deal_item']['begin_time'] > $this->_var['now']): ?>
			<div class="div3" style="text-align:left; width:100%; text-align:center;">
				<span class="num til">距开始时间还剩<font><?php echo $this->_var['deal_item']['left_begin_days']; ?></font>天</span>
			</div>
		<?php else: ?>
		<div class="div3 f_l" style="text-align:left">
			<span class="num"><font><?php 
$k = array (
  'name' => 'round',
  'v' => $this->_var['deal_item']['limit_price_w'],
  'e' => '2',
);
echo $k['name']($k['v'],$k['e']);
?></font>万</span>
			<div class="blank10"></div>
			<span class="til">融资总额</span>
		</div>
		<div class="div3" style="text-align:right;float:right">
			<span class="num"><font><?php echo $this->_var['deal_item']['invote_mini_money_w']; ?></font>万</span>
			<div class="blank10"></div>
			<span class="til">单投资人最低出资</span>
		</div>
		<?php endif; ?>
		<div class="blank5"></div>
		<div class="follow">
			<em class="tl">支持：<?php echo $this->_var['deal_item']['invote_num']; ?></em>
			<em class="tc">跟投：<?php echo $this->_var['deal_item']['gen_num']; ?></em>
			<em class="tr">询价：<?php echo $this->_var['deal_item']['xun_num']; ?></em>
		</div>
		<div class="blank"></div>
	</div>
	<?php else: ?>
	<!--2-->
	<div class="paiduan" style="height:30px;padding:10px 12px 0 12px ;line-height: 20px;color: #A4A4A4;">
		<span class="caption-title">目标：<em><?php echo $this->_var['deal_item']['num_days']; ?>天</em> <em><i class="font-yen">¥</i><?php 
$k = array (
  'name' => 'round',
  'v' => $this->_var['deal_item']['limit_price'],
  'e' => '2',
);
echo $k['name']($k['v'],$k['e']);
?></em></span>
		<span class="f_r ">
			<?php if ($this->_var['deal_item']['begin_time'] > $this->_var['now']): ?>
			<span class="common-begin">即将开始</span>
			<?php elseif ($this->_var['deal_item']['end_time'] < $this->_var['now'] && $this->_var['deal_item']['end_time'] != 0): ?>
			<span <?php if ($this->_var['deal_item']['percent'] >= 100): ?>class="common-success"<?php else: ?>class="common-fail"<?php endif; ?>><?php if ($this->_var['deal_item']['percent'] >= 100): ?>已成功<?php else: ?>筹资失败<?php endif; ?></span> 	 
			<?php else: ?>
			<?php if ($this->_var['deal_item']['percent'] >= 100): ?>
				<span class="common-success">已成功</span>
			<?php else: ?>
				<span class="common-sprite">
					<?php if ($this->_var['deal_item']['end_time'] == 0): ?>
					长期项目
					<?php else: ?>
						<?php if ($this->_var['deal_item']['type'] == 1): ?>
						融资中
						<?php else: ?>
						筹资中
						<?php endif; ?>
 					<?php endif; ?>
				</span>
			<?php endif; ?>
			<?php endif; ?>
		</span>
	</div>
	<!--3-->
 	<div class="deal_content_box" style="padding:0 12px 0 12px; ">             
		<?php if ($this->_var['deal_item']['begin_time'] > $this->_var['now']): ?>
			<div class="ui-progress">
				<span style="width:<?php echo $this->_var['deal_item']['percent']; ?>%;background:#ffae00;"></span>
			</div>
		<?php elseif ($this->_var['deal_item']['end_time'] < $this->_var['now'] && $this->_var['deal_item']['end_time'] != 0): ?>
			<?php if ($this->_var['deal_item']['percent'] >= 100): ?>				
			<div class="ui-success">
				<span class="theme_bgcolor" style="width:100%;"></span>
			</div>
			<?php else: ?>
			<div class="ui-progress">
				<span style="width:<?php echo $this->_var['deal_item']['percent']; ?>%;background:#4d4d4f;"></span>
			</div>
			<?php endif; ?>
		<?php else: ?>
			
			<?php if ($this->_var['deal_item']['percent'] >= 100): ?>
				<div class="ui-success">
					<span style="width:100%;"></span>
				</div>
			<?php else: ?>
				<?php if ($this->_var['deal_item']['end_time'] == 0): ?>
				<div class="ui-progress">
					<span class="theme_bgcolor" style="width:<?php echo $this->_var['deal_item']['percent']; ?>%;"></span>
				</div>
				<?php else: ?>
				<div class="ui-progress">
					<span class="theme_bgcolor" style="width:<?php echo $this->_var['deal_item']['percent']; ?>%;"></span>
				</div>
				<?php endif; ?>	
			<?php endif; ?>
				
			
		<?php endif; ?>
		<div class="blank"></div>
		<?php if ($this->_var['deal_item']['begin_time'] > $this->_var['now']): ?>
			<div class="div3" style="text-align:left; width:100%; text-align:center;">
				<span class="num til">距开始时间还剩<font><?php echo $this->_var['deal_item']['left_begin_days']; ?></font>天</span>
			</div>
		<?php else: ?>
		<div class="div3" style="text-align:left;">
			<span class="num"><?php echo $this->_var['deal_item']['percent']; ?>%</span>
			<div class="blank10"></div>
			<span class="til">已达</span>
		</div>
		<div class="div3">
			<span class="num"><font><?php 
$k = array (
  'name' => 'round',
  'v' => $this->_var['deal_item']['support_amount'],
  'e' => '2',
);
echo $k['name']($k['v'],$k['e']);
?></font>元</span>
			<div class="blank10"></div>
 			<?php if ($this->_var['deal_item']['type'] == 1): ?>
			<span class="til">已预购</span>
			<?php else: ?>
			<span class="til">已筹资</span>
			<?php endif; ?>
		</div>
		<div class="div3" style="text-align:right;">
			<?php if ($this->_var['deal_item']['begin_time'] > $this->_var['now']): ?>
			<span class="num"><font><?php echo $this->_var['deal_item']['left_begin_days']; ?></font>天</span>
			<?php elseif ($this->_var['deal_item']['end_time'] < $this->_var['now'] && $this->_var['deal_item']['end_time'] != 0): ?>
			<span class="num"><?php if ($this->_var['deal_item']['percent'] > 100): ?><?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['deal_item']['success_time'],
  'f' => 'y/m/d',
);
echo $k['name']($k['v'],$k['f']);
?><?php else: ?><?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['deal_item']['end_time'],
  'f' => 'y/m/d',
);
echo $k['name']($k['v'],$k['f']);
?><?php endif; ?></span>
			<?php else: ?>
			<span class="num">
				<?php if ($this->_var['deal_item']['end_time'] == 0): ?>
				长期项目
				<?php else: ?>
				<font><?php echo $this->_var['deal_item']['remain_days']; ?></font>天
				<?php endif; ?>
			</span>
			<?php endif; ?>	
			<div class="blank10"></div>
			<span class="til">
				<?php if ($this->_var['deal_item']['begin_time'] > $this->_var['now']): ?>
					已经预热
				<?php elseif (( $this->_var['deal_item']['end_time'] < $this->_var['now'] && $this->_var['deal_item']['end_time'] != 0 )): ?>
					结束时间
				<?php else: ?>
					<?php if ($this->_var['deal_item']['end_time'] == 0): ?>
						长期项目
					<?php else: ?>
						剩余时间
					<?php endif; ?>
				<?php endif; ?>
			</span>				
		</div>
		<?php endif; ?>
		
		<div class="blank"></div>
	</div>
	<?php endif; ?>
</div>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>