<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Plant_colors_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_colors($status='')
    {
        $this->db->select("*");
        $this->db->from('plant_colors');
        $this->db->where('status !=', '-1');
        // $this->db->order_by('id', 'DESC');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_color_data($id)
    {
        $this->db->select('*');
        $this->db->from('plant_colors');
        $this->db->where('id', $id);
        $this->db->where('status !=', '-1');
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
}