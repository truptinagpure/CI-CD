<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Source extends Somaiya_Controller
{
    private $default_institute_id;

    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/mediacoverage/Source_model', 'source_model');
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
        $this->data['sub_child_menu_type']  = "source";

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];

        validate_permissions('Source', 'index', $this->config->item('method_for_view'), $this->data['institute_id']);
        
        $this->data['data_list']            = $this->source_model->get_source_list();
        // echo "<pre>";
        // print_r($this->data['data_list']);
        // exit();
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/mediacoverage/source/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "source";
        $this->data['child_menu_type']      = "save_source";
        $this->data['sub_child_menu_type']  = "";
        $this->data['source_data']            = [];
        $this->data['source_id']              = $id;

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
        
        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Source', 'edit', $per_action, $this->data['institute_id']);

        if($this->input->post())
        {
            $this->data['source_data'] = $this->input->post();
        }

        // print_r($this->input->post());
        // exit();
        $this->form_validation->set_rules('source_name', 'Source Name', 'required');
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
                
                $area_of_interest = '';
                
                if($id)
                {
                    $update['source_name']                = $this->input->post('source_name');
					$update['public']                     = $this->input->post('public');
                    if(!empty($image))
                    {
                        $update['media_source_image']            = isset($image) ? $image : 'default.png';
                    }
                    $update['modified_on']          = date('Y-m-d H:i:s');
                    $update['modified_by']          = $this->session->userdata['user_id'];
                    // echo"<pre>";
                    // print_r($update);
                    // echo "<br>++++++++++<br>";
                    // exit();
                    $response = $this->source_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $source_id                                = $id;
                        $msg = ['error' => 0, 'message' => 'Source successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['source_name']        = $this->input->post('source_name');
                    $insert['media_source_image'] = isset($image) ? $image : 'default.png';
                    $insert['public']             = $this->input->post('public');
					
                    $insert['created_on']         = date('Y-m-d H:i:s');
                    $insert['created_by']         = $this->session->userdata['user_id'];
                    // echo"<pre>";
                    // print_r($insert);
                    // echo "<br>++++++++++<br>";
                    // exit();
                    $response                 = $this->source_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        //$source_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Source successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/source/');
            }
        }

        if($id!='')
        {
            $source                           = $this->source_model->get_source_list(['s.id' => $id, 's.public !=' => '-1']);
           // $this->data['source_images']      = $this->source_model->get_table_data('contents', ['relation_id' => $id]);
            $this->data['source_data']        = isset($source[0]) ? $source[0] : [];
            
            if(empty($this->data['source_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'source not found']);
                redirect(base_url()."cms/source/");
            }
        }

        $this->data['content']              = $this->load->view('cms/mediacoverage/source/form',$this->data,true);
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
        $deleteid  = $this->input->post('source_id');
        $update['media_source_image']                   = null;
        $update['modified_on']             = date('Y-m-d H:i:s');
        $update['modified_by']             = $this->session->userdata('user_id');

        //$this->job_fair->set_table('job_fair');
        $this->source_model->delete_image($deleteid, $update);
        echo true;

    }

    function delete($id='')
    {
        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
            
        validate_permissions('Source', 'delete', $this->config->item('method_for_delete'), $this->data['institute_id']);
             
        $source = $this->source_model->get_source_list(['s.id' => $id, 's.public !=' => '-1']);

        if(!empty($source))
        {
            $response = $this->source_model->_delete('id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Plant not found.']);
        }
        redirect(base_url().'cms/source/');
    }
}