<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mandatory_disclosure extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/mandatory_disclosure/Mandatory_disclosure_modal', 'mandatory_disclosure');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

     function index()
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "mandatory_disclosure";
        $this->data['child_menu_type']      = "mandatory_disclosure";
        $this->data['sub_child_menu_type']  = "mandatory_disclosure";

        validate_permissions('mandatory_disclosure', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list']            = $this->mandatory_disclosure->get_documents_list(['m.institute_id' => $this->session->userdata('sess_institute_id')]);
        // print_r($this->data['data_list']);
        // exit();
        $this->data['title']                = _l("Disclosure",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/mandatory_disclosure/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['title']                = 'Disclosure';
        $this->data['module']               = 'mandatory_disclosure';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "mandatory_disclosure";
        $this->data['child_menu_type']      = "mandatory_disclosure";
        $this->data['sub_child_menu_type']  = "save_documents";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        $this->data['sess_institute_id']    = $this->session->userdata('sess_institute_id');
        $this->data['sess_institute_name']  = $this->session->userdata('sess_institute_name');                                   
        $sub_institute_ids = array();
        $sub_institute_ids = $this->mandatory_disclosure->get_sub_institute_ids($this->data['sess_institute_id']);
        
        $this->data['sub_institute_ids']    = $sub_institute_ids;

        $instituteID                        = $this->session->userdata('sess_institute_id');
        //$this->data['document_category']    = $this->get_document_category_by_institute_id($this->data['sess_institute_id']);

        $this->data['document_category']    = $this->get_document_department_by_institute_id($this->data['sess_institute_id']);
        

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('mandatory_disclosure', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        // print_r($this->input->post());
        // exit();
        $this->form_validation->set_rules('document_name', 'Document Name', 'required');
        $this->form_validation->set_rules('department_name', 'Department Name', 'required');
        $this->form_validation->set_rules('document_url', 'Document Url', 'required');
        $this->form_validation->set_rules('status', 'Public', '');

        if($this->form_validation->run($this) === TRUE)
        {
            // print_r($this->input->post());
            // echo "<br>------------</br>";
            // exit();
            if($this->input->post())
            {   
                    
                if($id)
                {
                    //$slug_data                          = array('industry_name' => $this->input->post('industry_name'),);
                    //$slug                               = $this->slug->create_uri($slug_data, $id);

                    $update['institute_id']                 = $instituteID;
                    $update['name']                         = $this->input->post('document_name');
                    $update['document_subcategory_id']      = $this->input->post('document_category');
                    $update['document_category_id']         = $this->input->post('department_name');
                    $update['document_url']                 = $this->input->post('document_url');
                    $update['weblink_or_pdf']               = $this->input->post('weblink_or_pdf');
                    $update['order_by']                     = $this->input->post('order_by');
                    $update['description']                  = $this->input->post('description');
                    $update['status']                       = $this->input->post('status');
                    $update['modified_on']                  = date('Y-m-d H:i:s');
                    $update['modified_by']                  = $this->session->userdata('user_id');

                    $response = $this->mandatory_disclosure->_update('id', $id, $update);
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
                    $insert['institute_id']                 = $instituteID;
                    $insert['document_subcategory_id']      = $this->input->post('document_category');
                    $insert['document_category_id']         = $this->input->post('department_name');
                    $insert['document_url']                 = $this->input->post('document_url');
                    $insert['weblink_or_pdf']               = $this->input->post('weblink_or_pdf');
                    $insert['order_by']                     = $this->input->post('order_by');
                    $insert['description']                  = $this->input->post('description');
                    $insert['status']                       = $this->input->post('status');
                    $insert['created_on']                   = date('Y-m-d H:i:s');
                    $insert['created_by']                   = $this->session->userdata('user_id');
                    $insert['modified_on']                  = date('Y-m-d H:i:s');
                    $insert['modified_by']                  = $this->session->userdata('user_id');


                    // print_r($insert);
                    // exit();
                    $response                               = $this->mandatory_disclosure->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $industrial_visits_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Disclosure successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/mandatory_disclosure/');
            }
        }

        if($id!='')
        {
            $mandatory_disclosure              = $this->mandatory_disclosure->get_documents_list(['m.id' => $id]);
            $this->data['post_data']           = isset($mandatory_disclosure[0]) ? $mandatory_disclosure[0] : [];

            // print_r($this->data['post_data']);
            // exit();
            $this->data['document_subcategory']   = $this->mandatory_disclosure->get_document_category_by_department_id($this->data['post_data']['document_category_id']);

            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Disclosure not found']);
                redirect(base_url()."cms/mandatory_disclosure/");
            }
        }

        $this->data['all_institute']               = $this->mandatory_disclosure->get_all_institute();
        
        $this->data['content']                 = $this->load->view('cms/mandatory_disclosure/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function get_document_category_by_department_id()
    {
        $department_id = $this->input->post('department_id');

        $document_category = $this->mandatory_disclosure->get_document_category_by_department_id($department_id);

        echo json_encode($document_category);exit();
    }

    function get_document_category_by_institute_id($institute_id)
    {

        //$institute_id = $this->input->post("institute_id");
        $document_category = $this->mandatory_disclosure->get_document_category_by_institute_id($institute_id);
        
        return $document_category;

        // $institute_id = $this->input->post("institute_id");
        // $document_category = $this->documents->get_document_category_by_institute_id($institute_id);
        
        // echo json_encode($document_category);exit;
    }

    function get_document_department_by_institute_id($institute_id)
    {
        $document_department = $this->mandatory_disclosure->get_document_department_by_institute_id($institute_id);
        
        return $document_department;
    }

    function delete($id='')
    {
        $this->data['insta_id'] = $id;
        validate_permissions('mandatory_disclosure', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
    
        $response = $this->mandatory_disclosure->_delete('id', $id);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
       
        redirect(base_url().'cms/mandatory_disclosure/');
    }

    
}
