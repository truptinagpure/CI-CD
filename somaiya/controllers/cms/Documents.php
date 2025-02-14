<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Documents extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/documents/Documents_modal', 'documents');
        //$this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

     function index()
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "documents";
        $this->data['child_menu_type']      = "documents";
        $this->data['sub_child_menu_type']  = "documents";

        validate_permissions('documents', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['documents_list']            = $this->documents->get_documents_list(['institute_id' => $this->session->userdata('sess_institute_id')]);
        // print_r($this->data['data_list']);
        // exit();
        $this->data['title']                = _l("Documents",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/documents/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['title']                = 'Documents';
        $this->data['module']               = 'documents';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "documents";
        $this->data['child_menu_type']      = "documents";
        $this->data['sub_child_menu_type']  = "save_documents";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        $this->data['sess_institute_id']    = $this->session->userdata('sess_institute_id');
        $this->data['sess_institute_name']  = $this->session->userdata('sess_institute_name');                                   
        $sub_institute_ids = array();
        $sub_institute_ids = $this->documents->get_sub_institute_ids($this->data['sess_institute_id']);
        
        $this->data['sub_institute_ids']    = $sub_institute_ids;

        //$this->data['document_category']    = $this->get_document_category_by_institute_id($this->data['sess_institute_id']);

        $this->data['document_department']    = $this->get_document_department_by_institute_id($this->data['sess_institute_id']);
        

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('documents', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        // print_r($this->input->post());
        // exit();
        $this->form_validation->set_rules('document_name', 'Document Name', 'required');
        $this->form_validation->set_rules('institute_id[]', 'Institute Name', 'required');
        //$this->form_validation->set_rules('document_category', 'Document_category', 'required');
        $this->form_validation->set_rules('department_name', 'Department Name', 'required');
        //$this->form_validation->set_rules('description', 'Description', '');
        $this->form_validation->set_rules('document_url', 'Document Url', 'required');
        $this->form_validation->set_rules('status', 'Public', '');

        if($this->form_validation->run($this) === TRUE)
        {
            // print_r($this->input->post());
            // echo "<br>------------</br>";
            // exit();
            if($this->input->post())
            {   
                
                $institute_id = '';
                if(isset($this->data['post_data']['institute_id']) && !empty($this->data['post_data']['institute_id']) && is_array($this->data['post_data']['institute_id']))
                    {
                        $institute_id                   = implode(',', $this->data['post_data']['institute_id']);
                    }
                    
                if($id)
                {
                    //$slug_data                          = array('industry_name' => $this->input->post('industry_name'),);
                    //$slug                               = $this->slug->create_uri($slug_data, $id);

                    $update['institute_id']                 = $institute_id;
                    $update['name']                         = $this->input->post('document_name');
                    $update['document_category_id']         = $this->input->post('document_category');
                    $update['document_department_id']       = $this->input->post('department_name');
                    $update['document_url']                 = $this->input->post('document_url');
                    $update['description']                  = $this->input->post('description');
					$update['order_by']                     = $this->input->post('order_by');
                    $update['status']                       = $this->input->post('status');
                    $update['modified_on']                  = date('Y-m-d H:i:s');
                    $update['modified_by']                  = $this->session->userdata('user_id');

                    $response = $this->documents->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $industrial_visits_id               = $id;
                        $msg = ['error' => 0, 'message' => 'Document successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    //$insert['department_id']                = $department_id;
                    $insert['name']                         = $this->input->post('document_name');
                    //$insert['institute_id']                 = $this->input->post('institute_id');
                    $insert['institute_id']                 = $institute_id;
                    $insert['document_category_id']         = $this->input->post('document_category');
                    $insert['document_department_id']       = $this->input->post('department_name');
                    $insert['document_url']                 = $this->input->post('document_url');
                    $insert['description']                  = $this->input->post('description');
					$insert['order_by']                  	= $this->input->post('order_by');
                    $insert['status']                       = $this->input->post('status');
                    $insert['created_on']                   = date('Y-m-d H:i:s');
                    $insert['created_by']                   = $this->session->userdata('user_id');
                    $insert['modified_on']                  = date('Y-m-d H:i:s');
                    $insert['modified_by']                  = $this->session->userdata('user_id');


                    // print_r($insert);
                    // exit();
                    $response                               = $this->documents->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $industrial_visits_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Documents successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/documents/');
            }
        }

        if($id!='')
        {
            $documents                         = $this->documents->get_documents_list(['id' => $id]);
            $this->data['post_data']           = isset($documents[0]) ? $documents[0] : [];

            // print_r($this->data['post_data']);
            // exit();
            $this->data['document_category']   = $this->documents->get_document_category_by_department_id($this->data['post_data']['document_department_id']);

            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Documents not found']);
                redirect(base_url()."cms/documents/");
            }
        }

        $this->data['all_institute']               = $this->documents->get_all_institute();
        
        $this->data['content']                 = $this->load->view('cms/documents/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function get_document_category_by_department_id()
    {
        $department_id = $this->input->post('department_id');

        $document_category = $this->documents->get_document_category_by_department_id($department_id);

        echo json_encode($document_category);exit();
    }

    function get_document_category_by_institute_id($institute_id)
    {

        //$institute_id = $this->input->post("institute_id");
        $document_category = $this->documents->get_document_category_by_institute_id($institute_id);
        
        return $document_category;

        // $institute_id = $this->input->post("institute_id");
        // $document_category = $this->documents->get_document_category_by_institute_id($institute_id);
        
        // echo json_encode($document_category);exit;
    }

    function get_document_department_by_institute_id($institute_id)
    {
        $document_department = $this->documents->get_document_department_by_institute_id($institute_id);
        
        return $document_department;
    }

    function delete($id='')
    {
        $this->data['insta_id'] = $id;
        validate_permissions('documents', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
    
        $response = $this->documents->_delete('id', $id);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
       
        redirect(base_url().'cms/documents/');
    }

    
}
