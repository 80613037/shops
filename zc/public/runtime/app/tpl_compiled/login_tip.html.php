<div class="login_tip">	
	<?php if ($this->_var['user_info']): ?>
	<span>
		<a href="javascript:void(0);" id="mymessage" style="padding: 0 6px;
	border-right: 1px solid #d2d2d2; display:none;">消息 <b class="head_down_icon"></b></a>
		<a href="javascript:void(0);" id="mycenter" style=""><?php 
$k = array (
  'name' => 'msubstr',
  'v' => $this->_var['user_info']['user_name'],
  'b' => '0',
  'e' => '10',
);
echo $k['name']($k['v'],$k['b'],$k['e']);
?></a>
		<!--<i class="line"></i>-->
		<!--<a href="<?php
echo parse_url_tag("u:user#loginout|"."".""); 
?>" title="退出" id="user_login_out" style="padding: 0 6px; ">退出</a>-->
	</span>
	<div id="mymessage_drop" style="position:absolute; display:none;">
		<div class="drop_box">
			<span><a href="<?php
echo parse_url_tag("u:news#fav|"."".""); 
?>">关注动态</a></span>
			<span><a href="<?php
echo parse_url_tag("u:comment|"."".""); 
?>">查看评论</a></span>
			<span><a href="<?php
echo parse_url_tag("u:message|"."".""); 
?>">查看私信</a></span>
			<span class="last"><a href="<?php
echo parse_url_tag("u:notify|"."".""); 
?>">查看通知(<?php echo $this->_var['USER_MESSAGE_COUNT']; ?>)</a></span>
		</div>
	</div>
	<!--
	<div id="mycenter_drop" style="position:absolute; display:none;">
		<div class="drop_box mycenter_drop">
			<span><a href="<?php
echo parse_url_tag("u:home|"."id=".$this->_var['user_info']['id']."".""); 
?>">我的主页</a></span>
			<span><a href="<?php
echo parse_url_tag("u:account|"."".""); 
?>">项目管理</a></span>
			<span><a href="<?php
echo parse_url_tag("u:settings|"."".""); 
?>">个人设置</a></span>
			<span><a href="<?php
echo parse_url_tag("u:news#fav|"."".""); 
?>">关注动态</a></span>
			<span><a href="<?php
echo parse_url_tag("u:comment|"."".""); 
?>">查看评论</a></span>
			<span><a href="<?php
echo parse_url_tag("u:message|"."".""); 
?>">查看私信<?php if ($this->_var['USER_MESSAGE_COUNT'] > 0): ?>(<?php echo $this->_var['USER_MESSAGE_COUNT']; ?>)<?php endif; ?></a></span>
			<span class="last"><a href="<?php
echo parse_url_tag("u:notify|"."".""); 
?>">查看通知<?php if ($this->_var['USER_NOTIFY_COUNT'] > 0): ?>(<?php echo $this->_var['USER_NOTIFY_COUNT']; ?>)<?php endif; ?></a></span>
		</div>
	</div>-->
	<?php else: ?>
	<span>
		<a title="登录" href="javascript:void(0)" style="padding: 0 6px; " onclick="javascript:show_pop_login();" >登录</a>
		<i class="line"></i>
		<?php if (app_conf ( "USER_INVESTMENT" ) == 1): ?>
			<a href="<?php
echo parse_url_tag("u:user#register|"."".""); 
?>" title="创业者注册">创业者注册</a>&nbsp;&nbsp;
			<a href="<?php
echo parse_url_tag("u:user#register|"."".""); 
?>" title="投资者注册">投资者注册</a>&nbsp;&nbsp;
		<?php endif; ?>
		<?php if (app_conf ( "USER_INVESTMENT" ) == 0): ?>
			<a href="<?php
echo parse_url_tag("u:user#register|"."".""); 
?>" title="注册" style="padding: 0 6px; ">注册</a>
		<?php endif; ?>	
	</span>
	<?php endif; ?>
	<a href="<?php
echo parse_url_tag("u:project#choose|"."".""); 
?>" class="ui-button theme_bgcolor ml15 mt20" style="float:left;padding:0 15px;height:35px;line-height:35px;">发起项目</a>	
</div> 
<?php if ($this->_var['USER_NOTIFY_COUNT'] > 0 || $this->_var['USER_MESSAGE_COUNT'] > 0): ?>
	<?php if ($this->_var['HIDE_USER_NOTIFY'] == 0): ?>
		<div id="user_notify_tip" style="position:absolute; z-index:1; display:none; margin-top:60px;">		
			<div class="notify_tip_box1" id="close_user_notify">
				<div class="close_user_notify1"></div>
				<?php if ($this->_var['USER_NOTIFY_COUNT'] > 0): ?>
				<span><a href="<?php
echo parse_url_tag("u:notify|"."".""); 
?>">您有 <font><?php echo $this->_var['USER_NOTIFY_COUNT']; ?></font> 条新通知</a></span>
				<?php endif; ?>
				<?php if ($this->_var['USER_MESSAGE_COUNT'] > 0): ?>
				<span><a href="<?php
echo parse_url_tag("u:message|"."".""); 
?>">您有 <font><?php echo $this->_var['USER_MESSAGE_COUNT']; ?></font> 条新信息</a></span>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>