<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Result extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/result/Result_category_modal', 'result_category');
        $this->load->model('cms/result/Result_modal', 'result');
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "result";
        $this->data['child_menu_type']      = "result";
        $this->data['sub_child_menu_type']  = "result";

        validate_permissions('Result', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        

        $this->data['result_list'] = $this->result->get_result_list(['r.institute_id' => $this->session->userdata('sess_institute_id')]);
        $this->data['title']                = _l("Result",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/result/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['title']                = 'Result';
        $this->data['module']               = 'result';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "result";
        $this->data['child_menu_type']      = "result";
        $this->data['sub_child_menu_type']  = "save_result";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        $this->data['sess_institute_id']    = $this->session->userdata('sess_institute_id');
        $this->data['sess_institute_name']  = $this->session->userdata('sess_institute_name');                                   
             

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Result', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        $this->form_validation->set_rules('result_name', 'Result Name', 'required');
        $this->form_validation->set_rules('result_category_id', 'Result Category', 'required');
        $this->form_validation->set_rules('result_sub_category_id[]', 'Result Subcategory', 'required');
        //$this->form_validation->set_rules('url', 'result URL', 'required');
        $this->form_validation->set_rules('academic_year', 'Academic Year', 'required');
        
        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                
                $result_subcat_id = '';
        
                // if(isset($this->data['post_data']['result_category_id']) && !empty($this->data['post_data']['result_category_id']) && is_array($this->data['post_data']['result_category_id']))
                //     {
                //         $result_cat_id                   = implode(',', $this->data['post_data']['result_category_id']);
                //     }

                if(isset($this->data['post_data']['result_sub_category_id']) && !empty($this->data['post_data']['result_sub_category_id']) && is_array($this->data['post_data']['result_sub_category_id']))
                    {
                        $result_subcat_id                   = implode(',', $this->data['post_data']['result_sub_category_id']);
                    }

                
                $link_name = $this->data['post_data']['link_name'];
                $link_url = $this->data['post_data']['link_url'];
                $result_urls = array_combine($link_name, $link_url);
                if($id)
                {
                    $update['institute_id']             = $this->session->userdata('sess_institute_id');
                    $update['name']                     = $this->input->post('result_name');
                    $update['result_category_id']       = $this->input->post('result_category_id');
                    $update['result_sub_category_id']   = $result_subcat_id;
                    $update['academic_year']            = $this->input->post('academic_year');
                    $update['status']                   = $this->input->post('status');
                    $update['modified_on']              = date('Y-m-d H:i:s');
                    $update['modified_by']              = $this->session->userdata('user_id');

                    $response                           = $this->result->_update('id', $id, $update, $this->input->post());

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $result_id               = $id;
                        $msg = ['error' => 0, 'message' => 'Result successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['institute_id']             = $this->session->userdata('sess_institute_id');
                    $insert['name']                     = $this->input->post('result_name');
                    $insert['result_category_id']       = $this->input->post('result_category_id');
                    $insert['result_sub_category_id']   = $result_subcat_id;
                    $insert['academic_year']            = $this->input->post('academic_year');
                    $insert['status']                   = $this->input->post('status');
                    $insert['created_on']               = date('Y-m-d H:i:s');
                    $insert['created_by']               = $this->session->userdata('user_id');

                    $response                           = $this->result->_insert($insert,$result_urls);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $result_id = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Result successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }

                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/result/');
            }
        }

        if($id!='')
        {
            $this->data['links']                = $this->result->get_all_links($id);
            $result                             = $this->result->get_result_list(['r.id' => $id]);
            $this->data['post_data']            = isset($result[0]) ? $result[0] : [];
            $this->data['result_subcategory']   = $this->result->get_result_subcategory_by_cat_id($this->data['post_data']['result_category_id']);

            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Result not found']);
                redirect(base_url()."cms/result/");
            }
        }

        $this->data['all_institute']         = $this->result->get_all_institute();
        $CategoryList                        = $this->result->getCategoryByInstitute($this->session->userdata('sess_institute_id'));
        
        $this->data['all_result_category']   = $CategoryList;
        $this->data['academic_year']         = $this->result->get_all_academic_year_by_institute($this->session->userdata('sess_institute_id'));
        $this->data['content']               = $this->load->view('cms/result/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {

        $this->data['insta_id']             = $this->default_institute_id;
        validate_permissions('Result', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $response = $this->result->_delete('id', $id);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
       
        redirect(base_url().'cms/result/');
    }

    function delete_links()
    {        
        $deleteid  = $this->input->post('pid');
        $this->db->delete('result_urls', array('id' => $deleteid));

        $verify = $this->db->affected_rows();
        echo $verify;
    }

    function save_resultlinks_order()
    {   
        $programme_id = $_POST["programme_id_array"];
        $i=1;
        foreach($programme_id as $k=>$v){
            $query=$this->db->query("UPDATE result_urls SET link_order = '".$i."' where id = '".$v."'");


            $i++;
        }

        echo 'Result urls order has been updated';
    }

    function get_result_subcategory_by_cat_id()
    {
        $category_id = $this->input->post('category_id');

        $result_subcategory = $this->result->get_result_subcategory_by_cat_id($category_id);

        echo json_encode($result_subcategory);exit();
    }
}
