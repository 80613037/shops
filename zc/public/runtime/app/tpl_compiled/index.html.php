<?php echo $this->fetch('inc/header.html'); ?> 
<?php
$this->_var['dpagejs'][] = $this->_var['TMPL_REAL']."/js/index.js";
$this->_var['dcpagejs'][] = $this->_var['TMPL_REAL']."/js/index.js";
?>
<script type="text/javascript" src="<?php 
$k = array (
  'name' => 'parse_script',
  'v' => $this->_var['dpagejs'],
  'c' => $this->_var['dcpagejs'],
);
echo $k['name']($k['v'],$k['c']);
?>"></script>
<script type="text/javascript" src="<?php echo $this->_var['TMPL']; ?>/js/jquery.SuperSlide.2.1.js"></script>
<style>
	.index_title{
		font-weight:normal;
		height:50px;
		line-height:50px;
		margin:0 auto;
		position:relative;
	}
	.index_title span{
		font-size:30px;
	}
	.index_title a{
		position:absolute;
		right:0;
		top:8px;
		color:#fff;
		width:85px;
		height:35px;
		line-height:35px;
		display:block;
		text-indent:-999em;
		background:url(<?php echo $this->_var['TMPL']; ?>/images/view_more.png) no-repeat;
	}
</style>

<!--  海报区域开始  1-->
<div class="banner slideBox" id="banner">
	<div class="btn_tit effect_hd">
		<ul>
			<?php $_from = $this->_var['image_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'image_item');if (count($_from)):
    foreach ($_from AS $this->_var['image_item']):
?>
			<li></li>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
	</div>
	<div class="banner_cont effect_bd">
		<ul>
			<?php $_from = $this->_var['image_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'image_item');if (count($_from)):
    foreach ($_from AS $this->_var['image_item']):
?>
			<li><a href="<?php echo $this->_var['image_item']['url']; ?>" target=_blank style="display:block;background: url(<?php 
$k = array (
  'name' => 'get_spec_image',
  'v' => $this->_var['image_item']['image'],
  'w' => '1440',
  'h' => '350',
  'g' => '1',
);
echo $k['name']($k['v'],$k['w'],$k['h'],$k['g']);
?>) 50% 50% no-repeat;"></a></li>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
	</div>
	<div class="fy_box" style="">
		<!--左右翻页按钮，可以不用-->
		<a class="prev" href="javascript:void(0)"></a>
		<a class="next" href="javascript:void(0)"></a>
	</div>
	
</div>
<script type="text/javascript"> 
	if(!$(".banner_cont ul").has('li').length){ 
		$("#banner").css("display","none");
	} 
	
	if($(".banner_cont ul").find('li').length==1){ 
		$(".btn_tit").css("display","none");
	}
	else if($(".banner_cont ul").find('li').length>1){
		$(".btn_tit").css("display","block");
	}
	if($(".banner_cont ul").find('li').length>1){
		jQuery("#banner").slide({mainCell:".banner_cont ul",effect:"leftLoop",easing:"easeInOutQuint",delayTime:500,autoPlay:true});
		$("#banner").mousemove(function(){
			$(this).find(".prev").show();
			$(this).find(".next").show();
		}).mouseout(function(){
			$(this).find(".prev").hide();
			$(this).find(".next").hide();
		});
	}
</script>
<!--  海报区域结束  -->
<div class="adv_index">
	<adv adv_id="index_top" />
</div>
<!--  选项卡开始  -->
<?php if ($this->_var['deal_cate']): ?>
<div style="background: #ffffff;width:100%;margin-bottom:20px;padding:18px 0 24px 0;">
	<h3 class="wrap" style="background:url(<?php echo $this->_var['TMPL']; ?>/images/new_font.png) no-repeat;font-size:30px; font-weight:normal;height:27px;line-height:27px;margin:0 auto;text-indent:-999em">最新上线</h3>
	<div class="blank10"></div>
	<div id="getId">
		<div class="tabT effect_hd">
			<ul class="tab">
				<?php $_from = $this->_var['deal_cate']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'deal_cate_0_56588200_1495606450');$this->_foreach['cate'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cate']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['deal_cate_0_56588200_1495606450']):
        $this->_foreach['cate']['iteration']++;
?>
				<?php if ($this->_foreach['cate']['iteration'] <= 7): ?>
				<li id="tabId<?php echo $this->_var['deal_cate_0_56588200_1495606450']['id']; ?>"><?php echo $this->_var['deal_cate_0_56588200_1495606450']['cate_name']; ?></li>
				<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</ul>
		</div>
		<div class="tabB effect_bd">
			<?php $_from = $this->_var['deal_cate']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k1', 'deal_cate_item');$this->_foreach['deal_cates'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['deal_cates']['total'] > 0):
    foreach ($_from AS $this->_var['k1'] => $this->_var['deal_cate_item']):
        $this->_foreach['deal_cates']['iteration']++;
?>
			<?php if ($this->_foreach['deal_cates']['iteration'] <= 7): ?>
			<div id="tabC<?php echo $this->_var['deal_cate_item']['id']; ?>" class="tabCont">
				<div class="con">	
					<a href="<?php
echo parse_url_tag("u:deal#show|"."id=".$this->_var['deal_cate_item']['id']."".""); 
?>" title="<?php echo $this->_var['deal_cate_item']['name']; ?>" target="_blank">
						<?php if ($this->_var['deal_cate_item']['adv_image']): ?>
							<img src="<?php 
$k = array (
  'name' => 'get_spec_image',
  'v' => $this->_var['deal_cate_item']['adv_image'],
);
echo $k['name']($k['v']);
?>" alt="<?php echo $this->_var['deal_cate_item']['name']; ?>" alt="<?php echo $this->_var['deal_cate_item']['name']; ?>">
						<?php endif; ?>
						<?php if ($this->_var['deal_cate_item']['adv_image'] == null): ?>
							<img src="<?php if ($this->_var['deal_cate_item']['image'] == ''): ?><?php echo $this->_var['TMPL']; ?>/images/empty_thumb.gif<?php else: ?><?php 
$k = array (
  'name' => 'get_spec_image',
  'v' => $this->_var['deal_cate_item']['image'],
);
echo $k['name']($k['v']);
?><?php endif; ?>" alt="<?php echo $this->_var['deal_cate_item']['name']; ?>" alt="<?php echo $this->_var['deal_cate_item']['name']; ?>">
						<?php endif; ?>
					</a>
				</div>
				<div class="con2">
					<!--1-->
					<div class="deal_content_box">
						<div class="blank15"></div>
						<h3><a href="<?php
echo parse_url_tag("u:deal#show|"."id=".$this->_var['deal_cate_item']['id']."".""); 
?>" title="<?php echo $this->_var['deal_cate_item']['name']; ?>" class="deal_title" target="_blank"><?php 
$k = array (
  'name' => 'msubstr',
  'v' => $this->_var['deal_cate_item']['name'],
  'b' => '0',
  'e' => '23',
);
echo $k['name']($k['v'],$k['b'],$k['e']);
?></a></h3>
						<div class="blank20"></div>
						<div class="ui-button theme_bgcolor f20" style="width:214px">
							<a href="<?php
echo parse_url_tag("u:deal#show|"."id=".$this->_var['deal_cate_item']['id']."".""); 
?>" target="_blank">立即支持</a>
						</div>
						<div class="blank5"></div>
						<div class="inf"><span><?php 
$k = array (
  'name' => 'msubstr',
  'v' => $this->_var['deal_cate_item']['brief'],
  'b' => '0',
  'e' => '40',
);
echo $k['name']($k['v'],$k['b'],$k['e']);
?></span></div>
					</div>
					<!--2-->
					<div class="blank15"></div>
					<div class="paiduan" style="height:20px;line-height:20px;">
						<span class="caption-title">目标：<em><?php echo $this->_var['deal_cate_item']['num_days']; ?>天</em> <em><i class="font-yen">¥</i><?php 
$k = array (
  'name' => 'round',
  'v' => $this->_var['deal_cate_item']['limit_price'],
  'e' => '2',
);
echo $k['name']($k['v'],$k['e']);
?></em></span>
						<span class="f_r ">
							<?php if ($this->_var['deal_cate_item']['begin_time'] > $this->_var['now']): ?>
							<span class="common-begin">即将开始</span>
							<?php elseif ($this->_var['deal_cate_item']['end_time'] < $this->_var['now'] && $this->_var['deal_cate_item']['end_time'] != 0): ?>
							 <span  <?php if ($this->_var['deal_cate_item']['percent'] >= 100): ?>class="common-success"<?php else: ?>class="common-fail"<?php endif; ?>>
								<?php if ($this->_var['deal_cate_item']['percent'] >= 100): ?>已成功
								<?php else: ?>筹资失败
								<?php endif; ?>
							</span> 	 
							<?php else: ?>
								<?php if ($this->_var['deal_item']['percent'] >= 100): ?>
									<span class="common-success">已成功</span>
								<?php else: ?>
									<span class="common-sprite">
										<?php if ($this->_var['deal_cate_item']['end_time'] == 0): ?>
											长期项目
										<?php else: ?>
											<?php if ($this->_var['deal_item']['type'] == 1): ?>
											融资中
											<?php else: ?>
											筹资中
											<?php endif; ?>
										<?php endif; ?>
									</span>
								<?php endif; ?>
									
							<?php endif; ?>
						</span>
					</div>
					<div class="blank10"></div>
					<!--3-->
					<div class="deal_content_box">             
					<?php if ($this->_var['deal_cate_item']['begin_time'] > $this->_var['now']): ?>
						<div class="ui-progress">
							<span style="width:<?php echo $this->_var['deal_cate_item']['percent']; ?>%;background:#ffae00;"></span>
						</div>
					<?php elseif ($this->_var['deal_cate_item']['end_time'] < $this->_var['now'] && $this->_var['deal_cate_item']['end_time'] != 0): ?>
						<?php if ($this->_var['deal_cate_item']['percent'] >= 100): ?>				
						<div class="ui-success">
							<span style="width:100%;"></span>
						</div>
						<?php else: ?>
						<div class="ui-progress">
							<span style="width:<?php echo $this->_var['deal_cate_item']['percent']; ?>%;background:#4d4d4f;"></span>
						</div>
						<?php endif; ?>
					<?php else: ?>
							<?php if ($this->_var['deal_item']['percent'] >= 100): ?>
								<div class="ui-success">
									<span style="width:100%;"></span>
								</div>
							<?php else: ?>
								<?php if ($this->_var['deal_cate_item']['end_time'] == 0): ?>
									<div class="ui-progress">
										<span class="theme_bgcolor" style="width:<?php echo $this->_var['deal_cate_item']['percent']; ?>%;"></span>
									</div>
								<?php else: ?>
									<div class="ui-progress">
										<span class="theme_bgcolor" style="width:<?php echo $this->_var['deal_cate_item']['percent']; ?>%;"></span>
									</div>
								<?php endif; ?>	
							<?php endif; ?>
							
							
					<?php endif; ?>
						<div class="blank"></div>
						<?php if ($this->_var['deal_item']['begin_time'] > $this->_var['now']): ?>
							<div class="div3" style="text-align:left; width:100%; text-align:center;">
								<span class="num til">距开始时间还剩<font><?php echo $this->_var['deal_item']['left_begin_days']; ?></font>天</span>
							</div>
						<?php else: ?>
								
						<div class="div3" style="text-align:left;">
							<span class="num"><?php echo $this->_var['deal_cate_item']['percent']; ?>%</span>
							<div class="blank5"></div>
							<span class="til">已达</span>
						</div>
						<div class="div3">
							<span class="num"><font><?php 
$k = array (
  'name' => 'round',
  'v' => $this->_var['deal_cate_item']['support_amount'],
  'e' => '2',
);
echo $k['name']($k['v'],$k['e']);
?></font>元</span>
							<div class="blank5"></div>
							<?php if ($this->_var['deal_cate_item']['type'] == 1): ?>
							<span class="til">已预购</span>
							<?php else: ?>
							<span class="til">已筹资</span>
							<?php endif; ?>
							
							
						</div>
						
						<div class="div3" style="text-align:right;">
						<?php if ($this->_var['deal_cate_item']['begin_time'] > $this->_var['now']): ?>
							<span class="num"><font><?php echo $this->_var['deal_cate_item']['left_days']; ?></font>天</span>
						<?php elseif ($this->_var['deal_cate_item']['end_time'] < $this->_var['now'] && $this->_var['deal_cate_item']['end_time'] != 0): ?>
							<span class="num"><?php if ($this->_var['deal_cate_item']['percent'] > 100): ?><?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['deal_cate_item']['success_time'],
  'f' => 'y/m/d',
);
echo $k['name']($k['v'],$k['f']);
?><?php else: ?><?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['deal_cate_item']['end_time'],
  'f' => 'y/m/d',
);
echo $k['name']($k['v'],$k['f']);
?><?php endif; ?></span>
						<?php else: ?>
							<span class="num">
								<?php if ($this->_var['deal_cate_item']['end_time'] == 0): ?>
								长期项目
								<?php else: ?>
								<font><?php echo $this->_var['deal_cate_item']['remain_days']; ?></font>天
								<?php endif; ?>
							</span>
						<?php endif; ?>	
							<div class="blank5"></div>
							<span class="til">
								<?php if ($this->_var['deal_cate_item']['begin_time'] > $this->_var['now']): ?>
									已经预热
								<?php elseif (( $this->_var['deal_cate_item']['end_time'] < $this->_var['now'] && $this->_var['deal_cate_item']['end_time'] != 0 )): ?>
									结束时间
								<?php else: ?>
									<?php if ($this->_var['deal_cate_item']['end_time'] == 0): ?>
										长期项目
									<?php else: ?>
										剩余时间
									<?php endif; ?>
								<?php endif; ?>
							</span>				
						</div>
						<?php endif; ?>
						<div class="blank1"></div>
					</div>
				</div>
			</div>
			<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</div>
	</div> 
	<script type="text/javascript">jQuery("#getId").slide({effect:"top",delayTime:300});</script>
</div>
<?php endif; ?> 
<!--  选项卡结束  -->

<!--  项目列表开始  -->
<div class="wrap">
	<div class="category" style="display:none;">
		<ul style="float:left">
			<li><a href="<?php
echo parse_url_tag("u:deals|"."r=rec".""); 
?>" target=_blank>推荐项目</a></li>
			<li><a href="<?php
echo parse_url_tag("u:deals|"."r=new".""); 
?>" target=_blank>最新上线</a></li>
			<li><a href="<?php
echo parse_url_tag("u:deals|"."r=nend".""); 
?>" target=_blank>即将结束</a></li>
			<li><a href="<?php
echo parse_url_tag("u:deals|"."r=classic".""); 
?>" target=_blank>经典项目</a></li>
		</ul>
		<ul class="tab-nav" style="float:right">
			<?php $_from = $this->_var['cate_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cate_item');$this->_foreach['address'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['address']['total'] > 0):
    foreach ($_from AS $this->_var['cate_item']):
        $this->_foreach['address']['iteration']++;
?>
				<?php if ($this->_foreach['address']['iteration'] < 11): ?>
					<li><?php if ($this->_var['cate_item']['pid'] == 0): ?><a href="<?php
echo parse_url_tag("u:deals|"."id=".$this->_var['cate_item']['id']."".""); 
?>" title="<?php echo $this->_var['cate_item']['name']; ?>" target=_blank><?php echo $this->_var['cate_item']['name']; ?></a><?php endif; ?></li>
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
	</div>
	<div class="blank"></div>
	<?php if ($this->_var['deal_list']): ?>
	<h3 class="wrap index_title">
	 	<span>产品众筹</span>
	 	<a href="<?php
echo parse_url_tag("u:deals|"."".""); 
?>" target="_blank" class="f_r">查看更多</a>
	</h3>
	<div class="blank"></div>
	<div id="pin_box">
		<?php echo $this->fetch('inc/deal_list.html'); ?>
	</div>
	<div class="blank20"></div>
	<?php endif; ?>
	<?php if ($this->_var['deal_list_invest']): ?>
	<h3 class="wrap index_title">
	 	<span>股权众筹</span>
	 	<a href="<?php
echo parse_url_tag("u:deals|"."type=1".""); 
?>" target="_blank" class="f_r">查看更多</a>
	</h3>
	<div class="blank"></div>
	<div id="pin_box">
		<?php echo $this->fetch('inc/deal_list_invest.html'); ?>
	</div>
	<?php endif; ?>
 </div>
<!--  项目列表结束  -->
<div class="blank30"></div>
<!--梦想开始的地方开始-->
<div class="support">
	<div class="blank"></div>
    <div class="wrap" style="position:relative;">  
    <a href="<?php if (app_conf ( "INVEST_STATUS" ) == 0): ?><?php
echo parse_url_tag("u:deals|"."".""); 
?><?php endif; ?><?php if (app_conf ( "INVEST_STATUS" ) == 1): ?><?php
echo parse_url_tag("u:deals|"."".""); 
?><?php endif; ?><?php if (app_conf ( "INVEST_STATUS" ) == 2): ?><?php
echo parse_url_tag("u:deals|"."".""); 
?>&type=1<?php endif; ?>" target='_blank' class="ckgd">查看更多项目</a>
    <div class="mod-title" style="width:450px;margin:30px auto;text-align:center;line-height: 40px;">
           
		    <span style="font-size:36px;color:#766262;">梦想开始的地方</span></br>
           <span style="font-size:19px;color:#969595;"> 手里有闲钱不知道怎么花，支持这些有趣的项目</span>
        </div>
        <div class="support-con clearfix">
            <ul class="support-big clearfix">
                <li>
                	<a href="<?php
echo parse_url_tag("u:project#choose|"."".""); 
?>" alt="点击查看创业者指南" title="点击查看创业者指南" target="_blank">
						<span class="icon-sup mx_1"></span>
						<div class="blank10"></div>
						<h3>我有项目</h3>
						<div class="blank5"></div>
						<p><span>点击立即发布项目&nbsp;&nbsp;</span><i class="fa fa-arrow-right"></i></p>
					</a>
                </li>
				
                <li>
					<a href="<?php if (app_conf ( "INVEST_STATUS" ) == 0): ?><?php
echo parse_url_tag("u:deals|"."".""); 
?><?php endif; ?><?php if (app_conf ( "INVEST_STATUS" ) == 1): ?><?php
echo parse_url_tag("u:deals|"."".""); 
?><?php endif; ?><?php if (app_conf ( "INVEST_STATUS" ) == 2): ?><?php
echo parse_url_tag("u:deals|"."".""); 
?>&type=1<?php endif; ?>" alt="点击查看投资人手册" title="点击查看投资人手册" target="_blank">
						<span class="icon-sup mx_2"></span>
						<div class="blank10"></div>
						<h3>我想投资</h3>
						<div class="blank5"></div>
						<p><span>点击查看所有项目&nbsp;&nbsp;</span><i class="fa fa-arrow-right"></i></p>
					</a>
                </li>
                <li>
					<a href="<?php
echo parse_url_tag("u:faq|"."".""); 
?>" alt="点击查看新手手册" title="点击查看新手手册" target="_blank">
						<span class="icon-sup mx_3"></span>
						<div class="blank10"></div>
						<h3>新手指南</h3>
						<div class="blank5"></div>
						<p><span>点击查看新手手册&nbsp;&nbsp;</span><i class="fa fa-arrow-right"></i></p>
					</a>
                </li>
                <li>
					<a href="javascript:void(0);" alt="待开放" onclick="$.showSuccess('新功能敬请期待');" title="待开放">
						<span class="icon-sup mx_4"></span>
						<div class="blank10"></div>
						<h3>待开放</h3>
						<div class="blank5"></div>
						<p><span>--------&nbsp;&nbsp;</span><i class="fa fa-arrow-right"></i></p>
					</a>
                </li>               
            </ul>
			<div style="float:left;border-right:1px solid #dbdbdb;height:135px;width:20px;margin-top:15px;"></div>
            <ul class="support-sm clearfix" style="float:right;">
                <li>
                	<a>
                		<span class="icon-sup mxr_3"></span>
                		<div class="support-sm-r f_r">
		                    <h3>项目总数</h3>
	                    	<span class="number red"><?php echo $this->_var['virtual_effect']; ?><em>个</em></span>	
                		</div>
                	</a>
                </li>
                <li>
                	<a>
                		<span class="icon-sup mxr_2"></span>
                		<div class="support-sm-r f_r">
		                    <h3>累计支持人</h3>
		                    <span class="number violet"><?php echo $this->_var['virtual_person']; ?><em>人</em></span>
	                    </div>
                	</a>
                	
                </li>
                <li>
                	<a>
                		<span class="icon-sup mxr_1"></span>
                		<div class="support-sm-r f_r">
		                    <h3>累计筹资金额</h3>
		                    <span class="number yellow"><em>¥</em><?php echo $this->_var['virtual_money']; ?></span>
		                </div>
                	</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!--梦想开始的地方结束-->
<div id="gotop" style="display: block;z-index:99;"></div>
<?php echo $this->fetch('inc/footer.html'); ?> 