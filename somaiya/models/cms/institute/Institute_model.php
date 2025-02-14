<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Institute_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_institute($conditions=[])
    {
        $this->db->select('f.*');
        $this->db->from('edu_institute_dir f');
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->where('f.public !=', '-1');
        $this->db->order_by('f.INST_NAME', 'ASC');
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

    function get_all_areaofstudy()
    {
        $this->db->select('*');
        $this->db->from('edu_areaofstudy_dir');
        $query = $this->db->get();
        return  $query->result_array();
    }

    function get_designations()
    {
        $this->db->select('*');
        $this->db->from('edu_designation_dir');
        $query = $this->db->get();
        return  $query->result_array();
    }

    function get_faculty_name($faculty_institute)
    {   
        $curdate=date("Y-m-d");
        $this->db->select('edu_member_dir.*,edu_institute_dir.INST_ID,edu_institute_dir.INST_NAME');
        $this->db->from('edu_member_dir');
        $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=edu_member_dir.INST_ID",'left');
        $this->db->where("(edu_member_dir.SENSYS_DATE_OF_EXIT IS NULL
                       OR edu_member_dir.SENSYS_DATE_OF_EXIT = '0000-00-00'
                       OR edu_member_dir.SENSYS_DATE_OF_EXIT>='".$curdate."')", NULL, FALSE);
        $this->db->where('edu_member_dir.MEMBER_STATUS', 'A');
        $this->db->where_not_in('edu_institute_dir.INST_ID', '51');
        $this->db->where("edu_member_dir.MEMBER_TYPE ='FACULTY'");
        $this->db->where('edu_member_dir.INST_ID', $faculty_institute);
        $query = $this->db->get();
        //echo "<pre>";print_r($this->db->last_query());exit;
        return  $query->result_array();
    }

    function get_excluded_designations($faculty_institute)
    {
        $this->db->select('*');
        $this->db->from('edu_institute_config');
        $this->db->where('institute_id =', $faculty_institute);
        $query = $this->db->get();
        return  $query->result_array();
    }

    function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'edu_institute_config';

        $res                        = $this->db->insert($table, $data['designation']);
        $insert_id = $this->db->insert_id();

        if($res)
        {
            $response['status']     = 'success';
            $response['id']         = $insert_id;
        }
        else
        {
            $response['status']     = 'error';
            $response['message']    = $this->db->_error_message();
        }
        return  $response;
    }

    function _update($col, $val, $updatedata) {
        $response['status']         = 'error';
        $table                      = 'edu_institute_config';

        $this->db->where($col, $val);
        $update                     = $this->db->update($table, $updatedata['designation']);

        if($update)
        {
            $response['status']     = 'success';
            $response[$col]         = $val;
        }
        else
        {
            $response['status']     = 'error';
            $response['message']    = $this->db->_error_message();
        }
        return $response;
    }

}