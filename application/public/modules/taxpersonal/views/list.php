
<?php 	$i = $start;
foreach ($datas as $item){ 
	$id = $item->id;	
	?>
	<tr class="content edit" id="<?=$id;?>" insurance_type="<?=$item->insurance_type;?>">
		<td class="text-center">
			<input id="<?=$id;?>" class="check noClick" type="checkbox" value="<?=$id; ?>" name="keys[]">
		</td>
		<td class="text-center"><?=$i;?></td>
		<td class="from_salary text-right"><?=number_format($item->from_salary);?></td>
		<td class="to_salary text-right"><?=number_format($item->to_salary);?></td>
		<td class="tax text-right"><?=$item->tax;?></td>
		<td class="text-center">
			<?php if(isset($permission['edit'])){?>
				<a id="<?=$id;?>" class="btn btn-info edititem" href="#" data-toggle="modal" data-target="#myModalFrom">
				<i class="fa fa-pencil" aria-hidden="true"></i>
				</a>
			<?php }?>
			<?php if(isset($permission['delete'])){?>
				<a id="<?=$id;?>" class="btn btn-danger deleteitem mleft10" href="#" data-toggle="modal" data-target="#myModal">
				<i class="fa fa-times" aria-hidden="true"></i>
				</a>
			<?php }?>
		</td>
		<td></td>
	</tr>

<?php $i++;}?>
