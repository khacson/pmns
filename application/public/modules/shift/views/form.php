<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('ca-lam-viec');?> (<span class="red">*</span>)</label>
			<div class="col-md-8">
				<input type="text" name="input_shift_name"  id="input_shift_name" class="form-input form-control tab-event" 
				value="<?=$finds->shift_name;?>"  placeholder=""
				/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('dau-ca');?> </label>
			<div class="col-md-8">
				<input type="text" name="input_time_star"  id="input_time_star" class="form-input form-control tab-event" value="<?=$finds->time_star;?>"  placeholder="H:i"/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('cuoi-giua-ca');?> </label>
			<div class="col-md-8">
				<input type="text" name="input_time_end_am"  id="input_time_end_am" class="form-input form-control tab-event" value="<?=$finds->time_end_am;?>"  placeholder="H:i" />
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('dau-giua-ca');?> </label>
			<div class="col-md-8">
				<input type="text" name="input_time_star_pm"  id="input_time_star_pm" class="form-input form-control tab-event" value="<?=$finds->time_star_pm;?>"  placeholder="H:i"/>
			</div>
		</div>
	</div>
	<div class="col-md-12 mtop10">
		<div class="form-group">
			<label class="control-label col-md-4"><?=getLanguage('cuoi-ca');?> </label>
			<div class="col-md-8">
				<input type="text" name="input_time_end"  id="input_time_end" class="form-input form-control tab-event" value="<?=$finds->time_end;?>"  placeholder="H:i" />
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
		$('#input_shift_name').select();
	}
</script>
