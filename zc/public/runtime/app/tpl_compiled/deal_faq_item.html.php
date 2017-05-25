<div class="faq_item">
	<div class="faq_item1">
		<input type="text" value="<?php if ($this->_var['faq_item']['question'] != ''): ?><?php echo $this->_var['faq_item']['question']; ?><?php endif; ?>" class="pro_lf textbox" name="question[]" />&nbsp;&nbsp;
		<span class="holder_tip">请输入问题</span>
		<span ><a href="javascript:void(0);" onclick='del_faq(this);' class="setmid se">删除</a></span>
	</div>
	<div class="blank5"></div>
	<div class="faq_item1">
		<textarea name="answer[]" class="textareabox w350 textbox"><?php if ($this->_var['faq_item']['answer'] != ''): ?><?php echo $this->_var['faq_item']['answer']; ?><?php endif; ?></textarea>
		<span class="holder_tip">请输入问题</span>
	</div>
</div>
<div class="blank10"></div>
<script type="text/javascript">
	$(function(){
		show_tip();
	});
</script>