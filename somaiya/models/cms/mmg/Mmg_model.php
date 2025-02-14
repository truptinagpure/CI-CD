<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mmg_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'mmg_program';
    }

    function get_mmg($conditions=[])
    {
        $this->db->select('f.*,m.MMG_Fied_Name,f.grid_image as gimage,m.grid_image as grid_image');
        $this->db->from('mmg_program f');
        $this->db->join('mmg_field_dir m', 'm.MMG_Fied_Id = f.MMG_Fied_Id',"left");
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->where('f.status !=', '-1');
        $this->db->order_by('m.MMG_Fied_Name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function manage_mmg($data=[], $id='', $thumbnail, $images, $instituteID)
    {  
        if($id)
        {
            if(!empty($this->get_mmg($id)))
            {
                $update['MMG_Fied_Id']              = $this->input->post('mmg_name');
                $update['institute_id']             = $instituteID;
                $update['introduction']             = $this->input->post('introduction');
                $update['content']                  = $this->input->post('content');
                // if(!empty($thumbnail))
                // {
                //     $update['grid_image']           = $thumbnail;
                // }
                if(!empty($images))
                {
                    $update['banner_image_video']   = $images;
                }
                $update['status']                   = $this->input->post('status');
                $update['modified_on']              = date('Y-m-d H:i:s');
                $update['modified_by']              = $this->session->userdata('user_id');

                $this->db->where('id', $id);
                $this->db->update($this->table, $update);

                if($id!=null) 
                {
                    $save = [];
                    $save_user_group = [];
                    foreach ($data['link_name'] as $key => $value) 
                    {

                        $save['link_name']  = $value;
                        $save['link_url']   = $data['link_url'][$key];
                        $save['mmg_id']     = $data['mmg_array'][$key];
                        $save['id']         = $data['id2'][$key];
                        $save_group_inst[]  = $save;
                    }

                    $mmg_id = $this->input->post('mmg_id');
                    $id2    = $this->input->post('id2');

                    if($id2 == '')
                    { 

                        if(isset($data['links_array_check']) && $data['links_array_check'] == 1){ 
                            foreach($save_group_inst as $result){     
                                $this->db->insert('mmg_program_links',array("link_name"=>$result['link_name'],"link_url"=>$result['link_url'],"mmg_id"=>$result['mmg_id'],"mmg_program_id"=>$mmg_id,"link_order"=>1));
                                $pinsert[] = $this->db->insert_id();
                            }
                        }
                    } 

                    if(isset($data['links_array_check']) && $data['links_array_check'] == 2)
                    { 
                        
                        if (!empty($save_group_inst))  {  
                            foreach($save_group_inst as $key => $result){ 
                                if($result['id'] == ''){
                                    $last_row=$this->db->select('link_order')->order_by('link_order',"desc")->limit(1)->get('mmg_program_links')->row();
                                    $w_order = $last_row->link_order; 
                                    $link_order = $w_order + 1;
                                    $this->db->insert('mmg_program_links',array("link_name"=>$result['link_name'],"link_url"=>$result['link_url'],"mmg_id"=>$result['mmg_id'],"mmg_program_id"=>$mmg_id,"link_order"=>$link_order));
                                    $pinsert[] = $this->db->insert_id();
                                }


                                $this->db->where('id',$result['id']);
                                $this->db->update('mmg_program_links',array("link_name"=>$result['link_name'],"link_url"=>$result['link_url'],"mmg_id"=>$result['mmg_id'],"mmg_program_id"=>$mmg_id)); 
                            }
                        }
                    } 
                }


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
            $insert['MMG_Fied_Id']              = $this->input->post('mmg_name');
            $insert['institute_id']             = $instituteID;
            $insert['introduction']             = $this->input->post('introduction');
            $insert['content']                  = $this->input->post('content');
            // $insert['grid_image']               = $thumbnail;
            $insert['banner_image_video']       = $images;
            $insert['status']                   = $this->input->post('status');
            $insert['created_on']               = date('Y-m-d H:i:s');
            $insert['created_by']               = $this->session->userdata('user_id');
            $insert['modified_on']              = date('Y-m-d H:i:s');
            $insert['modified_by']              = $this->session->userdata('user_id');
            $this->db->insert($this->table, $insert);
            $insert_id = $this->db->insert_id();

            $link_name = $this->input->post('link_name');
            $link_url = $this->input->post('link_url');


            $save = [];
            $save_user_group = [];
            foreach ($data['link_name'] as $key => $value) {
                $save['link_name']  = $value;
                $save['link_url']   = $data['link_url'][$key];
                $save['mmg_id']     = $data['mmg_array'][$key];
                $save_group_inst[]  = $save;
            }

            foreach($save_group_inst as $result)
            {     
                $this->db->insert('mmg_program_links',array("link_name"=>$result['link_name'],"link_url"=>$result['link_url'],"mmg_id"=>$result['mmg_id'],"mmg_program_id"=>$insert_id,"link_order"=>1));
                $pinsert[] = $this->db->insert_id();
            } 

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

    function get_all_mmg_fields($instituteID)
    {
        // $this->db->select('DISTINCT(edu_map_course_head.MMG_Field_Id) as mmg_id, mmg_field_dir.MMG_Fied_Name as MMG_Fied_Name');
        // $this->db->from('edu_map_course_head');
        // $this->db->join('mmg_field_dir', 'mmg_field_dir.MMG_Fied_Id = edu_map_course_head.MMG_Field_Id',"left");
        // $this->db->where('edu_map_course_head.INST_ID',$instituteID);
        // $query = $this->db->get();
        // return $query->result_array();
        $this->db->select('mmg_field_dir.MMG_Fied_Id as mmg_id, mmg_field_dir.MMG_Fied_Name as MMG_Fied_Name');
        $this->db->from('mmg_field_dir');
        //$this->db->join('mmg_field_dir', 'mmg_field_dir.MMG_Fied_Id = edu_map_course_head.MMG_Field_Id',"left");
        //$this->db->where('edu_map_course_head.INST_ID',$instituteID);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_mmg_ids()
    {
        $this->db->select('*');
        $this->db->from('mmg_dir');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_links($id)
    {
        $this->db->select('*');
        $this->db->from('mmg_program_links');
        $this->db->where('mmg_program_id', $id);
        $this->db->order_by('link_order', 'ASC');
        $query = $this->db->get();
        return  $query->result_array();
    }
}