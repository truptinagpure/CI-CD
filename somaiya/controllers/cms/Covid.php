<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Covid extends Somaiya_Controller
{
    private $default_institute_id;

    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/covid/Covid_model', 'covid_model');
        $user_id = $this->session->userdata['user_id'];
        $default_institute_id = $this->config->item('default_institute_id');

    }

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "covid";
        $this->data['child_menu_type']      = "covid";
        $this->data['sub_child_menu_type']  = "covid";

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];

        validate_permissions('Covid', 'index', $this->config->item('method_for_view'), $this->data['institute_id']);
        
        $this->data['covid_list']           = $this->covid_model->get_covid_list(['c.institute_id' => $this->session->userdata['sess_institute_id']]);
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/covid/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['main_menu_type']           = "institute_menu";
        $this->data['sub_menu_type']            = "covid";
        $this->data['child_menu_type']          = "save_covid";
        $this->data['sub_child_menu_type']      = "save_covid";
        $this->data['covid_data']  = [];
        $this->data['id']                       = $id;

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
        // echo "<pre>";
        // print_r($this->data);exit();

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Covid', 'edit', $per_action, $this->data['institute_id']);

        if($this->input->post())
        {
            $this->data['covid_data'] = $this->input->post();
        }

        // echo "<pre>";
        // print_r($this->data['covid_data']);
        // exit();
        $this->form_validation->set_rules('covid_title', 'Title', 'required|max_length[150]');
        $this->form_validation->set_rules('date', 'Date', 'required'); 
        
        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                                                
                if($id)
                {
                    $update['institute_id']     = $this->session->userdata['sess_institute_id'];
                    $update['title']            = $this->input->post('covid_title');
                    $update['description']      = $this->input->post('description');
                    $update['date']             = $this->input->post('date');
                    $update['public']           = $this->input->post('public');
                    $update['modified_on']      = date('Y-m-d H:i:s');
                    $update['modified_by']      = $this->session->userdata['user_id'];
                    
                    $response = $this->covid_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $researchers_id                       = $id;
                        $msg = ['error' => 0, 'message' => 'Data successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['institute_id']     = $this->session->userdata['sess_institute_id'];
                    $insert['title']            = $this->input->post('covid_title');
                    $insert['description']      = $this->input->post('description');
                    $insert['date']             = $this->input->post('date');
                    $insert['public']           = $this->input->post('public');
                    $insert['created_on']       = date('Y-m-d H:i:s');
                    $insert['created_by']       = $this->session->userdata['user_id'];

                    $response                   = $this->covid_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $post_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Data successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/covid/');
            }
        }

        if($id!='')
        {
            $covid = $this->covid_model->get_covid_list(['c.id' => $id]);
            $this->data['covid_data']     = isset($covid[0]) ? $covid[0] : [];
            
            if(empty($this->data['covid_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Data not found']);
                redirect(base_url()."cms/covid/");
            }
        }

        $this->data['content']              = $this->load->view('cms/covid/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
            
        validate_permissions('Covid', 'delete', $this->config->item('method_for_delete'), $this->data['institute_id']);
             
        $covid = $this->covid_model->get_covid_list(['c.id' => $id]);

        if(!empty($covid))
        {
            $response = $this->covid_model->_delete('id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Data not found.']);
        }
        redirect(base_url().'cms/covid/');
    }

    public function check_member_id()
    {
        if (!$this->input->is_ajax_request())
        {
            //echo "cant access url directly";  
            show_404(); // Output "Page not found" error.
            exit();
        }

        if(!empty($this->input->post()))
        {
            $response = array();
            $member_id = $this->input->post('member_id');
            $researcher_id = $this->input->post('researcher_id');

            $member_data = $this->covid_model->check_member_id($member_id);
            // echo "count : ".count($member_data);
            // exit();
            if(count($member_data) == 0)
            {
               //$result = "false";
                $response['status']='failure';
                $response['message']='You entered member id does not exist.';
                $response['data']='';
            }
            else
            {
                //$result = "true";
                $researchers_data = $this->covid_model->check_researchers_id($member_id, $researcher_id);

                if(count($researchers_data) == 0)
                {
                    //$result = "true";
                    $response['status']='success';
                    $response['message']='';
                    $response['data']=$member_data;
                }
                else
                {
                    //$result = "already_exist";
                    $response['status']='failure';
                    $response['message']='You entered member id is already exist.';
                    $response['data']=$member_data;
                }
            }

            //echo $result;
            echo json_encode($response);
            exit();
        }
        
    }
}