<?php
/**
 * Created by Arigel Team.
 * User: Arigel
 * Date: 9/16/2016
 * Time: 1:03 AM
 * Project: Somaiya Vidyavihar
 * Website: http://www.arigel.com
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Sidebar_module_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


 
 function get_menu_details($id,$status)
    {   
        $this->db->where('module_id', $id);
        $this->db->where('status !=', $status);
        $this->db->select("*");
        $this->db->from('sidebar_module');
        $this->db->order_by('module_id  ', 'DESC');
        /*$query = $this->db->get();
        return $query->result_array();*/

               $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0 ? $return[0] : [];
    }


    function view_sidebarmodule($status)
    {
           $this->db->where('status !=', $status);
   $this->db->select("*");
        $this->db->from('sidebar_module');
        $this->db->order_by('module_id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }


 function view_sidebarmodule1($status)
    {
        $this->db->where('status =', $status);
        $this->db->select("*");
        $this->db->from('sidebar_module');
        $this->db->order_by('main_module','DESC');
        $this->db->order_by('module_id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function edit_sidebarmodule($id)
    {
        $this->db->select('*');
        $this->db->from('sidebar_module');
        $this->db->where('module_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

   function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'sidebar_module';
        $res                        = $this->db->insert($table, $data['sidebar_module']);
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
 function _update($conditions=[], $updatedata) {
        $response['status']         = 'error';
        $table                      = 'sidebar_module';
         if(!empty($conditions))
            {
                foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
                 }
             }

        $update                     = $this->db->update($table, $updatedata['sidebar_module']);

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
        $table      = 'sidebar_module';
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