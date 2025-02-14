<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Department extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/department/Department_model', 'department');
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

     function index()
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "department";
        $this->data['child_menu_type']      = "department";
        $this->data['sub_child_menu_type']  = "department";

        validate_permissions('department', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['department_by_institute'] = $this->department->get_department_name_by_institute($this->session->userdata('sess_institute_id'));
        $this->data['title']                = _l("Department",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/department/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['title']                = 'Department';
        $this->data['module']               = 'department';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "department";
        $this->data['child_menu_type']      = "save_department";
        $this->data['sub_child_menu_type']  = "";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        $this->data['sess_institute_id']    = $this->session->userdata('sess_institute_id');
        $this->data['sess_institute_name']  = $this->session->userdata('sess_institute_name');                                   
             

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('department', 'edit', $per_action, $this->data['insta_id']);

        $check_existing_institute_id = $this->department->get_active_department_list_by_institute($this->session->userdata('sess_institute_id'));

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        $this->form_validation->set_rules('department_id[]', 'Department Name', 'required');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                
                    $update['department_id']                = $this->input->post('department_id');
                    $update['modified_on']                  = date('Y-m-d H:i:s');
                    $update['modified_by']                  = $this->session->userdata('user_id');

                    $response = $this->department->add_update_data('institute_id', $this->session->userdata('sess_institute_id'), $update);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        //$industrial_visits_id               = $id;
                        $msg = ['error' => 0, 'message' => 'Department successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/department/');
            }
        }

        if($check_existing_institute_id!='')
        {
            $department     			= $this->department->get_active_department_list_by_institute($this->session->userdata('sess_institute_id'));
            $this->data['post_data']  	= isset($department[0]) ? $department[0] : [];
            
        }

        $this->data['all_departments']   = $this->department->get_all_department();
        $this->data['content']         = $this->load->view('cms/department/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    /*function delete($id='')
    {

        $this->data['insta_id']             = $this->default_institute_id;
        //$this->data['insta_id'] = $id;
        validate_permissions('department', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
    
        $response = $this->department->_delete('id', $id);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
       
        redirect(base_url().'cms/department/');
    }*/

    
}