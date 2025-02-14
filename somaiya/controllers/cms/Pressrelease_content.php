<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pressrelease_content extends Somaiya_Controller
{
    private $default_institute_id;

    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/pressrelease/Pressrelease_model', 'pressrelease_model');
        $this->load->model('cms/pressrelease/Pressrelease_content_model', 'pressrelease_content_model');
        $this->load->model('cms/Somaiya_general_admin_model', 'Somaiya_general_admin_model');
        $this->load->model('cms/Category_model', 'category_model');
        $user_id = $this->session->userdata['user_id'];
        $default_institute_id = $this->config->item('default_institute_id');
       
    }

 function index()
    { exit();
    }
 
    function pressreleasecontents($id='')
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "news_media";
        $this->data['child_menu_type']      = "press_release";
        $this->data['sub_child_menu_type']  = "";
        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
       validate_permissions('Pressrelease_content', 'index', $this->config->item('method_for_view'), $this->data['institute_id']);
        $contents = $this->pressrelease_content_model->get_pressrelease_contents($id);
        if(!empty($contents))
        {   
         $this->data['institutes_details']= $this->Somaiya_general_admin_model->get_institute_detail($this->session->userdata('sess_institute_id'));
            $this->data['data_list']            = $contents;
            $this->data['title']                = _l("pressrelease content", $this);
            $this->data['page']                 = "pressreleasecontents";
            $this->data['relation_id']          = $id;
            $this->data['content'] = $this->load->view('cms/pressrelease/index_contents',$this->data,true);
            $this->load->view($this->mainTemplate,$this->data);
        }
        else
        {
           $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'No pressrelease content found']);
           redirect(base_url().'cms/pressrelease/');
        }



    }

//start here


    function get_pressreleases($id='', $conditions=[], $order_by='')
    {
        $sql = 'SELECT pl.* FROM pressrelease pl WHERE 1=1';
        foreach ($conditions as $key => $value) {
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


    function edit($pressrelease_id='', $contents_id='')
    {
        $this->data['main_menu_type']        = "institute_menu";
        $this->data['sub_menu_type']         = "news_media";
        $this->data['child_menu_type']       = "press_release";
        $this->data['sub_child_menu_type']   = "";

        $pressreleasedata = $this->get_pressreleases($pressrelease_id);
        if(!empty($pressreleasedata))
        {
            $this->data['title']                    = _l("pressreleasecontents", $this);
            $this->data['page']                     = "pressreleasecontents";
            $this->data['data']                     = [];
            $this->data['contents_id']              = $contents_id;
            $this->data['relation_id']              = $pressrelease_id;
            $this->data['data']['public']           = 1;
            $this->data['languages']                = $this->Somaiya_general_admin_model->get_all_language();
            $this->data['institutes_details']       = $this->Somaiya_general_admin_model->get_institute_detail($_SESSION['inst_id']);

            if($contents_id)
            {
                $pressreleasedata = $this->pressrelease_content_model->get_pressrelease_contents($pressrelease_id);
                $this->data['data'] = isset($pressreleasedata[0]) ? $pressreleasedata[0] : [];
                if(empty($this->data['data']))
                { 
                    $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Pressrelease content not found']);
                    redirect(base_url().'cms/pressrelease/edit/'.$pressrelease_id);
                }
            }

            if($this->input->post())
            {
                $this->data['data'] = $this->input->post();
            }

            $this->form_validation->set_rules('title', 'Title', 'required|max_length[250]');
            $this->form_validation->set_rules('public', 'Public', '');
            $this->form_validation->set_rules('category_id', 'Category_id', '');
            $this->form_validation->set_rules('public', 'Public', '');
            if($this->form_validation->run($this) === TRUE)
            {
                if($this->input->post())
                {
                    $this->common_model->set_table('contentspressrelease');
                    if($contents_id)
                    {
                        $update['title']            = $this->input->post('title');
                        $update['language_id']      = $this->input->post('language_id');
                        $update['description']      = $this->input->post('description');
                        $update['persons']          = $this->input->post('persons');
                        $update['public']           = $this->input->post('public');
                        $update['updated_date']     = date('Y-m-d H:i:s');
                        $update['user_id']          = $this->session->userdata['user_id'];

                        $response = $this->pressrelease_content_model-> save($pressrelease_id, $contents_id, $update);
                         if(isset($response['status']) && $response['status'] == 'success')
                        {
                            $msg = ['error' => 0, 'message' => 'Pressrelease content successfully updated'];
                        }
                        else
                        {
                            $msg = ['error' => 0, 'message' => $response['message']];
                        }
                    }
                    else
                    {
                        $insert['title']            = $this->input->post('title');
                        $insert['description']      = $this->input->post('description');
                        $insert['relation_id']      = $pressrelease_id;
                        $insert['language_id']      = $this->input->post('language_id');
                        $insert['public']           = $this->input->post('public');
                        $insert['persons']          = $this->input->post('persons');
                        $insert['data_type']        = $this->input->post('data_type');
                        $insert['created_date']     = date('Y-m-d H:i:s');
                        $insert['updated_date']     = date('Y-m-d H:i:s');
                        $insert['user_id']          = $this->session->userdata['user_id'];
                        $response = $this->pressrelease_content_model-> save($pressrelease_id, $contents_id, $insert);
                     //   $response = $this->common_model->_insert($insert);
                        if(isset($response['status']) && $response['status'] == 'success')
                        {
                            $msg = ['error' => 0, 'message' => 'Pressrelease content successfully added'];
                        }
                        else
                        {
                            $msg = ['error' => 0, 'message' => $response['message']];
                        }
                    }
                    $this->session->set_flashdata('requeststatus', $msg);
                    redirect(base_url().'cms/pressrelease_content/pressreleasecontents/'.$pressrelease_id);
                }
            }//here

             $this->data['content']= $this->load->view('cms/pressrelease/form_contents',$this->data,true);
             $this->load->view($this->mainTemplate,$this->data);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'No Pressrelease found']);
            redirect(base_url().'cms/pressrelease');
        }
    }

   /* */

    function delete($pressrelease_id='', $contents_id='', $language_id='')
    {   
        if($language_id != 1)
        {
        $response = $this->pressrelease_content_model->_delete($pressrelease_id, $contents_id);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        redirect(base_url().'cms/pressrelease_content/pressreleasecontents/'.$pressrelease_id);
        }
        else
        {
            $this->session->set_flashdata('requeststatus',['error'=> 1,'message' =>'You can not delete default pressrelease content']);
            redirect(base_url().'cms/pressrelease_content/pressreleasecontents/'.$pressrelease_id);
        }
    }


}


?>