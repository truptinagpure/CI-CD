<?php
/**
 * Created by Somaiya Team.
 * Date: 3/1/2016
 * Time: 5:56 PM
 * Project: Somaiya Vidyavihar
 * Website: http://www.somaiya.com
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Somaiya_Controller extends CI_Controller {
    public $_website_info,$data,$mainTemplate;
    public $langArray=array();

    function __construct($controllerType='backend'){ // "backend" OR "frontend"
        parent::__construct();
        $models = $this->config->item($controllerType.'_models');
        $this->load->model($models);
        $helpers = $this->config->item($controllerType.'_helpers');
        $this->load->helper($helpers);
        $this->$controllerType();
    }

    private function backend(){
        $this->mainTemplate = $this->config->item('Somaiya_general_admin_templateFolderName');
        $this->_website_info = @reset($this->Somaiya_general_admin_model->get_website_info());
        if(!isset($this->session->userdata['user_id'])) redirect(base_url()."admin-sign");
        $_SESSION['language'] = $language = $this->Somaiya_general_admin_model->get_language_detail($this->_website_info["language_id"]);
        $this->lang->load('backend', $language["language_name"]);
        $this->data['settings'] = $this->_website_info;
        $this->data['base_url'] = base_url()."admin/";
        $this->load->library('spyc');
        $this->data['all_page_type'] = spyc_load_file(getcwd()."/page_type.yml") ;
        $this->data['page_list'] = $this->Somaiya_general_admin_model->get_all_page();
        $this->data['institutes_dropdown_list'] = $this->Somaiya_general_admin_model->get_assigned_institute_list();
          // start dynamic menu
        if(isset($_SESSION['sess_institute_id']) && !empty($_SESSION['sess_institute_id']))
        { $id = $_SESSION['sess_institute_id']; }
        else
         { $id=1;}
    
        $this->data['dropdown'] = $this->Somaiya_general_admin_model->get_all_sidebarmenu($id);
        $this->data['view_permissions']     = [];
            if(!empty($this->data['dropdown']))
                { //$this->data['view_permissions']      = isset($this->data['dropdown']['add_permissions']) ?$this->data['dropdown']['add_permissions'] : 0;
                    if(isset($this->data['dropdown']['permission']) && !empty($this->data['dropdown']['permission']))
                    {
                     $this->data['view_permissions'] = explode(',', $this->data['dropdown']['permission']);
                    }
                    //$this->data['view_permissions'] = explode(',', $this->data['dropdown']['permission']);
                }
        $this->data['select'] = $this->Somaiya_general_admin_model->get_sidebarchild_menu();
        //end dynamic menu contoller
    }

    private function frontend()
    {
        $this->mainTemplate                     = $this->config->item('Somaiya_general_templateFolderName');
    }
}