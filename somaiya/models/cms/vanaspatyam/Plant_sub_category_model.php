<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Plant_sub_category_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_sub_categories()
    {
        $where = '(c.parent_id IS NOT NULL AND c.parent_id != "" AND c.parent_id != 0)';
        $this->db->select("c.*, pc.name as parent_name");
        $this->db->from('plant_categories c');
        $this->db->join('plant_categories pc', 'c.parent_id=pc.id', 'left');
        $this->db->where($where);
        $this->db->where('c.status !=', '-1');
        $this->db->order_by('c.name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sub_category_data($id)
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