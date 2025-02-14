<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Event extends Somaiya_Controller
{
    private $default_institute_id;

    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/event/Event_model', 'event_model');
        $this->load->model('cms/Somaiya_general_admin_model', 'Somaiya_general_admin_model');
        //$this->load->model('cms/Category_model', 'category_model');
        $user_id = $this->session->userdata['user_id'];
        //echo '<pre>'; print_r($this->session->all_userdata());exit;
        $default_institute_id = $this->config->item('default_institute_id');

    }

    /** DASHBOARD **/

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "event";
        $this->data['child_menu_type']      = "event";
        $this->data['sub_child_menu_type']  = "";

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];

        validate_permissions('Event', 'index', $this->config->item('method_for_view'), $this->data['institute_id']);
        
        $this->data['data_list']            = $this->event_model->get_event_list(array('e.institute_id' => $this->data['institute_id']));
        // echo "<pre>";
        // print_r($this->data['data_list']);
        // exit();
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/event/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "event";
        $this->data['child_menu_type']      = "save_event";
        $this->data['sub_child_menu_type']  = "";
        $this->data['event_data']            = [];
        $this->data['event_id']              = $id;

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
        $this->data['event_type']           = $this->event_model->get_all_event_type_list();
        $this->data['audience_type']        = $this->event_model->get_all_audience_type_list();
        // $this->data['departments']          = $this->event_model->get_departmentsByInstitute($this->session->userdata['sess_institute_id']);
        $this->data['languages']            = $this->Somaiya_general_admin_model->get_all_language();
        $this->data['location']             = $this->Somaiya_general_admin_model->get_all_locations();
        $this->data['event_gallery_mapping']= $this->event_model->get_all_event_gallery_mapping($this->session->userdata['sess_institute_id']);
        // echo "<pre>"; print_r($this->data['event_gallery_mapping']);exit();
        // echo "<pre>";
        // print_r($this->data['category']);exit();

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Event', 'edit', $per_action, $this->data['institute_id']);

        if($this->input->post())
        {
            $this->data['event_data'] = $this->input->post();
        }

        // print_r($this->input->post());
        // exit();
        $this->form_validation->set_rules('event_name', 'Event Name', 'required');
        // $this->form_validation->set_rules('location', 'Location', 'required');
        $this->form_validation->set_rules('event_type[]', 'Event Type', 'required');
        $this->form_validation->set_rules('audience_type[]', 'Audience Type', 'required');
        //$this->form_validation->set_rules('department_id[]', 'Departments', 'required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('end_date', 'End Date', 'required');      
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
                $image  = isset($filesnew['image']) ? $filesnew['image'] : '';     
                

                $event_type = $audience_type = $department_id = '';

                // echo"<pre>";
                // print_r($this->data['event_data']['audience_type']);
                // exit();
                if(isset($this->data['event_data']['event_type']) && !empty($this->data['event_data']['event_type']))
                {
                    $event_type = implode(',', $this->data['event_data']['event_type']);
                }

                if(isset($this->data['event_data']['audience_type']) && !empty($this->data['event_data']['audience_type']))
                {
                    $audience_type = implode(',', $this->data['event_data']['audience_type']);
                }

                // if(isset($this->data['event_data']['department_id']) && !empty($this->data['event_data']['department_id']))
                // {
                //     $department_id = implode(',', $this->data['event_data']['department_id']);
                // }


                if($id)
                {
                    $update['event']['institute_id']         = $this->data['institute_id'];
                    $update['event']['location_id']          = $this->input->post('location');
                    $update['event']['event_name']           = $this->input->post('event_name');
                    $update['event']['to_date']              = $this->input->post('start_date');
                    $update['event']['from_date']            = $this->input->post('end_date');
                    if(!empty($image))
                    {
                        $update['event']['image']            = $image;
                    }

                    $update['event']['event_type']           = $event_type;
                    $update['event']['audience_type']        = $audience_type;
                    // $update['event']['department_id']        = $department_id;
                    $update['event']['featured_event']       = $this->input->post('featured_event');
                    //$update['event']['sticky_event']         = $this->input->post('sticky_event');
                    $update['event']['event_gallery_mapping']= $this->input->post('event_gallery_mapping');
                    $update['event']['whats_new']            = $this->input->post('whats_new');
                    $update['event']['whats_new_expiry_date']= $this->input->post('whats_new_expiry_date');
                    $update['event']['public']               = $this->input->post('public');
                    $update['event']['modified_on']          = date('Y-m-d H:i:s');
                    $update['event']['modified_by']          = $this->session->userdata['user_id'];

                    
                    $update['contents']['contents_id']          = $this->input->post('contents_id');
                    $update['contents']['name']                 = $this->input->post('event_name');
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
                    $response = $this->event_model->_update('event_id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $event_id                                = $id;
                        $msg = ['error' => 0, 'message' => 'Event successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['event']['institute_id']         = $this->data['institute_id'];
                    $insert['event']['location_id']          = $this->input->post('location');
                    $insert['event']['event_name']           = $this->input->post('event_name');
                    $insert['event']['to_date']              = $this->input->post('start_date');
                    $insert['event']['from_date']            = $this->input->post('end_date');
                    $insert['event']['image']                = $image;
                    $insert['event']['event_type']           = $event_type;
                    $insert['event']['audience_type']        = $audience_type;
                    // $insert['event']['department_id']        = $department_id;
                    $insert['event']['featured_event']       = $this->input->post('featured_event');
                    //$insert['event']['sticky_event']         = $this->input->post('sticky_event');
                    $insert['event']['event_gallery_mapping']= $this->input->post('event_gallery_mapping');
                    $insert['event']['whats_new']            = $this->input->post('whats_new');
                    $insert['event']['whats_new_expiry_date']= $this->input->post('whats_new_expiry_date');
                    $insert['event']['public']               = $this->input->post('public');
                    $insert['event']['created_on']           = date('Y-m-d H:i:s');
                    $insert['event']['created_by']           = $this->session->userdata['user_id'];

                    $insert['contents']['contents_id']          = $this->input->post('contents_id');
                    $insert['contents']['name']                 = $this->input->post('event_name');
                    $insert['contents']['description']          = $this->input->post('description');
                    $insert['contents']['language_id']          = $this->input->post('language_id');
                    $insert['contents']['public']               = 1; // 1 = active
                    $insert['contents']['created_on']           = date('Y-m-d H:i:s');
                    $insert['contents']['created_by']           = $this->session->userdata['user_id'];

                    // echo"<pre>";
                    // print_r($insert);
                    // echo "<br>++++++++++<br>";
                    // exit();
                    $response                 = $this->event_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        //$event_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Event successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/event/');
            }
        }

        if($id!='')
        {
            $event                           = $this->event_model->get_event_list(['e.event_id' => $id, 'e.public !=' => '-1']);
           // $this->data['event_images']      = $this->event_model->get_table_data('contents', ['relation_id' => $id]);
            $this->data['event_data']        = isset($event[0]) ? $event[0] : [];
            
            if(empty($this->data['event_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'event not found']);
                redirect(base_url()."cms/event/");
            }
        }

        $this->data['content']              = $this->load->view('cms/event/form',$this->data,true);
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
        $deleteid  = $this->input->post('event_id');
        $update['image']                   = null;
        $update['modified_on']             = date('Y-m-d H:i:s');
        $update['modified_by']             = $this->session->userdata('user_id');

        //$this->job_fair->set_table('job_fair');
        $this->event_model->delete_image($deleteid, $update);
        echo true;

    }

    function delete($id='')
    {
        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
            
        validate_permissions('Event', 'delete', $this->config->item('method_for_delete'), $this->data['institute_id']);
             
        $event = $this->event_model->get_event_list(['e.event_id' => $id, 'e.public !=' => '-1']);

        if(!empty($event))
        {
            $response = $this->event_model->_delete('event_id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Plant not found.']);
        }
        redirect(base_url().'cms/event/');
    }
}