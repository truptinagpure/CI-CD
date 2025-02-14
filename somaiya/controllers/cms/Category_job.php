<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Category_job extends Somaiya_Controller
{
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/career/Category_job_model', 'career');
        $user_id = $this->session->userdata['user_id'];
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "career";
        $this->data['child_menu_type']      = "jobcat";
        $this->data['sub_child_menu_type']  = "";
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
        $inst_id  = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Category_job', 'index', $this->config->item('method_for_view'), $inst_id);
        $this->data['data_list']    = $this->career->get_category($inst_id);
        $this->data['title']        = 'jobcat';
        $this->data['page']         = 'jobcat';
        $this->data['content']      = $this->load->view('cms/career/category',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);

    }


   function edit($id='')
    {

        $this->data['main_menu_type']      = "institute_menu";
        $this->data['sub_menu_type']       = "career";
        $this->data['child_menu_type']     = "jobcat";
        $this->data['sub_child_menu_type'] = "";
        $allowed_inst_ids          = [];
        $save_data                 = [];
        $instituteID               = $this->session->userdata('sess_institute_id');
        $inst_id    = isset($instituteID) ? $instituteID : $this->default_institute_id;
        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Category_job', 'edit', $per_action, $inst_id);
        $status      =-1;
        $this->data['title']                = 'jobcat';
        $this->data['page']                 = 'jobcat';
        $this->data['data']                 = [];
        $this->data['pressrelease_id']      = $id;
        $this->data['data']['public']       = 1;
      
        if($id)
        {
            $this->data['data']= $this->career->get_category_details($id,$inst_id);
            if(empty($this->data['data']))
            {
          $this->session->set_flashdata('requeststatus',['error'=>1,'message'=>'Job Category not found'.$inst_id]);
          redirect(base_url().'cms/category_job');
            } 
        }  
        if($this->input->post())
        {
            $this->data['data']= $this->input->post();
        }
        $this->form_validation->set_rules('name', 'Category Name', 'required|max_length[250]');
        if($this->form_validation->run($this) === TRUE)
        { 
            if($this->input->post())
            {   
                if($id)
                {
                     $update['career_category']['category_name']    = $this->input->post('name');
                     $update['career_category']['status']           = $this->input->post('status');
                     $update['career_category']['modified_on']      = date('Y-m-d H:i:s');
                     $update['career_category']['modified_by']      = $this->session->userdata['user_id'];
                     $condition                                          = array('cat_id' => $id, 'institute_id'=>$inst_id  );
                    $response = $this->career->_update($condition, $update);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Job Category  successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['career_category']['category_name']      = $this->input->post('name');
                    $insert['career_category']['institute_id']       = $inst_id ;
                    $insert['career_category']['status']             = $this->input->post('status');
                    $insert['career_category']['created_on']         = date('Y-m-d H:i:s');
                    $insert['career_category']['created_by']         = $this->session->userdata['user_id'];
                    $insert['career_category']['modified_on']        = date('Y-m-d H:i:s');
                    $insert['career_category']['modified_by']        = $this->session->userdata['user_id'];
                    $response   = $this->career->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $post_id           = $response['cat_id'];
                        $msg = ['error' => 0, 'message' => 'Job Category successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }

                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/category_job');
            }//end post
          //  end validations
        }
     
         $this->data['content'] = $this->load->view('cms/career/form_category',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data); 
    }

    //delete start here

    function delete($id='')
    {
        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
        validate_permissions('Category_job','delete',$this->config->item('method_for_delete'),$this->data['institute_id']);
        $condition  = array('cat_id' => $id, 'institute_id'=>$this->data['institute_id']   );
        $post = $this->career->get_category_details($id,$this->data['institute_id']);

        if(!empty($post))
        {
            $this->common_model->set_table('career_category');
            $response = $this->common_model->_delete('cat_id', $id);

            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
        $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Job Category not found.']);
        }
            redirect(base_url().'cms/category_job');
    }
}


?>