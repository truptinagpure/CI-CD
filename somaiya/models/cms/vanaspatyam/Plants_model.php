<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Plants_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_plants($conditions=[])
    {
        $this->db->select('p.*, pc.name as category_name, pc1.name as sub_category_name, pcl.name as color_name');
        $this->db->from('plants p');
        $this->db->join('plant_categories pc', 'p.category_id=pc.id', 'left');
        $this->db->join('plant_categories pc1', 'p.sub_category_id=pc1.id', 'left');
        $this->db->join('plant_colors pcl', 'p.color_id=pcl.id', 'left');
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->where('p.status !=', '-1');
        $this->db->order_by('p.id', 'DESC');
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