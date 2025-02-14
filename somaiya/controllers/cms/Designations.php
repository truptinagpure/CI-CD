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
class Designations extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/expert_talk/designations_model');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function designations()
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "lectures";
        $this->data['child_menu_type'] = "designations";
        $this->data['sub_child_menu_type'] = "designations";

        //$instituteID = $this->uri->segment(3);
        //$this->data['insta_id'] = $instituteID ? $instituteID : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        validate_permissions('Designations', 'designations', $this->config->item('method_for_view'), $this->data['insta_id']);

        $this->data['data_list']    = $this->designations_model->get_all_designations(['institute_id' => $this->data['insta_id']]);
        
        $this->data['title']        = _l("designations", $this);
        $this->data['page']         = "designation";
        $this->data['content']      = $this->load->view('cms/expert_talk/designations/index', $this->data, true);
        $this->load->view($this->mainTemplate, $this->data);
    }

    function managedesignation($id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "lectures";
        $this->data['child_menu_type'] = "designations";
        $this->data['sub_child_menu_type'] = "save_designation";

        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Designations', 'managedesignation', $per_action, $this->data['insta_id']);

        $this->data['title']                = _l("designations", $this);
        $this->data['page']                 = "designation";
        $this->data['post_data']            = [];
        $this->data['designation_id']       = $id;
        $this->data['post_data']['public']  = 1;

        if($id)
        {
            $this->data['post_data'] = $this->designations_model->get_designation($id, ['institute_id' => $this->data['insta_id']]);
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Designation not found']);
                //redirect(base_url().'designations/designations/'.$this->data['insta_id']);
                redirect(base_url().'cms/designations/designations/');
            }
        }

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        $this->form_validation->set_rules('name', 'Designation', 'required|max_length[250]');
        $this->form_validation->set_rules('short_name', 'Designation short name', 'required|max_length[50]');
        $this->form_validation->set_rules('description', 'Description', '');
        $this->form_validation->set_rules('public', 'Public', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {
                $response = $this->designations_model->manage_designations($this->input->post(), $id);
                $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
                //redirect(base_url().'designations/designations/'.$this->data['insta_id']);
                redirect(base_url().'cms/designations/designations/');
            }
        }
        $this->data['content']      = $this->load->view('cms/expert_talk/designations/form', $this->data, true);
        $this->load->view($this->mainTemplate, $this->data);
    }

    function deletedesignation($id='')
    {
        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        validate_permissions('Designations', 'deletedesignation', $this->config->item('method_for_delete'), $this->data['insta_id']);

        $des = $this->designations_model->get_designation($id, ['institute_id' => $this->data['insta_id']]);
        if(!empty($des))
        {
            $this->common_model->set_table('designations');
            $response = $this->common_model->_delete('designation_id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
            //redirect(base_url().'designations/designations/'.$this->data['insta_id']);
            redirect(base_url().'cms/designations/designations/');
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Designation not found.']);
            //redirect(base_url().'designations/designations/'.$this->data['insta_id']);
            redirect(base_url().'cms/designations/designations/');
        }
    }
}
