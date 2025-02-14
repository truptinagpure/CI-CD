<?php
/**
 * Created by Somaiya Team.
 * User: Somaiya
 * Date: 9/16/2016
 * Time: 1:03 AM
 * Project: Somaiya
 * Website: http://www.somaiya.com
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Somaiya_admin_sign extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model("Somaiya_general_admin_model");
        $this->load->model("Somaiya_admin_sign_model");
        $banner = @reset($this->Somaiya_general_admin_model->get_website_info());
        $_SESSION['language'] = $language = $this->Somaiya_general_admin_model->get_language_detail($banner["language_id"]);
        $this->lang->load($language["code"], $language["language_name"]);

    //load google login library
        $this->load->library('google');
    }

    function index()
    {
      //google login url
      $data['loginURL'] = $this->google->loginURL();

        if ($this->session->userdata('logged_in_status') == TRUE)
        {
            redirect('/admin/');
        }
        else
        {
            $this->load->view('somaiya_admin_login',$data);
        }


    }
    function login()
    {

       $username = $this->security->xss_clean($this->input->post('username'));
       $password = md5($this->input->post('password'));
       $pass = $this->security->xss_clean($this->input->post('password'));
       $this->load->model('Somaiya_admin_sign_model');
       $data['records']=$this->Somaiya_admin_sign_model->check_pass($username);
       $p = $data['records'][0];
       $pp = implode(" ",$p); 
       $password = password_verify($pass, $pp);

       if($password==true) {
            $result=$this->Somaiya_admin_sign_model->check_login($username);
            $tam =  $result;

            // $datauser = $this->session->set_userdata($tam[0]);
            // if(isset($data['user_id'])) {
            // $_SESSION['Session_Admin'] = $data['user_id'];
            if($tam[0]['status'] == 1)
            {
              $datauser = $this->session->set_userdata($tam[0]);
              if(isset($data['user_id'])) {
                $_SESSION['Session_Admin'] = $data['user_id'];
              }
              redirect(base_url().'admin/');
            }
            else{
              
              $this->session->set_flashdata('message', _l('Your account is in-active state, please contact administrator',$this));
              redirect(base_url().'admin-sign');
            }

          }
          else {
          $this->session->set_flashdata('message', _l('Incorrect Username or Password',$this));
           redirect(base_url().'admin-sign');
        }
    }

    function logout()
    {
        $this->session->sess_destroy();
        $this->session->unset_userdata('logged_in_status');
        redirect(base_url().'admin-sign');
    }
}
