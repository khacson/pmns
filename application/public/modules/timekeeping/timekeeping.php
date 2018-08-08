 <?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author sonnk
 * @copyright 2016
 */

class Timekeeping extends CI_Controller {
    var $phonedetail;
	var $login;
    function __construct() {
        parent::__construct();
        $this->load->model(array('login_model','base_model'));
        $this->phonedetail = 'hre_processdetail';
		$this->login = $this->site->getSession('glogin');
		$this->route = $this->router->class;
		$this->load->library('upload');
    }
    function _remap($method, $params = array()) {
        $id = $this->uri->segment(2);
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
		#gegion add log
		$ctrol = getLanguage('phong-ban');
		$func =  getLanguage('xem');
		$this->base_model->addAcction($ctrol,$func,'','');
		#end	
		$data->montNow = $year = gmdate("m/Y", time() + 7 * 3600);
		$data->departments = $this->base_model->getDepartment($login['departmentid']);
		$data->months = $this->model->getMonth();
        $content = $this->load->view('view', $data, true);
        $this->site->write('content', $content, true);
        $this->site->render();
    }
	function form(){
		$login = $this->login;
		$id = $this->input->post('id');
		$find = $this->model->findID($id);
		if(empty($find->id)){
			$find = $this->base_model->getColumns('hre_department');
		}
		$data = new stdClass();
        $result = new stdClass();
		$data->finds = $find;  
		if(empty($id)){
			$result->title = getLanguage('them-moi');
		}
		else{
			$result->title = getLanguage('sua');
		}
		
		$data->branchid = $login['branchid'];
        $result->content = $this->load->view('form', $data, true);
		$result->id = $id;
        echo json_encode($result);
	}
	function getList(){
		$rows = 20; //$this->site->config['row'];
		$page = $this->input->post('page');
        $pageStart = $page * $rows;
        $rowEnd = ($page + 1) * $rows;
		$start = empty($page) ? 1 : $page+1;
		$searchs = json_decode($this->input->post('search'),true);
		$searchs['order'] = substr($this->input->post('order'),4);
		$searchs['index'] = $this->input->post('index');
		$data = new stdClass();
		$result = new stdClass();
		$datas = $this->model->getList($searchs,$page,$rows);
		$count = $this->model->getTotal($searchs);
		$data->datas = $datas;
		$data->start = $start;
		$data->permission = $this->base_model->getPermission($this->login, $this->route);
		$searchmonth = $searchs['month'];
		$login = $this->login;
		$tb = $this->base_model->loadTable();
		$findMonth = $this->model->table($tb['hre_endoffmonth'])
					  ->select('id,monthyear,date_start,date_end')
					  ->where('id',$searchmonth)
					  ->find();
		$fromdate = $findMonth->date_start;
		$todate = $findMonth->date_end;
		//Nay cong nhan vien
		$data->ngaycong = $this->model->table($tb['hre_timesheets_month'])
						 ->select('employeeid,workday')
						 ->where('monthid',$searchmonth)
						 ->where('branchid',$login['branchid'])
						 ->find_combo('employeeid','workday');
		/*
		$arrMonth = explode('_',$searchmonth);
		
		$fromdate = 0;
		if(isset($arrMonth[0])){
			$fromdate = $arrMonth[0];
		}
		$todate = 0;
		if(isset($arrMonth[1])){
			$todate = $arrMonth[1];
		}
		*/
		
		$arrayDate = array(); 
		$arrayDateList = array(); 
		for($i=0;$i<32;$i++){
			$dateNext = date("Y-m-d", strtotime("$fromdate + $i day"));
			$arrayDate[$i] = $dateNext;
			$arrayDateList[$i] = "'".$dateNext."'";
			if($todate == $dateNext){
				break;
			}
		}
		$listDate = implode(',',$arrayDateList);
		//List employee
		$arrEmployee = array(); 
		$arrEmployeeList = array(); 
		foreach($datas as $item){
			$arrEmployee[$item->id]['time_start'] = $item->time_star;
			$arrEmployee[$item->id]['time_end'] = $item->time_end;
			$arrEmployeeList[] = $item->id;
		}
		$listEmployeeID = implode(',',$arrEmployeeList);
		$getCheckIN = $this->model->getCheckIN($listDate,$listEmployeeID,$arrEmployee);
		//Check Vân tay
		$data->timesheets = $this->model->geTimesheets($fromdate,$todate);
		//Nghỉ phép
		$data->nghiphep = $this->model->getNghiPhep($fromdate,$todate);
		//Đi công tác
		$data->dicongtac = $this->model->getDiCongTac($fromdate,$todate);
		//Nghi thai san
		$data->nghithaisan = $this->model->getNghiThaiSan($fromdate,$todate);
		
		$arr_thu = array();
		$arr_thu['monday'] = getLanguage('monday');
		$arr_thu['tuesday'] = getLanguage('tuesday');
		$arr_thu['wednesday'] = getLanguage('wednesday');
		$arr_thu['thursday'] = getLanguage('thursday');
		$arr_thu['friday'] = getLanguage('friday');
		$arr_thu['saturday'] = getLanguage('saturday');
		$arr_thu['sunday'] = getLanguage('sunday');
		
		$data->arr_thu = $arr_thu;
		$data->arrayDate = $arrayDate;
		$page_view=$this->site->pagination($count,$rows,5,$this->route,$page);
		$result->paging = $page_view;
		$result->csrfHash = $this->security->get_csrf_hash();
		$result->viewtotal = number_format($count); 
        $result->content = $this->load->view('list', $data, true);
		echo json_encode($result);
	}
	function workday(){
		$tb = $this->base_model->loadTable();
		$month = $this->input->post('month');
		$login = $this->login;
		$branchid  = $login['branchid'];
		//Danh sach bang cham cong
		$findMonth = $this->model->table($tb['hre_endoffmonth'])
					  ->select('id,monthyear,date_start,date_end,number_days')
					  ->where('id',$month)
					  ->find();
		$fromdate = $findMonth->date_start;
		$todate = $findMonth->date_end;
		//Danh sac ngay cong
		$sqltimeset = "
			SELECT ts.time_start, ts.time_end, s.id, s.time_star as shift_time_star, s.time_end as shift_time_end, s.time_end_am, s.time_star_pm, s.between_shift,
			s.hours_1, s.hours_2,  e.branchid, e.departmentid, ts.employeeid
			FROM `".$tb['hre_timesheets']."` ts
			left join `".$tb['hre_shift']."` s on s.id = ts.shiftid
			left join `".$tb['hre_employee']."` e on e.id = ts.employeeid
			where ts.isdelete = 0
			and ts.branchid = '$branchid'
			and ts.time_start >= '".$fromdate." 00:00:00'
			and ts.time_start <= '".$todate." 23:59:59'
			and ts.time_end >= '".$fromdate." 00:00:00'
			and ts.time_end <= '".$todate." 23:59:59'
			and ts.time_end is not null
			;
		";
		$query = $this->model->query($sqltimeset)->execute();
		$number_days = $findMonth->number_days;
		$array = array();
		foreach($query as $item){
			$time_start = $item->time_start;
			$s_ngaytheoca = date('Y-m-d',strtotime($time_start)).' '.$item->shift_time_star;
			if(strtotime($time_start) < strtotime($s_ngaytheoca)){//Chấm vân tay lúc vào trước giờ làm
				$time_start = $s_ngaytheoca;
			}
			$time_end = $item->time_end;   
			$e_theoca = date('Y-m-d',strtotime($time_end)).' '.$item->shift_time_end;
			if(strtotime($time_end) > strtotime($e_theoca)){//Chấm vân tay lúc ra sau giờ làm
				$time_end = $e_theoca;
			}
			$between_shift = $item->between_shift;
			$thoigianlamviecCangay = $item->hours_1 + $item->hours_2; //Thoi gian duoc thiet lap
			
			$daucacgieu = date('Y-m-d',strtotime($item->time_start)).' '.$item->time_star_pm;
			//Nếu check vân tay vào buổi chiều
			if(strtotime($time_start) > strtotime($daucacgieu)){
				$thoigianlamviec = ((strtotime($time_end) - strtotime($time_start))/3600);
			}
			else{//Làm cả ngày trừ thời gian nghi
				$thoigianlamviec = ((strtotime($time_end) - strtotime($time_start))/3600)-$between_shift;
			}
			if($thoigianlamviec == $thoigianlamviecCangay){
				$thoigian = 1;
			}
			else{
				$thoigian = round(($thoigianlamviec/$thoigianlamviecCangay),2);
			}
			if(isset($array[$item->employeeid])){
				$array[$item->employeeid]+= $thoigian;
			}
			else{
				$array[$item->employeeid] = $thoigian;
			}
		}
		//Tính ngh phép và đi công tac
		$sqlEmpleaveshow = "
			SELECT ts.time_start, ts.time_end, s.id, s.time_star as shift_time_star, s.time_end as shift_time_end, s.time_end_am, s.time_star_pm, s.between_shift,
			s.hours_1, s.hours_2,  e.branchid, e.departmentid, ts.employeeid
			FROM `".$tb['hre_empleaveshow_detail']."` ts
			left join `".$tb['hre_shift']."` s on s.id = ts.shiftid
			left join `".$tb['hre_employee']."` e on e.id = ts.employeeid
			where (ts.statusid = 1 or ts.statusid = 2)
			and ts.branchid = '$branchid'
			and ts.time_start >= '".$fromdate." 00:00:00'
			and ts.time_start <= '".$todate." 23:59:59'
			and ts.time_end >= '".$fromdate." 00:00:00'
			and ts.time_end <= '".$todate." 23:59:59'
			and ts.time_end is not null
			;
		"; 
		$query = $this->model->query($sqlEmpleaveshow)->execute();
		$array2 = array();
		foreach($query as $item){
			$time_start = $item->time_start;
			$s_ngaytheoca = date('Y-m-d',strtotime($time_start)).' '.$item->shift_time_star;
			if(strtotime($time_start) < strtotime($s_ngaytheoca)){//Chấm vân tay lúc vào trước giờ làm
				$time_start = $s_ngaytheoca;
			}
			$time_end = $item->time_end;   
			$e_theoca = date('Y-m-d',strtotime($time_end)).' '.$item->shift_time_end;
			if(strtotime($time_end) > strtotime($e_theoca)){//Chấm vân tay lúc ra sau giờ làm
				$time_end = $e_theoca;
			}
			$between_shift = $item->between_shift;
			$thoigianlamviecCangay = $item->hours_1 + $item->hours_2; //Thoi gian duoc thiet lap
			
			$daucacgieu = date('Y-m-d',strtotime($item->time_start)).' '.$item->time_star_pm;
			//Nếu check vân tay vào buổi chiều
			if(strtotime($time_start) > strtotime($daucacgieu)){
				$thoigianlamviec = ((strtotime($time_end) - strtotime($time_start))/3600);
			}
			else{//Làm cả ngày trừ thời gian nghi
				$thoigianlamviec = ((strtotime($time_end) - strtotime($time_start))/3600)-$between_shift;
			}
			if($thoigianlamviec == $thoigianlamviecCangay){
				$thoigian = 1;
			}
			else{
				$thoigian = round(($thoigianlamviec/$thoigianlamviecCangay),2);
			}
			if($thoigian < 0){
				$thoigian = 0;
			}
			if(isset($array2[$item->employeeid])){
				$array2[$item->employeeid]+= $thoigian;
			}
			else{
				$array2[$item->employeeid] = $thoigian;
			}
		}
		//danh sacnh nhan vien
		$danhsach = $this->model->table($tb['hre_employee'])
								->select('id,departmentid,branchid')
								->where('branchid',$branchid)
								->find_all(); 
		$arrNgaycong = array();
		foreach($danhsach as $item){
			$chamvantay = 0;
			if(isset($array[$item->id])){
				$chamvantay = $array[$item->id];
			}
			if(isset($arrNgaycong[$item->id])){
				$arrNgaycong[$item->id]+= $chamvantay;
			}
			else{
				$arrNgaycong[$item->id] = $chamvantay;
			}
			//nghi pheo cong tac
			$nghiphepcongtac = 0;
			if(isset($array2[$item->id])){
				$nghiphepcongtac = $array2[$item->id];
			}
			if(isset($arrNgaycong[$item->id])){
				$arrNgaycong[$item->id]+= $nghiphepcongtac;
			}
			else{
				$arrNgaycong[$item->id] = $nghiphepcongtac;
			}
		}
		//Lưu dữ liệu vào bảng chốt công
		//Xóa dữ liệu củx
		$this->model->table($tb['hre_timesheets_month'])->where('monthid',$month)->where('branchid',$branchid)->delete();
		foreach($danhsach as $item){
			$workday = 0;
			if(!empty($arrNgaycong[$item->id])){
				$workday = $arrNgaycong[$item->id];
			}
			$insert = array();
			$insert['monthid'] = $month;
			$insert['branchid'] = $branchid;
			$insert['employeeid'] = $item->id;
			$insert['departmentid'] = $item->departmentid;
			$insert['workday'] = $workday;
			$insert['datecreate'] =  gmdate("Y-m-d H:i:s", time() + 7 * 3600);;
			$insert['usercreate'] = $login['userlogin'];
			$this->model->table($tb['hre_timesheets_month'])->insert($insert);
		}
		echo 1;
	}
    /*function save() {
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
		if(isset($_FILES['avatarfile']) && $_FILES['avatarfile']['name'] != "") {
			$imge_name = $_FILES['avatarfile']['name'];
			$this->upload->initialize($this->set_upload_options());
			$image_data = $this->upload->do_upload('avatarfile', $imge_name); //Ten hinh 
			$array['image']  = $image_data;
			$resize = $this->resizeImg($image_data);	
		}
        $login = $this->login;
        $array['datecreate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
        $array['usercreate'] = $login['userlogin'];
        //$array['ipcreate'] = $this->base_model->getMacAddress();
		
        $result['status'] = $this->model->saves($array,$id);
		#region logfile
		$ctrol = getLanguage('phong-ban');
		$func =  getLanguage('them-moi').': '.$array['departmanet_name'];
		$this->base_model->addAcction($ctrol,$func,'','');	
		#end
		
        $result['csrfHash'] = $token;
        echo json_encode($result);
    }*/
	/*
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
		if(isset($_FILES['avatarfile']) && $_FILES['avatarfile']['name'] != "") {
			$imge_name = $_FILES['avatarfile']['name'];
			$this->upload->initialize($this->set_upload_options());
			$image_data = $this->upload->do_upload('avatarfile', $imge_name); //Ten hinh 
			$array['image']  = $image_data;
			$resize = $this->resizeImg($image_data);	
		}
        $login = $this->login;
        $array['dateupdate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
        $array['userupdate'] = $login['userlogin'];
		$findID = $this->model->findID($id);
        $result['status'] = $this->model->edits($array,$id);
		$findIDEnd = $this->model->findID($id);
		#region logfile
		$ctrol = getLanguage('phong-ban');
		$func =  getLanguage('sua').': '.$array['departmanet_name'];
		$this->base_model->addAcction($ctrol,$func,json_encode($findID),json_encode($findIDEnd));	
		#end
        $result['csrfHash'] = $token;
        echo json_encode($result);
    }*/
	/*
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
		$findID = $this->model->findID($id);
        $login = $this->login;
        $array['dateupdate'] = gmdate("Y-m-d H:i:s", time() + 7 * 3600);
        $array['userupdate'] = $login['userlogin'];
        $array['isdelete'] = 1;
        $this->model->deletes($id,$array);
        $result['status'] = 1;
        $result['csrfHash'] = $token;
		#region logfile
		$ctrol = getLanguage('phong-ban');
		$func =  getLanguage('xoa').': '.$findID->departmanet_name;
		$this->base_model->addAcction($ctrol,$func,json_encode($findID),'');	
		#end
        echo json_encode($result);
    }*/
}