<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Researchers_corner_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_researchers_list($conditions=[])
    {
        $this->db->select('rc.*, concat(emd.FIRST_NAME, " ", emd.LAST_NAME) as name');
        $this->db->from('researchers_corner rc');
        $this->db->join('edu_member_dir emd','emd.MEMBER_ID = rc.researcher_member_id');

        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        
        $this->db->where('rc.public !=', '-1');
        $this->db->order_by('rc.id', 'DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'researchers_corner';
        
        $res                        = $this->db->insert($table, $data);
        
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
        $table                      = 'researchers_corner';
        
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
            
        $update['public']       = -1;
        $update['modified_on']  = date('Y-m-d H:i:s');
        $update['modified_by']  = $this->session->userdata('user_id');

        $table      = 'researchers_corner';
        $this->db->where($col, $val);
        //$res        = $this->db->delete($table);
        $res        = $this->db->update($table,$update);
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }

    function check_member_id($member_id)
    {
        //$this->db->select('MEMBER_ID, MEMBER_TYPE, concat(SALUTATION, " ", FIRST_NAME, " ", LAST_NAME) as member_name'); // remove because 500200 id has empty 'SALUTATION' column
        $this->db->select('MEMBER_ID, MEMBER_TYPE, concat(FIRST_NAME, " ", LAST_NAME) as member_name');
        $this->db->from('edu_member_dir');
        $this->db->where('MEMBER_ID', $member_id);
        $this->db->where('MEMBER_STATUS', 'A');
        
        $query = $this->db->get();
        //return $query->num_rows();
        return $query->result_array();
    }

    function check_researchers_id($member_id, $researcher_id)
    {
        $this->db->select('*');
        $this->db->from('researchers_corner');
        $this->db->where('researcher_member_id', $member_id);
        if(!empty($researcher_id))
        {
            $this->db->where('id !=', $researcher_id);
        }
        $this->db->where('public !=', -1);
        
        $query = $this->db->get();
        //return $query->num_rows();
        return $query->result_array();
    }
}