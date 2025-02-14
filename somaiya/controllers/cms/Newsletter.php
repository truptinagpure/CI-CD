<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Newsletter extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function listing()
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "newsletters";
        $this->data['child_menu_type'] = "newsletter";
        $this->data['sub_child_menu_type'] = "newsletter";

        //$instituteID = $this->uri->segment(3);
        //$this->data['insta_id'] = $instituteID ? $instituteID : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];
        
        validate_permissions('Newsletter', 'listing', $this->config->item('method_for_view'), $this->data['insta_id']);

        $this->data['data_list']    = $this->get_newsletter('', ['institute_id' => $this->data['insta_id']]);
        $this->data['title']        = 'Newsletter';
        $this->data['page']         = "newsletter";
        $this->data['content']      = $this->load->view('cms/newsletter/newsletter/index', $this->data, true);
        $this->load->view($this->mainTemplate, $this->data);
    }

    function managenewsletter($id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "newsletters";
        $this->data['child_menu_type'] = "newsletter";
        $this->data['sub_child_menu_type'] = "save_newsletter";

        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Newsletter', 'managenewsletter', $per_action, $this->data['insta_id']);

        $this->data['title']                    = 'Newsletter';
        $this->data['page']                     = "newsletter";
        $this->data['post_data']                = [];
        $this->data['id']                       = $id;
        $this->data['post_data']['public']      = 1;

        if($id)
        {
            $newsletterdata = $this->get_newsletter($id, ['institute_id' => $this->data['insta_id']]);

            // echo "<pre>";
            // print_r($newsletterdata);
            // exit();
            $this->data['post_data'] = isset($newsletterdata[0]) ? $newsletterdata[0] : [];
            
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Newsletter not found']);
                //redirect(base_url().'cms/newsletter/listing/'.$this->data['insta_id']);
                redirect(base_url().'cms/newsletter/listing/');
            }
        }

        if($this->input->post())
        {
            $this->data['post_data']                = $this->input->post();
        }

        //$this->form_validation->set_rules('institute_id', 'Institute', '');
        $this->form_validation->set_rules('newsletter_type_id', 'Newsletter Type', 'required');
        $this->form_validation->set_rules('year', 'Year', 'required');
        $this->form_validation->set_rules('heading', 'Heading', 'required|max_length[250]');
        $this->form_validation->set_rules('content', 'Content', '');
        $this->form_validation->set_rules('document', 'Document', '');
        $this->form_validation->set_rules('public', 'Public', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {
                $this->common_model->set_table('newsletters');
                if($id)
                {
                    //$update['institute_id']         = $this->input->post('insta_id');
                    $update['institute_id']         = $this->session->userdata['sess_institute_id'];
                    $update['newsletter_type_id']   = $this->input->post('newsletter_type_id');
                    $update['year']                 = $this->input->post('year');
                    $update['document']             = $this->input->post('document');
                    $update['public']               = $this->input->post('public');
                    $update['modified_on']          = date('Y-m-d H:i:s');
                    $update['modified_by']          = $this->session->userdata['user_id'];

                    $response = $this->common_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $update1['heading']         = $this->input->post('heading');
                        $update1['content']         = $this->input->post('content');
                        $update1['public']          = $this->input->post('public');
                        $update1['modified_on']     = date('Y-m-d H:i:s');
                        $update1['modified_by']     = $this->session->userdata['user_id'];

                        $this->common_model->set_table('newsletter_content');
                        $response1 = $this->common_model->_update_with_multiple_conditions(['newsletter_id' => $id, 'language_id' => 1], $update1);

                        if(isset($response1['status']) && $response1['status'] == 'success')
                        {
                            $msg = ['error' => 0, 'message' => 'Newsletter successfully updated'];
                        }
                        else
                        {
                            $msg = ['error' => 0, 'message' => $response1['message']];
                        }
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    //$insert['institute_id']         = $this->input->post('insta_id');
                    $insert['institute_id']           = $this->session->userdata['sess_institute_id'];
                    $insert['newsletter_type_id']   = $this->input->post('newsletter_type_id');
                    $insert['year']                 = $this->input->post('year');
                    $insert['document']             = $this->input->post('document');
                    $insert['public']               = $this->input->post('public');
                    $insert['created_on']           = date('Y-m-d H:i:s');
                    $insert['created_by']           = $this->session->userdata['user_id'];
                    $insert['modified_on']          = date('Y-m-d H:i:s');
                    $insert['modified_by']          = $this->session->userdata['user_id'];

                    $response = $this->common_model->_insert($insert);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $insert1['newsletter_id']   = $response['id'];
                        $insert1['language_id']     = 1;
                        $insert1['heading']         = $this->input->post('heading');
                        $insert1['content']         = $this->input->post('content');
                        $insert1['public']          = $this->input->post('public');
                        $insert1['created_on']      = date('Y-m-d H:i:s');
                        $insert1['created_by']      = $this->session->userdata['user_id'];
                        $insert1['modified_on']     = date('Y-m-d H:i:s');
                        $insert1['modified_by']     = $this->session->userdata['user_id'];

                        $this->common_model->set_table('newsletter_content');
                        $response1 = $this->common_model->_insert($insert1);

                        if(isset($response1['status']) && $response1['status'] == 'success')
                        {
                            $msg = ['error' => 0, 'message' => 'Newsletter successfully added'];
                        }
                        else
                        {
                            $msg = ['error' => 0, 'message' => $response1['message']];
                        }
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/newsletter/listing/');
            }
        }
        // else
        // {
        //     echo "<pre>";print_r($this->form_validation->error_array());exit;
        // }

        $this->data['newsletter_types']         = $this->common_model->custom_query('SELECT * FROM newsletter_types WHERE public = "1" AND institute_id = "'.$this->data['insta_id'].'"');
        $this->data['content']      = $this->load->view('cms/newsletter/newsletter/form', $this->data, true);
        $this->load->view($this->mainTemplate, $this->data);
    }

    function get_newsletter($id='', $conditions=[], $order_by='')
    {
        $sql = 'SELECT n.*, (SELECT nt.title FROM newsletter_types nt WHERE nt.id = n.newsletter_type_id) as newsletter_type, (SELECT nc.heading FROM newsletter_content nc WHERE n.id = nc.newsletter_id AND nc.language_id = 1) as heading, (SELECT nc.content FROM newsletter_content nc WHERE n.id = nc.newsletter_id AND nc.language_id = 1) as content FROM newsletters n WHERE 1=1';
        foreach ($conditions as $key => $value) {
            $sql .= ' AND n.'.$key.' = "'.$value.'"';
        }
        if($id)
        {
            $sql .= ' AND n.id = "'.$id.'"';
        }
        if($order_by)
        {
            $sql .= ' ORDER BY "'.$order_by.'"';
        }
        else
        {
            $sql .= ' ORDER BY n.id DESC';
        }
        $result = $this->common_model->custom_query($sql);
        return $result;
    }

    function deletenewsletter($id='')
    {
        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        validate_permissions('Newsletter', 'deletenewsletter', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $newsletterdata = $this->get_newsletter($id, ['institute_id' => $this->data['insta_id']]);
        if(!empty($newsletterdata))
        {
            $this->common_model->set_table('newsletters');
            $response = $this->common_model->_delete('id', $id);
            $this->common_model->set_table('newsletter_content');
            $response = $this->common_model->_delete('newsletter_id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Newsletter not found.']);
        }
        redirect(base_url().'cms/newsletter/listing/');
    }

    function content($id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "newsletters";
        $this->data['child_menu_type'] = "newsletter";
        $this->data['sub_child_menu_type'] = "newsletter";

        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];
        $newsletterdata = $this->get_newsletter($id, ['institute_id' => $this->data['insta_id']]);

        if(!empty($newsletterdata))
        {
            $this->data['data_list']    = $this->get_newsletter_content($id);
            $this->data['title']        = 'Newsletter Content';
            $this->data['page']         = "newslettercontent";
            $this->data['newsletter_id']= $id;
            $this->data['content']      = $this->load->view('cms/newsletter/newsletter/content', $this->data, true);
            $this->load->view($this->mainTemplate, $this->data);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'No newsletter found']);
            redirect(base_url().'cms/newsletter/listing/');
        }
    }

    function managecontent($newsletter_id='', $newsletter_content_id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "newsletters";
        $this->data['child_menu_type'] = "newsletter";
        $this->data['sub_child_menu_type'] = "newsletter";
        
        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        $newsletterdata = $this->get_newsletter($newsletter_id, ['institute_id' => $this->data['insta_id']]);

        if(!empty($newsletterdata))
        {
            $this->data['title']                    = 'Newsletter Content';
            $this->data['page']                     = "newslettercontent";
            $this->data['post_data']                = [];
            $this->data['newsletter_content_id']    = $newsletter_content_id;
            $this->data['newsletter_id']            = $newsletter_id;
            $this->data['post_data']['public']      = 1;

            if($newsletter_content_id)
            {
                $newslettercontentdata = $this->get_newsletter_content($newsletter_id, $newsletter_content_id);
                $this->data['post_data'] = isset($newslettercontentdata[0]) ? $newslettercontentdata[0] : [];
                if(empty($this->data['post_data']))
                {
                    $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Newsletter content not found']);
                    //redirect(base_url().'cms/newsletter/content/'.$this->data['insta_id'].'/'.$newsletter_id);
                    redirect(base_url().'cms/newsletter/content/'.$newsletter_id);
                }
            }

            if($this->input->post())
            {
                $this->data['post_data'] = $this->input->post();
            }

            $this->form_validation->set_rules('language_id', 'Language', 'required|callback_unique_language');
            $this->form_validation->set_rules('heading', 'Heading', 'required|max_length[250]');
            $this->form_validation->set_rules('content', 'Content', '');
            $this->form_validation->set_rules('public', 'Public', '');

            if($this->form_validation->run($this) === TRUE)
            {
                if($this->input->post())
                {
                    $this->common_model->set_table('newsletter_content');
                    if($newsletter_content_id)
                    {
                        $update['language_id']      = $this->input->post('language_id');
                        $update['heading']          = $this->input->post('heading');
                        $update['content']          = $this->input->post('content');
                        $update['public']           = $this->input->post('public');
                        $update['modified_on']      = date('Y-m-d H:i:s');
                        $update['modified_by']      = $this->session->userdata['user_id'];

                        $response = $this->common_model->_update('id', $newsletter_content_id, $update);
                        if(isset($response['status']) && $response['status'] == 'success')
                        {
                            $msg = ['error' => 0, 'message' => 'Newsletter content successfully updated'];
                        }
                        else
                        {
                            $msg = ['error' => 0, 'message' => $response['message']];
                        }
                    }
                    else
                    {
                        $insert['language_id']      = $this->input->post('language_id');
                        $insert['newsletter_id']    = $newsletter_id;
                        $insert['heading']          = $this->input->post('heading');
                        $insert['content']          = $this->input->post('content');
                        $insert['public']           = $this->input->post('public');
                        $insert['created_on']       = date('Y-m-d H:i:s');
                        $insert['created_by']       = $this->session->userdata['user_id'];
                        $insert['modified_on']      = date('Y-m-d H:i:s');
                        $insert['modified_by']      = $this->session->userdata['user_id'];

                        $response = $this->common_model->_insert($insert);
                        if(isset($response['status']) && $response['status'] == 'success')
                        {
                            $msg = ['error' => 0, 'message' => 'Newsletter content successfully added'];
                        }
                        else
                        {
                            $msg = ['error' => 0, 'message' => $response['message']];
                        }
                    }
                    $this->session->set_flashdata('requeststatus', $msg);
                    redirect(base_url().'cms/newsletter/content/'.$this->data['insta_id'].'/'.$newsletter_id);
                }
            }

            $this->data['languages']    = $this->Somaiya_general_admin_model->get_all_language();
            $this->data['content']      = $this->load->view('cms/newsletter/newsletter/form_content', $this->data, true);
            $this->load->view($this->mainTemplate, $this->data);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'No newsletter found']);
            //redirect(base_url().'cms/newsletter/listing/'.$this->data['insta_id']);
            redirect(base_url().'cms/newsletter/listing/');
        }
    }

    function get_newsletter_content($newsletter_id='', $newsletter_content_id='', $conditions=[], $order_by='')
    {
        $sql = 'SELECT nc.*, l.language_name FROM newsletter_content nc left join languages l ON l.language_id = nc.language_id WHERE nc.newsletter_id = "'.$newsletter_id.'"';
        foreach ($conditions as $key => $value) {
            $sql .= ' AND nc.'.$key.' = "'.$value.'"';
        }
        if($newsletter_content_id)
        {
            $sql .= ' AND nc.id = "'.$newsletter_content_id.'"';
        }
        if($order_by)
        {
            $sql .= ' ORDER BY "'.$order_by.'"';
        }
        else
        {
            $sql .= ' ORDER BY nc.id DESC';
        }
        $result = $this->common_model->custom_query($sql);
        return $result;
    }

    function ajax_check_language()
    {
        if($this->input->post())
        {
            $result = $this->unique_language();
            echo $result;exit;
        }
    }

    function unique_language()
    {
        $newsletter_content_id      = isset($_POST['newsletter_content_id']) ? $_POST['newsletter_content_id'] : '';
        $newsletter_id              = isset($_POST['newsletter_id']) ? $_POST['newsletter_id'] : '';
        $language_id                = isset($_POST['language_id']) ? $_POST['language_id'] : '';
        $errormessage               = 'Newsletter content for this language is already exist.';
        $this->form_validation->set_message('unique_language', $errormessage);

        if($newsletter_content_id)
        {
            $content = $this->common_model->custom_query('Select * FROM newsletter_content WHERE language_id = "'.$language_id.'" AND newsletter_id = "'.$newsletter_id.'" AND id != "'.$newsletter_content_id.'"');
        }
        else
        {
            $content = $this->common_model->custom_query('Select * FROM newsletter_content WHERE language_id="'.$language_id.'" AND newsletter_id = "'.$newsletter_id.'"');
        }

        if(isset($content[0]) && !empty($content[0]))
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    function deletecontent($newsletter_id='',$newsletter_content_id,$language_id)
    {
        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        validate_permissions('Newsletter', 'deletecontent', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $newslettercontentdata = $this->get_newsletter_content($newsletter_id, $newsletter_content_id);

        if(!empty($newslettercontentdata))
        {
            $this->common_model->set_table('newsletter_content');
            $response = $this->common_model->_delete('id', $newsletter_content_id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Newsletter Content not found.']);
        }
        redirect(base_url().'cms/newsletter/listing/');
    }

    function newsletter_reports()
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "newsletters";
        $this->data['child_menu_type'] = "newsletter_reports";
        $this->data['sub_child_menu_type'] = "newsletter_reports";

        // $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];
        // validate_permissions('Newsletter', 'listing', $this->config->item('method_for_view'), $this->data['insta_id']);

        $this->data['data_list']    = $this->get_email_list_newsletter();
        $this->data['title']        = 'Newsletter Reports';
        $this->data['page']         = "newsletter reports";
        $this->data['content']      = $this->load->view('cms/newsletter/newsletter_reports', $this->data, true);
        $this->load->view($this->mainTemplate, $this->data);
    }

    function get_email_list_newsletter($id='', $conditions=[], $order_by='')
    {   
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];
        //$sql = 'SELECT * FROM subscribe WHERE (1=1) AND (type = "media_coverages" OR type = "media_list" OR type = "press_release")';
        $sql = 'SELECT *,subscribe.id as subid, (SELECT newsletter_type.title FROM newsletter_types newsletter_type WHERE newsletter_type.id = subscribe.type_id) as newsletter_type FROM subscribe LEFT JOIN newsletters ON subscribe.type_id=newsletters.id WHERE (1=1) AND (subscribe.type = "newsletter") AND (subscribe.institute_id = "'.$this->data['insta_id'].'")';
        
        foreach ($conditions as $key => $value) {
            $sql .= ' AND '.$key.' = "'.$value.'"';
        }
        if($id)
        {
            $sql .= ' AND subscribe.id = "'.$id.'"';
        }
        if($order_by)
        {
            $sql .= ' ORDER BY "'.$order_by.'"';
        }
        else
        {
            $sql .= ' ORDER BY subscribe.id DESC';
        }
        $result = $this->Somaiya_general_admin_model->newsletter_query($sql);
        return $result;
    }

    function newsletter_export()
    {
        // $inst_id = $this->default_institute_id;
        // validate_permissions('Newsletter', 'newsletter_export', $this->config->item('method_for_export'), $inst_id); 

        $email_list = $this->get_email_list_newsletter();
        if(!empty($email_list))
        {
            $this->load->library("excel");
            $object = new PHPExcel();
            $object->setActiveSheetIndex(0);
            $table_columns = array("Email");
            $column = 0;

            foreach($table_columns as $field)
            {
                $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                $column++;
            }

            $excel_row = 2;

            foreach($email_list as $row)
            {
                $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['email']);
                $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['type']);
                $excel_row++;
            }

            $fileName = time() . '.xls';
            $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$fileName.'"');
            $object_writer->save('php://output');
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'No record found.']);
            redirect(base_url()."newsletter_reports/");
        }
    }

    function delete_newsletter($id='')
    {
        // $deleteid  = $this->input->post('id');
        $this->db->delete('subscribe', array('id' => $id));
        $verify = $this->db->affected_rows();
        echo $verify;
        redirect(base_url().'cms/newsletter/newsletter_reports');
    }

}
