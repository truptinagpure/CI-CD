<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Industrial_visits_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_industrial_visit($conditions=[])
    {
        $this->db->select('iv.*, d.Department_Name as department_name');
        $this->db->from('industrial_visits iv');
        $this->db->join('edu_department_dir d', 'iv.department_id=d.Department_Id', 'left');

        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->where('iv.status !=', '-1');
        $this->db->order_by('iv.id', 'DESC');
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

    function get_parent_department($status='')
    {
        // $this->db->select("*");
        // $this->db->from('edu_department_dir');
        // $this->db->order_by('Department_Name', 'ASC');
        $this->db->select("di.*, ed.Department_Name");
        $this->db->from('department_by_institute di');
        $this->db->join('edu_department_dir ed','di.department_id = ed.Department_Id');
        $this->db->where('di.status =', '1');
        $this->db->where('di.institute_id =', $this->session->userdata('sess_institute_id'));
        $this->db->order_by('di.department_id','ASC');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    function delete_image($id, $update)
    {
        // $update['image']            = null;
        // $update['modified_on']      = date('Y-m-d H:i:s');
        // $update['modified_by']      = $this->session->userdata('user_id');

        $this->db->where('id', $id);
        $this->db->update('industrial_visits', $update);

        return $this->db->affected_rows();
    }

    function _update($col, $val, $updatedata) {
        $response['status']         = 'error';
        $table                      = 'industrial_visits';
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
        $table                      = 'industrial_visits';
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
        $table = 'industrial_visits';
        $this->db->where($col, $val);
        $query = $this->db->get($table);
        return $query->row_array();
    }

    function _delete($col, $val) {
        if(!empty($this->get_where($col, $val)))
        {
            $table      = 'industrial_visits';
            $this->db->where($col, $val);
            $res        = $this->db->delete($table);
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