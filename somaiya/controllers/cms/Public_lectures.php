<?php
/**
 * Created by Somaiya Team.
 * User: Somaiya
 * Date: 12/05/2018
 * Time: 10:53 PM
 * Project: Somaiya Vidyavihar
 * Website: https://www.somaiya.edu
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Public_lectures extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->default_institute_id = $this->config->item('default_institute_id');
    }

    function lectures()
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "lectures";
        $this->data['child_menu_type'] = "lectures";
        $this->data['sub_child_menu_type'] = "lectures";

        //$instituteID = $this->uri->segment(3);
        //$this->data['insta_id'] = $instituteID ? $instituteID : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        $this->data['pub_lect_title'] = 'Expert Talk';
        if($this->data['insta_id'] != 50)
        {
            $this->data['pub_lect_title'] = 'Guest';
        }
        validate_permissions('Public_lectures', 'lectures', $this->config->item('method_for_view'), $this->data['insta_id']);

        $this->data['data_list']    = $this->get_lectures('', ['institute_id' => $this->data['insta_id']]);
        $this->data['title']        = _l("lectures", $this);
        $this->data['page']         = "lecture";
        $this->data['content']      = $this->load->view('cms/expert_talk/public_lectures/index', $this->data, true);
        $this->load->view($this->mainTemplate, $this->data);
    }

    function managelecture( $id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "lectures";
        $this->data['child_menu_type'] = "lectures";
        $this->data['sub_child_menu_type'] = "save_lecture";

        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        $this->data['pub_lect_title'] = 'Public';
        if($this->data['insta_id'] != 50)
        {
            $this->data['pub_lect_title'] = 'Guest';
        }
        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Public_lectures', 'managelecture', $per_action, $this->data['insta_id']);

        $this->data['title']                    = _l("lectures", $this);
        $this->data['page']                     = "lecture";
        $this->data['post_data']                = [];
        $this->data['lecture_id']               = $id;
        $this->data['post_data']['public']      = 1;
        $this->data['speakers']                 = $this->common_model->custom_query('SELECT speaker_id, CONCAT(first_name," ",last_name) as speaker_name FROM speakers WHERE public = "1" AND institute_id = "'.$this->data['insta_id'].'"');
        $this->data['categories']               = $this->Somaiya_general_admin_model->get_all_categories();
        $this->data['departments']              = $this->Somaiya_general_admin_model->get_all_departments();
        $this->data['area_of_interest_array']   = [];

        if($id)
        {
            $lecturedata = $this->get_lectures($id, ['institute_id' => $this->data['insta_id']]);
            $this->data['post_data'] = isset($lecturedata[0]) ? $lecturedata[0] : [];
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Lecture not found']);
                //redirect(base_url().'public_lectures/lectures/'.$this->data['insta_id']);
                redirect(base_url().'cms/public_lectures/lectures/');
            }
            else
            {
                $this->data['area_of_interest_array'] = isset($lecturedata[0]['area_of_interest']) ? explode(',', $lecturedata[0]['area_of_interest'] ): [];
            }
        }

        if($this->input->post())
        {
            $this->data['post_data']                = $this->input->post();
            $this->data['area_of_interest_array']   = $this->input->post('area_of_interest');
        }

        $this->form_validation->set_rules('title', 'Lecture Title', 'required|max_length[250]');
        $this->form_validation->set_rules('speaker_id', 'Speaker', 'required');
        $this->form_validation->set_rules('start_date_time', 'Start Date & Time', 'required');
        $this->form_validation->set_rules('end_date_time', 'End Date & Time', 'required');
        $this->form_validation->set_rules('venue', 'Venue', 'required|max_length[250]');
        $this->form_validation->set_rules('area_of_interest', 'Area Of Interest', '');
        $this->form_validation->set_rules('image', 'Image', '');
        $this->form_validation->set_rules('public', 'Public', '');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {
                $area_of_interest = implode(',', $this->input->post('area_of_interest'));
                $this->common_model->set_table('public_lectures');
                if($id)
                {
                    $update['title']            = $this->input->post('title');
                    $update['speaker_id']       = $this->input->post('speaker_id');
                    $update['department_id']    = $this->input->post('department_id');
                    //$update['institute_id']     = $this->input->post('insta_id');
                    $update['institute_id']     = $this->session->userdata['sess_institute_id'];
                    $update['start_date_time']  = $this->input->post('start_date_time');
                    $update['end_date_time']    = $this->input->post('end_date_time');
                    $update['venue']            = $this->input->post('venue');
                    $update['area_of_interest'] = $area_of_interest;
                    $update['image']            = $this->input->post('image');
                    $update['public']           = $this->input->post('public');
                    $update['modified_on']      = date('Y-m-d H:i:s');
                    $update['modified_by']      = $this->session->userdata['user_id'];

                    $response = $this->common_model->_update('lecture_id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $update1['title']               = $this->input->post('title');
                        $update1['abstract_to_talk']    = $this->input->post('abstract_to_talk');
                        $update1['public']              = $this->input->post('public');
                        $update1['modified_on']         = date('Y-m-d H:i:s');
                        $update1['modified_by']         = $this->session->userdata['user_id'];

                        $this->common_model->set_table('public_lecture_content');
                        $response1 = $this->common_model->_update_with_multiple_conditions(['lecture_id' => $id, 'language_id' => 1], $update1);

                        if(isset($response1['status']) && $response1['status'] == 'success')
                        {
                            $msg = ['error' => 0, 'message' => 'Lecture successfully updated'];
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
                    $insert['title']            = $this->input->post('title');
                    $insert['speaker_id']       = $this->input->post('speaker_id');
                    $insert['department_id']    = $this->input->post('department_id');
                    //$insert['institute_id']     = $this->input->post('insta_id');
                    $insert['institute_id']     = $this->session->userdata['sess_institute_id'];
                    $insert['start_date_time']  = $this->input->post('start_date_time');
                    $insert['end_date_time']    = $this->input->post('end_date_time');
                    $insert['venue']            = $this->input->post('venue');
                    $insert['area_of_interest'] = $area_of_interest;
                    $insert['image']            = $this->input->post('image');
                    $insert['public']           = $this->input->post('public');
                    $insert['created_on']       = date('Y-m-d H:i:s');
                    $insert['created_by']       = $this->session->userdata['user_id'];
                    $insert['modified_on']      = date('Y-m-d H:i:s');
                    $insert['modified_by']      = $this->session->userdata['user_id'];

                    $response = $this->common_model->_insert($insert);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $insert1['lecture_id']          = $response['id'];
                        $insert1['language_id']         = 1;
                        $insert1['title']               = $this->input->post('title');
                        $insert1['abstract_to_talk']    = $this->input->post('abstract_to_talk');
                        $insert1['public']              = $this->input->post('public');
                        $insert1['created_on']          = date('Y-m-d H:i:s');
                        $insert1['created_by']          = $this->session->userdata['user_id'];
                        $insert1['modified_on']         = date('Y-m-d H:i:s');
                        $insert1['modified_by']         = $this->session->userdata['user_id'];

                        $this->common_model->set_table('public_lecture_content');
                        $response1 = $this->common_model->_insert($insert1);

                        if(isset($response1['status']) && $response1['status'] == 'success')
                        {
                            $msg = ['error' => 0, 'message' => 'Lecture successfully added'];
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
                //redirect(base_url().'public_lectures/lectures/'.$this->data['insta_id']);
                redirect(base_url().'cms/public_lectures/lectures/');
            }
        }
        $this->data['content']      = $this->load->view('cms/expert_talk/public_lectures/form', $this->data, true);
        $this->load->view($this->mainTemplate, $this->data);
    }

    function get_lectures($id='', $conditions=[], $order_by='')
    {
        $sql = 'SELECT pl.*, (SELECT CONCAT(first_name," ",last_name) from speakers s where s.speaker_id = pl.speaker_id) as speaker_name, (SELECT (plc.abstract_to_talk) from public_lecture_content plc where plc.lecture_id = pl.lecture_id ORDER BY plc.public_lecture_content_id ASC LIMIT 1) as abstract_to_talk FROM public_lectures pl WHERE 1=1';
        foreach ($conditions as $key => $value) {
            $sql .= ' AND pl.'.$key.' = "'.$value.'"';
        }
        if($id)
        {
            $sql .= ' AND pl.lecture_id = "'.$id.'"';
        }
        if($order_by)
        {
            $sql .= ' ORDER BY "'.$order_by.'"';
        }
        else
        {
            $sql .= ' ORDER BY pl.lecture_id DESC';
        }
        $result = $this->common_model->custom_query($sql);
        return $result;
    }

    function deletelecture($id='')
    {
        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        $this->data['pub_lect_title'] = 'Public';
        if($this->data['insta_id'] != 50)
        {
            $this->data['pub_lect_title'] = 'Guest';
        }
        validate_permissions('Public_lectures', 'deletelecture', $this->config->item('method_for_delete'), $this->data['insta_id']);

        $lecturedata = $this->get_lectures($id, ['institute_id' => $this->data['insta_id']]);
        if(!empty($lecturedata))
        {
            $this->common_model->set_table('public_lectures');
            $response = $this->common_model->_delete('lecture_id', $id);
            $this->common_model->set_table('public_lecture_content');
            $response = $this->common_model->_delete('lecture_id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Lecture not found.']);
        }
        //redirect(base_url().'public_lectures/lectures/'.$this->data['insta_id']);
        redirect(base_url().'cms/public_lectures/lectures/');
    }

    function lecture_content($id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "lectures";
        $this->data['child_menu_type'] = "lectures";
        $this->data['sub_child_menu_type'] = "lectures";

        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        $this->data['pub_lect_title'] = 'Public';
        if($this->data['insta_id'] != 50)
        {
            $this->data['pub_lect_title'] = 'Guest';
        }
        $lecturedata = $this->get_lectures($id, ['institute_id' => $this->data['insta_id']]);

        if(!empty($lecturedata))
        {
            $this->data['data_list']    = $this->get_lecture_content($id);
            $this->data['title']        = _l("lecture_content", $this);
            $this->data['page']         = "lecturecontent";
            $this->data['lecture_id']   = $id;
            $this->data['content']      = $this->load->view('cms/expert_talk/public_lectures/content', $this->data, true);
            $this->load->view($this->mainTemplate, $this->data);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'No lecture found']);
            //redirect(base_url().'public_lectures/lectures/'.$this->data['insta_id']);
            redirect(base_url().'cms/public_lectures/lectures/');
        }
    }

    function managelecturecontent($lecture_id='', $public_lecture_content_id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "lectures";
        $this->data['child_menu_type'] = "lectures";
        $this->data['sub_child_menu_type'] = "lectures";

        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        $this->data['pub_lect_title'] = 'Public';
        if($this->data['insta_id'] != 50)
        {
            $this->data['pub_lect_title'] = 'Guest';
        }
        $lecturedata = $this->get_lectures($lecture_id, ['institute_id' => $this->data['insta_id']]);

        if(!empty($lecturedata))
        {
            $this->data['title']                    = _l("lecture_content", $this);
            $this->data['page']                     = "lecturecontent";
            $this->data['post_data']                = [];
            $this->data['public_lecture_content_id']= $public_lecture_content_id;
            $this->data['lecture_id']               = $lecture_id;
            $this->data['post_data']['public']      = 1;
            $this->data['languages']                = $this->Somaiya_general_admin_model->get_all_language();

            if($public_lecture_content_id)
            {
                $lecturecontentdata = $this->get_lecture_content($lecture_id, $public_lecture_content_id);
                $this->data['post_data'] = isset($lecturecontentdata[0]) ? $lecturecontentdata[0] : [];
                if(empty($this->data['post_data']))
                {
                    $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Lecture content not found']);
                    //redirect(base_url().'public_lectures/lecture_content/'.$this->data['insta_id'].'/'.$lecture_id);
                    redirect(base_url().'cms/public_lectures/lecture_content/'.$lecture_id);
                }
            }

            if($this->input->post())
            {
                $this->data['post_data'] = $this->input->post();
            }

            $this->form_validation->set_rules('title', 'Lecture Title', 'required|max_length[250]');
            $this->form_validation->set_rules('language_id', 'Language', 'required|callback_unique_language');
            $this->form_validation->set_rules('abstract_to_talk', 'Abstract To Talk', '');
            $this->form_validation->set_rules('public', 'Public', '');

            if($this->form_validation->run($this) === TRUE)
            {
                if($this->input->post())
                {
                    $this->common_model->set_table('public_lecture_content');
                    if($public_lecture_content_id)
                    {
                        $update['title']            = $this->input->post('title');
                        $update['language_id']      = $this->input->post('language_id');
                        $update['abstract_to_talk'] = $this->input->post('abstract_to_talk');
                        $update['public']           = $this->input->post('public');
                        $update['modified_on']      = date('Y-m-d H:i:s');
                        $update['modified_by']      = $this->session->userdata['user_id'];

                        $response = $this->common_model->_update('public_lecture_content_id', $public_lecture_content_id, $update);
                        if(isset($response['status']) && $response['status'] == 'success')
                        {
                            if($this->input->post('language_id') == 1)
                            {
                                $update1['title']       = $this->input->post('title');
                                $update1['modified_on'] = date('Y-m-d H:i:s');
                                $update1['modified_by'] = $this->session->userdata['user_id'];
                                $this->common_model->set_table('public_lectures');
                                $response1 = $this->common_model->_update('lecture_id', $lecture_id, $update1);
                            }

                            $msg = ['error' => 0, 'message' => 'Lecture content successfully updated'];
                        }
                        else
                        {
                            $msg = ['error' => 0, 'message' => $response['message']];
                        }
                    }
                    else
                    {
                        $insert['title']            = $this->input->post('title');
                        $insert['abstract_to_talk'] = $this->input->post('abstract_to_talk');
                        $insert['lecture_id']       = $lecture_id;
                        $insert['language_id']      = $this->input->post('language_id');
                        $insert['public']           = $this->input->post('public');
                        $insert['created_on']       = date('Y-m-d H:i:s');
                        $insert['created_by']       = $this->session->userdata['user_id'];
                        $insert['modified_on']      = date('Y-m-d H:i:s');
                        $insert['modified_by']      = $this->session->userdata['user_id'];

                        $response = $this->common_model->_insert($insert);
                        if(isset($response['status']) && $response['status'] == 'success')
                        {
                            $msg = ['error' => 0, 'message' => 'Lecture content successfully added'];
                        }
                        else
                        {
                            $msg = ['error' => 0, 'message' => $response['message']];
                        }
                    }
                    $this->session->set_flashdata('requeststatus', $msg);
                    //redirect(base_url().'public_lectures/lecture_content/'.$this->data['insta_id'].'/'.$lecture_id);
                    redirect(base_url().'cms/public_lectures/lecture_content/'.$lecture_id);
                }
            }
            $this->data['content']      = $this->load->view('cms/expert_talk/public_lectures/form_content', $this->data, true);
            $this->load->view($this->mainTemplate, $this->data);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'No lecture found']);
            //redirect(base_url().'public_lectures/lectures/'.$this->data['insta_id']);
            redirect(base_url().'cms/public_lectures/lectures/');
        }
    }

    function get_lecture_content($lecture_id='', $public_lecture_content_id='', $conditions=[], $order_by='')
    {
        $sql = 'SELECT plc.*, l.language_name FROM public_lecture_content plc left join languages l ON l.language_id = plc.language_id WHERE plc.lecture_id = "'.$lecture_id.'"';
        foreach ($conditions as $key => $value) {
            $sql .= ' AND plc.'.$key.' = "'.$value.'"';
        }
        if($public_lecture_content_id)
        {
            $sql .= ' AND plc.public_lecture_content_id = "'.$public_lecture_content_id.'"';
        }
        if($order_by)
        {
            $sql .= ' ORDER BY "'.$order_by.'"';
        }
        else
        {
            $sql .= ' ORDER BY plc.public_lecture_content_id DESC';
        }
        $result = $this->common_model->custom_query($sql);
        return $result;
    }

    function deletelecturecontent($lecture_id='', $public_lecture_content_id='', $language_id='')
    {
        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        $this->data['pub_lect_title'] = 'Public';
        if($this->data['insta_id'] != 50)
        {
            $this->data['pub_lect_title'] = 'Guest';
        }
        if($language_id != 1)
        {
            $lecturedata = $this->get_lectures($lecture_id, ['institute_id' => $this->data['insta_id']]);
            if(!empty($lecturedata))
            {
                $this->common_model->set_table('public_lecture_content');
                $response = $this->common_model->_delete('public_lecture_content_id', $public_lecture_content_id);
                $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
            }
            else
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Lecture not found.']);
            }
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'You can not delete default lecture content']);
        }
        //redirect(base_url().'public_lectures/lecture_content/'.$this->data['insta_id'].'/'.$lecture_id);
        redirect(base_url().'cms/public_lectures/lecture_content/'.$lecture_id);
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
        $public_lecture_content_id  = isset($_POST['public_lecture_content_id']) ? $_POST['public_lecture_content_id'] : '';
        $lecture_id                 = isset($_POST['lecture_id']) ? $_POST['lecture_id'] : '';
        $language_id                = isset($_POST['language_id']) ? $_POST['language_id'] : '';
        $errormessage               = 'Lecture content for this language is already exist.';
        $this->form_validation->set_message('unique_language', $errormessage);

        if($public_lecture_content_id)
        {
            $content = $this->common_model->custom_query('Select * FROM public_lecture_content WHERE language_id = "'.$language_id.'" AND lecture_id = "'.$lecture_id.'" AND public_lecture_content_id != "'.$public_lecture_content_id.'"');
        }
        else
        {
            $content = $this->common_model->custom_query('Select * FROM public_lecture_content WHERE language_id="'.$language_id.'" AND lecture_id = "'.$lecture_id.'"');
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

    function reviews($id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "lectures";
        $this->data['child_menu_type'] = "lectures";
        $this->data['sub_child_menu_type'] = "lectures";

        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        $this->data['pub_lect_title'] = 'Public';
        if($this->data['insta_id'] != 50)
        {
            $this->data['pub_lect_title'] = 'Guest';
        }
        $lecturedata = $this->get_lectures($id, ['institute_id' => $this->data['insta_id']]);

        if(!empty($lecturedata))
        {
            $this->data['data_list']    = $this->get_lecture_reviews($id);
            $this->data['title']        = _l("lecture_reviews", $this);
            $this->data['page']         = "lecturereview";
            $this->data['lecture_id']   = $id;
            $this->data['content']      = $this->load->view('cms/expert_talk/public_lectures/reviews', $this->data, true);
            $this->load->view($this->mainTemplate, $this->data);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'No lecture found']);
            //redirect(base_url().'public_lectures/lectures/'.$this->data['insta_id']);
            redirect(base_url().'cms/public_lectures/lectures/');
        }
    }

    function managelecturereview($lecture_id='', $review_id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "lectures";
        $this->data['child_menu_type'] = "lectures";
        $this->data['sub_child_menu_type'] = "lectures";

        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        $this->data['pub_lect_title'] = 'Public';
        if($this->data['insta_id'] != 50)
        {
            $this->data['pub_lect_title'] = 'Guest';
        }
        $lecturedata = $this->get_lectures($lecture_id, ['institute_id' => $this->data['insta_id']]);

        if(!empty($lecturedata))
        {
            $this->data['title']                    = _l("lecture_reviews", $this);
            $this->data['page']                     = "lecturereview";
            $this->data['post_data']                = [];
            $this->data['review_id']                = $review_id;
            $this->data['lecture_id']               = $lecture_id;
            $this->data['post_data']['public']      = 1;
            $this->data['languages']                = $this->Somaiya_general_admin_model->get_all_language();

            if($review_id)
            {
                $lecturereviewdata                  = $this->get_lecture_reviews($lecture_id, $review_id);
                $this->data['post_data'] = isset($lecturereviewdata[0]) ? $lecturereviewdata[0] : [];
                if(empty($this->data['post_data']))
                {
                    $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Lecture review not found']);
                    //redirect(base_url().'public_lectures/reviews/'.$this->data['insta_id'].'/'.$lecture_id);
                    redirect(base_url().'cms/public_lectures/reviews/'.$lecture_id);
                }
            }

            if($this->input->post())
            {
                $this->data['post_data'] = $this->input->post();
            }

            // $this->form_validation->set_rules('name', 'Name', 'required|max_length[250]');
            $this->form_validation->set_rules('review', 'Abstract To Talk', 'required');
            $this->form_validation->set_rules('public', 'Public', '');

            if($this->form_validation->run($this) === TRUE)
            {
                if($this->input->post())
                {
                    $this->common_model->set_table('public_lecture_reviews');
                    if($review_id)
                    {
                        $update['name']             = $this->input->post('name');
                        $update['review']           = $this->input->post('review');
                        $update['public']           = $this->input->post('public');
                        $update['modified_on']      = date('Y-m-d H:i:s');
                        $update['modified_by']      = $this->session->userdata['user_id'];

                        $response = $this->common_model->_update('review_id', $review_id, $update);
                        if(isset($response['status']) && $response['status'] == 'success')
                        {
                            $msg = ['error' => 0, 'message' => 'Lecture review successfully updated'];
                        }
                        else
                        {
                            $msg = ['error' => 0, 'message' => $response['message']];
                        }
                    }
                    else
                    {
                        $insert['name']             = $this->input->post('name');
                        $insert['review']           = $this->input->post('review');
                        $insert['lecture_id']       = $lecture_id;
                        $insert['public']           = $this->input->post('public');
                        $insert['created_on']       = date('Y-m-d H:i:s');
                        $insert['created_by']       = $this->session->userdata['user_id'];
                        $insert['modified_on']      = date('Y-m-d H:i:s');
                        $insert['modified_by']      = $this->session->userdata['user_id'];

                        $response = $this->common_model->_insert($insert);
                        if(isset($response['status']) && $response['status'] == 'success')
                        {
                            $msg = ['error' => 0, 'message' => 'Lecture review successfully added'];
                        }
                        else
                        {
                            $msg = ['error' => 0, 'message' => $response['message']];
                        }
                    }
                    $this->session->set_flashdata('requeststatus', $msg);
                    //redirect(base_url().'public_lectures/reviews/'.$this->data['insta_id'].'/'.$lecture_id);
                    redirect(base_url().'cms/public_lectures/reviews/'.$lecture_id);
                }
            }
            $this->data['content']      = $this->load->view('cms/expert_talk/public_lectures/form_review', $this->data, true);
            $this->load->view($this->mainTemplate, $this->data);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'No lecture found']);
            //redirect(base_url().'public_lectures/lectures/'.$this->data['insta_id']);
            redirect(base_url().'cms/public_lectures/lectures/');
        }
    }

    function deletelecturereview($lecture_id='', $id=0)
    {
        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        $this->data['pub_lect_title'] = 'Public';
        if($this->data['insta_id'] != 50)
        {
            $this->data['pub_lect_title'] = 'Guest';
        }
        $lecturedata = $this->get_lectures($lecture_id, ['institute_id' => $this->data['insta_id']]);

        if(!empty($lecturedata))
        {
            $this->common_model->set_table('public_lecture_reviews');
            $response = $this->common_model->_delete('review_id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
            //redirect(base_url().'public_lectures/reviews/'.$this->data['insta_id'].'/'.$lecture_id);
            redirect(base_url().'cms/public_lectures/reviews/'.$lecture_id);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Lecture not found.']);
            //redirect(base_url().'public_lectures/lectures/'.$this->data['insta_id']);
            redirect(base_url().'cms/public_lectures/lectures/');
        }
    }

    function get_lecture_reviews($lecture_id='', $review_id='', $conditions=[], $order_by='')
    {
        $sql = 'SELECT plr.* FROM public_lecture_reviews plr WHERE plr.lecture_id = "'.$lecture_id.'"';
        foreach ($conditions as $key => $value) {
            $sql .= ' AND plr.'.$key.' = "'.$value.'"';
        }
        if($review_id)
        {
            $sql .= ' AND plr.review_id = "'.$review_id.'"';
        }
        if($order_by)
        {
            $sql .= ' ORDER BY "'.$order_by.'"';
        }
        else
        {
            $sql .= ' ORDER BY plr.review_id DESC';
        }
        $result = $this->common_model->custom_query($sql);
        return $result;
    }

    function resources( $id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "lectures";
        $this->data['child_menu_type'] = "lectures";
        $this->data['sub_child_menu_type'] = "lectures";

        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        $this->data['pub_lect_title'] = 'Public';
        if($this->data['insta_id'] != 50)
        {
            $this->data['pub_lect_title'] = 'Guest';
        }
        $this->data['title']                    = _l("resources", $this);
        $this->data['page']                     = "resource";
        $this->data['post_data']                = [];
        $this->data['lecture_id']               = $id;
        $this->data['post_data']['public']      = 1;
        $this->data['gallery']                  = $this->get_gallery();

        if($id)
        {
            $lecturedata                        = $this->get_lectures($id, ['institute_id' => $this->data['insta_id']]);
            $this->data['post_data']            = isset($lecturedata[0]) ? $lecturedata[0] : [];
            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Lecture not found']);
                //redirect(base_url().'public_lectures/lectures/'.$this->data['insta_id']);
                redirect(base_url().'cms/public_lectures/lectures/');
            }
            else
            {
                if(isset($lecturedata[0]['videos']) && !empty($lecturedata[0]['videos']))
                {
                    $this->data['post_data']['videos'] = json_decode($lecturedata[0]['videos']);
                }
                if(isset($lecturedata[0]['albums']) && !empty($lecturedata[0]['albums']))
                {
                    $this->data['post_data']['albums'] = explode(',', $lecturedata[0]['albums']);
                }
                else
                {
                    $this->data['post_data']['albums'] = [];
                }
                if(isset($lecturedata[0]['presentations']) && !empty($lecturedata[0]['presentations']))
                {
                    $this->data['post_data']['presentations'] = json_decode($lecturedata[0]['presentations']);
                }
            }
        }

        if($this->input->post())
        {
            $this->data['post_data'] = $this->input->post();
            if(isset($_POST['videos']) && !empty($_POST['videos']))
            {
                $this->data['post_data']['videos'] = $_POST['videos'];
            }
            if(isset($_POST['albums']) && !empty($_POST['albums']))
            {
                $this->data['post_data']['albums'] = $_POST['albums'];
            }

            if(!empty($this->input->post('videos')))
            {
                $videos             = array_filter($this->input->post('videos'));
                $update['videos']   = json_encode($videos);
            }
            if(!empty($this->input->post('albums')))
            {
                $update['albums']   = implode(',', $this->input->post('albums'));
            }
            else
            {
                $update['albums']   = null;
            }
            $update['modified_on']  = date('Y-m-d H:i:s');
            $update['modified_by']  = $this->session->userdata['user_id'];
            $presentations = [];
            if(isset($_FILES['presentations']) && !empty($_FILES['presentations']))
            {
                $presentations = $this->upload_files(substr(FCPATH, 0, -1).'\upload_file\public_lectures', 'public_lecture', 'upload_file/public_lectures/', $_FILES['presentations']);
            }

            if(!empty($presentations))
            {
                $update['presentations']   = json_encode($presentations);
            }

            $this->common_model->set_table('public_lectures');
            $response = $this->common_model->_update('lecture_id', $id, $update);
            if(isset($response['status']) && $response['status'] == 'success')
            {
                $msg = ['error' => 0, 'message' => 'Lecture resources successfully saved'];
            }
            else
            {
                $msg = ['error' => 0, 'message' => $response['message']];
            }
            $this->session->set_flashdata('requeststatus', $msg);
            //redirect(base_url().'public_lectures/lectures/'.$this->data['insta_id']);
            redirect(base_url().'cms/public_lectures/lectures/');
        }
        $this->data['content']      = $this->load->view('cms/expert_talk/public_lectures/form_resources', $this->data, true);
        $this->load->view($this->mainTemplate, $this->data);
    }

    function interests($lecture_id=0)
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "lectures";
        $this->data['child_menu_type'] = "lectures";
        $this->data['sub_child_menu_type'] = "lectures";

        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        $this->data['pub_lect_title'] = 'Public';
        if($this->data['insta_id'] != 50)
        {
            $this->data['pub_lect_title'] = 'Guest';
        }
        $lecturedata = $this->get_lectures($lecture_id, ['institute_id' => $this->data['insta_id']]);

        if(!empty($lecturedata))
        {
            $this->data['data_list']    = $this->get_lecture_interests($lecture_id);
            $this->data['title']        = _l("lectures", $this);
            $this->data['page']         = "lectureinterests";
            $this->data['lecture_id']   = $lecture_id;
            $this->data['content']      = $this->load->view('cms/expert_talk/public_lectures/interests', $this->data, true);
            $this->load->view($this->mainTemplate, $this->data);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Lecture not found.']);
            //redirect(base_url().'public_lectures/lectures/'.$this->data['insta_id']);
            redirect(base_url().'cms/public_lectures/lectures/');
        }
    }

    function deletelectureinterests($lecture_id='', $id=0)
    {
        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        $this->data['pub_lect_title'] = 'Public';
        if($this->data['insta_id'] != 50)
        {
            $this->data['pub_lect_title'] = 'Guest';
        }
        $lecturedata = $this->get_lectures($lecture_id, ['institute_id' => $this->data['insta_id']]);

        if(!empty($lecturedata))
        {
            $this->common_model->set_table('public_lecture_interests');
            $response = $this->common_model->_delete('interest_id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
            //redirect(base_url().'public_lectures/interests/'.$this->data['insta_id'].'/'.$lecture_id);
            redirect(base_url().'cms/public_lectures/interests/'.$lecture_id);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Lecture not found.']);
            //redirect(base_url().'public_lectures/lectures/'.$this->data['insta_id']);
            redirect(base_url().'cms/public_lectures/lectures/');
        }
    }

    function get_lecture_interests($id='', $conditions=[], $order_by='')
    {
        $sql = 'SELECT * FROM public_lecture_interests WHERE 1=1';
        foreach ($conditions as $key => $value) {
            $sql .= ' AND '.$key.' = "'.$value.'"';
        }
        if($id)
        {
            $sql .= ' AND lecture_id = "'.$id.'"';
        }
        if($order_by)
        {
            $sql .= ' ORDER BY "'.$order_by.'"';
        }
        else
        {
            $sql .= ' ORDER BY interest_id DESC';
        }
        $result = $this->common_model->custom_query($sql);
        return $result;
    }

    function email_list($id=0)
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "lectures";
        $this->data['child_menu_type'] = "lectures_email_list";
        $this->data['sub_child_menu_type'] = "";

        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        $this->data['pub_lect_title'] = 'Public';
        if($this->data['insta_id'] != 50)
        {
            $this->data['pub_lect_title'] = 'Guest';
        }
        validate_permissions('Public_lectures', 'email_list', $this->config->item('method_for_view'), $this->data['insta_id']);

        if($this->data['insta_id'])
        {
            $this->data['data_list']    = $this->get_lecture_email_list($this->data['insta_id'], $id);
            $this->data['title']        = _l("lectures", $this);
            $this->data['page']         = "lectureemaillist";
            $this->data['content']      = $this->load->view('cms/expert_talk/public_lectures/email_list', $this->data, true);
            $this->load->view($this->mainTemplate, $this->data);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'No institute selected.']);
            redirect(base_url().'admin/');
        }
    }

    function deletelectureemaillist($id=0)
    {
        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        $this->data['pub_lect_title'] = 'Public';
        if($this->data['insta_id'] != 50)
        {
            $this->data['pub_lect_title'] = 'Guest';
        }
        validate_permissions('Public_lectures', 'deletelectureemaillist', $this->config->item('method_for_delete'), $this->data['insta_id']);
        
        if($this->data['insta_id'])
        {
            $lecture_email_list = $this->get_lecture_email_list($this->data['insta_id'], $id);
            if(!empty($lecture_email_list))
            {
                $this->common_model->set_table('public_lecture_email_list');
                $response = $this->common_model->_delete('id', $id);
                $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
            }
            else
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'No email record found.']);
            }
            //redirect(base_url().'public_lectures/email_list/'.$this->data['insta_id']);
            redirect(base_url().'cms/public_lectures/email_list/');
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'No institute selected.']);
            redirect(base_url().'admin/');
        }
    }

    function get_lecture_email_list($insta_id='', $id='', $conditions=[], $order_by='')
    {
        $sql = 'SELECT * FROM subscribe WHERE 1=1';
        $sql .= ' AND type = "public_lectures"';
        foreach ($conditions as $key => $value) {
            $sql .= ' AND '.$key.' = "'.$value.'"';
        }
        /*if($insta_id)
        {
            $sql .= ' AND institute_id = "'.$insta_id.'"';
        }*/
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

    function get_gallery()
    {
        $sql    = 'SELECT * FROM galleries WHERE 1=1';
        $sql    .= ' ORDER BY name ASC';
        $result = $this->common_model->custom_query($sql);
        return $result;
    }

    private function upload_files($path, $title, $url_path, $files)
    {
        $config = array(
            'upload_path'   => $path,
            'allowed_types' => 'pdf|doc|docx|odt|txt|json|csv|pptx|xls|xlsx',
            'file_name' => time(),
        );

        $this->load->library('upload', $config);

        $uploadedfiles = [];

        foreach ($files['name'] as $key => $image) {
            $_FILES['uploadedfiles']['name']     = $files['name'][$key];
            $_FILES['uploadedfiles']['type']     = $files['type'][$key];
            $_FILES['uploadedfiles']['tmp_name'] = $files['tmp_name'][$key];
            $_FILES['uploadedfiles']['error']    = $files['error'][$key];
            $_FILES['uploadedfiles']['size']     = $files['size'][$key];

            $fileName                            = $title .'_'. $image;
            $config['file_name']                 = $fileName;

            $this->upload->initialize($config);

            if($this->upload->do_upload('uploadedfiles')) {
                $this->upload->data();
                $uploadedfiles[] = ['name' => explode('.', $this->upload->data()['client_name'])[0], 'path' => $url_path.$this->upload->data()['file_name']];
            } else {
                return false;
            }
        }

        return $uploadedfiles;
    }

    function export_interests($lecture_id='')
    {
        $interests                  = $this->get_lecture_interests($lecture_id);
        if(!empty($interests))
        {
            $this->load->library("excel");
            $object = new PHPExcel();
            $object->setActiveSheetIndex(0);

            $table_columns = array("Name", "Email", "Mobile Number");

            $column = 0;

            foreach($table_columns as $field)
            {
                $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                $column++;
            }

            $excel_row = 2;

            foreach($interests as $row)
            {
                $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['name']);
                $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['email']);
                $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['mobile']);
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
            //redirect(base_url()."public_lectures/interests/".$lecture_id);
            redirect(base_url()."cms/public_lectures/interests/".$lecture_id);
        }
    }

    function export_email_list()
    {
        //$this->data['insta_id'] = $insta_id ? $insta_id : $this->default_institute_id;
        $this->data['insta_id']         = $this->session->userdata['sess_institute_id'];

        $this->data['pub_lect_title'] = 'Public';
        if($this->data['insta_id'] != 50)
        {
            $this->data['pub_lect_title'] = 'Guest';
        }
        validate_permissions('Public_lectures', 'export_email_list', $this->config->item('method_for_export'), $this->data['insta_id']);

        $email_list                  = $this->get_lecture_email_list($this->data['insta_id']);
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
            //redirect(base_url()."public_lectures/email_list/".$this->data['insta_id']);
            redirect(base_url()."cms/public_lectures/email_list/");
        }
    }
}
