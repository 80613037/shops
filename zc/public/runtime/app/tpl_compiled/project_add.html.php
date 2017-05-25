<?php echo $this->fetch('inc/header.html'); ?> 
 
<script type="text/javascript"> 
//	var VAR_MODULE = "m";
//	var VAR_ACTION = "a";
	var ROOT = '<?php echo $this->_var['APP_ROOT']; ?>/keupload.php';
	var ROOT_PATH = '<?php echo $this->_var['APP_ROOT']; ?>';
	var can_use_quota = "<?php echo $this->_var['can_use_quota']; ?>";
//	var MAX_FILE_SIZE = "<?php echo (app_conf("MAX_IMAGE_SIZE")/1000000)."MB"; ?>";
</script>
<?php
$this->_var['dpagejs'][] = $this->_var['TMPL_REAL']."/js/deal_publish.js";
$this->_var['dcpagejs'][] = $this->_var['TMPL_REAL']."/js/deal_publish.js";
$this->_var['dpagejs'][] = $this->_var['TMPL_REAL']."/js/upload_deal_image.js";
$this->_var['dcpagejs'][] = $this->_var['TMPL_REAL']."/js/upload_deal_image.js";
$this->_var['dpagejs'][] = $this->_var['TMPL_REAL']."/js/ajaxupload.js";
$this->_var['dpagejs'][] = $this->_var['TMPL_REAL']."/js/switch_city.js";
$this->_var['dcpagejs'][] = $this->_var['TMPL_REAL']."/js/switch_city.js";
$this->_var['dpagejs'][] = APP_ROOT_PATH."/system/region.js";
$this->_var['dcpagejs'][] = APP_ROOT_PATH."/system/region.js";
?>
<script type="text/javascript"> 
    var ROOT = '<?php echo $this->_var['APP_ROOT']; ?>/m.php';
    var VAR_MODULE = "m";
    var VAR_ACTION = "a";
    var WEB_SESSION_ID = '<?php echo es_session::id(); ?>';
    var EMOT_URL = '<?php echo $this->_var['APP_ROOT']; ?>/public/emoticons/';
    var MAX_FILE_SIZE = "<?php echo (app_conf("MAX_IMAGE_SIZE")/1000000)."MB"; ?>";
    var UPLOAD_URL ='<?php echo $this->_var['APP_ROOT']; ?>/m.php?m=File&a=do_upload&upload_type=0&dir=image' ;
	var UPLOAD_SWF='<?php echo $this->_var['TMPL']; ?>/js/plupload/Moxie.swf';
	var UPLOAD_XAP='<?php echo $this->_var['TMPL']; ?>/js/plupload//Moxie.xap';
	var ALLOW_IMAGE_EXT= "gif,jpg,jpeg,png,bmp";
	var MAX_IMAGE_SIZE= "<?php echo (app_conf("MAX_IMAGE_SIZE")/1000000)."MB"; ?>";
	function get_file_fun(name){
    		$("#"+name).ui_upload({multi:false,
		FileUploaded:function(ajaxobj){
 				if(ajaxobj.error==1)
				{
					$.showErr(ajaxobj.info);
				}else{
					$("#"+name+"_url").val(ajaxobj.public_url);
					$("#"+name+"_image").attr('src',ajaxobj.url);
 				}
			},Error:function(error){
			$.showErr(error.message);
 		}});
	}
	
</script>
<script type="text/javascript" src="<?php 
$k = array (
  'name' => 'parse_script',
  'v' => $this->_var['dpagejs'],
  'c' => $this->_var['dcpagejs'],
);
echo $k['name']($k['v'],$k['c']);
?>"></script>
<link rel="stylesheet" href="<?php echo $this->_var['APP_ROOT']; ?>/admin/public/kindeditor/themes/default/default.css" />
<script type='text/javascript'  src='<?php echo $this->_var['APP_ROOT']; ?>/admin/public/kindeditor/kindeditor.js'></script>
<script type="text/javascript" src="<?php echo $this->_var['APP_ROOT']; ?>/admin/public/kindeditor/lang/zh_CN.js"></script>
 
<style> 
body{background:#f3f3f3;}
.pro_lf{padding:10px; width:350px;}
.hide {height:0;float:none}
.setlist{position:relative;}
.holder_tip{left:125px}
.faq_item1{position:relative;overflow:hidden;padding:4px;}
.faq_item1 .holder_tip{left:4px;top:4px;}
</style>
<div class="blank10"></div>
<div class="location_box wrap1000">
	<div class="location f_l">
		<i class="fl ico loc_ico mr5"></i>
		<label>您现在的位置：</label><a>发布产品项目</a><em>>></em><a>基本信息</a>
	</div>
</div>
<div class="blank"></div>
<!--中间开始-->
<div class="dlmain Myhomepage" style="margin-top:10px;">
	<div class="agreementhd"></div>
	<div class="agreementlf f_l">
		<form id="project_form" action="<?php
echo parse_url_tag("u:project#save|"."".""); 
?>" method="post">		
			<div class="pro_msg">项目信息</div>
			<div class="blank5"></div>
			<div class="setlist">
				<label class="setmid">项目标题</label>
				<input type="text" class="pro_lf textbox" name="name">
				<span class="holder_tip">名称不可超过40个字</span>
			</div>
			<div class="blank0"></div>
			<div class="setlist">
				<label class="setmid">筹资金额</label>
				<input type="text" class="pro_lf textbox" name="limit_price">&nbsp;&nbsp;
				<span class="setmid">元</span>
				<span class="holder_tip">不少于50</span>
			</div>
			<div class="blank0"></div>
			<div class="setlist">
				<label class="setmid">筹集天数</label>
				<input type="text" class="pro_lf textbox" name="deal_days">&nbsp;&nbsp;
				<span class="setmid">天</span>
				<span class="holder_tip">10~90</span>
			</div>
			<div class="blank0"></div>
			<div class="setlist">
				<label class="setmid">项目分类</label>
				<a class="btn_select f_l" id="cate_id_select">
					<span class="cur_select" id="cate_id_cur">项目分类：</span>
					<div class="select_arrow"></div>
					<select name="cate_id" class="select-h" id='cate_id'>
				    	<?php $_from = $this->_var['cate_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'cate_item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['cate_item']):
?>
				      		<option rel="<?php echo $this->_var['cate_item']['id']; ?>"><?php if ($this->_var['cate_item']['title_show']): ?>|--<?php endif; ?><?php echo $this->_var['cate_item']['name']; ?></br></option>
						<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				    </select>
					<input type="hidden" name="cate_id" id='cate_id_last' />
				</a>
			</div>
			<div class="blank0"></div>
			<div class="setlist">
				<label class="setmid">所在地区</label>		
				<a class="btn_select f_l mr10" id="cityid-1_select">
					<span class="cur_select" id="cityid-1_cur"></span>
					<div class="select_arrow"></div>
					<select name="province" class="select-h" id="cityid-1">				
						<option value="" rel="0">请选择省份</option>			
						<?php $_from = $this->_var['region_lv2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'region');if (count($_from)):
    foreach ($_from AS $this->_var['region']):
?>
							<option value="<?php echo $this->_var['region']['name']; ?>" rel="<?php echo $this->_var['region']['id']; ?>" <?php if ($this->_var['region']['selected']): ?>selected="selected"<?php endif; ?>><?php echo $this->_var['region']['name']; ?></option>
						<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					</select>
				</a>
				<a class="btn_select f_l mr10" id="cityid-2_select">
					<span class="cur_select" id="cityid-2_cur"></span>
					<div class="select_arrow"></div>
					<select name="city" class="select-h" id="cityid-2">				
						<option value="" rel="0">请选择城市</option>
						<?php $_from = $this->_var['region_lv3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'region');if (count($_from)):
    foreach ($_from AS $this->_var['region']):
?>
							<option value="<?php echo $this->_var['region']['name']; ?>" rel="<?php echo $this->_var['region']['id']; ?>" <?php if ($this->_var['region']['selected']): ?>selected="selected"<?php endif; ?>><?php echo $this->_var['region']['name']; ?></option>
						<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					</select>
				</a>
			</div>	
			<div class="blank0"></div>		
			<div class="setlist">
				<label class="setmid">项目封面</label>
				
				<label class="fileupload" onclick="upd_file(this,'image_file');" style="width:97px;">
					<input type="file" class="filebox" name="image_file" id="image_file"/  style="cursor:pointer;padding: 0;height: 39px;width: 97px;filter: alpha(opacity=0);-moz-opacity: 0;-khtml-opacity: 0;opacity: 0;">						
				</label>
				<span class="prompt" style="margin-top:3px;">支持jpg、jpeg、png、gif格式，大小不超过<?php echo $this->_var['max_size']; ?>M。【推荐尺寸640px*500px】</span>
			</div>
			<div class="setlist">
				<label class="setmid">项目视频</label>
				<input type="text" class="pro_lf textbox"  name="vedio">
				<span class="holder_tip">请输入项目视频地址</span>
			</div>			
			<div class="setlist">
				<label class="setmid">简要说明</label>
				<textarea name="brief" id="intro" class="textareabox textbox w350"></textarea>
				<span class="holder_tip">不超过75个字，简要描述一下你的项目</span>
			</div>
			<div class="setlist">
				<label class="setmid">项目详情</label>
				<div class="ke_form f_l">
					<?php 
$k = array (
  'name' => 'show_ke_form',
  'text_name' => 'descript',
  'width' => '470',
  'height' => '300',
  'ctn' => '',
);
echo $k['name']($k['text_name'],$k['width'],$k['height'],$k['ctn']);
?>		
				</div>
			</div>
			<div class="blank"></div>
			<div class="setlist" style="margin:10px 0; *margin:5px 0;">
				<label class="setmid" style="overflow:hidden">
				<span class="setmid se addqs" style="margin-top:0;">常见问题:</span><br /> 
				<a href="javascript:void(0);" id="add_faq" class="setmid se addqs" style="margin-top:20px;*margin-top:30px;">添加</a></label>		
				<div  id="faq_list" style="float:left; overflow:hidden; width:470px;">
					<?php echo $this->fetch('inc/deal_faq_item.html'); ?>					
				</div>
			</div>
			<div class="blank5"></div>
			<div class="f_l">
				<input type="hidden" name="image" value="<?php echo $this->_var['deal_image']['url']; ?>" />
				<input type="hidden" name="savenext" value="0" />
				<div class="saveone f_l" rel="gray" id="savenow"></div>
				<div class="nextstep f_l" rel="green" id="savenext"></div>
				<input type="hidden" value="1" name="ajax" />
				<input type="hidden" name="id" value="0" />
				<div class="blank15"></div>
			</div>
		</form>
	<div class="blank"></div>		
	</div>
	<div class="agreementrt f_r">
		<div class="deal_item_box agreementlist">
			<!--1-->			
			<div class="deal_content_box">
				<a href="#" title="<?php echo $this->_var['deal_item']['name']; ?>">
					<img id="image" src="<?php if ($this->_var['deal_image']['thumb_url'] == ''): ?><?php echo $this->_var['TMPL']; ?>/images/empty_thumb.gif<?php else: ?><?php echo $this->_var['deal_image']['thumb_url']; ?><?php endif; ?>" />
				</a>
				<div class="blank"></div>
				<a href="#" class="deal_title" id="deal_title">项目的名称</a>
				<div class="blank"></div>
			</div>
			<!--2-->
			<div class="paiduan" style="height:30px;padding:10px 12px 0 12px ;line-height: 20px;color: #A4A4A4;">
				<span class="caption-title">目标：
					<em>
						<span class="num"><font id="deal_days">0</font>天</span>
					</em> 
					<em>
						<i class="font-yen">¥</i>
						<span class="num" ><font id="price">0</font></span>
					</em>
				</span>
				<span class="f_r ">
					<span class="common-sprite">筹资中</span>
				</span>
			</div>
			<!--3-->
			<div class="deal_content_box" style="padding:0 12px 0 12px; ">             
				<div class="ui-progress">
					<span class="theme_bgcolor" style="width:100%;"></span>
	            </div>				
				<div class="blank"></div>
				<div class="div3" style="text-align:left;">
					<span class="num">100%</span>
					<div class="blank10"></div>
					<span class="til">已达</span>
				</div>
				<div class="div3">
					<span class="num"><font id="price">0</font>元</span>
					<div class="blank10"></div>
					<span class="til">已筹资</span>
				</div>
				<div class="div3" style="text-align:right;">
					<span class="num"><font id="deal_days">0</font>天</span>
					<div class="blank10"></div>
					<span class="til">剩余时间</span>				
				</div>
				<div class="blank"></div>
			</div>
		</div>
	</div>
	<div class="blank"></div>	
</div>
<!--中间结束-->
<div class="blank"></div>
<script type="text/javascript">
	$(function(){
		show_tip();
		// 项目分类
		funSelect("#cate_id_select","#cate_id_cur",'#cate_id_select option:selected');
	});
</script>
<?php echo $this->fetch('inc/footer.html'); ?> 


