<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Student_council_designation extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/student_council/Student_council_designation_model', 'type');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['title']                = 'Designation';
        $this->data['page']                 = 'Designation';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "student_council";
        $this->data['child_menu_type']      = "student_council_designation";
        $this->data['sub_child_menu_type']  = "student_council_designation";
        $this->data['page']                 = 'Designation';

        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Student_council_designation', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list']            = $this->type->get_designation();
        $this->data['content']              = $this->load->view('cms/student_council/type/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {   
        $this->data['title']                = 'Designation';
        $this->data['page']                 = 'Designation';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "student_council";
        $this->data['child_menu_type']      = "student_council_designation";
        $this->data['sub_child_menu_type']  = "save_type";
        $this->data['sub_child_menu_type']  = "save_type";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        $per_action                         = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Student_council_designation', 'edit', $per_action, $this->data['insta_id']);

        if($id!='')
        {
            $this->data['post_data']        = $this->type->get_type_data($this->data['insta_id'],$id);
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Designation not found']);
                redirect(base_url()."cms/student_council_designation/");
            }
        }

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        $this->form_validation->set_rules('designation', 'Designation', 'required|max_length[255]');
        $this->form_validation->set_rules('status', 'Publish', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {
                $this->common_model->set_table('student_council_designations');
                if($id)
                {
                    $update['designation']      = $this->input->post('designation');
                    $update['institute_id']     = $instituteID;
                    $update['status']           = $this->input->post('status');
                    $update['modified_on']      = date('Y-m-d H:i:s');
                    $update['modified_by']      = $this->session->userdata('user_id');

                    $response = $this->common_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Designation successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['institute_id']     = $this->data['insta_id'];
                    $insert['designation']      = $this->input->post('designation');
                    $insert['institute_id']     = $instituteID;
                    $insert['status']           = $this->input->post('status');
                    $insert['created_on']       = date('Y-m-d H:i:s');
                    $insert['created_by']       = $this->session->userdata('user_id');
                    $insert['modified_on']      = date('Y-m-d H:i:s');
                    $insert['modified_by']      = $this->session->userdata('user_id');

                    $response = $this->common_model->_insert($insert);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Designation successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/student_council_designation/');
            }
        }

        $this->data['content']              = $this->load->view('cms/student_council/type/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Student_council_designation', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $typedata = $this->type->get_type_data($this->data['insta_id'], $id);
        if(!empty($typedata))
        {
            $this->common_model->set_table('student_council_designations');
            $response = $this->common_model->_delete('id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Designation not found.']);
        }
        redirect(base_url().'cms/student_council_designation/');
    }

}
