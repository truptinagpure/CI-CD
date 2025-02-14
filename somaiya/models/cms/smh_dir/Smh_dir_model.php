<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Smh_dir_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_smh_dir_list($conditions=[])
    {
        $this->db->select('*');
        $this->db->from('smh_dir');
        $this->db->order_by('smh_dir_id','DESC');

        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->where('public !=', '-1');
        $query = $this->db->get();
        return $query->result_array();
    }

    function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'smh_dir';
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
        $table                      = 'smh_dir';
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

        // first check its column value is used in smh table.

        $this->db->select('*');
        $this->db->from('smh');
        $this->db->where('smh_dir_id', $val);
        $this->db->where('public !=', -1);
        
        $query = $this->db->get();
        $rows = $query->num_rows();
        //echo "number of rows : ".$rows;
        //exit();
        if($rows == 0)
        {
            $table      = 'smh_dir';
            $this->db->set('public', -1);
            $this->db->where($col, $val);
            //$res        = $this->db->delete($table);
            $res        = $this->db->update($table);
            $error      = $res ? 0 : 1;
            $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
            $res        = ['error' => $error, 'message' => $message];
        }
        else
        {
            $res            = ['error' => 1, 'message' => 'Unable to delete record, because child records found'];
        }
        
        return $res;
    }

    function check_social_name($smh_dir_name, $smh_dir_id)
    {
        $this->db->select('*');
        $this->db->from('smh_dir');
        $this->db->where('smh_dir_name', $smh_dir_name);
        if(!empty($smh_dir_id))
        {
            $this->db->where('smh_dir_id !=', $smh_dir_id);
        }
        $this->db->where('public !=', -1);
        
        $query = $this->db->get();
        //return $query->num_rows();
        return $query->result_array();
    }

}