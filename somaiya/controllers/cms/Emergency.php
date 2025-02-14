<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Emergency extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/emergency/Emergency_model', 'emergency');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "emergency";
        $this->data['child_menu_type']      = "emergency";
        $this->data['sub_child_menu_type']  = "emergency";

        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Emergency', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list']            = $this->emergency->get_emergency(['f.institute_id' => $instituteID]);
        $this->data['title']                = 'Emergency';
        $this->data['page']                 = "Emergency";
        $this->data['content']              = $this->load->view('cms/emergency/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['title']                = 'Emergency';
        $this->data['module']               = 'Emergency';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "emergency";
        $this->data['child_menu_type']      = "save_emergency";
        $this->data['sub_child_menu_type']  = "";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        $this->data['post_data']['status']  = 1;
        
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        $per_action                         = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Emergency', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
            // echo "<pre>"; print_r($this->data['post_data']);exit();
        }

        $this->form_validation->set_rules('emergency_name', 'Emergency Name', 'required|max_length[250]');
        $this->form_validation->set_rules('status', 'Status', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                $this->common_model->set_table('emergency');
                if($id)
                {   
                    $update['emergency_name']           = $this->input->post('emergency_name');
                    $update['location_id']              = $this->input->post('location_id');
                    $update['severity']                 = $this->input->post('severity');
                    $update['institute_id']             = $instituteID;
                    $update['from_date']                = $this->input->post('from_date');
                    $update['to_date']                  = $this->input->post('to_date');
                    $update['description']              = $this->input->post('description');
                    $update['status']                   = $this->input->post('status');
                    $update['modified_on']              = date('Y-m-d H:i:s');
                    $update['modified_by']              = $this->session->userdata('user_id');

                    $response = $this->common_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Emergency successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {   
                    $insert['emergency_name']           = $this->input->post('emergency_name');
                    $insert['location_id']              = $this->input->post('location_id');
                    $insert['severity']                 = $this->input->post('severity');
                    $insert['institute_id']             = $instituteID;
                    $insert['from_date']                = $this->input->post('from_date');
                    $insert['to_date']                  = $this->input->post('to_date');
                    $insert['description']              = $this->input->post('description');
                    $insert['status']                   = $this->input->post('status');
                    $insert['created_on']               = date('Y-m-d H:i:s');
                    $insert['created_by']               = $this->session->userdata('user_id');
                    $insert['modified_on']              = date('Y-m-d H:i:s');
                    $insert['modified_by']              = $this->session->userdata('user_id');

                    $response                           = $this->common_model->_insert($insert);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Emergency successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/emergency/');
            }
        }

        if($id!='')
        {
            $emergency                         = $this->emergency->get_emergency(['f.id' => $id, 'f.status !=' => '-1']);
            $this->data['post_data']        = isset($emergency[0]) ? $emergency[0] : [];
            
            if(empty($this->data['post_data']))
            {   
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'emergency not found']);
                redirect(base_url()."cms/emergency/");
            }
        }

        $this->data['location']         = $this->Somaiya_general_admin_model->get_all_locations();
        $this->data['content']          = $this->load->view('cms/emergency/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Emergency', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $emergency                          = $this->emergency->get_emergency(['f.id' => $id, 'f.status !=' => '-1']);

        if(!empty($emergency))
        {
            $this->common_model->set_table('emergency');
            $response = $this->common_model->_delete('id', $id);

            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'emergency not found.']);
        }
        redirect(base_url().'cms/emergency');
    }

}
