<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Whats_new extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/whats_new/Whats_new_model', 'whats_new');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "whats_new";
        $this->data['child_menu_type']      = "whats_new";
        $this->data['sub_child_menu_type']  = "whats_new";

        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Whats_new', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list']            = $this->whats_new->get_whats_new(['f.institute_id' => $instituteID]);
        $this->data['title']                = 'Whats_new';
        $this->data['page']                 = "Whats_new";
        $this->data['content']              = $this->load->view('cms/whats_new/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['title']                = 'Whats_new';
        $this->data['module']               = 'Whats_new';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "whats_new";
        $this->data['child_menu_type']      = "whats_new";
        $this->data['sub_child_menu_type']  = "save_whats_new";
        $this->data['post_data']            = [];
        $this->data['whatsnew_id']          = $id;
        $this->data['post_data']['public']  = 1;
        
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        $per_action                         = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Whats_new', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
            //echo "<pre>"; print_r($this->data['post_data']);exit();
        }

        $this->form_validation->set_rules('title', 'Title', 'required|max_length[250]');
        $this->form_validation->set_rules('status', 'Status', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                $this->common_model->set_table('whatsnew');
                if($id)
                {   
                    $update['title']                    = $this->input->post('title');
                    $update['publish_date']             = $this->input->post('publish_date');
                    $update['whats_new_expiry_date']    = $this->input->post('whats_new_expiry_date');
                    $update['institute_id']             = $instituteID;
                    $update['url']                      = $this->input->post('url');
                    $update['public']                   = $this->input->post('status');
                    $update['newtab']                   = $this->input->post('newtab');
                    $update['modified_on']              = date('Y-m-d H:i:s');
                    $update['modified_by']              = $this->session->userdata('user_id');

                    $response = $this->common_model->_update('whatsnew_id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Whats New successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {   
                    $insert['title']                    = $this->input->post('title');
                    $insert['publish_date']             = $this->input->post('publish_date');
                    $insert['whats_new_expiry_date']    = $this->input->post('whats_new_expiry_date');
                    $insert['institute_id']             = $instituteID;
                    $insert['url']                      = $this->input->post('url');
                    $insert['public']                   = $this->input->post('status');
                    $insert['newtab']                   = $this->input->post('newtab');
                    $insert['created_on']               = date('Y-m-d H:i:s');
                    $insert['created_by']               = $this->session->userdata('user_id');
                    $insert['modified_on']              = date('Y-m-d H:i:s');
                    $insert['modified_by']              = $this->session->userdata('user_id');

                    $response                           = $this->common_model->_insert($insert);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Whats new successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/whats_new/');
            }
        }

        if($id!='')
        {
            $whats_new                         = $this->whats_new->get_whats_new(['f.whatsnew_id' => $id, 'f.public !=' => '-1']);
            $this->data['post_data']           = isset($whats_new[0]) ? $whats_new[0] : [];
            
            if(empty($this->data['post_data']))
            {   
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'whats new not found']);
                redirect(base_url()."cms/whats_new/");
            }
        }

        $this->data['location']         = $this->Somaiya_general_admin_model->get_all_locations();
        $this->data['content']          = $this->load->view('cms/whats_new/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Whats_new', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $whats_new                          = $this->whats_new->get_whats_new(['f.whatsnew_id' => $id, 'f.public !=' => '-1']);

        if(!empty($whats_new))
        {
            $this->common_model->set_table('whatsnew');
            $response = $this->common_model->_delete('whatsnew_id', $id);

            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'whats new not found.']);
        }
        redirect(base_url().'cms/whats_new');
    }

}
