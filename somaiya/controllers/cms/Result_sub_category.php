<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Result_sub_category extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/result/Result_sub_category_modal', 'result_sub_category');
        $this->load->model('cms/result/Result_modal', 'result');
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

     function index()
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "result";
        $this->data['child_menu_type']      = "result_sub_category";
        $this->data['sub_child_menu_type']  = "result_sub_category";

        validate_permissions('Result_sub_category', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['result_sub_category_list'] = $this->result_sub_category->get_result_sub_category_list(['rsc.institute_id' => $this->session->userdata('sess_institute_id')]);
        $this->data['title']                = _l("Result Category",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/result/result_sub_category/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['insta_id']                 = $this->default_institute_id;
        $this->data['title']                    = 'Result Category';
        $this->data['module']                   = 'result_sub_category';
        $this->data['main_menu_type']           = "institute_menu";
        $this->data['sub_menu_type']            = "result";
        $this->data['child_menu_type']          = "result_sub_category";
        $this->data['sub_child_menu_type']      = "save_result_sub_category";
        $this->data['result_subcategory_data']     = [];
        $this->data['id']                       = $id;
        $this->data['sess_institute_id']        = $this->session->userdata('sess_institute_id');
        $this->data['sess_institute_name']      = $this->session->userdata('sess_institute_name');                                   
             

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Result_sub_category', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['result_subcategory_data'] = $this->input->post();
        }

        $this->form_validation->set_rules('sub_category_name', 'Subcategory Name', 'required');
        //$this->form_validation->set_rules('result_category_id[]', 'Category Name', 'required');
        $this->form_validation->set_rules('result_category_id', 'Category Name', 'required');
        
        
        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                
                // $category_id = '';

                // if(isset($this->data['result_subcategory_data']['result_category_id']) && !empty($this->data['result_subcategory_data']['result_category_id']) && is_array($this->data['result_subcategory_data']['result_category_id']))
                // {
                //     $category_id                   = implode(',', $this->data['result_subcategory_data']['result_category_id']);
                // }
                    
                if($id)
                {
                    $update['institute_id']                 = $this->session->userdata('sess_institute_id');
                    //$update['result_category_id']           = $category_id;
                    $update['result_category_id']           = $this->input->post('result_category_id');
                    $update['name']                         = $this->input->post('sub_category_name');
                    $update['order_by']                     = $this->input->post('order_by');
                    $update['status']                       = $this->input->post('status');
                    $update['modified_on']                  = date('Y-m-d H:i:s');
                    $update['modified_by']                  = $this->session->userdata('user_id');

                    $response = $this->result_sub_category->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $industrial_visits_id               = $id;
                        $msg = ['error' => 0, 'message' => 'Sub Category successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['institute_id']                 = $this->session->userdata('sess_institute_id');
                    //$insert['result_category_id']           = $category_id;
                    $insert['result_category_id']           = $this->input->post('result_category_id');
                    $insert['name']                         = $this->input->post('sub_category_name');
                    $insert['order_by']                     = $this->input->post('order_by');
                    $insert['status']                       = $this->input->post('status');
                    $insert['created_on']                   = date('Y-m-d H:i:s');
                    $insert['created_by']                   = $this->session->userdata('user_id');
                    $insert['modified_on']                  = date('Y-m-d H:i:s');
                    $insert['modified_by']                  = $this->session->userdata('user_id');

                    $response                               = $this->result_sub_category->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $industrial_visits_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Sub Category successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/result_sub_category/');
            }
        }

        if($id!='')
        {
            $result_sub_category     = $this->result_sub_category->get_result_sub_category_list(['rsc.id' => $id]);
            $this->data['result_subcategory_data']  = isset($result_sub_category[0]) ? $result_sub_category[0] : [];
                        
            if(empty($this->data['result_subcategory_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Result Category not found']);
                redirect(base_url()."cms/result_sub_category/");
            }
        }

        $this->data['category_list'] = $this->result_sub_category->get_result_category_by_institute_id($this->session->userdata('sess_institute_id'));
        $this->data['all_institute'] = $this->result_sub_category->get_all_institute();
        
        $this->data['content']         = $this->load->view('cms/result/result_sub_category/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    
    function delete($id='')
    {

        $this->data['insta_id']             = $this->default_institute_id;
        validate_permissions('result_sub_category', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $response = $this->result_sub_category->_delete('id', $id);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
       
        redirect(base_url().'cms/result_sub_category/');
    }

    
}
