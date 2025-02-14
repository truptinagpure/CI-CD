<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Calendar_types extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/calendar/Calendar_types_model', 'calendar_types');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['title']                = 'Calendar Types';
        $this->data['page']                 = 'Calendar Types';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "calendar";
        $this->data['child_menu_type']      = "calendar_types";
        $this->data['sub_child_menu_type']  = "list";
        $this->data['page']                 = 'Calendar Types';

        validate_permissions('Calendar_types', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list']            = $this->calendar_types->get_calendar_types();
        $this->data['content']              = $this->load->view('cms/calendar/calendar_types/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['title']                = 'Calendar Types';
        $this->data['page']                 = 'Calendar Types';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "calendar";
        $this->data['child_menu_type']      = "calendar_types";
        $this->data['sub_child_menu_type']  = "save_calendar_types";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        
        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Calendar_types', 'edit', $per_action, $this->data['insta_id']);

        if($id!='')
        {
            $this->data['post_data']        = $this->calendar_types->get_calendar_type_data($id);
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Calendar type not found']);
                redirect(base_url()."cms/calendar_types/");
            }
        }

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        $this->form_validation->set_rules('name', 'Calendar Type', 'required|max_length[255]');
        $this->form_validation->set_rules('color', 'Color', 'required|max_length[255]');
        $this->form_validation->set_rules('status', 'Public', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {
                $this->common_model->set_table('event_calendar_type');
                if($id)
                {
                    $update['name']             = $this->input->post('name');
                    $update['color']            = $this->input->post('color');
                    $update['status']           = $this->input->post('status');
                    $update['modified_on']      = date('Y-m-d H:i:s');
                    $update['modified_by']      = $this->session->userdata('user_id');

                    $response = $this->common_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Calendar type successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['name']             = $this->input->post('name');
                    $insert['color']            = $this->input->post('color');
                    $insert['status']           = $this->input->post('status');
                    $insert['created_on']       = date('Y-m-d H:i:s');
                    $insert['created_by']       = $this->session->userdata('user_id');
                    $insert['modified_on']      = date('Y-m-d H:i:s');
                    $insert['modified_by']      = $this->session->userdata('user_id');

                    $response = $this->common_model->_insert($insert);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Calendar type successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/calendar_types/');
            }
        }

        $this->data['content']              = $this->load->view('cms/calendar/calendar_types/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $this->data['insta_id'] = $this->default_institute_id;
        validate_permissions('Calendar_types', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $calendartypedata = $this->calendar_types->get_calendar_type_data_delete($id);
        if(!empty($calendartypedata))
        {
            $this->common_model->set_table('event_calendar_type');
            $response = $this->common_model->_delete('id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Calendar type not found.']);
        }
        redirect(base_url().'cms/calendar_types/');
    }

}
