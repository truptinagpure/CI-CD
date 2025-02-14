<?php
/**
 * Created by Somaiya Team.
 * User: Somaiya
 * Date: 9/16/2016
 * Time: 1:03 AM
 * Project: Somaiya Vidyavihar
 * Website: http://www.Somaiya.com
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Category_old extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
    }

    function category()
    {
        
        $group_id = $this->session->userdata['group_id'];
        $user_id = $this->session->userdata['user_id'];
        $result=$this->Somaiya_general_admin_model->get_session_permissions($group_id,$user_id);
        $explodePer=explode(',', $result[0]['permissions']); 

        if (in_array('category', $explodePer, true)) {
            $this->data['data_list']=$this->Category_model->get_all_category();
            $this->data['title'] = _l("category",$this);
            $this->data['page'] = "category";
            $this->data['content']=$this->load->view('category'.'/category',$this->data,true);
            $this->load->view($this->mainTemplate,$this->data);
        }else{
            $this->session->set_flashdata('error', _l('This request is just fore real admin.',$this));
            redirect(base_url()."admin/");
        }     
    }
    function editcategory($id='')
    {
        $group_id = $this->session->userdata['group_id'];
        $user_id = $this->session->userdata['user_id'];
        $result=$this->Somaiya_general_admin_model->get_session_permissions($group_id,$user_id);
        $explodePer=explode(',', $result[0]['permissions']); 

        if (in_array('editcategory', $explodePer, true)) {
            if($id!='')
            {
                $this->data['data']=$this->Category_model->get_category_detail($id);
                if($this->data['data']==null)
                redirect(base_url()."category/category_edit");
            }

            $this->load->library('spyc');
            $this->data['languages']=$this->Somaiya_general_admin_model->get_all_language();
            $this->data['title'] = _l("category",$this);
            $this->data['page'] = "category";
            $titles = array();
            
            $this->data['category'] = $this->Category_model->get_all_category();
            $this->data['content']=$this->load->view('category'.'/category_edit',$this->data,true);
            $this->load->view($this->mainTemplate,$this->data);
        }else{
            $this->session->set_flashdata('error', _l('This request is just fore real admin.',$this));
            redirect(base_url()."admin/");
        }     
    }

    function category_manipulate($id=null)
    {
        $group_id = $this->session->userdata['group_id'];
        $user_id = $this->session->userdata['user_id'];
        $result=$this->Somaiya_general_admin_model->get_session_permissions($group_id,$user_id);
        $explodePer=explode(',', $result[0]['permissions']); 

        if (in_array('category_manipulate', $explodePer, true)) {
            
            if ($this->Category_model->category_manipulate($_POST["data"],$id))
            {
                $this->session->set_flashdata('success', _l('Updated category',$this));
            }
            else
            {
                $this->session->set_flashdata('error', _l('Updated page error. Please try later',$this));
            }
        }else{
            $this->session->set_flashdata('error', _l('This request is just fore real admin.',$this));
            redirect(base_url()."admin/");
        }
        redirect(base_url()."category/category/");
    }
    function deletecategory($id=0)
   {
        $group_id = $this->session->userdata['group_id'];
        $user_id = $this->session->userdata['user_id'];
        $result=$this->Somaiya_general_admin_model->get_session_permissions($group_id,$user_id);
        $explodePer=explode(',', $result[0]['permissions']); 

        if (in_array('deletecategory', $explodePer, true)) {
           $this->db->trans_start();
           $this->db->delete('category', array('category_id' => $id));
           $this->db->trans_complete();
           $this->session->set_flashdata('success', _l('Deleted Category',$this));
       }else{
           $this->session->set_flashdata('error', _l('This request is just fore real admin.',$this));
           redirect(base_url()."admin/");
       }
       redirect(base_url()."category/category/");
   }

}
