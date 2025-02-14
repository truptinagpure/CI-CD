<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Superstar extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/superstar/Superstar_model', 'superstar');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "superstar";
        $this->data['child_menu_type']      = "superstar";
        $this->data['sub_child_menu_type']  = "superstar";

        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Superstar', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list']            = $this->superstar->get_superstar(['f.institute_id' => $instituteID]);
        $this->data['title']                = 'Superstar';
        $this->data['page']                 = "Superstar";
        $this->data['content']              = $this->load->view('cms/superstar/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['title']                = 'Superstar';
        $this->data['module']               = 'Superstar';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "superstar";
        $this->data['child_menu_type']      = "superstar";
        $this->data['sub_child_menu_type']  = "save_awards";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        $per_action                         = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Superstar', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
            // echo "<pre>"; print_r($this->data['post_data']);exit();
        }

        $this->form_validation->set_rules('superstar_name', 'Superstar Name', 'required');
        $this->form_validation->set_rules('status', 'Publish', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   

                $path       = './upload_file/superstar/';
                $filesnew   = $this->base64_to_image($this->input->post('thumbnail'), $path);
                $files      = $this->file_upload();

                $thumbnail  = isset($filesnew['thumbnail']) ? $filesnew['thumbnail'] : '';
                echo "<pre>"; print_r();

                $this->common_model->set_table('superstar');
                if($id)
                {   
                    $update['superstar_name']           = $this->input->post('superstar_name');
                    $update['designation']              = $this->input->post('designation');
                    // $update['year']                     = $this->input->post('year');
                    $update['achievements']             = $this->input->post('achievements');
                    $update['institute_id']             = $instituteID;
                    if(!empty($thumbnail))
                    {
                        $update['thumbnail']            = $thumbnail;
                    }
                    $update['status']                   = $this->input->post('status');
                    $update['modified_on']              = date('Y-m-d H:i:s');
                    $update['modified_by']              = $this->session->userdata('user_id');

                    $response = $this->common_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $awards_id                         = $id;
                        $msg = ['error' => 0, 'message' => 'Superstar successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {   
                    $insert['superstar_name']           = $this->input->post('superstar_name');
                    $insert['designation']              = $this->input->post('designation');
                    $insert['institute_id']             = $instituteID;
                    // $insert['year']                     = $this->input->post('year');
                    $insert['achievements']             = $this->input->post('achievements');
                    $insert['thumbnail']                = $thumbnail;
                    $insert['status']                   = $this->input->post('status');
                    $insert['created_on']               = date('Y-m-d H:i:s');
                    $insert['created_by']               = $this->session->userdata('user_id');
                    $insert['modified_on']              = date('Y-m-d H:i:s');
                    $insert['modified_by']              = $this->session->userdata('user_id');

                    $response                           = $this->common_model->_insert($insert);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $superstar_id                         = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Superstar successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/superstar/');
            }
        }

        if($id!='')
        {
            $superstar                          = $this->superstar->get_superstar(['f.id' => $id, 'f.status !=' => '-1']);
            $this->data['post_data']            = isset($superstar[0]) ? $superstar[0] : [];
            
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'superstar not found']);
                redirect(base_url()."cms/superstar/");
            }
        }

        $this->data['content']           = $this->load->view('cms/superstar/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Superstar', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $superstar                                = $this->superstar->get_superstar(['f.id' => $id, 'f.status !=' => '-1']);

        if(!empty($superstar))
        {
            $this->common_model->set_table('superstar');
            $response = $this->common_model->_delete('id', $id);

            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'superstar not found.']);
        }
        redirect(base_url().'cms/superstar/');
    }


    function base64_to_image($image_data='', $path='') {
        $image_name         = '';
        $path               = !empty($path) ? $path : './upload_file/superstar/';
        
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
        $pathToUpload   = './upload_file/superstar/';
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
        $update['thumbnail']                = '';
        $update['modified_on']              = date('Y-m-d H:i:s');
        $update['modified_by']              = $this->session->userdata('user_id');

        $this->common_model->set_table('superstar');
        $this->common_model->_update('id', $deleteid, $update);
        echo true;
    }

}