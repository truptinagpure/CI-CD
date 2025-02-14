<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Department_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function add_update_data($col, $val, $updatedata)
    {
        // echo "<pre>";
        // print_r($updatedata);
        // exit();
        $get_department_list_by_institute = $this->get_all_department_list_by_institute($this->session->userdata('sess_institute_id'));
        $department_id = $updatedata['department_id'];

        // echo "<pre>";
        // print_r($get_department_list_by_institute);
        // echo "<br>-----------<br>";
        // echo "<pre>";
        // print_r($department_id);
        // echo "<br>-----------<br>";
        //exit();

        /*foreach ($get_department_list_by_institute as $value) {

            if(in_array($value['department_id'], $department_id))
            {
                echo "<br>exit";
            }
            else
            {
                echo "<br>not exit";
            }
            
        }*/
        $existing_department = array();

        foreach ($get_department_list_by_institute as $value) {

            $existing_department[]=$value['department_id'];
            
        }
        // echo "<pre>";
        // print_r($existing_department);
        // echo "<br>**********<br>";

        foreach ($department_id as $value) {

            //if(array_search($value, array_column($get_department_list_by_institute,'department_id')) !== false)
            if(in_array($value, $existing_department))
            {
                //echo "<br>Update query";
                $data = array('status' => 1,'modified_on' => date('Y-m-d H:i:s'),'modified_by' => $this->session->userdata('user_id'));
                $this->db->where('institute_id', $this->session->userdata('sess_institute_id'));
                $this->db->where('department_id', $value);
                $this->db->update('department_by_institute', $data);

            }
            else
            {   

                //echo "<br>Insert query";
                $data = array('institute_id' => $this->session->userdata('sess_institute_id'), 'department_id' => $value,'status' => 1,'created_on' => date('Y-m-d H:i:s'),'created_by' => $this->session->userdata('user_id'));
                $this->db->insert('department_by_institute', $data);
            }
            
        }

        // update status(deactive) of previous added departments.

        $previous_department = array_diff($existing_department,$department_id);
        // echo "<br>-----------------<br>";
        // echo "<pre>";
        // print_r($previous_department);
        if(!empty($previous_department))
        {
            $data = array('status' => 0);
            $this->db->where('institute_id', $this->session->userdata('sess_institute_id'));
            $this->db->where('department_id in ('.implode(',', $previous_department).')');
            $this->db->update('department_by_institute', $data);
        }
        

        // $str = $this->db->last_query();
   
        // echo "<pre>";
        // print_r($str);
        // exit;

        $response['status']     = 'success';
        return  $response;
        //exit();
    }

    function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'department_by_institute';
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
        $table                      = 'department_by_institute';
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
    
    

    /*function _delete($col, $val) {

        $table      = 'department_by_institute';
        $this->db->set('status', -1);
        $this->db->where($col, $val);
        //$res        = $this->db->delete($table);
        $res        = $this->db->update($table);
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        $res            = ['error' => $error, 'message' => $message];
        return $res;
    }*/

    function get_all_department()
    {
        $this->db->select("Department_Id, Department_Name");
        $this->db->from('edu_department_dir');
        $this->db->order_by('Department_Name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function get_all_department_list_by_institute($institute_id)
    {
        $this->db->select("id, department_id");
        $this->db->from('department_by_institute');
        //$this->db->where('id', $id);
        $this->db->where('institute_id', $institute_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_active_department_list_by_institute($institute_id)
    {
        $this->db->select("id, group_concat(department_id SEPARATOR ',') as department_id");
        $this->db->from('department_by_institute');
        $this->db->where('status', 1);
        $this->db->where('institute_id', $institute_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_department_name_by_institute($institute_id)
    {
        $this->db->select("d.Department_Id, d.Department_Name");
        $this->db->from('edu_department_dir d');
        //$this->db->join('department_by_institute di, d.Department_Id = di.department_id','left');
        $this->db->join('department_by_institute di',"FIND_IN_SET(d.Department_Id,di.department_id)",'left');
        //$this->db->where('id', $id);
        $this->db->where('di.institute_id', $institute_id);
        $this->db->where('di.status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    
}