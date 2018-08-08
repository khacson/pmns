<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('phong-ban');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_departmanet_name"  id="input_departmanet_name" class="form-input form-control tab-event" 
				value="<?=$finds->departmanet_name;?>"  placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('dien-thoai');?> </label>
			<div class="col-md-8">
				<input type="text" name="input_phone"  id="input_phone" class="form-input form-control tab-event" value="<?=$finds->phone;?>"  placeholder=""/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('fax');?> </label>
			<div class="col-md-8">
				<input type="text" name="input_fax"  id="input_fax" class="form-input form-control tab-event" value="<?=$finds->fax;?>"  placeholder="" />
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('thu-truong');?></label>
			<div class="col-md-8">
				<input type="text" name="input_heads"  id="input_heads" class="form-input form-control tab-event" value="<?=$finds->heads;?>"  placeholder=""/>
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
		$('#input_departmanet_name').select();
	}
</script>
