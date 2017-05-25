<?php echo $this->fetch('inc/header.html'); ?>
<?php
$this->_var['dpagejs'][] = $this->_var['TMPL_REAL']."/js/deal_list.js";
$this->_var['dcpagejs'][] = $this->_var['TMPL_REAL']."/js/deal_list.js";
$this->_var['dpagecss'][] = $this->_var['TMPL_REAL']."/css/account.css";
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
<style>
.btn_creat{height:30px; font-size:14px; line-height:30px; padding:0 15px; background:#12adff; color:#fff; display:inline-block; -moz-border-radius:3px; -khtml-border-radius:3px; -webkit-border-radius:3px; border-radius:3px;}
.btn_creat:hover{color:#fff;}
input{border:solid 1px rgb(169, 169, 169);}
.label_l{height:31px;line-height:31px;font-size:14px;}
.small_textbox{padding:9px;}
.ui-button{height:39px;line-height:39px}
.btn_select ,
.btn_select .cur_select,
.btn_select select{height:29px;line-height:29px}
.select_arrow{margin-top:11px;}
.ui-button{height:31px;line-height:31px;font-size:14px;}
.pageright{width:1000px;}
</style>
<div class="blank"></div>

<!--中间开始-->
<div class="dlmain Myhomepage">

		<div class="homeright pageright f_r">
			<div >
				<div class="page_title">我的项目</div>	
				<div class="full">
					<form method="post" action="<?php
echo parse_url_tag("u:account#project|"."".""); 
?>" id="account_project">
						<span>
							<label class="label_l f_l mr10">项目类型:</label>
							<a class="btn_select f_l mr15" id="search_type_select">
								<span class="cur_select" id="search_type_cur"></span>
								<div class="select_arrow"></div>
								<select name="search_type" class="select-h" id="phase_id">
				              		<?php if (app_conf ( "INVEST_STATUS" ) == 0): ?>	
										<option value="-1" <?php if ($this->_var['search_type'] == - 1): ?>selected="selected"<?php endif; ?>>请选择</option>
										<option value="0" <?php if ($this->_var['search_type'] == 0): ?>selected="selected"<?php endif; ?>>普通众筹</option>
						              	<option value="1" <?php if ($this->_var['search_type'] == 1): ?>selected="selected"<?php endif; ?>>股权众筹</option>  
									<?php endif; ?>
									<?php if (app_conf ( "INVEST_STATUS" ) == 1): ?>	
										<option value="-1" <?php if ($this->_var['search_type'] == - 1): ?>selected="selected"<?php endif; ?>>请选择</option>
										<option value="0" <?php if ($this->_var['search_type'] == 0): ?>selected="selected"<?php endif; ?>>普通众筹</option>
									<?php endif; ?>
									<?php if (app_conf ( "INVEST_STATUS" ) == 2): ?>	
										<option value="-1" <?php if ($this->_var['search_type'] == - 1): ?>selected="selected"<?php endif; ?>>请选择</option>
										<option value="1" <?php if ($this->_var['search_type'] == 1): ?>selected="selected"<?php endif; ?>>股权众筹</option>  
									<?php endif; ?>		    
								</select>
							</a>
						</span>
						<span>
							<label class="label_l f_l mr10">项目名称:</label>
							<input type="text" class="smaller_textbox mr10" id="project_label" name="search_name" value="<?php echo $this->_var['search_name']; ?>">	
						</span>
						<span>
							<div name="submit_form" class="ui-button theme_bgcolor" id="screening" onclick="bind_project_form();">筛选</div>
						</span>
					</form>
				</div>
				<div class="blank0"></div>
				<div class="full">
					<?php if ($this->_var['deal_list']): ?>
					<div class="i_deal_list clearfix">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="uc_table">
						<thead>
							<tr>
								<th>项目名称</th>
								<th width="100">类型</th>
								<th width="100">状态</th>
								<th width="200" style="text-align:right;padding-right:24px">操作</th>
							</tr>
						</thead>
						<tbody>
							<?php $_from = $this->_var['deal_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'deal_item');if (count($_from)):
    foreach ($_from AS $this->_var['deal_item']):
?>
							<tr>
								<td class="deal_name" style="text-align:left;">
									<a href="#" p="id=$deal_item.id"}" target="" title="<?php echo $this->_var['deal_item']['name']; ?>"><img src="<?php 
$k = array (
  'name' => 'get_spec_image',
  'v' => $this->_var['deal_item']['image'],
  'w' => '50',
  'h' => '50',
  'g' => '1',
);
echo $k['name']($k['v'],$k['w'],$k['h'],$k['g']);
?>"  alt="<?php echo $this->_var['deal_item']['name']; ?>" class="f_l p_img"/></a>
									<a href="#" p="id=$deal_item.id"}" target="" title="<?php echo $this->_var['deal_item']['name']; ?>"><?php 
$k = array (
  'name' => 'msubstr',
  'v' => $this->_var['deal_item']['name'],
  'b' => '0',
  'e' => '25',
);
echo $k['name']($k['v'],$k['b'],$k['e']);
?></a>
								</td>
								<td>
									<?php if ($this->_var['deal_item']['type'] == 1): ?>
										股权众筹
									<?php else: ?>
										普通众筹
									<?php endif; ?>
								</td>
								<td>
									<?php if ($this->_var['deal_item']['is_effect'] == 0): ?>
											<?php if ($this->_var['deal_item']['is_edit'] == 1): ?>
												准备中
											<?php else: ?>
												等待审核
											<?php endif; ?>
										<?php elseif ($this->_var['deal_item']['is_effect'] == 2): ?>
												未通过<?php if ($this->_var['deal_item']['refuse_reason']): ?>,<a href="javascript:void(0);" class="refuse_reason" rel="<?php echo $this->_var['deal_item']['id']; ?>">查看理由</a><?php endif; ?>
										<?php else: ?>
										<?php if ($this->_var['deal_item']['type'] == 1): ?>
											<?php if ($this->_var['deal_item']['is_success'] == 1): ?>
												<?php if ($this->_var['deal_item']['begin_time'] > $this->_var['now']): ?>未开始<?php endif; ?>
												<?php if ($this->_var['deal_item']['end_time'] < $this->_var['now'] && $this->_var['deal_item']['end_time'] != 0 && $this->_var['deal_item']['pay_end_time'] > $this->_var['now']): ?>已成功<?php endif; ?>
												<?php if ($this->_var['deal_item']['pay_end_time'] < $this->_var['now']): ?>已成功<?php endif; ?>
												<?php if ($this->_var['deal_item']['begin_time'] < $this->_var['now'] && ( $this->_var['deal_item']['end_time'] > $this->_var['now'] || $this->_var['deal_item']['end_time'] == 0 )): ?>已成功<?php endif; ?>
											<?php else: ?>
												<?php if ($this->_var['deal_item']['begin_time'] > $this->_var['now']): ?>未开始<?php endif; ?>
												<?php if ($this->_var['deal_item']['end_time'] < $this->_var['now'] && $this->_var['deal_item']['end_time'] != 0 && $this->_var['deal_item']['pay_end_time'] > $this->_var['now']): ?>支付阶段<?php endif; ?>
												<?php if ($this->_var['deal_item']['pay_end_time'] < $this->_var['now']): ?>未成功<?php endif; ?>
												<?php if ($this->_var['deal_item']['begin_time'] < $this->_var['now'] && ( $this->_var['deal_item']['end_time'] > $this->_var['now'] || $this->_var['deal_item']['end_time'] == 0 )): ?>融资中<?php endif; ?>
											<?php endif; ?>
										<?php else: ?>
											<?php if ($this->_var['deal_item']['is_success'] == 1): ?>
												<?php if ($this->_var['deal_item']['begin_time'] > $this->_var['now']): ?>未开始<?php endif; ?>
												<?php if ($this->_var['deal_item']['end_time'] < $this->_var['now'] && $this->_var['deal_item']['end_time'] != 0): ?>已成功<?php endif; ?>
												<?php if ($this->_var['deal_item']['begin_time'] < $this->_var['now'] && ( $this->_var['deal_item']['end_time'] > $this->_var['now'] || $this->_var['deal_item']['end_time'] == 0 )): ?>已成功<?php endif; ?>
											<?php else: ?>
												<?php if ($this->_var['deal_item']['begin_time'] > $this->_var['now']): ?>未开始<?php endif; ?>
												<?php if ($this->_var['deal_item']['end_time'] < $this->_var['now'] && $this->_var['deal_item']['end_time'] != 0): ?>未成功<?php endif; ?>
												<?php if ($this->_var['deal_item']['begin_time'] < $this->_var['now'] && ( $this->_var['deal_item']['end_time'] > $this->_var['now'] || $this->_var['deal_item']['end_time'] == 0 )): ?>进行中<?php endif; ?>
											<?php endif; ?>
										<?php endif; ?>
 									<?php endif; ?>
								</td>
								<td	style="text-align:right;padding-right:10px">
									<?php if ($this->_var['deal_item']['is_effect'] == 0): ?>
										<?php if ($this->_var['deal_item']['is_edit'] == 1): ?>
											<?php if ($this->_var['deal_item']['type'] == 1): ?>
												<a href="<?php
echo parse_url_tag("u:project#investor_edit|"."id=".$this->_var['deal_item']['id']."".""); 
?>">编辑</a>
											<?php else: ?>
												<a href="<?php
echo parse_url_tag("u:project#edit|"."id=".$this->_var['deal_item']['id']."".""); 
?>">编辑</a>
											<?php endif; ?>
										<a href="<?php
echo parse_url_tag("u:project#del|"."id=".$this->_var['deal_item']['id']."".""); 
?>" class="del_deal">删除</a>
										<?php else: ?>
										等待审核
										<?php endif; ?>
									<?php elseif ($this->_var['deal_item']['is_effect'] == 2): ?>
										<?php if ($this->_var['deal_item']['type'] == 1): ?>
											<a href="<?php
echo parse_url_tag("u:project#investor_edit|"."id=".$this->_var['deal_item']['id']."".""); 
?>">编辑</a>
										<?php else: ?>
											<a href="<?php
echo parse_url_tag("u:project#edit|"."id=".$this->_var['deal_item']['id']."".""); 
?>">编辑</a>
										<?php endif; ?>
 										<a href="<?php
echo parse_url_tag("u:project#del|"."id=".$this->_var['deal_item']['id']."".""); 
?>" class="del_deal">删除</a>
									<?php else: ?>
										<a href="<?php
echo parse_url_tag("u:deal#support|"."id=".$this->_var['deal_item']['id']."".""); 
?>">项目日志</a><br />
										<?php if ($this->_var['deal_item']['type'] == 1): ?><a href="<?php
echo parse_url_tag("u:account#get_leader_list|"."id=".$this->_var['deal_item']['id']."".""); 
?>">领投资格列表</a><br /><?php endif; ?>
										<?php if ($this->_var['deal_item']['is_success'] == 1): ?>
											<?php if ($this->_var['deal_item']['type'] == 1): ?>
												<a href="<?php
echo parse_url_tag("u:account#get_investor_status|"."id=".$this->_var['deal_item']['id']."&type=0".""); 
?>">申请列表</a><br />
												<a href="<?php
echo parse_url_tag("u:account#support|"."id=".$this->_var['deal_item']['id']."&type=1".""); 
?>">投资列表</a><br />
												<a href="<?php
echo parse_url_tag("u:account#paid|"."id=".$this->_var['deal_item']['id']."".""); 
?>">放款记录</a>
  											<?php else: ?>
												<a href="<?php
echo parse_url_tag("u:account#support|"."id=".$this->_var['deal_item']['id']."".""); 
?>">支持记录</a><br />
												<a href="<?php
echo parse_url_tag("u:account#paid|"."id=".$this->_var['deal_item']['id']."".""); 
?>">放款记录</a>
											<?php endif; ?>
											
										<?php endif; ?>
									<?php endif; ?>
								</td>
							</tr>
							<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
						</tbody>	
					</table>
					</div>
					<div class="blank20"></div>
					<div class="pages"><?php echo $this->_var['pages']; ?></div>
					<div class="blank20"></div>
					<?php else: ?>
					<div class="empty_tip">
						从未创建过任何项目 <a href="<?php
echo parse_url_tag("u:project#choose|"."".""); 
?>" class="btn_creat linkgreen">立即创建项目</a>
					</div>
					<?php endif; ?>
				</div
				<div class="blank"></div>	
			</div>
	 		<div class="blank"></div>	
		</div>
<!--中间结束-->

<div class="blank"></div>
<div class="blank"></div>
</div>
<script>
	$(function(){
		funSelect("#search_type_select","#search_type_cur",'#search_type_select option:selected');
 		$(".refuse_reason").bind("click",function(){
			var ajaxurl = APP_ROOT+"/index.php?ctl=ajax&act=refuse_reason";
 			var obj=new Object();
			obj.deal_id=$(this).attr("rel");
			$.ajax({ 
				url: ajaxurl,
				data:obj,
				type: "POST",
				dataType: "json",
				success: function(data){
					if(data.status==1){
						$.weeboxs.open(data.info, {boxid:'fanwe_success_box',contentType:'text',showButton:true, showCancel:false, showOk:true,title:'未通过原因',width:250,type:'wee'});
					}else{
						$.showErr(data.info);
					}
					
					
				}
			});
		});
	});
	
	function bind_project_form()
	{	
			$("#account_project").submit();
	}
	
</script>