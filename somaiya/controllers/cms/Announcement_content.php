<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Announcement_content extends Somaiya_Controller
{
    private $default_institute_id;

    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/announcement/Announcement_model', 'announcement_model');
        $this->load->model('cms/announcement/Announcement_content_model', 'announcement_content_model');
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
    
    function contents($announcement_id='')
    {
        // echo "announcement content index method called".$announcement_id;
        // exit();
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "announcement";
        $this->data['child_menu_type']      = "";
        $this->data['sub_child_menu_type']  = "";

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];

        validate_permissions('Announcement_content', 'index', $this->config->item('method_for_view'), $this->data['institute_id']);
        
        //echo "announcement id : ".$announcement_id;
        $contents = $this->announcement_content_model->get_announcement_contents($announcement_id);
        // echo "<pre>";
        // print_r($contents);
        // exit();

        if(!empty($contents))
        {   
            $this->data['content_list']         = $contents;
            $this->data['title']                = _l("announcement content", $this);
            $this->data['page']                 = "announcementcontent";
            $this->data['announcement_id']              = $announcement_id;
            $this->data['content']              = $this->load->view('cms/announcement/announcement_content/index',$this->data,true);
            $this->load->view($this->mainTemplate, $this->data);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'No announcement found']);
            redirect(base_url().'cms/announcement/');
        }

        // $this->data['title']                = _l("Module",$this);
        // $this->data['page']                 = "Module";
        // $this->data['content']              = $this->load->view('cms/announcement/announcement_content/index',$this->data,true);
        // $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($announcement_id='',$id='')
    {
        // echo "announcement id : ".$announcement_id. " and contents id :".$id;
        // exit();
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "announcement";
        $this->data['child_menu_type']      = "";
        $this->data['sub_child_menu_type']  = "";

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];

        $this->data['contents_id']          = $id;
        $this->data['announcement_id']             = $announcement_id;
        $this->data['languages']            = $this->Somaiya_general_admin_model->get_all_language();
        $this->data['announcement_content_data']   = [];

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Announcement_content', 'edit', $per_action, $this->data['institute_id']);

        //if(!empty($announcement_id) && !empty($id))
        if(!empty($announcement_id))
        {
            //echo "test one";//exit();
            $this->form_validation->set_rules('name', 'Name', 'required');      
            //$this->form_validation->set_rules('description', 'Description', 'required');

            if($this->input->post())
            {
                $this->data['announcement_content_data']      = $this->input->post();
            }
            else
            {
                $this->data['announcement_content_data']      = $this->announcement_content_model->get_details($announcement_id, $id);                
            }
            // exit();
            // echo "<pre>";
            // print_r($this->data['announcement_content_data']);
            // exit();
            // if(!empty($this->data['announcement_content_data']))
            // {
                if($this->form_validation->run($this) === TRUE)
                {
                    if($this->input->post())
                    {

                        // echo "<pre>";
                        // print_r($this->input->post());
                        // echo "<br>----------<br>";
                        // exit();
                        $msg = $this->save($announcement_id, $id, $this->input->post());
                        $this->session->set_flashdata('status', $msg);
                        redirect(base_url().'cms/announcement_content/contents/'.$announcement_id);
                    }
                }

                $this->data['title']                = _l("Module",$this);
                $this->data['page']                 = "Module";
                $this->data['content']              = $this->load->view('cms/announcement/announcement_content/form',$this->data,true);
                $this->load->view($this->mainTemplate,$this->data);
            // }
            // else
            // {
            //     $this->session->set_flashdata('status', ['error' => 1, 'message' => 'No announcement content found']);
            //     redirect(base_url().'cms/announcement');
            // }

        }
        else
        {
            //echo "test two";exit();
            $this->session->set_flashdata('status', ['error' => 1, 'message' => 'Invalid request']);
            redirect(base_url().'cms/announcement');
        } 
    }

    public function save($announcement_id, $id='', $announcement_content_data=[])
    {
        $msg         = array('error' => 1, 'message' => 'Access denied');

        if(!empty($announcement_content_data))
        {
            //if($announcement_data['language'] == 'en' && $announcement_data['status'] < 1)
            if($announcement_content_data['language_id'] == 1 && $announcement_content_data['public'] < 1) // language_id=1 is default english lang
            {
                $msg = array('error' => 1, 'message' => 'Setting default english language content to in-active state is not allowed');
            }
            else
            {
                $save['announcement_id']            = $announcement_id;
                $save['language_id']                = $announcement_content_data['language_id'];
                $save['name']                       = $announcement_content_data['name'];
                $save['description']                = $announcement_content_data['description'];
                $save['public']                     = $announcement_content_data['public'];
                $msg                                = $this->announcement_content_model->save($announcement_id, $id, $save);
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
            $announcement_id = $this->input->post('announcement_id');
            $announcement_content_id = $this->input->post('announcement_content_id');
            $language_id = $this->input->post('language_id');

            $count = $this->announcement_content_model->check_content_by_lang($announcement_id, $announcement_content_id, $language_id);
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

    function delete($announcement_id='', $id='')
    {
        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
            
        validate_permissions('Announcement_content', 'delete', $this->config->item('method_for_delete'), $this->data['institute_id']);
             
        $announcement_contents = $this->announcement_content_model->get_details($announcement_id, $id);

        if(!empty($announcement_contents))
        {
            $response = $this->announcement_content_model->_delete($announcement_id, $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Plant not found.']);
        }
        redirect(base_url().'cms/announcement_content/contents/'.$announcement_id);

    }



    
}