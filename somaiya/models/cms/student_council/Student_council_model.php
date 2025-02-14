<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Student_council_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_student_council($conditions=[])
    {
        $this->db->select('f.*,sd.designation');
        $this->db->from('student_council f');
        $this->db->join('student_council_designations sd',"f.designation_id=sd.id",'left');
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

    function get_all_designation($institute_id)
    {
        $this->db->select('id,designation');
        $this->db->from('student_council_designations');
        $this->db->where('institute_id', $institute_id);
        $this->db->where('status =', '1');
        $query = $this->db->get();
        return $query->result_array();
    }
}