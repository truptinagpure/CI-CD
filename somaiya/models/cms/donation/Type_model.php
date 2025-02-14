<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Type_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_parent_type()
    {   
        $this->db->select("*");
        $this->db->from('donation_type');
        // $this->db->where('institute_id', $instituteID);
        //$this->db->where('public', '1');
        $this->db->order_by('donation_type', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_type_data($id)
    {
        $this->db->select('*');
        $this->db->from('donation_type');
        $this->db->where('dontype_id', $id);
        // $this->db->where('institute_id', $institute_id);
        // $this->db->where('public', '1');
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
}