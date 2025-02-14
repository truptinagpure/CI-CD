<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Pressrelease_content_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
 



 function get_pressrelease_contents($post_id)
    {
        $this->db->select('c.*,l.code as language_code,l.language_name');
        $this->db->from('contentspressrelease c');
        $this->db->join('languages l', 'c.language_id = l.language_id','left');
        $this->db->where('c.relation_id', $post_id);
        $this->db->where('c.public !=', '-1');
        $this->db->order_by('c.contents_id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

 function get_details($pressrelease_id='', $id='')
    {
        $this->db->select('*');
        $this->db->from('contentspressrelease');
        $this->db->where('relation_id', $pressrelease_id);
        $this->db->where('contents_id', $id);
        $this->db->where('public !=', '-1');
        $query = $this->db->get();
        return $query->row_array();
    }

     function save($post_id='', $id='', $save=[])
    {   
        $msg = ['error' => 1, 'message' => 'Invalid request'];
        if(!empty($save))
        {
            $post_content = $this->check_post_content($post_id, '', $save['language_id']);
            if(!empty($post_content))
            {
                $save['updated_date']   = date('Y-m-d H:i:s');
                $save['user_id']        = $this->session->userdata['user_id'];
                $this->db->where('contents_id', $post_content['contents_id']);
                $this->db->update('contentspressrelease', $save);
            }
            else
            {
                $save['created_date'] = date('Y-m-d H:i:s');
                $save['user_id'] = $this->session->userdata['user_id'];
                $this->db->insert('contentspressrelease', $save);
            }

            if($this->db->affected_rows())
            {
                  $response['status']     = 'success';
            }
            else
            {
                  $response['status']     = 'error';
                   $response['message']    = $this->db->_error_message();
            }
        }
        return $response;
    }

     function check_post_content($post_id='', $id='', $language='')
    {
        $this->db->select('*');
        $this->db->from('contentspressrelease');
        $this->db->where('relation_id', $post_id);
        $this->db->where('language_id', $language);
        if(!empty($id))
        {
            $this->db->where('contents_id', $id);
        }
        $this->db->where('public !=', '-1');
        $query = $this->db->get();
        return $query->row_array();
    }


function get_pressrelease_found($id,$public)
    {
        
       
            $this->db->select("*,pressrelease.title as name, pressrelease.public as publish");
            $this->db->from('pressrelease');
            $this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID,pressrelease.institute_id)",'left');
            $this->db->join('category',"category.category_id=pressrelease.category_id");
            $this->db->where("pressrelease.pressrelease_id", $id);
            $this->db->where('pressrelease.public !=', $public);
            $query = $this->db->get();
            return $query->result_array();
   }



function get_pressrelease($id='', $conditions=[])
    {
        $this->db->select('*,pressrelease.title as name');
        $this->db->from('pressrelease');
        $this->db->join('contentspressrelease', 'contentspressrelease.relation_id=pressrelease.pressrelease_id');
        $this->db->where('pressrelease.pressrelease_id', $id);
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value)
             {
                $this->db->where($key, $value);
            }
        }
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0 ? $return[0] : [];
    }



function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'pressrelease';
        $table2                     = 'contentspressrelease';
        $res                        = $this->db->insert($table, $data['pressrelease']);
        $insert_id = $this->db->insert_id();

        if($res)
        {
            $data['contentspressrelease']['relation_id']      = $insert_id;
            $res                        = $this->db->insert($table2, $data['contentspressrelease']);
            $response['status']     = 'success';
            $response['id']         = $insert_id;
        }
        else
        {
            $response['status']     = 'error';
            $response['message']    = $this->db->_error_message();
        }
        return  $response;
    }

 function _update($col, $val, $updatedata) {
        $response['status']         = 'error';
        $table                      = 'pressrelease';
        $table2                     = 'contentspressrelease';

        $this->db->where($col, $val);
        $update                     = $this->db->update($table, $updatedata['pressrelease']);

        if($update)
        {
            $this->db->where('contents_id', $updatedata['contentspressrelease']['contents_id']);
            $this->db->update($table2, $updatedata['contentspressrelease']);

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




      function _delete($pressrelease_id, $contents_id) { 
        $update['public']            = -1;
        $table      = 'contentspressrelease';
        $this->db->where('relation_id', $pressrelease_id);
        $this->db->where('contents_id', $contents_id);
        $res        = $this->db->update($table,$update);
        $str        = $this->db->last_query();
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted ' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }



   




 }

?>