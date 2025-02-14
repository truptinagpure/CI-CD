<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Disclosure_category extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/mandatory_disclosure/Disclosure_category_modal', 'disclosure_category');
        $this->load->model('cms/mandatory_disclosure/Mandatory_disclosure_modal', 'mandatory_disclosure');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

     function index()
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "mandatory_disclosure";
        $this->data['child_menu_type']      = "disclosure_category";
        $this->data['sub_child_menu_type']  = "disclosure_category";

        validate_permissions('disclosure_category', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list'] = $this->disclosure_category->get_documents_department_list(['dd.institute_id' => $this->session->userdata('sess_institute_id')]);
        // print_r($this->data['documents_department_list']);
        // exit();
        $this->data['title']                = _l("Disclosure Category",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/mandatory_disclosure/disclosure_category/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['title']                = 'Disclosure Category';
        $this->data['module']               = 'disclosure_category';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "mandatory_disclosure";
        $this->data['child_menu_type']      = "disclosure_category";
        $this->data['sub_child_menu_type']  = "save_disclosure_category";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        $this->data['sess_institute_id']    = $this->session->userdata('sess_institute_id');
        $this->data['sess_institute_name']  = $this->session->userdata('sess_institute_name');                                   
             
        $instituteID                        = $this->session->userdata('sess_institute_id');

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('disclosure_category', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        // print_r($this->input->post());
        // exit();
        $this->form_validation->set_rules('category_name', 'Category Name', 'required');
        

        if($this->form_validation->run($this) === TRUE)
        {
            // print_r($this->data['post_data']);
            // echo "<br>------------</br>";
            // print_r($this->data['post_data']['institute_id']);
            // echo "<br>------------</br>";
            // exit();
            if($this->input->post())
            {   
                
                if($id)
                {

                    $update['institute_id']                 = $instituteID;
                    $update['name']                         = $this->input->post('category_name');
                    $update['status']                       = $this->input->post('status');
                    $update['modified_on']                  = date('Y-m-d H:i:s');
                    $update['modified_by']                  = $this->session->userdata('user_id');

                    $response = $this->disclosure_category->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $industrial_visits_id               = $id;
                        $msg = ['error' => 0, 'message' => 'Disclosure Category successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['name']                         = $this->input->post('category_name');
                    $insert['institute_id']                 = $instituteID;
                    $insert['status']                       = $this->input->post('status');
                    $insert['created_on']                   = date('Y-m-d H:i:s');
                    $insert['created_by']                   = $this->session->userdata('user_id');
                    $insert['modified_on']                  = date('Y-m-d H:i:s');
                    $insert['modified_by']                  = $this->session->userdata('user_id');

                    $response                               = $this->disclosure_category->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $industrial_visits_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Disclosure Category successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/disclosure_category/');
            }
        }

        if($id!='')
        {
            $disclosure_category     = $this->disclosure_category->get_documents_department_list(['dd.id' => $id]);
            $this->data['post_data']  = isset($disclosure_category[0]) ? $disclosure_category[0] : [];
                        
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Documents Disclosure Category not found']);
                redirect(base_url()."cms/disclosure_category/");
            }
        }

        $this->data['all_institute']   = $this->disclosure_category->get_all_institute();
        
        $this->data['content']         = $this->load->view('cms/mandatory_disclosure/disclosure_category/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    
    function delete($id='')
    {

        $this->data['insta_id']             = $this->default_institute_id;
        //$this->data['insta_id'] = $id;
        validate_permissions('mandatory_disclosure_category', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
    
        $response = $this->disclosure_category->_delete('id', $id);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
       
        redirect(base_url().'cms/disclosure_category/');
    }

    
}
