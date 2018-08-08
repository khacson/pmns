<style title="" type="text/css">
	table col.c1 { width: 45px; }
	table col.c2 { width: 45px; }
	table col.c3 { width: 120px; }
	table col.c4 { width: 100px; }
	table col.c5 { width: 150px; }
	table col.c6 { width: 100px; }
	table col.c7 { width: 110px; }
	table col.c8 { width: 110px; }
	table col.ccallowances { width: 100px; }
	table col.caction { width: 100px; }
	table col.nc { width: 100px; }
	table col.ltl { width: 100px; }
	table col.cauto { width: auto;}
</style>

<div class="box">
	<div class="box-header with-border">
	  <?=$this->load->inc('breadcrumb');?>
	  <div class="box-tools pull-right">
		<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Đóng">
		  <i class="fa fa-minus"></i></button>
		<!--<button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
		  <i class="fa fa-times"></i></button>-->
	  </div>
	</div>
	<div class="box-body">
	    <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4" style="white-space:nowrap"><?=getLanguage('ma-nhan-vien');?></label>
					<div class="col-md-8">
						<input type="text" name="code" id="code" placeholder="" class="searchs form-control" required />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4" style="white-space:nowrap"><?=getLanguage('ho-ten')?></label>
					<div class="col-md-8">
						<input type="text" name="fullname" id="fullname" placeholder="" class="searchs form-control" required />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4" style="white-space:nowrap"><?=getLanguage('cmnd')?></label>
					<div class="col-md-8">
						<input type="text" name="identity" id="identity" placeholder="" class="searchs form-control" required />
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('phong-ban')?></label>
					<div class="col-md-8">
						<select class="combos" id="departmentid" name="departmentid">
							<?php foreach($departments as $item){?>
							<option value="<?=$item->id;?>"><?=$item->departmanet_name;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-md-4"><?=getLanguage('ky-luong')?></label>
					<div class="col-md-8">
						<select id="endoffmonthid" name="endoffmonthid" class="combos" >
							<option value=""></option>
							<?php $i=1; foreach($endoffmonths as $item){?>
							<option <?php if($i==1){?> selected <?php }?> value="<?=$item->id;?>"><?=$item->monthyear;?></option>
							<?php $i++;}?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row mtop10"></div>
	</div>
</div>
<div class="box">
	<div class="box-header with-border">
	  <div class="brc"><?=getLanguage('tim-thay');?> <span class="semi-bold viewtotal">0</span> <?=getLanguage('nhan-vien');?></div>

	  <div class="box-tools pull-right">
		   <ul class="button-group pull-right btnpermission">
				<li id="search">
					<button class="button">
						<i class="fa fa-search"></i>
						<?=getLanguage('tim-kiem');?>
					</button>
				</li>
				<li id="refresh" >
					<button class="button">
						<i class="fa fa-refresh"></i>
						<?=getLanguage('lam-moi');?>
					</button>
				</li>
				<?php if(isset($permission['add'])){?>
				<li id="save" data-toggle="modal" data-target="#myModalFrom">
					<button class="button" >
					<i class="fa fa-plus"></i>
					<?=getLanguage('them-moi');?>
					</button>
				</li>
				<?php }?>
				<?php if(isset($permission['edit'])){?>
				<li id="edit" data-toggle="modal" data-target="#myModalFrom">
					<button class="button">
						<i class="fa fa-save"></i>
						<?=getLanguage('sua');?>
					</button>
				</li>
				<?php }?>
				<?php if(isset($permission['add'])){?>
				<li id="copy">
					<button class="button" >
					<i class="fa fa-files-o"></i>
					<?=getLanguage('copy');?>
					</button>
				</li>
				<?php }?>
				<?php if(isset($permission['delete'])){?>
				<li id="delete">
					<button type="button" class="button">
						<i class="fa fa-times"></i>
						<?=getLanguage('xoa');?>
					</button>
				</li>
				<?php }?>
				
			</ul>	
	  </div>
	</div>
	<div class="box-body">
	     <div id="gridview" >
		 <!--header-->
		 <div id="cHeader">
			<div id="tHeader">    	
				<table width="100%" cellspacing="0" border="1" class="table ">
					<?php 
					for($i=1; $i< 9; $i++){?>
						<col class="c<?=$i;?>">
					<?php }?>
					<?php foreach($allowances as $item){?>
						<col class="ccallowances">
					<?php }?>
					<col class="caction">
					<col class="caction">
					<col class="caction">
					<col class="caction">
					<col class="cauto">
					<tr>
						<th><input type="checkbox" id="checkAll" autocomplete="off" /></th>
						<th><?=getLanguage('stt');?></th>
						<th id="ord_d.departmanet_name"><?=getLanguage('phong-ban');?></th>
						<th id="ord_e.code"><?=getLanguage('ma-nhan-vien');?></th>
						<th id="ord_e.fullname"><?=getLanguage('ho-ten');?></th>
						<th id="ord_e.endoffmonthid"><?=getLanguage('ky-luong');?></th>
						<th id="ord_r.othercollect_money"><?=getLanguage('luong-co-ban');?></th>
						<?php foreach($allowances as $item){?>
						<th id=""><?=$item->allowance_name;?></th>
						<?php }?>
						<th id=""><?=getLanguage('tong-cong');?></th>
						<th><?=getLanguage('ngay-cong');?></th>
						<th><?=getLanguage('thuc-lanh');?></th>
						<th><?=getLanguage('loai-luong');?></th>
						<th></th>
						<th></th>
					</tr>
				</table>
			</div>
		</div>
		<!--end header-->
		<!--body-->
		<div id="data">
			<div id="gridView">
				<table id="group"  width="100%" cellspacing="0" border="1">
					<?php 
					for($i=1; $i< 9; $i++){?>
						<col class="c<?=$i;?>">
					<?php }?>
					<?php foreach($allowances as $item){?>
						<col class="ccallowances">
					<?php }?>
					<col class="caction">
					<col class="caction">
					<col class="caction">
					<col class="caction">
					<col class="cauto">
					<tbody id="grid-rows"></tbody>
				</table>
			</div>
		</div>
		<!--end body-->
	 </div>
	 <div class="">
		<div class="fleft" id="paging"></div>
	 </div>
	</div>
</div>
<!-- END grid-->
<div class="loading" style="display: none;">
	<div class="blockUI blockOverlay" style="width: 100%;height: 100%;top:0px;left:0px;position: absolute;background-color: rgb(0,0,0);opacity: 0.1;z-index: 1000;">
	</div>
	<div class="blockUI blockMsg blockElement" style="width: 30%;position: absolute;top: 15%;left:35%;text-align: center;">
		<img src="<?=url_tmpl()?>img/preloader.gif" style="z-index: 2;position: absolute;"/>
	</div>
</div> 
<!-- ui-dialog -->
<!--S Modal -->
<div id="myModalFrom" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:850px;">
    <!-- Modal content-->
    <div class="modal-content ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modalTitleFrom"></h4>
      </div>
      <div id="loadContentFrom" class="modal-body">
      </div>
      <div class="modal-footer">
		 <button id="actionSave" type="button" class="btn btn-info" ><i class="fa fa-save" aria-hidden="true"></i>  <?=getLanguage('luu');?></button>
        <button id="close" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> <?=getLanguage('dong');?></button>
      </div>
    </div>
  </div>
</div>
<!--E Modal -->
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title"><?=getLanguage('bang-luong-chi-tiet');?></h4>
		</div>
		<div id="loadContent" class="modal-body">
		</div>
		<div class="modal-footer">
			<button id="printSalary" type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-print"></i> <?=getLanguage('in');?></button>			
			<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> <?=getLanguage('dong');?></button>
		</div>
    </div>
  </div>
</div>
<!--E Modal -->
<input type="hidden" name="id" id="id" />
<script>
	var controller = '<?=base_url().$routes;?>/';
	var table;
	var cpage = 0;
	var search;
	var routes = '<?=$routes;?>';
	$(function(){	
		init();
		//refresh();
		searchList();	
		$("#search").click(function(){
			$(".loading").show();
			searchList();	
		});
		$("#refresh").click(function(){
			$(".loading").show();
			refresh();
		});
		$("#export").click(function(){
			search = getSearch(); 
			window.location = controller+'export?search='+search;
		});
		$('#save').click(function(){
			$('#id').val('');
			loadForm();
		});
		$('#edit').click(function(){
			var id = $('#id').val();
			if(id == ''){
				warning(cldcs);
				return false;
			} 
			loadForm(id);
		});
		$("#delete").click(function(){
			var id = getCheckedId();
			if(id == ''){ return false;}
			confirmDelete(id);
			return false
		});
		$(document).keypress(function(e) {
			 var id = $("#id").val();
			 if (e.which == 13) {
				  if(id == ''){
					  save('','save');
				  }
				  else{
					  save(id,'edit');
				  }
			 }
		});
		$('#actionSave').click(function(){
			save();
		});
	});
	function loadForm(id){
		$.ajax({
			url : controller + 'form',
			type: 'POST',
			async: false,
			data:{id:id},  
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$('#loadContentFrom').html(obj.content);
				$('#modalTitleFrom').html(obj.title);
				$('#input_reward_content').select();
				$('#id').html(obj.id);
			}
		});
	}
	function save(id,func){
		var id = $('#id').val(); 
		var func = 'save';
		if(id != ''){
			func = 'edit';
		}
		
		var search = getFormInput(); 
		var obj = $.evalJSON(search); 
		if(obj.employeeid == ""){
			warning('<?=getLanguage('nhan-vien-khong-duoc-trong');?>'); 
			return false;		
		}
		if(obj.salary == ""){
			warning('<?=getLanguage('luong-co-ban-khong-duoc-trong');?>'); 
			return false;		
		}
		var allowance = getAllowance();
		$('.loading').show();
		var data = new FormData();
		//var objectfile2 = document.getElementById('profileAvatar').files;
		//data.append('avatarfile', objectfile2[0]);
		//data.append('csrf_stock_name', token);
		data.append('search', search);
		data.append('allowance', allowance);
		data.append('id',id);
		$.ajax({
			url : controller + func,
			type: 'POST',
			async: false,
			data:data,
			enctype: 'multipart/form-data',
			processData: false,  
			contentType: false,   
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$('.loading').hide();
				if(obj.status == 0){
					if(id == ''){
						error(tmktc); return false;	
					}
					else{
						error(sktc); return false;	
					}
				}
				else if(obj.status == -1){
					error(dldtt); return false;		
				}
				else{
					if(id == ''){
						success(tmtc); 
					}
					else{
						success(stc); 
					}
					refresh();
				}
			},
			error : function(){
				$('.loading').hide();
				if(id == ''){
					error(tmktc); return false;	
				}
				else{
					error(sktc); return false;	
				}
			}
		});
	}
	function init(){
		$('#departmentid').multipleSelect({
			filter: true,
			placeholder:'<?=getLanguage('chon-phong-ban')?>',
			single: false
		});
		$('#endoffmonthid').multipleSelect({
			filter: true,
			placeholder:'<?=getLanguage('chon-ky-luong')?>',
			single: true
		});
		
	}
	function funcList(obj){
		$(".edit").each(function(e){
			$(this).click(function(){ 
				var reward_content = $(".reward_content").eq(e).text().trim();
				var othercollect_date  = $(".othercollect_date").eq(e).text().trim();
				var id = $(this).attr('id');
				var departmentid = $(this).attr('departmentid');
				$("#id").val(id);	
				$("#reward_content").val(reward_content);
				$("#othercollect_date").val(othercollect_date);
				$('#departmentid').multipleSelect('setSelects', departmentid.split(','));				
			});
		});	
		$('.edititem').each(function(e){
			$(this).click(function(){
				var id = $(this).attr('id');
				loadForm(id);
			});
		});
		$('.deleteitem').each(function(e){
			$(this).click(function(){
				var id = $(this).attr('id');
				confirmDelete(id);
				return false
			});
		});
	}
	function refresh(){
		$(".loading").show();
		$(".searchs").val("");
		$('#departmentid').multipleSelect('uncheckAll');
		csrfHash = $('#token').val();
		search = getSearch();
		getList(cpage,csrfHash);	
	}
	function searchList(){
		$(".loading").show();
		search = getSearch();
		csrfHash = $('#token').val();
		getList(cpage,csrfHash);	
	}
	
</script>
