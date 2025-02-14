<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Awards extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/awards/Type_model', 'type');
        $this->load->model('cms/awards/Awards_model', 'awards');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "awards";
        $this->data['child_menu_type']      = "awards";
        $this->data['sub_child_menu_type']  = "awards";

        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Awards', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list']            = $this->awards->get_awards(['f.institute_id' => $instituteID]);
        $this->data['title']                = 'Awards';
        $this->data['page']                 = "Awards";
        $this->data['content']              = $this->load->view('cms/awards/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['title']                = 'Awards';
        $this->data['module']               = 'Awards';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "awards";
        $this->data['child_menu_type']      = "awards";
        $this->data['sub_child_menu_type']  = "save_awards";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        $per_action                         = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Awards', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
            // echo "<pre>"; print_r($this->data['post_data']);exit();
        }

        $this->form_validation->set_rules('type_id', 'Type', 'required');
        // $this->form_validation->set_rules('sub_category_id', 'Sub Category Id', 'required');
        // $this->form_validation->set_rules('question', 'Question', 'required|max_length[255]');
        // $this->form_validation->set_rules('answer', 'Answer', 'required');
        $this->form_validation->set_rules('status', 'Publish', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                $allowed_department_ids           = [];
                $save_data                  = [];
                foreach ($_POST['department_id'] as $key => $value) 
                {
                    $allowed_department_ids[] = $value;
                }

                $save_data = !empty($allowed_department_ids) ? implode(',', $allowed_department_ids) : '';

                $path       = './upload_file/awards/thumbnail/';
                $filesnew   = $this->base64_to_image($this->input->post('thumbnail'), $path);
                $files      = $this->file_upload();

                $thumbnail  = isset($filesnew['thumbnail']) ? $filesnew['thumbnail'] : '';
                $images     = isset($files['images']) ? $files['images'] : [];

                $this->common_model->set_table('awards');
                if($id)
                {   
                    $update['award_title']              = $this->input->post('award_title');
                    $update['awarded_by']               = $this->input->post('awarded_by');
                    $update['type_id']                  = $this->input->post('type_id');
                    $update['sub_type_id']              = $this->input->post('sub_type_id');
                    $update['department_id']            = $save_data;
                    $update['institute_id']             = $instituteID;
                    $update['date']                     = $this->input->post('date');
                    $update['award_badge']              = $this->input->post('award_badge');
                    $update['description']              = $this->input->post('description');
                    if(!empty($thumbnail))
                    {
                        $update['thumbnail']            = $thumbnail;
                    }
                    $update['status']                   = $this->input->post('status');
                    $update['modified_on']              = date('Y-m-d H:i:s');
                    $update['modified_by']              = $this->session->userdata('user_id');

                    $response = $this->common_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $awards_id                         = $id;
                        $this->save_images($images, $awards_id);
                        $msg = ['error' => 0, 'message' => 'Awards successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {   
                    $insert['award_title']              = $this->input->post('award_title');
                    $insert['awarded_by']               = $this->input->post('awarded_by');
                    $insert['department_id']            = $save_data;
                    $insert['institute_id']             = $instituteID;
                    $insert['type_id']                  = $this->input->post('type_id');
                    $insert['sub_type_id']              = $this->input->post('sub_type_id');
                    $insert['thumbnail']                = $thumbnail;
                    $insert['date']                     = $this->input->post('date');
                    $insert['award_badge']              = $this->input->post('award_badge');
                    $insert['description']              = $this->input->post('description');
                    $insert['status']                   = $this->input->post('status');
                    $insert['created_on']               = date('Y-m-d H:i:s');
                    $insert['created_by']               = $this->session->userdata('user_id');
                    $insert['modified_on']              = date('Y-m-d H:i:s');
                    $insert['modified_by']              = $this->session->userdata('user_id');

                    $response                           = $this->common_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $awards_id                         = $response['id'];
                        $this->save_images($images, $awards_id);
                        $msg = ['error' => 0, 'message' => 'Awards successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/awards/');
            }
        }

        if($id!='')
        {
            $awards                         = $this->awards->get_awards(['f.id' => $id, 'f.status !=' => '-1']);
            $this->data['award_images']     = $this->awards->get_table_data('awards_images', ['award_id' => $id]);
            $this->data['post_data']        = isset($awards[0]) ? $awards[0] : [];
            
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'awards not found']);
                redirect(base_url()."cms/awards/");
            }
        }

        $this->data['awards_type']       = $this->type->get_parent_type(1);
        $this->data['department']        = $this->awards->get_department();
        $this->data['content']           = $this->load->view('cms/awards/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Awards', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $awards                                = $this->awards->get_awards(['f.id' => $id, 'f.status !=' => '-1']);

        if(!empty($awards))
        {
            $this->common_model->set_table('awards');
            $response = $this->common_model->_delete('id', $id);

            $this->common_model->set_table('awards_images');
            $response = $this->common_model->_delete('award_id', $id);

            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'awards not found.']);
        }
        redirect(base_url().'cms/awards');
    }

    private function save_images($images, $awards_id)
    {
        if(!empty($images) && !empty($awards_id))
        {
            $insert_images                  = [];

            foreach ($images as $key => $value) {
                $save_images['award_id']        = $awards_id;
                $save_images['image']           = $value['image'];
                $save_images['name']            = $value['name'];
                $save_images['description']     = $value['description'];
                $save_images['status']          = $this->input->post('status');
                $save_images['created_on']      = date('Y-m-d H:i:s');
                $save_images['created_by']      = $this->session->userdata('user_id');
                $save_images['modified_on']     = date('Y-m-d H:i:s');
                $save_images['modified_by']     = $this->session->userdata('user_id');
                $insert_images[]                = $save_images;
            }

            if(!empty($insert_images))
            {
                $this->common_model->set_table('awards_images');
                $this->common_model->_insert_multiple($insert_images);
            }
        }
        return true;
    }

    function base64_to_image($image_data='', $path='') {
        $image_name         = '';
        $path               = !empty($path) ? $path : './upload_file/awards/thumbnail/';
        
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

    function file_upload()
    {
        $pathToUpload   = './upload_file/awards/thumbnail/';
        if(!file_exists($pathToUpload))
        {
            $create     = mkdir($pathToUpload);
            chmod("$pathToUpload", 0777);
        }
        $files          = $_FILES;
        $fimg           = count($_FILES['thumbnail']['name']);
        $thumbnail      = '';

        if($fimg !== "")
        {
            $config22['upload_path']    = $pathToUpload;
            $config22['allowed_types']  = 'gif|jpg|png|jpeg';
            $config22['max_size']       = '8000000';
            $config22['remove_spaces']  = true;
            $config22['overwrite']      = false;
            $config22['max_width']      = '';
            $config22['max_height']     = '';
            $fileNamefeatured12         = $_FILES['thumbnail']['name'];
            $fileNamefeatured           = str_replace(' ', '_', $fileNamefeatured12);
            $images2[]                  = $fileNamefeatured;

            $this->load->library('upload', $config22);
            $this->upload->initialize($config22);
            $this->upload->do_upload();
            if(!$this->upload->do_upload('thumbnail'))
            {
                $error = array('error' => $this->upload->display_errors());
            }
            else
            {
                $upload_data            = $this->upload->data();
                $thumbnail              = isset($upload_data['file_name']) ? $upload_data['file_name'] : '';
            }
        }

        $images         = [];
        $imagedata      = [];
        $pathToUpload   = './upload_file/awards/images/';

        if(isset($_POST['images']))
        {
            $this->load->library('customlib');
            foreach ($_POST['images'] as $key => $value) {
                $image = $this->customlib->base64_image_upload($value, $pathToUpload);
                $images['image'] = $image;
                $images['name'] = $_POST['image_name'][$key];
                $images['description'] = $_POST['image_description'][$key];
                $imagedata[] = $images;
            }
        }
        return ['thumbnail' => $thumbnail, 'images' => $imagedata];
    }

    function deleteimage()
    {
        $deleteid  = $this->input->post('image_id');
        $this->db->delete('awards_images', array('id' => $deleteid));
        $verify = $this->db->affected_rows();
        echo $verify;
    }

    function deletethumbnail()
    {
        $deleteid  = $this->input->post('award_id');
        $update['thumbnail']                = '';
        $update['modified_on']              = date('Y-m-d H:i:s');
        $update['modified_by']              = $this->session->userdata('user_id');

        $this->common_model->set_table('awards');
        $this->common_model->_update('id', $deleteid, $update);
        echo true;
    }

    function get_sub_type($parent_id)
    {
        $sql            = 'Select s.* FROM awards_type s WHERE s.status = "1" AND s.parent_id="'.$parent_id.'" ORDER BY s.name ASC';
        $sub_type       = $this->common_model->custom_query($sql);
        return $sub_type;
    }

    function get_subtype_options()
    { 
        $options            = '<option value="">-- Select Sub Type --</option>';
        $parent_id          = isset($_POST['parent_id']) ? $_POST['parent_id'] : '';
        $sub_type           = $this->get_sub_type($parent_id);
        $sub_type_id        = isset($_POST['sub_type_id']) ? $_POST['sub_type_id'] : '';

        foreach ($sub_type as $key => $value) {
            $selected           = '';
            if($sub_type_id == $value['id'])
            {
                $selected       = 'selected="selected"';
            }
            $options            .= '<option value="'.$value['id'].'" '.$selected.'>'.$value['name'].'</option>';
        }
        echo json_encode($options);exit;
    }
}
