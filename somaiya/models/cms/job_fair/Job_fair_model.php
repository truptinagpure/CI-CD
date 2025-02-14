<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Job_fair_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_jobs_fair_list($conditions=[])
    {
        $this->db->select('*');
        $this->db->from('job_fair');
        
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->where('status !=', '-1');
        $this->db->order_by('id', 'DESC');
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

    function delete_image($id, $update)
    {
        // $update['image']            = null;
        // $update['modified_on']      = date('Y-m-d H:i:s');
        // $update['modified_by']      = $this->session->userdata('user_id');

        $this->db->where('id', $id);
        $this->db->update('job_fair', $update);

        return $this->db->affected_rows();
    }

    function _update($col, $val, $updatedata) {
        $response['status']         = 'error';
        $table                      = 'job_fair';
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

    function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'job_fair';
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

    function get_where($col, $val) {
        $table = 'job_fair';
        $this->db->where($col, $val);
        $query = $this->db->get($table);
        return $query->row_array();
    }

    function _delete($col, $val) {
		
		$update['status']            = -1;
		
        if(!empty($this->get_where($col, $val)))
        {
            $table      = 'job_fair';
            $this->db->where($col, $val);
            //$res        = $this->db->delete($table);
			$res        = $this->db->update($table,$update);
            $error      = $res ? 0 : 1;
            $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
            $res        = ['error' => $error, 'message' => $message];
        }
        else
        {
            $error      = 1;
            $message    = 'Record does not exist in database';
        }
        $res            = ['error' => $error, 'message' => $message];
        return $res;
    }

}