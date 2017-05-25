<?php
// +----------------------------------------------------------------------
// | Fanwe 方维众筹商业系统
// +----------------------------------------------------------------------
// | Copyright (c) 2011 http://www.fanwe.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 云淡风轻(97139915@qq.com)
// +----------------------------------------------------------------------

//app项目用到的函数库

/**
 * 获取导航菜单
 */
function format_nav_list($nav_list)
{
		foreach($nav_list as $k=>$v)
		{
			if($v['url']!='')
			{
				if(substr($v['url'],0,7)!="http://")
				{		
					//开始分析url
					$nav_list[$k]['url'] = APP_ROOT."/".$v['url'];
				}
			}
		}
		return $nav_list;
}
function get_nav_list()
{
	return load_auto_cache("cache_nav_list");
}


function init_nav_list($nav_list)
{
 	$u_param = "";
	foreach($_GET as $k=>$v)
	{
		if(strtolower($k)!="ctl"&&strtolower($k)!="act")
		{
			$u_param.=$k."=".$v."&";
		}
	}
	if(substr($u_param,-1,1)=='&')
	$u_param = substr($u_param,0,-1);

	foreach($nav_list as $k=>$v)
	{			
		if($v['url']=='')
		{
				if($v['u_module']=="")$v['u_module']="index";
				if($v['u_action']=="")$v['u_action']="index";
				$route = $v['u_module'];
				if($v['u_action']!='')$route.="#".$v['u_action'];								
				$str = "u:".$route."|".$v['u_param'];					
				$nav_list[$k]['url'] =  parse_url_tag($str);		
				if(ACTION_NAME==$v['u_action']&&MODULE_NAME==$v['u_module']&&$v['u_param']==$u_param)
				{					
					$nav_list[$k]['current'] = 1;										
				}	
		}
	}	
	return $nav_list;
}


//获取所有子集的类
class ChildIds
{
	public function __construct($tb_name)
	{
		$this->tb_name = $tb_name;	
	}
	private $tb_name;
	private $childIds;
	private function _getChildIds($pid = '0', $pk_str='id' , $pid_str ='pid')
	{
		$childItem_arr = $GLOBALS['db']->getAll("select id from ".DB_PREFIX.$this->tb_name." where ".$pid_str."=".intval($pid));
		if($childItem_arr)
		{
			foreach($childItem_arr as $childItem)
			{
				$this->childIds[] = $childItem[$pk_str];
				$this->_getChildIds($childItem[$pk_str],$pk_str,$pid_str);
			}
		}
	}
	public function getChildIds($pid = '0', $pk_str='id' , $pid_str ='pid')
	{
		$this->childIds = array();
		$this->_getChildIds($pid,$pk_str,$pid_str);
		return $this->childIds;
	}
}


//获取相应规格的图片地址
//gen=0:保持比例缩放，不剪裁,如高为0，则保证宽度按比例缩放  gen=1：保证长宽，剪裁
function get_spec_image($img_path,$width=0,$height=0,$gen=0,$is_preview=true,$is_deleteable=true)
{
	if($width==0)
		$new_path = $img_path;
	else
	{
		$img_name = substr($img_path,0,-4);
		$img_ext = substr($img_path,-3);	
		if($is_deleteable){
			if($is_preview)
			$new_path = $img_name."_".$width."x".$height.".jpg";	
			else
			$new_path = $img_name."o_".$width."x".$height.".jpg";	
		}
		else
		{
			if($is_preview)
			$new_path = $img_name."".$width."".$height.".jpg";	
			else
			$new_path = $img_name."o".$width."".$height.".jpg";
		}
		
		

		
		if(!file_exists(APP_ROOT_PATH.$new_path))
		{
			require_once APP_ROOT_PATH."system/utils/es_imagecls.php";
			$imagec = new es_imagecls();
			$thumb = $imagec->thumb(APP_ROOT_PATH.$img_path,$width,$height,$gen,true,"",$is_preview,$is_deleteable);
			
			if(app_conf("PUBLIC_DOMAIN_ROOT")!='')
        	{
        		$paths = pathinfo($new_path);
        		$path = str_replace("./","",$paths['dirname']);
        		$filename = $paths['basename'];
        		$pathwithoupublic = str_replace("public/","",$path);
	        	$syn_url = app_conf("PUBLIC_DOMAIN_ROOT")."/es_file.php?username=".app_conf("IMAGE_USERNAME")."&password=".app_conf("IMAGE_PASSWORD")."&file=".get_domain().APP_ROOT."/".$path."/".$filename."&path=".$pathwithoupublic."/&name=".$filename."&act=0";
	        	@file_get_contents($syn_url);
        	}
			
		}
	}
	return $new_path;
}

function get_spec_gif_anmation($url,$width,$height)
{
	require_once APP_ROOT_PATH."system/utils/gif_encoder.php";
	require_once APP_ROOT_PATH."system/utils/gif_reader.php";
	require_once APP_ROOT_PATH."system/utils/es_imagecls.php";
	$gif = new GIFReader();
	$gif->load($url);
	$imagec = new es_imagecls();
	foreach($gif->IMGS['frames'] as $k=>$img)
	{
		$im = imagecreatefromstring($gif->getgif($k));		
		$im = $imagec->make_thumb($im,$img['FrameWidth'],$img['FrameHeight'],"gif",$width,$height,$gen=1);
		ob_start();
		imagegif($im);
		$content = ob_get_contents();
        ob_end_clean();
		$frames [ ] = $content;
   		$framed [ ] = $img['frameDelay'];
	}
		
	$gif_maker = new GIFEncoder (
	       $frames,
	       $framed,
	       0,
	       2,
	       0, 0, 0,
	       "bin"   //bin为二进制   url为地址
	  );
	return $gif_maker->GetAnimation ( );
}

//解析URL标签
// $str = u:acate#index|id=10&name=abc
function parse_url_tag($str)
{
	$key = md5("URL_TAG_".$str);
	if(isset($GLOBALS[$key]))
	{
		return $GLOBALS[$key];
	}
	
	$url = load_dynamic_cache($key);
	if($url!==false)
	{
		$GLOBALS[$key] = $url;
		return $url;
	}
	$str = substr($str,2);
	$str_array = explode("|",$str);
	$route = $str_array[0];
	$param_tmp = explode("&",$str_array[1]);
	$param = array();
	foreach($param_tmp as $item)
	{
		if($item!='')
		$item_arr = explode("=",$item);
		if($item_arr[0]&&$item_arr[1])
		$param[$item_arr[0]] = $item_arr[1];
	}
	$GLOBALS[$key]= url($route,$param);
	set_dynamic_cache($key,$GLOBALS[$key]);
	return $GLOBALS[$key];
}

function parse_url_tag_wap($str)
{
	$key = md5("URL_TAG_".$str);
	if(isset($GLOBALS[$key]))
	{
		return $GLOBALS[$key];
	}
	
	$url = load_dynamic_cache($key);
	if($url!==false)
	{
		$GLOBALS[$key] = $url;
		return $url;
	}
	$str = substr($str,2);
	$str_array = explode("|",$str);
	$route = $str_array[0];
	$param_tmp = explode("&",$str_array[1]);
	$param = array();
	foreach($param_tmp as $item)
	{
		if($item!='')
		$item_arr = explode("=",$item);
		if($item_arr[0]&&$item_arr[1])
		$param[$item_arr[0]] = $item_arr[1];
	}
	$GLOBALS[$key]= url_wap($route,$param);
	set_dynamic_cache($key,$GLOBALS[$key]);
	return $GLOBALS[$key];
}
//编译生成css文件
function parse_css($urls)
{
	
	$url = md5(implode(',',$urls));
	$css_url = 'public/runtime/statics/'.$url.'.css';
	$url_path = APP_ROOT_PATH.$css_url;
	if(!file_exists($url_path)||IS_DEBUG)
	{
		if(!file_exists(APP_ROOT_PATH.'public/runtime/statics/'))
		mkdir(APP_ROOT_PATH.'public/runtime/statics/',0777);
		$tmpl_path = $GLOBALS['tmpl']->_var['TMPL'];	
	
		$css_content = '';
		foreach($urls as $url)
		{
			$css_content .= @file_get_contents($url);
		}
		$css_content = preg_replace("/[\r\n]/",'',$css_content);
		$css_content = str_replace("../images/",$tmpl_path."/images/",$css_content);
//		@file_put_contents($url_path, unicode_encode($css_content));
		@file_put_contents($url_path, $css_content);
	}
	return get_domain().APP_ROOT."/".$css_url;
}

/**
 * 
 * @param $urls 载入的脚本
 * @param $encode_url 需加密的脚本
 */
function parse_script($urls,$encode_url=array())
{	
	$url = md5(implode(',',$urls));
	$js_url = 'public/runtime/statics/'.$url.'.js';
	$url_path = APP_ROOT_PATH.$js_url;
	if(!file_exists($url_path)||IS_DEBUG)
	{
		if(!file_exists(APP_ROOT_PATH.'public/runtime/statics/'))
		mkdir(APP_ROOT_PATH.'public/runtime/statics/',0777);
	
		if(count($encode_url)>0)
		{
			require_once APP_ROOT_PATH."system/libs/javascriptpacker.php";
		}
		
		$js_content = '';
		foreach($urls as $url)
		{
			$append_content = @file_get_contents($url)."\r\n";
			if(in_array($url,$encode_url))
			{
				$packer = new JavaScriptPacker($append_content);
				$append_content = $packer->pack();
			}			
			$js_content .= $append_content;
		}		
//		require_once APP_ROOT_PATH."system/libs/javascriptpacker.php";
//	    $packer = new JavaScriptPacker($js_content);
//		$js_content = $packer->pack();
		@file_put_contents($url_path,$js_content);
	}
	return get_domain().APP_ROOT."/".$js_url;
}


function load_page_png($img)
{
	return load_auto_cache("page_image",array("img"=>$img));
}



//显示错误
function showErr($msg,$ajax=0,$jump='',$stay=0)
{
	
	if($ajax==1)
	{
		$result['status'] = 0;
		$result['info'] = $msg;
		$result['jump'] = $jump;
		header("Content-Type:text/html; charset=utf-8");
        echo(json_encode($result));exit;
	}
	else
	{		
		$GLOBALS['tmpl']->assign('page_title',"错误");
		$GLOBALS['tmpl']->assign('msg',$msg);
		if($jump=='')
		{
			$jump = get_gopreview();
		}
		if(!$jump&&$jump=='')
		$jump = APP_ROOT."/";
		$GLOBALS['tmpl']->assign('jump',$jump);
		$GLOBALS['tmpl']->assign("stay",$stay);
		$GLOBALS['tmpl']->display("error.html");
		exit;
	}
}

//显示成功
function showSuccess($msg,$ajax=0,$jump='',$stay=0)
{
	
	if($ajax==1)
	{
		$result['status'] = 1;
		$result['info'] = $msg;
		$result['jump'] = $jump;
		header("Content-Type:text/html; charset=utf-8");
        echo(json_encode($result));exit;
	}
	else
	{

		$GLOBALS['tmpl']->assign('page_title',"成功");
		$GLOBALS['tmpl']->assign('msg',$msg);
		if($jump=='')
		{
			$jump = get_gopreview();
		}
		if(!$jump&&$jump=='')
		$jump = APP_ROOT."/";
		$GLOBALS['tmpl']->assign('jump',$jump);
		$GLOBALS['tmpl']->assign("stay",$stay);
		$GLOBALS['tmpl']->display("success.html");
		exit;
	}
}

function get_gopreview()
{
		$gopreview = es_session::get("gopreview");
		if($gopreview==get_current_url())
		{
			$gopreview = url("index");
		}
		if(!isset($gopreview)||$gopreview=="")
		{
			$gopreview = es_session::get('before_login')?es_session::get('before_login'):url("index");				
		}	
		return $gopreview;
}

function get_gopreview_wap()
{
		$gopreview = es_session::get("gopreview");
		if($gopreview==get_current_url())
		{
			$gopreview = url_wap("index");
		}
		if(!isset($gopreview)||$gopreview=="")
		{
			$gopreview = es_session::get('before_login')?es_session::get('before_login'):url_wap("index");				
		}	
		return $gopreview;
}
function get_current_url()
{
	$url  =  $_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'],'?')?'':"?");   
    $parse = parse_url($url);
    if(isset($parse['query'])) {
            parse_str($parse['query'],$params);
            $url   =  $parse['path'].'?'.http_build_query($params);
    }
    if(app_conf("URL_MODEL")==1)
    {	
    	$url = $GLOBALS['current_url'];
    	if(intval($_REQUEST['p'])>0)
    	{
    		$req = $_REQUEST;
    		unset($req['ctl']);
    		unset($req['act']);
    		unset($req['p']);
    		if(count($req)>0)
    		{
    			$url.="-p-".intval($_REQUEST['p']);
    		}
    		else
    		{
    			$url.="/p-".intval($_REQUEST['p']);
    		}
    	}
    }
    return $url;
}

function set_gopreview()
{
	$url =  get_current_url();
	es_session::set("gopreview",$url); 
}	
function app_redirect_preview()
{
	app_redirect(get_gopreview());
}	




function show_avatar($u_id,$type="middle")
{
	$key = md5("AVATAR_".$u_id.$type);
	if(isset($GLOBALS[$key]))
	{
		return $GLOBALS[$key];
	}
	else
	{
		$avatar_key = md5("USER_AVATAR_".$u_id); 
		$avatar_data = $GLOBALS['dynamic_avatar_cache'][$avatar_key];// 当前用户所有头像的动态缓存			
		if(!isset($avatar_data)||!isset($avatar_data[$key]))
		{
			$avatar_file = get_user_avatar($u_id,$type);	
			$avatar_str = "<a href='".url("home",array("id"=>$u_id))."' style='text-align:center; display:inline-block;'>".
				   "<img src='".$avatar_file."'  />".
				   "</a>"; 			
			$avatar_data[$key] = $avatar_str;
			if(count($GLOBALS['dynamic_avatar_cache'])<500) //保存500个用户头像缓存
			{
				$GLOBALS['dynamic_avatar_cache'][$avatar_key] = $avatar_data;
			}			
		}
		else
		{
			$avatar_str = $avatar_data[$key];
		}
		$GLOBALS[$key]= $avatar_str;
		return $GLOBALS[$key];
	}
}

function show_avatar_nurl($u_id,$type="middle")
{
    $key = md5("AVATAR_".$u_id.$type);
    if(isset($GLOBALS[$key]))
    {
        return $GLOBALS[$key];
    }
    else
    {
        $avatar_key = md5("USER_AVATAR_".$u_id);
        $avatar_data = $GLOBALS['dynamic_avatar_cache'][$avatar_key];// 当前用户所有头像的动态缓存
        if(!isset($avatar_data)||!isset($avatar_data[$key]))
        {
            $avatar_file = get_user_avatar($u_id,$type);
            $avatar_str = "<a href='#' style='text-align:center; display:inline-block;'>".
                "<img src='".$avatar_file."'  />".
                "</a>";
            $avatar_data[$key] = $avatar_str;
            if(count($GLOBALS['dynamic_avatar_cache'])<500) //保存500个用户头像缓存
            {
                $GLOBALS['dynamic_avatar_cache'][$avatar_key] = $avatar_data;
            }
        }
        else
        {
            $avatar_str = $avatar_data[$key];
        }
        $GLOBALS[$key]= $avatar_str;
        return $GLOBALS[$key];
    }
}

function show_wap_avatar($u_id,$type="middle")
{
	$key = md5("AVATAR_".$u_id.$type);
	if(isset($GLOBALS[$key]))
	{
		return $GLOBALS[$key];
	}
	else
	{
		$avatar_key = md5("USER_AVATAR_".$u_id);
		$avatar_data = $GLOBALS['dynamic_avatar_cache'][$avatar_key];// 当前用户所有头像的动态缓存
		if(!isset($avatar_data)||!isset($avatar_data[$key]))
		{
			$avatar_file = get_user_avatar($u_id,$type);
			$avatar_str = "<a href='".url_wap("settings",array("id"=>$u_id))."' style='text-align:center; display:inline-block;'>".
					"<img src='".$avatar_file."'  />".
					"</a>";
			$avatar_data[$key] = $avatar_str;
			if(count($GLOBALS['dynamic_avatar_cache'])<500) //保存500个用户头像缓存
			{
				$GLOBALS['dynamic_avatar_cache'][$avatar_key] = $avatar_data;
			}
		}
		else
		{
			$avatar_str = $avatar_data[$key];
		}
		$GLOBALS[$key]= $avatar_str;
		return $GLOBALS[$key];
	}
}

function show_empty_avatar($u_id,$type="middle")
{
	$key = md5("AVATAR_".$u_id.$type);
	if(isset($GLOBALS[$key]))
	{
		return $GLOBALS[$key];
	}
	else
	{
		$avatar_key = md5("USER_AVATAR_".$u_id);
		$avatar_data = $GLOBALS['dynamic_avatar_cache'][$avatar_key];// 当前用户所有头像的动态缓存
		if(!isset($avatar_data)||!isset($avatar_data[$key]))
		{
			$avatar_file = get_user_avatar($u_id,$type);
			$avatar_str ="<img src='".$avatar_file."'  />";
			$avatar_data[$key] = $avatar_str;
			if(count($GLOBALS['dynamic_avatar_cache'])<500) //保存500个用户头像缓存
			{
				$GLOBALS['dynamic_avatar_cache'][$avatar_key] = $avatar_data;
			}
		}
		else
		{
			$avatar_str = $avatar_data[$key];
		}
		$GLOBALS[$key]= $avatar_str;
		return $GLOBALS[$key];
	}
}

function update_avatar($u_id)
{
	$avatar_key = md5("USER_AVATAR_".$u_id); 
	unset($GLOBALS['dynamic_avatar_cache'][$avatar_key]);
	$GLOBALS['fcache']->set_dir(APP_ROOT_PATH."public/runtime/data/avatar_cache/");
	$GLOBALS['fcache']->set("AVATAR_DYNAMIC_CACHE",$GLOBALS['dynamic_avatar_cache']); //头像的动态缓存
}

//获取用户头像的文件名
function get_user_avatar($id,$type)
{
	$uid = sprintf("%09d", $id);
	$dir1 = substr($uid, 0, 3);
	$dir2 = substr($uid, 3, 2);
	$dir3 = substr($uid, 5, 2);
	$path = $dir1.'/'.$dir2.'/'.$dir3;
				
	$id = str_pad($id, 2, "0", STR_PAD_LEFT); 
	$id = substr($id,-2);
	$avatar_file = APP_ROOT."/public/avatar/".$path."/".$id."virtual_avatar_".$type.".jpg";
	$avatar_check_file = APP_ROOT_PATH."public/avatar/".$path."/".$id."virtual_avatar_".$type.".jpg";
	if(file_exists($avatar_check_file))	
	return $avatar_file;
	else
	return APP_ROOT."/public/avatar/noavatar_".$type.".gif";
	//@file_put_contents($avatar_check_file,@file_get_contents(APP_ROOT_PATH."public/avatar/noavatar_".$type.".gif"));
}

//获取手机端用户头像的文件名
function get_user_avatar_root($id,$type)
{
	$uid = sprintf("%09d", $id);
	$dir1 = substr($uid, 0, 3);
	$dir2 = substr($uid, 3, 2);
	$dir3 = substr($uid, 5, 2);
	$path = $dir1.'/'.$dir2.'/'.$dir3;
				
	$id = str_pad($id, 2, "0", STR_PAD_LEFT); 
	$id = substr($id,-2);
	$avatar_file = get_domain().REAL_APP_ROOT."/public/avatar/".$path."/".$id."virtual_avatar_".$type.".jpg";
	$avatar_check_file = APP_ROOT_PATH."/public/avatar/".$path."/".$id."virtual_avatar_".$type.".jpg";
 	if(file_exists($avatar_check_file))	
	return $avatar_file;
	else
	return get_domain().REAL_APP_ROOT."/public/avatar/noavatar_".$type.".gif";
	//@file_put_contents($avatar_check_file,@file_get_contents(REAL_APP_ROOT_PATH."public/avatar/noavatar_".$type.".gif"));
}

function show_ke_form($text_name,$width="300",$height="80",$cnt="")
{

	if($cnt=="")
	{
		$cnt = "<h3>关于我</h3>
<p>向支持者介绍一下你自己，以及你与所发起的项目之间的背景。这样有助于拉近你与支持者之间的距离。建议不超过100字。<br />
<br />
</p>
<h3>我想要做什么</h3>
<p>以图文并茂的方式简洁生动地说明你的项目，让大家一目了然，这会决定是否将你的项目描述继续看下去。建议不超过300字。<br />
<br />
</p>
<h3>为什么我需要你的支持</h3>
<p>这是加分项。说说你的项目不同寻常的特色、资金用途、以及大家支持你的理由。这会让更多人能够支持你，不超过200个汉字。<br />
<br />
</p>
<h3>我的承诺与回报</h3>
让大家感到你对待项目的认真程度，鞭策你将项目执行最终成功。同时向大家展示一下你为支持者准备的回报，来吸引更多人支持你。";
	}
//	$GLOBALS['tmpl']->assign("text_name",$text_name);
//	$GLOBALS['tmpl']->assign("width",$width);
//	$GLOBALS['tmpl']->assign("height",$height);
//	$GLOBALS['tmpl']->assign("box_id",$text_name);
//	$GLOBALS['tmpl']->assign("cnt",$cnt);
	return "<div  style='margin-bottom:5px; '><textarea id='".$text_name."' name='".$text_name."' class='ketext' style='width:".$width."px; height:".$height."px;' >".$cnt."</textarea> </div>";
  }
function show_ke_form_agency($text_name,$width="300",$height="80",$cnt="")
{

	if($cnt=="")
	{
		$cnt = "";
	}
//	$GLOBALS['tmpl']->assign("text_name",$text_name);
//	$GLOBALS['tmpl']->assign("width",$width);
//	$GLOBALS['tmpl']->assign("height",$height);
//	$GLOBALS['tmpl']->assign("box_id",$text_name);
//	$GLOBALS['tmpl']->assign("cnt",$cnt);
	return "<div  style='margin-bottom:5px; '><textarea id='".$text_name."' name='".$text_name."' class='ketext' style='width:".$width."px; height:".$height."px;' >".$cnt."</textarea> </div>";
  }
function show_ke_topic($id,$width=630,$height=350,$cnt="")
{	
	return "<script type='text/javascript'> var eid = '".$id."';KE.show({urlType:'domain', id:eid, items : ['fsource', 'fimage', 'justifyleft', 'justifycenter', 'justifyright','justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript','superscript', 'selectall', 'textcolor', 'bold','italic', 'underline', 'strikethrough', 'fullscreen','-','title', 'fontname', 'fontsize'], skinType: 'tinymce',allowFileManager : false,resizeMode : 0, newlineTag:'nl'});</script><div  style='margin-bottom:5px; '><textarea id='".$id."' name='".$id."' style='width:".$width."px; height:".$height."px;' >".$cnt."</textarea> </div>";
}

//过滤非法的html标签
function vaild_html($content)
{
	$content = preg_replace("/<(?!div|ol|ul|li|sup|sub|span|br|img|p|h1|h2|h3|h4|h5|h6)[^>]*>/i","",$content);
	return $content;
}

function replace_public($content)
{
	 $domain = app_conf("PUBLIC_DOMAIN_ROOT")==''?get_domain().APP_ROOT:app_conf("PUBLIC_DOMAIN_ROOT");
	 $domain_origin = get_domain().APP_ROOT;
	 $content = str_replace($domain."/public/","./public/",$content);	
	 $content = str_replace($domain_origin."/public/","./public/",$content);		 
	 return $content;
}


function log_deal_visit($deal_id)
{
	if(check_ipop_limit(get_client_ip(),"deal_show",600,$deal_id))
	{
		if($GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."deal_visit_log where deal_id = ".$deal_id." and client_ip = '".get_client_ip()."' and ".NOW_TIME." - create_time < 600")==0)
		{
			$view_data['deal_id'] = $deal_id;
			$view_data['client_ip'] = get_client_ip();
			$view_data['create_time'] = NOW_TIME;
			$GLOBALS['db']->autoExecute(DB_PREFIX."deal_visit_log",$view_data);
			$GLOBALS['db']->query("update ".DB_PREFIX."deal set view_count = view_count + 1 where id = ".$deal_id);
		}
	}
	
}

function number_price_format($price)
{
	if($price*100%100==0)
	$price= number_format(round($price,2));
	else
	$price = number_format(round($price,2),2);
	return $price;
}

//获取上线时间
function online_date($time,$online_time)
{
	if($time<$online_time)
	{
		return array("key"=>"online_0","info"=>"未上线");
	}
	else
	{
		$time_span = $time - $online_time;
		$day = ceil($time_span/(3600*24));
		return array("key"=>"online_".$day,"info"=>"上线第".$day."天");
	}
}

//获取已过时间
function pass_date($time)
{
		$time_span = NOW_TIME - $time;
		if($time_span>3600*24*365)
		{
			$time_span_lang = to_date($time,"Y-m-d");
		}
		elseif($time_span>3600*24*30)
		{
			$time_span_lang = to_date($time,"Y-m-d");
		}
		elseif($time_span>3600*24)
		{
			//一天
			$time_span_lang = round($time_span/(3600*24))."天前";
	
		}
		elseif($time_span>3600)
		{
			//一小时
			$time_span_lang = round($time_span/(3600))."小时前";
		}
	    elseif($time_span>60)
		{
			//一分
			$time_span_lang = round($time_span/(60))."分钟前";
			
		}
		else
		{
			//一秒
			$time_span_lang = "刚刚";
		}
		return $time_span_lang;
}

/*
 * 获得查询次数以及查询时间存入数据库中，方便用户查看
 */
function sql_check($type=''){
	if(!app_conf("SQL_CHECK"))return "";
	$base_name=basename($_SERVER['SCRIPT_FILENAME']);
	$check=array();
	if($base_name=='m.php'){
		return "";
	}
	$check['file_name']=$base_name;
	if($_REQUEST['from']=='wap'||$type=='wap'){
		$check['file_name']='wap.php';
	}
	
	
	$check['url']="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  	$module_name='ctl';
	$action_name='act';
	$module = strtolower(!empty($_REQUEST[$module_name])?$_REQUEST[$module_name]:"index");
	$check['module']=$module;
	$action = strtolower(!empty($_REQUEST[$action_name])?$_REQUEST[$action_name]:"index");
	$check['action']=$action;
	$check['module_action']=$module.'-'.$action;
	$check['module_action_para']=$module.'-'.$action;
 	//
	$request=array_filter($_REQUEST);
	foreach($request as $k=>$v){
		 
 		if($k==$module_name||$k==$action_name){
			unset($request[$k]);
			
		}
	}
  	asort($request);
	$pro=array_keys($request);
	if($pro){
		$check['para']=strtolower(implode("-",$pro));
		$check['module_action_para']=$module.'-'.$action.'-'.$check['para'];
	}
	//
	
 	$query_time = number_format($GLOBALS['db']->queryTime,6);
	$check['query_time']=$query_time;
	if($GLOBALS['begin_run_time']==''||$GLOBALS['begin_run_time']==0)
	{
		$run_time = 0;
	}
	else
	{
		if (PHP_VERSION >= '5.0.0')
		{
			$run_time = number_format(microtime(true) - $GLOBALS['begin_run_time'], 6);
		}
		else
		{
			list($now_usec, $now_sec)     = explode(' ', microtime());
			list($start_usec, $start_sec) = explode(' ', $GLOBALS['begin_run_time']);
			$run_time = number_format(($now_sec - $start_sec) + ($now_usec - $start_usec), 6);
		}
	}
	$check['run_time']=$run_time;
	/* 内存占用情况 */
	if (function_exists('memory_get_usage'))
	{
		$unit=array('B','KB','MB','GB');
		$size = memory_get_usage();
		$used = @round($size/pow(1024,($i=floor(log($size,1024)))),2);
		$memory_usage = $used;
	}
	else
	{
		$memory_usage = '';
	}
	$check['memory_usage']=$memory_usage;
	$enabled_gzip = (app_conf("GZIP_ON") && function_exists('ob_gzhandler'));
	$check['gzip_on']=$enabled_gzip;
	$check['sql_num']=count($GLOBALS['db']->queryLog);
	$sql_array=array();
	$old_num=$GLOBALS['db']->getOne("select sql_num from ".DB_PREFIX."sql_check where module_action_para='".$check['module_action_para']."' order by id desc ");
	
	foreach($GLOBALS['db']->queryLog as $K=>$sql)
	{
		$sql_array[]=$sql;
	}
	$check['sql_str']=serialize($sql_array);
	$check['create_time']=get_gmtime();
   	if($old_num!=$check['sql_num']||$old_num==0){
   		$GLOBALS['db']->autoExecute(DB_PREFIX."sql_check",$check,"INSERT","","SILENT");
 	}
 	
}

/**
 * 获得查询次数以及查询时间
 *
 * @access  public
 * @return  string
 */
function run_info()
{

	if(!SHOW_DEBUG)return "";

	$query_time = number_format($GLOBALS['db']->queryTime,6);

	if($GLOBALS['begin_run_time']==''||$GLOBALS['begin_run_time']==0)
	{
		$run_time = 0;
	}
	else
	{
		if (PHP_VERSION >= '5.0.0')
		{
			$run_time = number_format(microtime(true) - $GLOBALS['begin_run_time'], 6);
		}
		else
		{
			list($now_usec, $now_sec)     = explode(' ', microtime());
			list($start_usec, $start_sec) = explode(' ', $GLOBALS['begin_run_time']);
			$run_time = number_format(($now_sec - $start_sec) + ($now_usec - $start_usec), 6);
		}
	}

	/* 内存占用情况 */
	if (function_exists('memory_get_usage'))
	{
		$unit=array('B','KB','MB','GB');
		$size = memory_get_usage();
		$used = @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
		$memory_usage = "占用内存 ".$used;
	}
	else
	{
		$memory_usage = '';
	}

	/* 是否启用了 gzip */
	$enabled_gzip = (app_conf("GZIP_ON") && function_exists('ob_gzhandler'));
	$gzip_enabled = $enabled_gzip ? "gzip开启" : "gzip关闭";

	$str = '共执行 '.$GLOBALS['db']->queryCount.' 个查询，用时 '.$query_time.' 秒，'.$gzip_enabled.'，'.$memory_usage.'，程序执行时间 '.$run_time.' 秒';

	foreach($GLOBALS['db']->queryLog as $K=>$sql)
	{
		if($K==0)$str.="<br />SQL语句列表：";
		$str.="<br />行".($K+1).":".$sql;
	}

	return "<div style='width:940px; padding:10px; line-height:22px; border:1px solid #ccc; text-align:left; margin:30px auto; font-size:14px; color:#999; height:150px; overflow-y:auto;'>".$str."</div>";
}

function cache_log_comment($log)
{
	if($log['comment_data_cache']==""&&$log['id']>0)
	{
		$comment_data_cache = array();
		$log['comment_count'] = $comment_data_cache['comment_count'] = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."deal_comment where log_id = ".$log['id']);
		$log['comment_list'] = $comment_data_cache['comment_list'] = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_comment where log_id = ".$log['id']." order by create_time desc limit 3");
		if($log['comment_count']<=count($log['comment_list']))
		{
			$log['more_comment'] = $comment_data_cache['more_comment']  = false;
		}
		else
		{
			$log['more_comment'] = $comment_data_cache['more_comment']  = true;
		}
		$GLOBALS['db']->query("update ".DB_PREFIX."deal_log set comment_data_cache = '".serialize($comment_data_cache)."' where id = ".$log['id']);
	}
	else
	{
		$comment_data_cache = unserialize($log['comment_data_cache']);
		$log['comment_count'] = $comment_data_cache['comment_count'];
		$log['comment_list'] = $comment_data_cache['comment_list'];
		$log['more_comment'] = $comment_data_cache['more_comment'];
	}
	return $log;
}

function cache_log_deal($log)
{
	if($log['deal_info_cache']=="")
	{
		$deal_info_cache = array();
		$log['deal_info'] = $deal_info_cache['deal_info'] = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal where id = ".$log['deal_id']);
		if($log['deal_info'])
		{
			$log['deal_info']['remain_days']  = $deal_info_cache['deal_info']['remain_days'] = ceil(($log['deal_info']['end_time'] - NOW_TIME)/(24*3600));
			$log['deal_info']['percent']  = $deal_info_cache['deal_info']['percent'] = round($log['deal_info']['support_amount']/$log['deal_info']['limit_price']*100);			
		}
		$GLOBALS['db']->query("update ".DB_PREFIX."deal_log set deal_info_cache = '".serialize($deal_info_cache)."' where id = ".$log['id']);
	}
	else
	{
		$deal_info_cache = unserialize($log['deal_info_cache']);
		$log['deal_info'] = $deal_info_cache['deal_info'];
	}
	return $log;
	
}

//缓存项目信息
function cache_deal_extra($deal_info)
{
	if($deal_info['deal_extra_cache']=="")
	{
		$deal_extra_cache = array();
		$deal_info['deal_faq_list'] = $deal_extra_cache['deal_faq_list'] = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_faq where deal_id = ".$deal_info['id']." order by sort asc");		
		$deal_info['deal_item_list'] = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_item where deal_id = ".$deal_info['id']." order by price asc");
		foreach($deal_info['deal_item_list'] as $k=>$v)
		{
			$deal_info['deal_item_list'][$k]['images'] = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_item_image where deal_id=".$deal_info['id']." and deal_item_id = ".$v['id']);
			$deal_info['deal_item_list'][$k]['price_format'] = number_price_format($v['price']);				
		
		}
		$deal_extra_cache['deal_item_list'] = $deal_info['deal_item_list'];
		$GLOBALS['db']->query("update ".DB_PREFIX."deal set deal_extra_cache  = '".serialize($deal_extra_cache)."' where id = ".$deal_info['id']);
	}
	else
	{
		$deal_extra_cache = unserialize($deal_info['deal_extra_cache']);
		$deal_info['deal_faq_list'] = $deal_extra_cache['deal_faq_list'];
		$deal_info['deal_item_list'] = $deal_extra_cache['deal_item_list'];
	}
	return $deal_info;
}

function cache_deal_comment($comment)
{
	if($comment['deal_info_cache']=="")
	{
		$comment['deal_info']  = $deal_info_cache =  $GLOBALS['db']->getRow("select id,name from ".DB_PREFIX."deal where id = ".$comment['deal_id']);
		$GLOBALS['db']->query("update ".DB_PREFIX."deal_comment set deal_info_cache = '".serialize($deal_info_cache)."' where id = ".$comment['id']);
	}
	else
	{
		$comment['deal_info'] = unserialize($comment['deal_info_cache']);
	}
	return $comment;
}

function get_deal_list($limit="",$conditions="",$orderby=" sort asc ",$deal_type='deal'){
	
	
	if($limit!=""){
		$limit = " LIMIT ".$limit;
	}
	
	if($orderby!=""){
		$orderby = " ORDER BY ".$orderby;
	}
	
	if(app_conf("INVEST_STATUS")==0)
	{
		$condition = " 1=1 AND d.is_delete = 0 AND d.is_effect = 1 ";
	}
	elseif(app_conf("INVEST_STATUS")==1)
	{
		$condition = " 1=1 AND d.is_delete = 0 AND d.is_effect = 1 and d.type=0 ";
	}
	elseif(app_conf("INVEST_STATUS")==2)
	{
		$condition = " 1=1 AND d.is_delete = 0 AND d.is_effect = 1 and d.type=1 ";
	}
	
	if($conditions!=""){
		$condition.=" AND ".$conditions;
	}
	
	//权限浏览控制
//	if($GLOBALS['user_info']['user_level']!=0){
//		$level=$GLOBALS['db']->getOne("SELECT level from ".DB_PREFIX."user_level where id=".$GLOBALS['user_info']['user_level']);
//		$condition .=" AND (d.user_level ='' or d.user_level=0 or d.user_level <=$level)   ";
//	}
//	else{
//		$condition.=" AND (d.user_level =0 or d.user_level =1 or d.user_level ='')  ";
//	}
 	$deal_count = $GLOBALS['db']->getOne("select count(*)  from ".DB_PREFIX."deal as d  where ".$condition);
 
  	/*（所需项目）准备虚拟数据 start*/
	$deal_list = array();
	$level_list=$GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_level ");
	$level_list_array=array();
	foreach($level_list_array as $k=>$v){
		if($v['id']){
			$level_list_array[$v['id']]=$v['level'];
		}
	}
 	if($deal_count > 0){
		$now_time = NOW_TIME;
		$deal_list = $GLOBALS['db']->getAll("select d.* from ".DB_PREFIX."deal  as d   where ".$condition.$orderby.$limit);
		file_put_contents("condition.txt", print_r("select d.* from ".DB_PREFIX."deal  as d   where ".$condition.$orderby.$limit,1));
		$deal_ids = array();
		foreach($deal_list as $k=>$v)
		{
			$deal_list[$k]['remain_days'] = ceil(($v['end_time'] - $now_time)/(24*3600));
			if($v['begin_time'] > $now_time){
				$deal_list[$k]['left_days'] = intval(($now_time - $v['create_time']) / 24 / 3600);
			}
			$deal_list[$k]['num_days'] = ceil(($v['end_time'] - $v['begin_time'])/(24*3600));
			$deal_ids[] =  $v['id'];
			//查询出对应项目id的user_level
			$deal_list[$k]['deal_level']=$level_list_array[intval($deal_list[$k]['user_level'])];
			if($v['begin_time'] > $now_time){
				$deal_list[$k]['left_begin_days'] = intval(($v['begin_time']  - $now_time) / 24 / 3600);
			}
			if($v['begin_time'] > $now_time){
					$deal_list[$k]['status']= '0';                                 
			}
			elseif($v['end_time'] < $now_time && $v['end_time']>0){
				if($deal_list[$k]['percent'] >=100){
					$deal_list[$k]['status']= '1';  
				}
				else{
						$deal_list[$k]['status']= '2'; 
				}
			} 
			else{
					if ($v['end_time'] > 0) {
						$deal_list[$k]['status']= '3'; 
					}
					else
					$deal_list[$k]['status']= '4'; 
			}
			
			if($v['type']==1){
				$deal_list[$k]['virtual_person']=$deal_list[$k]['invote_num'];
				$deal_list[$k]['support_count'] =$deal_list[$k]['invote_num'];
				$deal_list[$k]['support_amount'] =$deal_list[$k]['invote_money'];
				$deal_list[$k]['percent'] = round(($deal_list[$k]['support_amount'])/$v['limit_price']*100);
				$deal_list[$k]['limit_price_w']=($deal_list[$k]['limit_price'])/10000;
				$deal_list[$k]['invote_mini_money_w']=round(($deal_list[$k]['invote_mini_money'])/10000);
			}else{
				$deal_list[$k]['virtual_person']=$deal_list[$k]['virtual_num'];
				$deal_list[$k]['support_count'] =$deal_list[$k]['virtual_num']+$deal_list[$k]['support_count'];
				$deal_list[$k]['support_amount'] =$deal_list[$k]['virtual_price']+$deal_list[$k]['support_amount'];
				$deal_list[$k]['percent'] = round(($deal_list[$k]['support_amount'])/$v['limit_price']*100);
 			}
 			if($deal_type=='deal_cate'||$deal_type=='deal_cate_preheat'){
 				$deal_list[$k]['user_info']=$GLOBALS['db']->getRowCached("select * from  ".DB_PREFIX."user where id=".$v['user_id']);
				$deal_list[$k]['deal_comment_num']=$GLOBALS['db']->getOneCached("select count(*) from ".DB_PREFIX."deal_comment where deal_id = ".$v['id']." and log_id = 0 and status=1 ");
				$deal_list[$k]['deal_comment_num']=intval($deal_list[$k]['deal_comment_num']);
				$deal_list[$k]['cate_name']=$GLOBALS['db']->getOneCached("select name from ".DB_PREFIX."deal_cate where id=".$v['cate_id']);
  				if($deal_type=='deal_cate_preheat'){
  					//关注
  					$deal_list[$k]['focus_num']=$GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."deal_comment where deal_id = ".$v['id']." and log_id = 0 and status=1 ");
   				}
  			}
		}
 	 
	}
	
	
	return array("rs_count"=>$deal_count,"list"=>$deal_list);
}

//最新动态
function deal_log_list($limit="",$condition="",$orderby="d.create_time desc"){
	$log_list = $GLOBALS['db']->getAll("select l.*,d.name as deal_name from ".DB_PREFIX."deal_log as l left join ".DB_PREFIX."deal as d on d.id=l.deal_id where $condition order by $orderby limit ".$limit);
	$full_list=array();
	foreach($log_list as $k=>$v){
		if(!empty($v['id'])){
			$v['left_time']=pass_date($v['create_time']);
			$log_list[$k]['left_time']=$v['left_time'];
			if($k<=1){
	 			$deal=get_deal_list("0,1","d.id=".$v['deal_id']);
				$v['deal_info']=$deal['list'][0];
				$full_list[]=$v;
				unset($log_list[$k]);
			}
		}
			
	}
	return array("right_list"=>$log_list,"left_list"=>$full_list);
}
//项目成功发送短信、回报短信(所有成功项目的支持人、项目创立者）
function send_deal_success_1(){
	if(app_conf("SMS_ON")==0){
		return false;
	}
	//项目成功发起者短信
	$deal_s_user=$GLOBALS['db']->getAll("select d.*,u.mobile from ".DB_PREFIX."deal d LEFT JOIN ".DB_PREFIX."user u ON u.id = d.user_id where d.is_success=1 and d.is_has_send_success=0 and d.is_delete = 0 ");
	
	$tmpl3=$GLOBALS['db']->getRowCached("select * from ".DB_PREFIX."msg_template where name='TPL_SMS_USER_S'");
	$tmpl_content3 = $tmpl3['content'];
	
	foreach ($deal_s_user as $k=>$v){
		if($v['id']&&$v['mobile']){
			$user_s_msg['user_name']=$v['user_name'];
			$user_s_msg['deal_name']=$v['name'];
		
			$GLOBALS['tmpl']->assign("user_s_msg",$user_s_msg);
			$msg3=$GLOBALS['tmpl']->fetch("str:".$tmpl_content3);
			$msg_data3['dest']=$v['mobile'];
			$msg_data3['send_type']=0;
			$msg_data3['content']=addslashes($msg3);
			$msg_data3['send_time']=0;
			$msg_data3['title']='项目'.$v['name'].'众筹成功-项目ID-'.$v['id'];;
			$msg_data3['is_send']=0;
			$msg_data3['create_time'] = NOW_TIME;
			$msg_data3['user_id'] = $v['user_id'];
			$msg_data3['is_html'] = $tmpl3['is_html'];
			$GLOBALS['db']->query("UPDATE ".DB_PREFIX."deal SET is_has_send_success=1 WHERE id = ".$v['id']);
	 		if($GLOBALS['db']->affected_rows()){
	 			$re=$GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data3); //插入
	 		}
  		}
	}
	
	$success_deal_user=$GLOBALS['db']->getAll("SELECT dlo.* FROM ".DB_PREFIX."deal_order dlo LEFT JOIN ".DB_PREFIX."deal d ON d.id= dlo.deal_id WHERE d.is_success=1 and d.is_has_send_success=1 and d.is_delete = 0 AND dlo.order_status=3 AND dlo.is_success=1 AND dlo.is_has_send_success=0 ");
	
	if($success_deal_user){
		//项目成功支持者
		$tmpl=$GLOBALS['db']->getRowCached("select * from ".DB_PREFIX."msg_template where name='TPL_SMS_DEAL_SUCCESS'");
		$tmpl_content = $tmpl['content'];
		
		foreach ($success_deal_user as $k=>$v){
			if($v['id']&&$v['mobile']){
				$success_user_info['user_name'] = $v['user_name'];
				$success_user_info['deal_name'] = $v['deal_name'];
				//封装发送到前台($success_user_info前台取)
				$GLOBALS['tmpl']->assign("success_user_info",$success_user_info);
				$msg=$GLOBALS['tmpl']->fetch("str:".$tmpl_content);
				$msg_data['dest']=$v['mobile'];
				$msg_data['send_type']=0;
				$msg_data['content']=addslashes($msg);
				$msg_data['send_time']=0;
				$msg_data['is_send']=0;
				$msg_data['title']='项目'.$v['deal_name'].'支持成功--订单号'.$v['id'];;
				$msg_data['create_time'] = NOW_TIME;
				$msg_data['user_id'] = $v['user_id'];
				$msg_data['is_html'] = $tmpl['is_html'];
				$GLOBALS['db']->query("UPDATE ".DB_PREFIX."deal_order SET is_has_send_success=1 WHERE id = ".$v['id']);
				if($GLOBALS['db']->affected_rows()){
					$GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data); //插入
				}
			}
		}
	}
	
}
//项目失败发送短信(支持人、项目发起人)
function send_deal_fail_1(){
	if(app_conf("SMS_ON")==0){
		return false;
	}
	//项目失败发起者短信
	$deal_f_user=$GLOBALS['db']->getAll("select d.*,u.mobile,u.user_name  from ".DB_PREFIX."deal d LEFT JOIN ".DB_PREFIX."user u ON u.id = d.user_id where d.is_success=0 and d.is_has_send_success=0 and d.is_delete = 0 and d.support_amount < (d.limit_price-(select sum(virtual_person*price) FROM ".DB_PREFIX."deal_item where deal_id=d.id )) and d.end_time < ".NOW_TIME." and d.end_time!=0");
 	
	$tmpl2=$GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name='TPL_SMS_USER_F'");
	$tmpl_content2 = $tmpl2['content'];
	foreach ($deal_f_user as $k=>$v){
		if($v['id']&&$v['mobile']){
			$user_f_msg['user_name']=$v['user_name'];
			$user_f_msg['deal_name']=$v['name'];
			$GLOBALS['tmpl']->assign("user_f_msg",$user_f_msg);
			$msg2=$GLOBALS['tmpl']->fetch("str:".$tmpl_content2);
			$msg_data2['dest']=$v['mobile'];
			$msg_data2['send_type']=0;
			$msg_data2['content']=addslashes($msg2);
			$msg_data2['send_time']=0;
			$msg_data2['is_send']=0;
			$msg_data2['create_time'] = get_gmtime();
			$msg_data2['user_id'] = $v['user_id'];
			$msg_data2['is_html'] = $tmpl2['is_html'];
			$msg_data2['title']='项目'.$v['name'].'众筹失败-项目ID-'.$v['id'];
			$GLOBALS['db']->query("UPDATE ".DB_PREFIX."deal SET is_has_send_success=1 WHERE id = ".$v['id']);
 			if($GLOBALS['db']->affected_rows()){
				 $GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data2); //插入
 			}
		}
 	}
	
	//支持人
	$tmpl=$GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name='TPL_SMS_DEAL_FAIL'");
	$tmpl_content = $tmpl['content'];
	$fail_deal_user = $GLOBALS['db']->getAll("SELECT dlo.* FROM ".DB_PREFIX."deal_order dlo LEFT JOIN ".DB_PREFIX."deal d ON d.id= dlo.deal_id WHERE d.is_success=0 and d.is_has_send_success=1 and d.is_delete = 0 and d.support_amount < (d.limit_price-(select sum(virtual_person*price) FROM ".DB_PREFIX."deal_item where deal_id=d.id )) and d.end_time < ".NOW_TIME." AND dlo.order_status='3' AND dlo.is_success='1' AND dlo.is_has_send_success=0 ");
	foreach ($fail_deal_user as $k=>$v){
		if($v['id']&&$v['mobile']){
			$fail_user_info['user_name']=$v['user_name'];
			$fail_user_info['deal_name']=$v['deal_name'];
			$GLOBALS['tmpl']->assign('fail_user_info',$fail_user_info);
			$msg=$GLOBALS['tmpl']->fetch("str:".$tmpl_content);
			$msg_data['dest']=$v['mobile'];
			$msg_data['send_type']=0;
			$msg_data['content']=addslashes($msg);
			$msg_data['send_time']=0;
			$msg_data['is_send']=0;
			$msg_data['title']='项目'.$v['deal_name'].'支持失败-订单号'.$v['id'];
			$msg_data['create_time'] = get_gmtime();
			$msg_data['user_id'] = $v['user_id'];
			$msg_data['is_html'] = $tmpl['is_html'];
 			$GLOBALS['db']->query("UPDATE ".DB_PREFIX."deal_order SET is_has_send_success=1 WHERE id = ".$v['id']);
			if($GLOBALS['db']->affected_rows()){
				$GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data); //插入
			}
		}
	}
	
}
//跟投、领投信息列表
function get_investor_info($deal_id,$type=''){
	if(!$GLOBALS['user_info'])
	{
		//app_redirect(url("user#login"));
	}
 	if($deal_id>0){
		if($type==1){
			//分页
			require APP_ROOT_PATH.'app/Lib/page.php';
			$page_size = 10;
			$page = intval($_REQUEST['p']);
			if($page==0)$page = 1;
			$limit = (($page-1)*$page_size).",".$page_size;
			//跟投信息(所有)
			$enquiry_info_list=$GLOBALS['db']->getAll("select i.*,u.user_name from ".DB_PREFIX."investment_list i LEFT JOIN ".DB_PREFIX."user as u on u.id=i.user_id where i.deal_id=".$deal_id." and i.type=2    ORDER BY i.create_time DESC limit $limit");
			foreach ($enquiry_info_list as $k=>$v){
				$enquiry_info_list[$k]['money']=number_format(($v['money']/10000),2);
			}
			//跟投信息(统计)
			$enquiry_count=$GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."investment_list i where i.deal_id=".$deal_id." and i.type=2");
			$page = new Page($enquiry_count,$page_size);   //初始化分页对象
			$p  =  $page->show();
			$GLOBALS['tmpl']->assign('pages',$p);
			$GLOBALS['tmpl']->assign("enquiry_count",$enquiry_count);
			$GLOBALS['tmpl']->assign("enquiry_info_all",$enquiry_info_list);
		}else{
			//跟投信息(4条)
			$enquiry_info=$GLOBALS['db']->getAll("select i.*,u.user_name from ".DB_PREFIX."investment_list i LEFT JOIN ".DB_PREFIX."user as u on u.id=i.user_id where i.deal_id=".$deal_id." and i.type=2   ORDER BY i.create_time DESC LIMIT 0,4");
			foreach ($enquiry_info as $k=>$v){
				$enquiry_info[$k]['money']=number_format(($v['money']/10000),2); 
			}
			$GLOBALS['tmpl']->assign("enquiry_info",$enquiry_info);
		}
		$GLOBALS['tmpl']->assign('type',intval($type));
		//领投信息
		$leader_info=$GLOBALS['db']->getRow("select i.*,u.user_name,u.identify_name from ".DB_PREFIX."investment_list i LEFT JOIN ".DB_PREFIX."user as u on u.id=i.user_id where i.deal_id=".$deal_id." and i.type=1 and status=1 GROUP BY i.user_id,i.user_id ORDER BY i.user_id DESC");
		if($leader_info>0){
			
			if($leader_info['leader_moban']){
				$leader_info['leader_info_name']=substr(strrchr(unserialize($leader_info['leader_moban']), '.'), 1);
			 	switch($leader_info['leader_info_name']){
			 		case 'txt':
			 		$leader_info['leader_info_exe']='leader_t';
			 		break;
			 		case 'doc':
			 		$leader_info['leader_info_exe']='leader_w';
			 		break;
			 		case 'docx':
			 		$leader_info['leader_info_exe']='leader_w';
			 		break;
			 		case 'rar':
			 		$leader_info['leader_info_exe']='leader_r';
			 		break;
			 		case 'zip':
			 		$leader_info['leader_info_exe']='leader_r';
			 		break;
			 		
			 		case 'xls':
			 		$leader_info['leader_info_exe']='leader_x';
			 		break;
			 		case 'xlsx':
			 		$leader_info['leader_info_exe']='leader_x';
			 		break;
			 		case 'ppt':
			 		$leader_info['leader_info_exe']='leader_p';
			 		break;
			 	}
			}
			$leader_info['money']=number_format(($leader_info['money']/10000),2);
			$GLOBALS['tmpl']->assign("leader_info",$leader_info);
		}	
	}
}

//得到用户自己所有（有效）的项目列表信息
function get_effective_deal_info($id){
	if($id>0){
		$condition="user_id=".$id." AND is_effect=1 AND is_delete=0 AND begin_time<".NOW_TIME." AND ".NOW_TIME."<end_time ORDER BY id DESC";
		$effective_deal_info=$GLOBALS['db']->getAll("SELECT * FROM ".DB_PREFIX."deal where ".$condition);
		return $effective_deal_info;
	}
}
?>