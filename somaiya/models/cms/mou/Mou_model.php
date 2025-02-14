<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mou_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_mou($conditions=[])
    {
        $this->db->select('f.*');
        $this->db->from('mou f');
        $this->db->join('edu_institute_dir d', 'f.institute_id=d.INST_ID', 'left');
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
        $this->db->select("*");
        $this->db->from('edu_department_dir');
        $this->db->order_by('Department_Id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
}