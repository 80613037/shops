<?php
$this->_var['dpagejs'][] = $this->_var['TMPL_REAL']."/js/ajax_user_login.js";
$this->_var['dcpagejs'][] = $this->_var['TMPL_REAL']."/js/ajax_user_login.js";
?>
<script type="text/javascript" src="<?php 
$k = array (
  'name' => 'parse_script',
  'v' => $this->_var['dpagejs'],
  'c' => $this->_var['dcpagejs'],
);
echo $k['name']($k['v'],$k['c']);
?>"></script>
<style>
	.dlmain{position:relative;z-index:1;}
	.control-group{position:relative; _float:left;}
	.dlmain { background:url(<?php echo $this->_var['TMPL']; ?>/images/images/reglog_bg.gif) repeat-y; }
	.control-group label{width:30px}
</style>
<div class="blank"></div>
<!--中间开始-->
<div class="dlmain" style="overflow:hidden">
	<div class="f_l dlr"  style="height:350px;width:554px;">
		<div class="dlr1">
			<span class="f_l">用户登录</span>
			<span class="f_r" style="font-size:14px;color:#8c8c8c;line-height:14px; margin-top:16px;" >还没账号？  <a href="<?php
echo parse_url_tag("u:user#register|"."".""); 
?>" style="color:#0196db;"> 注册</a> </span>
		</div>
		<div class="blank0"></div>
		<form id="user_login_form" name="user_login_form" action="<?php
echo parse_url_tag("u:user#do_login|"."".""); 
?>">
			<div class="control-group">
				<label class="title control-label">账户</label>
				<input type="text" class="textbox" name="email" id="email" />
				<span class="holder_tip">邮箱或者用户名或者手机号</span>
			</div>
			<div class="blank0"></div>
			<div class="control-group">
				<label class="title control-label">密码</label>
				<input type="password" name="user_pwd" class="textbox" id="user_pwd" />
				<a href="<?php
echo parse_url_tag("u:user#getpassword|"."".""); 
?>" style="color:#1184df;font-size:13px;margin-left:10px;">忘记密码？</a> 
				<span class="holder_tip">请输入密码</span>
				<div class="blank0"></div>
			</div>
			<div class="blank0"></div>
	        <div class="control-group tl">
	        	<label class="title control-label"></label>
	        	<input type="checkbox" value="1" name="auto_login" checked="checked" style="height:16px;width:16px;vertical-align:middle;margin:0" />
					记住我（下次自动登录）
	        </div>     
	        <div class="blank0"></div>
			<div class="control-group"> 
				<label class="title control-label"></label>
				<input type="button" value="登录" name="submit_form" class="ui-button theme_bgcolor" id="btn_do_login" />
				<input type="hidden" value="1" name="ajax" />
			</div>
		</form>
	</div>
	<div class="f_r dl" style="overflow:hidden">
		<div class="dl1">使用其他账号直接登录:</div>
		<?php 
$k = array (
  'name' => 'api_login',
);
echo $this->_hash . $k['name'] . '|' . base64_encode(serialize($k)) . $this->_hash;
?>
	</div>
</div>
<!--中间结束-->
<script type="text/javascript">
	show_tip();

	$(document).ready(function(){
		setTimeout("autofillHide()", 100);
	});
	function autofillHide(){
		if($("#user_pwd").val() || $("#email").val()){
			$(".holder_tip").hide();
		}
		else{
			$(".holder_tip").show();
		}
	}		
</script>
<div class="blank"></div>
<div id="gotop" style="display: block;z-index:99;"></div>