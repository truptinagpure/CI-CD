<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Frequent_contact extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/frequent_contact/Frequent_contact_model', 'frequent_contact');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {   
        $this->data['main_menu_type']       = "masters";
        $this->data['sub_menu_type']        = "frequent_contact";
        $this->data['child_menu_type']      = "frequent_contact";
        $this->data['sub_child_menu_type']  = "frequent_contact";

        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Frequent_contact', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list']            = $this->frequent_contact->get_frequent_contact(['f.institute_id' => $instituteID]);
        $this->data['title']                = 'Frequent_contact';
        $this->data['page']                 = "Frequent_contact";
        $this->data['content']              = $this->load->view('cms/frequent_contact/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['title']                = 'Frequent_contact';
        $this->data['module']               = 'Frequent_contact';
        $this->data['main_menu_type']       = "masters";
        $this->data['sub_menu_type']        = "frequent_contact";
        $this->data['child_menu_type']      = "frequent_contact";
        $this->data['sub_child_menu_type']  = "save_frequent_contact";
        $this->data['post_data']            = [];
        $this->data['institute_contact_id'] = $id;
        $this->data['post_data']['public']  = 1;
        
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        $per_action                         = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Frequent_contact', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
            //echo "<pre>"; print_r($this->data['post_data']);exit();
        }

        $this->form_validation->set_rules('type', 'Contact Type', 'required|max_length[250]');
        $this->form_validation->set_rules('status', 'Status', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                $this->common_model->set_table('institute_contact');
                if($id)
                {   
                    $update['type']                     = $this->input->post('type');
                    $update['email']                    = $this->input->post('email');
                    $update['extention']                = $this->input->post('extention');
                    $update['institute_id']             = $instituteID;
                    $update['contact_number']           = $this->input->post('contact_number');
                    $update['order_by']                 = $this->input->post('order_by');
                    $update['public']                   = $this->input->post('status');
                    $update['modified_on']              = date('Y-m-d H:i:s');
                    $update['modified_by']              = $this->session->userdata('user_id');

                    $response = $this->common_model->_update('institute_contact_id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Frequent contact successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {   
                    $insert['type']                     = $this->input->post('type');
                    $insert['email']                    = $this->input->post('email');
                    $insert['extention']                = $this->input->post('extention');
                    $insert['institute_id']             = $instituteID;
                    $insert['contact_number']           = $this->input->post('contact_number');
                    $insert['order_by']                 = $this->input->post('order_by');
                    $insert['public']                   = $this->input->post('status');
                    $insert['created_on']               = date('Y-m-d H:i:s');
                    $insert['created_by']               = $this->session->userdata('user_id');
                    $insert['modified_on']              = date('Y-m-d H:i:s');
                    $insert['modified_by']              = $this->session->userdata('user_id');

                    $response                           = $this->common_model->_insert($insert);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Frequent contact successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/frequent_contact/');
            }
        }

        if($id!='')
        {
            $frequent_contact                         = $this->frequent_contact->get_frequent_contact(['f.institute_contact_id' => $id, 'f.public !=' => '-1']);
            $this->data['post_data']           = isset($frequent_contact[0]) ? $frequent_contact[0] : [];
            
            if(empty($this->data['post_data']))
            {   
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Frequent contact not found']);
                redirect(base_url()."cms/frequent_contact/");
            }
        }

        $this->data['content']          = $this->load->view('cms/frequent_contact/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('frequent_contact', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $frequent_contact                          = $this->frequent_contact->get_frequent_contact(['f.institute_contact_id' => $id, 'f.public !=' => '-1']);

        if(!empty($frequent_contact))
        {
            $this->common_model->set_table('institute_contact');
            $response = $this->common_model->_delete('institute_contact_id', $id);

            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Frequent contact not found.']);
        }
        redirect(base_url().'cms/frequent_contact');
    }

}
