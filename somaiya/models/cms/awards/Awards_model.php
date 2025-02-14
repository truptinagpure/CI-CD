<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Awards_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_awards($conditions=[])
    {
        $this->db->select('f.*, fc.name as type_name, fc1.name as sub_type_name');
        $this->db->from('awards f');
        $this->db->join('awards_type fc', 'f.type_id=fc.id', 'left');
        $this->db->join('awards_type fc1', 'f.sub_type_id=fc1.id', 'left');
        $this->db->join('edu_institute_dir i', 'f.institute_id=i.INST_ID', 'left');
        // $this->db->join('edu_department_dir d', 'f.department_id=d.Department_Id', 'left');
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->where('f.status !=', '-1');
        $this->db->order_by('f.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_table_data($table, $conditions)
    {
        $this->db->select('*');
        $this->db->from($table);
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_department()
    {
        /* $this->db->select("*");
        $this->db->from('edu_department_dir');
        $this->db->order_by('Department_Id','ASC');
        $query = $this->db->get();
        return $query->result_array(); */
		
		$this->db->select("di.*, ed.Department_Name");
        $this->db->from('department_by_institute di');
        $this->db->join('edu_department_dir ed','di.department_id = ed.Department_Id');
        $this->db->where('di.status =', '1');
        $this->db->where('di.institute_id =', $this->session->userdata('sess_institute_id'));
        $this->db->order_by('di.department_id','ASC');

        $query = $this->db->get();
        return $query->result_array();
    }
}