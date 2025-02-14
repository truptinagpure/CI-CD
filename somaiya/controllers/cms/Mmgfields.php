<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mmgfields extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/mmg/Mmgfields_model', 'mmg');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['main_menu_type']       = "master";
        $this->data['sub_menu_type']        = "mmgfields";
        $this->data['child_menu_type']      = "mmgfields";
        $this->data['sub_child_menu_type']  = "mmgfields";

        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Mmgfields', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list']            = $this->mmg->get_mmg();
        $this->data['title']                = 'Mmg';
        $this->data['page']                 = "Mmg";
        $this->data['content']              = $this->load->view('cms/mmg/index_mmg_field',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {   

        $this->data['title']                = 'Mmg';
        $this->data['module']               = 'Mmg';
        $this->data['main_menu_type']       = "master";
        $this->data['sub_menu_type']        = "mmgfields";
        $this->data['child_menu_type']      = "mmgfields";
        $this->data['sub_child_menu_type']  = "save_mmg_fields";
        $this->data['post_data']            = [];
        $this->data['MMG_Fied_Id']                   = $id;
        $this->data['post_data']['status']  = 1;
        
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        $per_action                         = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Mmgfields', 'edit', $per_action, $this->data['insta_id']);

        if($id)
        {

            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'MMG Field not found']);
                redirect(base_url().'cms/mmgfields/index/');
            }
        }

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
            //echo "<pre>"; print_r($this->data['post_data']);exit();
        }

        // $this->form_validation->set_rules('mmg_name', 'Mmg Name', 'required');
        $this->form_validation->set_rules('MMG_Fied_Name', 'Mmg Name', 'required');

        if($this->form_validation->run($this) === TRUE)
        { 
            if($this->input->post())
            {   
                $path       = './upload_file/mmg/images/';
                $filesnew   = $this->base64_to_image($this->input->post('thumbnail'), $path);
                $thumbnail  = isset($filesnew['thumbnail']) ? $filesnew['thumbnail'] : '';
                
                $response = $this->mmg->manage_mmg($this->input->post(), $id,$thumbnail);
                if(isset($response['status']) && $response['status'] == 'success')
                {
                    $msg = ['error' => 0, 'message' => 'Mmg successfully added'];
                }
                else
                {
                    $msg = ['error' => 0, 'message' => $response['message']];
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/mmgfields/');
            }
        }
        if($id!='')
        {
            $mmg                            = $this->mmg->get_mmg(['f.MMG_Fied_Id' => $id]);
            $this->data['post_data']        = isset($mmg[0]) ? $mmg[0] : [];
            
            if(empty($this->data['post_data']))
            {   
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'mmg not found']);
                redirect(base_url()."cms/mmgfields/");
            }
        }
        $this->data['content']          = $this->load->view('cms/mmg/form_mmg_field',$this->data,true);
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
        validate_permissions('Mmgfields', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $mmg                          = $this->mmg->get_mmg(['f.MMG_Fied_Id' => $id]);

        if(!empty($mmg))
        {
            $this->common_model->set_table('mmg_field_dir');
            $response = $this->common_model->_delete('MMG_Fied_Id', $id);

            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'mmg not found.']);
        }
        redirect(base_url().'cms/mmgfields');
    }

}
