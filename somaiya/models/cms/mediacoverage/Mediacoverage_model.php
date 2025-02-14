<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mediacoverage_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_mediacoverage_list($conditions=[])
    {
        /* $this->db->select('m.*, mc.contents_id, mc.description, mc.language_id, GROUP_CONCAT(DISTINCT(c.category_name)) AS category_name, ms.source_name');
        $this->db->from('mediacoverage_new m');
        $this->db->join('contentsmediacoverage_new mc','m.mediacoverage_id = mc.mediacoverage_id','left');
        $this->db->join('category c',"FIND_IN_SET(c.category_id,m.category_id)",'left');
        $this->db->join('mediacoverage_source ms',"ms.id=m.source");
        

        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->where('mc.language_id',1);
        $this->db->where('m.public !=', '-1');
        $this->db->order_by('m.mediacoverage_id', 'DESC');
        $query = $this->db->get(); */
		
		$this->db->select('m.mediacoverage_id, GROUP_CONCAT(DISTINCT(edu_institute_dir.INST_NAME)) AS institute_name, m.institute_id, m.category_id, GROUP_CONCAT(DISTINCT(c.category_name)) AS category_name, m.title,m.person, m.date, m.type, m.source, m.link_to_epaper,m.whats_new, m.whats_new_expiry_date,m.public, m.department_id, mc.contents_id, mc.description, mc.language_id, ms.source_name,m.image');
        $this->db->from('mediacoverage_new m');
        $this->db->join('contentsmediacoverage_new mc','m.mediacoverage_id = mc.mediacoverage_id','left');
        $this->db->join('edu_institute_dir','FIND_IN_SET(edu_institute_dir.INST_ID,m.institute_id)','left');
        $this->db->join('category c',"FIND_IN_SET(c.category_id,m.category_id)",'left');
        $this->db->join('mediacoverage_source ms',"ms.id=m.source", "left");
        

        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->where("FIND_IN_SET(".$this->session->userdata['sess_institute_id'].", m.institute_id)");
        $this->db->where('mc.language_id',1);
        $this->db->where('m.public !=', '-1');
		$this->db->group_by('m.mediacoverage_id');
        $this->db->order_by('m.mediacoverage_id', 'DESC');
        $query = $this->db->get();

        // $str = $this->db->last_query();
   
        // echo "<pre>";
        // print_r($str);
        // exit;
        return $query->result_array();
    }

    function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'mediacoverage_new';
        $table2                     = 'contentsmediacoverage_new';

        $res                        = $this->db->insert($table, $data['mediacoverage']);
        $insert_id = $this->db->insert_id();

        if($res)
        {
            $data['contents']['mediacoverage_id']      = $insert_id;
            
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
        $table                      = 'mediacoverage_new';
        $table2                     = 'contentsmediacoverage_new';

        $this->db->where($col, $val);
        $update                     = $this->db->update($table, $updatedata['mediacoverage']);

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

        $this->db->where('mediacoverage_id', $id);
        $this->db->update('mediacoverage_new', $update);

        return $this->db->affected_rows();
    }

    function _delete($col, $val) {
            
        $update['public']           = -1;
        $update['modified_on']      = date('Y-m-d H:i:s');
        $update['modified_by']      = $this->session->userdata('user_id');

        $table      = 'mediacoverage_new';
        $this->db->where($col, $val);
        //$res        = $this->db->delete($table);
        $res        = $this->db->update($table,$update);
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }

    function get_departmentsByInstitute($institute_id)
    {
        $this->db->select("d.Department_Id, d.Department_Name");
        $this->db->from('edu_department_dir d');
        //$this->db->join('department_by_institute di, d.Department_Id = di.department_id','left');
        $this->db->join('department_by_institute di',"FIND_IN_SET(d.Department_Id,di.department_id)",'left');
        $this->db->where('status', 1);
        $this->db->where('di.institute_id', $institute_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
}