<?php
/**
 * Created by Somaiya Team.
 * User: Somaiya
 * Date: 10/05/2018
 * Time: 2:22 PM
 * Project: Somaiya Vidyavihar
 * Website: https://www.somaiya.edu
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Career extends Somaiya_Controller {
    private $permissions;
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/career/Career_model', 'career');
        $user_id = $this->session->userdata['user_id'];
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "career";
        $this->data['child_menu_type']      = "career";
        $this->data['sub_child_menu_type']  = "career";
        $instituteID               = $this->session->userdata('sess_institute_id');
        $inst_id  = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Career', 'index', $this->config->item('method_for_view'), $inst_id);
        $this->data['data_list']    = $this->career->get_career(['f.institute_id' => $instituteID]);
        $this->data['title']        = 'jobcat';
        $this->data['page']         = 'jobcat';
        $this->data['content']      = $this->load->view('cms/career/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);

    }

    function edit($id='')
    {   
        error_reporting(0);
        $this->data['title']                = 'Career';
        $this->data['module']               = 'Career';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "career";
        $this->data['child_menu_type']      = "career";
        $this->data['sub_child_menu_type']  = "save_career";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        $this->data['post_data']['status']  = 1;
        
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        $per_action                         = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Career', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        $career_documents = $_POST["career_documents"];

        $this->form_validation->set_rules('job_name', 'Job Name', 'required|max_length[250]');
        $this->form_validation->set_rules('status', 'Status', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                $response = $this->career->manage_career($this->input->post(), $id,$career_documents,$instituteID);
                if(isset($response['status']) && $response['status'] == 'success')
                {
                    $msg = ['error' => 0, 'message' => 'Job successfully added'];
                }
                else
                {
                    $msg = ['error' => 0, 'message' => $response['message']];
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/career/');
            }
        }

        if($id!='')
        {
            $career                         = $this->career->get_career(['f.id' => $id, 'f.status !=' => '-1']);
            $this->data['post_data']        = isset($career[0]) ? $career[0] : [];
            
            if(empty($this->data['post_data']))
            {   
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Job not found']);
                redirect(base_url()."cms/career/");
            }
        }

        $this->data['email']            = $this->career->get_email($instituteID);
        $this->data['category']         = $this->career->get_career_category($instituteID);
        $this->data['department']       = $this->career->get_department();
        $this->data['career_documents'] = $this->career->document_upload($id);
        $this->data['content']          = $this->load->view('cms/career/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function career_documents($relation_id='')
    {
        sleep(3);
        if($_FILES["files"]["name"] != '')
        {
            $output = '';
            $config["upload_path"] = './assets/career_upload/';
            $config["allowed_types"] = 'gif|jpg|png|pdf|doc|docx';
            $config['max_size'] = '2000';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            for($count = 0; $count<count($_FILES["files"]["name"]); $count++)
            {
                $_FILES["file"]["name"] = $_FILES["files"]["name"][$count];
                $_FILES["file"]["type"] = $_FILES["files"]["type"][$count];
                $_FILES["file"]["tmp_name"] = $_FILES["files"]["tmp_name"][$count];
                $_FILES["file"]["error"] = $_FILES["files"]["error"][$count];
                $_FILES["file"]["size"] = $_FILES["files"]["size"][$count];

                if ( ! $this->upload->do_upload('file')  && $_FILES['file']['size'] > 2000)
                {   
                        echo "<div class='alert alert-danger'>Max 2MB file is allowed.</div>";
                }
                else
                {   
                    $data = $this->upload->data();
                    $output .= '
                     <div class="col-md-3">
                      <img src="'.base_url().'assets/career_upload/'.$data["file_name"].'" class="img-responsive img-thumbnail" />
                      <input type="hidden" name="career_documents[]" value="'.$data["file_name"].'">
                     </div>
                    ';
                }
            }
           $data["file_name"] = array();
           $fileNamefeatured = implode(',', $data["file_name"]);
           echo $output;
        }
    }

    function delete($id='')
    {
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Career', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $career                          = $this->career->get_career(['f.id' => $id, 'f.status !=' => '-1']);

        if(!empty($career))
        {
            $this->common_model->set_table('career');
            $response = $this->common_model->_delete('id', $id);

            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Career not found.']);
        }
        redirect(base_url().'cms/career');
    }

    function deletedocument()
    {
        $deleteid  = $this->input->post('image_id');
        $this->db->delete('career_documents', array('doc_id' => $deleteid));
        $verify = $this->db->affected_rows();
        echo $verify;
    }
    
}
