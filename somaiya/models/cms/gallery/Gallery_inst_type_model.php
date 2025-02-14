<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Gallery_inst_type_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }


     function get_instgaltype()
    {
        $this->db->select("*,GROUP_CONCAT(galleries_type.type_name) AS type_name,institute_galleries_type.public as status");
        $this->db->from('institute_galleries_type');
        $this->db->join('edu_institute_dir','edu_institute_dir.INST_ID=institute_galleries_type.institute_id');
        $this->db->join('galleries_type',"FIND_IN_SET(galleries_type.id,institute_galleries_type.type_id)",'left');
        $this->db->group_by('ig_id');
        $this->db->order_by('ig_id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
     function get_galtype()
    {
        $this->db->select("*");
        $this->db->from('galleries_type');
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
   function get_galtype_detail($id)
    {
        $this->db->select('*');
        $this->db->from('galleries_type');
        $this->db->where('id', $id);
          $this->db->where('public', '1');
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
   function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'institute_galleries_type';

        $res                        = $this->db->insert($table, $data['institute_galleries_type']);
        $insert_id = $this->db->insert_id();

        if($res)
        {
        
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

function count_gallery_image($where = null)
    {
        $this->db->select("count(*)");
        $this->db->from('gallery_image');
        if($where!=null){
            foreach($where as $key=>$value){
                $this->db->where($key,$value);
            }
        }
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]["count(*)"])?$result[0]["count(*)"]:0;
    }
  function _update($conditions=[], $updatedata) {
        $response['status']         = 'error';
        $table                      = 'institute_galleries_type';
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $update                     = $this->db->update($table, $updatedata['institute_galleries_type']);

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

    function _delete($col, $val) {
            
        $update['public']       = -1;
        $update['modified_on']  = date('Y-m-d H:i:s');
        $update['modified_by']  = $this->session->userdata('user_id');

        $table      = 'institute_galleries_type';
        $this->db->where($col, $val);
        //$res        = $this->db->delete($table);
        $res        = $this->db->update($table,$update);
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }

      function get_instgaltype_detail($id)
    {
        $this->db->select("*");
        $this->db->from('institute_galleries_type');
        $this->db->where('institute_galleries_type.ig_id',$id);
        $this->db->order_by('ig_id','ASC');
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function check_institute_by_type_exit($institute_id, $institute_type_rel_id)
    {
        $this->db->select('*');
        $this->db->from('institute_galleries_type');
        $this->db->where('institute_id', $institute_id);
        if(!empty($institute_type_rel_id))
        {
            $this->db->where('ig_id !=', $institute_type_rel_id);
        }
        $this->db->where('public !=', '-1');
        $query = $this->db->get();

        return $query->num_rows();
    }
}