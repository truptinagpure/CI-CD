<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Faq_sub_category extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/faq/Faq_category_model', 'category');
        $this->load->model('cms/faq/Faq_sub_category_model', 'sub_category');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['title']                = 'Sub Categories';
        $this->data['page']                 = 'Sub Categories';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "faq";
        $this->data['child_menu_type']      = "subcategories";
        $this->data['sub_child_menu_type']  = "subcategories";

        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Faq_sub_category', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);

        $this->data['data_list']            = $this->sub_category->get_sub_categories($this->data['insta_id']);

        $this->data['content']              = $this->load->view('cms/faq/sub_categories/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['title']                = 'Sub Categories';
        $this->data['page']                 = 'Sub Categories';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "faq";
        $this->data['child_menu_type']      = "subcategories";
        $this->data['sub_child_menu_type']  = "save_sub_category";
        $this->data['sub_child_menu_type']  = "save_sub_category";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        $per_action                         = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Faq_sub_category', 'edit', $per_action, $this->data['insta_id']);

        if($id!='')
        {
            $this->data['post_data']        = $this->sub_category->get_sub_category_data($this->data['insta_id'], $id);
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Faq sub category not found']);
                redirect(base_url()."cms/faq_sub_category/");
            }
        }

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        $this->data['category_list']        = $this->category->get_parent_categories($this->data['insta_id'], 1);
        $this->form_validation->set_rules('parent_id', 'Category', 'required|max_length[255]');
        $this->form_validation->set_rules('name', 'Sub category Name', 'required|max_length[255]');
        $this->form_validation->set_rules('status', 'Public', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {
                $this->common_model->set_table('faq_categories');
                if($id)
                {
                    $update['parent_id']        = $this->input->post('parent_id');
                    $update['name']             = $this->input->post('name');
                    $update['status']           = $this->input->post('status');
                    $update['modified_on']      = date('Y-m-d H:i:s');
                    $update['modified_by']      = $this->session->userdata('user_id');

                    $response = $this->common_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Sub category successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['institute_id']     = $this->data['insta_id'];
                    $insert['parent_id']        = $this->input->post('parent_id');
                    $insert['name']             = $this->input->post('name');
                    $insert['status']           = $this->input->post('status');
                    $insert['created_on']       = date('Y-m-d H:i:s');
                    $insert['created_by']       = $this->session->userdata('user_id');
                    $insert['modified_on']      = date('Y-m-d H:i:s');
                    $insert['modified_by']      = $this->session->userdata('user_id');

                    $response = $this->common_model->_insert($insert);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Sub category successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/faq_sub_category/');
            }
        }

        $this->data['content']              = $this->load->view('cms/faq/sub_categories/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Faq_sub_category', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $categorydata = $this->category->get_category_data($id);
        if(!empty($categorydata))
        {
            $this->common_model->set_table('faq_categories');
            $response = $this->common_model->_delete('id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Sub category not found.']);
        }
        redirect(base_url().'cms/faq_sub_category/');
    }

}
