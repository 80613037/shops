<?php if (!defined('THINK_PATH')) exit();?>

<?php function get_order_status($status)
	{
		if($status==0)return "未支付";
		if($status==1)return "过期支付";
		if($status==2)return "限额已满";
		if($status==3)return "已支付";
	}
	
	function get_notice_info($notice)
	{		
		$str .= $notice['memo']."  ";
		$payment = M("Payment")->getById($notice['payment_id']);
		if($payment)
		{
			$str .= "通过";
			$class_name = $payment['class_name']."_payment";		
			$str.=$payment['name'];
			if($notice['bank_id']!="")
			{
				require_once APP_ROOT_PATH."/system/payment/".$class_name.".php";
				$str.=$payment_lang[$notice['bank_id']];
			}
		}
		$str.="支付".format_price($notice['money']);
		$str.=",内部单号:".$notice['notice_sn']."。外部单号:";
		if($notice['outer_notice_sn']=="")
		$notice['outer_notice_sn']= "无";
		$str.=$notice['outer_notice_sn'];
		return $str;
	} ?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/style.css" />
<script type="text/javascript" src="__TMPL__Common/js/check_dog.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/IA300ClientJavascript.js"></script>
<script type="text/javascript">
 	var VAR_MODULE = "<?php echo conf("VAR_MODULE");?>";
	var VAR_ACTION = "<?php echo conf("VAR_ACTION");?>";
	var MODULE_NAME	=	'<?php echo MODULE_NAME; ?>';
	var ACTION_NAME	=	'<?php echo ACTION_NAME; ?>';
	var ROOT = '__APP__';
	var ROOT_PATH = '<?php echo APP_ROOT; ?>';
	var CURRENT_URL = '<?php echo trim($_SERVER['REQUEST_URI']);?>';
	var INPUT_KEY_PLEASE = "<?php echo L("INPUT_KEY_PLEASE");?>";
	var TMPL = '__TMPL__';
	var APP_ROOT = '<?php echo APP_ROOT; ?>';
	var LOGINOUT_URL = '<?php echo u("Public/do_loginout");?>';
	var WEB_SESSION_ID = '<?php echo es_session::id(); ?>';
	var EMOT_URL = '<?php echo APP_ROOT; ?>/public/emoticons/';
	var MAX_FILE_SIZE = "<?php echo (app_conf("MAX_IMAGE_SIZE")/1000000)."MB"; ?>";
	var FILE_UPLOAD_URL ='<?php echo u("File/do_upload");?>' ;
	CHECK_DOG_HASH = '<?php $adm_session = es_session::get(md5(conf("AUTH_KEY"))); echo $adm_session["adm_dog_key"]; ?>';
	function check_dog_sender_fun()
	{
		window.clearInterval(check_dog_sender);
		check_dog2();
	}
	var check_dog_sender = window.setInterval("check_dog_sender_fun()",5000);
	
</script>
<script type="text/javascript" src="__TMPL__Common/js/jquery.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/jquery.timer.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/script.js"></script>
<script type="text/javascript" src="__ROOT__/public/runtime/admin/lang.js"></script>
<script type='text/javascript'  src='__ROOT__/admin/public/kindeditor/kindeditor.js'></script>
 <script type='text/javascript'  src='__ROOT__/admin/public/kindeditor/lang/zh_CN.js'></script>
</head>
<body onLoad="javascript:DogPageLoad();">
<div id="info"></div>

<script type="text/javascript" src="__TMPL__Common/js/jquery.bgiframe.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/jquery.weebox.js"></script>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/weebox.css" />
<div class="main">
<div class="main_title"><?php echo ($order_info["deal_name"]); ?></div>
<div class="main_title"> <a href="javascript:history.go(-1);" class="back_list"><?php echo L("BACK_LIST");?></a></div>

<div class="blank5"></div>

<table class="form" cellpadding=0 cellspacing=0>
	<tr>
		<td colspan=6 class="topTd"></td>
	</tr>
	<tr>
		<td class="item_title">项目名称:</td>
		<td class="item_input" colspan=3><?php echo ($order_info["deal_name"]); ?></td>
		<td class="item_title">支持者:</td>
		<td class="item_input"><?php echo ($order_info["user_name"]); ?></td>

	</tr>	
	<tr>
		<td class="item_title">配送地址:</td>
		<td class="item_input" colspan=5><?php echo ($order_info["province"]); ?><?php echo ($order_info["city"]); ?><?php echo ($order_info["address"]); ?>,邮编：<?php echo ($order_info["zip"]); ?>,收货人：<?php echo ($order_info["consignee"]); ?>手机：<?php echo ($order_info["mobile"]); ?></td>

	</tr>	
	<tr>
		<td class="item_title" width="16%">下单时间:</td>
		<td class="item_input" width="16%"><?php echo (to_date($order_info["create_time"])); ?></td>
		<td class="item_title" width="16%">订单状态:</td>
		<td class="item_input" width="16%">
			<?php echo (get_order_status($order_info["order_status"])); ?>
			<?php if($order_info['order_status'] == 0): ?><a href="<?php echo u("DealOrder/incharge",array("id"=>$order_info['id']));?>">管理员收款</a><?php endif; ?>
		</td>
		<td class="item_title" width="16%">退款:</td>
		<td class="item_input" width="16%">
			<?php if($order_info['is_refund'] == 0 and $order_info['order_status'] == 3): ?><a href="<?php echo u("DealOrder/refund",array("id"=>$order_info['id']));?>">立即退款</a>
			<?php else: ?>
			<?php if($order_info['order_status'] == 0): ?>--
			<?php else: ?>
			已退款<?php endif; ?><?php endif; ?>
		</td>
	</tr>
	<tr>
		<td class="item_title">总价:</td>
		<td class="item_input"><?php echo (format_price($order_info["total_price"])); ?></td>
		<td class="item_title">项目:</td>
		<td class="item_input"><?php echo (format_price($order_info["deal_price"])); ?></td>
		<td class="item_title">运费:</td>
		<td class="item_input"><?php echo (format_price($order_info["delivery_fee"])); ?></td>
	</tr>
	<tr>
		<td class="item_title">余额支付:</td>
		<td class="item_input"><?php echo (format_price($order_info["credit_pay"])); ?></td>
		<td class="item_title">在线支付:</td>
		<td class="item_input"><?php echo (format_price($order_info["online_pay"])); ?></td>
		<td class="item_title">支付时间:</td>
		<td class="item_input"><?php echo (to_date($order_info["pay_time"])); ?></td>
	</tr>	
	<tr>
		<td class="item_title">支持者备注:</td>
		<td class="item_input" colspan=5><?php echo ($order_info["support_memo"]); ?></td>

	</tr>
	<tr>
		<td class="item_title">回报设置:</td>
		<td class="item_input" colspan=5>
			<?php if($order_info['repay_time'] != 0): ?><?php echo (to_date($order_info["repay_time"])); ?>:<?php echo ($order_info["repay_memo"]); ?>
			<?php else: ?>
			回报未发放<?php endif; ?>
		</td>

	</tr>
	<tr>
		<th colspan=6>付款记录</th>
	</tr>
	<?php if(is_array($payment_notice_list)): foreach($payment_notice_list as $key=>$notice): ?><tr>
		<td class="item_title"><?php echo (to_date($notice["pay_time"])); ?>:</td>
		<td class="item_input" colspan=5>
			<?php echo (get_notice_info($notice)); ?>
		</td>

	</tr><?php endforeach; endif; ?>
	
		
	<tr>
		<td colspan=6 class="bottomTd"></td>
	</tr>
</table>
<div class="blank5"></div>

</div>
</body>
</html>