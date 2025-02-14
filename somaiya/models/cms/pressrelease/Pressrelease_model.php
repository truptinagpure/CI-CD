<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Pressrelease_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    function get_pressrelease_location($id,$public)
    {
        if($id == 50){
        $this->db->select("*,GROUP_CONCAT(edu_institute_dir.INST_NAME) AS institute_namenew,pressrelease.title as name, pressrelease.public as publish");
        $this->db->from('pressrelease');
        $this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID,pressrelease.institute_id)",'left');
        $this->db->join('category',"category.category_id=pressrelease.category_id");
        $this->db->where('pressrelease.public !=', $public);
        $this->db->group_by("pressrelease.pressrelease_id");
        $this->db->order_by('pressrelease.pressrelease_id','DESC');
        $query = $this->db->get();
        return $query->result_array();        
        } else {
            $this->db->select("*,pressrelease.title as name, pressrelease.public as publish");
            $this->db->from('pressrelease');
            $this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID,pressrelease.institute_id)",'left');
            $this->db->join('category',"category.category_id=pressrelease.category_id");
            $this->db->where("pressrelease.institute_id", $id);
            $this->db->where('pressrelease.public !=', $public);
            $this->db->group_by("pressrelease.pressrelease_id");
            $this->db->order_by('pressrelease.pressrelease_id','DESC');
            $query = $this->db->get();
            return $query->result_array();
        }

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
            foreach ($conditions as $key => $value) {
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




     function _delete($col, $val) {
        $update['public']            = -1;
        $table      = 'pressrelease';
        $this->db->where($col, $val);
        $res        = $this->db->update($table,$update);
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        return $res;
    }



   




 }

?>