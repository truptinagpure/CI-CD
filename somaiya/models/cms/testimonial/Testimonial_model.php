<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Testimonial_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
 
 function get_all_Testimonial($inst_id,$public)
    {   
        $this->db->where('institute_id', $inst_id);
        $this->db->where('status !=', $public);
        $this->db->select("*");
        $this->db->from('testimonials');
        $this->db->order_by('id  ', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

 function get_all_Testimonial_category($inst_id,$public)
    {   
   
        $this->db->where('institute_id', $inst_id);
        $this->db->where('testimonial_category.status =', $public);
        $this->db->select("*");
        $this->db->from('testimonial_category');
        $this->db->order_by('id  ', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }


function get_testimonial_details($id='',$inst_id='',$public)
    {
        $this->db->select('*,testimonials.name as name');
        $this->db->from('testimonials');
        $this->db->where('testimonials.id   ', $id);
        $this->db->where('testimonials.institute_id', $inst_id);
        $this->db->where('testimonials.status !=', $public);
    
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0 ? $return[0] : [];
    }




function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'testimonials';
        $res                        = $this->db->insert($table, $data['testimonials']);
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

 function _update($conditions=[], $updatedata,$ext,$filename) {
        $response['status']         = 'error';
        $table                      = 'testimonials';
         if(!empty($conditions))
            {
                foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
                 }
             }

        $update  = $this->db->update($table, $updatedata['testimonials']);
   if($filename!=''){

    if(!empty($conditions))
            {
                foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
                 }
             }
                    
                    $this->db->update('testimonials', array('image' => $filename,'ext'=>$ext));
                }
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

 function _delete($conditions=[]) {
            
        $update['status']            = -1;
        $table      = 'testimonials';
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $res        = $this->db->update($table,$update);
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }


 }

?>