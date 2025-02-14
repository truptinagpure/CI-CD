<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Testimonial extends Somaiya_Controller
{
    private $default_institute_id;

    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/testimonial/Testimonial_model', 'testimonial_model');
        $user_id = $this->session->userdata['user_id'];
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $default_institute_id = $this->config->item('default_institute_id');
     }

 function index()
    {
        $this->data['main_menu_type']        = "institute_menu";
        $this->data['sub_menu_type']         = "testimonial";
        $this->data['child_menu_type']       = "testimonial";
        $this->data['sub_child_menu_type']   = "testimonial";
        //session data
        $instituteID  = $this->session->userdata('sess_institute_id');
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
        $inst_id = $instituteID ? $instituteID : $default_institute_id;
        $public=-1;
        validate_permissions('Testimonial', 'index', $this->config->item('method_for_view'), $inst_id);

        $this->data['data_list']            = $this->testimonial_model->get_all_Testimonial($inst_id,$public);
        $this->data['title']                = 'testimonial';
        $this->data['page']                 = 'testimonial';
        $this->data['content']              = $this->load->view('cms/testimonial/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);

    }



   function edit($id='')
    {
        $this->data['main_menu_type']         = "institute_menu";
        $this->data['sub_menu_type']          = "testimonial";
        $this->data['child_menu_type']        = "testimonial";
        $this->data['sub_child_menu_type']    = "testimonial";
        $allowed_inst_ids           = [];
        $save_data                  = [];
 		$instituteID                = $this->session->userdata('sess_institute_id');
        $inst_id                    = isset($instituteID) ? $instituteID : $default_institute_id;
        $per_action                 = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Testimonial', 'edit', $per_action, $inst_id);
        $public=1;
        $titles = array();
        $data_titles = $this->Somaiya_general_admin_model->get_all_titles("testimonial",$id);
        $this->data['category'] = $this->testimonial_model->get_all_Testimonial_category($inst_id ,$public);
        if(count($data_titles)!=0)
            {
            foreach ($data_titles as $value) 
                {
                 $titles[$value["language_id"]] = $value;
                }
            }
        $this->data['titles']               = $titles;
        $this->data['title']                = 'testimonial';
        $this->data['page']                 = 'testimonial';
        $this->data['data']                 = [];
        $this->data['testimonial_id']       = $id;
        $this->data['data']['public']       = 1;
        if($id)
        {
            $public=-1;
             $this->data['data']    = $this->testimonial_model->get_testimonial_details($id,$inst_id,$public);
            if(empty($this->data['data']))
            {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Testimonial  not found'.$inst_id]);
            redirect(base_url().'cms/testimonial/');
            }
        }  
        if($this->input->post())
        {
            $this->data['data']     = $this->input->post();
        }
        $this->form_validation->set_rules('name', 'Name', 'required|max_length[250]');
        $this->form_validation->set_rules('category_id', 'Category_id', 'required');

        if($this->form_validation->run($this) === TRUE)
        { 
            if($this->input->post())
                {   
                    $status='';
                    $config['upload_path']      = './upload_file/kjsieit/testimonial/';
                    $config['allowed_types']    = 'gif|jpg|png|svg|wmv|mp4|avi|mov|mp3';
                     $config['max_size'] = 0;
                    $config['max_width']        = 1500;
                    $config['max_height']       = 1500;
                    $config['file_name']        = $_FILES['upload_image']['name'];
                    $this->load->library('upload', $config);
                    $uploadData                 = $this->upload->data();
                    $filename                   = $uploadData['file_name'];
                    $filename1                  = str_replace(' ', '_', $filename);
                  //   $vedio_url='';
                      if (!$this->upload->do_upload('upload_image')) 
                      {
                        $error  =array('error' => $this->upload->display_errors());
                        $status =0;
                      } 
                      else 
                      {
                        $data   = array('image_metadata' => $this->upload->data());
                        $status =1;
                      }
$ext = pathinfo($filename1, PATHINFO_EXTENSION);
 /*$v_url=$this->input->post('video_url');
                      if(isset($v_url) && !empty($v_url))
                      {
                       
                        $filename1=$this->input->post('video_url');
                      }
*/
                 
                     if($id)
                  
                    {
                        $update['testimonials']['name']            = $this->input->post('name');
                        $update['testimonials']['institute_id']    = $inst_id ;
                        /*$update['testimonials']['image']           = $filename1 ;//$this->input->post('upload_image');
                         $update['testimonials']['ext']           = $ext ;*/
                       //   $update['testimonials']['video_url']     = $this->input->post('video_url');
                        $update['testimonials']['embed_code']     = $this->input->post('embed_code');
                        $update['testimonials']['description']     = $this->input->post('description');
                        $update['testimonials']['testimonial_type']          = $this->input->post('testimonial_type');
                        $update['testimonials']['batch']           = $this->input->post('batch');
                         $update['testimonials']['designation']           = $this->input->post('designation');
                        $update['testimonials']['category_id']     = $this->input->post('category_id');
                        $update['testimonials']['status']          = $this->input->post('status');
                        $update['testimonials']['modified_on']     = date('Y-m-d H:i:s');
                        $update['testimonials']['modified_by']     = $this->session->userdata['user_id'];
                        $condition                                 = array('id' => $id, 'institute_id'=>$inst_id  );
                        $response = $this->testimonial_model->_update($condition, $update,$ext,$filename1);

                           if(isset($response['status']) && $response['status'] == 'success')
                                 {
                                     //$post_id           = $response['col'];
                                   $msg = ['error' => 0, 'message' => 'Testimonial successfully updated'];
                                 }
                            else
                                {
                                    $msg = ['error' => 0, 'message' => $response['message']];
                                }
                    }
                    else
                    {
                    $insert['testimonials']['name']                         = $this->input->post('name');
                    $insert['testimonials']['image']                        =$filename1;
                    $insert['testimonials']['ext']           = $ext ;
                   // $insert['testimonials']['video_url']     = $this->input->post('video_url');
                    $insert['testimonials']['embed_code']     = $this->input->post('embed_code');
                    $insert['testimonials']['institute_id']                 = $inst_id ;
                    $insert['testimonials']['description']                  = $this->input->post('description');
                    $insert['testimonials']['testimonial_type']          = $this->input->post('testimonial_type');
                    $insert['testimonials']['batch']                        = $this->input->post('batch');
                    $insert['testimonials']['designation']                        = $this->input->post('designation');
                    $insert['testimonials']['category_id']                  = $this->input->post('category_id');
                    $insert['testimonials']['status']                       = $this->input->post('status');
                    $insert['testimonials']['created_on']                   = date('Y-m-d H:i:s');
                    $insert['testimonials']['created_by']                   = $this->session->userdata['user_id'];
                    $insert['testimonials']['modified_on']                  = date('Y-m-d H:i:s');
                    $insert['testimonials']['modified_by']                  = $this->session->userdata['user_id'];
                   
                    $response  = $this->testimonial_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                         {
                            $post_id           = $response['id'];
                            $msg = ['error' => 0, 'message' => 'Testimonial successfully added'];
                         }
                    else
                         {
                            $msg = ['error' => 0, 'message' => $response['message']];
                         }
                    }
                 $this->session->set_flashdata('requeststatus', $msg);
                 redirect(base_url().'cms/testimonial');
            }//end post
          //  end validations
        }
             $this->data['content'] = $this->load->view('cms/testimonial/form',$this->data,true);
             $this->load->view($this->mainTemplate,$this->data); 
    }

//start here

    function deletefeaimage($id=0)
    {
        $this->db->where('id', $id);
        $response =  $this->db->update('testimonials', array('image' => '','ext'=>''));

        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        redirect(base_url().'cms/testimonial/edit/'.$id);
    }
    function delete($id='')
    {
        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
         validate_permissions('Testimonial', 'delete', $this->config->item('method_for_delete'), $this->data['institute_id']);
        $public    =-1;
        $condition = array('id' => $id, 'institute_id'=>$this->data['institute_id']   );
        $post      = $this->testimonial_model->get_testimonial_details($id,$this->data['institute_id'], $public);

        if(!empty($post))
        {
        $response = $this->testimonial_model->_delete($condition);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Testimonial  not found.']);
        }
            redirect(base_url().'cms/testimonial/');
    }
   

}


?>