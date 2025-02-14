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
class Career_model extends CI_Model
{
    private $user_id;
    private $table;
    function __construct()
    {
        parent::__construct();
        $CI =& get_instance();
        $this->user_id = $CI->session->userdata['user_id'];
    }

    function get_career($conditions=[])
    {
        $this->db->select('f.*');
        $this->db->from('career f');
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->order_by('f.job_name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function manage_career($data=[], $id='',$career_documents,$instituteID)
    {   
        if($id)
        {
            if(!empty($this->get_career($id)))
            {
                $update['job_name']                 = $this->input->post('job_name');
                $update['job_code']                 = $this->input->post('job_code');
                $update['job_cat']                  = $this->input->post('job_cat');
                $update['job_department']           = $this->input->post('Department_Id');
                $update['job_email']                = $this->input->post('email');
                $update['application_type']         = $this->input->post('application_type');
                $update['valid_till']               = $this->input->post('valid_till');
                $update['career_keywords']          = $this->input->post('career_keywords');
                $update['job_description']          = $this->input->post('job_description');
                $update['job_keyskills']            = $this->input->post('job_keyskills');
                $update['status']                   = $this->input->post('status');
                $update['modified_on']              = date('Y-m-d H:i:s');
                $update['modified_by']              = $this->session->userdata['user_id'];
                $this->db->where('id', $id);
                $this->db->update('career', $update);

                if(!empty($career_documents))
                {   
                    foreach ($career_documents as $key => $value) {
                        $save_document['document'] = $value;
                        $save_document['relation_id'] = $id;
                        $this->db->insert('career_documents',array("document"=>$value,"relation_id"=>$id));
                    }
                }

                if($this->db->affected_rows() > 0)
                {
                    $return = ['error' => 0, 'message' => 'Job successfully updated'];
                }
                else
                {
                    $return = ['error' => 1, 'message' => 'Unable to update Job'];
                }
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Job not found'];
            }
        }
        else
        {
            $insert['institute_id']             = $instituteID;
            $insert['job_name']                 = $this->input->post('job_name');
            $insert['job_code']                 = $this->input->post('job_code');
            $insert['job_cat']                  = $this->input->post('job_cat');
            $insert['job_department']           = $this->input->post('Department_Id');
            $insert['job_email']                = $this->input->post('email');
            $insert['application_type']         = $this->input->post('application_type');
            $insert['valid_till']               = $this->input->post('valid_till');
            $insert['career_keywords']          = $this->input->post('career_keywords');
            $insert['job_description']          = $this->input->post('job_description');
            $insert['job_keyskills']            = $this->input->post('job_keyskills');
            $insert['status']                   = $this->input->post('status');
            $insert['created_on']               = date('Y-m-d H:i:s');
            $insert['created_by']               = $this->session->userdata['user_id'];
            $insert['modified_on']              = date('Y-m-d H:i:s');
            $insert['modified_by']              = $this->session->userdata['user_id'];
            $this->db->insert('career', $insert);
            $insert_id = $this->db->insert_id();

            if(!empty($career_documents))
                {
                    foreach ($career_documents as $key => $value) {
                        $save_document['document'] = $value;
                        $save_document['relation_id'] = $insert_id;
                        $this->db->insert('career_documents',array("document"=>$value,"relation_id"=>$insert_id));
                    }
            }

            if($insert_id)
            {
                $return = ['error' => 0, 'message' => 'Product successfully added'];
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Unable to add product'];
            }
        }
        return $return;
    }

    function get_department()
    {
        $this->db->select("*");
        $this->db->from('edu_department_dir');
        $this->db->order_by('Department_Id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }


    function get_career_category($instituteID)
    {
        $this->db->select("*");
        $this->db->from('career_category');
        $this->db->where('career_category.institute_id', $instituteID);
        $this->db->order_by('career_category.cat_id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_email($instituteID)
    {
        $this->db->select("CAREER_MODULE_EMAIL_LIST");
        $this->db->from('edu_institute_dir');
        $this->db->where('INST_ID', $instituteID);
        $query = $this->db->get();
        return $query->result_array();
    }

    function document_upload($id)
    {  
        $this->db->select('*');
        $this->db->from('career_documents');
        $this->db->where('relation_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
}
