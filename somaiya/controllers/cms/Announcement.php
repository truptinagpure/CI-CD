<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Announcement extends Somaiya_Controller
{
    private $default_institute_id;

    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/announcement/Announcement_model', 'announcement_model');
        $this->load->model('cms/Somaiya_general_admin_model', 'Somaiya_general_admin_model');
        $this->load->model('cms/Category_model', 'category_model');
        $user_id = $this->session->userdata['user_id'];
        //echo '<pre>'; print_r($this->session->all_userdata());exit;
        $default_institute_id = $this->config->item('default_institute_id');

    }

    /** DASHBOARD **/

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "news_media";
        $this->data['child_menu_type']      = "announcement";
        $this->data['sub_child_menu_type']  = "";

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];

        validate_permissions('Announcement', 'index', $this->config->item('method_for_view'), $this->data['institute_id']);
        
        $this->data['data_list']            = $this->announcement_model->get_announcement_list(array('a.institute_id' => $this->data['institute_id']));
        // echo "<pre>";
        // print_r($this->data['data_list']);
        // exit();
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/announcement/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "announcement";
        $this->data['child_menu_type']      = "save_announcement";
        $this->data['sub_child_menu_type']  = "";
        $this->data['announcement_data']            = [];
        $this->data['announcement_id']              = $id;

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
        $this->data['category']             = $this->Somaiya_general_admin_model->get_all_categories();
        $this->data['languages']            = $this->Somaiya_general_admin_model->get_all_language();
        // $this->data['departments']          = $this->announcement_model->get_departmentsByInstitute($this->session->userdata['sess_institute_id']);
        // echo "<pre>";
        // print_r($this->data['category']);exit();

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Announcement', 'edit', $per_action, $this->data['institute_id']);

        if($this->input->post())
        {
            $this->data['announcement_data'] = $this->input->post();
        }

        // print_r($this->input->post());
        // exit();
        $this->form_validation->set_rules('announcement_name', 'Announcement Name', 'required');
        $this->form_validation->set_rules('area_of_interest', 'Area of interest', 'required');
        //$this->form_validation->set_rules('department_id[]', 'Departments', 'required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        //$this->form_validation->set_rules('image', 'Image', 'required');

        if($this->form_validation->run($this) === TRUE)
        {
            // print_r($this->input->post());
            // echo "<br>------------</br>";
            // exit();
            if($this->input->post())
            {   
                $path  = './upload_file/images20/';
                $filesnew   = $this->base64_to_image($this->input->post('image'), $path);
                //$files      = $this->file_upload();

                $image  = isset($filesnew['image']) ? $filesnew['image'] : '';     
                
                $announcement_type = $audience_type  = $department_id = '';

                // echo"<pre>";
                // print_r($this->data['announcement_data']['audience_type']);
                // exit();
                
                if(isset($this->data['announcement_data']['department_id']) && !empty($this->data['announcement_data']['department_id']))
                {
                    $department_id = implode(',', $this->data['announcement_data']['department_id']);
                }

                if($id)
                {
                    $update['announcement']['institute_id']         = $this->data['institute_id'];
                    $update['announcement']['title']                = $this->input->post('announcement_name');
                    $update['announcement']['category_id']          = $this->input->post('area_of_interest');
                    $update['announcement']['department_id']        = $department_id;
                    $update['announcement']['person']               = $this->input->post('related_person');
                    
                    $update['announcement']['date']                 = $this->input->post('start_date');
                    if(!empty($image))
                    {
                        $update['announcement']['image']            = isset($image) ? $image : 'default.png';
                    }

                    $update['announcement']['whats_new']            = $this->input->post('whats_new');
                    $update['announcement']['whats_new_expiry_date']= $this->input->post('whats_new_expiry_date');
                    $update['announcement']['public']               = $this->input->post('public');
                    $update['announcement']['modified_on']          = date('Y-m-d H:i:s');
                    $update['announcement']['modified_by']          = $this->session->userdata['user_id'];

                    
                    $update['contents']['contents_id']          = $this->input->post('contents_id');
                    $update['contents']['name']                 = $this->input->post('announcement_name');
                    $update['contents']['description']          = $this->input->post('description');
                    $update['contents']['language_id']          = $this->input->post('language_id');
                    $update['contents']['public']               = 1; // 1 = active
                    $update['contents']['modified_on']          = date('Y-m-d H:i:s');
                    $update['contents']['modified_by']          = $this->session->userdata['user_id'];

                    //$update['slug']                       = $slug;
                    
                    // echo"<pre>";
                    // print_r($update);
                    // echo "<br>++++++++++<br>";
                    // exit();
                    $response = $this->announcement_model->_update('announcement_id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $announcement_id                                = $id;
                        $msg = ['error' => 0, 'message' => 'Announcement successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['announcement']['institute_id']         = $this->data['institute_id'];
                    $insert['announcement']['title']                = $this->input->post('announcement_name');
                    $insert['announcement']['category_id']          = $this->input->post('area_of_interest');
                    $insert['announcement']['department_id']        = $department_id;
                    $insert['announcement']['person']               = $this->input->post('related_person');
                    
                    $insert['announcement']['date']                 = $this->input->post('start_date');
                    $insert['announcement']['image']                = isset($image) ? $image : 'default.png';
                    
                    $insert['announcement']['whats_new']            = $this->input->post('whats_new');
                    $insert['announcement']['whats_new_expiry_date']= $this->input->post('whats_new_expiry_date');
                    $insert['announcement']['public']               = $this->input->post('public');
                    $insert['announcement']['created_on']           = date('Y-m-d H:i:s');
                    $insert['announcement']['created_by']           = $this->session->userdata['user_id'];

                    $insert['contents']['contents_id']          = $this->input->post('contents_id');
                    $insert['contents']['name']                 = $this->input->post('announcement_name');
                    $insert['contents']['description']          = $this->input->post('description');
                    $insert['contents']['language_id']          = $this->input->post('language_id');
                    $insert['contents']['public']               = 1; // 1 = active
                    $insert['contents']['created_on']           = date('Y-m-d H:i:s');
                    $insert['contents']['created_by']           = $this->session->userdata['user_id'];

                    // echo"<pre>";
                    // print_r($insert);
                    // echo "<br>++++++++++<br>";
                    // exit();
                    $response                 = $this->announcement_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        //$announcement_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Announcement successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/announcement/');
            }
        }

        if($id!='')
        {
            $announcement                           = $this->announcement_model->get_announcement_list(['a.announcement_id' => $id, 'a.public !=' => '-1']);
           // $this->data['announcement_images']      = $this->announcement_model->get_table_data('contents', ['relation_id' => $id]);
            $this->data['announcement_data']        = isset($announcement[0]) ? $announcement[0] : [];
            
            if(empty($this->data['announcement_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'announcement not found']);
                redirect(base_url()."cms/announcement/");
            }
        }

        $this->data['content']              = $this->load->view('cms/announcement/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function base64_to_image($image_data='', $path='') {
        $image_name         = '';
        $path               = !empty($path) ? $path : './upload_file/images20/';
        
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

    function deleteimage()
    {
        // echo "hello";
        // exit();
        $deleteid  = $this->input->post('announcement_id');
        $update['image']                   = null;
        $update['modified_on']             = date('Y-m-d H:i:s');
        $update['modified_by']             = $this->session->userdata('user_id');

        //$this->job_fair->set_table('job_fair');
        $this->announcement_model->delete_image($deleteid, $update);
        echo true;

    }

    function delete($id='')
    {
        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
            
        validate_permissions('Announcement', 'delete', $this->config->item('method_for_delete'), $this->data['institute_id']);
             
        $announcement = $this->announcement_model->get_announcement_list(['a.announcement_id' => $id, 'a.public !=' => '-1']);

        if(!empty($announcement))
        {
            $response = $this->announcement_model->_delete('announcement_id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Plant not found.']);
        }
        redirect(base_url().'cms/announcement/');
    }
}