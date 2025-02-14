<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Smh_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_smh_list($conditions=[])
    {
        // $this->db->select('s.*, eid.INST_ID, eid.INST_NAME,smh_type.smh_belongs_to_type_name,smh_bd.smh_belongs_to_name,smh_dir.smh_dir_name');
        // $this->db->from('smh s');
        // $this->db->join('smh_belongs_to_dir smh_bd','s.smh_belongs_to_id = smh_bd.smh_belongs_to_id', 'left');
        // $this->db->join('edu_institute_dir eid', 's.institute_id = eid.INST_ID', 'left');
        // $this->db->join('smh_belongs_to_type_dir smh_type', 's.smh_belongs_to_type_id = smh_type.smh_belongs_to_type_id', 'left');
        // $this->db->join('smh_dir smh_dir', 's.smh_dir_id = smh_dir.smh_dir_id', 'left');

        $this->db->select('s.*, eid.INST_ID, eid.INST_NAME,smh_type.smh_belongs_to_type_name,smh_bd.smh_belongs_to_name,smh_dir.smh_dir_name, ed.Department_Name');
        $this->db->from('smh s');
        $this->db->join('smh_belongs_to_dir smh_bd','s.smh_belongs_to_id = smh_bd.smh_belongs_to_id', 'left');
        $this->db->join('edu_institute_dir eid', 's.institute_id = eid.INST_ID', 'left');
        $this->db->join('smh_belongs_to_type_dir smh_type', 's.smh_belongs_to_type_id = smh_type.smh_belongs_to_type_id', 'left');
        $this->db->join('smh_dir smh_dir', 's.smh_dir_id = smh_dir.smh_dir_id', 'left');
        $this->db->join('edu_department_dir ed', 's.smh_belongs_to_id=ed.Department_Id');
        
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->where('s.public !=', '-1');
        $this->db->order_by('s.id','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'smh';
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
        $table                      = 'smh';
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

        $table      = 'smh';
        $this->db->set('public', -1);
        $this->db->where($col, $val);
        //$res        = $this->db->delete($table);
        $res        = $this->db->update($table);
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        $res            = ['error' => $error, 'message' => $message];
        return $res;
    }

    function smh_type_list_by_institute()
    {
        $this->db->select('*');
        $this->db->from('smh_belongs_to_type_dir');
        //$this->db->where('institute_id =', $institute_id);
        $this->db->where('public =', '1');
        $this->db->order_by('smh_belongs_to_type_name','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    
    function smh_social_list()
    {
        $this->db->select('smh_dir.*');
        $this->db->from('smh_dir');
        $this->db->where('public =', '1');
        $this->db->order_by('smh_dir_name','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_smh_subcategory_by_cat_id($category_id)
    {
        //$category = implode(',', $category_id);

        $this->db->select('*');
        $this->db->from('smh_belongs_to_dir');
        //$this->db->where_in('smh_belongs_to_type', $category); // used multiple value
        $this->db->where('smh_belongs_to_type', $category_id); // used single value
        $this->db->where('institute_id =', $this->session->userdata('sess_institute_id'));
        $this->db->where('public =', '1');
        $this->db->order_by('smh_belongs_to_name','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_smh_subcategory_by_cat_department()
    {
        $this->db->select('ed.Department_Id, ed.Department_Name');
        $this->db->from('department_by_institute di');
        $this->db->join('edu_department_dir ed','di.department_id = ed.Department_Id');
        $this->db->where('di.institute_id =', $this->session->userdata('sess_institute_id'));
        $this->db->where('di.status =', '1');
        $this->db->order_by('ed.Department_Name','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    function check_cat_subcat_socialplatform_rel($smh_id, $smh_category, $smh_subcategory, $smh_platform)
    {
        $this->db->select('');
        $this->db->from('smh s');
        $this->db->where('smh_dir_id', $smh_platform);
        $this->db->where('smh_belongs_to_type_id', $smh_category);
        $this->db->where('smh_belongs_to_id', $smh_subcategory);

        if(!empty($smh_id))
        {
            $this->db->where('id !=', $smh_id);
        }
        $this->db->where('institute_id =', $this->session->userdata['sess_institute_id']);
        $this->db->where('public !=', -1);
        
        $query = $this->db->get();
        //return $query->num_rows();
        return $query->result_array();
    }
}