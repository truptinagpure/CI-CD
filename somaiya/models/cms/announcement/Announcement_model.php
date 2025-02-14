<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Announcement_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_announcement_list($conditions=[])
    {
        $this->db->select('a.*, ac.contents_id, ac.description,ac.language_id');
        $this->db->from('announcement_new a');
        $this->db->join('contentsannouncement_new ac','a.announcement_id = ac.announcement_id','left');

        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->where('ac.language_id',1);
        $this->db->where('a.public !=', '-1');
        $this->db->order_by('a.announcement_id', 'DESC');
        $query = $this->db->get();

        // $str = $this->db->last_query();
   
        // echo "<pre>";
        // print_r($str);
        // exit;
        return $query->result_array();
    }

    function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'announcement_new';
        $table2                     = 'contentsannouncement_new';

        $res                        = $this->db->insert($table, $data['announcement']);
        $insert_id = $this->db->insert_id();

        if($res)
        {
            $data['contents']['announcement_id']      = $insert_id;
            
            $res                        = $this->db->insert($table2, $data['contents']);

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
        $table                      = 'announcement_new';
        $table2                     = 'contentsannouncement_new';

        $this->db->where($col, $val);
        $update                     = $this->db->update($table, $updatedata['announcement']);

        // $str = $this->db->last_query();
   
        // echo "<pre>";
        // print_r($str);
        // echo "<br>----------------<br>";

        if($update)
        {
            $this->db->where('contents_id', $updatedata['contents']['contents_id']);
            $this->db->update($table2, $updatedata['contents']);

            // $str1 = $this->db->last_query();
            // echo "<pre>";
            // print_r($str1);
            // echo "<br>----------------<br>";

            // exit();

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

        $this->db->where('announcement_id', $id);
        $this->db->update('announcement_new', $update);

        return $this->db->affected_rows();
    }

    function _delete($col, $val) {
            
        $update['public']           = -1;
        $update['modified_on']      = date('Y-m-d H:i:s');
        $update['modified_by']      = $this->session->userdata('user_id');

        $table      = 'announcement_new';
        $this->db->where($col, $val);
        //$res        = $this->db->delete($table);
        $res        = $this->db->update($table,$update);
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }
    
    // function get_departmentsByInstitute($institute_id)
    // {
    //     $this->db->select("d.Department_Id, d.Department_Name");
    //     $this->db->from('edu_department_dir d');
    //     //$this->db->join('department_by_institute di, d.Department_Id = di.department_id','left');
    //     $this->db->join('department_by_institute di',"FIND_IN_SET(d.Department_Id,di.department_id)",'left');
    //     $this->db->where('status', 1);
    //     $this->db->where('di.institute_id', $institute_id);
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

    
}