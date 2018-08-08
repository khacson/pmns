<?php
/**
 * @author sonnk
 * @copyright 2016
 */
class AtmModel extends CI_Model
{
	function __construct(){
		parent::__construct('');
	}
		function getSearch($search){
		$sql = "";
		if(!empty($search['code'])){
			$sql.= " and s.code like '%".$search['code']."%' ";	
		}
		if(!empty($search['fullname'])){
			$sql.= " and s.fullname like '%".$search['fullname']."%' ";	
		}
		if(!empty($search['identity'])){
			$sql.= " and s.identity like '%".$search['identity']."%' ";	
		}
		if(!empty($search['phone'])){
			$sql.= " and s.phone like '%".$search['phone']."%' ";	
		}
		if(!empty($search['departmentid'])){
			$sql.= " and s.departmentid in (".$search['departmentid'].") ";	
		}
		if(!empty($search['positionid'])){
			$sql.= " and s.positionid in (".$search['positionid'].") ";	
		}
		if(!empty($search['jobstatusid'])){
			$sql.= " and s.jobstatusid in (".$search['jobstatusid'].") ";	
		}
		if(!empty($search['academic_level'])){
			$sql.= " and s.academic_level in (".$search['academic_level'].") ";	
		}
		if(!empty($search['ethnicid'])){
			$sql.= " and s.ethnicid in (".$search['ethnicid'].") ";	
		}
		if(!empty($search['religionid'])){
			$sql.= " and s.religionid in (".$search['religionid'].") ";	
		}
		if(!empty($this->login['departmentid']) && $this->login['grouptype'] > 1){// > 1 Các phòng ban khác
			$sql.= " and s.departmentid = '".$this->login['departmentid']."' ";	
		}
		else{
			if(!empty($search['departmentid'])){
				$sql.= " and s.departmentid in (".$search['departmentid'].") ";	
			}
		}
		return $sql;
	}
	function getList($search,$page,$rows){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = "
				SELECT s.*, d.departmanet_name, p.position_name, dg.departmentgroup_name
				FROM `".$tb['hre_employee']."` s
				left join `".$tb['hre_department']."` d on d.id = s.departmentid
				left join `".$tb['hre_position']."` p on p.id = s.positionid
				left join `".$tb['hre_departmentgroup']."` dg on dg.id = s.group_work_id
				where s.isdelete = 0
				$searchs
				";
		if(empty($search['order'])){
			$sql.= ' ORDER BY s.fullname ASC ';
		}
		else{
			$sql.= ' ORDER BY '.$search['order'].' '.$search['index'].' ';
		}
		if(!empty($rows)){
			$sql.= ' limit '.$page.','.$rows; 
		}
		$query = $this->model->query($sql)->execute();
		return $query;
	}
	function getTotal($search){
		$tb = $this->base_model->loadTable();
		$searchs = $this->getSearch($search);
		$sql = " 
		SELECT count(1) total
				FROM `".$tb['hre_employee']."`  s
				left join `".$tb['hre_department']."` d on d.id = s.departmentid
				left join `".$tb['hre_position']."` p on p.id = s.positionid
				where s.isdelete = 0
				$searchs	
		";
		$query = $this->model->query($sql)->execute();
		return $query[0]->total;	
	}
	function findID($id){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hre_employee'])
					  ->select('*')
					  ->where('id',$id)
					  ->find();
		return $query;
	 }
}