<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('dan-toc');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_ethnic_name"  id="input_ethnic_name" class="form-input form-control tab-event" 
				value="<?=$finds->ethnic_name;?>"
				/>
			</div>
		</div>
	</div>
</div>
<?php
	//print_r($finds);
?>
<script>
	$(function(){
		initForm();
	});
	function initForm(){
		$('#input_ethnic_name').select();
	}
</script>
