<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Plant_category extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/vanaspatyam/Plant_category_model', 'category');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['main_menu_type']       = "vanaspatyam";
        $this->data['sub_menu_type']        = "vanaspatyam";
        $this->data['child_menu_type']      = "categories";
        $this->data['sub_child_menu_type']  = "categories";

        validate_permissions('Plant_category', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list']            = $this->category->get_parent_categories();
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/vanaspatyam/categories/category',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['title']                = 'Plant Categories';
        $this->data['page']                 = 'Plant Categories';
        $this->data['main_menu_type']       = "vanaspatyam";
        $this->data['sub_menu_type']        = "vanaspatyam";
        $this->data['child_menu_type']      = "categories";
        $this->data['sub_child_menu_type']  = "save_category";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        
        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Plant_category', 'edit', $per_action, $this->data['insta_id']);

        if($id!='')
        {
            $this->data['post_data']        = $this->category->get_category_data($id);
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Plant category not found']);
                redirect(base_url()."cms/plant_category/");
            }
        }

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        $this->form_validation->set_rules('name', 'Category Name', 'required|max_length[255]');
        $this->form_validation->set_rules('status', 'Public', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {
                $this->common_model->set_table('plant_categories');
                if($id)
                {
                    $update['name']             = $this->input->post('name');
                    $update['status']           = $this->input->post('status');
                    $update['modified_on']      = date('Y-m-d H:i:s');
                    $update['modified_by']      = $this->session->userdata('user_id');

                    $response = $this->common_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Category successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['name']             = $this->input->post('name');
                    $insert['status']           = $this->input->post('status');
                    $insert['created_on']       = date('Y-m-d H:i:s');
                    $insert['created_by']       = $this->session->userdata('user_id');
                    $insert['modified_on']      = date('Y-m-d H:i:s');
                    $insert['modified_by']      = $this->session->userdata('user_id');

                    $response = $this->common_model->_insert($insert);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Category successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/plant_category/');
            }
        }

        $this->data['content']              = $this->load->view('cms/vanaspatyam/categories/category_form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $this->data['insta_id'] = $this->default_institute_id;
        validate_permissions('Plant_category', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $categorydata = $this->category->get_category_data($id);
        if(!empty($categorydata))
        {
            $this->common_model->set_table('plant_categories');
            $response = $this->common_model->_delete('id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Category not found.']);
        }
        redirect(base_url().'cms/plant_category/');
    }

}
