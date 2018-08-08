<style title="" type="text/css">
	table col.c1 { width: 50px; }
	table col.c2 { width: 50px; }
	table col.c3 { width: 80px;}
	table col.c4 { width: 150px; }
	table col.c5 { width: 150px; }
	table col.c6 { width: 145px; }
	table col.c7 { width: 200px;}
	table col.c8 { width: 90px; }
	table col.c9 { width: 100px; }
	table col.c10 { width: 130px; }
	table col.c11 { width: 150px; }
	table col.c12 { width: 130px; }
	table col.c13 { width: 180px; }
	table col.c14 { width: 100px; }
	table col.c15 { width: auto;}
	.col-md-4{ white-space: nowrap !important;}
</style>
<?=$this->load->inc('breadcrumb');?>
<div class="box mtop10">
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
					<?php for($i=1; $i< 16; $i++){?>
						<col class="c<?=$i;?>">
					<?php }?>
					<tr>
						<th><input type="checkbox" name="checkAll" id="checkAll" /></th>
						<th><?=getLanguage('stt')?></th>	
						
						<th id="ord_e.code"><?=getLanguage('ma-nhan-vien')?></th>	
						<th id="ord_e.fullname"><?=getLanguage('ho-ten')?></th>
						<th id="ord_al.time_start"><?=getLanguage('thoi-gian-nghi')?></th>
						<th id="ord_al.numberof"><?=getLanguage('so-ngay-nghi')?></th>
						<th id="ord_al.description"><?=getLanguage('ly-do-nghi')?></th>
						<th><?=getLanguage('ngay-phep')?></th>
						<th id="ord_al.approved"><?=getLanguage('duyet')?></th>
						<th id="ord_al.approved_date"><?=getLanguage('ngay-duyet')?></th>
						<th id="ord_al.approved_userid"><?=getLanguage('nguoi-duyet')?></th>
						<th id="ord_al.approved_description"><?=getLanguage('ghi-chu')?></th>
						<th id="ord_d.departmanet_name"><?=getLanguage('phong-ban')?></th>
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
					<?php for($i=1; $i< 16; $i++){?>
						<col class="c<?=$i;?>">
					<?php }?>
					<tr class="row-searach">
						<td></td>
						<td></td>
						<td>
							<input type="text" name="code" id="code" class="searchs form-control " />
						</td>
						<td>
							<input type="text" name="fullname" id="fullname" class="searchs form-control " />
						</td>
						<td>
							<div class="col-md-12" data-date-format="dd/mm/yyyy" style="display:inline-flex; padding-left:0; padding-right:25px;">
								<input style="float:left; text-align:center;" placeholder="Chọn ngày" type="text" id="datecreate" placeholder="dd/mm/yyyy" name="datecreate" class="form-control searchs"  >
								<span class="input-group-btn" >
									<button class="btn default btn-picker datecreateClick" type="button"><i class="fa fa-calendar "></i></button>
								</span>
							</div>
						</td>
						<td>
							<input type="text" name="numberof" id="numberof" class="searchs form-control " />
						</td>
						<td>
							<input type="text" name="description" id="description" class="searchs form-control " />
						</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>
							<select class="combos" id="departmentid" name="departmentid">
								<?php foreach($departments as $item){
									
									?>
								<option value="<?=$item->id;?>"><?=$item->departmanet_name;?></option>
								<?php }?>
							</select>
						</td>
						<td></td>
						<td></td>
					</tr>
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
  <div class="modal-dialog w500">
    <!-- Modal content-->
    <div class="modal-content ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modalTitleFrom"></h4>
      </div>
      <div id="loadContentFrom" class="modal-body">
      </div>
      <div class="modal-footer">
		 <?php if($login['approved_leave'] == 1){?>
		 <?php if(isset($permission['approved'])){?>
			<button id="actionSaveApproved" type="button" class="btn btn-info" ><i class="fa fa-check" aria-hidden="true"></i>  <?=getLanguage('duyet');?></button>
		 <?php }}?>
		 <button id="actionSave" type="button" class="btn btn-info" ><i class="fa fa-save" aria-hidden="true"></i>  <?=getLanguage('luu');?></button>
        <button id="close" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> <?=getLanguage('dong');?></button>
      </div>
    </div>
  </div>
</div>
<!--E Modal -->
<input type="hidden" name="id" id="id" />
<link rel="stylesheet" href="<?=url_tmpl();?>theme/plugins/daterangepicker/daterangepicker.css">
<script type='text/javascript' src="<?=url_tmpl();?>theme/plugins/daterangepicker/daterangepicker.js"></script>
<script>
	var controller = '<?=base_url().$routes;?>/';
	var table;
	var cpage = 0;
	var search;
	var routes = '<?=$routes;?>';
	$(function(){	
		init();
		//refresh();
		$('#datecreate').daterangepicker({
			 locale: {
			  format: 'DD/MM/YYYY'
			},
			timePicker: false,
        	timePickerIncrement: 8,
        	showDropdowns: true,
			startDate: moment().subtract('days', 7),
			endDate: moment()
		});
		$('.datecreateClick').click(function(){
			$('#datecreate').click();
		});
		$('#id').val('');
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
			window.location = controller+'export?search='+search
		});
		$('#save').click(function(){
			$('#id').val('');
			loadForm('',0);
		});
		$('#edit').click(function(){
			var id = $('#id').val();
			if(id == ''){
				warning(cldcs);
				return false;
			} 
			loadForm(id,0);
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
				$(".loading").show();
				searchList();	
			 }
		});
		$('#actionSave').click(function(){
			save();
		});
		$('#actionSaveApproved').click(function(){
			saveApproved();
		});
		searchFunction();
	});
	function searchFunction(){
		$("#fullname").keyup(function() {
			searchList();	
		});
		/*$('#click_date').datepicker().on('changeDate', function (ev) {
			searchList();
		});*/
		$('#datecreate').on('apply.daterangepicker', function(ev, picker) {
			searchList();	
		});
	}
	function loadForm(id,approved){
		$.ajax({
			url : controller + 'form',
			type: 'POST',
			async: false,
			data:{id:id,approved:approved},  
			success:function(datas){
				var obj = $.evalJSON(datas); 
				if(approved == 1){
					$('#actionSave').hide();
					$('#actionSaveApproved').show();
				}
				else{
					$('#actionSave').show();
					$('#actionSaveApproved').hide();
				}
				$('#loadContentFrom').html(obj.content);
				$('#modalTitleFrom').html(obj.title);
				$('#input_ethnic_name').select();
				$('#id').html(obj.id);
			}
		});
	}
	/*function saveApproved(){ 
		var id = $('#id').val(); 
		if(id == ''){
			warning('<?=getLanguage('chon-nhan-vien');?>'); 
			return false;		
		}
		var search = getFormInput();  
		var obj = $.evalJSON(search); 
		if(obj.approved == ""){
			warning('<?=getLanguage('chon-trang-thai');?>'); 
			return false;		
		}
		$('.loading').show();
		var data = new FormData();
		data.append('search', search);
		data.append('id',id);
		$.ajax({
			url : controller + 'saveApproved',
			type: 'POST',
			async: false,
			data:data,
			enctype: 'multipart/form-data',
			processData: false,  
			contentType: false,   
			success:function(datas){
				var obj = $.evalJSON(datas); 
				$('.loading').hide();
				if(obj.status == -10){
					window.location = '<?=base_url();?>authorize';
				}
				if(obj.status == 1){
					success(obj.msg); 
					searchList();
				}
				else{
					error(obj.msg); 
					searchList();
				}
			},
			error : function(){
				error(obj.msg); 
				searchList();
			}
		});
	}*/
	function save(){
		var id = $('#id').val(); 
		var func = 'save';
		if(id != ''){
			func = 'edit';
		}
		var search = getFormInput();
		var obj = $.evalJSON(search); 
		var code = obj.code;
		if(code == ""){
			warning('<?=getLanguage('ma-nhan-vien-hoac-phong-ban-khong-duoc-trong');?>'); 
			return false;		
		}
		if(obj.time_start == ""){
			warning('<?=getLanguage('thoi-gian-bat-dau-khong-duoc-trong');?>'); 
			return false;		
		}
		if(obj.time_end == ""){
			warning('<?=getLanguage('thoi-gian-ket-thuc-khong-duoc-trong');?>'); 
			return false;		
		}
		if(obj.description == ""){
			warning('<?=getLanguage('ly-do-nghi-khong-duoc-trong');?>'); 
			return false;		
		}
		$('.loading').show();
		var data = new FormData();
		data.append('search', search);
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
				if(obj.status == -10){
					window.location = '<?=base_url();?>authorize'; return;
				}
				if(obj.status == 1){
					success(obj.msg); 
					searchList(); return false;
				}
				else{
					error(obj.msg); 
					refresh();
					return false;	
				}
			},
			error : function(){
				$('.loading').hide();
				error("<?=getLanguage('loi');?>"); return false;	
			}
		});
	}
	function init(){
		$('#departmentid').multipleSelect({
			filter: true,
			placeholder:'<?=getLanguage('chon-phong-ban')?>',
			single: false,
			onClick: function(view){
				searchList();
			}
		});
	}
	function funcList(obj){
		$(".edit").each(function(e){
			$(this).click(function(){ 
				var code = $(".code").eq(e).text().trim();
				var fullname = $(".fullname").eq(e).text().trim();
				var identity = $(this).attr('identity');
				var departmentid = $(this).attr('departmentid');
				var id = $(this).attr('id');
				$("#id").val(id);	
				$("#code").val(code);
				$("#fullname").val(fullname);	
				$("#identity").val(identity);	
				$('#departmentid').multipleSelect('setSelects', departmentid.split(','));
			});
		});	
		$('.edititem').each(function(e){
			$(this).click(function(){
				var id = $(this).attr('id');
				var approved = $(this).attr('approved');
				loadForm(id,approved);
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
		$('#datenow').val('<?=$datenow;?>');
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