<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Faq_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_faq($conditions=[])
    {
        $this->db->select('f.*, fc.name as category_name, fc1.name as sub_category_name');
        $this->db->from('faq f');
        $this->db->join('faq_categories fc', 'f.category_id=fc.id', 'left');
        $this->db->join('faq_categories fc1', 'f.sub_category_id=fc1.id', 'left');
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