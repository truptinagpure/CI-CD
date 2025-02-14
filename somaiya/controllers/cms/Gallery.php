<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Gallery extends Somaiya_Controller
{
     function __construct()
    {
    

          parent::__construct('backend');
          $this->load->model('cms/gallery/Gallery_model', 'Gallery_model');
          $user_id = $this->session->userdata['user_id'];
          $this->default_institute_id = $this->config->item('default_institute_id');
    }

 function index($id='')
    {

         
        $abc = $_SESSION['sess_institute_id'];
        $this->data['main_menu_type'] = "masters";
        $this->data['sub_menu_type'] = "galleries";
        $this->data['child_menu_type'] = "galleries";
        $this->data['sub_child_menu_type'] = "";

        validate_permissions('Gallery', 'view', $this->config->item('method_for_view'), $this->default_institute_id);

        $this->data['page'] = "View Gallery";
        $this->data['view_data']= $this->Gallery_model->view_data($abc);
        $this->data['content']= $this->load->view('cms/gallery/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);

    }


   function edit($id='')
    {


        $this->data['main_menu_type']      = "master";
        $this->data['sub_menu_type']       = "Gallery";
        $this->data['child_menu_type']     = "Gallery";
        $this->data['sub_child_menu_type'] = "Gallery";
        $abc = $_SESSION['sess_institute_id'];

        $this->data['title'] = _l("Gallery",$this);
        $this->data['data']                 = [];
        $this->data['page'] = "Gallery";
        $this->data['institute'] =          $this->Somaiya_general_admin_model->get_all_institute();
        $this->data['type'] = $this->Gallery_model->get_institutegaltype();
        $this->data['gallerytype']  =       $this->Gallery_model->get_gallerytype($abc);
        $this->data['g_id']=$id;
    
        if($id)
        {
            $this->data['data']= $this->Gallery_model->get_galdata($id);
            $this->data['gallery_data_image']= $this->Gallery_model->get_data_image($id);
            if(empty($this->data['data']))
            {
                $this->session->set_flashdata('requeststatus',['error'=>1,'message'=>' Gallery data not found'.$inst_id]);
                redirect(base_url().'cms/gallery');
            } 
        }  
        if($this->input->post())
        {

            $this->data['data']= $this->input->post();
        }
        $this->form_validation->set_rules('title', 'Title', 'required|max_length[250]');
        if($this->form_validation->run($this) === TRUE)
        { 
            if($this->input->post())
            {   



                $folderName = $_POST['name'];
                $pathToUpload = './upload_file/images20/' . $folderName;
                $images2 = array();
                /*
                // comment feature image code

                if(isset($_FILES['featured']['name']) && !empty($_FILES['featured']['name']))
                {
                    if ( ! file_exists($pathToUpload) )
                    {
                    $create = mkdir($pathToUpload);
                    chmod("$pathToUpload", 0777);
                    }
                    $files = $_FILES;
                    $fimg = count($_FILES['featured']['name']);
                    if ($fimg !== "") 
                    {// echo "In Featured Image";
                    $config22['upload_path'] = $pathToUpload;
                    $config22['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config22['max_size'] = '8000000';
                    $config22['remove_spaces'] = true;
                    $config22['overwrite'] = false;
                    $config22['max_width'] = '';
                    $config22['max_height'] = '';
                    $fileNamefeatured12 = $_FILES['featured']['name'];
                    $fileNamefeatured = str_replace(' ', '_', $fileNamefeatured12);
                    $images2[] = $fileNamefeatured;
                    $this->load->library('upload', $config22);
                    $this->upload->initialize($config22);
                    $this->upload->do_upload();
                    if ( ! $this->upload->do_upload('featured'))
                    {
                    $error = array('error' => $this->upload->display_errors());
                    redirect('cms/gallery/');
                    }
                    else
                    {
                    //echo "Success";
                    }     
                    }
                }*/
                    
                    $all_existing_image_array = array();

                    if(isset($_POST['existing_image_id']))
                    {
                        $gal_image_id = $_POST['existing_image_id'];
                        $gal_image_name = $_POST['existing_image_name'];
                        $gal_image_description = $_POST['existing_image_description'];

                        
                        foreach ( $gal_image_id as $idx => $val ) {
                            //$all_existing_image_array[] = [ $val, $gal_image_name[$idx], $gal_image_description[$idx] ];
                            $all_existing_image_array[] = [
                                                'image_id' => $val,
                                                'image_name' => $gal_image_name[$idx],
                                                'image_description' => $gal_image_description[$idx],
                                            ];
                        }
                    }
                    

                    $images = [];
                    $imagedata = [];

                if(isset($_POST['images']))
                {
                    if ( ! file_exists($pathToUpload) )
                    {
                    $create = mkdir($pathToUpload);
                    chmod("$pathToUpload", 0777);
                    }
                $this->load->library('customlib');
                foreach ($_POST['images'] as $key => $value)
                {
                $image = $this->customlib->base64_image_upload($value, $pathToUpload);
                $images['image'] = $image;
                $images['name'] = $_POST['image_name'][$key];
                $images['description'] = $_POST['image_description'][$key];
                $imagedata[] = $images;  
                }
                }


                $fileNamefeatured = "";

                if(isset($images2))
                {
                    $fileNamefeatured = implode(',',$images2);    
                }            

                if($id)
                {
                    $gallery_data                   = [];
        $gallery_data['gallery_for']    = $this->input->post('gallery_for');
        $gallery_data['type_id']        = $this->input->post('type_id');
        $gallery_data['name']           = $this->input->post('name');
        $gallery_data['title']          = $this->input->post('title');
        $gallery_data['date']           = $this->input->post('date');
        if($fileNamefeatured)
        {
            $gallery_data['featured_img']   = $fileNamefeatured;
        }
        $gallery_data['public']         = $this->input->post('public');
            
          $response =$this->Gallery_model->update_upload_image($id,$gallery_data,$imagedata,$fileNamefeatured,$all_existing_image_array);
        if(isset($response['status']) && $response['status'] == 'success')
                    {

                        $post_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Gallery successfully Updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                
                $this->session->set_flashdata('requeststatus', $msg);
               
                redirect(base_url().'cms/gallery/');
                }
                else
                {
                   
                      $gallery_data                   = [];
        $gallery_data['gallery_for']    = $this->input->post('gallery_for');
        $gallery_data['type_id']        = $this->input->post('type_id');
        $gallery_data['name']           = $this->input->post('name');
        $gallery_data['title']          = $this->input->post('title');
        $gallery_data['date']           = $this->input->post('date');
        $gallery_data['featured_img']   = $fileNamefeatured;
        $gallery_data['public']         = $this->input->post('public');

        $response =  $this->Gallery_model->upload_image($gallery_data,$imagedata,$fileNamefeatured);

           if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $post_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Gallery successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/gallery/');
                }

               
            }//end post
          //  end validations
        }
     
         $this->data['content'] = $this->load->view('cms/gallery/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data); 
    }

//delete start here

   function delete($id='')
    {
      
        validate_permissions('Gallery', 'delete', $this->config->item('method_for_delete'));
        $this->db->trans_start();
        $this->db->delete('photos', array('g_id' => $id));
        $this->db->delete('galleries', array('g_id' => $id));
        $response= $this->db->trans_complete();
        //print_r($response);exit();
          if(isset($response) && $response == '1')
                    {
                        //$post_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Gallery data successfully deleted'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                
                $this->session->set_flashdata('requeststatus', $msg);
        redirect('cms/gallery');
    }

     function deleteimage()
    {
        $deleteid  = $this->input->post('image_id');
        $this->db->delete('photos', array('id' => $deleteid));
        $verify = $this->db->affected_rows();
        echo $verify;
    }

    function deletefeaimage()
    {
        $deleteid  = $this->input->post('image_id');
        $this->db->where('g_id', $deleteid);
        $this->db->update('galleries', array('featured_img' => ''));
        $verify = $this->db->affected_rows();
        echo $verify;
    }
}


?>