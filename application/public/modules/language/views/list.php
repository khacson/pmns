
<?php 	$i = $start;
foreach ($datas as $item){ 
	$id = $item->id;
	?>
	<tr class="content edit" id="<?=$id;?>" >
		<td class="text-center">
			<input id="<?=$id;?>" class="check noClick" type="checkbox" value="<?=$id; ?>" name="keys[]">
		</td>
		<td class="text-center"><?=$i;?></td>
		<td class="langkey"><?=$item->langkey;?></td>
		<td class="langname"><?=$item->langname;?></td>
		<td class="text-center">
			<img width="60" height="40" src="<?=base_url();?>files/lang/<?=$item->image;?>" />
		</td>
		<td></td>
	</tr>

<?php $i++;}?>
