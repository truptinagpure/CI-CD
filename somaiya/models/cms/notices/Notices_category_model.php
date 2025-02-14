<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Notices_category_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_notices_category_list($conditions=[])
    {
        $this->db->select('nc.*, eid.INST_NAME');
        $this->db->from('notices_category nc');
        $this->db->join('edu_institute_dir eid', 'nc.institute_id = eid.INST_ID', 'left');
        

        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->where('nc.status !=', '-1');
        $this->db->order_by('nc.id','DESC');
        $query = $this->db->get();

        // $str = $this->db->last_query();
   
        // echo "<pre>";
        // print_r($str);
        // exit;
        return $query->result_array();
    }

    function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'notices_category';
        $res                        = $this->db->insert($table, $data);
        if($res)
        {
            $response['status']     = 'success';
            $response['id']         = $this->db->insert_id();
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
        $table                      = 'notices_category';
        $this->db->where($col, $val);
        $update                     = $this->db->update($table, $updatedata);
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
    
    

    function _delete($col, $val) {

        $table      = 'notices_category';
        $this->db->set('status', -1);
        $this->db->where($col, $val);
        //$res        = $this->db->delete($table);
        $res        = $this->db->update($table);
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        $res            = ['error' => $error, 'message' => $message];
        return $res;
    }

    function get_all_institute()
    {
        $this->db->select("INST_ID, INST_NAME");
        $this->db->from('edu_institute_dir');
        $this->db->order_by('INST_NAME', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
}