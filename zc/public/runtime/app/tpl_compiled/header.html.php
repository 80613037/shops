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
	DD_belatedPNG.fix('.banner .btn_tit ul li.on , .banner .btn_tit ul li , .mx_1 , .mx_2 , .mx_3 , .mx_4 , .xzdq1 , .zcz , .timeline-left-gray , .deal_log_title .title , .timeline-comment-top , .timeline-start span , .pageleft a , .dz , .kj , .mf , .boxaddress , .xzdq , .con6 .sub , .fx i , .attention_focus_deal i , .head_down_icon , .banner .prev , .banner .next , .mxr_1 , .mxr_2 , .mxr_3 , .shenhe .shenhe_info li , .mod_title i , .box4 .mod_cont3 .leader_t , .box4 .mod_cont3 .leader_w , .box4 .mod_cont3 .leader_r , .box4 .mod_cont3 .leader_x , .box4 .mod_cont3 .leader_p , .step_box , .pageleft a i , .invester_all .col_a , .article_l li.on , .article_box .article_r_list h3 , .deals_cate_equity .equity_box .equity_box_l .inf_2 i , .fa , .send_message');
	</script>
<![endif]-->
</head>
<body>
<div class="header" id="J_head">
	<div class="wrap">
		<div class="logo f_l" style="display: none;">
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
		<ul class="main_nav f_l" style="display: none;">
		<?php $_from = $this->_var['nav_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav_item');if (count($_from)):
    foreach ($_from AS $this->_var['nav_item']):
?>
			<li class="<?php if ($this->_var['deal_type']): ?> <?php if ($this->_var['deal_type'] == 'gq_type' && $this->_var['nav_item']['u_module'] == 'deals' && $this->_var['nav_item']['u_action'] == 'index' && $this->_var['nav_item']['u_param'] == 'type=1'): ?>current<?php elseif ($this->_var['deal_type'] == 'product_type' && $this->_var['nav_item']['u_module'] == 'deals' && $this->_var['nav_item']['u_action'] == 'index' && $this->_var['nav_item']['u_param'] == ''): ?>current<?php elseif ($this->_var['deal_type'] == 'home' && $this->_var['nav_item']['u_module'] == 'investor' && $this->_var['nav_item']['u_action'] == 'invester_list'): ?>current<?php elseif ($this->_var['deal_type'] == 'article_type' && $this->_var['nav_item']['u_module'] == 'article_cate' && $this->_var['nav_item']['u_action'] == '' && $this->_var['nav_item']['u_param'] == ''): ?>current<?php endif; ?> <?php else: ?> <?php if ($this->_var['nav_item']['current'] == 1): ?>current<?php endif; ?><?php endif; ?>">
				<a href="<?php echo $this->_var['nav_item']['url']; ?>"  target="<?php if ($this->_var['nav_item']['blank'] == 1): ?>_blank<?php endif; ?>" title="<?php echo $this->_var['nav_item']['name']; ?>">
					<span><?php echo $this->_var['nav_item']['name']; ?></span>
				</a>
			</li>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
		<div class="f_l" style="display: none;">
			<form action="<?php
echo parse_url_tag("u:deals|"."".""); 
?>" method="post" id="header_search_form">
			<div class="header_seach f_l">
			<input type="button" value="" class="seach_submit" id="header_submit">
			<input type="text" id="header_keyword" name="k" placeholder="搜索项目" class="seach_text">
            <?php if (app_conf ( "INVEST_STATUS" ) == 0): ?>
				<div id="ddlText" class="ddlspan ">产品众筹</div>
            	<input type="hidden" name="hid_ddlText" value="0" />
			<?php endif; ?>
			<?php if (app_conf ( "INVEST_STATUS" ) == 1): ?>
				<div id="ddlText" class="ddlspan ">产品众筹</div>
            	<input type="hidden" name="hid_ddlText" value="0" />
			<?php endif; ?>
			<?php if (app_conf ( "INVEST_STATUS" ) == 2): ?>
				<div id="ddlText" class="ddlspan ">股权众筹</div>
            	<input type="hidden" name="hid_ddlText" value="1" />
			<?php endif; ?>
            <ul class="ddlul" tagdom="ddlText">
				<?php if (app_conf ( "INVEST_STATUS" ) == 0): ?>
         			<li livalue="0" class="libg class_select">产品众筹</li>
             		<li livalue="1" class="class_select">股权众筹</li>
				<?php endif; ?>
				<?php if (app_conf ( "INVEST_STATUS" ) == 1): ?>
					<li livalue="0" class="libg class_select">产品众筹</li>
				<?php endif; ?>
				<?php if (app_conf ( "INVEST_STATUS" ) == 2): ?>
					<li livalue="1" class="libg class_select">股权众筹</li>
				<?php endif; ?>
            </ul>
				<?php if (app_conf ( "INVEST_STATUS" ) == 0): ?>
					<input type="hidden" name="type" value="0"/>
					<input type="hidden" name="redirect" value="1"/>
				<?php endif; ?>
				<?php if (app_conf ( "INVEST_STATUS" ) == 1): ?>
					<input type="hidden" name="type" value="0"/>
				<?php endif; ?>
				<?php if (app_conf ( "INVEST_STATUS" ) == 2): ?>
					<input type="hidden" name="type" value="1"/>
				<?php endif; ?>
			</div>
			</form>
        </div>
		<div class="f_r" style="width:320px;">
			<?php 
$k = array (
  'name' => 'login_tip',
);
echo $this->_hash . $k['name'] . '|' . base64_encode(serialize($k)) . $this->_hash;
?>
			<!--<div class="login_tip"><span>-->
				<!--<a href="javascript:void(0);" id="mycenter" style=""><?php 
$k = array (
  'name' => 'msubstr',
  'v' => $this->_var['user_info']['user_name'],
  'b' => '0',
  'e' => '10',
);
echo $k['name']($k['v'],$k['b'],$k['e']);
?></a> 欢迎您来到 <?php echo $this->_var['site_name']; ?>！-->
				<!--</span>-->
			<!--</div>-->
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		// 头部搜索类目选项
		$("#ddlText").click(function(e){
            e.stopPropagation();
            var $this=$(this);
            $this.next().next(".ddlul").css("width",($this.width()+5)+"px").show();
            var lia=$this.prev("input[name='hid_ddlText']").val();
            if($.trim(lia)!=""){
                $(".ddlul li").each(function() {
                    if($this.attr("livalue")==lia){
                        $this.addClass("libg");
                    }
                    else{
                    	$this.removeClass("libg");
                	}
                });
            }
            $(".ddlul li").bind('hover',function(){
                $(this).addClass("libg").siblings().removeClass("libg");
            });
        });
        $(document).click(function(event)  {
            var eo  =  $(event.target);
            if($(".ddlul").is(":visible") && eo.attr("class") != "ddlul" && !eo.parent(".ddlul").length) {
                $('.ddlul').hide();
            }
        });
        $(".ddlul li").live('click',function(){
            $(this).parent().prev().prev("#ddlText").text($(this).html());
            $(this).parent().prev("input[name='hid_ddlText']").val($(this).attr("livalue"));
            $("input[name='type']").val($(this).attr("livalue"));
            $(".ddlul").hide();
    	});


		//解决input中placeholder值在ie中无法支持的问题
		var doc=document,inputs=doc.getElementsByTagName('input'),supportPlaceholder='placeholder'in doc.createElement('input'),placeholder=function(input){var text=input.getAttribute('placeholder'),defaultValue=input.defaultValue;
		if(defaultValue==''){
			input.value=text}
			input.onfocus=function(){
				if(input.value===text){
				this.value=''
				}
			};
			input.onblur=function(){
				if(input.value===''){
					this.value=text
				}
			}
		};
		if(!supportPlaceholder){
			for(var i=0,len=inputs.length;i<len;i++){
				var input=inputs[i],text=input.getAttribute('placeholder');
				if(input.type==='text'&&text){
					placeholder(input)
				}
			}
		}
	});
</script>