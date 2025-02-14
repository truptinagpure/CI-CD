<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Awards_sub_type extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/awards/Type_model', 'type');
        $this->load->model('cms/awards/Sub_type_model', 'sub_type');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['title']                = 'Sub Type';
        $this->data['page']                 = 'Sub Type';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "awards";
        $this->data['child_menu_type']      = "awards_sub_type";
        $this->data['sub_child_menu_type']  = "awards_sub_type";

        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Awards_sub_type', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);

        $this->data['data_list']            = $this->sub_type->get_sub_type();

        $this->data['content']              = $this->load->view('cms/awards/sub_type/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['title']                = 'Sub Type';
        $this->data['page']                 = 'Sub Type';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "awards";
        $this->data['child_menu_type']      = "awards_sub_type";
        $this->data['sub_child_menu_type']  = "save_sub_type";
        $this->data['sub_child_menu_type']  = "save_sub_type";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        $per_action                         = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Awards_sub_type', 'edit', $per_action, $this->data['insta_id']);

        if($id!='')
        {
            $this->data['post_data']        = $this->sub_type->get_sub_type_data($this->data['insta_id'],$id);
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Awards sub type not found']);
                redirect(base_url()."cms/awards_sub_type/");
            }
        }

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        $this->data['type_list']        = $this->type->get_parent_type(1);
        $this->form_validation->set_rules('parent_id', 'Type', 'required|max_length[255]');
        $this->form_validation->set_rules('name', 'Sub type Name', 'required|max_length[255]');
        $this->form_validation->set_rules('status', 'Publish', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {
                $this->common_model->set_table('awards_type');
                if($id)
                {
                    $update['parent_id']        = $this->input->post('parent_id');
                    $update['name']             = $this->input->post('name');
                    $update['institute_id']     = $instituteID;
                    $update['status']           = $this->input->post('status');
                    $update['modified_on']      = date('Y-m-d H:i:s');
                    $update['modified_by']      = $this->session->userdata('user_id');

                    $response = $this->common_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Sub type successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['parent_id']        = $this->input->post('parent_id');
                    $insert['name']             = $this->input->post('name');
                    $insert['institute_id']     = $instituteID;
                    $insert['status']           = $this->input->post('status');
                    $insert['created_on']       = date('Y-m-d H:i:s');
                    $insert['created_by']       = $this->session->userdata('user_id');
                    $insert['modified_on']      = date('Y-m-d H:i:s');
                    $insert['modified_by']      = $this->session->userdata('user_id');

                    $response = $this->common_model->_insert($insert);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Sub type successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/awards_sub_type/');
            }
        }

        $this->data['content']              = $this->load->view('cms/awards/sub_type/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Awards_sub_type', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $typedata = $this->type->get_type_data($id);
        if(!empty($typedata))
        {
            $this->common_model->set_table('awards_type');
            $response = $this->common_model->_delete('id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Sub type not found.']);
        }
        redirect(base_url().'cms/awards_sub_type/');
    }

}
