<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Industrial_visits extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/industrial_visits/Industrial_visits_model', 'industrial_visits');
        //$this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "industrial_visits";
        $this->data['child_menu_type']      = "industrial_visits";
        $this->data['sub_child_menu_type']  = "industrial_visits";

        validate_permissions('Industrial_visits', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list']            = $this->industrial_visits->get_industrial_visit(array('iv.institute_id' => $this->session->userdata['sess_institute_id']));
        // print_r($this->data['data_list']);
        // exit();
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/industrial_visits/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['title']                = 'Industrial Visits';
        $this->data['module']               = 'industrial_visits';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "industrial_visits";
        $this->data['child_menu_type']      = "save_industrial_visits";
        $this->data['sub_child_menu_type']  = "save_industrial_visits";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        
        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Industrial_visits', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        // print_r($this->input->post());
        // exit();
        $this->form_validation->set_rules('department_id[]', 'Department Name', 'required');
        $this->form_validation->set_rules('industry_name', 'Industry Name', 'required');
        $this->form_validation->set_rules('location', 'Location', 'required');
        /* $this->form_validation->set_rules('contact_person', 'Contac Person', 'required');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'required');
        $this->form_validation->set_rules('email_id', 'Email id', 'required');
        $this->form_validation->set_rules('website_url', 'Website_url', 'required'); */
		$this->form_validation->set_rules('visit_from', 'Vistit From', 'required');
        $this->form_validation->set_rules('visit_to', 'Visit To', 'required');
        /* $this->form_validation->set_rules('organise_by', 'Organise By', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required'); */
        //$this->form_validation->set_rules('image', 'Image', 'required');
        $this->form_validation->set_rules('status', 'Public', '');

        if($this->form_validation->run($this) === TRUE)
        {
            // print_r($this->input->post());
            // echo "<br>------------</br>";
            // exit();
            if($this->input->post())
            {   
                $path  = './upload_file/kjsieit/industrial_visits/images/';
                $filesnew   = $this->base64_to_image($this->input->post('image'), $path);
                $files      = $this->file_upload();

                $image  = isset($filesnew['image']) ? $filesnew['image'] : '';
                
                //$filesnew = $this->base64_to_image($this->input->post('image'), $path);
               //  $files = $this->file_upload();

               //  //$thumbnail      = isset($filesnew['image']) ? $filesnew['thumbnail'] : '';
               // // $image      = isset($filesnew['image']) ? $filesnew['image'] : '';
               //  $image         = isset($files['image']) ? $files['image'] : [];
                // echo "img upload";
                // exit();
                                // $config = array(
                //     'table'         => 'industrial_visits',
                //     'id'            => 'id',
                //     'field'         => 'slug',
                //     'title'         => 'industry_name',
                //     'replacement'   => 'dash' // Either dash or underscore
                // );
                // $this->load->library('slug', $config);

                //$this->common_model->set_table('industrial_visits');
				
				$department_id = '';
                if(isset($this->data['post_data']['department_id']) && !empty($this->data['post_data']['department_id']) && is_array($this->data['post_data']['department_id']))
                    {
                        $department_id                   = implode(',', $this->data['post_data']['department_id']);
                    }
					
                if($id)
                {
                    //$slug_data                          = array('industry_name' => $this->input->post('industry_name'),);
                    //$slug                               = $this->slug->create_uri($slug_data, $id);

                    $update['department_id']                = $department_id;
                    $update['institute_id']                 = $this->session->userdata('sess_institute_id');
                    $update['industry_name']                = $this->input->post('industry_name');
                    $update['location']                     = $this->input->post('location');
                    $update['contact_person']               = $this->input->post('contact_person');
                    $update['contact_number']               = $this->input->post('contact_number');
                    $update['email_id']                     = $this->input->post('email_id');
                    $update['website_url']                  = $this->input->post('website_url');
                    $update['visit_from']                   = $this->input->post('visit_from');
                    $update['visit_to']                     = $this->input->post('visit_to');
                    $update['organise_by']                  = $this->input->post('organise_by');
                    $update['description']                  = $this->input->post('description');
                    //$update['gallery_url']                  = isset($this->input->post('gallery_url')) ? $this->input->post('gallery_url') : 'null';
                    $update['gallery_url']                  = $this->input->post('gallery_url');
                    //$update['slug']                       = $slug;
                    if(!empty($image))
                    {
                        $update['image']                    = $image;
                    }
                    $update['status']                       = $this->input->post('status');
                    $update['modified_on']                  = date('Y-m-d H:i:s');
                    $update['modified_by']                  = $this->session->userdata('user_id');

                    $response = $this->industrial_visits->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $industrial_visits_id               = $id;
                        $msg = ['error' => 0, 'message' => 'Industry Visit successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['department_id']                = $department_id;
                    $insert['institute_id']                 = $this->session->userdata('sess_institute_id');
                    $insert['industry_name']                = $this->input->post('industry_name');
                    $insert['location']                     = $this->input->post('location');
                    $insert['contact_person']               = $this->input->post('contact_person');
                    $insert['contact_number']               = $this->input->post('contact_number');
                    $insert['email_id']                     = $this->input->post('email_id');
                    $insert['website_url']                  = $this->input->post('website_url');
                    $insert['visit_from']                   = $this->input->post('visit_from');
                    $insert['visit_to']                     = $this->input->post('visit_to');
                    $insert['organise_by']                  = $this->input->post('organise_by');
                    $insert['description']                  = $this->input->post('description');
                    //$insert['gallery_url']                  = isset($this->input->post('gallery_url')) ? $this->input->post('gallery_url') : '';
                    $insert['gallery_url']                  = $this->input->post('gallery_url');
                    //$insert['slug']                       = $this->slug->create_uri(array('industry_name' => $this->input->post('industry_name')));
                    $insert['image']                        = $image;
                    $insert['status']                       = $this->input->post('status');
                    $insert['created_on']                   = date('Y-m-d H:i:s');
                    $insert['created_by']                   = $this->session->userdata('user_id');
                    $insert['modified_on']                  = date('Y-m-d H:i:s');
                    $insert['modified_by']                  = $this->session->userdata('user_id');

                    $response                               = $this->industrial_visits->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $industrial_visits_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Industry Visit successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/industrial_visits/');
            }
        }

        if($id!='')
        {
            $industrial_visits                 = $this->industrial_visits->get_industrial_visit(['iv.id' => $id, 'iv.status !=' => '-1']);
            $this->data['industry_images']     = $this->industrial_visits->get_table_data('industrial_visits', ['id' => $id]);
            $this->data['post_data']           = isset($industrial_visits[0]) ? $industrial_visits[0] : [];
            
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Industrial_visits not found']);
                redirect(base_url()."cms/industrial_visits/");
            }
        }

        $this->data['industrial_department']     = $this->industrial_visits->get_parent_department();
        // print_r($this->data['industrial_department']);
        // exit();
        $this->data['content']              = $this->load->view('cms/industrial_visits/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function base64_to_image($image_data='', $path='') {
        $image_name         = '';
        $path               = !empty($path) ? $path : './upload_file/kjsieit/industrial_visits/images/';
        
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
        $pathToUpload   = './upload_file/kjsieit/industrial_visits/images/';
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

        //$this->industrial_visits->set_table('industrial_visits');
        $this->industrial_visits->delete_image($deleteid, $update);
        echo true;

    }

    function delete($id='')
    {
        $this->data['insta_id'] = $this->default_institute_id;
        validate_permissions('Industrial_visits', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $industry = $this->industrial_visits->get_industrial_visit(['iv.id' => $id, 'iv.status !=' => '-1']);

        if(!empty($industry))
        {
            //$this->industrial_visits->set_table('plants');
            $response = $this->industrial_visits->_delete('id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Plant not found.']);
        }
        redirect(base_url().'cms/industrial_visits/');
    }
}
