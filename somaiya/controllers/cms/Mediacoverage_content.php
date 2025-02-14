<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mediacoverage_content extends Somaiya_Controller
{
    private $default_institute_id;

    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/mediacoverage/Mediacoverage_model', 'mediacoverage_model');
        $this->load->model('cms/mediacoverage/Mediacoverage_content_model', 'mediacoverage_content_model');
        //$this->load->model('cms/Somaiya_general_admin_model', 'Somaiya_general_admin_model');
        //$this->load->model('cms/Category_model', 'category_model');
        $user_id = $this->session->userdata['user_id'];
        //echo '<pre>'; print_r($this->session->all_userdata());exit;
        $default_institute_id = $this->config->item('default_institute_id');

    }

    function index()
    {
        echo "hello";
        exit();
    }
    
    function contents($mediacoverage_id='')
    {
        // echo "mediacoverage content index method called".$mediacoverage_id;
        // exit();
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "mediacoverage";
        $this->data['child_menu_type']      = "";
        $this->data['sub_child_menu_type']  = "";

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];

        validate_permissions('Mediacoverage_content', 'index', $this->config->item('method_for_view'), $this->data['institute_id']);
        
        //echo "mediacoverage id : ".$mediacoverage_id;
        $contents = $this->mediacoverage_content_model->get_mediacoverage_contents($mediacoverage_id);
        // echo "<pre>";
        // print_r($contents);
        // exit();

        if(!empty($contents))
        {   
            $this->data['content_list']         = $contents;
            $this->data['title']                = _l("mediacoverage content", $this);
            $this->data['page']                 = "mediacoveragecontent";
            $this->data['mediacoverage_id']              = $mediacoverage_id;
            $this->data['content']              = $this->load->view('cms/mediacoverage/mediacoverage_content/index',$this->data,true);
            $this->load->view($this->mainTemplate, $this->data);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'No mediacoverage found']);
            redirect(base_url().'cms/mediacoverage/');
        }

        // $this->data['title']                = _l("Module",$this);
        // $this->data['page']                 = "Module";
        // $this->data['content']              = $this->load->view('cms/mediacoverage/mediacoverage_content/index',$this->data,true);
        // $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($mediacoverage_id='',$id='')
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "mediacoverage";
        $this->data['child_menu_type']      = "";
        $this->data['sub_child_menu_type']  = "";

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];

        $this->data['contents_id']          = $id;
        $this->data['mediacoverage_id']             = $mediacoverage_id;
        $this->data['languages']            = $this->Somaiya_general_admin_model->get_all_language();
        $this->data['mediacoverage_content_data']   = [];

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Mediacoverage_content', 'edit', $per_action, $this->data['institute_id']);

        //if(!empty($mediacoverage_id) && !empty($id))
        if(!empty($mediacoverage_id))
        {
            //echo "test one";//exit();
            $this->form_validation->set_rules('name', 'Name', 'required');      
            //$this->form_validation->set_rules('description', 'Description', 'required');

            if($this->input->post())
            {
                $this->data['mediacoverage_content_data']      = $this->input->post();
            }
            else
            {
                $this->data['mediacoverage_content_data']      = $this->mediacoverage_content_model->get_details($mediacoverage_id, $id);                
            }
            // exit();
            // echo "<pre>";
            // print_r($this->data['mediacoverage_content_data']);
            // exit();
            // if(!empty($this->data['mediacoverage_content_data']))
            // {
                if($this->form_validation->run($this) === TRUE)
                {
                    if($this->input->post())
                    {

                        // echo "<pre>";
                        // print_r($this->input->post());
                        // echo "<br>----------<br>";
                        // exit();
                        $msg = $this->save($mediacoverage_id, $id, $this->input->post());
                        $this->session->set_flashdata('status', $msg);
                        redirect(base_url().'cms/mediacoverage_content/contents/'.$mediacoverage_id);
                    }
                }

                $this->data['title']                = _l("Module",$this);
                $this->data['page']                 = "Module";
                $this->data['content']              = $this->load->view('cms/mediacoverage/mediacoverage_content/form',$this->data,true);
                $this->load->view($this->mainTemplate,$this->data);
            // }
            // else
            // {
            //     $this->session->set_flashdata('status', ['error' => 1, 'message' => 'No mediacoverage content found']);
            //     redirect(base_url().'cms/mediacoverage');
            // }

        }
        else
        {
            //echo "test two";exit();
            $this->session->set_flashdata('status', ['error' => 1, 'message' => 'Invalid request']);
            redirect(base_url().'cms/mediacoverage');
        } 
    }

    public function save($mediacoverage_id, $id='', $mediacoverage_content_data=[])
    {
        $msg         = array('error' => 1, 'message' => 'Access denied');

        if(!empty($mediacoverage_content_data))
        {
            //if($mediacoverage_data['language'] == 'en' && $mediacoverage_data['status'] < 1)
            if($mediacoverage_content_data['language_id'] == 1 && $mediacoverage_content_data['public'] < 1) // language_id=1 is default english lang
            {
                $msg = array('error' => 1, 'message' => 'Setting default english language content to in-active state is not allowed');
            }
            else
            {
                $save['mediacoverage_id']            = $mediacoverage_id;
                $save['language_id']                = $mediacoverage_content_data['language_id'];
                $save['name']                       = $mediacoverage_content_data['name'];
                $save['description']                = $mediacoverage_content_data['description'];
                $save['public']                     = $mediacoverage_content_data['public'];
                $msg                                = $this->mediacoverage_content_model->save($mediacoverage_id, $id, $save);
            }
        }
        return $msg;
    }

    public function check_content_by_lang()
    {
        //echo "hello";exit();
        if (!$this->input->is_ajax_request())
        {
            //echo "cant access url directly";  
            show_404(); // Output "Page not found" error.
            exit();
        }

        if(!empty($this->input->post()))
        {
            $mediacoverage_id = $this->input->post('mediacoverage_id');
            $mediacoverage_content_id = $this->input->post('mediacoverage_content_id');
            $language_id = $this->input->post('language_id');

            $count = $this->mediacoverage_content_model->check_content_by_lang($mediacoverage_id, $mediacoverage_content_id, $language_id);
            // echo "count : ".$count;
            // exit();
            if($count == 0)
            {
               $result = "true";
            }
            else
            {
                $result = "false";
            }

            echo $result;
        }
        
    }

    function delete($mediacoverage_id='', $id='')
    {
        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
            
        validate_permissions('Mediacoverage_content', 'delete', $this->config->item('method_for_delete'), $this->data['institute_id']);
             
        $mediacoverage_contents = $this->mediacoverage_content_model->get_details($mediacoverage_id, $id);

        if(!empty($mediacoverage_contents))
        {
            $response = $this->mediacoverage_content_model->_delete($mediacoverage_id, $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Plant not found.']);
        }
        redirect(base_url().'cms/mediacoverage_content/contents/'.$mediacoverage_id);

    }



    
}