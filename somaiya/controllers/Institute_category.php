<?php
/**
 * Created by Somaiya Team.
 * User: Somaiya
 * Date: 9/16/2016
 * Time: 1:03 AM
 * Project: Somaiya Vidyavihar
 * Website: http://www.somaiya.com
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Institute_category extends Somaiya_Controller {
    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('Institute_category_model');
    }

    function institute_category()
    {
        
        $group_id = $this->session->userdata['group_id'];
        $user_id = $this->session->userdata['user_id'];
        $result=$this->Somaiya_general_admin_model->get_session_permissions($group_id,$user_id);
        $explodePer=explode(',', $result[0]['permissions']); 


        if (in_array('institute_category', $explodePer, true)) {
            $this->data['data_list']=$this->Institute_category_model->get_all_institute_category();
            $this->data['title'] = _l("institute_category",$this);
            $this->data['page'] = "institute_category";
            $this->data['content']=$this->load->view('institute_category'.'/institute_category',$this->data,true);
            $this->load->view($this->mainTemplate,$this->data);
        }else{
            $this->session->set_flashdata('error', _l('This request is just fore real admin.',$this));
            redirect(base_url()."admin/");
        }    
    }
    function editinstitute_category($id='')
    {
        $group_id = $this->session->userdata['group_id'];
        $user_id = $this->session->userdata['user_id'];
        $result=$this->Somaiya_general_admin_model->get_session_permissions($group_id,$user_id);
        $explodePer=explode(',', $result[0]['permissions']); 
     
        if (in_array('editinstitute_category', $explodePer, true)) {
            if($id!='')
            {
                $this->data['data']=$this->Institute_category_model->get_institute_category_detail($id);
                if($this->data['data']==null)
                redirect(base_url()."institute_category/institute_category_edit");
            }

            $this->load->library('spyc');
            $this->data['languages']=$this->Somaiya_general_admin_model->get_all_language();
            $this->data['title'] = _l("institute_category",$this);
            $this->data['page'] = "institute_category";
            $titles = array();
            
            $this->data['institute_category'] = $this->Institute_category_model->get_all_institute_category();
            $this->data['content']=$this->load->view('institute_category'.'/institute_category_edit',$this->data,true);
            $this->load->view($this->mainTemplate,$this->data);
        }else{
            $this->session->set_flashdata('error', _l('This request is just fore real admin.',$this));
            redirect(base_url()."admin/");
        }    
    }

    function institute_category_manipulate($id=null)
    {
        $group_id = $this->session->userdata['group_id'];
        $user_id = $this->session->userdata['user_id'];
        $result=$this->Somaiya_general_admin_model->get_session_permissions($group_id,$user_id);
        $explodePer=explode(',', $result[0]['permissions']); 

        if (in_array('institute_category_manipulate', $explodePer, true)) {
            
            if ($this->Institute_category_model->institute_category_manipulate($_POST["data"],$id))
            {
                $this->session->set_flashdata('success', _l('Updated institute_category',$this));
            }
            else
            {
                $this->session->set_flashdata('error', _l('Updated page error. Please try later',$this));
            }
        }else{
            $this->session->set_flashdata('error', _l('This request is just fore real admin.',$this));
            redirect(base_url()."admin/");
        }
        redirect(base_url()."institute_category/institute_category/");
    }
    function deleteinstitute_category($id=0)
    {
        $group_id = $this->session->userdata['group_id'];
        $user_id = $this->session->userdata['user_id'];
        $result=$this->Somaiya_general_admin_model->get_session_permissions($group_id,$user_id);
        $explodePer=explode(',', $result[0]['permissions']); 

        if (in_array('deleteinstitute_category', $explodePer, true)) {
            $this->db->trans_start();
            $this->db->delete('institute_category', array('location_id' => $id));
            $this->db->trans_complete();
            $this->session->set_flashdata('success', _l('Deleted institute_category',$this));
        }else{
            $this->session->set_flashdata('error', _l('This request is just fore real admin.',$this));
            redirect(base_url()."admin/");
        }
        redirect(base_url()."institute_category/institute_category/");
    }


    function institute_category_ajax($id=0)
    {
        
            $this->data['data_list']=$this->Institute_category_model->myformAjax($id);
            print_r($this->data['data_list']);

    }

}
