<?php
/**
 * Created by Somaiya Team.
 * User: Somaiya
 * Date: 11/05/2018
 * Time: 12:28 PM
 * Project: Somaiya Vidyavihar
 * Website: https://www.somaiya.edu
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Speakers extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function speakers()
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "lectures";
        $this->data['child_menu_type'] = "speakers";
        $this->data['sub_child_menu_type'] = "speakers";

        //$instituteID = $this->uri->segment(3);
        //$this->data['insta_id'] = $instituteID ? $instituteID : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        validate_permissions('Speakers', 'speakers', $this->config->item('method_for_view'), $this->data['insta_id']);

        $this->data['data_list']    = $this->get_speakers('', ['institute_id' => $this->data['insta_id']]);
        $this->data['title']        = _l("speakers", $this);
        $this->data['page']         = "speaker";
        $this->data['content']      = $this->load->view('cms/expert_talk/speakers/index', $this->data, true);
        $this->load->view($this->mainTemplate, $this->data);
    }

    function managespeaker($id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "lectures";
        $this->data['child_menu_type'] = "speakers";
        $this->data['sub_child_menu_type'] = "save_speaker";

        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Speakers', 'managespeaker', $per_action, $this->data['insta_id']);

        $this->data['title']                = _l("speakers", $this);
        $this->data['page']                 = "speaker";
        $this->data['post_data']            = [];
        $this->data['speaker_id']           = $id;
        $this->data['post_data']['public']  = 1;
        $this->data['designations']         = $this->common_model->custom_query('SELECT designation_id, name FROM designations WHERE public = "1" AND institute_id = "'.$this->data['insta_id'].'"');

        if($id)
        {
            $speakerdata = $this->get_speakers($id, ['institute_id' => $this->data['insta_id']]);
            $this->data['post_data'] = isset($speakerdata[0]) ? $speakerdata[0] : [];
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Speaker not found']);
                //redirect(base_url().'speakers/speakers/'.$this->data['insta_id']);
                redirect(base_url().'cms/speakers/speakers/');
            }
        }

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        $this->form_validation->set_rules('first_name', 'First Name', 'required|max_length[250]');
        if($this->input->post())
        {
            $this->form_validation->set_rules('middle_name', 'Middle Name', 'max_length[250]');
        }
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|max_length[250]');
        $this->form_validation->set_rules('designation_id', 'Designation', 'required');
        $this->form_validation->set_rules('description', 'Description', '');
        $this->form_validation->set_rules('profile_image', 'Profile Image', '');
        $this->form_validation->set_rules('public', 'Public', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {
                $this->common_model->set_table('speakers');
                if($id)
                {
                    $update['first_name']       = $this->input->post('first_name');
                    $update['middle_name']      = $this->input->post('middle_name');
                    $update['last_name']        = $this->input->post('last_name');
                    $update['designation_id']   = $this->input->post('designation_id');
                    //$update['institute_id']     = $this->input->post('insta_id');
                    $update['institute_id']     = $this->session->userdata['sess_institute_id'];
                    $update['description']      = $this->input->post('description');
                    $update['profile_image']    = $this->input->post('profile_image');
                    $update['public']           = $this->input->post('public');
                    $update['modified_on']      = date('Y-m-d H:i:s');
                    $update['modified_by']      = $this->session->userdata['user_id'];

                    $response = $this->common_model->_update('speaker_id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Speaker successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['first_name']       = $this->input->post('first_name');
                    $insert['middle_name']      = $this->input->post('middle_name');
                    $insert['last_name']        = $this->input->post('last_name');
                    $insert['designation_id']   = $this->input->post('designation_id');
                    //$insert['institute_id']     = $this->input->post('insta_id');
                    $insert['institute_id']     = $this->session->userdata['sess_institute_id'];
                    $insert['description']      = $this->input->post('description');
                    $insert['profile_image']    = $this->input->post('profile_image');
                    $insert['public']           = $this->input->post('public');
                    $insert['created_on']       = date('Y-m-d H:i:s');
                    $insert['created_by']       = $this->session->userdata['user_id'];
                    $insert['modified_on']      = date('Y-m-d H:i:s');
                    $insert['modified_by']      = $this->session->userdata['user_id'];

                    $response = $this->common_model->_insert($insert);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Speaker successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
               //redirect(base_url().'speakers/speakers/'.$this->data['insta_id']);
                redirect(base_url().'cms/speakers/speakers/');
            }
        }
        $this->data['content']      = $this->load->view('cms/expert_talk/speakers/form', $this->data, true);
        $this->load->view($this->mainTemplate, $this->data);
    }

    function get_speakers($id='', $conditions=[], $order_by='')
    {
        $sql = 'SELECT s.*, (SELECT name from designations d where d.designation_id = s.designation_id) as designation_name FROM speakers s WHERE 1=1';
        foreach ($conditions as $key => $value) {
            $sql .= ' AND s.'.$key.' = "'.$value.'"';
        }
        if($id)
        {
            $sql .= ' AND s.speaker_id = "'.$id.'"';
        }
        if($order_by)
        {
            $sql .= ' ORDER BY "'.$order_by.'"';
        }
        else
        {
            $sql .= ' ORDER BY s.speaker_id DESC';
        }
        $result = $this->common_model->custom_query($sql);
        return $result;
    }

    function deletespeaker($id='')
    {
        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        validate_permissions('Speakers', 'deletespeaker', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $speakerdata = $this->get_speakers($id, ['institute_id' => $this->data['insta_id']]);
        if(!empty($speakerdata))
        {
            $this->common_model->set_table('speakers');
            $response = $this->common_model->_delete('speaker_id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Speaker not found.']);
        }
        //redirect(base_url().'speakers/speakers/'.$this->data['insta_id']);
        redirect(base_url().'cms/speakers/speakers/');
    }
}
