﻿ <?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author sonnk
 * @copyright 2017
 */

class Emptimekeeping extends CI_Controller {
	var $login;
    function __construct() {
        parent::__construct();
        $this->load->model(array('login_model','base_model','excel_model'));
		$this->login = $this->site->getSession('glogin');
		$this->route = $this->router->class;
    }
    function _remap($method, $params = array()) {
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        }
        $this->_view();
    }
    function _view() {
		$data = new stdClass();
        $login = $this->login;
        if (!isset($login['id'])){
			redirect(base_url());
		}
		$permission = $this->base_model->getPermission($this->login, $this->route);
        if(!isset($permission['view'])) {
            redirect('authorize');
        }
		$data->permission = $permission;
        $data->routes = $this->route; 
        $data->groupid = $login['groupid'];
		$data->departments = $this->base_model->getDepartment($login['departmentid']);
		$data->positions = $this->base_model->getPosition('');
		$data->departmentGroups = $this->base_model->getDepartmentGroup($login['departmentid']);
		$data->employees = '';
		$datenow = gmdate(configs('cfdate'), time() + 7 * 3600);
		$data->datenow =$datenow;
		$dateStart =  gmdate('Y-m', time() + 7 * 3600).'-01';
		$data->time_start = date(configs('cfdate'), strtotime($dateStart));
		
		#gegion add log
		$ctrol = getLanguage('cham-cong-nhan-vien');
		$func =  getLanguage('xem');
		$this->base_model->addAcction($ctrol,$func,'','');
		#end	
        $content = $this->load->view('view', $data, true);
        $this->site->write('content', $content, true);
        $this->site->render();
    }
	function form(){
		$login = $this->login;
		$id = $this->input->post('id');
		$find = $this->model->findID($id);
		$tb = $this->base_model->loadTable();
		if(empty($find->id)){
			$find = $this->base_model->getColumns($tb['hre_timesheets']);
		}
		$employeeid = $find->employeeid;
		$items = $this->model->table($tb['hre_employee'])->select('id,code,fullname')
								 ->where('id',$employeeid)
								 ->find();
		$data = new stdClass();
        $result = new stdClass();
		$data->finds = $find;  
		if(!empty($items->id)){
			$data->code = $items->code;  
			$data->fullname = $items->fullname;  
		}
		else{
			$data->code ='';  
			$data->fullname = '';  
		}
		if(empty($id)){
			$result->title = getLanguage('cham-cong');
		}
		else{
			$result->title = getLanguage('sua-cham-cong');
		}
		$data->employees = $this->base_model->getEmployees($login);
		$data->departments = $this->base_model->getDepartment($login['departmentid']);
		$data->branchid = $login['branchid'];
        $result->content = $this->load->view('form', $data, true);
		$result->id = $id;
        echo json_encode($result);
	}
    function getList() {
        $permission = $this->base_model->getPermission($this->login, $this->route);
        if (!isset($permission['view'])) {
            //redirect('authorize');
        }
        $rows = 20; //$this->site->config['row'];
        $page = $this->input->post('page');
        $pageStart = $page * $rows;
        $rowEnd = ($page + 1) * $rows;
        $start = empty($page) ? 1 : $page + 1;
		$searchs = json_decode($this->input->post('search'), true);
		$index = $this->input->post('index');
        $order = $this->input->post('order');
		if(!empty($order)) {
            $order = str_replace('ord_', '', $order);
        }
		$searchs['index'] = $index;
        $searchs['order'] = $order;
	    
        $data = new stdClass();
        $result = new stdClass();
        $query = $this->model->getList($searchs, $page, $rows);
        $count = $this->model->getTotal($searchs);
        $data->datas = $query;
        $data->start = $start;
        $data->permission = $this->base_model->getPermission($this->login, $this->route);
        $page_view = $this->site->pagination($count, $rows, 5, $this->route, $page);
		if($count <= $rows){
			$page_view = '';
		}
		
        $result->paging = $page_view;
        $result->csrfHash = $this->security->get_csrf_hash();
        $result->viewtotal = $count;
        $result->content = $this->load->view('list', $data, true);
        echo json_encode($result);
    }
	function export(){
		$search = '{}';
		if(isset($_GET['search'])){
			$search = $_GET['search'];
		}
		$searchs = json_decode($search,true);
		include(APPPATH . 'libraries/excel2013/PHPExcel/IOFactory' . EXT);
		
		$versionExcel = 'Excel2007';
		$objPHPExcel = new PHPExcel();
		$sheetIndex = $objPHPExcel->setActiveSheetIndex(0);
		$sheetIndex->setTitle('nha vien di lam');
		
		$sheetIndex->setCellValueByColumnAndRow(0, 1, getLanguage('stt'));
		$sheetIndex->setCellValueByColumnAndRow(1, 1, getLanguage('ma-nhan-vien'));
		$sheetIndex->setCellValueByColumnAndRow(2, 1, getLanguage('ho-ten'));
		$sheetIndex->setCellValueByColumnAndRow(3, 1, getLanguage('thoi-gian-vao'));
		$sheetIndex->setCellValueByColumnAndRow(4, 1, getLanguage('thoi-gian-ra'));
		$sheetIndex->setCellValueByColumnAndRow(5, 1, getLanguage('phong-ban'));
		$sheetIndex->setCellValueByColumnAndRow(6, 1, getLanguage('chu-vu'));
		$sheetIndex->setCellValueByColumnAndRow(7, 1, getLanguage('to-nhom'));
		$query = $this->model->getList($searchs, 0, 0);

		$i=2;
		foreach($query as $item){
			
			
			$sheetIndex->setCellValueByColumnAndRow(0, $i, ($i-1));
			$sheetIndex->setCellValueByColumnAndRow(1, $i, $item->code);
			$sheetIndex->setCellValueByColumnAndRow(2, $i, $item->fullname);
			$sheetIndex->setCellValueByColumnAndRow(3, $i, date(configs('cfdate').' H:i:s',strtotime($item->time_start)));
			$sheetIndex->setCellValueByColumnAndRow(4, $i, date(configs('cfdate').' H:i:s',strtotime($item->time_end)));
			$sheetIndex->setCellValueByColumnAndRow(5, $i, $item->departmanet_name);
			$sheetIndex->setCellValueByColumnAndRow(6, $i, $item->position_name);
			$sheetIndex->setCellValueByColumnAndRow(7, $i, $item->departmentgroup_name);

			$i++;
		}
		$today = gmdate("ymdHis", time() + 7 * 3600);;
        $name = "NV_Dilam_".$today.".xlsx";
        $boderthin = "A1:H" .($i-1);
        $sheetIndex->getStyle($boderthin)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $this->excel_model->exportExcel($objPHPExcel, $versionExcel, $name);
	}
	function save() {
        $token = $this->security->get_csrf_hash();
        $permission = $this->base_model->getPermission($this->login, $this->route);
		$id = $this->input->post('id');
        if (!isset($permission['view'])) {
            redirect('authorize');
        }
        if (!isset($permission['add'])) {
            $result['status'] = 0;
            $result['csrfHash'] = $token;
            echo json_encode($result);
            exit;
        }
        $array = json_decode($this->input->post('search'), true);
		
        $login = $this->login;
        $array['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
        $array['usercreate'] = $login['userlogin'];
        //$array['ipcreate'] = $this->base_model->getMacAddress();
		
        $result['status'] = $this->model->saves($array,$id);
		#region logfile
		$ctrol = getLanguage('cham-cong-nhan-vien');
		$func =  getLanguage('cham-cong').': '.$array['employeeid'];
		$this->base_model->addAcction($ctrol,$func,'','');	
		#end
		
        $result['csrfHash'] = $token;
        echo json_encode($result);
    }
	function edit() {
        $token = $this->security->get_csrf_hash();
        $permission = $this->base_model->getPermission($this->login, $this->route);
		$id = $this->input->post('id');
        if (!isset($permission['view'])) {
            redirect('authorize');
        }
        if (!isset($permission['edit'])) {
            $result['status'] = 0;
            $result['csrfHash'] = $token;
            echo json_encode($result);
            exit;
        }
        $array = json_decode($this->input->post('search'), true);
		
        $login = $this->login;
        $array['dateupdate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
        $array['userupdate'] = $login['userlogin'];
		$findID = $this->model->findID($id);
        $result['status'] = $this->model->edits($array,$id);
		$findIDEnd = $this->model->findID($id);
		#region logfile
		$ctrol = getLanguage('cham-cong');
		$func =  getLanguage('sua').': '.$array['employeeid'];
		$this->base_model->addAcction($ctrol,$func,json_encode($findID),json_encode($findIDEnd));	
		#end
        $result['csrfHash'] = $token;
        echo json_encode($result);
    }
    function deletes() {
        $token = $this->security->get_csrf_hash();
        $id = $this->input->post('id');
        $permission = $this->base_model->getPermission($this->login, $this->route);
        if (!isset($permission['view'])) {
            redirect('authorize');
        }
        if (!isset($permission['delete'])) {
            $result['status'] = 0;
            $result['csrfHash'] = $token;
            echo json_encode($result);
            exit;
        }
		$tb = $this->base_model->loadTable();
		$sql = "
			SELECT group_concat(ts.employeeid) employeeid
				FROM `".$tb['hre_timesheets']."` ts where id in ($id);
		";
		$query = $this->model->query($sql)->execute();
		$employeeid = 0;
		if(!empty($query->employeeid)){
			$employeeid = $query->employeeid;
		}
		$sql2 = "
			select group_concat(e.`code`) code
			from `".$tb['hre_employee']."` e
			where e.id in ($employeeid)
		";
		$querys = $this->model->query($sql2)->execute();
		$code = '';
		if(!empty($query->code)){
			$code = $query->code;
		}
		
        $login = $this->login;
        $this->model->table($tb['hre_timesheets'])->where("id in ($id)")->delete();
        $result['status'] = 1;
        $result['csrfHash'] = $token;
		#region logfile
		$ctrol = getLanguage('cham-cong-nhan-vien');
		$func =  getLanguage('xoa').': '.$code;
		$this->base_model->addAcction($ctrol,$func,'','');	
		#end
        echo json_encode($result);
    }
	function getEmployee(){
		$login = $this->login;
		$departmentid = $this->input->post('departmentid');
		$employees = $this->base_model->getEmployees($login,$departmentid);
		$html = '<select id="input_employeeid" class="form-control form-input select2me" name="input_employeeid" data-placeholder="'.getLanguage('chon-nhan-vien').'"><option value=""></option>';
		foreach($employees as $item){
			$html.= '<option value="'.$item->id .'">'.$item->code .'- '.$item->fullname .'</option>';
		}
		$html.= '</select>';
		echo $html;
	}
}