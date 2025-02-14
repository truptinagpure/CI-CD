<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Plant_category_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_parent_categories($status='')
    {
        $or_where = '(parent_id IS NULL OR parent_id = "" OR parent_id = 0)';
        $this->db->select("*");
        $this->db->from('plant_categories');
        $this->db->where($or_where);
        if($status)
        {
            $this->db->where('status', $status);
        }
        else
        {
            $this->db->where('status !=', '-1');
        }
        // $this->db->order_by('id', 'ASC');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_category_data($id)
    {
        $this->db->select('*');
        $this->db->from('plant_categories');
        $this->db->where('id', $id);
        $this->db->where('status !=', '-1');
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
}