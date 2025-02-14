<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Category_testimonial extends Somaiya_Controller
{
     function __construct()
    {
    

          parent::__construct('backend');
        $this->load->model('cms/testimonial/Category_testimonial_model', 'Category_testimonial_model');
        $user_id = $this->session->userdata['user_id'];
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $default_institute_id = $this->config->item('default_institute_id');
    }

 function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "testimonial";
        $this->data['child_menu_type']      = "testimonial";
        $this->data['sub_child_menu_type']  = "testimonialcat";
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
        $inst_id  = $instituteID ? $instituteID : $default_institute_id;
        $public   =-1;
        validate_permissions('Category_testimonial', 'index', $this->config->item('method_for_view'), $inst_id);
        $this->data['data_list']    = $this->Category_testimonial_model->get_Category($inst_id,$public);
        $this->data['title']        = 'testimonialcat';
        $this->data['page']         = 'testimonialcat';
        $this->data['content']      = $this->load->view('cms/testimonial/index_category',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);

    }


   function edit($id='')
    {

        $this->data['main_menu_type']      = "institute_menu";
        $this->data['sub_menu_type']       = "testimonial";
        $this->data['child_menu_type']     = "testimonial";
        $this->data['sub_child_menu_type'] = "testimonialcat";
        $allowed_inst_ids          = [];
        $save_data                 = [];
        $instituteID               = $this->session->userdata('sess_institute_id');
        $inst_id    = isset($instituteID) ? $instituteID : $default_institute_id;
        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Category_testimonial', 'edit', $per_action, $inst_id);
        $status      =-1;
        $this->data['title']                = 'testimonialcat';
        $this->data['page']                 = 'testimonialcat';
        $this->data['data']                 = [];
        $this->data['pressrelease_id']      = $id;
        $this->data['data']['public']       = 1;
      
        if($id)
        {
            $this->data['data']= $this->Category_testimonial_model->get_category_details($id,$inst_id,$status);
            if(empty($this->data['data']))
            {
          $this->session->set_flashdata('requeststatus',['error'=>1,'message'=>'Testimonial Category not found'.$inst_id]);
          redirect(base_url().'cms/category_testimonial');
            } 
        }  
        if($this->input->post())
        {
            $this->data['data']= $this->input->post();
        }
        $this->form_validation->set_rules('name', 'Name', 'required|max_length[250]');
        if($this->form_validation->run($this) === TRUE)
        { 
            if($this->input->post())
            {   
                if($id)
                {
                     $update['testimonial_category']['category_name']    = $this->input->post('name');
                     $update['testimonial_category']['status']           = $this->input->post('status');
                     $update['testimonial_category']['modified_on']      = date('Y-m-d H:i:s');
                     $update['testimonial_category']['modified_by']      = $this->session->userdata['user_id'];
                     $condition                                          = array('id' => $id, 'institute_id'=>$inst_id  );
                    $response = $this->Category_testimonial_model->_update($condition, $update);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Testimonial Category  successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['testimonial_category']['category_name']      = $this->input->post('name');
                    $insert['testimonial_category']['institute_id']       = $inst_id ;
                    $insert['testimonial_category']['status']             = $this->input->post('status');
                    $insert['testimonial_category']['created_on']         = date('Y-m-d H:i:s');
                    $insert['testimonial_category']['created_by']         = $this->session->userdata['user_id'];
                    $insert['testimonial_category']['modified_on']        = date('Y-m-d H:i:s');
                    $insert['testimonial_category']['modified_by']        = $this->session->userdata['user_id'];
                    $response   = $this->Category_testimonial_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $post_id           = $response['id'];
                        $msg = ['error' => 0, 'message' => 'Testimonial Category successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }

                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/category_testimonial');
            }//end post
          //  end validations
        }
     
         $this->data['content'] = $this->load->view('cms/testimonial/form_category',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data); 
    }

//delete start here

    function delete($id='')
    {
        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
        validate_permissions('Category_testimonial','delete',$this->config->item('method_for_delete'),$this->data['institute_id']);
        $public     =-1;
        $condition  = array('id' => $id, 'institute_id'=>$this->data['institute_id']   );
        $post=$this->Category_testimonial_model->get_category_details($id,$this->data['institute_id'], $public);

        if(!empty($post))
        {
        $response = $this->Category_testimonial_model->_delete($condition);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
        $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Testimonial Category not found.']);
        }
            redirect(base_url().'cms/category_testimonial');
    }
}


?>