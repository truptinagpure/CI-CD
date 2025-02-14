<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Internship_statistics_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_student_council($conditions=[])
    {   
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->db->select('f.*');
        $this->db->from('graph_internship_statistics f');
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


    function get_all_academic_year_by_institute($institute_id)
    {
        $this->db->select('distinct(ay.academic_year_name)');
        $this->db->from('academic_year ay');
        $this->db->limit(6);
        $this->db->order_by('ay.academic_year_id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }


}