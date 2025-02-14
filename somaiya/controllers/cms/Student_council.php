<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Student_council extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/student_council/Student_council_model', 'student_council');
        $this->load->model('cms/notices/Notices_model', 'notices');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "student_council";
        $this->data['child_menu_type']      = "student_council";
        $this->data['sub_child_menu_type']  = "student_council";

        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Student_council', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list']            = $this->student_council->get_student_council(['f.institute_id' => $instituteID]);
        $this->data['title']                = 'Student_council';
        $this->data['page']                 = "Student_council";
        $this->data['content']              = $this->load->view('cms/student_council/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['title']                = 'Student_council';
        $this->data['module']               = 'Student_council';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "student_council";
        $this->data['child_menu_type']      = "save_student_council";
        $this->data['sub_child_menu_type']  = "";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        $this->data['post_data']['status']  = 1;
        
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        $per_action                         = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Student_council', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
            // echo "<pre>"; print_r($this->data['post_data']);exit();
        }

        $this->form_validation->set_rules('student_name', 'Student Name', 'required|max_length[250]');
        $this->form_validation->set_rules('status', 'Status', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                $path       = './upload_file/student_council/';
                $filesnew   = $this->base64_to_image($this->input->post('thumbnail'), $path);
                $files      = $this->file_upload();

                $thumbnail  = isset($filesnew['thumbnail']) ? $filesnew['thumbnail'] : '';

                $this->common_model->set_table('student_council');
                if($id)
                {   
                    $update['student_name']             = $this->input->post('student_name');
                    $update['designation_id']           = $this->input->post('designation');
                    $update['academic_year']            = $this->input->post('academic_year');
                    $update['institute_id']             = $instituteID;
                    if(!empty($thumbnail))
                    {
                        $update['photo']                = $thumbnail;
                    }
                    $update['order_by']                 = $this->input->post('order_by');
                    $update['status']                   = $this->input->post('status');
                    $update['modified_on']              = date('Y-m-d H:i:s');
                    $update['modified_by']              = $this->session->userdata('user_id');

                    $response = $this->common_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Student_council successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {   
                    $insert['student_name']             = $this->input->post('student_name');
                    $insert['designation_id']           = $this->input->post('designation');
                    $insert['academic_year']            = $this->input->post('academic_year');
                    $insert['institute_id']             = $instituteID;
                    $insert['photo']                    = $thumbnail;
                    $insert['order_by']                 = $this->input->post('order_by');
                    $insert['status']                   = $this->input->post('status');
                    $insert['created_on']               = date('Y-m-d H:i:s');
                    $insert['created_by']               = $this->session->userdata('user_id');
                    $insert['modified_on']              = date('Y-m-d H:i:s');
                    $insert['modified_by']              = $this->session->userdata('user_id');

                    $response                           = $this->common_model->_insert($insert);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Student council successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/student_council/');
            }
        }

        if($id!='')
        {
            $student_council                         = $this->student_council->get_student_council(['f.id' => $id, 'f.status !=' => '-1']);
            $this->data['post_data']        = isset($student_council[0]) ? $student_council[0] : [];
            
            if(empty($this->data['post_data']))
            {   
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Student Council not found']);
                redirect(base_url()."cms/student_council/");
            }
        }

        $this->data['academic_year']    = $this->notices->get_all_academic_year_by_institute($this->session->userdata('sess_institute_id'));
        $this->data['designation']      = $this->student_council->get_all_designation($this->session->userdata('sess_institute_id'));
        $this->data['content']          = $this->load->view('cms/student_council/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Student_council', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $student_council                          = $this->student_council->get_student_council(['f.id' => $id, 'f.status !=' => '-1']);

        if(!empty($student_council))
        {
            $this->common_model->set_table('student_council');
            $response = $this->common_model->_delete('id', $id);

            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'student_council not found.']);
        }
        redirect(base_url().'cms/student_council');
    }


        function base64_to_image($image_data='', $path='') {
        $image_name         = '';
        $path               = !empty($path) ? $path : './upload_file/student_council/';
        
        if(!empty($image_data))
        {   
            $image_parts    = explode(";base64,", $image_data);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type     = $image_type_aux[1];
            $image_base64   = base64_decode($image_parts[1]);
            $image_name     = uniqid().'.'.$image_type;
            $file           = $path.'/'.$image_name;
            file_put_contents($file, $image_base64);
        }
        return ['thumbnail' => $image_name];
    }

    function file_upload()
    {
        $pathToUpload   = './upload_file/student_council/';
        if(!file_exists($pathToUpload))
        {
            $create     = mkdir($pathToUpload);
            chmod("$pathToUpload", 0777);
        }
        $files          = $_FILES;
        $fimg           = count($_FILES['thumbnail']['name']);
        $thumbnail      = '';

        if($fimg !== "")
        {
            $config22['upload_path']    = $pathToUpload;
            $config22['allowed_types']  = 'gif|jpg|png|jpeg';
            $config22['max_size']       = '8000000';
            $config22['remove_spaces']  = true;
            $config22['overwrite']      = false;
            $config22['max_width']      = '';
            $config22['max_height']     = '';
            $fileNamefeatured12         = $_FILES['thumbnail']['name'];
            $fileNamefeatured           = str_replace(' ', '_', $fileNamefeatured12);
            $images2[]                  = $fileNamefeatured;

            $this->load->library('upload', $config22);
            $this->upload->initialize($config22);
            $this->upload->do_upload();
            if(!$this->upload->do_upload('thumbnail'))
            {
                $error = array('error' => $this->upload->display_errors());
            }
            else
            {
                $upload_data            = $this->upload->data();
                $thumbnail              = isset($upload_data['file_name']) ? $upload_data['file_name'] : '';
            }
        }

        return ['thumbnail' => $thumbnail];
    }

    function deletethumbnail()
    {
        $deleteid  = $this->input->post('award_id');
        $update['photo']                = '';
        $update['modified_on']              = date('Y-m-d H:i:s');
        $update['modified_by']              = $this->session->userdata('user_id');

        $this->common_model->set_table('student_council');
        $this->common_model->_update('id', $deleteid, $update);
        echo true;
    }

}
