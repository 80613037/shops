<?php $fd93bb7bba3arr=array("localhost","192.168.1.166","192.168.1.166","192.168.1.166","192.168.1.166");$fd93bb7bba3host=$_SERVER["HTTP_HOST"];$fd93bb7bba3host=explode(":",$fd93bb7bba3host);$fd93bb7bba3host=$fd93bb7bba3host[0];$fd93bb7bba3bln=false;foreach($fd93bb7bba3arr as $fd93bb7bba3val){if(substr($fd93bb7bba3val,0,2)==="*."){if(preg_match("/".preg_quote(substr($fd93bb7bba3val,2))."$/",$fd93bb7bba3host)>0){$fd93bb7bba3bln=true;break;}}}if(!$fd93bb7bba3bln&&!in_array($fd93bb7bba3host,$fd93bb7bba3arr)){echo "domain not authorized";exit;}if (PHP_VERSION >= '5.0.0')
{
    $begin_run_time = @microtime(true);
}
else
{
    $begin_run_time = @microtime();
}
@set_magic_quotes_runtime (0);
define('MAGIC_QUOTES_GPC',get_magic_quotes_gpc()?True:False);
if(!defined('IS_CGI'))
define('IS_CGI',substr(PHP_SAPI, 0,3)=='cgi' ? 1 : 0 );
 if(!defined('_PHP_FILE_')) {
        if(IS_CGI) {
            //CGI/FASTCGI模式下
            $_temp  = explode('.php',$_SERVER["PHP_SELF"]);
            define('_PHP_FILE_',  rtrim(str_replace($_SERVER["HTTP_HOST"],'',$_temp[0].'.php'),'/'));
        }else {
            define('_PHP_FILE_',  rtrim($_SERVER["SCRIPT_NAME"],'/'));
        }
    }
if(!defined('APP_ROOT')) {
        // 网站URL根目录
        $_root = dirname(_PHP_FILE_);
        $_root = (($_root=='/' || $_root=='\\')?'':$_root);
        $_root = str_replace("/system","",$_root);
        $_root = str_replace("/wap","",$_root);
        define('APP_ROOT', $_root  );
}

define("MAX_DYNAMIC_CACHE_SIZE",1000);  //动态缓存最数量

//定义$_SERVER['REQUEST_URI']兼容性
if (!isset($_SERVER['REQUEST_URI']))
{
        if (isset($_SERVER['argv']))
        {
            $uri = $_SERVER['PHP_SELF'] .'?'. $_SERVER['argv'][0];
        }
        else
        {
            $uri = $_SERVER['PHP_SELF'] .'?'. $_SERVER['QUERY_STRING'];
        }
        $_SERVER['REQUEST_URI'] = $uri;
}
filter_request($_GET);
filter_request($_POST);

//关于安装的检测
if(!file_exists(APP_ROOT_PATH."public/install.lock"))
{
    app_redirect(APP_ROOT."/install/index.php");
}

//引入数据库的系统配置及定义配置函数
update_sys_config();
$sys_config = require APP_ROOT_PATH.'system/config.php';
function app_conf($name)
{
    return stripslashes($GLOBALS['sys_config'][$name]);
}
if(IS_DEBUG)
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
else
error_reporting(0);

//end 引入数据库的系统配置及定义配置函数

require APP_ROOT_PATH.'system/utils/es_cookie.php';
require APP_ROOT_PATH.'system/utils/es_session.php';
es_session::start();

function get_http()
{
    return (isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) != 'off')) ? 'https://' : 'http://';
}
function get_domain()
{
    /* 协议 */
    $protocol = get_http();
    
    if(app_conf("SITE_DOMAIN")!="")
    {
         return $protocol.app_conf("SITE_DOMAIN");
    }

    /* 域名或IP地址 */
    if (isset($_SERVER['HTTP_X_FORWARDED_HOST']))
    {
        $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
    }
    elseif (isset($_SERVER['HTTP_HOST']))
    {
        $host = $_SERVER['HTTP_HOST'];
    }
    else
    {
        /* 端口 */
        if (isset($_SERVER['SERVER_PORT']))
        {
            $port = ':' . $_SERVER['SERVER_PORT'];

            if ((':80' == $port && 'http://' == $protocol) || (':443' == $port && 'https://' == $protocol))
            {
                $port = '';
            }
        }
        else
        {
            $port = '';
        }

        if (isset($_SERVER['SERVER_NAME']))
        {
            $host = $_SERVER['SERVER_NAME'] . $port;
        }
        elseif (isset($_SERVER['SERVER_ADDR']))
        {
            $host = $_SERVER['SERVER_ADDR'] . $port;
        }
    }

    return $protocol . $host;
}
function get_host()
{


    /* 域名或IP地址 */
    if (isset($_SERVER['HTTP_X_FORWARDED_HOST']))
    {
        $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
    }
    elseif (isset($_SERVER['HTTP_HOST']))
    {
        $host = $_SERVER['HTTP_HOST'];
    }
    else
    {
        if (isset($_SERVER['SERVER_NAME']))
        {
            $host = $_SERVER['SERVER_NAME'];
        }
        elseif (isset($_SERVER['SERVER_ADDR']))
        {
            $host = $_SERVER['SERVER_ADDR'];
        }
    }
    return $host;
}

if(app_conf("URL_MODEL")==1)
{
    //重写模式
    $current_url = APP_ROOT;    
    if(isset($_REQUEST['rewrite_param']))
    $rewrite_param = $_REQUEST['rewrite_param'];
    else
    $rewrite_param = "";
    
    $rewrite_param = str_replace(array( "\"","'" ), array("",""), $rewrite_param);
    $rewrite_param = explode("/",$rewrite_param);
    $rewrite_param_array = array();
    foreach($rewrite_param as $k=>$param_item)
    {
        if($param_item!='')
        $rewrite_param_array[] = $param_item;
    }   
    foreach ($rewrite_param_array as $k=>$v)
    {
        if(substr($v,0,1)=='-')
        {
            //扩展参数
            $v = substr($v,1);
            $ext_param = explode("-",$v);
            foreach($ext_param as $kk=>$vv)
            {
                if($kk%2==0)
                {
                    if(preg_match("/(\w+)\[(\w+)\]/",$vv,$matches))
                    {
                        $_GET[$matches[1]][$matches[2]] = $ext_param[$kk+1];
                    }
                    else
                    $_GET[$ext_param[$kk]] = $ext_param[$kk+1];
                    
                    if($ext_param[$kk]!="p")
                    {
                        $current_url.=$ext_param[$kk];  
                        $current_url.="-".$ext_param[$kk+1]."-";
                    }
                }
            }           
        }
        elseif($k==0)
        {
            //解析ctl与act
            $ctl_act = explode("-",$v);
            if($ctl_act[0]!='id')
            {
                
                $_GET['ctl'] = !empty($ctl_act[0])?$ctl_act[0]:"";
                $_GET['act'] = !empty($ctl_act[1])?$ctl_act[1]:"";  
        
                $current_url.="/".$ctl_act[0];  
                if(!empty($ctl_act[1]))
                $current_url.="-".$ctl_act[1]."/";  
                else
                $current_url.="/";  
            }
            else
            {
                //扩展参数
                $ext_param = explode("-",$v);
                foreach($ext_param as $kk=>$vv)
                {
                    if($kk%2==0)
                    {
                        if(preg_match("/(\w+)\[(\w+)\]/",$vv,$matches))
                        {
                            $_GET[$matches[1]][$matches[2]] = $ext_param[$kk+1];
                        }
                        else
                        $_GET[$ext_param[$kk]] = $ext_param[$kk+1];
                        
                        if($ext_param[$kk]!="p")
                        {
                            if($kk==0)$current_url.="/";
                            $current_url.=$ext_param[$kk];  
                            $current_url.="-".$ext_param[$kk+1]."-";    
                        }
                    }
                }
            }
            
        }elseif($k==1)
        {
            //扩展参数
            $ext_param = explode("-",$v);
            foreach($ext_param as $kk=>$vv)
            {
                if($kk%2==0)
                {
                    if(preg_match("/(\w+)\[(\w+)\]/",$vv,$matches))
                    {
                        $_GET[$matches[1]][$matches[2]] = $ext_param[$kk+1];
                    }
                    else
                    $_GET[$ext_param[$kk]] = $ext_param[$kk+1];
                    
                    if($ext_param[$kk]!="p")
                    {
                        $current_url.=$ext_param[$kk];  
                        $current_url.="-".$ext_param[$kk+1]."-";
                    }
                }
            }           
        }
    }
    $current_url = substr($current_url,-1)=="-"?substr($current_url,0,-1):$current_url; 

}
unset($_REQUEST['rewrite_param']);
unset($_GET['rewrite_param']);


//引入时区配置及定义时间函数
if(function_exists('date_default_timezone_set'))
    date_default_timezone_set(app_conf('DEFAULT_TIMEZONE'));
//end 引入时区配置及定义时间函数


if(!defined('NOW_TIME')) 
    define("NOW_TIME",get_gmtime());



//定义缓存
require APP_ROOT_PATH.'system/cache/Cache.php';
$cache = CacheService::getInstance();
require_once APP_ROOT_PATH."system/cache/CacheFileService.php";
$fcache = new CacheFileService();  //专用于保存静态数据的缓存实例
$fcache->set_dir(APP_ROOT_PATH."public/runtime/data/");
//end 定义缓存

//定义DB
require APP_ROOT_PATH.'system/db/db.php';
define('DB_PREFIX', app_conf('DB_PREFIX')); 
if(!file_exists(APP_ROOT_PATH.'public/runtime/app/db_caches/'))
    mkdir(APP_ROOT_PATH.'public/runtime/app/db_caches/',0777);
$pconnect = false;
$db = new mysql_db(app_conf('DB_HOST').":".app_conf('DB_PORT'), app_conf('DB_USER'),app_conf('DB_PWD'),app_conf('DB_NAME'),'utf8',$pconnect);
//end 定义DB


//定义模板引擎
require  APP_ROOT_PATH.'system/template/template.php';
if(!file_exists(APP_ROOT_PATH.'public/runtime/app/tpl_caches/'))
    mkdir(APP_ROOT_PATH.'public/runtime/app/tpl_caches/',0777); 
if(!file_exists(APP_ROOT_PATH.'public/runtime/app/tpl_compiled/'))
    mkdir(APP_ROOT_PATH.'public/runtime/app/tpl_compiled/',0777);
$tmpl = new AppTemplate;

//end 定义模板引擎
$_REQUEST = array_merge($_GET,$_POST);
filter_request($_REQUEST);



//项目成功发送短信、回报短信(所有成功项目的支持人、项目创立者）
function send_deal_success(){
    if(app_conf("SMS_ON")==0){
        return false;
    }
    //项目成功发起者短信
    $deal_s_user=$GLOBALS['db']->getAll("select d.*,u.mobile from ".DB_PREFIX."deal d LEFT JOIN ".DB_PREFIX."user u ON u.id = d.user_id where d.is_success='1' and d.is_has_send_success='0' and d.is_delete = 0 ");
    $tmpl3=$GLOBALS['db']->getRowCached("select * from ".DB_PREFIX."msg_template where name='TPL_SMS_USER_S'");
    $tmpl_content3 = $tmpl3['content'];
    
    foreach ($deal_s_user as $k=>$v){
        if($v['id']){
        $user_s_msg['user_name']=$v['user_name'];
        $user_s_msg['deal_name']=$v['name'];
    
        $GLOBALS['tmpl']->assign("user_s_msg",$user_s_msg);
        $msg3=$GLOBALS['tmpl']->fetch("str:".$tmpl_content3);
        $msg_data3['dest']=$v['mobile'];
        $msg_data3['send_type']=0;
        $msg_data3['content']=addslashes($msg3);
        $msg_data3['send_time']=0;
        $msg_data3['title']='项目成功发起者-'.$v['name'].'-项目ID-'.$v['id'];;
        $msg_data3['is_send']=0;
        $msg_data3['create_time'] = NOW_TIME;
        $msg_data3['user_id'] = $v['user_id'];
        $msg_data3['is_html'] = $tmpl3['is_html'];
        $GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data3); //插入
    
        $GLOBALS['db']->query("UPDATE ".DB_PREFIX."deal SET is_has_send_success='1' WHERE id = ".$v['id']);
        }
    }
    
    $success_deal_user=$GLOBALS['db']->getAll("SELECT dlo.* FROM ".DB_PREFIX."deal_order dlo LEFT JOIN ".DB_PREFIX."deal d ON d.id= dlo.deal_id WHERE d.is_success='1' and d.is_has_send_success='0' and d.is_delete = 0 AND dlo.order_status='3' AND dlo.is_success='1' AND dlo.is_has_send_success=0 ");
    if($success_deal_user){
        //项目成功支持者
        $tmpl=$GLOBALS['db']->getRowCached("select * from ".DB_PREFIX."msg_template where name='TPL_SMS_DEAL_SUCCESS'");
        $tmpl_content = $tmpl['content'];
        
        foreach ($success_deal_user as $k=>$v){
            if($v['id']){
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
            $msg_data['title']='项目成功支持者-'.$v['deal_name'].'-订单号'.$v['id'];;
            $msg_data['create_time'] = NOW_TIME;
            $msg_data['user_id'] = $v['user_id'];
            $msg_data['is_html'] = $tmpl['is_html'];
            $GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data); //插入
            
            $GLOBALS['db']->query("UPDATE ".DB_PREFIX."deal_order SET is_has_send_success='1' WHERE id = ".$v['id']);
            }
        }
    }
    
}


//项目失败发送短信(支持人、项目发起人)
function send_deal_fail(){
    if(app_conf("SMS_ON")==0){
        return false;
    }
    //项目失败发起者短信
    $deal_f_user=$GLOBALS['db']->getAll("select d.*,u.mobile from ".DB_PREFIX."deal d LEFT JOIN ".DB_PREFIX."user u ON u.id = d.user_id where d.is_success='0' and d.is_has_send_success='0' and d.is_delete = 0 and d.support_amount < (d.limit_price-(select sum(virtual_person*price) FROM ".DB_PREFIX."deal_item where deal_id=d.id )) and d.end_time < ".NOW_TIME);
    
    $tmpl2=$GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name='TPL_SMS_USER_F'");
    $tmpl_content2 = $tmpl2['content'];
    foreach ($deal_f_user as $k=>$v){
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
        $msg_data2['title']='项目失败发起者-'.$v['name'].'-项目ID-'.$v['id'];
        $GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data2); //插入
        $GLOBALS['db']->query("UPDATE ".DB_PREFIX."deal SET is_has_send_success='1' WHERE id = ".$v['id']);
    }
    
    //支持人
    $tmpl=$GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name='TPL_SMS_DEAL_FAIL'");
    $tmpl_content = $tmpl['content'];
    $fail_deal_user = $GLOBALS['db']->getAll("SELECT dlo.* FROM ".DB_PREFIX."deal_order dlo LEFT JOIN ".DB_PREFIX."deal d ON d.id= dlo.deal_id WHERE d.is_success='0' and d.is_has_send_success='0' and d.is_delete = 0 and d.support_amount < (d.limit_price-(select sum(virtual_person*price) FROM ".DB_PREFIX."deal_item where deal_id=d.id )) and d.end_time < ".NOW_TIME." AND dlo.order_status='3' AND dlo.is_success='1' AND dlo.is_has_send_success=0 ");
    foreach ($fail_deal_user as $k=>$v){
        $fail_user_info['user_name']=$v['user_name'];
        $fail_user_info['deal_name']=$v['deal_name'];
        $GLOBALS['tmpl']->assign('fail_user_info',$fail_user_info);
        $msg=$GLOBALS['tmpl']->fetch("str:".$tmpl_content);
        $msg_data['dest']=$v['mobile'];
        $msg_data['send_type']=0;
        $msg_data['content']=addslashes($msg);
        $msg_data['send_time']=0;
        $msg_data['is_send']=0;
        $msg_data['title']='项目失败支持人-'.$v['deal_name'].'-订单号'.$v['id'];
        $msg_data['create_time'] = get_gmtime();
        $msg_data['user_id'] = $v['user_id'];
        $msg_data['is_html'] = $tmpl['is_html'];
        $GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data); //插入
        $GLOBALS['db']->query("UPDATE ".DB_PREFIX."deal_order SET is_has_send_success='1' WHERE id = ".$v['id']);
    }
    
}

//注册验证成功发送短信
function send_register_success($user_id=0,$user_info=array()){
    if(app_conf("SMS_ON")==0 && ($user_id == 0 || !$user_info)){
        return false;
    }
    if(!$user_info){
        $user_info = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."user where id=".$user_id);
    }
    if($user_info['mobile']==""){
        return false;
    }
    $tmpl=$GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name='TPL_SMS_USER_VERIFY'");
    $tmpl_content = $tmpl['content'];
    if ($user_info){
        $success_user_info['user_name']=$user_info['user_name'];
        $GLOBALS['tmpl']->assign('success_user_info',$success_user_info);
        $msg=$GLOBALS['tmpl']->fetch("str:".$tmpl_content);
        $msg_data['dest']=$user_info['mobile'];
        $msg_data['send_type']=0;
        $msg_data['content']=addslashes($msg);
        $msg_data['send_time']=0;
        $msg_data['is_send']=0;
        $msg_data['title']='注册成功';
        $msg_data['create_time'] = NOW_TIME;
        $msg_data['user_id'] = $user_info['id'];
        $msg_data['is_html'] = $tmpl['is_html'];
        $GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data); //插入
    }
    
} ?>