<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Result_sub_category_modal extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_result_sub_category_list($conditions=[])
    {
        //$this->db->select('rsc.*, GROUP_CONCAT(rc.name SEPARATOR "|") as category_name, eid.INST_ID, eid.INST_NAME');
        $this->db->select('rsc.*, eid.INST_ID, eid.INST_NAME');
        $this->db->from('result_sub_category rsc');
        //$this->db->join('result_category rc',"FIND_IN_SET(rc.id,rsc.result_category_id)",'left');
        $this->db->join('edu_institute_dir eid', 'rsc.institute_id = eid.INST_ID', 'left');
        $this->db->order_by('rsc.id','DESC');

        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->where('rsc.status !=', '-1');
        $query = $this->db->get();

        return $query->result_array();
    }

    function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'result_sub_category';
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
        $table                      = 'result_sub_category';
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

        $table      = 'result_sub_category';
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
        $this->db->order_by('INST_ID', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_result_category_by_institute_id($institute_id)
    {
        $this->db->select("id, name");
        $this->db->from('result_category');
        $this->db->where('status',1);
        $this->db->where('institute_id',$institute_id);
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
}