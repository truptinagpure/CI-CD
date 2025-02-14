<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Faq extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/faq/Faq_category_model', 'category');
        $this->load->model('cms/faq/Faq_model', 'faq');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "faq";
        $this->data['child_menu_type']      = "faq";
        $this->data['sub_child_menu_type']  = "faq";

        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Faq', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list']            = $this->faq->get_faq(['f.institute_id' => $this->data['insta_id']]);
        $this->data['title']                = 'Faq';
        $this->data['page']                 = "Faq";
        $this->data['content']              = $this->load->view('cms/faq/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['title']                = 'Faq';
        $this->data['module']               = 'Faq';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "faq";
        $this->data['child_menu_type']      = "faq";
        $this->data['sub_child_menu_type']  = "save_faq";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        $per_action                         = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Faq', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        $this->form_validation->set_rules('category_id', 'Category', 'required');
        // $this->form_validation->set_rules('sub_category_id', 'Sub Category Id', 'required');
        $this->form_validation->set_rules('question', 'Question', 'required|max_length[255]');
        $this->form_validation->set_rules('answer', 'Answer', 'required');
        $this->form_validation->set_rules('status', 'Public', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {
                $this->common_model->set_table('faq');
                if($id)
                {
                    $update['category_id']              = $this->input->post('category_id');
                    $update['sub_category_id']          = $this->input->post('sub_category_id');
                    $update['question']                 = $this->input->post('question');
                    $update['answer']                   = $this->input->post('answer');
                    $update['status']                   = $this->input->post('status');
                    $update['modified_on']              = date('Y-m-d H:i:s');
                    $update['modified_by']              = $this->session->userdata('user_id');

                    $response = $this->common_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $faq_id                         = $id;
                        $msg = ['error' => 0, 'message' => 'Faq successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['institute_id']             = $this->data['insta_id'];
                    $insert['category_id']              = $this->input->post('category_id');
                    $insert['sub_category_id']          = $this->input->post('sub_category_id');
                    $insert['question']                 = $this->input->post('question');
                    $insert['answer']                   = $this->input->post('answer');
                    $insert['status']                   = $this->input->post('status');
                    $insert['created_on']               = date('Y-m-d H:i:s');
                    $insert['created_by']               = $this->session->userdata('user_id');
                    $insert['modified_on']              = date('Y-m-d H:i:s');
                    $insert['modified_by']              = $this->session->userdata('user_id');

                    $response                           = $this->common_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $faq_id                         = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Faq successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/faq/');
            }
        }

        if($id!='')
        {
            $faq                            = $this->faq->get_faq(['f.id' => $id, 'f.institute_id' => $this->data['insta_id'], 'f.status !=' => '-1']);
            $this->data['post_data']        = isset($faq[0]) ? $faq[0] : [];
            
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Faq not found']);
                redirect(base_url()."cms/faq/");
            }
        }

        $this->data['faq_categories']       = $this->category->get_parent_categories($this->data['insta_id'], 1);
        $this->data['content']              = $this->load->view('cms/faq/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Faq', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $faq                                = $this->faq->get_faq(['f.id' => $id, 'f.institute_id' => $this->data['insta_id'], 'f.status !=' => '-1']);

        if(!empty($faq))
        {
            $this->common_model->set_table('faq');
            $response = $this->common_model->_delete('id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Faq not found.']);
        }
        redirect(base_url().'cms/faq/');
    }

    function get_sub_category($parent_id)
    {
        $sql            = 'Select s.* FROM faq_categories s WHERE s.status = "1" AND s.parent_id="'.$parent_id.'" ORDER BY s.name ASC';
        $sub_categories = $this->common_model->custom_query($sql);
        return $sub_categories;
    }

    function get_subcategory_options()
    {
        $options            = '<option value="">-- Select Sub Category --</option>';
        $parent_id          = isset($_POST['parent_id']) ? $_POST['parent_id'] : '';
        $sub_categories     = $this->get_sub_category($parent_id);
        $sub_category_id    = isset($_POST['sub_category_id']) ? $_POST['sub_category_id'] : '';

        foreach ($sub_categories as $key => $value) {
            $selected           = '';
            if($sub_category_id == $value['id'])
            {
                $selected       = 'selected="selected"';
            }
            $options            .= '<option value="'.$value['id'].'" '.$selected.'>'.$value['name'].'</option>';
        }
        echo json_encode($options);exit;
    }
}
