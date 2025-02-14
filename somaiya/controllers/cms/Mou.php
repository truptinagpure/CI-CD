<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mou extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/mou/Mou_model', 'mou');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "mou";
        $this->data['child_menu_type']      = "mou";
        $this->data['sub_child_menu_type']  = "mou";

        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Mou', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list']            = $this->mou->get_mou(['f.institute_id' => $instituteID]);
        $this->data['title']                = 'Mou';
        $this->data['page']                 = "Mou";
        $this->data['content']              = $this->load->view('cms/mou/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['title']                = 'Mou';
        $this->data['module']               = 'Mou';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "mou";
        $this->data['child_menu_type']      = "mou";
        $this->data['sub_child_menu_type']  = "save_mou";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        $this->data['post_data']['status']  = 1;
        
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        $per_action                         = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Mou', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
            //echo "<pre>"; print_r($this->data['post_data']);exit();
        }

        $this->form_validation->set_rules('organization_name', 'Organization Name', 'required|max_length[255]');
        $this->form_validation->set_rules('location', 'Location', 'required|max_length[255]');
        $this->form_validation->set_rules('status', 'Publish', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                $allowed_department_ids           = [];
                $save_data                  = [];
                foreach ($_POST['department_id'] as $key => $value) 
                {
                    $allowed_department_ids[] = $value;
                }

                $save_data = !empty($allowed_department_ids) ? implode(',', $allowed_department_ids) : '';

                $path       = './upload_file/mou/thumbnail/';
                $filesnew   = $this->base64_to_image($this->input->post('thumbnail'), $path);
                $files      = $this->file_upload();

                $thumbnail  = isset($filesnew['thumbnail']) ? $filesnew['thumbnail'] : '';
                //$docsnew    = isset($files['document']) ? $files['document'] : '';

                $this->common_model->set_table('mou');
                if($id)
                {   
                    $update['organization_name']        = $this->input->post('organization_name');
                    $update['location']                 = $this->input->post('location');
                    $update['website_link']             = $this->input->post('website_link');
                    $update['tenure']                   = $this->input->post('tenure');
                    $update['department_id']            = $save_data;
                    $update['institute_id']             = $instituteID;
                    $update['date']                     = $this->input->post('date');
                    $update['description']              = $this->input->post('description');
                    if(!empty($thumbnail))
                    {
                        $update['thumbnail']            = $thumbnail;
                    }
                    $update['document']                 = $this->input->post('document');
                    $update['status']                   = $this->input->post('status');
                    $update['modified_on']              = date('Y-m-d H:i:s');
                    $update['modified_by']              = $this->session->userdata('user_id');

                    $response = $this->common_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Mou successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {   
                    $insert['organization_name']        = $this->input->post('organization_name');
                    $insert['location']                 = $this->input->post('location');
                    $insert['department_id']            = $save_data;
                    $insert['institute_id']             = $instituteID;
                    $insert['website_link']             = $this->input->post('website_link');
                    $insert['tenure']                   = $this->input->post('tenure');
                    $insert['thumbnail']                = $thumbnail;
                    $insert['document']                 = $this->input->post('document');
                    $insert['date']                     = $this->input->post('date');
                    $insert['description']              = $this->input->post('description');
                    $insert['status']                   = $this->input->post('status');
                    $insert['created_on']               = date('Y-m-d H:i:s');
                    $insert['created_by']               = $this->session->userdata('user_id');
                    $insert['modified_on']              = date('Y-m-d H:i:s');
                    $insert['modified_by']              = $this->session->userdata('user_id');

                    $response                           = $this->common_model->_insert($insert);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Mou successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/mou/');
            }
        }

        if($id!='')
        {
            $mou                            = $this->mou->get_mou(['f.id' => $id, 'f.status !=' => '-1']);
            $this->data['post_data']        = isset($mou[0]) ? $mou[0] : [];
            
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Mou not found']);
                redirect(base_url()."cms/mou/");
            }
        }

        $this->data['department']        = $this->mou->get_department();
        $this->data['content']           = $this->load->view('cms/mou/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Mou', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $mou                                = $this->mou->get_mou(['f.id' => $id, 'f.status !=' => '-1']);

        if(!empty($mou))
        {
            $this->common_model->set_table('mou');
            $response = $this->common_model->_delete('id', $id);

            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Mou not found.']);
        }
        redirect(base_url().'cms/mou/');
    }

    function base64_to_image($image_data='', $path='') {
        $image_name         = '';
        $path               = !empty($path) ? $path : './upload_file/mou/thumbnail/';
        
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
        $pathToUpload   = './upload_file/mou/thumbnail/';
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

        // $docToUpload   = './upload_file/mou/documents/';
        // if(!file_exists($docToUpload))
        // {
        //     $create     = mkdir($docToUpload);
        //     chmod("$docToUpload", 0777);
        // }
        // $docs           = $_FILES;
        // $doc            = count($_FILES['document']['name']);
        // $document       = '';

        // if($doc !== "")
        // {
        //     $config22['upload_path']    = $docToUpload;
        //     $config22['allowed_types']  = 'pdf';
        //     $config22['max_size']       = '8000000';
        //     $config22['remove_spaces']  = true;
        //     $config22['overwrite']      = false;
        //     $config22['max_width']      = '';
        //     $config22['max_height']     = '';
        //     $document1                  = $_FILES['document']['name'];
        //     $document12                 = str_replace(' ', '_', $document1);
        //     $images2[]                  = $document12;

        //     $this->load->library('upload', $config22);
        //     $this->upload->initialize($config22);
        //     $this->upload->do_upload();
        //     if(!$this->upload->do_upload('document'))
        //     {
        //         $error = array('error' => $this->upload->display_errors());
        //     }
        //     else
        //     {
        //         $upload_data            = $this->upload->data();
        //         $document               = isset($upload_data['file_name']) ? $upload_data['file_name'] : '';
        //     }
        // }

        // return ['thumbnail' => $thumbnail, 'document' => $document];
        return ['thumbnail' => $thumbnail];
    }

    // function deleteimage()
    // {
    //     $deleteid  = $this->input->post('image_id');
    //     $this->db->delete('mou_images', array('id' => $deleteid));
    //     $verify = $this->db->affected_rows();
    //     echo $verify;
    // }

    // function deletethumbnail()
    // {
    //     $deleteid  = $this->input->post('award_id');
    //     $update['thumbnail']                = '';
    //     $update['modified_on']              = date('Y-m-d H:i:s');
    //     $update['modified_by']              = $this->session->userdata('user_id');

    //     $this->common_model->set_table('mou');
    //     $this->common_model->_update('id', $deleteid, $update);
    //     echo true;
    // }

}
