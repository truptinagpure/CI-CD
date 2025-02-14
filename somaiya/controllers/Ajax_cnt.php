<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Ajax_cnt extends Somaiya_Controller {

    public function __construct(){
        parent::__construct('backend');
    }

    public function set_institute()
    {
        $_SESSION['sess_institute_id'] = '';
        if(isset($_POST['sess_inst_val']) && !empty($_POST['sess_inst_val']))
        {
            $instData = $this->Somaiya_general_admin_model->get_assigned_institute($_POST['sess_inst_val']);
            if(!empty($instData))
            {
                $_SESSION['sess_institute_id'] = $_POST['sess_inst_val'];
                $_SESSION['sess_institute_short_name'] = $_POST['inst_short_name'];
                $_SESSION['sess_institute_name'] = isset($instData[0]['INST_NAME']) ? $instData[0]['INST_NAME'] : '';
            }
            
            redirect(base_url()."admin/");
        }
    }
}