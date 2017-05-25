<?php echo $this->fetch('inc/header.html'); ?> 
<?php
$this->_var['dpagecss'][] = $this->_var['TMPL_REAL']."/css/project_index.css";

$this->_var['dpagejs'][] = $this->_var['TMPL_REAL']."/js/project_index.js";
$this->_var['dcpagejs'][] = $this->_var['TMPL_REAL']."/js/project_index.js";
?>
<link rel="stylesheet" type="text/css" href="<?php 
$k = array (
  'name' => 'parse_css',
  'v' => $this->_var['dpagecss'],
);
echo $k['name']($k['v']);
?>" />
<script type="text/javascript" src="<?php 
$k = array (
  'name' => 'parse_script',
  'v' => $this->_var['dpagejs'],
  'c' => $this->_var['dcpagejs'],
);
echo $k['name']($k['v'],$k['c']);
?>"></script>
<!--中间开始-->
<div class="main_9" style="margin-top: ; margin-bottom: 200px;">
	<div class="xm_9">
		<form action="/project-add" name="fqform" method="post">
			<h3>如果你有一颗真诚的心那么请在这里发起你的梦想</h3>
			<p><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'SITE_NAME',
);
echo $k['name']($k['v']);
?>是一家可以帮助您实现梦想的网站，在这里您可以发布您的梦想、创意和创业计划，</br>并通过网络平台面对公众集资，让有创造力的人可能获得他们所需要的资金，</br>以便使他们的梦想有可能实现。</p>
			<div class="pro-agr-chk">
				<input id="flag" name="flag" type="checkbox" checked="checked">
				阅读并同意<a style="color:#12adff;" href="../index.php?m=Home&c=Articles&a=zc&articleId=17" target="_blank"><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'SITE_NAME',
);
echo $k['name']($k['v']);
?>服务条款</a>
			</div>
			<div class="pro-agr-btn">
				<div class="ui-button theme_bgcolor">
					<a href="<?php
echo parse_url_tag("u:project#add|"."".""); 
?>" ><span class="common-sprite2">立即发起项目</span></a>
				</div>
				<div class="blank20"></div>
				<div class="ui-button theme_bgcolor" style="display:none;">
					<a href="<?php
echo parse_url_tag("u:investor#index|"."".""); 
?>" >认证投资者</a>
				</div>
			</div>
		</form>
	</div>
</div>
<!--中间结束-->

<div class="blank"></div>
<?php echo $this->fetch('inc/footer.html'); ?>