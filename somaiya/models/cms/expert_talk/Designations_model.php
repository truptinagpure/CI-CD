<?php
/**
 * Created by Somaiya Team.
 * User: Somaiya
 * Date: 10/05/2018
 * Time: 2:22 PM
 * Project: Somaiya Vidyavihar
 * Website: http://www.arigel.com
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Designations_model extends CI_Model
{
    private $user_id;
    function __construct()
    {
        parent::__construct();
        $CI =& get_instance();
        $this->user_id = $CI->session->userdata['user_id'];
    }

    function get_all_designations($conditions=[])
    {
        $this->db->select("*");
        $this->db->from('designations');
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->order_by('designation_id','DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    function get_designation($id='', $conditions=[])
    {
        $this->db->select('*');
        $this->db->from('designations');
        $this->db->where('designation_id', $id);
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0 ? $return[0] : [];
    }

    function manage_designations($data=[], $id='')
    {
        if($id)
        {
            if(!empty($this->get_designation($id)))
            {
                //$update['institute_id'] = $data['insta_id'];
                $update['institute_id'] = $this->session->userdata['sess_institute_id'];
                $update['name']         = $data['name'];
                $update['short_name']   = $data['short_name'];
                $update['description']  = $data['description'];
                $update['public']       = $data['public'];
                $update['modified_on']  = date('Y-m-d H:i:s');
                $update['modified_by']  = $this->user_id;
                $this->db->where('designation_id', $id);
                $this->db->update('designations', $update);

                if($this->db->affected_rows() > 0)
                {
                    $return = ['error' => 0, 'message' => 'Designation successfully updated'];
                }
                else
                {
                    $return = ['error' => 1, 'message' => 'Unable to update designation'];
                }
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Designation not found'];
            }
        }
        else
        {
            //$insert['institute_id'] = $data['insta_id'];
            $insert['institute_id'] = $this->session->userdata['sess_institute_id'];
            $insert['name']         = $data['name'];
            $insert['short_name']   = $data['short_name'];
            $insert['description']  = $data['description'];
            $insert['public']       = $data['public'];
            $insert['created_on']   = date('Y-m-d H:i:s');
            $insert['created_by']   = $this->user_id;
            $insert['modified_on']  = date('Y-m-d H:i:s');
            $insert['modified_by']  = $this->user_id;
            $this->db->insert('designations', $insert);

            if($this->db->insert_id())
            {
                $return = ['error' => 0, 'message' => 'Designation successfully added'];
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Unable to add designation'];
            }
        }
        return $return;
    }
}
