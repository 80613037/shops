<?php
// +----------------------------------------------------------------------
// | EaseTHINK 易想团购系统 mapi 插件
// +----------------------------------------------------------------------
// | Copyright (c) 2010 http://www.fanwe.com All rights reserved.
// +----------------------------------------------------------------------

//define('APP_ROOT','zhongc');
require '../system/common.php';
require '../system/utils/transport.php';
require './common.php';
require './functions.php';
require '../system/utils/weixin.php';
define("DEAL_PAGE_SIZE",60);
define("DEAL_STEP_SIZE",12);

define("DEALUPDATE_PAGE_SIZE",15);
define("DEALUPDATE_STEP_SIZE",5);

define("DEAL_COMMENT_PAGE_SIZE",40);

define("DEAL_SUPPORT_PAGE_SIZE",20);

define("ACCOUNT_PAGE_SIZE",10);
$transport = new transport;
$transport->use_curl = true;
$GLOBALS['tmpl']->assign("APP_ROOT",APP_ROOT);
$GLOBALS['tmpl']->assign("APP_URL",get_domain().APP_ROOT."/wap");
$GLOBALS['tmpl']->assign("PC_URL",get_domain().APP_ROOT);

define('REAL_APP_ROOT',str_replace('/wap',"",APP_ROOT));
define('REAL_APP_ROOT_PATH',str_replace('/wap',"",APP_ROOT));

//======
filter_injection($_REQUEST);

if(!file_exists(APP_ROOT_PATH.'public/runtime/wap/'))
{
	mkdir(APP_ROOT_PATH.'public/runtime/wap/',0777);
}
if(!file_exists(APP_ROOT_PATH.'public/runtime/wap/tpl_caches/'))
	mkdir(APP_ROOT_PATH.'public/runtime/wap/tpl_caches/',0777);
if(!file_exists(APP_ROOT_PATH.'public/runtime/wap/tpl_compiled/'))
	mkdir(APP_ROOT_PATH.'public/runtime/wap/tpl_compiled/',0777);
$GLOBALS['tmpl']->cache_dir      = APP_ROOT_PATH . 'public/runtime/wap/tpl_caches';
$GLOBALS['tmpl']->compile_dir    = APP_ROOT_PATH . 'public/runtime/wap/tpl_compiled';
$GLOBALS['tmpl']->template_dir   = APP_ROOT_PATH . 'wap/tpl/default';

//定义模板路径
$tmpl_path = get_domain().APP_ROOT."/wap/tpl/";
$GLOBALS['tmpl']->assign("TMPL",$tmpl_path."default");
$GLOBALS['tmpl']->assign("APP_ROOT_URL",get_domain().APP_ROOT);
$GLOBALS['tmpl']->assign("ROOT_URL",get_domain());

$GLOBALS['tmpl']->assign("TMPL_REAL",APP_ROOT_PATH."wap/tpl/default");
//用户信息
$user_info = es_session::get('user_info');
if($module!="ajax")
{
	if($user_info)
	{
		$user_info = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."user where id = ".intval($GLOBALS['user_info']['id'])." and is_effect = 1");
		es_session::set('user_info',$user_info);
		//查询登入用户所对应的user_level
		$user_level=$GLOBALS['db']->getAll("select level from ".DB_PREFIX."user_level where id=".intval($GLOBALS['user_info']['user_level']));
		//给前台会员的level值
		$GLOBALS['tmpl']->assign("user_level",$user_level);
		$GLOBALS['tmpl']->assign("user_info",$user_info);
	}


	//输出SEO元素
	//$GLOBALS['tmpl']->assign("site_name",app_conf("SITE_NAME"));
	$GLOBALS['tmpl']->assign("seo_title",app_conf("SEO_TITLE"));
	$GLOBALS['tmpl']->assign("seo_keyword",app_conf("SEO_KEYWORD"));
	$GLOBALS['tmpl']->assign("seo_description",app_conf("SEO_DESCRIPTION"));

	$helps = load_auto_cache("helps");
	$GLOBALS['tmpl']->assign("helps",$helps);

	//删除超过三天的订单
	$GLOBALS['db']->query("delete from ".DB_PREFIX."deal_order where order_status = 0 and credit_pay = 0 and  ".NOW_TIME." - create_time > ".(24*3600*3));


	$has_deal_notify = intval($GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."deal_notify"));
	define("HAS_DEAL_NOTIFY",$has_deal_notify); //存在待发的项目通知

}
//
define('MAPI_DATA_CACHE_DIR',APP_ROOT_PATH.'public/runtime/mapi/data_caches');
$m_config = getMConfig();//初始化手机端配置
$GLOBALS['tmpl']->assign('m_config',$m_config);
$GLOBALS['tmpl']->assign('now_time',NOW_TIME);
define('VERSION',1); //接口版本号,float 类型
define("CACHE_TIME",60); //动态数据缓存时间，300秒
if (intval($m_config['page_size']) == 0){
	define('PAGE_SIZE',20); //分页的常量
}else{
	define('PAGE_SIZE',intval($m_config['page_size'])); //分页的常量
}


$GLOBALS['tmpl']->assign("site_name",$m_config['program_title']?$m_config['program_title']:app_conf("SITE_NAME"));
$GLOBALS['tmpl']->assign("site_logo",$m_config['logo']?$m_config['logo']:app_conf("SITE_LOGO"));

$class = strtolower(strim($_REQUEST['ctl']))?strtolower(strim($_REQUEST['ctl'])):"index";

$act2 = strtolower(strim($_REQUEST['act']))?strtolower(strim($_REQUEST['act'])):"index";
$city_id = intval($request['city_id']);
define('ACT',$class); //act常量
define('ACT_2',$act2);

$GLOBALS['tmpl']->assign("class",$class);
$GLOBALS['tmpl']->assign("act",$act2);
get_pre_wap();
$cate_list = load_dynamic_cache("INDEX_CATE_LIST");

if(!$cate_list)
{
	$cate_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_cate order by sort asc");
	set_dynamic_cache("INDEX_CATE_LIST",$cate_list);
}
$is_weixin=isWeixin();
$GLOBALS['tmpl']->assign("is_weixin",$is_weixin);

$GLOBALS['tmpl']->assign("cate_list",$cate_list);
 if($_REQUEST['code']&&$_REQUEST['state']==1&&$m_config['wx_appid']&&$m_config['wx_secrit']&&!$user_info){
	//file_put_contents('./t.txt',var_export($_REQUEST,TRUE)."\n",FILE_APPEND);
	//require '../system/utils/weixin.php';
	$weixin=new weixin($m_config['wx_appid'],$m_config['wx_secrit'],get_domain().APP_ROOT."/wap");
	$wx_info=$weixin->scope_get_userinfo($_REQUEST['code']);

  	if($wx_info['openid']){
		$wx_user_info=get_user_has('wx_openid',$wx_info['openid']);
  		if($wx_user_info){
 			require_once APP_ROOT_PATH."system/libs/user.php";
			//如果会员存在，直接登录

			do_login_user($wx_user_info['mobile'],$wx_user_info['user_pwd']);
 		}else{
			//会员不存在进入登录流程
			$class='user';
			$act2='wx_register';
 		}
	}
}else{
	if($is_weixin&&!$user_info&&$m_config['wx_appid']&&$m_config['wx_secrit']&&$class!='ajax'&&$class!='user'){
		$weixin_2=new weixin($m_config['wx_appid'],$m_config['wx_secrit'],get_domain().$_SERVER["REQUEST_URI"]);
		$wx_url=$weixin_2->scope_get_code();
		app_redirect($wx_url);
	}
}
if($m_config['wx_appid']&&$m_config['wx_secrit']){
	require_once APP_ROOT_PATH."system/utils/jssdk.php";
	$jssdk = new JSSDK($m_config['wx_appid'],$m_config['wx_secrit']);
	$signPackage = $jssdk->GetSignPackage();
	$GLOBALS['tmpl']->assign("signPackage",$signPackage);

	$weixin_1=new weixin($m_config['wx_appid'],$m_config['wx_secrit'],get_domain().$_SERVER["REQUEST_URI"]);
	//$weixin_1->redirect_url=get_domain().$_SERVER["REQUEST_URI"];
	$wx_url=$weixin_1->scope_get_code();
  	$GLOBALS['tmpl']->assign("wx_url",$wx_url);
}
file_put_contents('zcindex_php.log',$class.'--'.$act2);
//if(!empty($_GET['code'])&&$_GET['state']=='STATE'&&$_GET['id']>0){
//	 $class='cart';
//	 $act2='wx_jspay';
// }
  //公共初始化
if(file_exists("./lib/".$class.".action.php"))
{
	require_once "./lib/".$class.".action.php";
	//if($class=='index'){
		$class=$class.'Module';
	//}
    file_put_contents('zcindex_php.log',$class.'--'.$act2);
 	if(class_exists($class))
	{
 		$obj = new $class;

		if(method_exists($obj,$act2))
		{
			$obj->$act2();
		}
		else
		{
			header("Content-Type:text/html; charset=utf-8");
			exit("Hack attemp!");
		}
	}
	else
	{
		header("Content-Type:text/html; charset=utf-8");
		exit("Hack attemp!");
	}
}
else
{
	header("Content-Type:text/html; charset=utf-8");
	exit("Hack attemp!".ACT);
}

?>