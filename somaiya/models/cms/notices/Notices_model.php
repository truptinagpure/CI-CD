<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Notices_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_notices_list($conditions=[])
    {
        $this->db->select('nc.*, eid.INST_NAME');
        $this->db->from('notices nc');
        $this->db->join('edu_institute_dir eid', 'nc.institute_id = eid.INST_ID', 'left');
        

        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->where('nc.status !=', '-1');
        $this->db->order_by('nc.id','DESC');
        $query = $this->db->get();

        // $str = $this->db->last_query();
   
        // echo "<pre>";
        // print_r($str);
        // exit;
        return $query->result_array();
    }

    function _insert($data,$notice_urls) {

        $response['status']         = 'failed';
        $table                      = 'notices';
        $res                        = $this->db->insert($table, $data);
        if($res)
        {
            $response['status']     = 'success';
            $response['id']         = $this->db->insert_id();

            foreach ($notice_urls as $key => $value) {
                $this->db->insert('notices_urls',array("link_name"=>$key,"link_url"=>$value,"notices_id"=>$response['id'],"created_on"=>date('Y-m-d H:i:s'),"created_by"=>$this->session->userdata('user_id')));
            }
        }
        else
        {
            $response['status']     = 'error';
            $response['message']    = $this->db->_error_message();
        }
        return  $response;
    }

    function _update($col, $val, $updatedata, $data) {
        $response['status']         = 'error';
        $table                      = 'notices';
        $this->db->where($col, $val);
        $update                     = $this->db->update($table, $updatedata);
        if($update)
        {
            $response['status']     = 'success';
            $response[$col]         = $val;

            if($val!=null) 
            {
                $save = [];
                $save_user_group = [];
                foreach ($data['link_name'] as $key => $value) 
                {

                    $save['link_name']  = $value;
                    $save['link_url']   = $data['link_url'][$key];
                    $save['id']         = $data['id2'][$key];
                    $save_group_inst[]  = $save;
                }

                $notice_id = $val;
                $id2    = $this->input->post('id2');

                if($id2 == '')
                { 

                    if(isset($data['links_array_check']) && $data['links_array_check'] == 1){ 
                        foreach($save_group_inst as $result){     
                            $this->db->insert('notices_urls',array("link_name"=>$result['link_name'],"link_url"=>$result['link_url'],"notices_id"=>$notice_id,"created_on"=>date('Y-m-d H:i:s'),"created_by"=>$this->session->userdata('user_id')));
                            $pinsert[] = $this->db->insert_id();
                        }
                    }
                } 

                if(isset($data['links_array_check']) && $data['links_array_check'] == 2)
                { 
                    
                    if (!empty($save_group_inst))  {  
                        foreach($save_group_inst as $key => $result){ 
                            if($result['id'] == ''){
                                $this->db->insert('notices_urls',array("link_name"=>$result['link_name'],"link_url"=>$result['link_url'],"notices_id"=>$notice_id,"created_on"=>date('Y-m-d H:i:s'),"created_by"=>$this->session->userdata('user_id')));
                                $pinsert[] = $this->db->insert_id();
                            }


                            $this->db->where('id',$result['id']);
                            $this->db->update('notices_urls',array("link_name"=>$result['link_name'],"link_url"=>$result['link_url'],"notices_id"=>$notice_id,"modified_on"=>date('Y-m-d H:i:s'),"modified_by"=>$this->session->userdata('user_id'))); 
                        }
                    }
                } 
            }
        }
        else
        {
            $response['status']     = 'error';
            $response['message']    = $this->db->_error_message();
        }
        return $response;
    }
    
    

    function _delete($col, $val) {

        $table      = 'notices';
        $this->db->set('status', -1);
        $this->db->where($col, $val);
        //$res        = $this->db->delete($table);
        $res        = $this->db->update($table);

        if($res)
        {
            $this->db->delete('notices_urls', array('notices_id' => $val));
            // $table2      = 'notices_urls';
            // $this->db->set('status', -1);
            // $this->db->where('notices_id', $val);
            // $this->db->update($table2);
        }

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

    function get_all_department()
    {
        $this->db->select("Department_Id, Department_Name");
        $this->db->from('edu_department_dir');
        $this->db->order_by('Department_Name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function get_all_notice_category($id_of_institute)
    {
        // $this->db->select("id, name");
        // $this->db->from('notices_category');
        // $this->db->where('status', 1);
        // $this->db->order_by('name', 'ASC');
        // $query = $this->db->get();
        // return $query->result_array();
    }

    function getParentCategoryByInstitute($id_of_institute)
    {
        $this->db->select('nc.id,nc.name');
        $this->db->from('notices_category nc');
        $this->db->where('nc.institute_id',$id_of_institute);
        $this->db->where('nc.status', 1);
        $this->db->where('nc.comes_under', 0);
        $this->db->order_by('nc.name', 'ASC');
           
        $query  = $this->db->get();
        return $query->result_array();
    }

    function get_subCategoryData($category_id)
    {
        $this->db->select('nc.id,nc.name');
        $this->db->from('notices_category nc');
        $this->db->where('nc.comes_under',$category_id);
        $this->db->where('nc.status', 1);
        $this->db->order_by('nc.name', 'ASC');
           
        $query  = $this->db->get();
        $return = $query->result_array();

        return $return;

    }

    function get_all_academic_year_by_institute($institute_id)
    {
        // $this->db->select('ay.academic_year_id, ay.academic_year_name');
        // $this->db->from('academic_year ay');
        // $this->db->join('map_default_inst_year mdy', 'ay.academic_year_id = mdy.academic_year_id', 'left');
        // $this->db->where('mdy.inst_id', $institute_id);
        // $this->db->order_by('ay.academic_year_id', 'DESC');
        // $query = $this->db->get();
        // return $query->result_array();

        $this->db->select('distinct(ay.academic_year_name)');
        $this->db->from('academic_year ay');
        $this->db->limit(4);
        $this->db->order_by('ay.academic_year_id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_links($id)
    {
        $this->db->select('*');
        $this->db->from('notices_urls');
        $this->db->where('notices_id', $id);
        $this->db->where('status =', 1);
        $this->db->order_by('link_order', 'ASC');
        $query = $this->db->get();
        return  $query->result_array();
    }
}