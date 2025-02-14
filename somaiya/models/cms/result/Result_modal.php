<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Result_modal extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_result_list($conditions=[])
    {
        $this->db->select('r.*, eid.INST_NAME');
        $this->db->from('result r');
        $this->db->join('edu_institute_dir eid', 'r.institute_id = eid.INST_ID', 'left');
        

        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->where('r.status !=', '-1');
        $this->db->order_by('r.id','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    function _insert($data,$result_urls) {

        $response['status']         = 'failed';
        $table                      = 'result';
        $res                        = $this->db->insert($table, $data);
        if($res)
        {
            $response['status']     = 'success';
            $response['id']         = $this->db->insert_id();

            foreach ($result_urls as $key => $value) {
                $this->db->insert('result_urls',array("link_name"=>$key,"link_url"=>$value,"result_id"=>$response['id'],"created_on"=>date('Y-m-d H:i:s'),"created_by"=>$this->session->userdata('user_id')));
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
        $table                      = 'result';
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

                $result_id = $val;
                $id2    = $this->input->post('id2');

                if($id2 == '')
                { 

                    if(isset($data['links_array_check']) && $data['links_array_check'] == 1){ 
                        foreach($save_group_inst as $result){     
                            $this->db->insert('result_urls',array("link_name"=>$result['link_name'],"link_url"=>$result['link_url'],"result_id"=>$result_id,"created_on"=>date('Y-m-d H:i:s'),"created_by"=>$this->session->userdata('user_id')));
                            $pinsert[] = $this->db->insert_id();
                        }
                    }
                } 

                if(isset($data['links_array_check']) && $data['links_array_check'] == 2)
                { 
                    
                    if (!empty($save_group_inst))  {  
                        foreach($save_group_inst as $key => $result){ 
                            if($result['id'] == ''){
                                $this->db->insert('result_urls',array("link_name"=>$result['link_name'],"link_url"=>$result['link_url'],"result_id"=>$result_id,"created_on"=>date('Y-m-d H:i:s'),"created_by"=>$this->session->userdata('user_id')));
                                $pinsert[] = $this->db->insert_id();
                            }


                            $this->db->where('id',$result['id']);
                            $this->db->update('result_urls',array("link_name"=>$result['link_name'],"link_url"=>$result['link_url'],"result_id"=>$result_id,"modified_on"=>date('Y-m-d H:i:s'),"modified_by"=>$this->session->userdata('user_id'))); 
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

        $table      = 'result';
        $this->db->set('status', -1);
        $this->db->where($col, $val);
        //$res        = $this->db->delete($table);
        $res        = $this->db->update($table);

        if($res)
        {
            $this->db->delete('result_urls', array('result_id' => $val));
            // $table2      = 'result_urls';
            // $this->db->set('status', -1);
            // $this->db->where('result_id', $val);
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

    
    
    function getCategoryByInstitute($id_of_institute)
    {
        $this->db->select('rc.id,rc.name');
        $this->db->from('result_category rc');
        $this->db->where('rc.institute_id',$id_of_institute);
        $this->db->where('rc.status', 1);
        $this->db->order_by('rc.name', 'ASC');
           
        $query  = $this->db->get();
        return $query->result_array();
    }

    function get_subCategoryData($id_of_institute)
    {
        $this->db->select('rsc.id,rsc.name');
        $this->db->from('result_sub_category rsc');
        $this->db->where('rsc.institute_id',$id_of_institute);
        $this->db->where('rsc.status', 1);
        $this->db->order_by('rsc.name', 'ASC');
           
        $query  = $this->db->get();
        $return = $query->result_array();

        return $return;

    }

    function get_all_academic_year_by_institute($institute_id)
    {
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
        $this->db->from('result_urls');
        $this->db->where('result_id', $id);
        $this->db->where('status =', 1);
        $this->db->order_by('link_order', 'ASC');
        $query = $this->db->get();
        return  $query->result_array();
    }

    function get_result_subcategory_by_cat_id($category_id)
    {
        $this->db->select("rsc.id, rsc.name");
        $this->db->from('result_sub_category rsc');

        if(count($category_id) >= 2)
        {
            $category = implode(',', $category_id);
            $this->db->where_in('rsc.result_category_id', $category); 
        }
        else
        {
            $category = $category_id;
            //$this->db->where('rsc.result_category_id', $category);
            $this->db->where('find_in_set("'.$category.'", rsc.result_category_id) <> 0'); 

        }

        $this->db->where('rsc.status =', '1');
        $this->db->order_by('rsc.id', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
}