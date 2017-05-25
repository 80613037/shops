<?php
// +----------------------------------------------------------------------
// | Fanwe 方维众筹商业系统
// +----------------------------------------------------------------------
// | Copyright (c) 2011 http://www.fanwe.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 云淡风轻(97139915@qq.com)
// +----------------------------------------------------------------------

//开放的公共类，不需RABC验证
class PublicAction extends BaseAction{
	public function login(){
		//验证是否已登录
		//管理员的SESSION
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$adm_name = $adm_session['adm_name'];
		$adm_id = intval($adm_session['adm_id']);
        if(C('isDevelop')) {
            $this->WLog(zcv, 'sess', $adm_session);
        }
		if($adm_id != 0)
		{
			//已登录
			$this->redirect(u("Index/index"));
		}
		else
		{
			$this->display();
		}
	}
	public function verify()
	{
        Image::buildImageVerify(4,1);
    }

    //登录函数
    public function do_login(){
    	$adm_name = trim($_REQUEST['adm_name']);
    	$adm_password = trim($_REQUEST['adm_password']);
    	$ajax = intval($_REQUEST['ajax']);  //是否ajax提交
    	if($adm_name == '')
    	{
    		$this->error(L('ADM_NAME_EMPTY',$ajax));
    	}
    	if($adm_password == '')
    	{
    		$this->error(L('ADM_PASSWORD_EMPTY',$ajax));
    	}
    	if(es_session::get("verify") != md5($_REQUEST['adm_verify'])) {
//			$this->error(L('ADM_VERIFY_ERROR'),$ajax);
		}

		$condition['adm_name'] = $adm_name;
		$condition['is_effect'] = 1;
		$condition['is_delete'] = 0;
		$adm_data = M("Admin")->where($condition)->find();
		if($adm_data) //有用户名的用户
		{
			if($adm_data['adm_password']!=md5($adm_password))
			{
				save_log($adm_name.L("ADM_PASSWORD_ERROR"),0); //记录密码登录错误的LOG
				$this->error(L("ADM_PASSWORD_ERROR"),$ajax);
			}
			else
			{
				//登录成功
				$adm_session['adm_name'] = $adm_data['adm_name'];
				$adm_session['adm_id'] = $adm_data['id'];


				es_session::set(md5(conf("AUTH_KEY")),$adm_session);

				//重新保存记录
				$adm_data['login_ip'] = get_client_ip();
				$adm_data['login_time'] = get_gmtime();
				M("Admin")->save($adm_data);
				save_log($adm_data['adm_name'].L("LOGIN_SUCCESS"),1);
				$this->success(L("LOGIN_SUCCESS"),$ajax);
			}
		}
		else
		{
			save_log($adm_name.L("ADM_NAME_ERROR"),0); //记录用户名登录错误的LOG
			$this->error(L("ADM_NAME_ERROR"),$ajax);
		}
    }

    //登出函数
	public function do_loginout()
	{
	//验证是否已登录
		//管理员的SESSION
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$adm_id = intval($adm_session['adm_id']);

		if($adm_id == 0)
		{
			//已登录
            es_session:delete('WST_STAFF');
            $this->redirect("index.php?m=Admin&c=Index&a=toLogin");
//			$this->redirect(u("Public/login"));
		}
		else
		{
			es_session::delete(md5(conf("AUTH_KEY")));
			$this->assign("jumpUrl",U("Public/login"));
			$this->assign("waitSecond",3);
			$this->success(L("LOGINOUT_SUCCESS"));
		}

	}


    /**
     * @param $fileName 日志名（abc）
     * @param $limit 显示名（uinfo）
     * @param $word  内容（可以是数组）
     * abc.log 文件内容为 ( [03-03 16:13:54] [info]：数组信息)
     */
    function  WLog($fileName, $limit, $word){
        if(is_array($word)){
            $word = json_encode($word);
        }
        $path = "../Apps/Runtime/Logs/";
        file_put_contents($path.$fileName.'.log', '['.date("m-d H:i:s").'] ['.$limit.']：'.$word.PHP_EOL, FILE_APPEND);
    }


}
?>