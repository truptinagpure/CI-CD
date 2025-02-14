<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Smh_dir extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/smh_dir/Smh_dir_model', 'smh_dir');
        //$this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

     function index()
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['main_menu_type']       = "masters";
        $this->data['sub_menu_type']        = "smh_dir";
        $this->data['child_menu_type']      = "smh_dir";
        $this->data['sub_child_menu_type']  = "smh_dir";

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
        
        validate_permissions('smh_dir', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['smh_list'] = $this->smh_dir->get_smh_dir_list();
        $this->data['title']                = _l("Smh Dir",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/smh_dir/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['title']                = 'Smh Dir';
        $this->data['module']               = 'smh_dir';
        $this->data['main_menu_type']       = "masters";
        $this->data['sub_menu_type']        = "smh_dir";
        $this->data['child_menu_type']      = "save_smh_dir";
        $this->data['sub_child_menu_type']  = "";
        $this->data['smh_dir_data']         = [];
        $this->data['id']                   = $id;
        $this->data['sess_institute_id']    = $this->session->userdata('sess_institute_id');
        $this->data['sess_institute_name']  = $this->session->userdata('sess_institute_name');                                   
             

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('smh_dir', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['smh_dir_data'] = $this->input->post();
        }

        $this->form_validation->set_rules('smh_dir_name', 'Name', 'required'); 
        $this->form_validation->set_rules('social_icon', 'Social Icon', 'required'); 

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {                       
                if($id)
                {
                	$update['smh_dir_name'] = $this->input->post('smh_dir_name');
                    $update['social_icon']  = $this->input->post('social_icon');
                    $update['public']       = $this->input->post('public');
                    $update['modified_on']  = date('Y-m-d H:i:s');
                    $update['modified_by']  = $this->session->userdata('user_id');

                    $response = $this->smh_dir->_update('smh_dir_id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $smh_category_id               = $id;
                        $msg = ['error' => 0, 'message' => 'Social media successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['smh_dir_name']  = $this->input->post('smh_dir_name');
                    $insert['social_icon']   = $this->input->post('social_icon');
                    $insert['public']        = $this->input->post('public');
                    $insert['created_on']    = date('Y-m-d H:i:s');
                    $insert['created_by']    = $this->session->userdata('user_id');
                    
                    $response                = $this->smh_dir->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $smh_id      = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Social Media successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/smh_dir/');
            }
        }

        if($id!='')
        {
            $smh_category     = $this->smh_dir->get_smh_dir_list(['smh_dir_id' => $id]);
            $this->data['smh_dir_data']  = isset($smh_category[0]) ? $smh_category[0] : [];
                        
            if(empty($this->data['smh_dir_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Social Media not found']);
                redirect(base_url()."cms/smh_dir/");
            }
        }

        
        $this->data['content']         = $this->load->view('cms/smh_dir/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    
    function delete($id='')
    {

        $this->data['insta_id']             = $this->default_institute_id;
        validate_permissions('smh_dir', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
    
        $response = $this->smh_dir->_delete('smh_dir_id', $id);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
       
        redirect(base_url().'cms/smh_dir/');
    }

    function check_social_name()
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
            $smh_dir_name = $this->input->post('smh_dir_name');
            $smh_dir_id = $this->input->post('smh_dir_id');

            $social_data = $this->smh_dir->check_social_name($smh_dir_name, $smh_dir_id);
            
            if(count($social_data) == 0)
            {
                $response['status']='success';
                $response['message']='';
                $response['data']=$social_data;
            }
            else
            {
                $response['status']='failure';
                $response['message']='You entered name is already exist.';
                $response['data']=$social_data;
            }
            
            echo json_encode($response);
            exit();
        }
        
    }
    
}
