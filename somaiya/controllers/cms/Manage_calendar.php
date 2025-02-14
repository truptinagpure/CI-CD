<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Manage_calendar extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/calendar/Calendar_types_model', 'calendar_types');
        $this->load->model('cms/calendar/Manage_calendar_model', 'manage_calendar');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function index()
    {
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['title']                = 'Manage Calendar';
        $this->data['page']                 = 'Manage Calendar';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "calendar";
        $this->data['child_menu_type']      = "manage_calendar";
        $this->data['sub_child_menu_type']  = "list";

        validate_permissions('Manage_calendar', 'index', $this->config->item('method_for_view'), $this->data['insta_id']);
        $instituteID                        = $this->session->userdata('sess_institute_id');
        $this->data['data_list']            = $this->manage_calendar->get_calendar($instituteID);

        $this->data['content']              = $this->load->view('cms/calendar/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit($id='')
    {   
        error_reporting(0);
        $this->data['insta_id']             = $this->default_institute_id;
        $this->data['title']                = 'Manage Calendar';
        $this->data['page']                 = 'Manage Calendar';
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "calendar";
        $this->data['child_menu_type']      = "manage_calendar";
        $this->data['sub_child_menu_type']  = "save_calendar";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        $this->data['post_data']['status']  = 1;
        $this->data['document']             = $this->manage_calendar->get_document_detail($id);
        $this->data['calendar_types']       = $this->calendar_types->get_calendar_types_new();
        $this->data['institutes_list']      = $this->Somaiya_general_admin_model->get_all_institute();
        
        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Manage_calendar', 'edit', $per_action, $this->data['insta_id']);

        if($id!='')
        {
            $this->data['post_data']        = $this->manage_calendar->get_calendar_data($id);
            // echo "<pre>"; print_r($this->data['post_data']);
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Calendar not found']);
                redirect(base_url()."cms/manage_calendar/");
            }

            // if(isset($this->data['post_data']['institute_id']) && !empty($this->data['post_data']['institute_id']))
            // {
            //     $this->data['institute_id'] = explode(',', $this->data['post_data']['institute_id']);
            // }

            if(isset($this->data['post_data']['calendar_type_id']) && !empty($this->data['post_data']['calendar_type_id']))
            {
                $this->data['calendar_type_id'] = explode(',', $this->data['post_data']['calendar_type_id']);
            }

            if(isset($this->data['post_data']['calendar_sub_type_id']) && !empty($this->data['post_data']['calendar_sub_type_id']))
            {
                $this->data['calendar_sub_type_id'] = explode(',', $this->data['post_data']['calendar_sub_type_id']);
            }
        }

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }


        $documents = $_POST["documents"];

        if($this->input->post())
        {   
            $response = $this->manage_calendar->manage_calendar($this->input->post(), $id, $documents);                
            $this->session->set_flashdata('requeststatus', $response);
            redirect(base_url().'cms/manage_calendar/');
        }

        $this->data['content']              = $this->load->view('cms/calendar/form',$this->data,true);
        $this->load->view($this->mainTemplate, $this->data);    
    }

    function delete($id='')
    {
        $this->data['insta_id'] = $this->default_institute_id;
        validate_permissions('Manage_calendar', 'delete', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $calendardata = $this->manage_calendar->get_calendar_data($id);
        if(!empty($calendardata))
        {
            $this->common_model->set_table('event_calendar');
            $response = $this->common_model->_delete('id', $id);

            $this->common_model->set_table('event_calendar_document');
            $response = $this->common_model->_delete('relation_id', $id);

            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Calendar not found.']);
        }
        redirect(base_url().'cms/manage_calendar/');
    }

    function upload_document($relation_id='')
    {
        sleep(3);
        if($_FILES["files"]["name"] != '')
        {
            $output = '';
            $config["upload_path"] = './assets/calendar/';
            $config["allowed_types"] = 'pdf';
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
                      <img src="'.base_url().'assets/calendar/pdf.png" class="img-responsive img-thumbnail" />
                      <input type="hidden" name="documents[]" value="'.$data["file_name"].'">
                     </div>
                    ';
                }
            }
           $data["file_name"] = array();
           $fileNamefeatured = implode(',', $data["file_name"]);
           echo $output;
        }
    }

    function deletedocument()
    {
        $deleteid  = $this->input->post('id');
        $this->db->delete('event_calendar_document', array('id' => $deleteid));
        $verify = $this->db->affected_rows();
        echo $verify;
    }

    function get_sub($calendar_type_id)
    {
        $sql            = 'Select s.* FROM event_calendar_sub_type s WHERE s.status = "1" AND s.calendar_type_id IN ('.$calendar_type_id.') ORDER BY s.name ASC';
        $sub_type = $this->common_model->custom_query($sql);
        return $sub_type;
    }

    function get_sub_options()
    {
        $options            = '<option value="">-- Select Sub Category --</option>';
        $calendar_type_id   = isset($_POST['calendar_type_id']) ? $_POST['calendar_type_id'] : '';
        $sub_type           = $this->get_sub($calendar_type_id);
        $sub_type_id        = isset($_POST['calendar_sub_type_id']) ? $_POST['calendar_sub_type_id'] : '';
        $arr3 = explode(',' , $sub_type_id);

        foreach($sub_type as $key => $value) 
        {   
            $selected           = '';
            if(in_array($value['id'],$arr3))
            {   
                $selected       = 'selected="selected"';
            }
            $options            .= '<option value="'.$value['id'].'" '.$selected.'>'.$value['name'].'</option>';
        }
            
        echo json_encode($options);exit;
    }

}
