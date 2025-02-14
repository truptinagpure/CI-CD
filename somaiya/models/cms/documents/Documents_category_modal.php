<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Documents_category_modal extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_documents_category_list($conditions=[])
    {
        $this->db->select('dc.*,dd.name as department_name, eid.INST_NAME');
        $this->db->from('document_category dc');
        $this->db->join('document_department dd', 'dc.document_department_id = dd.id', 'left');
        $this->db->join('edu_institute_dir eid', 'dc.institute_id = eid.INST_ID', 'left');
        

        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->where('dc.status !=', '-1');
        $this->db->order_by('dc.id','DESC');
        $query = $this->db->get();

        // $str = $this->db->last_query();
   
        // echo "<pre>";
        // print_r($str);
        // exit;
        return $query->result_array();
    }

    function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'document_category';
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
        $table                      = 'document_category';
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

        $table      = 'document_category';
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
    
	function get_document_department_by_institute_id($institute_id)
    {
        $this->db->select("dc.id, dc.name");
        $this->db->from('document_department dc');
        //$this->db->join('document_category dc', 'd.document_category_id=dc.id', 'left');

        if(count($institute_id) >= 2)
        {
            $institutes = implode(',', $institute_id);
            $this->db->where_in('dc.institute_id', $institutes); 
        }
        else
        {
            $institutes = $institute_id;
            $this->db->where('dc.institute_id', $institutes);
        }

        $this->db->where('dc.status =', '1');
        $this->db->order_by('dc.id', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
}