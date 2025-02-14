<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Gallery_inst_type extends Somaiya_Controller
{
     function __construct()
    {
    

        parent::__construct('backend');
        $this->load->model('cms/gallery/Gallery_inst_type_model', 'Gallery_inst_type_model');
        $user_id = $this->session->userdata['user_id'];
        $this->default_institute_id = $this->config->item('default_institute_id');
       
    }

 function index()
    {
        $this->data['main_menu_type'] = "masters";
        $this->data['sub_menu_type'] = "galleries";
        $this->data['child_menu_type'] = "institute_gallery_types";
        $this->data['sub_child_menu_type'] = "";

        validate_permissions('Gallery_inst_type', 'index', $this->config->item('method_for_view'), $this->default_institute_id);

        $this->data['data_list']=$this->Gallery_inst_type_model->get_instgaltype();
        $this->data['title'] = _l("Gallery Type",$this);
        $this->data['page'] = "index";
        $this->data['content']=$this->load->view('cms/gallery/index_inst_type',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);  

    }


   function edit($id='')
    {
        $this->data['main_menu_type'] = "masters";
        $this->data['sub_menu_type'] = "galleries";
        $this->data['child_menu_type'] = "gallery_inst_type";
        $this->data['sub_child_menu_type'] = "";
        $allowed_inst_ids          = [];
        $save_data                 = [];
        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('gallery_inst_type', 'edit', $per_action);
        $status      =-1;
        $this->data['type_list'] = $this->Gallery_inst_type_model->get_galtype();
        $this->data['institutes_list'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->data['title']                = 'gallery_inst_type';
        $this->data['page']                 = 'gallery_inst_type';
        $this->data['data']                 = [];
        $this->data['id']      = $id;
        $this->data['data']['public']       = 1;
      
        if($id)
        {
             $this->data['data']=$this->Gallery_inst_type_model->get_instgaltype_detail($id);
            if(empty($this->data['data']))
            {
                $this->session->set_flashdata('requeststatus',['error'=>1,'message'=>'Institute Gallery Type  not found']);
                redirect(base_url().'cms/index_inst_type');
            } 
        }  
        if($this->input->post())
        {
            $this->data['data']= $this->input->post();

        }
       
        $this->form_validation->set_rules('data[institute_id]', 'data[institute_id]', 'required|max_length[250]');
        if($this->form_validation->run($this) === TRUE)
        { 
            if($this->input->post())
            {   

                $institute = $this->input->post('data[institute_id]');
                $type_id = $this->input->post('data[type_id][]');
                $type_id2 = implode(',', $type_id);
                if($id)
                {
                     $update['institute_galleries_type']['institute_id']    = $institute;
                     $update['institute_galleries_type']['type_id']           = $type_id2;
                     $update['institute_galleries_type']['public']             = $this->input->post('public');
                     $update['institute_galleries_type']['modified_on']      = date('Y-m-d H:i:s');
                     $update['institute_galleries_type']['modified_by']      = $this->session->userdata['user_id'];
                     $condition                                          = array('ig_id' => $id);
                    $response = $this->Gallery_inst_type_model->_update($condition, $update);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Gallery Type  successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['institute_galleries_type']['institute_id']    = $institute;
                    $insert['institute_galleries_type']['type_id']           = $type_id2;
                    $insert['institute_galleries_type']['public']             = $this->input->post('public');
                    $insert['institute_galleries_type']['created_on']         = date('Y-m-d H:i:s');
                    $insert['institute_galleries_type']['created_by']         = $this->session->userdata['user_id'];
                    $insert['institute_galleries_type']['modified_on']        = date('Y-m-d H:i:s');
                    $insert['institute_galleries_type']['modified_by']        = $this->session->userdata['user_id'];
                
                    $response   = $this->Gallery_inst_type_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $post_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Gallery Type successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }

                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/gallery_inst_type');
            }//end post
          //  end validations
        }
     
         $this->data['content'] = $this->load->view('cms/gallery/form_inst_type',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data); 


    }


    function delete($id='')
    {
      
        validate_permissions('Gallery_inst_type', 'delete', $this->config->item('method_for_delete'), $this->default_institute_id);

        if($this->Gallery_inst_type_model->count_gallery_image(array("data_type"=>"institute_galleries_type","relation_id"=>$id))==0)
        {
            $this->db->trans_start();
            $this->db->delete('gallery', array('relation_id' => $id,"data_type"=>"institute_galleries_type"));
            $this->db->delete('institute_galleries_type ', array('ig_id' => $id));
            $this->db->trans_complete();
            $this->session->set_flashdata('success', _l('Deleted instgaltype',$this));

        }else{
            $this->session->set_flashdata('error', _l('You should first delete galleries.',$this));
        }
        redirect(base_url()."cms/gallery_inst_type/");
    }

    function check_institute_by_type_exit()
    {
        //echo "hello";exit();
        if (!$this->input->is_ajax_request())
        {
            //echo "cant access url directly";  
            show_404(); // Output "Page not found" error.
            exit();
        }

        if(!empty($this->input->post()))
        {
            $institute_id = $this->input->post('institute_id');
            $institute_type_rel_id = $this->input->post('institute_type_rel_id');
            $count = $this->Gallery_inst_type_model->check_institute_by_type_exit($institute_id, $institute_type_rel_id);
            
            echo $count;
            
            // if($count == 0)
            // {
            //     $result = "true";
            // }
            // else
            // {
            //     $result = "false";
            // }

            // echo $result;
        }
    }
}

?>                             