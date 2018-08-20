<style title="" type="text/css">
	table td{
		padding:6px 10px;
	}
</style>

<div class="box">
	<div class="box-header with-border">
	  <?=$this->load->inc('breadcrumb');?>
	  <div class="box-tools pull-right">
		<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Đóng">
		  <i class="fa fa-minus"></i></button>
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
	  <div class="brc">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
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
						<i class="fa fa-print"></i>
						<?=getLanguage('print');?>
					</button>
				</li>
			</ul>	
	  </div>
	</div>
	<div class="box-body">
		<!--body-->
		<div id="data" style="padding-left:15px; height:auto" class="row">
			<div class="col-md-6" style="padding-right:0;">
				<table width="100%" cellspacing="0" border="1">
					<tr>
						<td>Lương cơ bản:</td>
						<td></td>
					</tr>
					<?php foreach($allowances as $item){?>
					<tr>
						<td><?=$item->allowance_name;?>:</td>
						<td></td>
					</tr>
					<?php }?>
					<tr>
						<td>Các khoản thu khác:</td>
						<td></td>
					</tr>
					<tr>
						<td>Các khoản nợ khác:</td>
						<td></td>
					</tr>
					<tr>
						<td>Lương:</td>
						<td></td>
					</tr>
					<tr>
						<td>Thực lãnh:</td>
						<td></td>
					</tr>
				</table>
			</div>
			<div class="col-md-6">
				<table width="100%" cellspacing="0" border="1">
					<?php foreach($insurance as $item){?>
					<tr>
						<td><?=$item->insurance_name;?>:</td>
						<td></td>
					</tr>
					<?php }?>
					<tr>
						<td>Thuế thu nhập cá nhân:</td>
						<td></td>
					</tr>
					<tr>
						<td>Tổng ngày phép:</td>
						<td></td>
					</tr>
					<tr>
						<td>Số ngày phép đã sử dụng:</td>
						<td></td>
					</tr>
					<tr>
						<td>Số ngày phép còn lại:</td>
						<td></td>
					</tr>
					<tr>
						<td>Số lần đi trễ:</td>
						<td></td>
					</tr>
					<tr>
						<td>Số lần về sớm:</td>
						<td></td>
					</tr>
				</table>
			</div>	
		</div>
		<!--end body-->
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
					  searchList();
				  }
				  else{
					  searchList();
				  }
			 }
		});
	});
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
		$(".loading").hide();
	}
</script>
