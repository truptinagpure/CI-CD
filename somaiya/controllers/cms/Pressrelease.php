<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pressrelease extends Somaiya_Controller
{
    private $default_institute_id;

    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/pressrelease/Pressrelease_model', 'pressrelease_model');
        $this->load->model('cms/Somaiya_general_admin_model', 'Somaiya_general_admin_model');
        $this->load->model('cms/Category_model', 'category_model');
        $user_id = $this->session->userdata['user_id'];
        $default_institute_id = $this->config->item('default_institute_id');
       
    }

 function index()
    {

    	$this->data['main_menu_type']           = "institute_menu";
        $this->data['sub_menu_type']            = "news_media";
        $this->data['child_menu_type']          = "press_release";
        $this->data['sub_child_menu_type']      = "";
        $instituteID  = $this->session->userdata('sess_institute_id');
        $this->data['institute_name']           = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name']     = $this->session->userdata['sess_institute_short_name'];
        $inst_id = $instituteID ? $instituteID : $default_institute_id;
        $public  =-1;
        validate_permissions('Pressrelease', 'index', $this->config->item('method_for_view'), $inst_id);
        $this->data['institutes_details']   = $this->Somaiya_general_admin_model->get_institute_detail($inst_id);
        $this->data['data_list']            = $this->pressrelease_model->get_pressrelease_location($inst_id,$public);
        $this->data['title']                = 'pressrelease';
        $this->data['page']                 = 'pressrelease';
        $this->data['content']              = $this->load->view('cms/pressrelease/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);

    }



   function edit($id='',$contents_id='')
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "news_media";
        $this->data['child_menu_type']      = "press_release";
        $this->data['sub_child_menu_type']  = "save_press_release";
        $allowed_inst_ids                   = [];
        $save_data                          = [];
 		$instituteID  = $this->session->userdata('sess_institute_id');
        $inst_id      = isset($instituteID) ? $instituteID : $default_institute_id;
        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Pressrelease', 'edit', $per_action, $inst_id);

        $titles      = array();
        $data_titles = $this->Somaiya_general_admin_model->get_all_titles("pressrelease",$id);
        if(count($data_titles)!=0)
        {
            foreach ($data_titles as $value) 
            {
                $titles[$value["language_id"]] = $value;
            }
        }
        $this->data['titles']               = $titles;
        $this->data['languages']            = $this->Somaiya_general_admin_model->get_all_language();
        $this->data['institutes_details']   = $this->Somaiya_general_admin_model->get_institute_detail($instituteID);
        $this->data['institutes_list']      = $this->Somaiya_general_admin_model->get_all_institute();
        $this->data['category']             = $this->Somaiya_general_admin_model->get_all_categories();
        $this->data['title']                = 'Pressrelease';
        $this->data['page']                 = 'Pressrelease';
        $this->data['data']                 = [];
        $this->data['pressrelease_id']      = $id;
        $this->data['data']['public']       = 1;
        if($id)
        {
            $this->data['data']    = $this->pressrelease_model->get_pressrelease($id);
            if(empty($this->data['data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Pressrelease not found']);
                redirect(base_url().'cms/pressrelease/');
            }

            if(isset($this->data['data']['institute_id']) && !empty($this->data['data']['institute_id']))
            {
                $this->data['institute_id'] = explode(',', $this->data['data']['institute_id']);
            }
        }

        if($this->input->post())
        {
            $this->data['data']     = $this->input->post();
        }

        $this->form_validation->set_rules('name', 'Name', 'required|max_length[250]');
        $this->form_validation->set_rules('public', 'Public', '');
        $this->form_validation->set_rules('category_id', 'category_id', '');
        $this->form_validation->set_rules('public', 'Public', '');
        if($this->form_validation->run($this) === TRUE)
        { 
            if($this->input->post())
            {   
                 foreach ( $this->input->post('institute_id') as $key => $value) 
                     {
                      $allowed_inst_ids[] = $value;
                     }
                 $save_data = !empty($allowed_inst_ids) ? implode(',', $allowed_inst_ids) : '';
                if($id)
                {
                    $update['pressrelease']['title']                         = $this->input->post('name');
                    $update['pressrelease']['institute_id']                  = $save_data;
                    $update['pressrelease']['category_id']                   = $this->input->post('category_id');
                    $update['pressrelease']['whats_new']                     = $this->input->post('whats_new');
                    $update['pressrelease']['whats_new_expiry_date']         = $this->input->post('whats_new_expiry_date');
                    $update['pressrelease']['date']                          = $this->input->post('date');
                    $update['pressrelease']['public']                        = $this->input->post('public');
                    $update['pressrelease']['user_id']                       = $this->session->userdata['user_id'];
                    $update['pressrelease']['modified_on']                   = date('Y-m-d H:i:s');
                    $update['pressrelease']['modified_by']                   = $this->session->userdata['user_id'];
                    $update['contentspressrelease']['contents_id']           = $this->input->post('contents_id');
                    $update['contentspressrelease']['title']                 = $this->input->post('name');
                    $update['contentspressrelease']['description']           = $this->input->post('description');
                    $update['contentspressrelease']['language_id']           = $this->input->post('language_id');
                    $update['contentspressrelease']['public']                = $this->input->post('public');
                    $update['contentspressrelease']['persons']               = $this->input->post('persons');
                    $update['contentspressrelease']['modified_on']          = date('Y-m-d H:i:s');
                    $update['contentspressrelease']['modified_by']               = $this->session->userdata['user_id'];
                    $response = $this->pressrelease_model->_update('pressrelease_id', $id, $update);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                    $msg = ['error' => 0, 'message' => 'Pressrelease successfully updated'];
                    }
                    else
                    { $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['pressrelease']['title']                         = $this->input->post('name');
                    $insert['pressrelease']['institute_id']                  = $save_data;
                    $insert['pressrelease']['category_id']                   = $this->input->post('category_id');
                    $insert['pressrelease']['whats_new']                     = $this->input->post('whats_new');
                    $insert['pressrelease']['whats_new_expiry_date']         = $this->input->post('whats_new_expiry_date');
                    $insert['pressrelease']['date']                          = $this->input->post('date');
                    $insert['pressrelease']['public']                        = $this->input->post('public');
                    $insert['pressrelease']['user_id']                       = $this->session->userdata['user_id'];
                    $insert['pressrelease']['created_on']                    = date('Y-m-d H:i:s');
                    $insert['pressrelease']['modified_on']                   = date('Y-m-d H:i:s');
                    $insert['pressrelease']['created_by']                    = $this->session->userdata['user_id'];
                    $insert['pressrelease']['modified_by']                   = $this->session->userdata['user_id'];
                    $insert['contentspressrelease']['title']                 = $this->input->post('name');
                    $insert['contentspressrelease']['description']           = $this->input->post('description');
                    $insert['contentspressrelease']['language_id']           = $this->input->post('language_id');
                    $insert['contentspressrelease']['public']                = $this->input->post('public');
                    $insert['contentspressrelease']['persons']               = $this->input->post('persons');
                    $insert['contentspressrelease']['data_type']             = $this->input->post('data_type');
                    $insert['contentspressrelease']['created_on']            = date('Y-m-d H:i:s');
                    $insert['contentspressrelease']['modified_on']           = date('Y-m-d H:i:s');
                    $insert['contentspressrelease']['created_by']            = $this->session->userdata['user_id'];
                    $insert['contentspressrelease']['modified_by']           = $this->session->userdata['user_id'];
                    $response= $this->pressrelease_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $post_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Pressrelease successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
               $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/pressrelease');
            }
        }
     

          $this->data['content'] = $this->load->view('cms/pressrelease/form',$this->data,true);
          $this->load->view($this->mainTemplate,$this->data);  
    }

//start here

    function delete($id='')
    {
        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
        validate_permissions('Pressrelease', 'delete', $this->config->item('method_for_delete'), $this->data['institute_id']);
        $public =-1;
        $post   = $this->pressrelease_model->get_pressrelease_found($id, $public);

        if(!empty($post))
        {
        $response = $this->pressrelease_model->_delete('pressrelease_id', $id);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
        $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Pressrelease not found.']);
        }
        
        redirect(base_url().'cms/pressrelease');


    }

    function get_pressreleases($id='', $conditions=[], $order_by='')
    {
        $sql = 'SELECT pl.* FROM pressrelease pl WHERE 1=1';
        foreach ($conditions as $key => $value)
        {
            $sql .= ' AND pl.'.$key.' = "'.$value.'"';
        }
        if($id)
        {
            $sql .= ' AND pl.pressrelease_id = "'.$id.'"';
        }
        if($order_by)
        {
            $sql .= ' ORDER BY "'.$order_by.'"';
        }
        else
        {
            $sql .= ' ORDER BY pl.pressrelease_id DESC';
        }
        $result = $this->common_model->custom_query($sql);
        return $result;
    }

 
        function get_pressrelease_content($pressrelease_id='', $contents_id='', $conditions=[], $order_by='')
    {
        $sql = 'SELECT plc.*, l.language_name FROM contentspressrelease plc join languages l ON l.language_id = plc.language_id WHERE plc.relation_id = "'.$pressrelease_id.'"';
        foreach ($conditions as $key => $value) {
            $sql .= ' AND plc.'.$key.' = "'.$value.'"';
        }
        if($contents_id)
        {
            $sql .= ' AND plc.contents_id = "'.$contents_id.'"';
        }
        if($order_by)
        {
            $sql .= ' ORDER BY "'.$order_by.'"';
        }
        else
        {
            $sql .= ' ORDER BY plc.contents_id DESC';
        }
        $result = $this->common_model->custom_query($sql);
        return $result;
    }

    

}


?>