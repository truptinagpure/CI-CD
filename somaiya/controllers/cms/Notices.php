<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Notices extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/notices/Notices_model', 'notices');
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

     function index()
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "notices";
        $this->data['child_menu_type']      = "notices";
        $this->data['sub_child_menu_type']  = "notices";

        validate_permissions('Notices', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        

        $this->data['notices_list'] = $this->notices->get_notices_list(['nc.institute_id' => $this->session->userdata('sess_institute_id')]);
        // echo "<pre>";
        // print_r($this->data['notices_list']);
        // exit();
        $this->data['title']                = _l("Notices",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/notices/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
		$this->data['insta_id']             = $this->default_institute_id;
        $this->data['title']                = 'Notices';
        $this->data['module']               = 'notices';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "notices";
        $this->data['child_menu_type']      = "notices";
        $this->data['sub_child_menu_type']  = "save_notices";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        $this->data['sess_institute_id']    = $this->session->userdata('sess_institute_id');
        $this->data['sess_institute_name']  = $this->session->userdata('sess_institute_name');                                   
             

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Notices', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        // print_r($this->input->post());
        // exit();
        $this->form_validation->set_rules('notice_name', 'Notice Name', 'required');
        //$this->form_validation->set_rules('department', 'Department', 'required');
        $this->form_validation->set_rules('notice_category[]', 'Notices Category', 'required');
        //$this->form_validation->set_rules('url', 'Notices URL', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required');
        //$this->form_validation->set_rules('expiry_date', 'Expiry Date', 'required');
        $this->form_validation->set_rules('academic_year', 'Academic Year', 'required');
        $this->form_validation->set_rules('applicable_for[]', 'Applicable for', 'required');
        
        if($this->form_validation->run($this) === TRUE)
        {
            /* print_r($this->data['post_data']);
            echo "<br>------------</br>";
            print_r($this->data['post_data']['institute_id']);
            echo "<br>------------</br>";
            exit(); */
            if($this->input->post())
            {   
                
                $notices_cat_id = $applicable_for = '';
		
                if(isset($this->data['post_data']['notice_category']) && !empty($this->data['post_data']['notice_category']) && is_array($this->data['post_data']['notice_category']))
                    {
                        $notices_cat_id                   = implode(',', $this->data['post_data']['notice_category']);
                    }

                if(isset($this->data['post_data']['applicable_for']) && !empty($this->data['post_data']['applicable_for']) && is_array($this->data['post_data']['applicable_for']))
                    {
                        $applicable_for                   = implode(',', $this->data['post_data']['applicable_for']);
                    }

                if(isset($this->data['post_data']['department']) && !empty($this->data['post_data']['department']) && is_array($this->data['post_data']['department']))
                {
                    $department                   = implode(',', $this->data['post_data']['department']);
                }
                else
                {
                    $department = "null";
                }

                $link_name = $this->data['post_data']['link_name'];
                $link_url = $this->data['post_data']['link_url'];
                $notice_urls = array_combine($link_name, $link_url);
                // echo "<pre>";
                // print_r($link_name);
                // echo "<br>------------------<br>";
                // echo "<pre>";
                // print_r($link_url);
                // echo "<br>------------------<br>";
                // echo "<pre>";
                // print_r($notice_urls);
                // echo "<br>------------------<br>";
                // echo "<pre>";
                // print_r($this->input->post());
                // exit();
                if($id)
                {
                    $update['institute_id']     = $this->session->userdata('sess_institute_id');
					$update['name']             = $this->input->post('notice_name');
                    $update['department_id']    = $department;
                    $update['notices_cat_id']   = $notices_cat_id;
                    //$update['url']              = $this->input->post('url');
                    $update['date']             = $this->input->post('date');
                    $update['expiry_date']      = $this->input->post('expiry_date');
                    $update['academic_year']    = $this->input->post('academic_year');
                    $update['applicable_for']   = $applicable_for;
					$update['whats_new']            = $this->input->post('whats_new');
                    $update['whats_new_expiry_date']= $this->input->post('whats_new_expiry_date');
                    $update['status']           = $this->input->post('status');
                    $update['modified_on']      = date('Y-m-d H:i:s');
                    $update['modified_by']      = $this->session->userdata('user_id');
                    // echo "<pre>";
                    // print_r($update);
                    // exit();
                    $response = $this->notices->_update('id', $id, $update, $this->input->post());
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
                    $insert['name']             = $this->input->post('notice_name');
                    
                    $insert['department_id']    = $department;
                    $insert['notices_cat_id']   = $notices_cat_id;
                    //$insert['url']              = $this->input->post('url');
                    $insert['date']             = $this->input->post('date');
                    $insert['expiry_date']      = $this->input->post('expiry_date');
                    $insert['academic_year']    = $this->input->post('academic_year');
                    $insert['applicable_for']   = $applicable_for;
					$insert['whats_new']            = $this->input->post('whats_new');
                    $insert['whats_new_expiry_date']= $this->input->post('whats_new_expiry_date');
                    $insert['status']           = $this->input->post('status');
                    $insert['created_on']       = date('Y-m-d H:i:s');
                    $insert['created_by']       = $this->session->userdata('user_id');

                    // echo "<pre>";
                    // print_r($insert);
                    // exit();
                    
                    $response              = $this->notices->_insert($insert,$notice_urls);

                    // echo "<pre>";
                    // print_r($response);
                    // exit();
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $notice_id = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Notice successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }

                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/notices/');
            }
        }

        if($id!='')
        {
            $this->data['links']  = $this->notices->get_all_links($id);

            $notices     	      = $this->notices->get_notices_list(['nc.id' => $id]);
            $this->data['post_data']    = isset($notices[0]) ? $notices[0] : [];
						
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Notice Category not found']);
                redirect(base_url()."cms/notices/");
            }
        }

        //$this->data['notices']               = $this->notices->get_notices_list(['nc.institute_id' => $this->session->userdata('sess_institute_id')]);
        $this->data['all_institute']         = $this->notices->get_all_institute();
        $this->data['all_department']        = $this->notices->get_all_department();
        $parentCategoryList                  = $this->notices->getParentCategoryByInstitute($this->session->userdata('sess_institute_id'));

        if($parentCategoryList)
        {
            $i = 0;
            foreach ($parentCategoryList as $key => $value) {
                $childCategory = $this->notices->get_subCategoryData($value['id']);
                
                if($childCategory)
                {
                    $j=0;
                    $parentCategoryList[$i]['sub_category'] = $childCategory;
                }
                $i++;
            }
        }
        

        $this->data['all_notice_category']   = $parentCategoryList;
        $this->data['academic_year']         = $this->notices->get_all_academic_year_by_institute($this->session->userdata('sess_institute_id'));
        $this->data['content']               = $this->load->view('cms/notices/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {

        $this->data['insta_id']             = $this->default_institute_id;
        //$this->data['insta_id'] = $id;
        validate_permissions('Notices', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $response = $this->notices->_delete('id', $id);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
       
        redirect(base_url().'cms/notices/');
    }

    function delete_links()
    {        
        $deleteid  = $this->input->post('pid');
        $this->db->delete('notices_urls', array('id' => $deleteid));

        // $table      = 'notices_urls';
        // $this->db->set('status', -1);
        // $this->db->where('id', $deleteid);
        // $this->db->update($table);

        $verify = $this->db->affected_rows();
        echo $verify;
    }

    function save_noticelinks_order()
    {   
        $programme_id = $_POST["programme_id_array"];
        // echo "<pre>";
        // print_r($programme_id);
        // exit();
        $i=1;
        foreach($programme_id as $k=>$v){
            $query=$this->db->query("UPDATE notices_urls SET link_order = '".$i."' where id = '".$v."'");


            $i++;
        }

        echo 'Notice urls order has been updated';
    }

    
}
