<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Institute extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/institute/Institute_model', 'institute');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['main_menu_type']       = "masters";
        $this->data['sub_menu_type']        = "institute";
        $this->data['child_menu_type']      = "institute";
        $this->data['sub_child_menu_type']  = "institute";

        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Institute', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        if($instituteID == 50)
        {
            $this->data['data_list']            = $this->institute->get_institute();
        }
        else
        {
            $this->data['data_list']            = $this->institute->get_institute(['f.INST_ID' => $instituteID]);
        }

        $this->data['title']                = 'Institute';
        $this->data['page']                 = "Institute";
        $this->data['content']              = $this->load->view('cms/institute/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['title']                = 'Institute';
        $this->data['module']               = 'Institute';
        $this->data['main_menu_type']       = "masters";
        $this->data['sub_menu_type']        = "institute";
        $this->data['child_menu_type']      = "institute";
        $this->data['sub_child_menu_type']  = "save_institute";
        $this->data['post_data']            = [];
        $this->data['INST_ID']              = $id;
        $this->data['post_data']['public']  = 1;
        
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        $per_action                         = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Institute', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
            // echo "<pre>"; print_r($this->data['post_data']);exit();
        }

        // $this->form_validation->set_rules('public', 'Status', '');

        // if($this->form_validation->run($this) === TRUE)
        // {
            if($this->input->post())
            {   
                $this->common_model->set_table('edu_institute_dir');
                if($id)
                {   
                    $update['INST_NAME']                = $this->input->post('INST_NAME');
                    $update['INST_SHORTNAME']           = $this->input->post('INST_SHORTNAME');
                    $update['institute_url']            = $this->input->post('institute_url');
                    $update['INSTITUTE_LOCATION']       = $this->input->post('INSTITUTE_LOCATION');
                    $update['INSTITUTE_TYPE']           = $this->input->post('INSTITUTE_TYPE');
                    $update['INSTITUTE_CATEGORY']       = $this->input->post('INSTITUTE_CATEGORY');
                    $update['grievance_user_access']    = $this->input->post('grievance_user_access');
                    $update['institute_campus_image']   = $this->input->post('institute_campus_image');
                    $update['institute_description']    = $this->input->post('institute_description');
                    $update['public']                   = $this->input->post('public');

                    $response = $this->common_model->_update('INST_ID', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Institute successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {   
                    // $insert['INST_NAME']                = $this->input->post('INST_NAME');
                    // $insert['INST_SHORTNAME']           = $this->input->post('INST_SHORTNAME');
                    // $insert['institute_url']            = $this->input->post('institute_url');
                    // $insert['INSTITUTE_LOCATION']       = $this->input->post('INSTITUTE_LOCATION');
                    // $insert['INSTITUTE_TYPE']           = $this->input->post('INSTITUTE_TYPE');
                    // $insert['INSTITUTE_CATEGORY']       = $this->input->post('INSTITUTE_CATEGORY');
                    // $insert['grievance_user_access']    = $this->input->post('grievance_user_access');
                    // $insert['institute_campus_image']   = $this->input->post('institute_campus_image');
                    // $insert['institute_description']    = $this->input->post('institute_description');
                    // $insert['public']                   = $this->input->post('public');

                    // $response                           = $this->common_model->_insert($insert);
                    // if(isset($response['status']) && $response['status'] == 'success')
                    // {
                    //     $msg = ['error' => 0, 'message' => 'Institute successfully added'];
                    // }
                    // else
                    // {
                    //     $msg = ['error' => 0, 'message' => $response['message']];
                    // }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/institute/');
            }
        //}

        if($id!='')
        {
            $institute                         = $this->institute->get_institute(['f.INST_ID' => $id, 'f.public !=' => '-1']);
            $this->data['post_data']        = isset($institute[0]) ? $institute[0] : [];
            
            if(empty($this->data['post_data']))
            {   
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'institute not found']);
                redirect(base_url()."cms/institute/");
            }
        }

        $this->data['areaofstudy']      = $this->institute->get_all_areaofstudy();
        $this->data['content']          = $this->load->view('cms/institute/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Institute', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $institute                          = $this->institute->get_institute(['f.INST_ID' => $id, 'f.public !=' => '-1']);

        if(!empty($institute))
        {
            $this->common_model->set_table('institute');
            $response = $this->common_model->_delete('INST_ID', $id);

            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'institute not found.']);
        }
        redirect(base_url().'cms/institute');
    }



    function config()
    {   
        $faculty_institute = $this->uri->segment(4);
        $this->data['main_menu_type']       = "masters";
        $this->data['sub_menu_type']        = "institute";
        $this->data['child_menu_type']      = "institute";
        $this->data['sub_child_menu_type']  = "institute";

        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Institute', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['institutes_details']   = $this->Somaiya_general_admin_model->get_institute_detail($faculty_institute);
        $this->data['designation']          = $this->institute->get_designations();
        $this->data['faculty_name']         = $this->institute->get_faculty_name($faculty_institute);
        $this->data['data_list']            = $this->institute->get_excluded_designations($faculty_institute);
        $this->data['title']                = 'Institute';
        $this->data['page']                 = "Institute";
        $this->data['content']              = $this->load->view('cms/institute/config',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function excluded_faculty()
    {   
        $this->data['designation_data']            = [];
        // $this->data['id']                          = $id;
        $id1 = $this->input->post('id');
        if($id1 != '')
        {
            $id = $id1;
        }
        else
        {
            $id = '';
        }

        if($this->input->post())
        {
            $this->data['designation_data'] = $this->input->post();
        }

        if($this->input->post())
        {   
            if(isset($this->data['designation_data']['designation_id']) && !empty($this->data['designation_data']['designation_id']))
            {
                $designation_id = implode(',', $this->data['designation_data']['designation_id']);
            }

            if(isset($this->data['designation_data']['faculty_name']) && !empty($this->data['designation_data']['faculty_name']))
            {
                $faculty_name = implode(',', $this->data['designation_data']['faculty_name']);
            }

            if ($designation_id == '')
            {
                $designation_id = 0;
            }
            if ($faculty_name == '')
            {
                $faculty_name = 0;
            }
            if(isset($this->data['designation_data']['designation_id']) && !empty($this->data['designation_data']['designation_id']) OR isset($this->data['designation_data']['faculty_name']) && !empty($this->data['designation_data']['faculty_name']))
            {
                if($id != '')
                {   
                    $update['designation']['excluded_faculty_designation_id']        = $designation_id;
                    $update['designation']['excluded_faculty_id']        = $faculty_name;
                    $update['designation']['institute_id']          = $this->input->post('institute_id');
                    $update['designation']['modified_on']           = date('Y-m-d H:i:s');
                    $update['designation']['modified_by']           = $this->session->userdata['user_id'];
                    $response = $this->institute->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $announcement_id                                = $id;
                        $msg = ['error' => 0, 'message' => 'Faculty Configuration successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {   
                    $insert['designation']['excluded_faculty_designation_id']       = $designation_id;
                    $update['designation']['excluded_faculty_id']        = $faculty_name;
                    $insert['designation']['institute_id']         = $this->input->post('institute_id');
                    $insert['designation']['created_on']           = date('Y-m-d H:i:s');
                    $insert['designation']['created_by']           = $this->session->userdata['user_id'];
                    $response                 = $this->institute->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Faculty Configuration successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
            }
            else
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Fill At least one filed']);
            }

            redirect(base_url().'cms/institute/config/'.$this->input->post('institute_id'));
        }
    }
}
