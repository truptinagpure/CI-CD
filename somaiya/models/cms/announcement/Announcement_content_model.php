<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Announcement_content_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_announcement_contents($announcement_id)
    {
        $this->db->select('ec.*,l.code as language_code');
        $this->db->from('contentsannouncement_new ec');
        $this->db->join('languages l', 'ec.language_id = l.language_id','left');
        $this->db->where('ec.announcement_id', $announcement_id);
        $this->db->where('ec.public !=', '-1');
        $this->db->order_by('ec.contents_id', 'DESC');
        $query = $this->db->get();

        //$str = $this->db->last_query();
        // echo "<pre>";
        // print_r($str);
        // exit;

        return $query->result_array();
    }

    function get_details($announcement_id='', $id='')
    {
        $this->db->select('*');
        $this->db->from('contentsannouncement_new');
        $this->db->where('announcement_id', $announcement_id);
        $this->db->where('contents_id', $id);
        $this->db->where('public !=', '-1');
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function save($announcement_id='', $id='', $save=[])
    {   
        $msg = ['error' => 1, 'message' => 'Invalid request'];
        if(!empty($save))
        {
            $announcement_content = $this->check_announcement_content($announcement_id, '', $save['language_id']);

            // print_r($announcement_content);
            // exit();
            if(!empty($announcement_content))
            {
                $save['modified_on']   = date('Y-m-d H:i:s');
                $save['modified_by']   = $this->session->userdata['user_id'];
                $this->db->where('contents_id', $announcement_content['contents_id']);
                $this->db->update('contentsannouncement_new', $save);
            }
            else
            {
                $save['created_on'] = date('Y-m-d H:i:s');
                $save['created_by'] = $this->session->userdata['user_id'];
                $this->db->insert('contentsannouncement_new', $save);
            }

            if($this->db->affected_rows())
            {
                $msg = ['error' => 0, 'message' => 'Announcement content successfully saved'];
            }
            else
            {
                $msg = ['error' => 1, 'message' => 'Unable to save an announcement content'];
            }
        }
        return $msg;
    }

    function check_announcement_content($announcement_id='', $id='', $language='')
    {
        $this->db->select('*');
        $this->db->from('contentsannouncement_new');
        $this->db->where('announcement_id', $announcement_id);
        $this->db->where('language_id', $language);
        if(!empty($id))
        {
            $this->db->where('contents_id', $id);
        }
        // if($this->session->userdata('role') != 1)
        // {
        //     $this->db->where('created_by', $this->session->userdata('user_id'));
        // }
        $this->db->where('public !=', '-1');
        $query = $this->db->get();
        return $query->row_array();
    }

    function check_content_by_lang($announcement_id, $announcement_content_id, $language_id)
    {
        $this->db->select('*');
        $this->db->from('contentsannouncement_new');
        $this->db->where('announcement_id', $announcement_id);
        $this->db->where('language_id', $language_id);
        if(!empty($announcement_content_id))
        {
            $this->db->where('contents_id !=', $announcement_content_id);
        }
        $this->db->where('public !=', '-1');
        $query = $this->db->get();

        // $str = $this->db->last_query();
        // echo "<pre>";
        // print_r($str);
        // exit;
        return $query->num_rows();
    }

    function _delete($announcement_id, $id) { 

        $update['public']           = -1;
        $update['modified_on']      = date('Y-m-d H:i:s');
        $update['modified_by']      = $this->session->userdata['user_id'];

        $table      = 'contentsannouncement_new';
        $this->db->where('announcement_id', $announcement_id);
        $this->db->where('contents_id', $id);
        //$res        = $this->db->delete($table);
        $res        = $this->db->update($table,$update);
        $str = $this->db->last_query();
   
        // echo "<pre>";
        // print_r($str);
        // exit;
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }
}