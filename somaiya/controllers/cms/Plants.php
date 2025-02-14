<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Plants extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/vanaspatyam/Plant_category_model', 'category');
        $this->load->model('cms/vanaspatyam/Plant_colors_model', 'colors');
        $this->load->model('cms/vanaspatyam/Plants_model', 'plants');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['main_menu_type']       = "vanaspatyam";
        $this->data['sub_menu_type']        = "vanaspatyam";
        $this->data['child_menu_type']      = "plants";
        $this->data['sub_child_menu_type']  = "plants";

        validate_permissions('Plants', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list']            = $this->plants->get_plants();
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/vanaspatyam/plants/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['title']                = 'Plants';
        $this->data['module']               = 'Plants';
        $this->data['main_menu_type']       = "vanaspatyam";
        $this->data['sub_menu_type']        = "vanaspatyam";
        $this->data['child_menu_type']      = "plants";
        $this->data['sub_child_menu_type']  = "save_plants";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        
        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Plants', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        $this->form_validation->set_rules('category_id', 'Category', 'required');
        $this->form_validation->set_rules('botanical_name', 'Botanical Name', 'required');
        $this->form_validation->set_rules('plant_name_in_sanskrit', 'Sanskrit Name', 'required');
        $this->form_validation->set_rules('plant_name_in_english', 'English Name', 'required');
        $this->form_validation->set_rules('plant_name_in_marathi', 'Marathi Name', 'required');
        $this->form_validation->set_rules('plant_name_in_hindi', 'Hindi Name', 'required');
        $this->form_validation->set_rules('plant_name_in_gujarati', 'Gujarati Name', 'required');
		$this->form_validation->set_rules('latitude', 'Latitude', 'required');
        $this->form_validation->set_rules('longitude', 'Longitude', 'required');
        $this->form_validation->set_rules('status', 'Public', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                $path  = './upload_file/vanaspatyam/plants/thumbnail/';
                $filesnew = $this->base64_to_image($this->input->post('thumbnail'), $path);
                $files = $this->file_upload();

                // $thumbnail  = isset($files['thumbnail']) ? $files['thumbnail'] : '';
                $thumbnail      = isset($filesnew['thumbnail']) ? $filesnew['thumbnail'] : '';
                $images     = isset($files['images']) ? $files['images'] : [];

                $config = array(
                    'table'         => 'plants',
                    'id'            => 'id',
                    'field'         => 'slug',
                    'title'         => 'plant_name_in_english',
                    'replacement'   => 'dash' // Either dash or underscore
                );
                $this->load->library('slug', $config);

                $this->common_model->set_table('plants');
                if($id)
                {
                    $slug_data                          = array('plant_name_in_english' => $this->input->post('plant_name_in_english'),);
                    $slug                               = $this->slug->create_uri($slug_data, $id);

                    $update['category_id']              = $this->input->post('category_id');
                    $update['sub_category_id']          = $this->input->post('sub_category_id');
                    $update['color_id']                 = $this->input->post('color_id');
                    $update['botanical_name']           = $this->input->post('botanical_name');
                    $update['plant_name_in_sanskrit']   = $this->input->post('plant_name_in_sanskrit');
                    $update['plant_name_in_english']    = $this->input->post('plant_name_in_english');
                    $update['plant_name_in_marathi']    = $this->input->post('plant_name_in_marathi');
                    $update['plant_name_in_hindi']      = $this->input->post('plant_name_in_hindi');
                    $update['plant_name_in_gujarati']   = $this->input->post('plant_name_in_gujarati');
                    $update['description']              = $this->input->post('description');
                    $update['slug']                     = $slug;
                    if(!empty($thumbnail))
                    {
                        $update['thumbnail']            = $thumbnail;
                    }
                    $update['verses']                   = $this->input->post('verses');
                    $update['reference']                = $this->input->post('reference');
					$update['latitude']                 = $this->input->post('latitude');
                    $update['longitude']                = $this->input->post('longitude');
                    $update['status']                   = $this->input->post('status');
                    $update['modified_on']              = date('Y-m-d H:i:s');
                    $update['modified_by']              = $this->session->userdata('user_id');

                    $response = $this->common_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $plant_id                       = $id;
                        $moreverses                     = isset($_POST['moreverses']) ? $_POST['moreverses'] : [];
                        $morereference                  = isset($_POST['morereference']) ? $_POST['morereference'] : [];

                        $this->save_images($images, $plant_id);
                        $this->save_benefits($plant_id);
                        $this->save_verses($moreverses, $morereference, $plant_id);

                        $msg = ['error' => 0, 'message' => 'Plant successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['category_id']              = $this->input->post('category_id');
                    $insert['sub_category_id']          = $this->input->post('sub_category_id');
                    $insert['color_id']                 = $this->input->post('color_id');
                    $insert['botanical_name']           = $this->input->post('botanical_name');
                    $insert['plant_name_in_sanskrit']   = $this->input->post('plant_name_in_sanskrit');
                    $insert['plant_name_in_english']    = $this->input->post('plant_name_in_english');
                    $insert['plant_name_in_marathi']    = $this->input->post('plant_name_in_marathi');
                    $insert['plant_name_in_hindi']      = $this->input->post('plant_name_in_hindi');
                    $insert['plant_name_in_gujarati']   = $this->input->post('plant_name_in_gujarati');
                    $insert['description']              = $this->input->post('description');
                    $insert['slug']                     = $this->slug->create_uri(array('plant_name_in_english' => $this->input->post('plant_name_in_english')));
                    $insert['thumbnail']                = $thumbnail;
                    $insert['verses']                   = $this->input->post('verses');
                    $insert['reference']                = $this->input->post('reference');
					$insert['latitude']                 = $this->input->post('latitude');
                    $insert['longitude']                = $this->input->post('longitude');
                    $insert['status']                   = $this->input->post('status');
                    $insert['created_on']               = date('Y-m-d H:i:s');
                    $insert['created_by']               = $this->session->userdata('user_id');
                    $insert['modified_on']              = date('Y-m-d H:i:s');
                    $insert['modified_by']              = $this->session->userdata('user_id');

                    $response                           = $this->common_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $plant_id                       = $response['id'];
                        $moreverses                     = isset($_POST['moreverses']) ? $_POST['moreverses'] : [];
                        $morereference                  = isset($_POST['morereference']) ? $_POST['morereference'] : [];

                        $this->save_images($images, $plant_id);
                        $this->save_benefits($plant_id);
                        $this->save_verses($moreverses, $morereference, $plant_id);

                        $msg = ['error' => 0, 'message' => 'Plant successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/plants/');
            }
        }

        if($id!='')
        {
            $plant                          = $this->plants->get_plants(['p.id' => $id, 'p.status !=' => '-1']);
            $this->data['plant_images']     = $this->plants->get_table_data('plant_images', ['plant_id' => $id]);
            $this->data['plant_benefits']   = $this->plants->get_table_data('plant_benefits', ['plant_id' => $id]);
            $this->data['plant_verses']     = $this->plants->get_table_data('plant_verses', ['plant_id' => $id]);
            $this->data['post_data']        = isset($plant[0]) ? $plant[0] : [];

            // echo "<pre>";print_r($this->data['plant_images']);exit;

            foreach ($this->data['plant_benefits'] as $key => $value) {
                $this->data['post_data'][$value['language']] = $value['benefit'];
            }
            
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Plant not found']);
                redirect(base_url()."cms/plants/");
            }
        }

        $this->data['plant_categories']     = $this->category->get_parent_categories();
        $this->data['plant_colors']         = $this->colors->get_colors();
        $this->data['content']              = $this->load->view('cms/vanaspatyam/plants/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    private function save_images($images, $plant_id)
    {
        if(!empty($images) && !empty($plant_id))
        {
            $insert_images                  = [];

            foreach ($images as $key => $value) {
                $save_images['plant_id']        = $plant_id;
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
                $this->common_model->set_table('plant_images');
                $this->common_model->_insert_multiple($insert_images);
            }
        }
        return true;
    }

    private function save_benefits($plant_id='')
    {
        if(!empty($plant_id))
        {
            $insert_benefits                = [];
            $languages                      = ['en', 'hi', 'mr', 'gu'];

            foreach ($languages as $key => $value) {
                $benefits['plant_id']       = $plant_id;
                $benefits['language']       = $value;
                $benefits['benefit']        = isset($_POST[$value]) ? $_POST[$value] : '';
                $benefits['status']         = $this->input->post('status');
                $benefits['created_on']     = date('Y-m-d H:i:s');
                $benefits['created_by']     = $this->session->userdata('user_id');
                $benefits['modified_on']    = date('Y-m-d H:i:s');
                $benefits['modified_by']    = $this->session->userdata('user_id');
                $insert_benefits[]          = $benefits;
            }

            if(!empty($insert_benefits))
            {
                $this->common_model->set_table('plant_benefits');
                $this->common_model->_delete('plant_id', $plant_id);
                $this->common_model->_insert_multiple($insert_benefits);
            }
        }
        return true;
    }

    private function save_verses($moreverses=[], $morereference=[], $plant_id)
    {
        if(!empty($moreverses) && !empty($plant_id))
        {
            $insert_verses                     = [];
            foreach ($moreverses as $key => $value) {
                if(!empty($value))
                {
                    $save_verses['plant_id']       = $plant_id;
                    $save_verses['verses']         = $value;
                    $save_verses['reference']      = isset($morereference[$key]) ? $morereference[$key] : '';
                    $save_verses['status']         = $this->input->post('status');
                    $save_verses['created_on']     = date('Y-m-d H:i:s');
                    $save_verses['created_by']     = $this->session->userdata('user_id');
                    $save_verses['modified_on']    = date('Y-m-d H:i:s');
                    $save_verses['modified_by']    = $this->session->userdata('user_id');
                    $insert_verses[]               = $save_verses;
                }
            }
            if(!empty($insert_verses))
            {
                $this->common_model->set_table('plant_verses');
                $this->common_model->_delete('plant_id', $plant_id);
                $this->common_model->_insert_multiple($insert_verses);
            }
        }
        return true;
    }


    function base64_to_image($image_data='', $path='') {
        $image_name         = '';
        $path               = !empty($path) ? $path : './upload_file/vanaspatyam/plants/thumbnail/';
        
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
        $pathToUpload   = './upload_file/vanaspatyam/plants/thumbnail/';
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
        $pathToUpload   = './upload_file/vanaspatyam/plants/images/';

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
        $this->db->delete('plant_images', array('id' => $deleteid));
        $verify = $this->db->affected_rows();
        echo $verify;
    }

    function deletethumbnail()
    {
        $deleteid  = $this->input->post('plant_id');
        $update['thumbnail']                = '';
        $update['modified_on']              = date('Y-m-d H:i:s');
        $update['modified_by']              = $this->session->userdata('user_id');

        $this->common_model->set_table('plants');
        $this->common_model->_update('id', $deleteid, $update);
        echo true;
    }

    function delete($id='')
    {
        $this->data['insta_id'] = $this->default_institute_id;
        validate_permissions('Plants', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $plant = $this->plants->get_plants(['p.id' => $id, 'p.status !=' => '-1']);

        if(!empty($plant))
        {
            $this->common_model->set_table('plants');
            $response = $this->common_model->_delete('id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Plant not found.']);
        }
        redirect(base_url().'cms/plants/');
    }

    function get_sub_category($parent_id)
        {
            $sql            = 'Select s.* FROM plant_categories s WHERE s.status = "1" AND s.parent_id="'.$parent_id.'" ORDER BY s.name ASC';
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
