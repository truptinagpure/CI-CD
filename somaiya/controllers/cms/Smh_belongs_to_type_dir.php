<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Smh_belongs_to_type_dir extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/smh_belongs_to_type_dir/Smh_belongs_to_type_dir_model', 'smh_category');
        //$this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

     function index()
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "smh";
        $this->data['child_menu_type']      = "smh_belongs_to_type_dir";
        $this->data['sub_child_menu_type']  = "smh_belongs_to_type_dir";

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
        
        validate_permissions('smh_belongs_to_type_dir', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        //$this->data['smh_category_list'] = $this->smh_category->get_smh_belongs_to_type_dir_list(['smh_type.institute_id' => $this->session->userdata('sess_institute_id')]);
        $this->data['smh_category_list'] = $this->smh_category->get_smh_belongs_to_type_dir_list();
        // print_r($this->data['documents_department_list']);
        // exit();
        $this->data['title']                = _l("Smh belongs to type",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/smh_belongs_to_type_dir/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['title']                = 'Smh belongs to type';
        $this->data['module']               = 'smh_belongs_to_type_dir';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "smh";
        $this->data['child_menu_type']      = "smh_belongs_to_type_dir";
        $this->data['sub_child_menu_type']  = "save_smh_belongs_to_type_dir";
        $this->data['smh_category_data']     = [];
        $this->data['id']                   = $id;
        $this->data['sess_institute_id']    = $this->session->userdata('sess_institute_id');
        $this->data['sess_institute_name']  = $this->session->userdata('sess_institute_name');                                   
             

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('smh_belongs_to_type_dir', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['smh_category_data'] = $this->input->post();
        }

        $this->form_validation->set_rules('smh_belongs_to_type_name', 'Category Name', 'required'); 
        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {                       
                if($id)
                {
                	$update['smh_belongs_to_type_name'] = $this->input->post('smh_belongs_to_type_name');
                    //$update['institute_id'] = $this->session->userdata('sess_institute_id');
                    $update['public']       = $this->input->post('public');
                    $update['modified_on']  = date('Y-m-d H:i:s');
                    $update['modified_by']  = $this->session->userdata('user_id');

                    $response = $this->smh_category->_update('smh_belongs_to_type_id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $smh_category_id               = $id;
                        $msg = ['error' => 0, 'message' => 'Category successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['smh_belongs_to_type_name']          = $this->input->post('smh_belongs_to_type_name');
                    //$insert['institute_id']  = $this->session->userdata('sess_institute_id');
                    $insert['public']        = $this->input->post('public');
                    $insert['created_on']    = date('Y-m-d H:i:s');
                    $insert['created_by']    = $this->session->userdata('user_id');
                    
                    $response                = $this->smh_category->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $smh_category_id      = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Category successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/smh_belongs_to_type_dir/');
            }
        }

        if($id!='')
        {
            $smh_category     = $this->smh_category->get_smh_belongs_to_type_dir_list(['smh_type.smh_belongs_to_type_id' => $id]);
            $this->data['smh_category_data']  = isset($smh_category[0]) ? $smh_category[0] : [];
                        
            if(empty($this->data['smh_category_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Category not found']);
                redirect(base_url()."cms/smh_belongs_to_type_dir/");
            }
        }

        
        $this->data['content']         = $this->load->view('cms/smh_belongs_to_type_dir/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    
    function delete($id='')
    {

        $this->data['insta_id']             = $this->default_institute_id;
        validate_permissions('smh_belongs_to_type_dir', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
    
        $response = $this->smh_category->_delete('smh_belongs_to_type_id', $id);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
       
        redirect(base_url().'cms/smh_belongs_to_type_dir/');
    }

    function check_category_name()
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
            $smh_belongs_to_type_name = $this->input->post('smh_belongs_to_type_name');
            $smh_belongs_to_type_id = $this->input->post('smh_belongs_to_type_id');

            $smh_belong_type_data = $this->smh_category->check_category_name($smh_belongs_to_type_name, $smh_belongs_to_type_id);
            
            if(count($smh_belong_type_data) == 0)
            {
                $response['status']='success';
                $response['message']='';
                $response['data']=$smh_belong_type_data;
            }
            else
            {
                $response['status']='failure';
                $response['message']='You entered name is already exist.';
                $response['data']=$smh_belong_type_data;
            }
            
            echo json_encode($response);
            exit();
        }
    }
}
