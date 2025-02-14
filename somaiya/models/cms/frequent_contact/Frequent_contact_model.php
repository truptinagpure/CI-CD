<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Frequent_contact_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_frequent_contact($conditions=[])
    {
        $this->db->select('f.*,k.INST_ID, k.INST_NAME');
        $this->db->from('institute_contact f');
        $this->db->join('edu_institute_dir k', 'k.INST_ID=f.institute_id','left');
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->where('f.public !=', '-1');
        $this->db->order_by('f.order_by', 'ASC');
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