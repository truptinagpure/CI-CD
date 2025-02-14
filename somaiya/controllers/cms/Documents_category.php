<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Documents_category extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/documents/documents_category_modal', 'documents_category');
        $this->load->model('cms/documents/Documents_modal', 'documents');
        //$this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

     function index()
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "documents";
        $this->data['child_menu_type']      = "documents_category";
        $this->data['sub_child_menu_type']  = "documents_category";

        validate_permissions('documents_category', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        

        $this->data['documents_category_list'] = $this->documents_category->get_documents_category_list(['dc.institute_id' => $this->session->userdata('sess_institute_id')]);
        // echo "<pre>";
        // print_r($this->data['documents_category_list']);
        // exit();
        $this->data['title']                = _l("Documents Department",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/documents/documents_category/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['title']                = 'Documents Department';
        $this->data['module']               = 'documents_category';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "documents";
        $this->data['child_menu_type']      = "documents_category";
        $this->data['sub_child_menu_type']  = "save_documents_category";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        $this->data['sess_institute_id']    = $this->session->userdata('sess_institute_id');
        $this->data['sess_institute_name']  = $this->session->userdata('sess_institute_name');                                   
             

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('documents_category', 'edit', $per_action, $this->data['insta_id']);

        $this->data['documents_department_list_by_session_institute'] = $this->get_document_department_by_session_institute_id($this->session->userdata('sess_institute_id'));

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        // print_r($this->input->post());
        // exit();
        $this->form_validation->set_rules('category_name', 'Category Name', 'required');
        $this->form_validation->set_rules('institute_id[]', 'Institute Name', 'required');
        $this->form_validation->set_rules('department_id[]', 'Department Name', 'required');

        if($this->form_validation->run($this) === TRUE)
        {
            /* print_r($this->data['post_data']);
            echo "<br>------------</br>";
            print_r($this->data['post_data']['institute_id']);
            echo "<br>------------</br>";
            exit(); */
            if($this->input->post())
            {   
                
                $institute_id = '';
				$department_id = '';
				
                if(isset($this->data['post_data']['institute_id']) && !empty($this->data['post_data']['institute_id']) && is_array($this->data['post_data']['institute_id']))
                    {
                        $institute_id                   = implode(',', $this->data['post_data']['institute_id']);
                    }

				if(isset($this->data['post_data']['department_id']) && !empty($this->data['post_data']['department_id']) && is_array($this->data['post_data']['department_id']))
                    {
                        $department_id                   = implode(',', $this->data['post_data']['department_id']);
                    }
                    
                if($id)
                {
                    //$slug_data                          = array('industry_name' => $this->input->post('industry_name'),);
                    //$slug                               = $this->slug->create_uri($slug_data, $id);

                    $update['institute_id']                 = $institute_id;
					$update['document_department_id']       = $department_id;
                    $update['name']                         = $this->input->post('category_name');
					$update['order_by']                     = $this->input->post('order_by');
                    $update['status']                       = $this->input->post('status');
                    $update['modified_on']                  = date('Y-m-d H:i:s');
                    $update['modified_by']                  = $this->session->userdata('user_id');

                    $response = $this->documents_category->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $industrial_visits_id               = $id;
                        $msg = ['error' => 0, 'message' => 'Department successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['institute_id']                 = $institute_id;
					$insert['document_department_id']       = $department_id;
                    $insert['name']                         = $this->input->post('category_name');
					$insert['order_by']                  	= $this->input->post('order_by');
                    $insert['status']                       = $this->input->post('status');
                    $insert['created_on']                   = date('Y-m-d H:i:s');
                    $insert['created_by']                   = $this->session->userdata('user_id');
                    $insert['modified_on']                  = date('Y-m-d H:i:s');
                    $insert['modified_by']                  = $this->session->userdata('user_id');

                    $response                               = $this->documents_category->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $industrial_visits_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Department successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/documents_category/');
            }
        }

        if($id!='')
        {
            $documents_category     			= $this->documents_category->get_documents_category_list(['dc.id' => $id]);
            $this->data['post_data']  			= isset($documents_category[0]) ? $documents_category[0] : [];
			
			
			$this->data['post_department_data'] = $this->documents_category->get_document_department_by_institute_id($this->data['post_data']['institute_id']);				
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Documents Department not found']);
                redirect(base_url()."cms/documents_category/");
            }
        }

        $this->data['all_institute']   = $this->documents_category->get_all_institute();
        $this->data['content']         = $this->load->view('cms/documents/documents_category/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function get_document_department_by_session_institute_id($institute_id)
    {
        $document_department = $this->documents_category->get_document_department_by_institute_id($institute_id);
        
        return $document_department;
    }

    function get_document_department_by_institute_id()
	{
		$institute_id = $this->input->post('institute_id');
		$document_department = $this->documents_category->get_document_department_by_institute_id($institute_id);
        
        echo json_encode($document_department);
	}
	
    function delete($id='')
    {

        $this->data['insta_id']             = $this->default_institute_id;
        //$this->data['insta_id'] = $id;
        validate_permissions('documents_category', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
    
        $response = $this->documents_category->_delete('id', $id);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
       
        redirect(base_url().'cms/documents_category/');
    }

    
}
