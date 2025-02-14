<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sub_type_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_sub_type()
    {   
        $this->db->select("c.*, fc.donation_type as parent_name");
        $this->db->from('donation_sub_type c');
        $this->db->join('donation_type fc', 'c.donation_type=fc.dontype_id', 'left');
        // $this->db->where('c.institute_id', $instituteID);
        //$this->db->where('c.public', '1');
        $this->db->order_by('c.sub_donation_type', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sub_type_data($id)
    {
        $this->db->select('*');
        $this->db->from('donation_sub_type');
        $this->db->where('id', $id);
        // $this->db->where('institute_id', $institute_id);
        //$this->db->where('public', '1');
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function get_sub_type_parent()
    {   
        $this->db->select("c.dontype_id, c.donation_type as parent_name");
        $this->db->from('donation_type c');
        // $this->db->where('c.institute_id', $instituteID);
        $this->db->where('c.public', '1');
        $this->db->order_by('c.donation_type', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
}