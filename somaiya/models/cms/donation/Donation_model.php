<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Donation_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_donation_list($conditions=[])
    {
        $this->db->select('a.*, a.public as public, ac.contents_id, ac.description,ac.language_id, dt.dontype_id, dt.donation_type, ds.id, ds.donation_type, ds.sub_donation_type');
        $this->db->from('donation a');
        $this->db->join('contentsdonation ac','a.donation_id = ac.donation_id','left');
        $this->db->join('donation_type dt','a.dontype_id = dt.dontype_id','left');
        $this->db->join('donation_sub_type ds','a.sub_dontype_id = ds.id','left');

        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->where('ac.language_id',1);
        $this->db->where('a.public !=', '-1');
        $this->db->order_by('a.donation_id', 'DESC');
        $query = $this->db->get();

        // $str = $this->db->last_query();
   
        // echo "<pre>";
        // print_r($str);
        // exit;
        return $query->result_array();
    }

    function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'donation';
        $table2                     = 'contentsdonation';

        $res                        = $this->db->insert($table, $data['donation']);
        $insert_id = $this->db->insert_id();

        if($res)
        {
            $data['contents']['donation_id']      = $insert_id;
            
            $res                        = $this->db->insert($table2, $data['contents']);

            $response['status']     = 'success';
            $response['id']         = $insert_id;
        }
        else
        {
            $response['status']     = 'error';
            $response['message']    = $this->db->_error_message();
        }
        return  $response;
    }

    function _update($col, $val, $updatedata) {
        $response['status']         = 'error';
        $table                      = 'donation';
        $table2                     = 'contentsdonation';

        $this->db->where($col, $val);
        $update                     = $this->db->update($table, $updatedata['donation']);

        // $str = $this->db->last_query();
   
        // echo "<pre>";
        // print_r($str);
        // echo "<br>----------------<br>";

        if($update)
        {
            $this->db->where('contents_id', $updatedata['contents']['contents_id']);
            $this->db->update($table2, $updatedata['contents']);

            // $str1 = $this->db->last_query();
            // echo "<pre>";
            // print_r($str1);
            // echo "<br>----------------<br>";

            // exit();

            $response['status']     = 'success';
            $response[$col]         = $val;
        }
        else
        {
            $response['status']     = 'error';
            $response['message']    = $this->db->_error_message();
        }
        return $response;
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

    function delete_image($id, $update)
    {
        // $update['image']            = null;
        // $update['modified_on']      = date('Y-m-d H:i:s');
        // $update['modified_by']      = $this->session->userdata('user_id');

        $this->db->where('donation_id', $id);
        $this->db->update('donation', $update);

        return $this->db->affected_rows();
    }

    function _delete($col, $val) {
            
        $update['public']           = -1;
        $update['modified_on']      = date('Y-m-d H:i:s');
        $update['modified_by']      = $this->session->userdata('user_id');

        $table      = 'donation';
        $this->db->where($col, $val);
        //$res        = $this->db->delete($table);
        $res        = $this->db->update($table,$update);
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }
    

    function get_all_documents($id)
    {
        $this->db->select('*');
        $this->db->from('donation_document_links');
        $this->db->where('donation_id', $id);
        $this->db->order_by('link_order', 'ASC');
        $query = $this->db->get();
        return  $query->result_array();
    }



    function manage_donation($data=[], $id='', $image, $instituteID)
    {  
        if($id)
        {
            // if(!empty($this->get_donation_list($id)))
            // {
                $update['institute_id']         = $this->data['institute_id'];
                $update['project_name']         = $this->input->post('project_name');
                $update['dontype_id']           = $this->input->post('type_id');
                $update['sub_dontype_id']       = $this->input->post('sub_donation_type');
                $update['never_ending']         = $this->input->post('never_ending');
                $update['end_date']             = $this->input->post('end_date');
                $update['start_date']           = $this->input->post('start_date');
                $update['radio_amount']         = $this->input->post('radio_amount');
                $update['goal_amount']          = $this->input->post('goal_amount');
                $update['quantity_amount']      = $this->input->post('quantity_amount');
                if(!empty($image))
                {
                    $update['image']            = isset($image) ? $image : '';
                }

                $update['tax_benefit']          = $this->input->post('tax_benefit');
                $update['featured']             = $this->input->post('featured');
                $update['email_doc']            = $this->input->post('email_doc');
                // $update['donation']['flag']                 = $this->input->post('flag');
                $update['public']               = $this->input->post('public');
                $update['modified_on']          = date('Y-m-d H:i:s');
                $update['modified_by']          = $this->session->userdata['user_id'];

                $this->db->where('donation_id', $id);
                $this->db->update('donation', $update);
                
                $upd['contents_id']          = $this->input->post('contents_id');
                $upd['name']                 = $this->input->post('project_name');
                $upd['description']          = $this->input->post('description');
                $upd['language_id']          = $this->input->post('language_id');
                $upd['data_type']            = 'donation';
                $upd['public']               = 1; // 1 = active
                $upd['modified_on']          = date('Y-m-d H:i:s');
                $upd['modified_by']          = $this->session->userdata['user_id'];

                $this->db->where('contents_id', $data['contents_id']);
                $this->db->update('contentsdonation', $upd);

                if($id!=null) 
                {
                    $save = [];
                    $save_user_group = [];
                    foreach ($data['link_name'] as $key => $value) 
                    {

                        $save['link_name']  = $value;
                        $save['link_url']   = $data['link_url'][$key];
                        $save['id']         = $data['id2'][$key];
                        $save_group_inst[]  = $save;
                    }

                    $id2    = $this->input->post('id2');

                    if($id2 == '')
                    { 

                        if(isset($data['links_array_check']) && $data['links_array_check'] == 1){ 
                            foreach($save_group_inst as $result){     
                                $this->db->insert('donation_document_links',array("link_name"=>$result['link_name'],"link_url"=>$result['link_url'],"donation_id"=>$id,"link_order"=>1));
                                $pinsert[] = $this->db->insert_id();
                            }
                        }
                    } 

                    if(isset($data['links_array_check']) && $data['links_array_check'] == 2)
                    { 
                        
                        if (!empty($save_group_inst))  {  
                            foreach($save_group_inst as $key => $result){ 
                                if($result['id'] == ''){
                                    $last_row=$this->db->select('link_order')->order_by('link_order',"desc")->limit(1)->get('donation_document_links')->row();
                                    $w_order = $last_row->link_order; 
                                    $link_order = $w_order + 1;
                                    $this->db->insert('donation_document_links',array("link_name"=>$result['link_name'],"link_url"=>$result['link_url'],"donation_id"=>$id,"link_order"=>$link_order));
                                    $pinsert[] = $this->db->insert_id();
                                }


                                $this->db->where('id',$result['id']);
                                $this->db->update('donation_document_links',array("link_name"=>$result['link_name'],"link_url"=>$result['link_url'],"donation_id"=>$id)); 
                            }
                        }
                    } 
                }


                if($this->db->affected_rows() > 0)
                {
                    $return = ['error' => 0, 'message' => 'Donation successfully updated'];
                }
                else
                {
                    $return = ['error' => 1, 'message' => 'Unable to update Donation'];
                }
            // }
            // else
            // {
            //     $return = ['error' => 1, 'message' => 'Donation not found'];
            // }
        }
        else
        {   
            $insert['institute_id']         = $this->data['institute_id'];
            $insert['project_name']         = $this->input->post('project_name');
            $insert['dontype_id']           = $this->input->post('type_id');
            $insert['sub_dontype_id']       = $this->input->post('sub_donation_type');
            $insert['never_ending']         = $this->input->post('never_ending');
            $insert['end_date']             = $this->input->post('end_date');
            $insert['start_date']           = $this->input->post('start_date');
            $insert['radio_amount']         = $this->input->post('radio_amount');
            $insert['goal_amount']          = $this->input->post('goal_amount');
            $insert['quantity_amount']      = $this->input->post('quantity_amount');
            if(!empty($image))
            {
                $insert['image']            = isset($image) ? $image : '';
            }

            $insert['tax_benefit']          = $this->input->post('tax_benefit');
            $insert['featured']             = $this->input->post('featured');
            // $insert['donation']['flag']                 = $this->input->post('flag');
            $insert['email_doc']            = $this->input->post('email_doc');
            $insert['public']               = $this->input->post('public');
            $insert['created_on']           = date('Y-m-d H:i:s');
            $insert['created_by']           = $this->session->userdata['user_id'];

            $this->db->insert('donation', $insert);
            $insert_id = $this->db->insert_id();

            $ins['contents_id']          = $this->input->post('contents_id');
            $ins['name']                 = $this->input->post('project_name');
            $ins['description']          = $this->input->post('description');
            $ins['language_id']          = $this->input->post('language_id');
            $ins['donation_id']          = $insert_id;
            $ins['data_type']            = 'donation';
            $ins['public']               = 1; // 1 = active
            $ins['created_on']           = date('Y-m-d H:i:s');
            $ins['created_by']           = $this->session->userdata['user_id'];

            $this->db->insert('contentsdonation', $ins);
            $ins_id = $this->db->insert_id();

            $link_name = $this->input->post('link_name');
            $link_url = $this->input->post('link_url');

            foreach ($data['link_name'] as $key => $value) {
                $save['link_name']  = $value;
                $save['link_url']   = $data['link_url'][$key];
                $save_group_inst[]  = $save;
            }

            foreach($save_group_inst as $result)
            {     
                $this->db->insert('donation_document_links',array("link_name"=>$result['link_name'],"link_url"=>$result['link_url'],"donation_id"=>$insert_id,"link_order"=>1));
                $pinsert[] = $this->db->insert_id();
            } 

            if($insert_id)
            {
                $return = ['error' => 0, 'message' => 'Donation successfully added'];
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Unable to add Donation'];
            }
        }
        return $return;
    }


}