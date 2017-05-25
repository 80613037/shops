<style>
	.db .bdshare-button-style0-16 {float:left;}
	.db .bdshare-button-style0-16 a , .db .bdshare-button-style0-16 .bds_more {padding-left:0; background-image:none; margin-top:0;}
	.bdshare-button-style0-16 a:hover {filter:alpha(opacity=100); opacity:1;}
	.foot-logo img{width:90px; height:90px;}
</style>
<!--footer static-->
<div class="footer" pbid="footer" id="J_footer">
	<!--footer section start-->
	<div class="footer-section">
		<div class="footer-wrap">
			<!--footer map start-->
			<div class="foot-map">

			</div>
		</div>
	</div>
	<div class="blank"></div>
	<!--footer section start-->
	<div class="footer-copy ">
		<div class="footer-wrap">
			 <?php $_from = $this->_var['g_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'links');if (count($_from)):
    foreach ($_from AS $this->_var['links']):
?>
			<div class="ft-links">
				<div class="g_links <?php if ($this->_var['links']['type'] == 1): ?>g_imglinks<?php endif; ?>">
					<span class="f_l" <?php if ($this->_var['links']['type'] == 1): ?>style="height:30px;line-height:30px"<?php endif; ?>><?php echo $this->_var['links']['name']; ?>：</span>
					<div class="g_links_text f_l">
						<?php $_from = $this->_var['links']['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'g_links');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['g_links']):
?>
							<?php if ($this->_var['key'] == 2): ?>
							|
							<?php endif; ?>
							<?php if ($this->_var['links']['type'] == 1): ?>
							<?php if ($this->_var['g_links']['img']): ?>
							<a href="<?php echo $this->_var['g_links']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['g_links']['img']; ?>" alt="<?php echo $this->_var['g_links']['name']; ?>" height=30></a>
 							<?php endif; ?>
							<?php else: ?>
							<?php if ($this->_var['g_links']['name']): ?>
							<a href="<?php echo $this->_var['g_links']['url']; ?>" target="_blank"><?php echo $this->_var['g_links']['name']; ?></a>
							<?php endif; ?>
							<?php endif; ?>


						<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					</div>
				</div>
			</div>
			<div class="blank10"></div>
			 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		resetWindowBox();
	});
</script>
</body>
</html>