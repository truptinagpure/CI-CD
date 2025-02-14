<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Newsletter_type extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function listing()
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "newsletters";
        $this->data['child_menu_type'] = "newsletter_type";
        $this->data['sub_child_menu_type'] = "newsletter_type";

        //$instituteID = $this->uri->segment(3);
        //$this->data['insta_id'] = $instituteID ? $instituteID : $this->default_institute_id;

        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        validate_permissions('Newsletter_type', 'listing', $this->config->item('method_for_view'), $this->data['insta_id']);

        $this->data['data_list']    = $this->get_newsletter_types('', ['institute_id' => $this->data['insta_id']]);
        $this->data['title']        = 'Newsletter Types';
        $this->data['page']         = "newsletter_type";
        $this->data['content']      = $this->load->view('cms/newsletter/types/index', $this->data, true);
        $this->load->view($this->mainTemplate, $this->data);
    }

    function managenewslettertype($id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "newsletters";
        $this->data['child_menu_type'] = "newsletter_type";
        $this->data['sub_child_menu_type'] = "save_newsletter_type";

        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Newsletter_type', 'managenewslettertype', $per_action, $this->data['insta_id']);

        $this->data['title']                = 'Newsletter Types';
        $this->data['page']                 = "newsletter_type";
        $this->data['post_data']            = [];
        $this->data['id']                   = $id;
        $this->data['post_data']['public']  = 1;

        if($id)
        {
            $newslettertypedata = $this->get_newsletter_types($id, ['institute_id' => $this->data['insta_id']]);
            $this->data['post_data'] = isset($newslettertypedata[0]) ? $newslettertypedata[0] : [];
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Newsletter type not found']);
                //redirect(base_url().'cms/newsletter_type/listing/'.$this->data['insta_id']);
                redirect(base_url().'cms/newsletter_type/listing/');
            }
        }

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
        }

        $this->form_validation->set_rules('title', 'Title', 'required|max_length[250]');
        $this->form_validation->set_rules('description', 'Description', '');
        $this->form_validation->set_rules('image', 'Image', '');
        $this->form_validation->set_rules('public', 'Public', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {
                $this->common_model->set_table('newsletter_types');
                if($id)
                {
                    //$update['institute_id']     = $this->input->post('insta_id');
                    $update['institute_id']     = $this->session->userdata['sess_institute_id'];
                    $update['title']            = $this->input->post('title');
                    $update['description']      = $this->input->post('description');
					$update['team_voice']       = $this->input->post('team_voice');
                    $update['image']            = $this->input->post('image');
                    $update['public']           = $this->input->post('public');
                    $update['modified_on']      = date('Y-m-d H:i:s');
                    $update['modified_by']      = $this->session->userdata['user_id'];

                    $response = $this->common_model->_update('id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Newsletter type successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    //$insert['institute_id']     = $this->input->post('insta_id');
                    $insert['institute_id']     = $this->session->userdata['sess_institute_id'];
                    $insert['title']            = $this->input->post('title');
                    $insert['description']      = $this->input->post('description');
					$insert['team_voice']       = $this->input->post('team_voice');
                    $insert['image']            = $this->input->post('image');
                    $insert['public']           = $this->input->post('public');
                    $insert['created_on']       = date('Y-m-d H:i:s');
                    $insert['created_by']       = $this->session->userdata['user_id'];
                    $insert['modified_on']      = date('Y-m-d H:i:s');
                    $insert['modified_by']      = $this->session->userdata['user_id'];

                    $response = $this->common_model->_insert($insert);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Newsletter type successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                //redirect(base_url().'cms/newsletter_type/listing/'.$this->data['insta_id']);
                redirect(base_url().'cms/newsletter_type/listing/');
            }
        }
        $this->data['content']      = $this->load->view('cms/newsletter/types/form', $this->data, true);
        $this->load->view($this->mainTemplate, $this->data);
    }

    function get_newsletter_types($id='', $conditions=[], $order_by='')
    {
        $sql = 'SELECT n.* FROM newsletter_types n WHERE 1=1';
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

    function deletenewslettertype($id='')
    {
        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        validate_permissions('Newsletter_type', 'deletenewslettertype', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        $newslettertypedata = $this->get_newsletter_types($id, ['institute_id' => $this->data['insta_id']]);
        if(!empty($newslettertypedata))
        {
            $this->common_model->set_table('newsletter_types');
            $response = $this->common_model->_delete('id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Newsletter type not found.']);
        }
        //redirect(base_url().'cms/newsletter_type/listing/'.$this->data['insta_id']);
        redirect(base_url().'cms/newsletter_type/listing/');
    }

    function subscribers($id=0)
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "newsletters";
        $this->data['child_menu_type'] = "newsletter_type";
        $this->data['sub_child_menu_type'] = "newsletter_type";
        
        $this->data['id']       = $id;
        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        validate_permissions('Newsletter_type', 'subscribers', $this->config->item('method_for_view'), $this->data['insta_id']);

        $newslettertypedata = $this->get_newsletter_types($id, ['institute_id' => $this->data['insta_id']]);
        if(!empty($newslettertypedata))
        {
            $this->data['data_list']    = $this->get_subscribers('', ['type' => 'newsletter', 'type_id' => $id], 'id desc');
            $this->data['title']        = 'Subscribers';
            $this->data['page']         = "subscribers";
            $this->data['content']      = $this->load->view('cms/newsletter/types/subscribers', $this->data, true);
            $this->load->view($this->mainTemplate, $this->data);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Newsletter type not found.']);
            //redirect(base_url().'cms/newsletter_type/listing/'.$this->data['insta_id']);
            redirect(base_url().'cms/newsletter_type/listing/');
        }
    }

    function deletesubscriber($newsletter_type_id=0, $id=0)
    {
        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        validate_permissions('Newsletter_type', 'deletesubscriber', $this->config->item('method_for_delete'), $this->data['insta_id']);

        $newslettertypedata = $this->get_newsletter_types($newsletter_type_id, ['institute_id' => $this->data['insta_id']]);
        if(!empty($newslettertypedata))
        {
            $this->common_model->set_table('subscribe');
            $response = $this->common_model->_delete('id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Newsletter type not found.']);
        }
        //redirect(base_url().'cms/newsletter_type/subscribers/'.$this->data['insta_id'].'/'.$newsletter_type_id);
        redirect(base_url().'cms/newsletter_type/subscribers/'.$newsletter_type_id);
    }

    function export_subscribers( $id=0)
    {
        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        validate_permissions('Newsletter_type', 'export_subscribers', $this->config->item('method_for_export'), $this->data['insta_id']);

        $newslettertypedata = $this->get_newsletter_types($id, ['institute_id' => $this->data['insta_id']]);
        if(!empty($newslettertypedata))
        {
            $subscribers                  = $this->get_subscribers('', ['type' => 'newsletter', 'type_id' => $id], 'id asc');
            if(!empty($subscribers))
            {
                $this->load->library("excel");
                $object = new PHPExcel();
                $object->setActiveSheetIndex(0);

                $table_columns = array("Email", "Subscription Date");

                $column = 0;

                foreach($table_columns as $field)
                {
                    $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                    $column++;
                }

                $excel_row = 2;

                foreach($subscribers as $row)
                {
                    $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['email']);
                    $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['created_on']);
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
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Newsletter type not found.']);
                //redirect(base_url().'cms/newsletter_type/subscribers/'.$this->data['insta_id'].'/'.$id);
                redirect(base_url().'cms/newsletter_type/subscribers/'.$id);
            }
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Newsletter type not found.']);
            //redirect(base_url().'cms/newsletter_type/subscribers/'.$this->data['insta_id'].'/'.$id);
            redirect(base_url().'cms/newsletter_type/subscribers/'.$id);
        }
    }

    function get_subscribers($id='', $conditions=[], $order_by='')
    {
        $sql = 'SELECT * FROM subscribe WHERE 1=1';
        foreach ($conditions as $key => $value) {
            $sql .= ' AND '.$key.' = "'.$value.'"';
        }
        if($id)
        {
            $sql .= ' AND id = "'.$id.'"';
        }
        if($order_by)
        {
            $sql .= ' ORDER BY "'.$order_by.'"';
        }
        else
        {
            $sql .= ' ORDER BY id DESC';
        }
        $result = $this->common_model->custom_query($sql);
        return $result;
    }
}
