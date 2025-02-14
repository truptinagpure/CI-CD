<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Notices_category extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/notices/Notices_category_model', 'notices_category');
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

     function index()
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "notices";
        $this->data['child_menu_type']      = "notices_category";
        $this->data['sub_child_menu_type']  = "notices_category";

        validate_permissions('Notices_category', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        

        $this->data['notices_category_list'] = $this->notices_category->get_notices_category_list(['nc.institute_id' => $this->session->userdata('sess_institute_id')]);
        // echo "<pre>";
        // print_r($this->data['notices_category_list']);
        // exit();
        $this->data['title']                = _l("Notices Category",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/notices/notices_category/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['title']                = 'Notices_category';
        $this->data['module']               = 'notices';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "notices";
        $this->data['child_menu_type']      = "notices_category";
        $this->data['sub_child_menu_type']  = "save_notices_category";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        $this->data['sess_institute_id']    = $this->session->userdata('sess_institute_id');
        $this->data['sess_institute_name']  = $this->session->userdata('sess_institute_name');                                   
             

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Notices_category', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        // print_r($this->input->post());
        // exit();
        $this->form_validation->set_rules('category_name', 'Category Name', 'required');
        
        if($this->form_validation->run($this) === TRUE)
        {
            /* print_r($this->data['post_data']);
            echo "<br>------------</br>";
            print_r($this->data['post_data']['institute_id']);
            echo "<br>------------</br>";
            exit(); */
            if($this->input->post())
            {   
                
                // $institute_id = '';
		
                // if(isset($this->data['post_data']['institute_id']) && !empty($this->data['post_data']['institute_id']) && is_array($this->data['post_data']['institute_id']))
                //     {
                //         $institute_id                   = implode(',', $this->data['post_data']['institute_id']);
                //     }
                   
                if($id)
                {
                    $update['institute_id']        = $this->session->userdata('sess_institute_id');
					$update['comes_under']         = $this->input->post('comes_under');
                    $update['name']                = $this->input->post('category_name');
                    $update['academic_year']       = $this->input->post('cat_academic_year');
                    $update['status']              = $this->input->post('status');
                    $update['modified_on']         = date('Y-m-d H:i:s');
                    $update['modified_by']         = $this->session->userdata('user_id');
                    // echo "<pre>";
                    // print_r($update);
                    // exit();
                    $response = $this->notices_category->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $industrial_visits_id               = $id;
                        $msg = ['error' => 0, 'message' => 'Notice Category successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['institute_id']     = $this->session->userdata('sess_institute_id');
					$insert['comes_under']      = $this->input->post('comes_under');
                    $insert['name']             = $this->input->post('category_name');
                    $insert['academic_year']    = $this->input->post('cat_academic_year');
                    $insert['status']           = $this->input->post('status');
                    $insert['created_on']       = date('Y-m-d H:i:s');
                    $insert['created_by']       = $this->session->userdata('user_id');

                    // echo "<pre>";
                    // print_r($insert);
                    // exit();
                    
                    $response              = $this->notices_category->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $notice_category_id = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Notice Category successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/notices_category/');
            }
        }

        if($id!='')
        {
            $notices_category     	    = $this->notices_category->get_notices_category_list(['nc.id' => $id]);
            $this->data['post_data']    = isset($notices_category[0]) ? $notices_category[0] : [];
						
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Notice Category not found']);
                redirect(base_url()."cms/notices_category/");
            }
        }

        $this->data['parents_notices_category']= $this->notices_category->get_notices_category_list(['nc.comes_under' => 0, 'nc.status' => 1, 'nc.institute_id' => $this->session->userdata('sess_institute_id')]);
        $this->data['all_institute']   = $this->notices_category->get_all_institute();
        $this->data['content']         = $this->load->view('cms/notices/notices_category/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {

        $this->data['insta_id']             = $this->default_institute_id;
        //$this->data['insta_id'] = $id;
        validate_permissions('Notices_category', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $response = $this->notices_category->_delete('id', $id);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
       
        redirect(base_url().'cms/notices_category/');
    }

    
}
