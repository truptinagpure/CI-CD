<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Locations extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/locations/Locations_model', 'locations');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['main_menu_type']       = "masters";
        $this->data['sub_menu_type']        = "locations";
        $this->data['child_menu_type']      = "locations";
        $this->data['sub_child_menu_type']  = "locations";

        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Locations', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        
        $this->data['data_list']            = $this->locations->get_locations();
        $this->data['title']                = 'Locations';
        $this->data['page']                 = "Locations";
        $this->data['content']              = $this->load->view('cms/locations/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['title']                = 'Locations';
        $this->data['module']               = 'Locations';
        $this->data['main_menu_type']       = "masters";
        $this->data['sub_menu_type']        = "locations";
        $this->data['child_menu_type']      = "save_locations";
        $this->data['sub_child_menu_type']  = "";
        $this->data['post_data']            = [];
        $this->data['location_id']          = $id;
        $this->data['post_data']['public']  = 1;
        
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        $per_action                         = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Locations', 'edit', $per_action, $this->data['insta_id']);

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        $this->form_validation->set_rules('location_name', 'Location Name', 'required|max_length[250]');
        $this->form_validation->set_rules('status', 'Status', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                $this->common_model->set_table('locations');
                if($id)
                {   
                    $update['location_name']            = $this->input->post('location_name');
                    $update['location_description']     = $this->input->post('location_description');
                    $update['public']                   = $this->input->post('status');

                    $response = $this->common_model->_update('location_id', $id, $update);
                    if(isset($response['public']) && $response['public'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Locations successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {   
                    $insert['location_name']            = $this->input->post('location_name');
                    $insert['location_description']     = $this->input->post('location_description');
                    $insert['public']                   = $this->input->post('status');

                    $response                           = $this->common_model->_insert($insert);
                    if(isset($response['public']) && $response['public'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Location successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/locations/');
            }
        }

        if($id!='')
        {
            $locations                         = $this->locations->get_locations(['f.location_id' => $id, 'f.public !=' => '-1']);
            $this->data['post_data']        = isset($locations[0]) ? $locations[0] : [];
            
            if(empty($this->data['post_data']))
            {   
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'locations not found']);
                redirect(base_url()."cms/locations/");
            }
        }

        $this->data['content']          = $this->load->view('cms/locations/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['insta_id']             = $instituteID ? $instituteID : $this->default_institute_id;
        validate_permissions('Locations', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $locations                          = $this->locations->get_locations(['f.location_id' => $id, 'f.public !=' => '-1']);

        if(!empty($locations))
        {
            $this->common_model->set_table('locations');
            $response = $this->common_model->_delete('location_id', $id);

            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'locations not found.']);
        }
        redirect(base_url().'cms/locations');
    }

}
