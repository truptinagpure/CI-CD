<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Banner extends Somaiya_Controller
{
    private $default_institute_id;

    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/banner/Banner_model', 'banner_model');
        //$this->load->model('cms/Somaiya_general_admin_model', 'Somaiya_general_admin_model');
        //$this->load->model('cms/Category_model', 'category_model');
        $user_id = $this->session->userdata['user_id'];
        //echo '<pre>'; print_r($this->session->all_userdata());exit;
        $default_institute_id = $this->config->item('default_institute_id');

    }

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "banner";
        $this->data['child_menu_type']      = "";
        $this->data['sub_child_menu_type']  = "";

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];

        validate_permissions('Banner', 'index', $this->config->item('method_for_view'), $this->data['institute_id']);
        
        $this->data['data_list']            = $this->banner_model->get_banner_list(array('institute_id' => $this->data['institute_id']));
        // echo "<pre>";
        // print_r($this->data['data_list']);
        // exit();
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/banner/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "banner";
        $this->data['child_menu_type']      = "save_post";
        $this->data['sub_child_menu_type']  = "";
        $this->data['banner_data']          = [];
        $this->data['banner_id']            = $id;

        $this->data['institute_list']       = $this->banner_model->get_all_institute_list();

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
        // echo "<pre>";
        // print_r($this->data);exit();

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Banner', 'edit', $per_action, $this->data['institute_id']);

        if($this->input->post())
        {
            $this->data['banner_data'] = $this->input->post();
        }

        
        //$this->form_validation->set_rules('banner_text', 'Banner', 'required|max_length[250]');      
        //$this->form_validation->set_rules('banner_image', 'Banner Image', 'required');
        $this->form_validation->set_rules('valid_upto', 'Valid Date', 'required');
        $this->form_validation->set_rules('public', 'Public', 'required');

            

        if($this->form_validation->run($this) === TRUE)
        {
            // print_r($this->input->post());
            // echo "<br>------------</br>";
            // exit();
            if($this->input->post())
            {   
                // $path  = './upload_file/banner_images/';
                // $filesnew   = $this->base64_to_image($this->input->post('image'), $path);
                // $image  = isset($filesnew['image']) ? $filesnew['image'] : 'default.png';


                // following code used for image validation and upload image
                $config['upload_path'] = './upload_file/banner_images/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                // $config['max_size'] = 2000;
                // $config['max_width'] = 1024;
                // $config['max_height'] = 450;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('banner_image')) {
                    $error = $this->upload->display_errors();
                    //$this->load->view('cms/banner/form', $error); 
                    $banner_data = $this->input->post();
                    
                    /*if(strip_tags($error) != 'You did not select a file to upload.')
                    {
                        $banner_data['error'] = $error;
                        $this->session->set_flashdata('banner_image', $banner_data);
                        redirect(base_url()."cms/banner/edit/".$id);

                        
                    }*/
                    
                } else {
                    $image_data = array('image_metadata' => $this->upload->data());

                }

                // print_r($image_data);
                // exit();

                $image = isset($image_data['image_metadata']['file_name']) ? $image_data['image_metadata']['file_name'] : '';

                // following code for mobile banner image

                if (!$this->upload->do_upload('mobile_banner_image')) {
                    $error = $this->upload->display_errors();
                    //$banner_data = $this->input->post();
                    
                } else {
                    $mobile_image_data = array('mobile_image_metadata' => $this->upload->data());

                }

                $mobile_image = isset($mobile_image_data['mobile_image_metadata']['file_name']) ? $mobile_image_data['mobile_image_metadata']['file_name'] : '';
                // end mobile banner code

                $selected_institute_ids ='';
                if($this->session->userdata('user_id') == 1 && $this->session->userdata['sess_institute_id'] == 50)
                {
                    
                    if(isset($this->data['banner_data']['institute']) && !empty($this->data['banner_data']['institute']))
                    {
                        $selected_institute_ids = implode(',', $this->data['banner_data']['institute']);
                    }

                }
                else
                {
                    $selected_institute_ids            = $this->data['institute_id']; // this is session institute id
                }

                if($id)
                {   
                    $update['institute_id']            = $selected_institute_ids;
                    $update['banner_text']             = $this->input->post('banner_text');
                    $update['banner_sub_text']         = $this->input->post('banner_sub_text');
                    $update['banner_sub_title']        = $this->input->post('banner_sub_title');
                    $update['banner_alt_text']         = $this->input->post('banner_alt_text');
                    $update['banner_url']              = $this->input->post('banner_url');
                    $update['banner_url_button_text']  = $this->input->post('banner_url_button_text');
                    $update['banner_url_target']       = $this->input->post('banner_url_target');
                    $update['valid_upto']              = $this->input->post('valid_upto');
                    $update['row_order']               = $this->input->post('row_order');
                    $update['public']                  = $this->input->post('public');

                    if(!empty($image))
                    {
                        $update['image']             = $image;
                        //$update['image']               = 'upload_file/banner_images/'.$image; // note: we save all img path because initially save all image path in table.
                    }

                    if(!empty($mobile_image))
                    {
                        $update['mobile_image']        = $mobile_image;
                        //$update['mobile_image']        = 'upload_file/banner_images/'.$mobile_image; // note: we save all img path because initially save all image path in table.
                    }
                    
                    // echo"<pre>";
                    // print_r($update);
                    // echo "<br>update<br>";
                    // exit();
                    $response = $this->banner_model->_update('image_id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $bammer_id                       = $id;
                        $msg = ['error' => 0, 'message' => 'Banner successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['institute_id']            = $selected_institute_ids;
                    $insert['banner_text']             = $this->input->post('banner_text');
                    $insert['banner_sub_text']         = $this->input->post('banner_sub_text');
                    $insert['banner_sub_title']        = $this->input->post('banner_sub_title');
                    $insert['banner_alt_text']         = $this->input->post('banner_alt_text');
                    $insert['banner_url']              = $this->input->post('banner_url');
                    $insert['banner_url_button_text']  = $this->input->post('banner_url_button_text');
                    $insert['banner_url_target']       = $this->input->post('banner_url_target');
                    $insert['valid_upto']              = $this->input->post('valid_upto');
                    $insert['row_order']               = $this->input->post('row_order');
                    $insert['image']                   = $image;
                    $insert['mobile_image']            = $mobile_image;
                    //$insert['image']                   = 'upload_file/banner_images/'.$image; // note: we save all img path because initially save all image path in table.
                    //$insert['mobile_image']            = 'upload_file/banner_images/'.$mobile_image;
                    $insert['public']                  = $this->input->post('public');

                    $insert['created_date']            = date('Y-m-d H:i:s');
                    $insert['user_id']                 = $this->session->userdata['user_id'];
                    // print_r($insert);
                    // echo "<br>insert<br>";
                    // exit();
                    $response                       = $this->banner_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $post_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Banner successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/banner/');
            }
        }

        if($id!='')
        {
            $banner = $this->banner_model->get_banner_list(['image_id' => $id, 'public !=' => '-1']);
            $this->data['banner_data']     = isset($banner[0]) ? $banner[0] : [];
            
            if(empty($this->data['banner_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'banner not found']);
                redirect(base_url()."cms/banner/");
            }
        }

        $this->data['content']              = $this->load->view('cms/banner/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function base64_to_image($image_data='', $path='') {
        $image_name         = '';
        $path               = !empty($path) ? $path : './upload_file/banner_images/';
        
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
        return ['image' => $image_name];
    }

    function deleteimage()
    {
        // echo "hello";
        // exit();
        $deleteid  = $this->input->post('banner_id');
        $update['image']                    = null;
        //$update['updated_date']             = date('Y-m-d H:i:s');
        $update['user_id']                  = $this->session->userdata('user_id');

        $this->banner_model->delete_image($deleteid, $update);
        echo true;

    }

    function delete($id='')
    {
        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
            
        validate_permissions('Banner', 'delete', $this->config->item('method_for_delete'), $this->data['institute_id']);
             
        $banner = $this->banner_model->get_banner_list(['image_id' => $id]);

        if(!empty($banner))
        {
            $response = $this->banner_model->_delete('image_id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Plant not found.']);
        }
        redirect(base_url().'cms/banner/');
    }

    function save_banner_order()
    {   
        $banner_id = $_POST["banner_id_array"];

        // echo "<pre>";
        // print_r($banner_id);
        // exit();

        for($i=0; $i<count($banner_id); $i++)
        { 
            $query=$this->db->query("UPDATE banner_images SET row_order = '".$i."' where image_id = '".$banner_id[$i]."'");
        }
        echo 'Banner Order has been updated';exit();
    }

    function banner_ajax_list()
    {
            $condition      = ['b.public !' => '-1'];
            
            $list               = $this->banner_model->get_banners_data($condition, '', '', '');
            $tabledata          = [];
            $no                 = isset($_GET['offset']) ? $_GET['offset'] : 0;
            //echo "<pre>";print_r($list);exit;

            foreach ($list as $key => $value) {

                if($value->public == 1)
                {
                    $status     = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$value->image_id.', 0);"><div class="label label-default label-form wd-100-px background-green">Active</div></a>';
                }
                else if($value->public == 0)
                {
                    $status     = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$value->image_id.', 1);"><div class="label label-default label-form wd-100-px background-red">In-Active</div></a>';
                }

                $banner_image     = '<img src="'.base_url().'upload_file/banner_images/'.$value->image.'" height="100px" width="100px">';

                $no++;
                $row                    = [];
                $row['sr_no']           = $no;
                $row['image_id']        = $value->image_id;
                $row['banner_text']     = $value->banner_text;
                $row['banner_image']    = $banner_image;
                $row['valid_upto']      = $value->valid_upto;
                $row['row_order']       = $value->row_order;
                $row['status']          = $status;
                
                $edit                                           = '<a data-toggle="tooltip" class="btn btn-sm btn-primary m-r-5" href="'.base_url().'cms/banner/edit/'.$value->image_id.'" title="Edit"><i class="icon-pencil"></i></a>';
                $delete                                         = '<a class="btn btn-sm btn-danger" href="javascript:void(0);" title="Delete" onclick="change_status('.$value->image_id.', -1);"><i class="icon-trash"></i></a>';
                $row['action']                                  = '<div class="wd-130-px m-0-auto">'.$edit.$delete.'</div>';
                
                $tabledata[]                                    = $row;
            }
            //echo "<pre>";print_r($tabledata);exit;
            $output             = array(
                                        "total"      => $this->banner_model->get_banners_data($condition, '', '', 'allcount'),
                                        "rows"       => $tabledata,
                                    );

            //echo "<pre>";print_r($output);exit;
            echo json_encode($output);
        
    }

    function banner_change_status($id='', $status='')
    {
        //validate_permissions('Somaiya_general_admin', 'deleteuser', $this->config->item('method_for_delete'), $this->default_institute_id);

        
        $error      = 1;
        $message    = 'Invalid request';
        if($id)
        {
            $details = $this->banner_model->get_banner_details($id);

            if(!empty($details))
            {
                if($status == -1)
                {
                    $message = 'deleted';
                }
                else if($status == 1)
                {
                    $message = 'activated';
                }
                else if($status == 0)
                {
                    $message = 'in-activated';
                }

                if($this->banner_model->change_banner_status($id, $status))
                {
                    $error      = 0;
                    $message    = 'Banner successfully '.$message;
                }
                else
                {
                    $error      = 1;
                    $message    = 'Unable to perform this action';
                }
            }
            else
            {
                $error      = 1;
                $message    = 'No user found';
            }
        }
        $this->session->set_flashdata('status', ['error' => $error, 'message' => $message]);
        redirect(base_url().'cms/banner/');
    }

    function get_banner_institute_options()
    {
        $options        = '<option value="">-- Select Institute --</option>';
        $institute_list  = $this->banner_model->get_all_institute_list();

            if(!empty($institute_list))
            {
                foreach ($institute_list as $key => $value) {
                    $selected           = '';
                    $options            .= '<option value="'.$value['INST_ID'].'" '.$selected.'>'.$value['INST_NAME'].'</option>';
                }
            }

            echo json_encode($options);exit;

    }

    function deletemobileimage()
    {
        $deleteid  = $this->input->post('banner_id');
        $update['mobile_image']            = null;
        //$update['updated_date']          = date('Y-m-d H:i:s');
        $update['user_id']                 = $this->session->userdata('user_id');

        $this->banner_model->delete_image($deleteid, $update);
        echo true;

    }

}