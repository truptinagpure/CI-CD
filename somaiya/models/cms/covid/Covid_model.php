<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Covid_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_covid_list($conditions=[])
    {
        $this->db->select('c.*');
        $this->db->from('covid c');

        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }

        $this->db->where('c.public !=', '-1');
        $this->db->order_by('c.id', 'DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'covid';
        
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
        $table                      = 'covid';
        
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

        $table      = 'covid';
        $this->db->where($col, $val);
        //$res        = $this->db->delete($table);
        $res        = $this->db->update($table,$update);
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }

    function check_covid_title($member_id, $researcher_id)
    {
        $this->db->select('*');
        $this->db->from('covid');
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