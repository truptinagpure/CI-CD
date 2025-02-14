<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Nacc_childcategory extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/nacc/Nacc_childcategory_model', 'nacc_childcategory');
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

     function index()
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "nacc";
        $this->data['child_menu_type']      = "nacc_childcategory";
        $this->data['sub_child_menu_type']  = "nacc_childcategory";

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];

        validate_permissions('Nacc', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        

        $this->data['nacc_list'] = $this->nacc_childcategory->get_nacc_list(['nc.institute_id' => $this->session->userdata('sess_institute_id')]);
        $this->data['title']                = _l("Nacc",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/nacc/nacc_childcategory/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
		$this->data['insta_id']             = $this->default_institute_id;
        $this->data['title']                = 'Nacc';
        $this->data['module']               = 'nacc';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "nacc";
        $this->data['child_menu_type']      = "nacc_childcategory";
        $this->data['sub_child_menu_type']  = "save_nacc_childcategory";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        $this->data['sess_institute_id']    = $this->session->userdata('sess_institute_id');
        $this->data['sess_institute_name']  = $this->session->userdata('sess_institute_name');                                   
             

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Nacc', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        $this->form_validation->set_rules('name', 'Notice Name', 'required');
        $this->form_validation->set_rules('accreditation_id[]', 'Accreditation Id', 'required');
        $this->form_validation->set_rules('parent_id[]', 'Accreditation Id', 'required');
        
        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                
                $parent_id  = $accreditation_id = '';
		
                if(isset($this->data['post_data']['parent_id']) && !empty($this->data['post_data']['parent_id']) && is_array($this->data['post_data']['parent_id']))
                {
                    $parent_id                   = implode(',', $this->data['post_data']['parent_id']);
                }

                if(isset($this->data['post_data']['accreditation_id']) && !empty($this->data['post_data']['accreditation_id']) && is_array($this->data['post_data']['accreditation_id']))
                {
                    $accreditation_id                   = implode(',', $this->data['post_data']['accreditation_id']);
                }
                

                $link_name = $this->data['post_data']['link_name'];
                $link_url = $this->data['post_data']['link_url'];
                $nacc_files = array_combine($link_name, $link_url);
                
                if($id)
                {
                    $update['institute_id']         = $this->session->userdata('sess_institute_id');
                    $update['accreditation_id']     = $accreditation_id;
                    $update['parent_id']            = $parent_id;
                    $update['name']                 = $this->input->post('name');
                    $update['metric_number']        = $this->input->post('metric_number');
                    $update['description']          = $this->input->post('description');
                    $update['order_by']             = $this->input->post('order_by');
                    $update['status']               = $this->input->post('status');
                    $update['modified_on']          = date('Y-m-d H:i:s');
                    $update['modified_by']          = $this->session->userdata('user_id');
                    
                    $response = $this->nacc_childcategory->_update('id', $id, $update, $this->input->post());
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $industrial_visits_id               = $id;
                        $msg = ['error' => 0, 'message' => 'Nacc successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['institute_id']         = $this->session->userdata('sess_institute_id');
                    $insert['accreditation_id']     = $accreditation_id;
                    $insert['parent_id']            = $parent_id;
                    $insert['name']                 = $this->input->post('name');
                    $insert['metric_number']        = $this->input->post('metric_number');
                    $insert['description']          = $this->input->post('description');
                    $insert['order_by']             = $this->input->post('order_by');
                    $insert['status']               = $this->input->post('status');
                    $insert['created_on']           = date('Y-m-d H:i:s');
                    $insert['created_by']           = $this->session->userdata('user_id');

                    $response              = $this->nacc_childcategory->_insert($insert,$nacc_files);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $notice_id = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Nacc successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }

                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/nacc_childcategory/');
            }
        }

        if($id!='')
        {
            $this->data['links']  = $this->nacc_childcategory->get_all_links($id);

            $nacc     	      = $this->nacc_childcategory->get_nacc_list(['nc.id' => $id]);
            $this->data['post_data']    = isset($nacc[0]) ? $nacc[0] : [];
		    //$this->data['all_nacc_list']         = $this->nacc_childcategory->get_all_nacc_list($this->session->userdata('sess_institute_id'),$id);
            $this->data['all_nacc_list']         = $this->nacc_childcategory->get_all_nacc_list($this->session->userdata('sess_institute_id'),$nacc[0]['accreditation_id']);
            //$this->data['all_subcategory_list']  = $this->nacc_childcategory->get_all_subcategory_list($this->session->userdata('sess_institute_id'),$id);
            $this->data['category_id']           = $this->nacc_childcategory->get_categoryId_by_subcategory($nacc[0]['parent_id']);
            // echo "<pre>";
            // print_r($this->data['category_id']);
            // exit();
            $this->data['all_subcategory_list']  = $this->nacc_childcategory->get_all_subcategory_list($this->session->userdata('sess_institute_id'),$this->data['category_id'][0]['parent_id']);

            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Nacc not found']);
                redirect(base_url()."cms/nacc_childcategory/");
            }
        }
        else
        {
            //$this->data['all_nacc_list']         = $this->nacc_childcategory->get_all_nacc_list($this->session->userdata('sess_institute_id'),'');
            //$this->data['all_subcategory_list']  = $this->nacc_childcategory->get_all_subcategory_list($this->session->userdata('sess_institute_id'),'');
            $this->data['category_id']           = array();
        }

        $this->data['all_accreditation']     = $this->nacc_childcategory->get_all_accreditation($this->session->userdata('sess_institute_id'));
        

        $this->data['content']             = $this->load->view('cms/nacc/nacc_childcategory/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {

        $this->data['insta_id']             = $this->default_institute_id;
        //$this->data['insta_id'] = $id;
        validate_permissions('Nacc', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $response = $this->nacc_childcategory->_delete('id', $id);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
       
        redirect(base_url().'cms/nacc_childcategory/');
    }

    function delete_links()
    {        
        $deleteid  = $this->input->post('pid');
        $this->db->delete('nacc_files', array('id' => $deleteid));

        $verify = $this->db->affected_rows();
        echo $verify;
    }

    function save_nacclinks_order()
    {   
        $programme_id = $_POST["programme_id_array"];
        $i=1;
        foreach($programme_id as $k=>$v){
            $query=$this->db->query("UPDATE nacc_files SET link_order = '".$i."' where id = '".$v."'");


            $i++;
        }

        echo 'Nacc urls order has been updated';
    }

    function get_subcategory_by_cat_id()
    {
        $category_id = $this->input->post('category_id');

        $subcategory = $this->nacc_childcategory->get_subcategory_by_cat_id($category_id);

        echo json_encode($subcategory);exit();
    }

    function get_category_by_accreditation_id()
    {
        $accreditation_id = $this->input->post('accreditation_id');

        $category = $this->nacc_childcategory->get_category_by_accreditation_id($accreditation_id);

        echo json_encode($category);exit();
    }
    
}
