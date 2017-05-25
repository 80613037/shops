<?php echo $this->fetch('inc/header.html'); ?>
<div id="J_wraps">
	<div class="blank20"></div>
	<?php if (app_conf ( "INVEST_STATUS" ) == 0): ?>
		<div class="project_choose">
			<div class="project_general">
				<span class="f14">
					我有一个梦想，有创意项目，有创意产品，点击发布回报众筹
				</span>
				<div class="blank20"></div>
				<div>
					<a href="<?php
echo parse_url_tag("u:project#index|"."".""); 
?>" class="ui-button bg_red">立即发布产品众筹</a>
				</div>
				
			</div>
			<div class="project_agency">
				<span class="f14">
					我有创业梦想，有融资需求，点击发布股权众筹
				</span>
				<div class="blank20"></div>
				<div>
					<a href="<?php
echo parse_url_tag("u:project#investor_index1|"."".""); 
?>" class="ui-button theme_bgcolor">立即发布股权众筹</a>
				</div>
			</div>	
		</div>
	<?php endif; ?>
	<?php if (app_conf ( "INVEST_STATUS" ) == 1): ?>
		<div class="project_choose">
			<div class="project_general" style="margin:0 auto;float:none">
				<span class="f14">
					您是否需要产品项目，发布产品项目，你可以做些什么呢？
				</span>
				<div class="blank20"></div>
				<div>
					<a href="<?php
echo parse_url_tag("u:project#index|"."".""); 
?>" class="ui-button bg_red">立即发布产品众筹</a>
				</div>
				
			</div>
		</div>
	<?php endif; ?>
	<?php if (app_conf ( "INVEST_STATUS" ) == 2): ?>
		<div class="project_choose">
			<div class="project_agency" style="margin:0 auto;float:none">
				<span class="f14">
					您是否需要股权项目，发布股权项目，你可以做些什么呢？
				</span>
				<div class="blank20"></div>
				<div>
					<a href="<?php
echo parse_url_tag("u:project#investor_index1|"."".""); 
?>" class="ui-button theme_bgcolor">立即发布股权众筹</a>
				</div>
			</div>	
		</div>
	<?php endif; ?>
	<div class="blank20"></div>
</div>
<script type="text/javascript">
	$(function(){
		resetWindowBoxs();
	})
	function resetWindowBoxs(){
		clearTimeout(resetTimeact);
		if($("#J_wraps").outerHeight() + $(".footer").outerHeight() + $(".header").outerHeight() < $(window).height())
		{
			$("#J_wraps").css({"marginTop":($(window).height() - $(".footer").outerHeight() - $(".header").outerHeight()- $("#J_wraps").outerHeight())/2,"marginBottom":($(window).height() - $(".footer").outerHeight() - $(".header").outerHeight()- $("#J_wraps").outerHeight())/2} );
		}
		resetTimeact = setTimeout(resetWindowBoxs,100);
	}
</script>
<?php echo $this->fetch('inc/footer.html'); ?> 