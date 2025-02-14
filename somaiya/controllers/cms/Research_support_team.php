<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Research_support_team extends Somaiya_Controller
{
    private $default_institute_id;

    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/research_support_team/Research_support_team_model', 'research_support_team_model');
        $user_id = $this->session->userdata['user_id'];
        $default_institute_id = $this->config->item('default_institute_id');

    }

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "research_support_team";
        $this->data['child_menu_type']      = "research_support_team";
        $this->data['sub_child_menu_type']  = "research_support_team";

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];

        validate_permissions('Research_support_team', 'index', $this->config->item('method_for_view'), $this->data['institute_id']);
        
        $this->data['data_list']            = $this->research_support_team_model->get_researchers_list();
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/research_support_team/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['main_menu_type']           = "institute_menu";
        $this->data['sub_menu_type']            = "research_support_team";
        $this->data['child_menu_type']          = "save_research_support_team";
        $this->data['sub_child_menu_type']      = "";
        $this->data['research_support_team_data']  = [];
        $this->data['id']                       = $id;

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
        // echo "<pre>";
        // print_r($this->data);exit();

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Research_support_team', 'edit', $per_action, $this->data['institute_id']);

        if($this->input->post())
        {
            $this->data['research_support_team_data'] = $this->input->post();
        }

        // echo "<pre>";
        // print_r($this->data['research_support_team_data']);
        // exit();
        $this->form_validation->set_rules('researcher_member_id', 'Member Id', 'required|max_length[250]');
        //$this->form_validation->set_rules('researchers_introduction', 'Researchers Introduction', 'required'); 
        
        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                                                
                if($id)
                {
                    $update['researcher_member_id'] = $this->input->post('researcher_member_id');
                    $update['role']                 = $this->input->post('researcher_role');
                    $update['order_by']             = $this->input->post('order_by');
                    $update['public']               = $this->input->post('public');
                    $update['modified_on']          = date('Y-m-d H:i:s');
                    $update['modified_by']          = $this->session->userdata['user_id'];
                    
                    $response = $this->research_support_team_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $researchers_id                       = $id;
                        $msg = ['error' => 0, 'message' => 'Researchers successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['researcher_member_id'] = $this->input->post('researcher_member_id');
                    $insert['role']                 = $this->input->post('researcher_role');
                    $insert['order_by']             = $this->input->post('order_by');
                    $insert['public']               = $this->input->post('public');
                    $insert['created_on']           = date('Y-m-d H:i:s');
                    $insert['created_by']           = $this->session->userdata['user_id'];

                    $response                          = $this->research_support_team_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $post_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Researchers successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/research_support_team/');
            }
        }

        if($id!='')
        {
            $research_support_team = $this->research_support_team_model->get_researchers_list(['rst.id' => $id]);
            $this->data['research_support_team_data']     = isset($research_support_team[0]) ? $research_support_team[0] : [];
            
            if(empty($this->data['research_support_team_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Researchers not found']);
                redirect(base_url()."cms/research_support_team/");
            }
        }

        $this->data['content']              = $this->load->view('cms/research_support_team/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
            
        validate_permissions('Research_support_team', 'delete', $this->config->item('method_for_delete'), $this->data['institute_id']);
             
        $research_support_team = $this->research_support_team_model->get_researchers_list(['rst.id' => $id]);

        if(!empty($research_support_team))
        {
            $response = $this->research_support_team_model->_delete('id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Plant not found.']);
        }
        redirect(base_url().'cms/research_support_team/');
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

            $member_data = $this->research_support_team_model->check_member_id($member_id);
            if(count($member_data) == 0)
            {
                $response['status']='failure';
                $response['message']='You entered member id does not exist.';
                $response['data']='';
            }
            else
            {
                $researchers_data = $this->research_support_team_model->check_researchers_id($member_id, $researcher_id);

                if(count($researchers_data) == 0)
                {
                    $response['status']='success';
                    $response['message']='';
                    $response['data']=$member_data;
                }
                else
                {
                    $response['status']='failure';
                    $response['message']='You entered member id is already exist.';
                    $response['data']=$member_data;
                }
            }

            echo json_encode($response);
            exit();
        }
        
    }
}