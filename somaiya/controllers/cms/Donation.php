<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Donation extends Somaiya_Controller
{
    private $default_institute_id;

    function __construct()
    {
        parent::__construct('backend');
        $this->load->model('cms/donation/Donation_model', 'donation_model');
        $this->load->model('cms/donation/Sub_type_model', 'sub_type');
        $this->load->model('cms/Somaiya_general_admin_model', 'Somaiya_general_admin_model');
        $user_id = $this->session->userdata['user_id'];
        $default_institute_id = $this->config->item('default_institute_id');

    }

    /** DASHBOARD **/

    function index()
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "news_media";
        $this->data['child_menu_type']      = "donation";
        $this->data['sub_child_menu_type']  = "";

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];

        validate_permissions('Donation', 'index', $this->config->item('method_for_view'), $this->data['institute_id']);
        
        $this->data['data_list']            = $this->donation_model->get_donation_list(array('a.institute_id' => $this->data['institute_id']));

        $this->data['title']                = _l("Module",$this);
        $this->data['page']                 = "Module";
        $this->data['content']              = $this->load->view('cms/donation/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edit_new($id='')
    {
        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "donation";
        $this->data['child_menu_type']      = "save_donation";
        $this->data['sub_child_menu_type']  = "";
        $this->data['donation_data']            = [];
        $this->data['donation_id']              = $id;

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
        $this->data['languages']            = $this->Somaiya_general_admin_model->get_all_language();

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Donation', 'edit', $per_action, $this->data['institute_id']);

        if($id)
        {
            $this->data['donation_documents']   = $this->donation_model->get_all_documents($id);
        }

        
        if($this->input->post())
        {   
            $this->data['donation_data']        = $this->input->post();
            // echo "<pre>"; print_r($this->data['donation_data']);exit();
        }

        $this->form_validation->set_rules('project_name', 'Project Name', 'required');

        if($this->form_validation->run($this) === TRUE)
        {
            if($this->input->post())
            {   
                $path  = './upload_file/donation_upload/';
                $filesnew   = $this->base64_to_image($this->input->post('image'), $path);

                $image  = isset($filesnew['image']) ? $filesnew['image'] : '';     
                                
                if($id)
                {
                    $update['donation']['institute_id']         = $this->data['institute_id'];
                    $update['donation']['project_name']         = $this->input->post('project_name');
                    $update['donation']['dontype_id']           = $this->input->post('type_id');
                    $update['donation']['sub_dontype_id']       = $this->input->post('sub_donation_type');
                    $update['donation']['never_ending']         = $this->input->post('never_ending');
                    $update['donation']['end_date']             = $this->input->post('end_date');
                    $update['donation']['start_date']           = $this->input->post('start_date');
                    $update['donation']['radio_amount']         = $this->input->post('radio_amount');
                    $update['donation']['goal_amount']          = $this->input->post('goal_amount');
                    $update['donation']['quantity_amount']      = $this->input->post('quantity_amount');
                    if(!empty($image))
                    {
                        $update['donation']['image']            = isset($image) ? $image : '';
                    }

                    $update['donation']['tax_benefit']          = $this->input->post('tax_benefit');
                    $update['donation']['featured']             = $this->input->post('featured');
                    $update['donation']['email_doc']            = $this->input->post('email_doc');
                    // $update['donation']['flag']                 = $this->input->post('flag');
                    $update['donation']['public']               = $this->input->post('public');
                    $update['donation']['modified_on']          = date('Y-m-d H:i:s');
                    $update['donation']['modified_by']          = $this->session->userdata['user_id'];

                    
                    $update['contents']['contents_id']          = $this->input->post('contents_id');
                    $update['contents']['name']                 = $this->input->post('project_name');
                    $update['contents']['description']          = $this->input->post('description');
                    $update['contents']['language_id']          = $this->input->post('language_id');
                    $update['contents']['data_type']            = 'donation';
                    $update['contents']['public']               = 1; // 1 = active
                    $update['contents']['modified_on']          = date('Y-m-d H:i:s');
                    $update['contents']['modified_by']          = $this->session->userdata['user_id'];

                    $response = $this->donation_model->_update('donation_id', $id, $update);
                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $donationt_id                                = $id;
                        $msg = ['error' => 0, 'message' => 'Donation successfully updated'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                else
                {
                    $insert['donation']['institute_id']         = $this->data['institute_id'];
                    $insert['donation']['project_name']         = $this->input->post('project_name');
                    $insert['donation']['dontype_id']           = $this->input->post('type_id');
                    $insert['donation']['sub_dontype_id']       = $this->input->post('sub_donation_type');
                    $insert['donation']['never_ending']         = $this->input->post('never_ending');
                    $insert['donation']['end_date']             = $this->input->post('end_date');
                    $insert['donation']['start_date']           = $this->input->post('start_date');
                    $insert['donation']['radio_amount']         = $this->input->post('radio_amount');
                    $insert['donation']['goal_amount']          = $this->input->post('goal_amount');
                    $insert['donation']['quantity_amount']      = $this->input->post('quantity_amount');
                    if(!empty($image))
                    {
                        $insert['donation']['image']            = isset($image) ? $image : '';
                    }

                    $insert['donation']['tax_benefit']          = $this->input->post('tax_benefit');
                    $insert['donation']['featured']             = $this->input->post('featured');
                    // $insert['donation']['flag']                 = $this->input->post('flag');
                    $insert['donation']['email_doc']            = $this->input->post('email_doc');
                    $insert['donation']['public']               = $this->input->post('public');
                    $insert['donation']['created_on']           = date('Y-m-d H:i:s');
                    $insert['donation']['created_by']           = $this->session->userdata['user_id'];

                    $insert['contents']['contents_id']          = $this->input->post('contents_id');
                    $insert['contents']['name']                 = $this->input->post('project_name');
                    $insert['contents']['description']          = $this->input->post('description');
                    $insert['contents']['language_id']          = $this->input->post('language_id');
                    $insert['contents']['data_type']            = 'donation';
                    $insert['contents']['public']               = 1; // 1 = active
                    $insert['contents']['created_on']           = date('Y-m-d H:i:s');
                    $insert['contents']['created_by']           = $this->session->userdata['user_id'];

                    $response                 = $this->donation_model->_insert($insert);

                    if(isset($response['status']) && $response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Donation successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $response['message']];
                    }
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/donation/');
            }
        }

        if($id!='')
        {
            $donation                           = $this->donation_model->get_donation_list(['a.donation_id' => $id, 'a.public !=' => '-1']);
            // echo "<pre>"; print_r($donation);exit();
            $this->data['donation_data']        = isset($donation[0]) ? $donation[0] : [];
            
            if(empty($this->data['donation_data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'donation not found']);
                redirect(base_url()."cms/donation/");
            }
        }

        $this->data['donation_type']        = $this->sub_type->get_sub_type_parent();
        $this->data['content']              = $this->load->view('cms/donation/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }


    function edit($id='')
    {   

        $this->data['main_menu_type']       = "institute_menu";
        $this->data['sub_menu_type']        = "donation";
        $this->data['child_menu_type']      = "save_donation";
        $this->data['sub_child_menu_type']  = "";
        $this->data['donation_data']            = [];
        $this->data['donation_id']              = $id;

        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
        $this->data['languages']            = $this->Somaiya_general_admin_model->get_all_language();

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Donation', 'edit', $per_action, $this->data['institute_id']);

        // if($id)
        // {
        //     $this->data['donation_documents']  = $this->donation_model->get_all_documents($id);

        //     if(empty($this->data['donation_data']))
        //     {
        //         $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Donation not found']);
        //         redirect(base_url().'cms/donation/index/');
        //     }
        // }

        if($this->input->post())
        {
            $this->data['donation_data'] = $this->input->post();
            // echo "<pre>"; print_r($this->data['post_data']);exit();
        }

        $this->form_validation->set_rules('project_name', 'Project Name', 'required');

        if($this->form_validation->run($this) === TRUE)
        { 
            if($this->input->post())
            {   
                $path  = './upload_file/donation_upload/';
                $filesnew   = $this->base64_to_image($this->input->post('image'), $path);

                $image  = isset($filesnew['image']) ? $filesnew['image'] : ''; 

                $response = $this->donation_model->manage_donation($this->input->post(), $id,$image,$instituteID);
                if(isset($response['status']) && $response['status'] == 'success')
                {
                    $msg = ['error' => 0, 'message' => 'Donation successfully added'];
                }
                else
                {
                    $msg = ['error' => 0, 'message' => $response['message']];
                }
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url().'cms/donation/');
            }
        }
        if($id!='')
        {   
            $this->data['donation_documents']   = $this->donation_model->get_all_documents($id);
            $donation                           = $this->donation_model->get_donation_list(['a.donation_id' => $id, 'a.public !=' => '-1']);
            $this->data['donation_data']        = isset($donation[0]) ? $donation[0] : [];
            
            if(empty($this->data['donation_data']))
            {   
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'donation not found']);
                redirect(base_url()."cms/donation/");
            }
        }
        $this->data['donation_type']        = $this->sub_type->get_sub_type_parent();
        $this->data['content']              = $this->load->view('cms/donation/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);        
    }



    function base64_to_image($image_data='', $path='') {
        $image_name         = '';
        $path               = !empty($path) ? $path : './upload_file/donation_upload/';
        
        if(!empty($image_data))
        {   
            $image_parts    = explode(";base64,", $image_data);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type     = $image_type_aux[1];
            $image_base64   = base64_decode($image_parts[1]);
            $image_name     = uniqid().'.'.$image_type;
            $file           = $path.'/'.$image_name;
            file_put_contents($file, $image_base64);
        }
        return ['image' => $image_name];
    }

    function deleteimage()
    {
        $deleteid  = $this->input->post('donation_id');
        $update['image']                   = null;
        $update['modified_on']             = date('Y-m-d H:i:s');
        $update['modified_by']             = $this->session->userdata('user_id');

        $this->donation_model->delete_image($deleteid, $update);
        echo true;

    }

    function delete($id='')
    {
        $this->data['institute_id']         = $this->session->userdata['sess_institute_id'];
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
            
        validate_permissions('Donation', 'delete', $this->config->item('method_for_delete'), $this->data['institute_id']);
             
        $donation = $this->donation_model->get_donation_list(['a.donation_id' => $id, 'a.public !=' => '-1']);

        if(!empty($donation))
        {
            $response = $this->donation_model->_delete('donation_id', $id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Plant not found.']);
        }
        redirect(base_url().'cms/donation/');
    }


    function get_sub_type($parent_id)
    {
        $sql            = 'Select s.* FROM donation_sub_type s WHERE s.public = "1" AND s.donation_type="'.$parent_id.'" ORDER BY s.sub_donation_type ASC';
        $sub_type       = $this->common_model->custom_query($sql);
        return $sub_type;
    }

    function get_subtype_options()
    { 
        $options            = '<option value="">-- Select Sub Type --</option>';
        $parent_id          = isset($_POST['parent_id']) ? $_POST['parent_id'] : '';
        $sub_type           = $this->get_sub_type($parent_id);
        $sub_type_id        = isset($_POST['sub_donation_type']) ? $_POST['sub_donation_type'] : '';

        foreach ($sub_type as $key => $value) {
            $selected           = '';
            if($sub_type_id == $value['id'])
            {
                $selected       = 'selected="selected"';
            }
            $options            .= '<option value="'.$value['id'].'" '.$selected.'>'.$value['sub_donation_type'].'</option>';
        }
        echo json_encode($options);exit;
    }


    function delete_donation_documents()
    {        
        $deleteid  = $this->input->post('pid');
        $this->db->delete('donation_document_links', array('id' => $deleteid));
        $verify = $this->db->affected_rows();
        echo $verify;
    }

    function save_donation_documents_order()
    {   
        $programme_id = $_POST["programme_id_array"];

        $i=1;
        foreach($programme_id as $k=>$v){
            $query=$this->db->query("UPDATE donation_document_links SET link_order = '".$i."' where id = '".$v."'");


            $i++;
        }

        echo 'Link order has been updated';
    }


}