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
class Sidebarmenu_permissions_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function view_permission()
    {
        $this->db->select("mp.*,  i.INST_NAME as institute_name,i.INST_ID");
        $this->db->from('module_permission as mp');
        $this->db->join('edu_institute_dir as i', "i.INST_ID=mp.institute_id", "left");
        $this->db->order_by('i.INST_ID','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function edit_permission($id)
    {
        $this->db->select('pr_id, institute_id as pr_inst_id,permission as permissions');
        $this->db->from('module_permission');
        $this->db->where('institute_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function add_permission($data,$id=null)
    {
        $this->db->trans_start();

        if($id!=null) // update
        {
            $this->db->where('pr_id',$id);
            $this->db->update('user_permissions',$data);
        }
        else    //add
        {
            $this->db->insert('user_permissions',$data);
            $id=$this->db->insert_id();

        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    function get_all_methods($conditions=null)
    {
        $this->db->select('*');
        $this->db->from('user_module');
        $this->db->join('user_permission_method',"user_permission_method.pm_module_id=user_module.module_id","left");
        //$this->db->group_by('user_module.module_id');
        $this->db->order_by('user_module.module_id','ASC');
        if($conditions!=null) $this->db->where($conditions);
        $query = $this->db->get();
        return $query->result_array();
    }


    function user_select($group)
    {
        $this->db->select('users.user_id,users.fullname');
        $this->db->from('users');
        $this->db->join('groups',"groups.group_id=users.user_id","left");
        $this->db->where('users.group_id', $group);
        $query = $this->db->get();
        return $query->result_array();
    }


    function institutes_pages($instituteid)
    {
        $this->db->select('page.page_id,page.page_name');
        $this->db->from('page');
        $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=page.institute_id","left");
        $this->db->where('page.institute_id', $instituteid);
        $query = $this->db->get();
        return $query->result_array();
    }

    function view_page_permissions()
    {
       /* $this->db->select("up.*, g.group_name, i.INST_NAME as institute_name");
        $this->db->from('user_page_permissions as up');
        $this->db->join('groups as g', "g.group_id=up.pr_group_id", "left");
        $this->db->join('edu_institute_dir as i', "i.INST_ID=up.pr_inst_id", "left");
        $this->db->order_by('up.pr_id', 'ASC');
        $query = $this->db->get();
        return $query->result_array();*/

        $this->db->select("mp.*,  i.INST_NAME as institute_name,i.INST_ID");
        $this->db->from('module_permission as mp');
        $this->db->join('edu_institute_dir as i', "i.INST_ID=mp.institute_id", "INNER");
        $this->db->group_by('mp.institute_id');// add group_by
        $this->db->order_by('i.INST_ID','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

  function view_page_permissions_delete($id)
    {
       

        $this->db->select("mp.*, sm.*");
        $this->db->from('module_permission as mp');
        $this->db->join('sidebar_module as sm', "sm.module_id=mp.permission", "INNER");
        $this->db->where('mp.institute_id',$id);// add group_by
        $this->db->order_by('sm.module_name','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function edit_module_permission($pr_id)
    {
     /*   $this->db->select('institute_id,permission,pr_id');
        $this->db->from('module_permission');
        $this->db->where('institute_id', $pr_id);
        $query = $this->db->get();
         return $query->result_array();
      return count($return)!=0?$return[0]:null;*/

      $this->db->select("institute_id,permission,pr_id");
            $this->db->from('module_permission ');
            $this->db->where('institute_id',$pr_id );
             $this->db->order_by('institute_id','ASC');
        $query = $this->db->get();
        //return $query->result_array();

         $return = $query->result_array();
        return count($return)!=0?$return[0]:null;


    }

    function save_module_permission($data, $id=null) //required insert update
    {

 $this->db->trans_start();

        $this->db->where('institute_id',$data['institute_id']);
   $q = $this->db->get('module_permission');

   if ( $q->num_rows() > 0 ) 
   {
      $this->db->where('institute_id',$data['institute_id']);
      $this->db->update('module_permission',$data);
   } else {
    
      $this->db->insert('module_permission',$data);
   }

$this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }

       

       /* if($id!=null) // update
        {
           /* $this->db->where('pr_id', $id);
            $this->db->update('module_permission', $data);
        }
        else   {
            $this->db->insert('module_permission', $data);
            $id=$this->db->insert_id();

        }
*/
        
    }



function check_module_permission($inst_id,$permission)
{
  // $this->db->trans_start();

       $this->db->select('pr_id');
            $this->db->where('institute_id', $inst_id);
            $this->db->where('permission', $permission);
$query = $this->db->get();
        return $query->result_array();
      /*  $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }*/

}
    function get_other_page($page_ids=[], $inst_id)
    {
        $this->db->select('*');
        $this->db->from('page');
        // $this->db->where('page_id', implode(',', $page_ids));
        //$this->db->where('`page_id` NOT IN ('.implode(',', $page_ids).')');
		if($page_ids)
        {
            $this->db->where('`page_id` NOT IN ('.implode(',', $page_ids).')');
        }
		
        if($inst_id)
        {
            $this->db->where('institute_id', $inst_id);
        }
        $query = $this->db->get();
        // echo "<pre>";print_r($this->db->last_query());exit;
        return $query->result_array();
    }
}