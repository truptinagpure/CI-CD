<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Student_council_designation_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_designation()
    {   
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->db->select("*");
        $this->db->from('student_council_designations');
        $this->db->where('institute_id', $instituteID);
        $this->db->where('status !=', '-1');
        // $this->db->order_by('id', 'ASC');
        $this->db->order_by('designation', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_type_data($institute_id,$id)
    {
        $this->db->select('*');
        $this->db->from('student_council_designations');
        $this->db->where('id', $id);
        $this->db->where('institute_id', $institute_id);
        $this->db->where('status !=', '-1');
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
}