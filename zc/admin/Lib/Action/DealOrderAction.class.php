<?php
// +----------------------------------------------------------------------
// | Fanwe 方维众筹商业系统
// +----------------------------------------------------------------------
// | Copyright (c) 2011 http://www.fanwe.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 云淡风轻(97139915@qq.com)
// +----------------------------------------------------------------------

class DealOrderAction extends CommonAction{
	public function index()
	{
		if($_REQUEST['type']=='NULL'){
			unset($_REQUEST['type']);
		}
		$order_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_order where repay_make_time=0 and repay_time>0  ");
		foreach($order_list as $k=>$v){
				$left_date=intval(app_conf("REPAY_MAKE"))?7:intval(app_conf("REPAY_MAKE"));
				$repay_make_date=$v['repay_time']+$left_date*24*3600;
				if($repay_make_date<=get_gmtime()){
 					$GLOBALS['db']->query("update ".DB_PREFIX."deal_order set repay_make_time =  ".get_gmtime()." where id = ".$v['id'] );
				}
 		}
		//列表过滤器，生成查询Map对象
		$map = $this->_search ();
		//追加默认参数
		if($this->get("default_map"))
		$map = array_merge($map,$this->get("default_map"));
		if(trim($_REQUEST['deal_name'])!='')
		{
			$map['deal_name'] = array('like','%'.trim($_REQUEST['deal_name']).'%');
		}
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$name=$this->getActionName();
		$model = D ($name);
		if (! empty ( $model )) {
			$this->_list ( $model, $map );
		}
		$this->display ();
		return;
	}
	
	public function delete() {
		//彻底删除指定记录
		$ajax = intval($_REQUEST['ajax']);
		$id = $_REQUEST ['id'];
		if (isset ( $id )) {
				$condition = array ('id' => array ('in', explode ( ',', $id ) ) );
				$rel_data = M(MODULE_NAME)->where($condition)->findAll();				
				foreach($rel_data as $data)
				{
					$info[] = "[".$data['deal_name'].$data['deal_price']."支持人:".$data['user_name']."状态:".$data['order_status']."]";						
				}
				if($info) $info = implode(",",$info);
				$list = M(MODULE_NAME)->where ( $condition )->delete();		
						
				if ($list!==false) {
//					$deal_id=$GLOBALS['db']->getOne("select deal_id from  ".DB_PREFIX."deal_order where id=$id");
//					syn_deal($deal_id);
					save_log($info."成功删除",1);
					$this->success ("成功删除",$ajax);
				} else {
					save_log($info."删除出错",0);					
					$this->error ("删除出错",$ajax);
				}
			} else {
				$this->error (l("INVALID_OPERATION"),$ajax);
		}
	}
	
	public function view()
	{
		$order_info = M("DealOrder")->getById(intval($_REQUEST['id']));
		if(!$order_info)$this->error("没有该项目的支持");
		
		
		$payment_notice_list = M("PaymentNotice")->where("order_id=".$order_info['id']." and is_paid = 1")->findAll();
		$this->assign("payment_notice_list",$payment_notice_list);
		
		$this->assign("order_info",$order_info);		
		$this->display();
	}
	
	public function refund()
	{
		$id = intval($_REQUEST['id']);
		$order_info = M("DealOrder")->getById($id);
		if($order_info)
		{
			if($order_info['is_refund']==0)
			{
				$GLOBALS['db']->query("update ".DB_PREFIX."deal_order set is_refund = 1 where id = ".$id." and is_refund = 0");
				if($GLOBALS['db']->affected_rows()>0)
				{
					require_once APP_ROOT_PATH."system/libs/user.php";				
					modify_account(array("money"=>$order_info['total_price']),$order_info['user_id'],$order_info['deal_name']."退款");
				}
				
				$this->success("成功退款到会员余额");
			}
			else
			{
				$this->error("已经退款");
			}
		}
		else
		{
			$this->error("没有该项目的支持");
		}
	}
	
	public function incharge()
	{
		$id = intval($_REQUEST['id']);
		$order_info = M("DealOrder")->getById($id);
		if($order_info)
		{
			if($order_info['order_status']==0)
			{
				$result = pay_order($order_info['id']);				
				$money = $result['money'];
				$payment_notice['create_time'] = get_gmtime();
				$payment_notice['user_id'] = $order_info['user_id'];
				$payment_notice['payment_id'] = 0;
				$payment_notice['money'] = $money;
				$payment_notice['bank_id'] = "";
				$payment_notice['order_id'] = $order_info['id'];
				$payment_notice['memo'] = "管理员收款";
				$payment_notice['deal_id'] = $order_info['deal_id'];
				$payment_notice['deal_item_id'] = $order_info['deal_item_id'];
				$payment_notice['deal_name'] = $order_info['deal_name'];
				
				do{
					$payment_notice['notice_sn'] = to_date(get_gmtime(),"Ymd").rand(100,999);
					$GLOBALS['db']->autoExecute(DB_PREFIX."payment_notice",$payment_notice,"INSERT","","SILENT");
					$notice_id = $GLOBALS['db']->insert_id();
				}while($notice_id==0);
				
				require_once APP_ROOT_PATH."system/libs/cart.php";
				$rs = payment_paid($payment_notice['notice_sn'],"");	
				$this->error("收款完成");
			}
			else
			{
				$this->error("已经付过款");
			}
		}
		else
		{
			$this->error("没有该项目的支持");
		}
	}
	
	//导出电子表
	public function export_csv($page = 1)
	{
		$pagesize = 10;
		set_time_limit(0);
		$limit = (($page - 1)*intval($pagesize)).",".(intval($pagesize));
	//	$limit=((0).",".(10));
		//echo $limit;exit;
		$where = " 1=1 ";
		//定义条件
		if(trim($_REQUEST['deal_id'])!='')
		{
			$where.= " and ".DB_PREFIX."deal_order.deal_id = ".intval($_REQUEST['deal_id']);
		}
		if(trim($_REQUEST['deal_name'])!='')
		{
			$where.= " and ".DB_PREFIX."deal_order.deal_name = ".intval($_REQUEST['deal_name']);
		}
		if(trim($_REQUEST['user_name'])!='')
		{
			$where.= " and ".DB_PREFIX."deal_order.user_name = ".intval($_REQUEST['user_name']);
		}
		if(trim($_REQUEST['type'])!='')
		{
			$where.= " and ".DB_PREFIX."deal_order.type = ".intval($_REQUEST['type']);
		}
		$list = M("DealOrder")
				->where($where)
				->field(DB_PREFIX.'deal_order.*')
				->limit($limit)->findAll();
		
		if($list)
		{
			register_shutdown_function(array(&$this, 'export_csv'), $page+1);
			
			$order_value = array( 'user_name'=>'""', 'deal_name'=>'""', 'total_price'=>'""','zip'=>'""','mobile'=>'""','province'=>'""','consignee'=>'""','city'=>'""','address'=>'""');
	    	if($page == 1)
	    	{
		    	$content = iconv("utf-8","gbk","参与者,项目名称,应付总额,邮编,手机,配送地址,收货人");	    		    	
		    	$content = $content . "\n";
	    	}
	    	
			foreach($list as $k=>$v)
			{
				
				$order_value['user_name'] = '"' . iconv('utf-8','gbk',$v['user_name']) . '"';
				$order_value['deal_name'] = '"' . iconv('utf-8','gbk',$v['deal_name']) . '"';
				$order_value['total_price'] = '"' . iconv('utf-8','gbk',$v['total_price']) . '"';
				$order_value['zip'] = '"' . iconv('utf-8','gbk',$v['zip']) . '"';
				$order_value['mobile'] = '"' . iconv('utf-8','gbk',$v['mobile']) . '"';
				$order_value['province'] = '"' . iconv('utf-8','gbk',$v['province']) . '"'. iconv('utf-8','gbk',$v['city']) . iconv('utf-8','gbk',$v['address']);
				$order_value['consignee'] = '"' . iconv('utf-8','gbk',$v['consignee']). '"' ;
				$content .= implode(",", $order_value) . "\n";
			}	
			
			//
			header("Content-Disposition: attachment; filename=order_list.csv");
	    	echo $content ;
		}
		else
		{
			if($page==1)
			$this->error(L("NO_RESULT"));
		}	
		
	}
	
	public function get_pay_list()
	{
		$deal_id=$_REQUEST['deal_id'];
		$deal_info=$GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal where id=$deal_id ");
		$this->assign("deal_info",$deal_info);
		$order_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_order where repay_make_time=0 and repay_time>0 and deal_id=$deal_id  ");
		foreach($order_list as $k=>$v){
				$left_date=intval(app_conf("REPAY_MAKE"))?7:intval(app_conf("REPAY_MAKE"));
				$repay_make_date=$v['repay_time']+$left_date*24*3600;
				if($repay_make_date<=get_gmtime()){
 					$GLOBALS['db']->query("update ".DB_PREFIX."deal_order set repay_make_time =  ".get_gmtime()." where id = ".$v['id'] );
				}
 		}
		//列表过滤器，生成查询Map对象
		$map = $this->_search ();
		//追加默认参数
		if($this->get("default_map"))
		$map = array_merge($map,$this->get("default_map"));
		if(trim($_REQUEST['deal_name'])!='')
		{
			$map['deal_name'] = array('like','%'.trim($_REQUEST['deal_name']).'%');
		}
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$name=$this->getActionName();
		$model = D ($name);
		if (! empty ( $model )) {
			$this->_list ( $model, $map );
		}
		$this->display ();
		return;
	}
	
}
?>