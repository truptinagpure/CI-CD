<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mmg extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/mmg/Mmg_model', 'mmg');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "mmg";
        $this->data['child_menu_type']      = "mmg";
        $this->data['sub_child_menu_type']  = "mmg";

        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Mmg', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list']            = $this->mmg->get_mmg(['f.institute_id' => $instituteID]);
        $this->data['title']                = 'Mmg';
        $this->data['page']                 = "Mmg";
        $this->data['content']              = $this->load->view('cms/mmg/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {   

        $this->data['title']                = 'Mmg';
        $this->data['module']               = 'Mmg';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "mmg";
        $this->data['child_menu_type']      = "mmg";
        $this->data['sub_child_menu_type']  = "save_mmg";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        $this->data['post_data']['status']  = 1;
        
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        $per_action                         = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Mmg', 'edit', $per_action, $this->data['insta_id']);

        if($id)
        {
            $this->data['links']  = $this->mmg->get_all_links($id);

            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'MMG Field not found']);
                redirect(base_url().'cms/mmg/index/');
            }
        }

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
            // echo "<pre>"; print_r($this->data['post_data']);exit();
        }

        // $this->form_validation->set_rules('mmg_name', 'Mmg Name', 'required');
        $this->form_validation->set_rules('mmg_name', 'Mmg Name', 'required|callback_unique_mmg');
        $this->form_validation->set_rules('status', 'Status', '');

        if($this->form_validation->run($this) === TRUE)
        { 
            if($this->input->post())
            {   
                $path       = './upload_file/mmg/images/';
                $filesnew   = $this->base64_to_image($this->input->post('thumbnail'), $path);

                $thumbnail  = isset($filesnew['thumbnail']) ? $filesnew['thumbnail'] : '';
                
                $files = $_FILES;
                $count = count($_FILES['banner_image_video']['name']);
                if (isset($_FILES['banner_image_video']['name']) && !empty($_FILES['banner_image_video']['name'])) 
                {   
                    $config2['upload_path'] = $path;
                    $config2['allowed_types'] = 'gif|jpg|png|jpeg|mp4|mpeg|mpg|avi|mov';
                    $config2['max_size'] = '0';
                    $config2['remove_spaces'] = true;
                    $config2['overwrite'] = false;
                    $config2['max_width'] = '';
                    $config2['max_height'] = '';
                    $fileNamefeatured12 = $_FILES['banner_image_video']['name'];
                    $fileNamefeatured = str_replace(' ', '_', $fileNamefeatured12);
                    $this->load->library('upload', $config2);
                    $this->upload->initialize($config2);
                    $this->upload->do_upload();
                    if ( ! $this->upload->do_upload('banner_image_video'))
                    {
                        // codeToMessage($_FILES['file']['error']); 
                        $error = array('error' => $this->upload->display_errors());
                    }
                    else
                    {
                        echo "Success";
                    }         
                }

                $response = $this->mmg->manage_mmg($this->input->post(), $id,$thumbnail,$fileNamefeatured,$instituteID);
                if(isset($response['status']) && $response['status'] == 'success')
                {
                    $msg = ['error' => 0, 'message' => 'Mmg successfully added'];
                }
                else
                {
                    $msg = ['error' => 0, 'message' => $response['message']];
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/mmg/');
            }
        }
        if($id!='')
        {
            $mmg                            = $this->mmg->get_mmg(['f.id' => $id, 'f.status !=' => '-1']);
            $this->data['post_data']        = isset($mmg[0]) ? $mmg[0] : [];
            
            if(empty($this->data['post_data']))
            {   
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'mmg not found']);
                redirect(base_url()."cms/mmg/");
            }
        }
        $this->data['mmg_fields']       = $this->mmg->get_all_mmg_fields($instituteID);
        $this->data['mmg_ids']          = $this->mmg->get_all_mmg_ids();
        $this->data['content']          = $this->load->view('cms/mmg/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);        
    }


    function base64_to_image($image_data='', $path='') {
        $image_name         = '';
        $path               = !empty($path) ? $path : './upload_file/mmg/images/';
        
        if(!empty($image_data))
        {   
            $image_parts    = explode(";base64,", $image_data);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type     = $image_type_aux[1];
            $image_base64   = base64_decode($image_parts[1]);
            $image_name     = uniqid().'.'.$image_type;
            $file           = $path.'/'.$image_name;
            file_put_contents($file, $image_base64);
        }
        return ['thumbnail' => $image_name];
    }


    function delete($id='')
    {
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Mmg', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $mmg                          = $this->mmg->get_mmg(['f.id' => $id, 'f.status !=' => '-1']);

        if(!empty($mmg))
        {
            $this->common_model->set_table('mmg_program');
            $response = $this->common_model->_delete('id', $id);

            $this->common_model->set_table('mmg_program_links');
            $response = $this->common_model->_delete('mmg_program_id', $id);

            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'mmg not found.']);
        }
        redirect(base_url().'cms/mmg');
    }

    function ajax_check_mmg()
    {   
        if($this->input->post())
        {
            $result = $this->unique_mmg();
            echo $result;exit;
        }
    }

    function unique_mmg()
    {   
        $instituteID                = $this->session->userdata('sess_institute_id');
        $mmgid                      = isset($_POST['mmgid']) ? $_POST['mmgid'] : '';
        $mmg_field_id               = isset($_POST['mmg_field_id']) ? $_POST['mmg_field_id'] : '';
        $errormessage               = 'MMG for this institute is already exist.';
        $this->form_validation->set_message('unique_mmg', $errormessage);

        if(empty($mmgid) and !empty($instituteID))
        {
            $content = $this->common_model->custom_query('Select * FROM mmg_program WHERE MMG_Fied_Id = "'.$mmg_field_id.'" AND institute_id = "'.$instituteID.'" AND id != "'.$mmgid.'"');
        }

        if(isset($content[0]) && !empty($content[0]))
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }


    function delete_banner_image($id=0)
    {
        $this->db->where('id', $id);
        $response =  $this->db->update('mmg_program', array('banner_image_video' => ''));

        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        redirect(base_url().'cms/mmg/edit/'.$id);
    }

    function delete_links()
    {        
        $deleteid  = $this->input->post('pid');
        $this->db->delete('mmg_program_links', array('id' => $deleteid));
        $verify = $this->db->affected_rows();
        echo $verify;
    }

    function save_mmglinks_order()
    {   
        $programme_id = $_POST["programme_id_array"];

        $i=1;
        foreach($programme_id as $k=>$v){
            $query=$this->db->query("UPDATE mmg_program_links SET link_order = '".$i."' where id = '".$v."'");


            $i++;
        }

        echo 'Link order has been updated';
    }

    function appendmmg()
    { 
        $mmg_dir_list  = $this->mmg->get_all_mmg_ids();

        $options = '<option value="">Select MMG</option>';

        foreach ($mmg_dir_list as $key => $value) {
            $options .= '<option value="'.$value["MMG_ID"].'">'.$value["MMG_Name"].'</option>';
        }

        echo $options;
    }

}
