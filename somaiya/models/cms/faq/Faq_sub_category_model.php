<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Faq_sub_category_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_sub_categories($institute_id)
    {
        $where = '(c.parent_id IS NOT NULL AND c.parent_id != "" AND c.parent_id != 0)';
        $this->db->select("c.*, fc.name as parent_name");
        $this->db->from('faq_categories c');
        $this->db->join('faq_categories fc', 'c.parent_id=fc.id', 'left');
        $this->db->where($where);
        $this->db->where('c.institute_id', $institute_id);
        $this->db->where('c.status !=', '-1');
        $this->db->order_by('c.name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_sub_category_data($institute_id, $id)
    {
        $this->db->select('*');
        $this->db->from('faq_categories');
        $this->db->where('id', $id);
        $this->db->where('institute_id', $institute_id);
        $this->db->where('status !=', '-1');
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
}