<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Language extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/language/Language_model', 'language');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['main_menu_type']       = "masters";
        $this->data['sub_menu_type']        = "language";
        $this->data['child_menu_type']      = "language";
        $this->data['sub_child_menu_type']  = "language";

        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Language', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list']            = $this->language->get_language();
        $this->data['title']                = 'Language';
        $this->data['page']                 = "Language";
        $this->data['content']              = $this->load->view('cms/language/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['title']                = 'Language';
        $this->data['module']               = 'Language';
        $this->data['main_menu_type']       = "masters";
        $this->data['sub_menu_type']        = "language";
        $this->data['child_menu_type']      = "save_language";
        $this->data['sub_child_menu_type']  = "";
        $this->data['post_data']            = [];
        $this->data['language_id']          = $id;
        $this->data['post_data']['public']  = 1;
        
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        $per_action                         = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Language', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
            // echo "<pre>"; print_r($this->data['post_data']);exit();
        }

        $this->form_validation->set_rules('language_name', 'Language Name', 'required|max_length[250]');
        $this->form_validation->set_rules('status', 'Status', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                $this->common_model->set_table('languages');
                if($id)
                {   
                    $update['language_name']            = $this->input->post('language_name');
                    $update['code']                     = $this->input->post('code');
                    $update['sort_order']               = $this->input->post('sort_order');
                    $update['default']                  = $this->input->post('default');
                    $update['public']                   = $this->input->post('status');
                    $update['modified_on']              = date('Y-m-d H:i:s');
                    $update['modified_by']              = $this->session->userdata('user_id');

                    $response = $this->common_model->_update('language_id', $id, $update);
                    if(isset($response['public']) && $response['public'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Language successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {   
                    $insert['language_name']            = $this->input->post('language_name');
                    $insert['code']                     = $this->input->post('code');
                    $insert['sort_order']               = $this->input->post('sort_order');
                    $insert['default']                  = $this->input->post('default');
                    $insert['public']                   = $this->input->post('status');
                    $insert['created_on']               = date('Y-m-d H:i:s');
                    $insert['created_by']               = $this->session->userdata('user_id');
                    $insert['modified_on']              = date('Y-m-d H:i:s');
                    $insert['modified_by']              = $this->session->userdata('user_id');

                    $response                           = $this->common_model->_insert($insert);
                    if(isset($response['public']) && $response['public'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Language successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/language/');
            }
        }

        if($id!='')
        {
            $language                         = $this->language->get_language(['f.language_id' => $id, 'f.public !=' => '-1']);
            $this->data['post_data']        = isset($language[0]) ? $language[0] : [];
            
            if(empty($this->data['post_data']))
            {   
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'language not found']);
                redirect(base_url()."cms/language/");
            }
        }

        $this->data['content']          = $this->load->view('cms/language/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Language', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $language                          = $this->language->get_language(['f.language_id' => $id, 'f.public !=' => '-1']);

        if(!empty($language))
        {
            $this->common_model->set_table('languages');
            $response = $this->common_model->_delete('language_id', $id);

            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'language not found.']);
        }
        redirect(base_url().'cms/language');
    }

}
