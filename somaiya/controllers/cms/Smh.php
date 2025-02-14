<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Smh extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/smh/Smh_model', 'smh');
        //$this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

     function index()
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "smh";
        $this->data['child_menu_type']      = "smh";
        $this->data['sub_child_menu_type']  = "smh";

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
        
        validate_permissions('smh', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['smh_list'] = $this->smh->get_smh_list(['s.institute_id' => $this->session->userdata('sess_institute_id')]);
        $this->data['title']                = _l("Smh",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/smh/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['title']                = 'Smh';
        $this->data['module']               = 'smh';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "smh";
        $this->data['child_menu_type']      = "smh";
        $this->data['sub_child_menu_type']  = "save_smh";
        $this->data['smh_data']     = [];
        $this->data['id']                   = $id;
        $this->data['sess_institute_id']    = $this->session->userdata('sess_institute_id');
        $this->data['sess_institute_name']  = $this->session->userdata('sess_institute_name');                                   
             

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('smh', 'edit', $per_action, $this->data['insta_id']);

        $this->data['smh_type_list_by_institute'] = $this->smh->smh_type_list_by_institute();
        $this->data['smh_social_list'] = $this->smh->smh_social_list();
        $this->data['smh_belongs_to_list_by_type'] = array();
        if($this->input->post())
        {
            $this->data['smh_data'] = $this->input->post();
        }

        $this->form_validation->set_rules('admin_member', 'Admin Member', 'required');
        $this->form_validation->set_rules('admin_member_type', 'Admin Member Type', 'required'); 
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'required');
        $this->form_validation->set_rules('email_id', 'Email Id', 'required');
        $this->form_validation->set_rules('smh_dir_id', 'Social Media', 'required');
        $this->form_validation->set_rules('smh_belongs_to_type_id', 'Category', 'required');
        $this->form_validation->set_rules('smh_belongs_to_id', 'Subcategory', 'required');
        $this->form_validation->set_rules('social_url', 'Social Url', 'required');
        
        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {                       
                if($id)
                {
                    $update['institute_id'] = $this->session->userdata('sess_institute_id');
                    $update['admin_member'] = $this->input->post('admin_member');
                    $update['admin_member_type']  = $this->input->post('admin_member_type');
                    $update['contact_number']       = $this->input->post('contact_number');
                    $update['email_id']       = $this->input->post('email_id');
                    $update['smh_dir_id']       = $this->input->post('smh_dir_id');
                    $update['smh_belongs_to_type_id']       = $this->input->post('smh_belongs_to_type_id');
                    $update['smh_belongs_to_id']       = $this->input->post('smh_belongs_to_id');
                    $update['social_url']       = $this->input->post('social_url');
                    $update['purpose']       = $this->input->post('purpose');

                    $update['public']       = $this->input->post('public');
                    $update['modified_on']  = date('Y-m-d H:i:s');
                    $update['modified_by']  = $this->session->userdata('user_id');

                    $response = $this->smh->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $smh_subcategory_id               = $id;
                        $msg = ['error' => 0, 'message' => 'Social Media Handle successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['institute_id'] = $this->session->userdata('sess_institute_id');
                    $insert['admin_member'] = $this->input->post('admin_member');
                    $insert['admin_member_type']  = $this->input->post('admin_member_type');
                    $insert['contact_number']       = $this->input->post('contact_number');
                    $insert['email_id']       = $this->input->post('email_id');
                    $insert['smh_dir_id']       = $this->input->post('smh_dir_id');
                    $insert['smh_belongs_to_type_id']       = $this->input->post('smh_belongs_to_type_id');
                    $insert['smh_belongs_to_id']       = $this->input->post('smh_belongs_to_id');
                    $insert['social_url']       = $this->input->post('social_url');
                    $insert['purpose']       = $this->input->post('purpose');
                    $insert['public']        = $this->input->post('public');
                    $insert['created_on']    = date('Y-m-d H:i:s');
                    $insert['created_by']    = $this->session->userdata('user_id');
                    
                    $response                = $this->smh->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $smh_id      = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Social Media Handle successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/smh/');
            }
        }

        if($id!='')
        {
            $smh_subcategory     = $this->smh->get_smh_list(['s.id' => $id]);
            $this->data['smh_data']  = isset($smh_subcategory[0]) ? $smh_subcategory[0] : [];
            
            //$this->data['smh_belongs_to_list_by_type'] = $this->smh->get_smh_subcategory_by_cat_id(array($this->data['smh_data']['smh_belongs_to_type_id']));

            //following code used for single category selection
            $smh_category = $this->data['smh_data']['smh_belongs_to_type_id'];
            if($smh_category == 1) // 1 for institute, its get data from master tables
            {
               $this->data['smh_belongs_to_list_by_type'] = array(array('institute_id' => $this->session->userdata('sess_institute_id'), 'institute_name' => $this->session->userdata('sess_institute_name'))); 
            }
            elseif ($smh_category == 2) // 2 for department, its get data from master tables
            {
                $this->data['smh_belongs_to_list_by_type'] = $this->smh->get_smh_subcategory_by_cat_department();
            }
            else
            {
                $this->data['smh_belongs_to_list_by_type'] = $this->smh->get_smh_subcategory_by_cat_id($smh_category);
            }

            if(empty($this->data['smh_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Social media handle not found']);
                redirect(base_url()."cms/smh/");
            }
        }

        
        $this->data['content']         = $this->load->view('cms/smh/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    
    function delete($id='')
    {

        $this->data['insta_id']             = $this->default_institute_id;
        validate_permissions('smh', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
    
        $response = $this->smh->_delete('id', $id);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
       
        redirect(base_url().'cms/smh/');
    }

    function get_smh_subcategory_by_cat_id()
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
            $category_id = $this->input->post('category_id');
            $option = '';

            if($category_id == 1) // 1 for institute, its get data from master tables
            {
                //$smh_subcategory = $this->smh->get_smh_subcategory_by_cat_institute();
                $option .=   "<option value=''>Please select institute</option>";
                $option .=  "<option value='".$this->session->userdata('sess_institute_id')."'>".$this->session->userdata('sess_institute_name')."</option>";
            }
            elseif ($category_id == 2) // 2 for department, its get data from master tables
            {
                $smh_subcategory = $this->smh->get_smh_subcategory_by_cat_department();
                $option .=   "<option value=''>Please select department</option>";      
                foreach ($smh_subcategory as $key => $value) {
                    $option .= "<option value='".$value['Department_Id']."'>".$value['Department_Name']."</option>";
                }
            }
            else
            {
                $smh_subcategory = $this->smh->get_smh_subcategory_by_cat_id($category_id);
                $option .=   "<option value=''>Please select subcategory</option>";
                foreach ($smh_subcategory as $key => $value) {
                    $option .= "<option value='".$value['smh_belongs_to_id']."'>".$value['smh_belongs_to_name']."</option>";
                }
            }
            
            echo $option;
            //echo json_encode($smh_subcategory);
            exit();
        }
        
    }

    function check_cat_subcat_socialplatform_rel()
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

            $smh_category       = $this->input->post('smh_category');
            $smh_subcategory    = $this->input->post('smh_subcategory');
            $smh_platform       = $this->input->post('smh_platform');
            $smh_id             = $this->input->post('smh_id');

            $smh_data = $this->smh->check_cat_subcat_socialplatform_rel($smh_id, $smh_category, $smh_subcategory, $smh_platform);
            
            if(count($smh_data) == 0)
            {
                $response['status']='success';
                $response['message']='';
                $response['data']=$smh_data;
            }
            else
            {
                $response['status']='failure';
                $response['message']='You entered category, subcategory and social media entry is already exist.';
                $response['data']=$smh_data;
            }
            
            echo json_encode($response);
            exit();
        }
    }
    
}
