<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Job_fair extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/job_fair/Job_fair_model', 'job_fair');
        //$this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "job_fair";
        $this->data['child_menu_type']      = "job_fair";
        $this->data['sub_child_menu_type']  = "job_fair";

        validate_permissions('Job_fair', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list']            = $this->job_fair->get_jobs_fair_list(array('institute_id' => $this->session->userdata['sess_institute_id']));
        // print_r($this->data['data_list']);
        // exit();
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/job_fair/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['title']                = 'Job Fair';
        $this->data['module']               = 'job_fair';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "job_fair";
        $this->data['child_menu_type']      = "save_job_fair";
        $this->data['sub_child_menu_type']  = "save_job_fair";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        
        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Job_fair', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        // print_r($this->input->post());
        // exit();
        $this->form_validation->set_rules('job_fair_title', 'Title', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('pdf_url', 'PDF URL', 'required');
        $this->form_validation->set_rules('jobs_fair_year', 'jobs_fair_year', 'required');       
        //$this->form_validation->set_rules('image', 'Image', 'required');
        //$this->form_validation->set_rules('status', 'Public', '');

        if($this->form_validation->run($this) === TRUE)
        {
            // print_r($this->input->post());
            // echo "<br>------------</br>";
            // exit();
            if($this->input->post())
            {   
                $path  = './upload_file/kjsieit/jobs_fair/images/';
                $filesnew   = $this->base64_to_image($this->input->post('image'), $path);
                //$files      = $this->file_upload();

                $image  = isset($filesnew['image']) ? $filesnew['image'] : '';
                
                //$filesnew = $this->base64_to_image($this->input->post('image'), $path);
               //  $files = $this->file_upload();

               //  //$thumbnail      = isset($filesnew['image']) ? $filesnew['thumbnail'] : '';
               // // $image      = isset($filesnew['image']) ? $filesnew['image'] : '';
               //  $image         = isset($files['image']) ? $files['image'] : [];
                // echo "img upload";
                // exit();
                                // $config = array(
                //     'table'         => 'job_fair',
                //     'id'            => 'id',
                //     'field'         => 'slug',
                //     'title'         => 'industry_name',
                //     'replacement'   => 'dash' // Either dash or underscore
                // );
                // $this->load->library('slug', $config);

                //$this->common_model->set_table('job_fair');
								
                if($id)
                {
                    //$slug_data                          = array('industry_name' => $this->input->post('industry_name'),);
                    //$slug                               = $this->slug->create_uri($slug_data, $id);
                    $update['institute_id']         = $this->session->userdata('sess_institute_id');
                    $update['title']                = $this->input->post('job_fair_title');
                    $update['description']          = $this->input->post('description');
                    $update['pdf_url']              = $this->input->post('pdf_url');
                    $update['year']                 = $this->input->post('jobs_fair_year');
                    //$update['slug']                       = $slug;
                    if(!empty($image))
                    {
                        $update['image']            = $image;
                    }
                    $update['status']               = $this->input->post('status');
                    $update['modified_on']          = date('Y-m-d H:i:s');
                    $update['modified_by']          = $this->session->userdata('user_id');

                    $response = $this->job_fair->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $job_fair_id               = $id;
                        $msg = ['error' => 0, 'message' => 'Jobs fair successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['institute_id']         = $this->session->userdata('sess_institute_id');
                    $insert['title']                = $this->input->post('job_fair_title');
                    $insert['description']          = $this->input->post('description');
                    $insert['pdf_url']              = $this->input->post('pdf_url');
                    $insert['year']                 = $this->input->post('jobs_fair_year');
                    $insert['image']                = $image;
                    $insert['status']               = $this->input->post('status');
                    $insert['created_on']           = date('Y-m-d H:i:s');
                    $insert['created_by']           = $this->session->userdata('user_id');
                    $insert['modified_on']          = date('Y-m-d H:i:s');
                    $insert['modified_by']          = $this->session->userdata('user_id');

                    // print_r($insert);
                    // exit();
                    $response                       = $this->job_fair->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $job_fair_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Jobs fair successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/job_fair/');
            }
        }

        if($id!='')
        {
            $job_fair                       = $this->job_fair->get_jobs_fair_list(['id' => $id, 'status !=' => '-1']);
            $this->data['jobs_fair_images'] = $this->job_fair->get_table_data('job_fair', ['id' => $id]);
            $this->data['post_data']        = isset($job_fair[0]) ? $job_fair[0] : [];
            
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'job_fair not found']);
                redirect(base_url()."cms/job_fair/");
            }
        }

        $this->data['content']              = $this->load->view('cms/job_fair/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function base64_to_image($image_data='', $path='') {
        $image_name         = '';
        $path               = !empty($path) ? $path : './upload_file/kjsieit/jobs_fair/images/';
        
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
        return ['image' => $image_name];
    }

    function file_upload()
    {
        $pathToUpload   = './upload_file/kjsieit/jobs_fair/images/';
        if(!file_exists($pathToUpload))
        {
            $create     = mkdir($pathToUpload);
            chmod("$pathToUpload", 0777);
        }
        $files          = $_FILES;
        // print_r($files);
        // echo "<br>-----------<br>";
        // print_r($_FILES['image']['name']);
        //exit();
        $fimg           = count($_FILES['image']['name']);
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
            $fileNamefeatured12         = $_FILES['image']['name'];
            $fileNamefeatured           = str_replace(' ', '_', $fileNamefeatured12);
            $images2[]                  = $fileNamefeatured;

            $this->load->library('upload', $config22);
            $this->upload->initialize($config22);
            $this->upload->do_upload();
            if(!$this->upload->do_upload('image'))
            {
                $error = array('error' => $this->upload->display_errors());
                // echo "error : <br>";
                // print_r($error);
                 $image = '';
            }
            else
            {
                $upload_data            = $this->upload->data();
                $image              = isset($upload_data['file_name']) ? $upload_data['file_name'] : '';
                // echo "image : <br>";
                // print_r($image);
            }
        }

        return ['image' => $image];
    }

    function deleteimage()
    {
        $deleteid  = $this->input->post('id');
        $update['image']                    = null;
        $update['modified_on']              = date('Y-m-d H:i:s');
        $update['modified_by']              = $this->session->userdata('user_id');

        //$this->job_fair->set_table('job_fair');
        $this->job_fair->delete_image($deleteid, $update);
        echo true;

    }

    function delete($id='')
    {
        $this->data['insta_id'] = $this->default_institute_id;
        validate_permissions('Job_fair', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $jobs_fair = $this->job_fair->get_jobs_fair_list(['id' => $id, 'status !=' => '-1']);

        if(!empty($jobs_fair))
        {
            //$this->job_fair->set_table('plants');
            $response = $this->job_fair->_delete('id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Plant not found.']);
        }
        redirect(base_url().'cms/job_fair/');
    }
}
