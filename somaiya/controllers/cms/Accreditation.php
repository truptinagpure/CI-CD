<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Accreditation extends Somaiya_Controller
{
    private $default_institute_id;

    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/nacc/accreditation_model', 'accreditation_model');
        $user_id = $this->session->userdata['user_id'];
        //echo '<pre>'; print_r($this->session->all_userdata());exit;
        $default_institute_id = $this->config->item('default_institute_id');

    }

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "nacc";
        $this->data['child_menu_type']      = "accreditation";
        $this->data['sub_child_menu_type']  = "accreditation";

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];

        validate_permissions('accreditation', 'index', $this->config->item('method_for_view'), $this->data['institute_id']);
        
        $this->data['data_list']            = $this->accreditation_model->get_accreditation_list(['institute_Id ' => $this->session->userdata['sess_institute_id']]);
        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/nacc/accreditation/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "nacc";
        $this->data['child_menu_type']      = "accreditation";
        $this->data['sub_child_menu_type']  = "save_accreditation";
        $this->data['accreditation_data']      = [];
        $this->data['accreditation_id']        = $id;

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
        
        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('accreditation', 'edit', $per_action, $this->data['institute_id']);

        if($this->input->post())
        {
            $this->data['accreditation_data'] = $this->input->post();
        }

        
        $this->form_validation->set_rules('name', 'Accreditation name', 'required|max_length[250]');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {                                                   
                if($id)
                {
                    $update['institute_id']         = $this->session->userdata['sess_institute_id'];
                    $update['name']                 = $this->input->post('name');
                    $update['start_date']           = $this->input->post('start_date');
                    $update['end_date']             = $this->input->post('end_date');
                    $update['description']          = $this->input->post('description');
                    $update['status']               = $this->input->post('public');
                    $update['modified_on']          = date('Y-m-d H:i:s');
                    $update['modified_by']          = $this->session->userdata['user_id'];
                    
                    $response = $this->accreditation_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'accreditation successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['institute_id']         = $this->session->userdata['sess_institute_id'];
                    $insert['name']                 = $this->input->post('name');
                    $insert['start_date']           = $this->input->post('start_date');
                    $insert['end_date']             = $this->input->post('end_date');
                    $insert['description']          = $this->input->post('description');
                    $insert['status']               = $this->input->post('public');
                    $insert['created_on']           = date('Y-m-d H:i:s');
                    $insert['created_by']           = $this->session->userdata['user_id'];
                    
                    $response                       = $this->accreditation_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $entyty_type_id           	= $response['id'];
                        $msg = ['error' => 0, 'message' => 'Accreditation successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/accreditation/');
            }
        }

        if($id!='')
        {
            $accreditation = $this->accreditation_model->get_accreditation_list(['id' => $id, 'status !=' => '-1']);
            $this->data['accreditation_data']     = isset($accreditation[0]) ? $accreditation[0] : [];
            
            if(empty($this->data['accreditation_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'accreditation not found']);
                redirect(base_url()."cms/accreditation/");
            }
        }

        $this->data['content']              = $this->load->view('cms/nacc/accreditation/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }

    function delete($id='')
    {
        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
            
        validate_permissions('accreditation', 'delete', $this->config->item('method_for_delete'), $this->data['institute_id']);
             
        $accreditation = $this->accreditation_model->get_accreditation_list(['id' => $id]);

        if(!empty($accreditation))
        {
            $response = $this->accreditation_model->_delete('id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Plant not found.']);
        }
        redirect(base_url().'cms/accreditation/');
    }

}
