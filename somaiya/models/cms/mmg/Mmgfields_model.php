<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mmgfields_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'mmg_field_dir';
    }

    function get_mmg($conditions=[])
    {
        $this->db->select('f.*');
        $this->db->from('mmg_field_dir f');
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        //$this->db->where('f.status !=', '-1');
        $this->db->order_by('f.MMG_Fied_Name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function manage_mmg($data=[], $id='', $thumbnail)
    {  
        if($id)
        {
            if(!empty($this->get_mmg($id)))
            {
                $update['MMG_Fied_Name']              = $this->input->post('MMG_Fied_Name');
                  $update['programme_keywords']              = $this->input->post('programme_keywords');
                if(!empty($thumbnail))
                {
                    $update['grid_image']           = $thumbnail;
                }
                
                $this->db->where('MMG_Fied_Id', $id);
                $this->db->update($this->table, $update);                
                if($this->db->affected_rows() > 0)
                {
                    $return = ['error' => 0, 'message' => 'MMG successfully updated'];
                }
                else
                {
                    $return = ['error' => 1, 'message' => 'Unable to update mmg'];
                }
            }
            else
            {
                $return = ['error' => 1, 'message' => 'MMG not found'];
            }
        }
        else
        {   
            $insert['MMG_Fied_Name']              = $this->input->post('MMG_Fied_Name');
             $insert['programme_keywords']              = $this->input->post('programme_keywords');
            $insert['grid_image']                  = $thumbnail;
            $this->db->insert($this->table, $insert);
            $insert_id = $this->db->insert_id();

            if($insert_id)
            {
                $return = ['error' => 0, 'message' => 'MMG successfully added'];
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Unable to add mmg'];
            }
        }
        return $return;
    }


    function get_table_data($table, $conditions)
    {
        $this->db->select('*');
        $this->db->from($table);
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $query = $this->db->get();
        return $query->result_array();
    }

}