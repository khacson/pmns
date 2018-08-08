<?php
/**
 * @author sonnk
 * @copyright 2016
 */
class TimekeepingModel extends CI_Model
{
	function __construct(){
		parent::__construct('');
	}
	//Bang van tay
	function geTimesheets($fromdate,$todate){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hre_timesheets'])
					  ->select('id,employeeid,datecheck,time_start,time_end')
					  ->where('isdelete',0)
					  ->where('datecheck >= ',$fromdate)
					  ->where('datecheck <= ',$todate)
					  ->find_all();
		$array = array();
		foreach($query as $item){
			$array[$item->employeeid][$item->datecheck] = $item;
		}
        return $array;
	}
	//tang ca
	function getRegovertime($fromdate,$todate){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hre_regovertime'])
					  ->select('id,employeeid,departmentid,branchid,datecheck,time_start,time_end')
					  ->where('isdelete',0)
					  ->where('approved',1)
					  ->where('datecheck >= ',$fromdate)
					  ->where('datecheck <= ',$todate)
					  ->find_all();
		$array = array();
		foreach($query as $item){
			$array[$item->employeeid][$item->datecheck] = $item;
		}
        return $array;
	}
	//Nghỉ phép
	function getNghiPhep($fromdate,$todate){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hre_empleaveshow_detail'])
					  ->select('id,employeeid,datecheck,time_start,time_end')
					  ->where('statusid',1)
					  ->where('datecheck >= ',$fromdate)
					  ->where('datecheck <= ',$todate)
					  ->find_all();
		$array = array();
		foreach($query as $item){
			$array[$item->employeeid][$item->datecheck] = $item;
		}
        return $array;
	}
	//Đi công tác
	function getDiCongTac($fromdate,$todate){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hre_empleaveshow_detail'])
					  ->select('id,employeeid,datecheck,time_start,time_end')
					  ->where('statusid',2)
					  ->where('datecheck >= ',$fromdate)
					  ->where('datecheck <= ',$todate)
					  ->find_all();
		$array = array();
		foreach($query as $item){
			$array[$item->employeeid][$item->datecheck] = $item;
		}
        return $array;
	}
	//Nghi thai san
	function getNghiThaiSan($fromdate,$todate){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hre_empleaveshow_detail'])
					  ->select('id,employeeid,datecheck,time_start,time_end')
					  ->where('statusid',3)
					  ->where('datecheck >= ',$fromdate)
					  ->where('datecheck <= ',$todate)
					  ->find_all();
		$array = array();
		foreach($query as $item){
			$array[$item->employeeid][$item->datecheck] = $item;
		}
        return $array;
	}
	function getMonth(){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hre_endoffmonth'])
					  ->select('id,monthyear,date_start,date_end')
					  ->where('isdelete',0)
					  ->order_by('monthyear','desc')
					  ->find_all();
        return $query;
	}
	function findID($id) {
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hre_employee'])
					  ->where('isdelete',0)
					  ->where('id',$id)
					  ->find();
        return $query;
    }
	function getSearch($search){
		$login = $this->login;
		$sql = "";
		if(!empty($search['departmanet_name'])){
			$sql.= " and e.departmanet_name like '%".$search['departmanet_name']."%' ";	
		}
		if(!empty($search['phone'])){
			$sql.= " and e.phone like '%".$search['phone']."%' ";	
		}
		if(!empty($search['fax'])){
			$sql.= " and e.fax like '%".$search['fax']."%' ";	
		}
		if(!empty($search['heads'])){
			$sql.= " and e.heads like '%".$search['heads']."%' ";	
		}
		if(!empty($login['departmentid'])){
			if($login['grouptype'] > 1){
				$sql.= " and e.departmentid in (".$login['departmentid'].")";	
			}
		}
		else{
			if(!empty($search['departmentid'])){
				$sql.= " and e.departmentid in (".$search['departmentid'].") ";	
			}
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " 
				SELECT e.id, e.branchid, e.`code`, e.fullname, e.sex, e.birthday, e.place_of_birth, e.marriage, e.ethnicid,
				e.nationality, e.religionid, e.identity, e.identity_date, e.identity_from, e.academic_level, e.academic_skills, e.english_level, e.departmentid,
				e.positionid, e.jobstatusid,
				d.departmanet_name, s.shift_name, s.time_star, s.time_end
				FROM `".$tb['hre_employee']."` AS e
				LEFT JOIN `".$tb['hre_department']."` d on d.id = e.departmentid
				left join `".$tb['hre_shift']."` s on s.id = e.shiftid
				WHERE e.isdelete = 0
				$searchs
				and d.isdelete = 0
				";
		if(empty($search['order'])){
			$sql .= " ORDER BY e.fullname , e.departmentid ASC  ";
		}
		else{
			$sql.= " ORDER BY ".$search['order']." ".$search['index']." ";
		} 
		$sql.= ' limit '.$page.','.$rows;
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " 
		SELECT count(1) total  
			FROM `".$tb['hre_employee']."` AS e
			LEFT JOIN `".$tb['hre_department']."` d on d.id = e.departmentid
			WHERE e.isdelete = 0
			$searchs	
			and d.isdelete = 0
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function getDays($month,$year){
		if($month == 4 || $month == 6 || $month == 9 || $month == 11){
			$days = 30;
		}
		else if($month == 2){
			if($year % 400 == 0 || ($year % 4 == 0 && $year % 100 !=0)){
				$days = 29;
			}
			else{
				$days = 28;
			}
		}
		else{
			$days = 31;
		}
		return $days;
	}
	function getCheckIN($listDate,$listEmployeeID,$arrEmployee){
		$tb = $this->base_model->loadTable();
		//Cham van tay
		$timesheets	= $this->model->table($tb['hre_timesheets'])
								  ->select('id, time_start, time_end, employeeid, departmentid')
								  ->where('isdelete',0)
								  ->where("employeeid in ($listEmployeeID)")
								  ->where("datecheck in ($listDate)")
								  ->find_all();
		//Xin nghi phep
		
		return $timesheets;
	}
}