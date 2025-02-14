<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Donation_type extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/donation/Type_model', 'type');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['title']                = 'Donation Type';
        $this->data['page']                 = 'Donation Type';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "donation";
        $this->data['child_menu_type']      = "donation_type";
        $this->data['sub_child_menu_type']  = "donation_type";
        $this->data['page']                 = 'Donation Type';

        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Donation_type', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        // $this->data['data_list']            = $this->type->get_parent_type($instituteID);
        $this->data['data_list']            = $this->type->get_parent_type();
        $this->data['content']              = $this->load->view('cms/donation/type/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['title']                = 'Donation Type';
        $this->data['page']                 = 'Donation Type';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "donation";
        $this->data['child_menu_type']      = "donation_type";
        $this->data['sub_child_menu_type']  = "save_type";
        $this->data['sub_child_menu_type']  = "save_type";
        $this->data['post_data']            = [];
        $this->data['dontype_id']           = $id;
        
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        $per_action                         = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Donation_type', 'edit', $per_action, $this->data['insta_id']);

        if($id!='')
        {
            // $this->data['post_data']        = $this->type->get_type_data($id, $instituteID);
            $this->data['post_data']        = $this->type->get_type_data($id);
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Donation type not found']);
                redirect(base_url()."cms/donation_type/");
            }
        }

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        $this->form_validation->set_rules('donation_type', 'Type Name', 'required|max_length[255]');
        $this->form_validation->set_rules('public', 'Publish', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {
                $this->common_model->set_table('donation_type');
                if($id)
                {
                    $update['donation_type']    = $this->input->post('donation_type');
                    // $update['institute_id']     = $instituteID;
                    $update['public']           = $this->input->post('public');
                    $update['modified_on']      = date('Y-m-d H:i:s');
                    $update['modified_by']      = $this->session->userdata('user_id');

                    $response = $this->common_model->_update('dontype_id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Type successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['donation_type']    = $this->input->post('donation_type');
                    // $insert['institute_id']     = $instituteID;
                    $insert['public']           = $this->input->post('public');
                    $insert['created_on']       = date('Y-m-d H:i:s');
                    $insert['created_by']       = $this->session->userdata('user_id');
                    $insert['modified_on']      = date('Y-m-d H:i:s');
                    $insert['modified_by']      = $this->session->userdata('user_id');

                    $response = $this->common_model->_insert($insert);
                    if(isset($response['public']) && $response['public'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Type successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/donation_type/');
            }
        }

        $this->data['content']              = $this->load->view('cms/donation/type/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Donation_type', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        // $typedata = $this->type->get_type_data($id, $instituteID);
        $typedata = $this->type->get_type_data($id);
        if(!empty($typedata))
        {
            $this->common_model->set_table('donation_type');
            $response = $this->common_model->_delete('dontype_id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Type not found.']);
        }
        redirect(base_url().'cms/donation_type/');
    }

}
