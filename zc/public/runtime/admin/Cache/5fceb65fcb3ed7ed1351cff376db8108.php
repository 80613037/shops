<?php if (!defined('THINK_PATH')) exit();?>

<?php function get_order_status($status)
	{
		if($status==0)return "未支付";
		if($status==1)return "过期支付";
		if($status==2)return "限额已满";
		if($status==3)return "已支付";
	}
	 
	function get_order_make_status($status,$deal)
	{
		if($deal['is_success']==1){
			if($status==0)
			{
				if($deal['repay_time']){
					return "未收到";
				}else{
					return "未发放";
				}
			};
			if($status>1)return "收到";
		}else{
			return "未成功";
		} 
			
		 
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
<script type="text/javascript" src="__TMPL__Common/js/deal.js"></script>
<script type="text/javascript">
	function view(id)
	{
		location.href = ROOT+"?"+VAR_MODULE+"="+MODULE_NAME+"&"+VAR_ACTION+"=view&id="+id;
	}
</script>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/weebox.css" />
<div class="main">
<div class="main_title">项目支持记录</div>
<div class="blank5"></div>
<div class="button_row">
	<input type="button" class="button" value="删除" onclick="del();" />
</div>
<div class="blank5"></div>
<div class="search_row">
	<form name="search" action="__APP__" method="get">	
		项目ID: <input type="text" class="textbox" name="deal_id" value="<?php echo trim($_REQUEST['deal_id']);?>" style="width:30px;" />
		项目名称：<input type="text" class="textbox" name="deal_name" value="<?php echo trim($_REQUEST['deal_name']);?>" style="width:100px;" />		
		类型:<select name="type">
			<option value="NULL" <?php if($_REQUEST['type'] == NULL): ?>selected="selected"<?php endif; ?> >请选择</option>
			<option value="0" <?php if($_REQUEST['type'] == '0'): ?>selected="selected"<?php endif; ?> >产品众筹</option>
			<option value="1" <?php if($_REQUEST['type'] == 1): ?>selected="selected"<?php endif; ?> >股权众筹</option>
			</select>
		支持者名称: <input type="text" class="textbox" name="user_name" value="<?php echo trim($_REQUEST['user_name']);?>" style="width:100px;" />
		退款:
		<select name="is_refund">
		<option value="NULL" <?php if($_REQUEST['is_refund'] == NULL): ?>selected="selected"<?php endif; ?> >请选择</option>
			<option value="0" <?php if($_REQUEST['is_refund'] == '0'): ?>selected="selected"<?php endif; ?> >否</option>
			<option value="1" <?php if($_REQUEST['is_refund'] == 1): ?>selected="selected"<?php endif; ?> >是</option>
		</select>
		支付状态: 
		<select name="order_status">
		<option value="NULL" <?php if($_REQUEST['order_status'] == NULL): ?>selected="selected"<?php endif; ?> >请选择</option>
			<option value="0" <?php if($_REQUEST['order_status'] == '0'): ?>selected="selected"<?php endif; ?> >未支付</option>
			<option value="1" <?php if($_REQUEST['order_status'] == 1): ?>selected="selected"<?php endif; ?> >已支付(过期)</option>
			<option value="2" <?php if($_REQUEST['order_status'] == 2): ?>selected="selected"<?php endif; ?> >已支付(无库存)</option>
			<option value="3" <?php if($_REQUEST['order_status'] == 3): ?>selected="selected"<?php endif; ?> >支付成功</option>
		</select>
		预计回报时间:<input type="text" class="textbox" name="repay_time" value="<?php echo trim($_REQUEST['repay_time']);?>" style="width:100px;" />
		<input type="hidden" value="DealOrder" name="m" />
		<input type="hidden" value="index" name="a" />
		<input type="submit" class="button" value="<?php echo L("SEARCH");?>" />
		<input type="button" class="button" value="<?php echo L("EXPORT");?>" onclick="export_csv();" />
	</form>
</div>
<div class="blank5"></div>
<!-- Think 系统列表组件开始 -->
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 ><tr><td colspan="16" class="topTd" >&nbsp; </td></tr><tr class="row" ><th width="8"><input type="checkbox" id="check" onclick="CheckAll('dataTable')"></th><th width="50px   "><a href="javascript:sortBy('id','<?php echo ($sort); ?>','DealOrder','index')" title="按照<?php echo L("ID");?><?php echo ($sortType); ?> "><?php echo L("ID");?><?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('deal_name','<?php echo ($sort); ?>','DealOrder','index')" title="按照项目名称   <?php echo ($sortType); ?> ">项目名称   <?php if(($order)  ==  "deal_name"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('type','<?php echo ($sort); ?>','DealOrder','index')" title="按照类型   <?php echo ($sortType); ?> ">类型   <?php if(($order)  ==  "type"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('user_name','<?php echo ($sort); ?>','DealOrder','index')" title="按照支持人   <?php echo ($sortType); ?> ">支持人   <?php if(($order)  ==  "user_name"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('num','<?php echo ($sort); ?>','DealOrder','index')" title="按照购买数量   <?php echo ($sortType); ?> ">购买数量   <?php if(($order)  ==  "num"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('total_price','<?php echo ($sort); ?>','DealOrder','index')" title="按照应付总额   <?php echo ($sortType); ?> ">应付总额   <?php if(($order)  ==  "total_price"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('credit_pay','<?php echo ($sort); ?>','DealOrder','index')" title="按照余额支付   <?php echo ($sortType); ?> ">余额支付   <?php if(($order)  ==  "credit_pay"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('online_pay','<?php echo ($sort); ?>','DealOrder','index')" title="按照在线支付   <?php echo ($sortType); ?> ">在线支付   <?php if(($order)  ==  "online_pay"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('pay_time','<?php echo ($sort); ?>','DealOrder','index')" title="按照支付时间   <?php echo ($sortType); ?> ">支付时间   <?php if(($order)  ==  "pay_time"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('order_status','<?php echo ($sort); ?>','DealOrder','index')" title="按照状态   <?php echo ($sortType); ?> ">状态   <?php if(($order)  ==  "order_status"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('repay_make_time','<?php echo ($sort); ?>','DealOrder','index')" title="按照确认收到回报   <?php echo ($sortType); ?> ">确认收到回报   <?php if(($order)  ==  "repay_make_time"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('is_refund','<?php echo ($sort); ?>','DealOrder','index')" title="按照退款   <?php echo ($sortType); ?> ">退款   <?php if(($order)  ==  "is_refund"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('repay_time','<?php echo ($sort); ?>','DealOrder','index')" title="按照回报日期   <?php echo ($sortType); ?> ">回报日期   <?php if(($order)  ==  "repay_time"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('create_time','<?php echo ($sort); ?>','DealOrder','index')" title="按照下单日期<?php echo ($sortType); ?> ">下单日期<?php if(($order)  ==  "create_time"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th width="350px">操作</th></tr><?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$deal): ++$i;$mod = ($i % 2 )?><tr class="row" ><td><input type="checkbox" name="key" class="key" value="<?php echo ($deal["id"]); ?>"></td><td>&nbsp;<?php echo ($deal["id"]); ?></td><td>&nbsp;<?php echo (get_title($deal["deal_name"])); ?></td><td>&nbsp;<?php echo (get_type_name($deal["type"])); ?></td><td>&nbsp;<?php echo ($deal["user_name"]); ?></td><td>&nbsp;<?php echo ($deal["num"]); ?></td><td>&nbsp;<?php echo (format_price($deal["total_price"])); ?></td><td>&nbsp;<?php echo (format_price($deal["credit_pay"])); ?></td><td>&nbsp;<?php echo (format_price($deal["online_pay"])); ?></td><td>&nbsp;<?php echo (to_date($deal["pay_time"])); ?></td><td>&nbsp;<?php echo (get_order_status($deal["order_status"])); ?></td><td>&nbsp;<?php echo (get_order_make_status($deal["repay_make_time"],$deal)); ?></td><td>&nbsp;<?php echo (get_status($deal["is_refund"])); ?></td><td>&nbsp;<?php echo (to_date($deal["repay_time"])); ?></td><td>&nbsp;<?php echo (to_date($deal["create_time"])); ?></td><td><a href="javascript:view('<?php echo ($deal["id"]); ?>')">查看</a>&nbsp;<a href="javascript:del('<?php echo ($deal["id"]); ?>')">删除</a>&nbsp;</td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td colspan="16" class="bottomTd"> &nbsp;</td></tr></table>
<!-- Think 系统列表组件结束 -->
 

<div class="blank5"></div>
<div class="page"><?php echo ($page); ?></div>
</div>
</body>
</html>