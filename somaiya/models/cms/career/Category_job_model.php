<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Category_job_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }



    function get_category($inst_id)
    {   

        $this->db->select("*");
        $this->db->from('career_category');
        $this->db->where('institute_id', $inst_id);
        $this->db->order_by('category_name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }



    function get_category_details($id='',$inst_id='')
    {
        $this->db->select('*,category_name as name');
        $this->db->from('career_category');
        $this->db->where('cat_id', $id);
        $this->db->where('institute_id', $inst_id);    
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0 ? $return[0] : [];
    }


    function _insert($data) 
    {
        $response['status']         = 'failed';
        $table                      = 'career_category';

        $res                        = $this->db->insert($table, $data['career_category']);
        $insert_id = $this->db->insert_id();

        if($res)
        {
        
            $response['status']     = 'success';
            $response['cat_id']     = $insert_id;
        }
        else
        {
            $response['status']     = 'error';
            $response['message']    = $this->db->_error_message();
        }
        return  $response;
    }

    function _update($conditions=[], $updatedata) 
    {
        $response['status']         = 'error';
        $table                      = 'career_category';
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $update                     = $this->db->update($table, $updatedata['career_category']);

        if($update)
        {

            $response['status']     = 'success';
            $response[$col]         = $val;
        }
        else
        {
            $response['status']     = 'error';
            $response['message']    = $this->db->_error_message();
        }
        return $response;
    }

}

