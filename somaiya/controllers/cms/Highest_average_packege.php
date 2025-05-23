<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Highest_average_packege extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/graphs/Highest_average_packege_model', 'highest_average_packege');
        $this->load->model('cms/notices/Notices_model', 'notices');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "highest_average_packege";
        $this->data['child_menu_type']      = "highest_average_packege";
        $this->data['sub_child_menu_type']  = "highest_average_packege";

        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Highest_average_packege', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list']            = $this->highest_average_packege->get_student_council();
        $this->data['title']                = 'Highest_average_packege';
        $this->data['page']                 = "Highest_average_packege";
        $this->data['content']              = $this->load->view('cms/graphs/highest_average_packege/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {   
        $this->data['title']                = 'Highest_average_packege';
        $this->data['module']               = 'Highest_average_packege';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "highest_average_packege";
        $this->data['child_menu_type']      = "save_highest_average_packege";
        $this->data['sub_child_menu_type']  = "";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        $this->data['post_data']['status']  = 1;
        
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        $per_action                         = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Highest_average_packege', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
            //echo "<pre>"; print_r($this->data['post_data']);exit();
        }

        $this->form_validation->set_rules('highest_package', 'Highest Package', 'required');
        $this->form_validation->set_rules('status', 'Status', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                $this->common_model->set_table('graph_highest_average_packege');
                if($id)
                {   
                    $update['academic_year']            = $this->input->post('academic_year');
                    $update['highest_package']          = $this->input->post('highest_package');
                    $update['average_package']          = $this->input->post('average_package');
                    $update['institute_id']             = $instituteID;
                    $update['status']                   = $this->input->post('status');
                    $update['modified_on']              = date('Y-m-d H:i:s');
                    $update['modified_by']              = $this->session->userdata('user_id');

                    $response = $this->common_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Highest Package successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {   
                    $insert['academic_year']            = $this->input->post('academic_year');
                    $insert['highest_package']          = $this->input->post('highest_package');
                    $insert['average_package']          = $this->input->post('average_package');
                    $insert['institute_id']             = $instituteID;
                    $insert['status']                   = $this->input->post('status');
                    $insert['created_on']               = date('Y-m-d H:i:s');
                    $insert['created_by']               = $this->session->userdata('user_id');
                    $insert['modified_on']              = date('Y-m-d H:i:s');
                    $insert['modified_by']              = $this->session->userdata('user_id');

                    $response                           = $this->common_model->_insert($insert);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Highest Package successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/highest_average_packege/');
            }
        }

        if($id!='')
        {
            $highest_average_packege                         = $this->highest_average_packege->get_student_council(['f.id' => $id, 'f.status !=' => '-1']);
            $this->data['post_data']        = isset($highest_average_packege[0]) ? $highest_average_packege[0] : [];
            
            if(empty($this->data['post_data']))
            {   
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Highest Package not found']);
                redirect(base_url()."cms/highest_average_packege/");
            }
        }

        $this->data['academic_year']    = $this->notices->get_all_academic_year_by_institute($this->session->userdata('sess_institute_id'));
        $this->data['content']          = $this->load->view('cms/graphs/highest_average_packege/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Highest_average_packege', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $highest_average_packege                          = $this->highest_average_packege->get_student_council(['f.id' => $id, 'f.status !=' => '-1']);

        if(!empty($highest_average_packege))
        {
            $this->common_model->set_table('graph_highest_average_packege');
            $response = $this->common_model->_delete('id', $id);

            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Highest Package not found.']);
        }
        redirect(base_url().'cms/highest_average_packege');
    }


    function ajax_check_graph()
    {   
        if($this->input->post())
        {
            $result = $this->unique_graph();
            echo $result;exit;
        }
    }

    function unique_graph()
    {   
        $instituteID                = $this->session->userdata('sess_institute_id');
        $id                      = isset($_POST['id']) ? $_POST['id'] : '';
        $academic_year              = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $errormessage               = 'Academic year data for this institute is already exist.';
        $this->form_validation->set_message('unique_graph', $errormessage);

        if(!empty($id) and !empty($instituteID))
        {
            $content = $this->common_model->custom_query('Select * FROM graph_highest_average_packege WHERE academic_year = "'.$academic_year.'" AND institute_id = "'.$instituteID.'" AND id != "'.$id.'"');
        }
        else
        {
            $content = $this->common_model->custom_query('Select * FROM graph_highest_average_packege WHERE academic_year = "'.$academic_year.'" AND institute_id = "'.$instituteID.'"');
        }

        if(isset($content[0]) && !empty($content[0]))
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

}
