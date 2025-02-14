<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Manage_calendar_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_calendar($instituteID)
    {
        $this->db->select("c.*, ct.name as calendar_type, i.INST_NAME as institute_name");
        $this->db->from('event_calendar c');
        //$this->db->join('calendar_types ct', 'c.calendar_type_id=ct.id', 'left');
        $this->db->join('event_calendar_type ct', 'c.calendar_type_id=ct.id', 'left');
        $this->db->join('edu_institute_dir i', "i.INST_ID = c.institute_id");
        $this->db->where('c.institute_id =', $instituteID);
        $this->db->where('c.status !=', '-1');
        $this->db->order_by('c.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // function get_calendar_data($id)
    // {
    //     $this->db->select('*');
    //     $this->db->from('event_calendar');
    //     $this->db->join('calendar_types ct', 'c.calendar_type_id=ct.id', 'left');
    //     $this->db->where('id', $id);
    //     $this->db->where('status !=', '-1');
    //     $query = $this->db->get();
    //     $return = $query->result_array();
    //     return count($return)!=0?$return[0]:null;
    // }

    function get_calendar_data($id='', $conditions=[])
    {
        $this->db->select('*');
        $this->db->from('event_calendar');
        $this->db->where('event_calendar.id', $id);
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

    function get_document_detail($id)
    {  
        $this->db->select('*');
        $this->db->from('event_calendar_document');
        $this->db->where('relation_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    } 

    function manage_calendar($data=[], $id='', $documents)
    {   
        $allowed_inst_ids           = [];
        $save_data                  = [];
        // foreach ($_POST['institute_id'] as $key => $value) 
        // {
        //     $allowed_inst_ids[] = $value;
        // }

        $save_data = !empty($allowed_inst_ids) ? implode(',', $allowed_inst_ids) : '';

        $allowed_type_ids           = [];
        $save_type_data             = [];
        foreach ($_POST['calendar_type_id'] as $key => $value) 
        {
            $allowed_type_ids[] = $value;
        }

        $save_type_data = !empty($allowed_type_ids) ? implode(',', $allowed_type_ids) : '';

        $allowed_sub_type_ids           = [];
        $save_sub_type_data             = [];
        foreach ($_POST['calendar_sub_type_id'] as $key => $value) 
        {
            $allowed_sub_type_ids[] = $value;
        }

        $save_sub_type_data = !empty($allowed_sub_type_ids) ? implode(',', $allowed_sub_type_ids) : '';
  
        if($id)
        {   
            $update['name']                     = $this->input->post('name');
            $update['pattern']                  = $this->input->post('pattern');
            //$update['institute_id']             = $save_data;
            $update['institute_id']             = $this->session->userdata['sess_institute_id'];
            $update['calendar_type_id']         = $save_type_data;
            $update['calender_sub_type_id']     = $save_sub_type_data;
            $update['description']              = $this->input->post('description');
            $update['start_date']               = $this->input->post('start_date');
            $update['end_date']                 = $this->input->post('end_date');
            $update['status']                   = $this->input->post('status');
            $update['modified_on']              = date('Y-m-d H:i:s');
            $update['modified_by']              = $this->session->userdata('user_id');
            $this->db->where('id', $id);
            $this->db->update('event_calendar', $update);


            if(!empty($documents))
            {
                foreach ($documents as $key => $value) {
                    $save_document['document'] = $value;
                    $save_document['relation_id'] = $id;
                    $this->db->insert('event_calendar_document',array("document"=>$value,"relation_id"=>$id));
                }
            }

            if($this->db->affected_rows() > 0)
            {
                $msg = ['error' => 0, 'message' => 'Calendar successfully updated'];
            }
            else
            {
                $msg = ['error' => 1, 'message' => 'Unable to update Calendar'];
            }
        }
        else
        {   
            $insert['name']                     = $this->input->post('name');
            $insert['pattern']                  = $this->input->post('pattern');
            //$insert['institute_id']             = $save_data;
            $insert['institute_id']             = $this->session->userdata['sess_institute_id'];;
            $insert['calendar_type_id']         = $save_type_data;
            $insert['calender_sub_type_id']     = $save_sub_type_data;
            $insert['description']              = $this->input->post('description');
            $insert['start_date']               = $this->input->post('start_date');
            $insert['end_date']                 = $this->input->post('end_date');
            $insert['status']                   = $this->input->post('status');
            $insert['created_on']               = date('Y-m-d H:i:s');
            $insert['created_by']               = $this->session->userdata('user_id');
            $insert['modified_on']              = date('Y-m-d H:i:s');
            $insert['modified_by']              = $this->session->userdata('user_id');
            $this->db->insert('event_calendar', $insert);
            $ins_id = $this->db->insert_id();


            if(!empty($documents))
            {
                foreach ($documents as $key => $value) {
                    $save_document['document'] = $value;
                    $save_document['relation_id'] = $ins_id;
                    $this->db->insert('event_calendar_document',array("document"=>$value,"relation_id"=>$ins_id));
                }
            }

            if($insert_id)
            {
                $msg = ['error' => 1, 'message' => 'Unable to add Calendar'];
            }
            else
            {
                $msg = ['error' => 0, 'message' => 'Calendar successfully added'];
            }

        }

        return $msg;
    }
}