<?php
/**
 * Created by Somaiya Team.
 * User: Somaiya
 * Date: 9/16/2016
 * Time: 1:03 AM
 * Project: Somaiya Vidyavihar
 * Website: http://www.Somaiya.com
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Sidebar_module extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/sidebar_module/Sidebar_module_model', 'sidebar_module_model');
        $user_id = $this->session->userdata['user_id'];
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $default_institute_id = $this->config->item('default_institute_id');
      //  validate_permissions('', '', '', 'notallowed');

    }

    function index()
    {
        $this->data['main_menu_type'] = "user_management";
        $this->data['sub_menu_type'] = "sidebar_modules";
        $this->data['child_menu_type'] = "sidebar_modules";
        $this->data['sub_child_menu_type'] = "";
        //session data
        $instituteID  = $this->session->userdata('sess_institute_id');
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
        $inst_id = $instituteID ? $instituteID : $default_institute_id;
        $status=-1;
        validate_permissions('Menu', 'index', $this->config->item('method_for_view'), $inst_id);
        $this->data['data_list']=$this->sidebar_module_model->view_sidebarmodule($status);
        $this->data['title'] = _l("Module",$this);
        $this->data['page'] = "Module";
        $this->data['content']=$this->load->view('cms/sidebar_module'.'/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);

     }

    function edit($id='')
    {
        $this->data['main_menu_type'] = "user_management";
        $this->data['sub_menu_type'] = "sidebar_modules";
        $this->data['child_menu_type'] = "sidebar_modules";
        $this->data['sub_child_menu_type'] = "";

        $instituteID= $this->session->userdata('sess_institute_id');
        $inst_id                    = isset($instituteID) ? $instituteID : $default_institute_id;
        $per_action                 = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Sidebar_module', 'edit', $per_action, $inst_id);
        $status=-1;
        $titles = array();
        $this->data['title'] = _l("Sidebar_module",$this);
        $this->data['page']                 = 'Sidebar_module';
        $this->data['data']                 = [];
        $this->data['module_id']       = $id;
        $this->data['data']['status']       = 1;
        $this->data['module'] = $this->sidebar_module_model->view_sidebarmodule($status); 
        if($id)
        {
            $status=-1;
             $this->data['data']    = $this->sidebar_module_model->get_menu_details($id,$status);
            if(empty($this->data['data']))
            {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => $id]);
            redirect(base_url().'cms/sidebar_module/index/');
            }
           /*  $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => $id]);
            redirect(base_url().'cms/menu/menu/');*/
        }  
      if($this->input->post())
        {
            $this->data['data']     = $this->input->post();
            //echo "<pre>"; print_r($this->data['data']);exit();

        }

            if($this->input->post())
                {   
                   if($id)
                    {
                   
                        $update['sidebar_module']['url_id']                 = $this->input->post('url_id');
                        $update['sidebar_module']['main_module']            = $this->input->post('main_module');
                        $update['sidebar_module']['module_name']            = $this->input->post('data[module_name]');
                        $update['sidebar_module']['parent_id']              = $this->input->post('data[parent_id]');
                        $update['sidebar_module']['url']                    = $this->input->post('data[url]');
                        $update['sidebar_module']['sort_order']             = $this->input->post('data[sort_order]');
                        $update['sidebar_module']['classname']              = $this->input->post('data[classname]');
                        $update['sidebar_module']['icon']                   = $this->input->post('data[icon]');
                        $update['sidebar_module']['cums_under_menu']        = $this->input->post('data[cums_under_menu]');
                        $update['sidebar_module']['status']                 = $this->input->post('status');
                        $update['sidebar_module']['modified_on']            = date('Y-m-d H:i:s');
                        $update['sidebar_module']['modified_by']            = $this->session->userdata['user_id'];
                        // echo "<pre>"; print_r($update);exit();
                        $condition                                 = array('module_id' => $id);
                        $response = $this->sidebar_module_model->_update($condition, $update);

                           if(1)
                                 {
                                     //$post_id           = $response['col'];
                                   $msg = ['error' => 0, 'message' => "Module successfully updated"];
                                 }
                            else
                                {
                                    $msg = ['error' => 0, 'message' => $response['message']];
                                }
                    }
                    else
                    {
                       
                        $insert['sidebar_module']['url_id']                 = $this->input->post('url_id');
                        $insert['sidebar_module']['main_module']            = $this->input->post('main_module');
                        $insert['sidebar_module']['module_name']            = $this->input->post('data[module_name]');
                        $insert['sidebar_module']['parent_id']              = $this->input->post('data[parent_id]');
                        $insert['sidebar_module']['url']                    = $this->input->post('data[url]');
                        $insert['sidebar_module']['sort_order']             = $this->input->post('data[sort_order]');
                        $insert['sidebar_module']['classname']              = $this->input->post('data[classname]');
                        $insert['sidebar_module']['icon']                   = $this->input->post('data[icon]');
                        $insert['sidebar_module']['cums_under_menu']        = $this->input->post('data[cums_under_menu]');
                        $insert['sidebar_module']['status']                 = $this->input->post('status');
                        $insert['sidebar_module']['created_on']             = date('Y-m-d H:i:s');
                        $insert['sidebar_module']['created_by']             = $this->session->userdata['user_id'];
                        $insert['sidebar_module']['modified_on']            = date('Y-m-d H:i:s');
                        $insert['sidebar_module']['modified_by']            = $this->session->userdata['user_id'];
                   
                    $response  = $this->sidebar_module_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                         {
                            $post_id           = $response['id'];
                            $msg = ['error' => 0, 'message' => 'Module successfully added'];
                         }
                    else
                         {
                            $msg = ['error' => 0, 'message' => $response['message']];
                         }
                    }
                 $this->session->set_flashdata('requeststatus', $msg);
                 redirect(base_url().'cms/sidebar_module/index');
            }//end post
    
            $this->data['content'] = $this->load->view('cms/sidebar_module/form',$this->data,true);
            $this->load->view($this->mainTemplate,$this->data); 
          
    }

    function delete($id=0)
    {   
        // validate_permissions('Usermanagement_module', 'delete_module', $this->config->item('method_for_delete'));


        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
         validate_permissions('Sidebar_module', 'delete', $this->config->item('method_for_delete'), $this->data['institute_id']);
        $status    =-1;
        $condition = array('module_id' => $id );
        $post      = $this->sidebar_module_model->get_menu_details($id, $status);

        if(!empty($post))
        {
        $response = $this->sidebar_module_model->_delete($condition);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Sidebar Module  not found.']);
        }
            redirect(base_url().'cms/sidebar_module/index/');
    

    }

}
