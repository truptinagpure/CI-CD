<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Students_placed_branchwise extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/graphs/Students_placed_branchwise_model', 'students_placed_branchwise');
        $this->load->model('cms/notices/Notices_model', 'notices');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "students_placed_branchwise";
        $this->data['child_menu_type']      = "students_placed_branchwise";
        $this->data['sub_child_menu_type']  = "students_placed_branchwise";

        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Students_placed_branchwise', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list']            = $this->students_placed_branchwise->get_student_council();
        $this->data['title']                = 'Students_placed_branchwise';
        $this->data['page']                 = "Students_placed_branchwise";
        $this->data['content']              = $this->load->view('cms/graphs/students_placed_branchwise/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {   
        $this->data['title']                = 'Students_placed_branchwise';
        $this->data['module']               = 'Students_placed_branchwise';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "students_placed_branchwise";
        $this->data['child_menu_type']      = "save_students_placed_branchwise";
        $this->data['sub_child_menu_type']  = "";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        $this->data['post_data']['status']  = 1;
        
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        $per_action                         = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Students_placed_branchwise', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
            //echo "<pre>"; print_r($this->data['post_data']);exit();
        }

        $this->form_validation->set_rules('branch', 'Branch', 'required');
        $this->form_validation->set_rules('status', 'Status', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                $this->common_model->set_table('graph_students_placed_branchwise');
                if($id)
                {   
                    $update['academic_year']            = $this->input->post('academic_year');
                    $update['branch']                   = $this->input->post('branch');
                    $update['placed_number']            = $this->input->post('placed_number');
                    $update['institute_id']             = $instituteID;
                    $update['status']                   = $this->input->post('status');
                    $update['modified_on']              = date('Y-m-d H:i:s');
                    $update['modified_by']              = $this->session->userdata('user_id');

                    $response = $this->common_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Students_placed_branchwise successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {   
                    $insert['academic_year']            = $this->input->post('academic_year');
                    $insert['branch']                   = $this->input->post('branch');
                    $insert['placed_number']            = $this->input->post('placed_number');
                    $insert['institute_id']             = $instituteID;
                    $insert['status']                   = $this->input->post('status');
                    $insert['created_on']               = date('Y-m-d H:i:s');
                    $insert['created_by']               = $this->session->userdata('user_id');
                    $insert['modified_on']              = date('Y-m-d H:i:s');
                    $insert['modified_by']              = $this->session->userdata('user_id');

                    $response                           = $this->common_model->_insert($insert);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Students_placed_branchwise successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/students_placed_branchwise/');
            }
        }

        if($id!='')
        {
            $students_placed_branchwise                         = $this->students_placed_branchwise->get_student_council(['f.id' => $id, 'f.status !=' => '-1']);
            $this->data['post_data']        = isset($students_placed_branchwise[0]) ? $students_placed_branchwise[0] : [];
            
            if(empty($this->data['post_data']))
            {   
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Students_placed_branchwise not found']);
                redirect(base_url()."cms/students_placed_branchwise/");
            }
        }

        $this->data['academic_year']    = $this->notices->get_all_academic_year_by_institute($this->session->userdata('sess_institute_id'));
        $this->data['content']          = $this->load->view('cms/graphs/students_placed_branchwise/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Students_placed_branchwise', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $students_placed_branchwise                          = $this->students_placed_branchwise->get_student_council(['f.id' => $id, 'f.status !=' => '-1']);

        if(!empty($students_placed_branchwise))
        {
            $this->common_model->set_table('graph_students_placed_branchwise');
            $response = $this->common_model->_delete('id', $id);

            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Students_placed_branchwise not found.']);
        }
        redirect(base_url().'cms/students_placed_branchwise');
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
        $id                         = isset($_POST['id']) ? $_POST['id'] : '';
        $academic_year              = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $branch                     = isset($_POST['branch']) ? $_POST['branch'] : '';
        $errormessage               = 'Academic year data for this institute is already exist.';
        $this->form_validation->set_message('unique_graph', $errormessage);

        if(!empty($id) and !empty($instituteID) and !empty($branch))
        {
            $content = $this->common_model->custom_query('Select * FROM graph_students_placed_branchwise WHERE academic_year = "'.$academic_year.'" AND branch = "'.$branch.'" AND institute_id = "'.$instituteID.'" AND id != "'.$id.'"');
        }
        else
        {
            $content = $this->common_model->custom_query('Select * FROM graph_students_placed_branchwise WHERE academic_year = "'.$academic_year.'" AND branch = "'.$branch.'" AND institute_id = "'.$instituteID.'"');
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
