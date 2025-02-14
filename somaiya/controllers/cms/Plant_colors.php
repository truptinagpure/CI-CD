<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Plant_colors extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/vanaspatyam/Plant_colors_model', 'colors');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {   
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['main_menu_type']       = "vanaspatyam";
        $this->data['sub_menu_type']        = "vanaspatyam";
        $this->data['child_menu_type']      = "colors";
        $this->data['sub_child_menu_type']  = "colors";

        validate_permissions('Plant_colors', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list']            = $this->colors->get_colors();
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/vanaspatyam/colors/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['title']                = 'Plant Colors';
        $this->data['page']                 = 'Plant Colors';
        $this->data['main_menu_type']       = "vanaspatyam";
        $this->data['sub_menu_type']        = "vanaspatyam";
        $this->data['child_menu_type']      = "colors";
        $this->data['sub_child_menu_type']  = "save_color";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        
        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Plant_colors', 'edit', $per_action, $this->data['insta_id']);

        if($id!='')
        {
            $this->data['post_data']        = $this->colors->get_color_data($id);
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Plant color not found']);
                redirect(base_url()."cms/plant_colors/");
            }
        }

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        $this->form_validation->set_rules('name', 'Color Name', 'required|max_length[255]');
        if(!empty($this->input->post('color_code')))
        {
            $this->form_validation->set_rules('color_code', 'Color Code', 'max_length[7]');
        }
        $this->form_validation->set_rules('status', 'Public', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {
                $this->common_model->set_table('plant_colors');
                if($id)
                {
                    $update['name']             = $this->input->post('name');
                    $update['color_code']       = $this->input->post('color_code');
                    $update['status']           = $this->input->post('status');
                    $update['modified_on']      = date('Y-m-d H:i:s');
                    $update['modified_by']      = $this->session->userdata('user_id');

                    $response = $this->common_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Color successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['name']             = $this->input->post('name');
                    $insert['color_code']       = $this->input->post('color_code');
                    $insert['status']           = $this->input->post('status');
                    $insert['created_on']       = date('Y-m-d H:i:s');
                    $insert['created_by']       = $this->session->userdata('user_id');
                    $insert['modified_on']      = date('Y-m-d H:i:s');
                    $insert['modified_by']      = $this->session->userdata('user_id');

                    $response = $this->common_model->_insert($insert);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Color successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/plant_colors/');
            }
        }

        $this->data['content']              = $this->load->view('cms/vanaspatyam/colors/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $this->data['insta_id'] = $this->default_institute_id;
        validate_permissions('Plant_colors', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $colordata = $this->colors->get_color_data($id);
        if(!empty($colordata))
        {
            $this->common_model->set_table('plant_colors');
            $response = $this->common_model->_delete('id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Color not found.']);
        }
        redirect(base_url().'cms/plant_colors/');
    }
}
