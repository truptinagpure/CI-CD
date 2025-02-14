<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Semester_long_internship_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_student_council($conditions=[])
    {   
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->db->select('f.*');
        $this->db->from('graph_semester_long_internship f');
        $this->db->where('f.institute_id', $instituteID);
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
}