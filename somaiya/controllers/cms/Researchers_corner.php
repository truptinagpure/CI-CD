<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Researchers_corner extends Somaiya_Controller
{
    private $default_institute_id;

    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/researchers_corner/Researchers_corner_model', 'researchers_corner_model');
        $user_id = $this->session->userdata['user_id'];
        $default_institute_id = $this->config->item('default_institute_id');

    }

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "researchers_corner";
        $this->data['child_menu_type']      = "researchers_corner";
        $this->data['sub_child_menu_type']  = "researchers_corner";

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];

        validate_permissions('Researchers_corner', 'index', $this->config->item('method_for_view'), $this->data['institute_id']);
        
        $this->data['data_list']            = $this->researchers_corner_model->get_researchers_list();
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/researchers_corner/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['main_menu_type']           = "institute_menu";
        $this->data['sub_menu_type']            = "researchers_corner";
        $this->data['child_menu_type']          = "save_researchers_corner";
        $this->data['sub_child_menu_type']      = "";
        $this->data['researchers_corner_data']  = [];
        $this->data['id']                       = $id;

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
        // echo "<pre>";
        // print_r($this->data);exit();

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Researchers_corner', 'edit', $per_action, $this->data['institute_id']);

        if($this->input->post())
        {
            $this->data['researchers_corner_data'] = $this->input->post();
        }

        // echo "<pre>";
        // print_r($this->data['researchers_corner_data']);
        // exit();
        $this->form_validation->set_rules('researcher_member_id', 'Member Id', 'required|max_length[250]');
        //$this->form_validation->set_rules('researchers_introduction', 'Researchers Introduction', 'required'); 
        
        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                                                
                if($id)
                {
                    $update['researcher_member_id']    = $this->input->post('researcher_member_id');
                    $update['researcher_introduction'] = $this->input->post('researcher_introduction');
                    $update['researcher_valid_date']   = $this->input->post('researcher_valid_date');
                    $update['public']                  = $this->input->post('public');
                    $update['modified_on']             = date('Y-m-d H:i:s');
                    $update['modified_by']             = $this->session->userdata['user_id'];
                    
                    $response = $this->researchers_corner_model->_update('id', $id, $update);
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
                    $insert['researcher_member_id']    = $this->input->post('researcher_member_id');
                    $insert['researcher_introduction'] = $this->input->post('researcher_introduction');
                    $insert['researcher_valid_date']   = $this->input->post('researcher_valid_date');
                    $insert['public']                  = $this->input->post('public');
                    $insert['created_on']              = date('Y-m-d H:i:s');
                    $insert['created_by']              = $this->session->userdata['user_id'];

                    $response                          = $this->researchers_corner_model->_insert($insert);

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
                redirect(base_url().'cms/researchers_corner/');
            }
        }

        if($id!='')
        {
            $researchers_corner = $this->researchers_corner_model->get_researchers_list(['rc.id' => $id]);
            $this->data['researchers_corner_data']     = isset($researchers_corner[0]) ? $researchers_corner[0] : [];
            
            if(empty($this->data['researchers_corner_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Researchers not found']);
                redirect(base_url()."cms/researchers_corner/");
            }
        }

        $this->data['content']              = $this->load->view('cms/researchers_corner/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
            
        validate_permissions('Researchers_corner', 'delete', $this->config->item('method_for_delete'), $this->data['institute_id']);
             
        $researchers_corner = $this->researchers_corner_model->get_researchers_list(['rc.id' => $id]);

        if(!empty($researchers_corner))
        {
            $response = $this->researchers_corner_model->_delete('id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Plant not found.']);
        }
        redirect(base_url().'cms/researchers_corner/');
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

            $member_data = $this->researchers_corner_model->check_member_id($member_id);
            if(count($member_data) == 0)
            {
                $response['status']='failure';
                $response['message']='You entered member id does not exist.';
                $response['data']='';
            }
            else
            {
                $researchers_data = $this->researchers_corner_model->check_researchers_id($member_id, $researcher_id);

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