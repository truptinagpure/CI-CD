<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mediacoverage extends Somaiya_Controller
{
    private $default_institute_id;

    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/mediacoverage/Mediacoverage_model', 'mediacoverage_model');
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
        $this->data['sub_menu_type']        = "news_media";
        $this->data['child_menu_type']      = "media_coverage";
        $this->data['sub_child_menu_type']  = "media_coverage";

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];

        validate_permissions('Mediacoverage', 'index', $this->config->item('method_for_view'), $this->data['institute_id']);
        
        //$this->data['data_list']            = $this->mediacoverage_model->get_mediacoverage_list(array('m.institute_id' => $this->data['institute_id']));
		$this->data['data_list']            = $this->mediacoverage_model->get_mediacoverage_list();
        // echo "<pre>";
        // print_r($this->data['data_list']);
        // exit();
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/mediacoverage/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "mediacoverage";
        $this->data['child_menu_type']      = "save_mediacoverage";
        $this->data['sub_child_menu_type']  = "";
        $this->data['mediacoverage_data']            = [];
        $this->data['mediacoverage_id']              = $id;

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
        $this->data['category']             = $this->Somaiya_general_admin_model->get_all_categories();
        $this->data['source']             = $this->Somaiya_general_admin_model->get_source();
        $this->data['languages']            = $this->Somaiya_general_admin_model->get_all_language();
        // $this->data['departments']          = $this->mediacoverage_model->get_departmentsByInstitute($this->session->userdata['sess_institute_id']);
        // echo "<pre>";
        // print_r($this->data['category']);exit();

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Mediacoverage', 'edit', $per_action, $this->data['institute_id']);

        if($this->input->post())
        {
            $this->data['mediacoverage_data'] = $this->input->post();
        }

        // print_r($this->input->post());
        // exit();
        $this->form_validation->set_rules('mediacoverage_name', 'Mediacoverage Name', 'required');
        $this->form_validation->set_rules('area_of_interest[]', 'Area of interest', 'required');
        $this->form_validation->set_rules('type', 'Type', 'required');
        $this->form_validation->set_rules('source', 'Source', 'required');
        //$this->form_validation->set_rules('department_id[]', 'Departments', 'required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        //$this->form_validation->set_rules('image', 'Image', 'required');

        if($this->form_validation->run($this) === TRUE)
        {
            // echo "<pre>";
            // print_r($this->input->post());
            // echo "<br>------------</br>";
            // exit();
            if($this->input->post())
            {   
                $path  = './upload_file/images20/';
                $filesnew   = $this->base64_to_image($this->input->post('image'), $path);

                $image  = isset($filesnew['image']) ? $filesnew['image'] : '';     
                
                $area_of_interest = $department_id = '';

                if($this->input->post('area_of_interest') != '')
                {
                    $area_of_interest = implode(",", $this->input->post('area_of_interest'));
                }

                // if(isset($this->data['mediacoverage_data']['department_id']) && !empty($this->data['mediacoverage_data']['department_id']))
                // {
                //     $department_id = implode(',', $this->data['mediacoverage_data']['department_id']);
                // }
                                
                if($id)
                {
                    $update['mediacoverage']['institute_id']         = $this->data['institute_id'];
                    $update['mediacoverage']['title']                = $this->input->post('mediacoverage_name');
                    $update['mediacoverage']['category_id']          = $area_of_interest;
                    $update['mediacoverage']['person']               = $this->input->post('related_person'); 
                    $update['mediacoverage']['date']                 = $this->input->post('start_date');
                    $update['mediacoverage']['type']                 = $this->input->post('type');
                    $update['mediacoverage']['source']               = $this->input->post('source');
                    // $update['mediacoverage']['department_id']        = $department_id;
                    $update['mediacoverage']['link_to_epaper']                 = $this->input->post('link_to_epaper');
                    if(!empty($image))
                    {
                        $update['mediacoverage']['image']            = isset($image) ? $image : 'upload_file/images20/default.png';
                    }
                    $update['mediacoverage']['whats_new']            = $this->input->post('whats_new');
                    $update['mediacoverage']['whats_new_expiry_date']= $this->input->post('whats_new_expiry_date');
                    $update['mediacoverage']['public']               = $this->input->post('public');
                    $update['mediacoverage']['modified_on']          = date('Y-m-d H:i:s');
                    $update['mediacoverage']['modified_by']          = $this->session->userdata['user_id'];

                    
                    $update['contents']['contents_id']          = $this->input->post('contents_id');
                    $update['contents']['name']                 = $this->input->post('mediacoverage_name');
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
                    $response = $this->mediacoverage_model->_update('mediacoverage_id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $mediacoverage_id                                = $id;
                        $msg = ['error' => 0, 'message' => 'Mediacoverage successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['mediacoverage']['institute_id']         = $this->data['institute_id'];
                    $insert['mediacoverage']['title']                = $this->input->post('mediacoverage_name');
                    $insert['mediacoverage']['category_id']          = $area_of_interest;
                    $insert['mediacoverage']['person']               = $this->input->post('related_person'); 
                    $insert['mediacoverage']['date']                 = $this->input->post('start_date');
                    $insert['mediacoverage']['type']                 = $this->input->post('type');
                    // $insert['mediacoverage']['department_id']        = $department_id;
                    $insert['mediacoverage']['source']               = $this->input->post('source');
                    $insert['mediacoverage']['link_to_epaper']                 = $this->input->post('link_to_epaper');
                    
                    $insert['mediacoverage']['image']            = isset($image) ? $image : 'upload_file/images20/default.png';
                    
                    $insert['mediacoverage']['whats_new']            = $this->input->post('whats_new');
                    $insert['mediacoverage']['whats_new_expiry_date']= $this->input->post('whats_new_expiry_date');
                    $insert['mediacoverage']['public']               = $this->input->post('public');
                    $insert['mediacoverage']['created_on']          = date('Y-m-d H:i:s');
                    $insert['mediacoverage']['created_by']          = $this->session->userdata['user_id'];

                    
                    $insert['contents']['contents_id']          = $this->input->post('contents_id');
                    $insert['contents']['name']                 = $this->input->post('mediacoverage_name');
                    $insert['contents']['description']          = $this->input->post('description');
                    $insert['contents']['language_id']          = $this->input->post('language_id');
                    $insert['contents']['public']               = 1; // 1 = active
                    $insert['contents']['created_on']          = date('Y-m-d H:i:s');
                    $insert['contents']['created_by']          = $this->session->userdata['user_id'];

                    // echo"<pre>";
                    // print_r($insert);
                    // echo "<br>++++++++++<br>";
                    // exit();
                    $response                 = $this->mediacoverage_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        //$mediacoverage_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Mediacoverage successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/mediacoverage/');
            }
        }

        if($id!='')
        {
            $mediacoverage                           = $this->mediacoverage_model->get_mediacoverage_list(['m.mediacoverage_id' => $id, 'm.public !=' => '-1']);
           // $this->data['mediacoverage_images']      = $this->mediacoverage_model->get_table_data('contents', ['relation_id' => $id]);
            $this->data['mediacoverage_data']        = isset($mediacoverage[0]) ? $mediacoverage[0] : [];
            
            if(empty($this->data['mediacoverage_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'mediacoverage not found']);
                redirect(base_url()."cms/mediacoverage/");
            }
        }

        $this->data['content']              = $this->load->view('cms/mediacoverage/form',$this->data,true);
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
        $deleteid  = $this->input->post('mediacoverage_id');
        $update['image']                   = null;
        $update['modified_on']             = date('Y-m-d H:i:s');
        $update['modified_by']             = $this->session->userdata('user_id');

        //$this->job_fair->set_table('job_fair');
        $this->mediacoverage_model->delete_image($deleteid, $update);
        echo true;

    }

    function delete($id='')
    {
        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
            
        validate_permissions('Mediacoverage', 'delete', $this->config->item('method_for_delete'), $this->data['institute_id']);
             
        $mediacoverage = $this->mediacoverage_model->get_mediacoverage_list(['m.mediacoverage_id' => $id, 'm.public !=' => '-1']);

        if(!empty($mediacoverage))
        {
            $response = $this->mediacoverage_model->_delete('mediacoverage_id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Plant not found.']);
        }
        redirect(base_url().'cms/mediacoverage/');
    }
}