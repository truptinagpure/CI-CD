<?php
/**
 * Created by Somaiya Team.
 * User: Somaiya
 * Date: 10/05/2018
 * Time: 2:22 PM
 * Project: Somaiya Vidyavihar
 * Website: http://www.arigel.com
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Studentprojects_model extends CI_Model
{
    private $user_id;
    private $table;
    function __construct()
    {
        parent::__construct();
        $CI =& get_instance();
        $this->user_id = $CI->session->userdata['user_id'];
        $this->table = 'student_projects';
    }

    // function get_all_projects()
    // {
    //     $this->db->select("*");
    //     $this->db->from($this->table);
    //     $this->db->order_by('project_id', 'DESC');
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

    function get_all_students_projects($id)
    {
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->where("institute_id", $id);
        $this->db->order_by('student_project_id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_student_project($id='', $conditions=[])
    {
        $this->db->select('*');
        $this->db->from('student_projects sp');
        $this->db->join('student_project_content spc', 'sp.student_project_id = spc.student_project_id');
        $this->db->where('sp.student_project_id', $id);
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0 ? $return[0] : [];
    }

    function manage_projects($data=[], $id='', $filename, $fileNamefeatured, $fileLogo, $instituteID)
    {  

        // echo "<pre>";
        // print_r($data);
        // exit();
        $allowed_inst_ids           = [];
        $save_data                  = [];
        foreach ($_POST['institute_id'] as $key => $value) 
        {
            $allowed_inst_ids[] = $value;
        }

        $save_data = !empty($allowed_inst_ids) ? implode(',', $allowed_inst_ids) : '';

        if($id)
        {
            if(!empty($this->get_student_project($id)))
            {
                $update['title']            = $data['name'];
                // $update['institute_id']     = $save_data;
                $update['institute_id']     = $instituteID;
                $update['featured_project'] = $data['featured_project'];
                $update['public']           = $data['public'];
                $update['modified_on']      = date('Y-m-d H:i:s');
                $update['modified_by']      = $this->user_id;
                $this->db->where('student_project_id', $id);
                $this->db->update($this->table, $update);

                if($fileNamefeatured!=''){
                    $this->db->where('student_project_id', $id);
                    $this->db->update('student_projects', array('team_logo' => $fileNamefeatured));
                }

                if($filename!=''){ 
                  $filename1 = explode(',',$filename);
                  foreach($filename1 as $file){
                    $file_data = array(
                        'image' => $file,
                        'student_project_id' => $id
                    );
                    $this->db->insert('student_project_images', $file_data);
                  }
                }


                $upd['student_project_id']      = $data['student_project_id'];
                $upd['language_id']             = $data['language_id'];
                $upd['title']                   = $data['name'];
                $upd['description']             = $data['description'];
                $upd['public']                  = $data['public'];
                $upd['created_on']              = date('Y-m-d H:i:s');
                $upd['created_by']              = $this->user_id;
                $upd['modified_on']             = date('Y-m-d H:i:s');
                $upd['modified_by']             = $this->user_id;

       //          echo "<pre>";
                // print_r($upd);
                // exit();
        
                $this->db->where('content_id', $data['student_project_content_id']);
                $this->db->update('student_project_content', $upd);


                if($this->db->affected_rows() > 0)
                {
                    $return = ['error' => 0, 'message' => 'Student project successfully updated'];
                }
                else
                {
                    $return = ['error' => 1, 'message' => 'Unable to update student project'];
                }
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Student project not found'];
            }
        }
        else
        {   
            $insert['title']                = $data['name'];
            // $insert['institute_id']         = $save_data;
            $insert['institute_id']         = $instituteID;
            $insert['featured_project']     = $data['featured_project'];
            $insert['public']               = $data['public'];
            $insert['created_on']           = date('Y-m-d H:i:s');
            $insert['created_by']           = $this->user_id;
            $insert['modified_on']          = date('Y-m-d H:i:s');
            $insert['modified_by']          = $this->user_id;
            $this->db->insert($this->table, $insert);
            $insert_id = $this->db->insert_id();

            $this->db->where('student_project_id', $insert_id);
            $this->db->update('student_projects', array('team_logo' => $fileNamefeatured));

            if($filename!='' ){
                  $filename1 = explode(',',$filename);
                  foreach($filename1 as $file){
                    $file_data = array(
                        'image' => $file,
                        'student_project_id' => $insert_id
                    );
                    $this->db->insert('student_project_images', $file_data);
                  }
            }

            $ins['student_project_id']    = $insert_id;
            $ins['language_id']   = $data['language_id'];
            $ins['title']         = $data['name'];
            $ins['description']   = $data['description'];
            $ins['public']       = $data['public'];
            $ins['created_on']   = date('Y-m-d H:i:s');
            $ins['created_by']   = $this->user_id;
            $ins['modified_on']  = date('Y-m-d H:i:s');
            $ins['modified_by']  = $this->user_id;
            $this->db->insert('student_project_content', $ins);
            $ins_id = $this->db->insert_id();

            if($insert_id)
            {
                $return = ['error' => 0, 'message' => 'Student project successfully added'];
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Unable to add project'];
            }
        }
        return $return;
    }

    function data_image($id)
    {
        $query=$this->db->query("SELECT *
                                 FROM  student_project_images as photo
                                 WHERE photo.student_project_id = $id order by photo.img_order ASC ");
        return $query->result_array();
    }

}
