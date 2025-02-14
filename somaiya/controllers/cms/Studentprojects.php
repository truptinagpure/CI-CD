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
class Studentprojects extends Somaiya_Controller {
    private $permissions;
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/student_projects/Studentprojects_model','Studentprojects_model');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
    }

    function index($id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "studentprojects";
        $this->data['child_menu_type'] = "studentprojects";
        $this->data['sub_child_menu_type'] = "";

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];


        validate_permissions('Studentprojects', 'index', $this->config->item('method_for_view'), $this->data['institute_id']);

        $this->data['data_list']    = $this->Studentprojects_model->get_all_students_projects($this->data['institute_id']);
        // echo "<pre>";
        // print_r($this->data['data_list']);
        // exit();

        $this->data['title']        = 'Studentprojects';
        $this->data['page']         = 'studentprojects';
        $this->data['content']      = $this->load->view('cms/student_projects/index', $this->data, true);
        $this->load->view($this->mainTemplate, $this->data);
    }

    function manageproject($id='',$project_content_id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "studentprojects";
        $this->data['child_menu_type'] = "studentprojects";
        $this->data['sub_child_menu_type'] = "save_student_project";

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Studentprojects', 'manageproject', $per_action);

        $this->data['title']                = 'studentprojects';
        $this->data['page']                 = 'studentprojects';
        $this->data['post_data']            = [];
        $this->data['project_id']           = $id;
        $this->data['post_data']['public']  = 1;
        $this->data['languages']            = $this->Somaiya_general_admin_model->get_all_language();
        $this->data['institutes_list']      = $this->Somaiya_general_admin_model->get_all_institute();
        $instituteID                        = $this->session->userdata('sess_institute_id');
        
        if($id)
        {
            $this->data['post_data'] = $this->Studentprojects_model->get_student_project($id);
            $this->data['data_image'] = $this->Studentprojects_model->data_image($id);

            if(empty($this->data['post_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Student project not found']);
                redirect(base_url().'studentprojects/index/'.$_SESSION['inst_id']);
            }

            if(isset($this->data['post_data']['institute_id']) && !empty($this->data['post_data']['institute_id']))
            {
                $this->data['institute_id'] = explode(',', $this->data['post_data']['institute_id']);
            }
        }

        if($this->input->post())
        {
            $this->data['post_data']     = $this->input->post();
        }

        $this->form_validation->set_rules('name', 'Project', 'required');
        //$this->form_validation->set_rules('public', 'Public', '');

        if($this->form_validation->run($this) === TRUE)
        { 
            if($this->input->post())
            {   //print_r($id);exit();
                $pathToUpload = 'upload_file/images20/';
                $pathToUploadlogo = 'upload_file/images20/';
                //$countlogo = count($_FILES['logo']['name']);
                $fileNamefeatured = '';
                $files = $_FILES;
                $count = count($_FILES['userfile']['name']);
                if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) 
                {   
                    $config22['upload_path'] = $pathToUpload;
                    $config22['allowed_types'] = 'gif|jpg|png|jpeg|svg|mp4|mpeg|mpg|avi|mov';
                    $config22['max_size'] = '0';
                    $config22['remove_spaces'] = true;
                    $config22['overwrite'] = false;
                    $config22['max_width'] = '';
                    $config22['max_height'] = '';
                    $fileNamefeatured12 = $_FILES['image']['name'];
                    $fileNamefeatured = str_replace(' ', '_', $fileNamefeatured12);
                    $this->load->library('upload', $config22);
                    $this->upload->initialize($config22);
                    $this->upload->do_upload();
                    if ( ! $this->upload->do_upload('image'))
                    {
                        // codeToMessage($_FILES['file']['error']); 
                        $error = array('error' => $this->upload->display_errors());
                    }
                    else
                    {
                        echo "Success";
                    }         
                }

                if (isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])) 
                { 
                    for($i=0; $i<$count; $i++)
                    {   
                        //print_r($_FILES['userfile']['name']);exit();
                        $_FILES['userfile']['name']= $files['userfile']['name'][$i];
                        $_FILES['userfile']['type']= $files['userfile']['type'][$i];
                        $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
                        $_FILES['userfile']['error']= $files['userfile']['error'][$i];
                        $_FILES['userfile']['size']= $files['userfile']['size'][$i];
                        $config11['upload_path'] = $pathToUpload;
                        $config11['allowed_types'] = 'gif|jpg|png|jpeg|mp4|mpeg|mpg|avi|mov';
                        $config11['max_size'] = '0';
                        $config11['remove_spaces'] = true;
                        $config11['overwrite'] = false;
                        $config11['max_width'] = '';
                        $config11['max_height'] = '';
                        $fileName12 = $_FILES['userfile']['name'];
                        $fileName = str_replace(' ', '_', $fileName12);
                        $images[] = $fileName;
                        $this->load->library('upload', $config11);
                        $this->upload->initialize($config11);
                        $this->upload->do_upload();
                    }
                    $fileName = implode(',',$images);
                }

                /*if (isset($_FILES['logo']['name']) && !empty($_FILES['logo']['name'])) 
                { 
                    for($j=0; $j<$countlogo; $j++)
                    {   
                        $_FILES['logo']['name']= $files['logo']['name'][$j];
                        $_FILES['logo']['type']= $files['logo']['type'][$j];
                        $_FILES['logo']['tmp_name']= $files['logo']['tmp_name'][$j];
                        $_FILES['logo']['error']= $files['logo']['error'][$j];
                        $_FILES['logo']['size']= $files['logo']['size'][$j];
                        $config33['upload_path'] = $pathToUploadlogo;
                        $config33['allowed_types'] = 'gif|jpg|png|jpeg|mp4|mpeg|mpg|avi|mov';
                        $config33['max_size'] = '0';
                        $config33['remove_spaces'] = true;
                        $config33['overwrite'] = false;
                        $config33['max_width'] = '';
                        $config33['max_height'] = '';
                        $fileLogo12 = $_FILES['logo']['name'];
                        $fileLogo = str_replace(' ', '_', $fileLogo12);
                        $imageslogo[] = $fileLogo;
                        $this->load->library('upload', $config33);
                        $this->upload->initialize($config33);
                        $this->upload->do_upload();
                        if ( ! $this->upload->do_upload('logo'))
                        {
                            // codeToMessage($_FILES['file']['error']); 
                            $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            echo "Success";
                        }
                    }
                    $fileLogo = implode(',',$imageslogo);
                }*/
                $fileLogo = '';
                //$response = $this->Studentprojects_model->manage_projects($this->input->post(), $id,$fileName,$fileNamefeatured,$fileLogo);
                $response = $this->Studentprojects_model->manage_projects($this->input->post(), $id,$fileName,$fileNamefeatured,$fileLogo,$instituteID);
                $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
                redirect(base_url().'cms/studentprojects/index/'.$_SESSION['inst_id']);
            }
        }
        $this->data['content']      = $this->load->view('cms/student_projects/form', $this->data, true);
        $this->load->view($this->mainTemplate, $this->data);
    }

    function deleteproject($id=0)
    {
        validate_permissions('Studentprojects', 'deleteproject', $this->config->item('method_for_delete'));

        $this->common_model->set_table('student_projects');
        $response = $this->common_model->_delete('student_project_id', $id);

        $this->common_model->set_table('student_project_images');
        $response = $this->common_model->_delete('student_project_id', $id);

        $this->common_model->set_table('student_project_content');
        $response = $this->common_model->_delete('student_project_id', $id);

        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        redirect(base_url().'cms/studentprojects/index/');
    }

    function get_projects($id='', $conditions=[], $order_by='')
    {
        $sql = 'SELECT pl.* FROM student_projects pl WHERE 1=1';
        foreach ($conditions as $key => $value) {
            $sql .= ' AND pl.'.$key.' = "'.$value.'"';
        }
        if($id)
        {
            $sql .= ' AND pl.student_project_id = "'.$id.'"';
        }
        if($order_by)
        {
            $sql .= ' ORDER BY "'.$order_by.'"';
        }
        else
        {
            $sql .= ' ORDER BY pl.student_project_id DESC';
        }
        $result = $this->common_model->custom_query($sql);
        return $result;
    }

    function project_content($id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "studentprojects";
        $this->data['child_menu_type'] = "studentprojects";
        $this->data['sub_child_menu_type'] = "";

        $lecturedata = $this->get_projects($id);
        if(!empty($lecturedata))
        {
            $this->data['data_list']    = $this->get_project_content($id);
            $this->data['title']        = _l("student project_content", $this);
            $this->data['page']         = "studentprojectcontent";
            $this->data['student_project_id']   = $id;
            $this->data['content']      = $this->load->view('cms/student_projects/content', $this->data, true);
            $this->load->view($this->mainTemplate, $this->data);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'No Project found']);
            redirect(base_url().'cms/studentprojects/index/');
        }
    }

    function manageprojectcontent($project_id='', $project_content_id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "studentprojects";
        $this->data['child_menu_type'] = "studentprojects";
        $this->data['sub_child_menu_type'] = "";

        $lecturedata = $this->get_projects($project_id);
        if(!empty($lecturedata))
        {
            $this->data['title']                            = _l("studentproject_content", $this);
            $this->data['page']                             = "studentprojectcontent";
            $this->data['post_data']                        = [];
            $this->data['student_project_content_id']       = $project_content_id;
            $this->data['student_project_id']               = $project_id;
            $this->data['post_data']['public']              = 1;
            $this->data['languages']                        = $this->Somaiya_general_admin_model->get_all_language();

            if($project_content_id)
            {
                $lecturedata = $this->get_project_content($project_id, $project_content_id);
                $this->data['post_data'] = isset($lecturedata[0]) ? $lecturedata[0] : [];
                if(empty($this->data['post_data']))
                {
                    $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Project content not found']);
                    redirect(base_url().'cms/studentprojects/project_content/'.$project_id);
                }
            }

            if($this->input->post())
            {
                $this->data['post_data'] = $this->input->post();
            }

            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('language_id', 'Language', 'required|callback_unique_language');
            $this->form_validation->set_rules('public', 'Public', '');

            if($this->form_validation->run($this) === TRUE)
            {
                if($this->input->post())
                {
                    $this->common_model->set_table('student_project_content');
                    if($project_content_id)
                    {
                        $update['title']            = $this->input->post('title');
                        $update['language_id']      = $this->input->post('language_id');
                        $update['description']      = $this->input->post('description');
                        $update['public']           = $this->input->post('public');
                        $update['modified_on']      = date('Y-m-d H:i:s');
                        $update['modified_by']      = $this->session->userdata['user_id'];

                        $response = $this->common_model->_update('content_id', $project_content_id, $update);
                         if(isset($response['status']) && $response['status'] == 'success')
                        {
                        //     if($this->input->post('language_id') == 1)
                        //     {
                        //         $update1['name']       = $this->input->post('name');
                        //         $update1['modified_on'] = date('Y-m-d H:i:s');
                        //         $update1['modified_by'] = $this->session->userdata['user_id'];
                        //         $this->common_model->set_table('projects');
                        //         $response1 = $this->common_model->_update('project_id', $project_id, $update1);
                        //     }

                            $msg = ['error' => 0, 'message' => 'Student project content successfully updated'];
                        }
                        else
                        {
                            $msg = ['error' => 0, 'message' => $response['message']];
                        }
                    }
                    else
                    {
                        $insert['title']                    = $this->input->post('title');
                        $insert['description']              = $this->input->post('description');
                        $insert['student_project_id']       = $project_id;
                        $insert['language_id']              = $this->input->post('language_id');
                        $insert['public']                   = $this->input->post('public');
                        $insert['created_on']               = date('Y-m-d H:i:s');
                        $insert['created_by']               = $this->session->userdata['user_id'];
                        $insert['modified_on']              = date('Y-m-d H:i:s');
                        $insert['modified_by']              = $this->session->userdata['user_id'];

                        $response = $this->common_model->_insert($insert);
                        if(isset($response['status']) && $response['status'] == 'success')
                        {
                            $msg = ['error' => 0, 'message' => 'Student project content successfully added'];
                        }
                        else
                        {
                            $msg = ['error' => 0, 'message' => $response['message']];
                        }
                    }
                    $this->session->set_flashdata('requeststatus', $msg);
                    redirect(base_url().'cms/studentprojects/project_content/'.$project_id);
                }
            }
            $this->data['content']      = $this->load->view('cms/student_projects/form_content', $this->data, true);
            $this->load->view($this->mainTemplate, $this->data);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'No Student Project found']);
            redirect(base_url().'cms/studentprojects/index/');
        }
    }

    function get_project_content($project_id='', $project_content_id='', $conditions=[], $order_by='')
    {
        $sql = 'SELECT plc.*, l.language_name FROM student_project_content plc join languages l ON l.language_id = plc.language_id WHERE plc.student_project_id = "'.$project_id.'"';
        foreach ($conditions as $key => $value) {
            $sql .= ' AND plc.'.$key.' = "'.$value.'"';
        }
        if($project_content_id)
        {
            $sql .= ' AND plc.content_id = "'.$project_content_id.'"';
        }
        if($order_by)
        {
            $sql .= ' ORDER BY "'.$order_by.'"';
        }
        else
        {
            $sql .= ' ORDER BY plc.content_id DESC';
        }
        $result = $this->common_model->custom_query($sql);
        return $result;
    }

    function deletelecturecontent($project_id='', $project_content_id='', $language_id='')
    {
        if($language_id != 1)
        {
            $this->common_model->set_table('student_project_content');
            $response = $this->common_model->_delete('content_id', $project_content_id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
            redirect(base_url().'cms/studentprojects/project_content/'.$project_id);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'You can not delete default project content']);
            redirect(base_url().'cms/studentprojects/project_content/'.$project_id);
        }
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
        $project_content_id         = isset($_POST['project_content_id']) ? $_POST['project_content_id'] : '';
        $project_id                 = isset($_POST['project_id']) ? $_POST['project_id'] : '';
        $language_id                = isset($_POST['language_id']) ? $_POST['language_id'] : '';
        $errormessage               = 'Project content for this language is already exist.';
        $this->form_validation->set_message('unique_language', $errormessage);

        if($project_content_id)
        {
            $content = $this->common_model->custom_query('Select * FROM student_project_content WHERE language_id = "'.$language_id.'" AND student_project_id = "'.$project_id.'" AND content_id != "'.$project_content_id.'"');
        }
        else
        {
            $content = $this->common_model->custom_query('Select * FROM student_project_content WHERE language_id="'.$language_id.'" AND student_project_id = "'.$project_id.'"');
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

    function deleteimage($id=0)
    {   
        $project_id = $_GET['student_project_id'];
        $response =  $this->db->delete('student_project_images', array('id' => $id));

        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        redirect(base_url().'cms/studentprojects/manageproject/'.$project_id);
    }

    function deletefeaimage($id=0)
    {
        $this->db->where('student_project_id', $id);
        $response =  $this->db->update('student_projects', array('team_logo' => ''));

        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        redirect(base_url().'cms/studentprojects/manageproject/'.$id);
    }
    
    function save_student_projectimg_order()
    {   
        $programme_id = $_POST["programme_id_array"];

        $i=1;
        foreach($programme_id as $k=>$v){
            //$query=$this->db->query("UPDATE student_project_images SET img_order = '".$i."' where id = '".$v."' and type = 'project_banner_images' ");

            $query=$this->db->query("UPDATE student_project_images SET img_order = '".$i."' where id = '".$v."' ");

            $i++;
        }

        echo 'Student Project Banner has been updated';
    }
    
    /*function deletedonor()
    {        
        $deleteid  = $this->input->post('pid');
        $this->db->delete('project_donor', array('pid' => $deleteid));
        $verify = $this->db->affected_rows();
        echo $verify;
    }*/

    /*function funder($project_id=0)
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "projects";
        $this->data['child_menu_type'] = "projects";
        $this->data['sub_child_menu_type'] = "";
        
        $this->data['data_list']    = $this->get_funders($project_id);
        $this->data['title']        = _l("lectures", $this);
        $this->data['page']         = "lectureinterests";
        $this->data['project_id']   = $project_id;
        $this->data['content']      = $this->load->view('projects'.'/funders', $this->data, true);
        $this->load->view($this->mainTemplate, $this->data);
    }*/

    /*function get_funders($id='', $conditions=[], $order_by='')
    {
        $sql = 'SELECT * FROM project_donor t WHERE 1=1';
        foreach ($conditions as $key => $value) {
            $sql .= ' AND '.$key.' = "'.$value.'"';
        }
        if($id)
        {
            $sql .= ' AND t.project_id = "'.$id.'"';
        }
        if($order_by)
        {
            $sql .= ' ORDER BY "'.$order_by.'"';
        }
        else
        {
            $sql .= ' ORDER BY t.pid DESC';
        }
        $result = $this->common_model->custom_query($sql);
        return $result;
    }*/

    /*function export_funders($id='')
    {
        $interests                  = $this->get_funders($id);
        if(!empty($interests))
        {
            $this->load->library("excel");
            $object = new PHPExcel();
            $object->setActiveSheetIndex(0);

            $table_columns = array("Name", "Amount");

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
                $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['amount']);
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
            redirect(base_url()."funder/".$id);
        }
    }*/
}
