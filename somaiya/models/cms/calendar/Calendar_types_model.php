<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Calendar_types_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_calendar_types($status='')
    {
        $this->db->select("*");
        $this->db->from('event_calendar_type');
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


    function get_calendar_types_new($status='')
    {
        $this->db->select("*");
        $this->db->from('event_calendar_type');
        if($status)
        {
            $this->db->where('status', $status);
        }
        else
        {
            $this->db->where('status !=', '-1');
        }
        $this->db->where('id !=', '1');
        // $this->db->order_by('id', 'ASC');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }


    function get_calendar_type_data($id)
    {
        $this->db->select('*');
        $this->db->from('event_calendar_type');
        $this->db->where('id', $id);
        $this->db->where('status !=', '-1');
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function get_calendar_type_data_delete($id)
    {
        $this->db->select('*');
        $this->db->from('event_calendar_type');
        $this->db->where('id', $id);
        $this->db->where('status !=', '-1');
        $this->db->where('id !=', '1');
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
}