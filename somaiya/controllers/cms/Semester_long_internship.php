<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Semester_long_internship extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/graphs/Semester_long_internship_model', 'semester_long_internship');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "semester_long_internship";
        $this->data['child_menu_type']      = "semester_long_internship";
        $this->data['sub_child_menu_type']  = "semester_long_internship";

        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Semester_long_internship', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list']            = $this->semester_long_internship->get_student_council();
        $this->data['title']                = 'Semester_long_internship';
        $this->data['page']                 = "Semester_long_internship";
        $this->data['content']              = $this->load->view('cms/graphs/semester_long_internship/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {   
        $this->data['title']                = 'Semester_long_internship';
        $this->data['module']               = 'Semester_long_internship';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "semester_long_internship";
        $this->data['child_menu_type']      = "save_semester_long_internship";
        $this->data['sub_child_menu_type']  = "";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        $this->data['post_data']['status']  = 1;
        
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        $per_action                         = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Semester_long_internship', 'edit', $per_action, $this->data['insta_id']);

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
                $this->common_model->set_table('graph_semester_long_internship');
                if($id)
                {   
                    $update['branch']                   = $this->input->post('branch');
                    $update['case1']                    = $this->input->post('case1');
                    $update['case2']                    = $this->input->post('case2');
                    $update['institute_id']             = $instituteID;
                    $update['status']                   = $this->input->post('status');
                    $update['modified_on']              = date('Y-m-d H:i:s');
                    $update['modified_by']              = $this->session->userdata('user_id');

                    $response = $this->common_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Semester_long_internship successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {   
                    $insert['branch']                   = $this->input->post('branch');
                    $insert['case1']                    = $this->input->post('case1');
                    $insert['case2']                    = $this->input->post('case2');
                    $insert['institute_id']             = $instituteID;
                    $insert['status']                   = $this->input->post('status');
                    $insert['created_on']               = date('Y-m-d H:i:s');
                    $insert['created_by']               = $this->session->userdata('user_id');
                    $insert['modified_on']              = date('Y-m-d H:i:s');
                    $insert['modified_by']              = $this->session->userdata('user_id');

                    $response                           = $this->common_model->_insert($insert);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Semester_long_internship successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/semester_long_internship/');
            }
        }

        if($id!='')
        {
            $semester_long_internship                         = $this->semester_long_internship->get_student_council(['f.id' => $id, 'f.status !=' => '-1']);
            $this->data['post_data']        = isset($semester_long_internship[0]) ? $semester_long_internship[0] : [];
            
            if(empty($this->data['post_data']))
            {   
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Semester_long_internship not found']);
                redirect(base_url()."cms/semester_long_internship/");
            }
        }

        $this->data['content']          = $this->load->view('cms/graphs/semester_long_internship/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Semester_long_internship', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $semester_long_internship                          = $this->semester_long_internship->get_student_council(['f.id' => $id, 'f.status !=' => '-1']);

        if(!empty($semester_long_internship))
        {
            $this->common_model->set_table('graph_semester_long_internship');
            $response = $this->common_model->_delete('id', $id);

            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Semester_long_internship not found.']);
        }
        redirect(base_url().'cms/semester_long_internship');
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
        //$academic_year              = isset($_POST['academic_year']) ? $_POST['academic_year'] : '';
        $branch                     = isset($_POST['branch']) ? $_POST['branch'] : '';
        $errormessage               = 'Academic year data for this institute is already exist.';
        $this->form_validation->set_message('unique_graph', $errormessage);

        if(!empty($id) and !empty($instituteID) and !empty($branch))
        {
            $content = $this->common_model->custom_query('Select * FROM graph_semester_long_internship WHERE branch = "'.$branch.'" AND institute_id = "'.$instituteID.'" AND id != "'.$id.'"');
        }
        else
        {
            $content = $this->common_model->custom_query('Select * FROM graph_semester_long_internship WHERE branch = "'.$branch.'" AND institute_id = "'.$instituteID.'"');
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
