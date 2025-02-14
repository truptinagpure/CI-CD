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
class Somaiya_admin_sign_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function check_login($username)
    {
        $this->db->select("users.login_type,users.username,users.email,users.user_id,users.fullname,users.avatar,users.status");
        $this->db->from('users');
        $this->db->where('users.username', $username);
        $query = $this->db->get();
        return $query->result_array();
    }

    function check_pass($username)
    {
        $this->db->select("password");
        $this->db->from('users');
        $this->db->where('username', $username);
        $query = $this->db->get();
        return $query->result_array();    
    }
}
