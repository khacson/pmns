<?php
/**
 * @author sonnk
 * @copyright 2018
 */
class PayrolldetailModel extends CI_Model
{
	function __construct(){
		parent::__construct('');
	}
	function findID($id) {
		$tb = $this->base_model->loadTable();
        $query = $this->model->table($tb['hre_salary'])
					  ->where('isdelete',0)
					  ->where('id',$id)
					  ->find();
        return $query;
    }
	function getAllowance(){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hre_allowance'])
					  ->select('id,allowance_name')
					  ->where('isdelete',0)
					  ->find_all();
        return $query;
	}
	function getInsurance(){
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hre_insurance'])
					  ->select('id,insurance_name')
					  ->where('isdelete',0)
					  ->find_all();
        return $query;
	}
	function getTimesheetsMonth($monthid){
		$login = $this->login;
		$tb = $this->base_model->loadTable();
		$query = $this->model->table($tb['hre_timesheets_month'])
					  ->select('id,employeeid,workday')
					  ->where('branchid',$login['branchid'])
					  ->where('monthid',$monthid)
					  ->find_combo('employeeid','workday');
        return $query;
	}
	function getAllowanceSalary($endoffmonthid){
		$tb = $this->base_model->loadTable();
		 $query = $this->model->table($tb['hre_salary_allowance'])
					  ->select('id,allowanceid,salary,employeeid,typeid')
					  ->where('isdelete',0)
					  ->where('endoffmonthid',$endoffmonthid)
					  ->find_all();
        return $query;
	}
	function getEndoffmonth(){
		$tb = $this->base_model->loadTable();
		 $query = $this->model->table($tb['hre_endoffmonth'])
					  ->select('id,monthyear')
					  ->where('isdelete',0)
					  ->order_by('monthyear','desc')
					  ->find_all();
        return $query;
	}
	function getEmployee($departmentid) {
		$tb = $this->base_model->loadTable();
		$login = $this->login;
        $query = $this->model->table($tb['hre_employee'])
					  ->select('id,code,fullname')
					  ->where('isdelete',0);
		if(!empty($departmentid)){
			if($login['grouptype'] > 1){
				$query = $query->where('departmentid',$departmentid);
			}
		}
		$query = $query->find_all();
        return $query;
    }
	function findDepartment($employeeid){
		$tb = $this->base_model->loadTable();
		$find = $this->model->table($tb['hre_employee'])
							->select('id,departmentid')
							->where('id',$employeeid)
							->find();
		$departmentid = 0;
		if(!empty($find->departmentid)){
			$departmentid = $find->departmentid;
		}
		return $departmentid;
	}
}