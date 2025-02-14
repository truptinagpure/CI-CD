<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mandatory_disclosure_modal extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_documents_list($conditions=[])
    {
        $this->db->select('m.*,m.name as name, d.name as catname, md.name as subname,m.order_by as order');
        $this->db->from('mandatory_disclosure m');
        $this->db->join('mandatory_disclosure_category d', 'd.id=m.document_category_id', 'left');
        $this->db->join('mandatory_disclosure_subcategory md', 'md.id=m.document_subcategory_id', 'left');
        $this->db->where('m.status !=', '-1');

        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                //$this->db->where($key, $value);
                $this->db->where("$key IN (".$value.")");

            }
        }
        // $this->db->order_by('CAST(m.order_by AS DECIMAL(3,2)) ASC');
        $this->db->order_by('m.order_by','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'mandatory_disclosure';
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
        $table                      = 'mandatory_disclosure';
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
    
    function get_all_institute()
    {
        $this->db->select("INST_ID, INST_NAME");
        $this->db->from('edu_institute_dir');
        $this->db->order_by('INST_ID', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_document_category_by_department_id($department_id)
    {
        $this->db->select("dc.id, dc.name");
        $this->db->from('mandatory_disclosure_subcategory dc');
        //$this->db->join('document_category dc', 'd.document_category_id=dc.id', 'left');

        if(count($department_id) >= 2)
        {
            $departments = implode(',', $department_id);
            $this->db->where_in('dc.document_category_id', $departments); 
        }
        else
        {
            $departments = $department_id;
            $this->db->where('dc.document_category_id', $departments);
        }

        $this->db->where('dc.status =', '1');
        $this->db->order_by('dc.id', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_document_category_by_institute_id($institute_id)
    {
        $this->db->select("dc.id, dc.name");
        $this->db->from('mandatory_disclosure_subcategory dc');
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

    function get_document_department_by_institute_id($institute_id)
    {
        $this->db->select("dc.id, dc.name");
        $this->db->from('mandatory_disclosure_category dc');
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

    function get_sub_institute_ids($institute_id)
    {
        $this->db->select('INST_ID, INST_NAME');
        $this->db->from('edu_institute_dir');
        $this->db->where('subsidary',$institute_id);
        $this->db->where('INST_ID !=',$institute_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function _delete($col, $val) {

        $table      = 'mandatory_disclosure';
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
}