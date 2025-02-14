<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Donation_content extends Somaiya_Controller
{
    private $default_institute_id;

    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/donation/Donation_model', 'donation_model');
        $this->load->model('cms/donation/Donation_content_model', 'donation_content_model');
        $user_id = $this->session->userdata['user_id'];
        $default_institute_id = $this->config->item('default_institute_id');

    }

    function index()
    {
        echo "hello";
        exit();
    }
    
    function contents($donation_id='')
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "donation";
        $this->data['child_menu_type']      = "";
        $this->data['sub_child_menu_type']  = "";

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];

        validate_permissions('Donation_content', 'index', $this->config->item('method_for_view'), $this->data['institute_id']);
        
        $contents = $this->donation_content_model->get_donation_contents($donation_id);

        if(!empty($contents))
        {   
            $this->data['content_list']         = $contents;
            $this->data['title']                = _l("donation content", $this);
            $this->data['page']                 = "donationcontent";
            $this->data['donation_id']          = $donation_id;
            $this->data['content']              = $this->load->view('cms/donation/donation_content/index',$this->data,true);
            $this->load->view($this->mainTemplate, $this->data);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'No donation found']);
            redirect(base_url().'cms/donation/');
        }

    }

    function edit($donation_id='',$id='')
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "donation";
        $this->data['child_menu_type']      = "";
        $this->data['sub_child_menu_type']  = "";

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];

        $this->data['contents_id']          = $id;
        $this->data['donation_id']          = $donation_id;
        $this->data['languages']            = $this->Somaiya_general_admin_model->get_all_language();
        $this->data['donation_content_data']   = [];

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Donation_content', 'edit', $per_action, $this->data['institute_id']);

        if(!empty($donation_id))
        {
            $this->form_validation->set_rules('name', 'Name', 'required');      

            if($this->input->post())
            {
                $this->data['donation_content_data']      = $this->input->post();
            }
            else
            {
                $this->data['donation_content_data']      = $this->donation_content_model->get_details($donation_id, $id);                
            }

                if($this->form_validation->run($this) === TRUE)
                {
                    if($this->input->post())
                    {
                        $msg = $this->save($donation_id, $id, $this->input->post());
                        $this->session->set_flashdata('status', $msg);
                        redirect(base_url().'cms/donation_content/contents/'.$donation_id);
                    }
                }

                $this->data['title']                = _l("Module",$this);
                $this->data['page']                 = "Module";
                $this->data['content']              = $this->load->view('cms/donation/donation_content/form',$this->data,true);
                $this->load->view($this->mainTemplate,$this->data);
        }
        else
        {
            //echo "test two";exit();
            $this->session->set_flashdata('status', ['error' => 1, 'message' => 'Invalid request']);
            redirect(base_url().'cms/donation');
        } 
    }

    public function save($donation_id, $id='', $donation_content_data=[])
    {
        $msg         = array('error' => 1, 'message' => 'Access denied');

        if(!empty($donation_content_data))
        {
            if($donation_content_data['language_id'] == 1 && $donation_content_data['public'] < 1) // language_id=1 is default english lang
            {
                $msg = array('error' => 1, 'message' => 'Setting default english language content to in-active state is not allowed');
            }
            else
            {
                $save['donation_id']                = $donation_id;
                $save['language_id']                = $donation_content_data['language_id'];
                $save['name']                       = $donation_content_data['name'];
                $save['description']                = $donation_content_data['description'];
                $save['public']                     = $donation_content_data['public'];
                $msg                                = $this->donation_content_model->save($donation_id, $id, $save);
            }
        }
        return $msg;
    }

    public function check_content_by_lang()
    {
        if (!$this->input->is_ajax_request())
        {
            //echo "cant access url directly";  
            show_404(); // Output "Page not found" error.
            exit();
        }

        if(!empty($this->input->post()))
        {
            $donation_id = $this->input->post('donation_id');
            $donation_content_id = $this->input->post('donation_content_id');
            $language_id = $this->input->post('language_id');

            $count = $this->donation_content_model->check_content_by_lang($donation_id, $donation_content_id, $language_id);
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

    function delete($donation_id='', $id='')
    {
        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
            
        validate_permissions('Donation_content', 'delete', $this->config->item('method_for_delete'), $this->data['institute_id']);
             
        $donation_contents = $this->donation_content_model->get_details($donation_id, $id);

        if(!empty($donation_contents))
        {
            $response = $this->donation_content_model->_delete($donation_id, $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Plant not found.']);
        }
        redirect(base_url().'cms/donation_content/contents/'.$donation_id);

    }



    
}