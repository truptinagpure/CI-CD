<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Locations_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_locations($conditions=[])
    {
        $this->db->select('f.*');
        $this->db->from('locations f');
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->where('f.public !=', '-1');
        $this->db->order_by('f.location_id', 'DESC');
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