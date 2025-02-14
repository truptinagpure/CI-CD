<?php
/**
 * Created by Somaiya Team.
 * User: Somaiya
 * Date: 9/16/2015
 * Time: 1:03 AM
 * Project: Somaiya Vidyavihar
 * Website: http://www.somaiya.com
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Somaiya_general_admin extends Somaiya_Controller 
{
    private $default_institute_id;

    function __construct()
    {
        parent::__construct('backend');
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        
        //load google login library
        $this->load->library('google');
        
        //google login url
        $data['loginURL'] = $this->google->loginURL();

        $instituteID=$this->uri->segment(3);
        $user_id = $this->session->userdata['user_id'];
        $this->default_institute_id = $this->config->item('default_institute_id');

    }

    /** DASHBOARD **/

    function index()
    {
        $this->data['main_menu_type'] = "dashboard";
        $this->data['sub_menu_type'] = "dashboard";
        $this->data['child_menu_type'] = "";
        $this->data['sub_child_menu_type'] = "";

        $this->data['languages'] = $this->Somaiya_general_admin_model->get_all_language();
        foreach($this->data['languages'] as &$item){
            $item["content_percent"] = $this->Somaiya_general_admin_model->count_extensions(array("language_id"=>$item["language_id"]))!=0?(($this->Somaiya_general_admin_model->count_extensions(array("language_id"=>$item["language_id"])) * 100) / $extension_count):0;
            $item["comment_percent"] = $this->Somaiya_general_admin_model->count_comment(array("lang"=>$item["code"]))!=0?(($this->Somaiya_general_admin_model->count_comment(array("lang"=>$item["code"])) * 100) / $comment_count):0;
        }
        
        $this->data['content']=$this->load->view($this->mainTemplate.'/main',$this->data,true);
        $this->data['title'] = "home";
        $this->data['page'] = "home";
        $this->load->view($this->mainTemplate,$this->data);
    }



    /** SETTINGS **/

    function settings($sub_page='general')
    {
        $this->data['main_menu_type'] = "settings";
        $this->data['sub_menu_type'] = "settings";
        $this->data['child_menu_type'] = "";
        $this->data['sub_child_menu_type'] = "";

        validate_permissions('Somaiya_general_admin', 'settings', $this->config->item('method_for_view'), $this->default_institute_id);

        if(isset($_POST['data'])){
                $data = $this->input->post('data');
                if(isset($data["options"])){
                    foreach($data["options"] as $key=>$value){
                        if($this->Somaiya_general_admin_model->check_setting_options($key)){
                            $this->Somaiya_general_admin_model->edit_setting_options($key,$value);
                        }else{
                            $this->Somaiya_general_admin_model->insert_setting_options($key,$value);
                        }
                    }
                    unset($data["options"]);
                }
                $this->Somaiya_general_admin_model->edit_setting($data);
                $this->session->set_flashdata('success', _l("Your Setting has been updated successfully!",$this));
            redirect(base_url('admin/settings/'.$sub_page));
        }

        $data_options = array();
        $setting_options = $this->Somaiya_general_admin_model->get_all_setting_options();
        foreach($setting_options as $value){
            $data_options[$value["language_id"]] = $value;
        }
        $this->data['options'] = $data_options;
        $this->data['languages'] = $this->Somaiya_general_admin_model->get_all_language();
        if($sub_page=='general'){
            $this->data['title'] = _l('General settings',$this);
            $this->data['content']=$this->load->view($this->mainTemplate.'/setting',$this->data,true);
        }elseif($sub_page=='seo'){
            $this->data['title'] = _l('SEO optimise',$this);
            $this->data['content']=$this->load->view($this->mainTemplate.'/setting_seo',$this->data,true);
        }elseif($sub_page=='contact'){
            $this->data['title'] = _l('Contact settings',$this);
            $this->data['content']=$this->load->view($this->mainTemplate.'/setting_contact',$this->data,true);
        }elseif($sub_page=='mail'){
            $this->data['public_keys'] = array(
                array('label'=>_l('Company name',$this),'value'=>'[--$company--]'),
                array('label'=>_l('Site Email',$this),'value'=>'[--$smail--]'),
                array('label'=>_l('Date',$this),'value'=>'[--$date--]'),
            );
            $this->data['register_keys'] = array(
                array('label'=>_l('Company name',$this),'value'=>'[--$company--]'),
                array('label'=>_l('Username',$this),'value'=>'[--$username--]'),
                array('label'=>_l('Email address',$this),'value'=>'[--$email--]'),
                array('label'=>_l('User activate URL',$this),'value'=>'[--$refurl--]'),
                array('label'=>_l('Date',$this),'value'=>'[--$date--]'),
                array('label'=>_l('User created date',$this),'value'=>'[--$cdate--]'),
            );
            $this->data['activate_keys'] = array(
                array('label'=>_l('Company name',$this),'value'=>'[--$company--]'),
                array('label'=>_l('Username',$this),'value'=>'[--$username--]'),
                array('label'=>_l('Email address',$this),'value'=>'[--$email--]'),
                array('label'=>_l('Date',$this),'value'=>'[--$date--]'),
            );
            $this->data['reset_pass_keys'] = array(
                array('label'=>_l('Company name',$this),'value'=>'[--$company--]'),
                array('label'=>_l('Username',$this),'value'=>'[--$username--]'),
                array('label'=>_l('Email address',$this),'value'=>'[--$email--]'),
                array('label'=>_l('Make new password URL',$this),'value'=>'[--$refurl--]'),
            );
            $this->data['title'] = _l('Send mail settings',$this);
            $this->data['content']=$this->load->view($this->mainTemplate.'/setting_mail',$this->data,true);
        }elseif($sub_page=='media_source'){
            $this->data['title'] = _l('Media source settings',$this);
            $this->data['content']=$this->load->view($this->mainTemplate.'/setting_media_source',$this->data,true);
        }
        $this->data['page'] = "setting";
        $this->load->view($this->mainTemplate,$this->data);
    }



    /** USER MODULE CODE **/

    function user()
    {
        $this->data['main_menu_type'] = "user_management";
        $this->data['sub_menu_type'] = "users";
        $this->data['child_menu_type'] = "users";
        $this->data['sub_child_menu_type'] = "";

        validate_permissions('Somaiya_general_admin', 'user', $this->config->item('method_for_view'), $this->default_institute_id);

        $this->data['data_list']=$this->Somaiya_general_admin_model->get_all_user();
        $this->data['title'] = _l("User",$this);
        $this->data['page'] = "user";
        $this->data['content']=$this->load->view($this->mainTemplate.'/user',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function edituser($id='')
    {
        $this->data['main_menu_type'] = "user_management";
        $this->data['sub_menu_type'] = "users";
        $this->data['child_menu_type'] = "users";
        $this->data['sub_child_menu_type'] = "";

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Somaiya_general_admin', 'edituser', $per_action);

            if($id!='')
            {
                $this->data['data']=$this->Somaiya_general_admin_model->get_user_detail($id);
                if($this->data['data']==null)
                    redirect(base_url()."admin/user");
            }

            $this->form_validation->set_rules('login_type', 'Login Type', 'required');
            $this->form_validation->set_rules('group_id', 'Group', '');

            if(isset($_POST['login_type']) && !empty($_POST['login_type']))
            {
                if($_POST['login_type'] == '1')
                {
                    $this->form_validation->set_rules('username', 'Username', 'required|callback_custom_unique_username[username]');
                    if(isset($_POST['email']) && !empty($_POST['email']))
                    {
                        $this->form_validation->set_rules('email', 'Email', 'callback_custom_unique_email[email]');
                    }
                }
                else if($_POST['login_type'] == '2')
                {
                    $this->form_validation->set_rules('email', 'Email', 'required|callback_custom_unique_email[email]');
                }
            }

            if($this->form_validation->run($this) === TRUE)
            {
                if($this->input->post())
                {
                    if($this->Somaiya_general_admin_model->user_manipulate($_POST, $id))
                    {
                        $this->session->set_flashdata('requeststatus', ['error' => 0, 'message' => 'User saved successfully']);
                    }
                    else
                    {
                        $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Unable to save an user']);
                    }
                    redirect(base_url()."admin/user/");
                }
            }

            $this->data['title'] = _l("User",$this);
            $this->data['groups'] = $this->Somaiya_general_admin_model->get_all_groups();
            $this->data['institutes_list'] = $this->Somaiya_general_admin_model->get_all_institute();
            $this->data['uservalue'] = $this->Somaiya_general_admin_model->get_all_uservalue($id);
            $this->data['page'] = "user";
            $this->data['content']=$this->load->view($this->mainTemplate.'/user_edit',$this->data,true);
            $this->load->view($this->mainTemplate,$this->data);
    }

    function user_manipulate($id=null)
    {
        if($this->Somaiya_general_admin_model->user_manipulate($_POST["data"], $id))
        {
            $this->session->set_flashdata('requeststatus', ['error' => 0, 'message' => 'User saved successfully']);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Unable to save an user']);
        }
        redirect(base_url()."admin/user/");
    }


    function deleteusergroup(){
        $deleteid  = $this->input->post('ugiid');
        $this->db->delete('user_groups_institute', array('ugiid' => $deleteid));
        $verify = $this->db->affected_rows();
        echo $verify;
    }

    function appendinstitute()
    { 
        $institutes_list  = $this->Somaiya_general_admin_model->get_all_institute();

        $options = '<option value="">Select Institute</option>';

        foreach ($institutes_list as $key => $value) {
            $options .= '<option value="'.$value["INST_ID"].'">'.$value["INST_NAME"].'</option>';
        }

        echo $options;
    }

    function appendgroups()
    { 
        $groups_list  = $this->Somaiya_general_admin_model->get_all_groups();

        $options = '<option value="">Select Group</option>';

        foreach ($groups_list as $key => $value) {
            $options .= '<option value="'.$value["group_id"].'">'.$value["group_name"].'</option>';
        }

        echo $options;
    }

    public function custom_unique_username($str, $func)
    {
        $this->form_validation->set_message('custom_unique_username', "Username already exist");

        $result = TRUE;
        if(!empty($str))
        {
            $sql = 'SELECT * FROM users WHERE username="'.$str.'"';
            if(isset($_POST['user_id']) && !empty($_POST['user_id']))
            {
                $sql .= ' AND user_id != "'.$_POST['user_id'].'"';
            }
            $result = $this->common_model->custom_query($sql);

            if(isset($result[0]) && !empty($result[0]))
            {
                $result = FALSE;
            }
            else
            {
                $result = TRUE;
            }
        }
        return $result;
    }

    function ajax_check_username()
    {
        if($this->input->post())
        {
            $result = $this->custom_unique_username($this->input->post('username'), '');
            echo $result;exit;
        }
    }

    public function custom_unique_email($str, $func)
    {
        $this->form_validation->set_message('custom_unique_email', "Email already exist");

        $result = TRUE;
        if(!empty($str))
        {
            $sql = 'SELECT * FROM users WHERE email="'.$str.'"';
            if(isset($_POST['user_id']) && !empty($_POST['user_id']))
            {
                $sql .= ' AND user_id != "'.$_POST['user_id'].'"';
            }
            $result = $this->common_model->custom_query($sql);

            if(isset($result[0]) && !empty($result[0]))
            {
                $result = FALSE;
            }
            else
            {
                $result = TRUE;
            }
        }
        return $result;
    }

    function ajax_check_email()
    {
        if($this->input->post())
        {
            $result = $this->custom_unique_email($this->input->post('email'), '');
            echo $result;exit;
        }
    }

    function deleteuser($id=0,$status=0)
    {
        validate_permissions('Somaiya_general_admin', 'deleteuser', $this->config->item('method_for_delete'), $this->default_institute_id);

        $this->db->trans_start();
        $this->db->delete('users', array('user_id' => $id));
        $this->db->trans_complete();
        $this->session->set_flashdata('success', _l('Deleted User',$this));
        redirect(base_url()."admin/user/");
    }


    /** USER GROUPS CODE **/

    function groups()
    {
        $this->data['main_menu_type'] = "user_management";
        $this->data['sub_menu_type'] = "groups";
        $this->data['child_menu_type'] = "groups";
        $this->data['sub_child_menu_type'] = "";

        validate_permissions('Somaiya_general_admin', 'groups', $this->config->item('method_for_view'), $this->default_institute_id);

        $this->data['data_list']=$this->Somaiya_general_admin_model->get_all_groups();
        $this->data['title'] = _l("Groups",$this);
        $this->data['page'] = "groups";
        $this->data['content']=$this->load->view($this->mainTemplate.'/groups',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);  
    }

    function editgroups($id='')
    {
        $this->data['main_menu_type'] = "user_management";
        $this->data['sub_menu_type'] = "groups";
        $this->data['child_menu_type'] = "groups";
        $this->data['sub_child_menu_type'] = "";

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Somaiya_general_admin', 'editgroups', $per_action, $this->default_institute_id);

            if($id!='')
            {
                $this->data['data']=$this->Somaiya_general_admin_model->get_groups_detail($id);
                if($this->data['data']==null)
                    redirect(base_url()."admin/groups");
            }
            $this->load->library('controllerlist');
            $this->data['data_list']=$this->controllerlist->getControllers();
            $a=$this->data['data_list']['Somaiya_general_admin'];
            $b=$this->data['data_list']['Category'];
            $c=$this->data['data_list']['Tags'];
            $d=$this->data['data_list']['Locations'];
            $e=$this->data['data_list']['Public_lectures'];
            $f=$this->data['data_list']['Speakers'];
            $g=$this->data['data_list']['Designations'];

            $data_list =  array_merge($a,$b,$c,$d,$e,$f,$g);
            $this->data['data_list'] = $data_list;
            $count = count($this->data['data_list']);
            $i = 0;
            for($i=0;$i<$count;$i++){
                _l($this->data['data_list'][$i],$this);
            }
            $this->data['title'] = _l("User",$this);
            $this->data['page'] = "groups";
            $this->data['content']=$this->load->view($this->mainTemplate.'/groups_edit',$this->data,true);
            $this->load->view($this->mainTemplate,$this->data);  
    }

    function groups_manipulate($id=null)
    {
        if ($this->Somaiya_general_admin_model->groups_manipulate($_POST["data"],$id))
        {
            $this->session->set_flashdata('success', _l('Updated Group',$this));
        }
        else
        {
            $this->session->set_flashdata('error', _l('Updated user error. Please try later',$this));
        }
        redirect(base_url()."admin/groups/");
    }

    function deletegroups($id=0)
    {
        validate_permissions('Somaiya_general_admin', 'deletegroups', $this->config->item('method_for_delete'), $this->default_institute_id);

        $this->db->trans_start();
        $this->db->delete('groups', array('group_id' => $id));
        $this->db->trans_complete();
        $this->session->set_flashdata('success', _l('Deleted Group',$this));
        redirect(base_url()."admin/groups/");
    }


    /** PAGE CODE **/

    function page($id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "page";
        $this->data['child_menu_type'] = "";
        $this->data['sub_child_menu_type'] = "";

        $inst_id = $this->uri->segment(3);
        validate_permissions('Somaiya_general_admin', 'page', $this->config->item('method_for_view'), $inst_id);

        $this->load->library('spyc');
        if($id==1) {
            $this->data['page_type'] = spyc_load_file(getcwd()."/page_type.yml") ;
        }

        $this->data['institutes_details']   = $this->Somaiya_general_admin_model->get_institute_detail($id);
        $this->data['data_list']            = $this->Somaiya_general_admin_model->get_all_page_institute($id);
        $this->data['title']                = 'page';
        $this->data['page']                 = 'page';
        $this->data['content']              =$this->load->view($this->mainTemplate.'/page',$this->data,true);
        $this->load->view($this->mainTemplate, $this->data);
    }

    function editpage($id='',$contents_id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "page";
        $this->data['child_menu_type'] = "save_page";
        $this->data['sub_child_menu_type'] = "";

        $inst_id = isset($_SESSION['inst_id']) ? $_SESSION['inst_id'] : '';
        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_page_permissions($id, $per_action, $inst_id);

        $this->load->library('spyc');
        if(isset($_SESSION['inst_id']) AND $_SESSION['inst_id']!="")
        {       
            $this->data['page_type'] = spyc_load_file(getcwd()."/page_type.yml") ;          
        } else {
           $this->data['page_type'] = spyc_load_file(getcwd()."/page_type.yml") ; 
        }

        $titles = array();
        $data_titles = $this->Somaiya_general_admin_model->get_all_titles("page",$id);
        if(count($data_titles)!=0){
            foreach ($data_titles as $value) {
                $titles[$value["language_id"]] = $value;
            }
        }
        $this->data['titles']               = $titles;
        $this->data['languages']            = $this->Somaiya_general_admin_model->get_all_language();
        $this->data['gallery']              = $this->Somaiya_general_admin_model->get_all_galleryids();
        $this->data['institutes_details']   = $this->Somaiya_general_admin_model->get_institute_detail($_SESSION['inst_id']);
        $this->data['title']                = 'Page';
        $this->data['page']                 = 'Page';
        $this->data['data']                 = [];
        $this->data['page_id']              = $id;
        $this->data['data']['public']       = 1;

        if($id)
        {
            $this->data['data']    = $this->Somaiya_general_admin_model->get_page($id);

            if(empty($this->data['data']))
            {
                $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Page not found']);
                redirect(base_url().'admin/page/');
            }
        }

        if($this->input->post())
        {
            $this->data['data']     = $this->input->post();
        }

        $this->form_validation->set_rules('page_name', 'Page Name', 'required|max_length[250]');
        $this->form_validation->set_rules('public', 'Public', '');

        if($this->form_validation->run($this) === TRUE)
        { 
            if($this->input->post())
            {   
                $response = $this->Somaiya_general_admin_model->manage_page($this->input->post(), $id);
                $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
                redirect(base_url().'admin/page/'.$_SESSION['inst_id']);
            }
        }
        $this->data['content']  =$this->load->view($this->mainTemplate.'/page_edit',$this->data,true);
        $this->load->view($this->mainTemplate, $this->data);
    }
 
    function deletepage($id=0)
    {
        $inst_id = isset($_SESSION['inst_id']) ? $_SESSION['inst_id'] : '';
        validate_page_permissions($id, $this->config->item('method_for_delete'), $inst_id);

        $this->common_model->set_table('page');
        $response = $this->common_model->_delete('page_id', $id);

        $this->common_model->set_table('extensions');
        $response = $this->common_model->_delete('relation_id', $id);

        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        redirect(base_url().'admin/page/'.$_SESSION['inst_id']);
    }

    function get_pages($id='', $conditions=[], $order_by='')
    {
        $sql = 'SELECT pl.* FROM page pl WHERE 1=1';
        foreach ($conditions as $key => $value) {
            $sql .= ' AND pl.'.$key.' = "'.$value.'"';
        }
        if($id)
        {
            $sql .= ' AND pl.page_id = "'.$id.'"';
        }
        if($order_by)
        {
            $sql .= ' ORDER BY "'.$order_by.'"';
        }
        else
        {
            $sql .= ' ORDER BY pl.page_id DESC';
        }
        $result = $this->common_model->custom_query($sql);
        return $result;
    }

    function extensions($id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "page";
        $this->data['child_menu_type'] = "";
        $this->data['sub_child_menu_type'] = "";

        $pagedata = $this->get_pages($id);
        if(!empty($pagedata))
        {   
            $this->data['institutes_details']   = $this->Somaiya_general_admin_model->get_institute_detail($_SESSION['inst_id']);
            $this->data['data_list']            = $this->get_page_content($id);
            $this->data['title']                = _l("page content", $this);
            $this->data['page']                 = "extensions";
            $this->data['relation_id']          = $id;
            $this->data['content']              = $this->load->view($this->mainTemplate.'/extensions',$this->data,true);
            $this->load->view($this->mainTemplate, $this->data);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'No Page found']);
            redirect(base_url().'admin/page/');
        }
    }

    function editextension($page_id='', $contents_id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "page";
        $this->data['child_menu_type'] = "";
        $this->data['sub_child_menu_type'] = "";

        $pagedata = $this->get_pages($page_id);
        if(!empty($pagedata))
        {
            $this->data['title']                    = _l("extensions", $this);
            $this->data['page']                     = "extensions";
            $this->data['data']                     = [];
            $this->data['extension_id']             = $contents_id;
            $this->data['relation_id']              = $page_id;
            $this->data['data']['public']           = 1;
            $this->data['languages']                = $this->Somaiya_general_admin_model->get_all_language();
            $this->data['institutes_details']       = $this->Somaiya_general_admin_model->get_institute_detail($_SESSION['inst_id']);

            if($contents_id)
            {
                $pagedata = $this->get_page_content($page_id, $contents_id);
                $this->data['data'] = isset($pagedata[0]) ? $pagedata[0] : [];
                if(empty($this->data['data']))
                { 
                    $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Page content not found']);
                    redirect(base_url().'admin/extensions/'.$page_id);
                }
            }

            if($this->input->post())
            {
                $this->data['data'] = $this->input->post();
            }

            $this->form_validation->set_rules('name', 'Content Name', 'required|max_length[250]');
            $this->form_validation->set_rules('public', 'Public', '');

            if($this->form_validation->run($this) === TRUE)
            {
                if($this->input->post())
                {
                    $this->common_model->set_table('extensions');
                    if($contents_id)
                    {
                        $update['name']             = $this->input->post('name');
                        $update['language_id']      = $this->input->post('language_id');
                        $update['description']      = $this->input->post('description');
                        $update['meta_title']       = $this->input->post('meta_title');
                        $update['meta_description'] = $this->input->post('meta_description');
                        $update['meta_keywords']    = $this->input->post('meta_keywords');
                        $update['meta_image']       = $this->input->post('meta_image');
                        $update['public']           = $this->input->post('public');
                        $update['updated_date']     = date('Y-m-d H:i:s');
                        $update['user_id']          = $this->session->userdata['user_id'];

                        $response = $this->common_model->_update('extension_id', $contents_id, $update);
                         if(isset($response['status']) && $response['status'] == 'success')
                        {
                            $msg = ['error' => 0, 'message' => 'Page content successfully updated'];
                        }
                        else
                        {
                            $msg = ['error' => 0, 'message' => $response['message']];
                        }
                    }
                    else
                    {
                        $insert['name']             = $this->input->post('name');
                        $insert['description']      = $this->input->post('description');
                        $insert['relation_id']      = $page_id;
                        $insert['language_id']      = $this->input->post('language_id');
                        $insert['public']           = $this->input->post('public');
                        $insert['meta_title']       = $this->input->post('meta_title');
                        $insert['meta_description'] = $this->input->post('meta_description');
                        $insert['meta_keywords']    = $this->input->post('meta_keywords');
                        $insert['meta_image']       = $this->input->post('meta_image');
                        $insert['data_type']        = $this->input->post('data_type');
                        $insert['created_date']     = date('Y-m-d H:i:s');
                        $insert['updated_date']     = date('Y-m-d H:i:s');
                        $insert['user_id']          = $this->session->userdata['user_id'];

                        $response = $this->common_model->_insert($insert);
                        if(isset($response['status']) && $response['status'] == 'success')
                        {
                            $msg = ['error' => 0, 'message' => 'Page content successfully added'];
                        }
                        else
                        {
                            $msg = ['error' => 0, 'message' => $response['message']];
                        }
                    }
					// start add code for insert page content history
                    $page_content_history_insert['page_id']             = $page_id;
                    $page_content_history_insert['extension_id']        = $contents_id;
                    $page_content_history_insert['language_id']         = $this->input->post('language_id');
					$page_content_history_insert['type']                = 'update';
                    $page_content_history_insert['name']                = $this->input->post('name');
                    $page_content_history_insert['description']         = $this->input->post('description');
                    $page_content_history_insert['meta_title']          = $this->input->post('meta_title');
                    $page_content_history_insert['meta_description']    = $this->input->post('meta_description');
                    $page_content_history_insert['meta_keywords']       = $this->input->post('meta_keywords');
                    $page_content_history_insert['meta_image']          = $this->input->post('meta_image');
                    $page_content_history_insert['status']              = $this->input->post('public');

                    $page_content_history_insert['created_on']          = date('Y-m-d H:i:s');
                    $page_content_history_insert['created_by']          = $this->session->userdata['user_id'];
                    
                    $history_response = $this->Somaiya_general_admin_model->page_content_history_insert($page_content_history_insert);

                    if(isset($history_response['status']) && $history_response['status'] == 'success')
                    {
                        $msg = ['error' => 0, 'message' => 'Page content successfully added'];
                    }
                    else
                    {
                        $msg = ['error' => 0, 'message' => $history_response['message']];
                    }

                    // end code for insert page content history
					
                    $this->session->set_flashdata('requeststatus', $msg);
                    redirect(base_url().'admin/extensions/'.$page_id);
                }
            }
            $this->data['content']  =   $this->load->view($this->mainTemplate.'/extension_edit',$this->data,true);
            $this->load->view($this->mainTemplate, $this->data);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'No Page found']);
            redirect(base_url().'admin/page/');
        }
    }

    function get_page_content($page_id='', $contents_id='', $conditions=[], $order_by='')
    {
        $sql = 'SELECT plc.*, l.language_name FROM extensions plc join languages l ON l.language_id = plc.language_id WHERE plc.relation_id = "'.$page_id.'"';
        foreach ($conditions as $key => $value) {
            $sql .= ' AND plc.'.$key.' = "'.$value.'"';
        }
        if($contents_id)
        {
            $sql .= ' AND plc.extension_id = "'.$contents_id.'"';
        }
        if($order_by)
        {
            $sql .= ' ORDER BY "'.$order_by.'"';
        }
        else
        {
            $sql .= ' ORDER BY plc.extension_id DESC';
        }
        $result = $this->common_model->custom_query($sql);
        return $result;
    }

    function deleteextension($page_id='', $contents_id='', $language_id='')
    {   
        if($language_id != 1)
        {
            $this->common_model->set_table('extensions');
            $response = $this->common_model->_delete('extension_id', $contents_id);
            $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
            redirect(base_url().'admin/extensions/'.$page_id);
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'You can not delete default page content']);
            redirect(base_url().'admin/extensions/'.$page_id);
        }
    }

    

    /** HTML SLIDER CODE **/

    function htmlcontentslider()
    {
        $this->data['institute'] = $this->Somaiya_general_admin_model->get_all_institute();
        $this->data['data_list']=$this->Somaiya_general_admin_model->get_all_videos();
        $this->data['title'] = _l("htmlcontentslider",$this);
        $this->data['page'] = "htmlcontentslider";
        $this->data['content']=$this->load->view($this->mainTemplate.'/htmlcontentslider',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);  
    }

    function edithtmlcontentslider($id='')
    {
            if($id!='')
            {
                $this->data['data']=$this->Somaiya_general_admin_model->get_video_detail($id);
                if($this->data['data']==null)
                    redirect(base_url()."admin/htmlcontentslider");
            }
           

            $titles = array();
            $data_titles = $this->Somaiya_general_admin_model->get_all_titles("htmlcontentslider",$id);
            if(count($data_titles)!=0){
                foreach ($data_titles as $value) {
                    $titles[$value["language_id"]] = $value;
                }
            }
            $this->data['titles'] = $titles;
              $this->data['institute'] = $this->Somaiya_general_admin_model->get_all_institute();
            $this->data['languages'] = $this->Somaiya_general_admin_model->get_all_language();
            $this->data['title'] = _l("page",$this);
            $this->data['page'] = "page";
            $this->data['content']=$this->load->view($this->mainTemplate.'/htmlcontentslider_edit',$this->data,true);
            $this->load->view($this->mainTemplate,$this->data); 
    }

    function edithtmlcontentslider_options($id='')
    {
            if($id!='')
            {
                $this->data['data']=$this->Somaiya_general_admin_model->get_page_detail($id);
                if($this->data['data']==null){
                    $this->session->set_flashdata('error', _l('Your request not valid.',$this));
                    redirect(base_url()."admin/page");
                }
                $this->load->library('spyc');
                $this->data['page_type'] = spyc_load_file(getcwd()."/page_type.yml") ;

                $this->data['title'] = _l("page",$this);
                $this->data['page'] = "page";
                $this->data['content']=$this->load->view($this->mainTemplate.'/page_options',$this->data,true);
                $this->load->view($this->mainTemplate,$this->data);
            }else{
                $this->session->set_flashdata('error', _l('Your request not valid.',$this));
                redirect(base_url()."admin/page");
            }   
    }

    function htmlcontentslider_manipulate($id=null)
    {
        $this->db->trans_start();               
        $this->db->update('htmlcontentslider_management', array('featured_htmlcontentslider' => 0));
        $this->db->trans_complete();
        if ($this->Somaiya_general_admin_model->video_manipulate($_POST["data"],$id))
        {
            $this->session->set_flashdata('success', _l('Updated page',$this));
        }
        else
        {
            $this->session->set_flashdata('error', _l('Updated page error. Please try later',$this));
        }
        redirect(base_url()."admin/htmlcontentslider/");
    }

    function deletehtmlcontentslider($id=0)
    {
        if($this->Somaiya_general_admin_model->get_videos_detail($id)){
            $this->db->trans_start();               
            $this->db->delete('htmlcontentslider_management', array('htmlcontentslider_id' => $id));
            $this->db->trans_complete();
            $this->session->set_flashdata('success', _l('Deleted htmlcontentslider',$this));
        }else{
            $this->session->set_flashdata('error', _l('You should first delete galleries.',$this));
        }
        redirect(base_url()."admin/htmlcontentslider/");
    }


    /** MEDIA CODE **/

    function uploaded_images(){

        $this->data["data_list"] = $this->Somaiya_general_admin_model->get_all_images_modal();
        echo $this->load->view($this->mainTemplate.'/uploaded_images',$this->data,true);
    }

    function uploaded_images_manager()
    {
        $this->data['main_menu_type'] = "masters";
        $this->data['sub_menu_type'] = "media_files";
        $this->data['child_menu_type'] = "media_files";
        $this->data['sub_child_menu_type'] = "";

        validate_permissions('Somaiya_general_admin', 'uploaded_images_manager', $this->config->item('method_for_view'), $this->default_institute_id);

        $this->load->library('pagination');
        $this->data['page'] = "uploaded_images";
        $this->data['title'] = _l("Management uploaded images",$this);
        $config = array();
        $config['base_url'] = base_url().'admin/uploaded_images_manager';
        $config["total_rows"] = $this->Somaiya_general_admin_model->record_count();
        $config['per_page'] = 100;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = round($choice);
        $this->pagination->initialize($config);
        $page =  $this->uri->segment(3);
        $this->data["data_list"] = $this->Somaiya_general_admin_model->get_all_images($config["per_page"], $page);
        $this->data["links"] = $this->pagination->create_links();
        $this->data['content']= $this->load->view($this->mainTemplate.'/uploaded_images_manager',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function upload_image($type=null,$data_type=null,$relation_id=null,$gallery_id=null)
    {       
            if($type==null){
                echo json_encode(array("status"=>"error","errors"=>"empty"));
            }elseif($type==1){
                $folder = "logo/";
                $config['upload_path'] ='upload_file/'.$folder;
                $config['allowed_types'] = 'gif|jpg|png';
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload("file"))
                {
                    echo json_encode(array("status"=>"error","errors"=>$this->upload->display_errors('<p>', '</p>')));
                }
                else
                {
                    $data = $this->upload->data();
                    $data_image = array(
                        "image"=>$config['upload_path'].$data["file_name"],
                        "width"=>$data["image_width"],
                        "height"=>$data["image_height"],
                        "name"=>$data["file_name"],
                        "root"=>$config["upload_path"],
                        "folder"=>$folder,
                        "size"=>$data["file_size"]
                    );

                    $getid = $this->Somaiya_general_admin_model->insert_image($data_image);
                
                    if($getid!=0){
                        echo json_encode(array("status"=>"success","file_patch"=>$config['upload_path'].$data["file_name"],"file_url"=>base_url().$config['upload_path'].$data["file_name"]));
                    }else{
                        unlink(getcwd()."/".$data_image["image"]);
                        echo json_encode(array("status"=>"error","errors"=>_l("Data Set error 1!",$this)));
                    }
                }
            }elseif($type==2){
                $folder = "lang/";
                $config['upload_path'] ='upload_file/'.$folder;
                $config['allowed_types'] = 'gif|jpg|png';

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload("file"))
                {
                    echo json_encode(array("status"=>"error","errors"=>$this->upload->display_errors('<p>', '</p>')));
                }
                else
                {
                    $data = $this->upload->data();
                    $data_image = array(
                        "image"=>$config['upload_path'].$data["file_name"],
                        "width"=>$data["image_width"],
                        "height"=>$data["image_height"],
                        "name"=>$data["file_name"],
                        "root"=>$config['upload_path'],
                        "folder"=>$folder,
                        "size"=>$data["file_size"]
                    );
                    

                        $getid = $this->Somaiya_general_admin_model->insert_image($data_image);
                 
                    if($getid!=0){
                        echo json_encode(array("status"=>"success","file_patch"=>$config['upload_path'].$data["file_name"],"file_url"=>base_url().$config['upload_path'].$data["file_name"]));
                    }else{
                        unlink(getcwd()."/".$data_image["image"]);
                        echo json_encode(array("status"=>"error","errors"=>_l("Data Set error 2!",$this)));
                    }
                }
            }elseif($type=="10" && $data_type!=null && $relation_id!=null && is_numeric($relation_id) && $gallery_id!=null && is_numeric($gallery_id)){
                $accept_type = array("city","tours","page");
                if(in_array($data_type,$accept_type)){
                    $folder = "images/";
                    $config['upload_path'] ='upload_file/'.$folder;
                    $config['allowed_types'] = 'gif|jpg|png';

                    $this->load->library('upload', $config);

                    if ( ! $this->upload->do_upload("file"))
                    {
                        echo json_encode(array("status"=>"error","errors"=>$this->upload->display_errors('<p>', '</p>')));
                    }
                    else
                    {
                        $data = $this->upload->data();
                        $data_gallery = array(
                            "gallery_id"=>$gallery_id,
                            "relation_id"=>$relation_id,
                            "data_type"=>$data_type,
                            "image"=>$config['upload_path'].$data["file_name"],
                            "width"=>$data["image_width"],
                            "height"=>$data["image_height"],
                            "name"=>$data["file_name"],
                            "size"=>$data["file_size"]
                        );
                        $getid = $this->Somaiya_general_admin_model->get_insert_gallery_image($data_gallery);
                        if($getid!=0){
                            echo json_encode(array("status"=>"success","getid"=>$getid,"file_patch"=>$config['upload_path'].$data["file_name"],"file_url"=>base_url().$config['upload_path'].$data["file_name"]));
                        }else{
                            echo json_encode(array("status"=>"error","errors"=>_l("System problem!",$this)));
                        }
                    }
                }else{
                    echo json_encode(array("status"=>"error","errors"=>_l('Your request is problem!',$this)));
                }
            }elseif($type=="20"){
                $folder = "images20/";
                $config['upload_path'] ='upload_file/'.$folder;
                $config['allowed_types'] = 'gif|jpg|png';

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload("file"))
                {
                    echo json_encode(array("status"=>"error","errors"=>$this->upload->display_errors('<p>', '</p>')));
                }
                else
                {
                    $data = $this->upload->data();
                    $data_image = array(
                        "image"=>$config['upload_path'].$data["file_name"],
                        "width"=>$data["image_width"],
                        "height"=>$data["image_height"],
                        "name"=>$data["file_name"],
                        "root"=>$config["upload_path"],
                        "folder"=>$folder,
                        "size"=>$data["file_size"]
                    );
                   
                        $getid = $this->Somaiya_general_admin_model->insert_image($data_image);
                    
                    if($getid!=0){
                        echo json_encode(array("status"=>"success","file_patch"=>$config['upload_path'].$data["file_name"],"file_url"=>base_url().$config['upload_path'].$data["file_name"]));
                    }else{
                        unlink(getcwd()."/".$data_image["image"]);
                        echo json_encode(array("status"=>"error","errors"=>_l("Data Set error 10!",$this)));
                    }
                }
            }elseif($type==21){
                $folder = "speakers/";
                $config['upload_path'] ='upload_file/'.$folder;
                $config['allowed_types'] = 'gif|jpg|png';
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload("file"))
                {
                    echo json_encode(array("status"=>"error","errors"=>$this->upload->display_errors('<p>', '</p>')));
                }
                else
                {
                    $data = $this->upload->data();
                    $data_image = array(
                        "image"=>$config['upload_path'].$data["file_name"],
                        "width"=>$data["image_width"],
                        "height"=>$data["image_height"],
                        "name"=>$data["file_name"],
                        "root"=>$config["upload_path"],
                        "folder"=>$folder,
                        "size"=>$data["file_size"]
                    );

                    $getid = $this->Somaiya_general_admin_model->insert_image($data_image);
                
                    if($getid!=0){
                        echo json_encode(array("status"=>"success","file_patch"=>$config['upload_path'].$data["file_name"],"file_url"=>base_url().$config['upload_path'].$data["file_name"]));
                    }else{
                        unlink(getcwd()."/".$data_image["image"]);
                        echo json_encode(array("status"=>"error","errors"=>_l("Data Set error 1!",$this)));
                    }
                }
            }elseif($type==22){
                $folder = "public_lectures/";
                $config['upload_path'] ='upload_file/'.$folder;
                $config['allowed_types'] = 'gif|jpg|png';
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload("file"))
                {
                    echo json_encode(array("status"=>"error","errors"=>$this->upload->display_errors('<p>', '</p>')));
                }
                else
                {
                    $data = $this->upload->data();
                    $data_image = array(
                        "image"=>$config['upload_path'].$data["file_name"],
                        "width"=>$data["image_width"],
                        "height"=>$data["image_height"],
                        "name"=>$data["file_name"],
                        "root"=>$config["upload_path"],
                        "folder"=>$folder,
                        "size"=>$data["file_size"]
                    );

                    $getid = $this->Somaiya_general_admin_model->insert_image($data_image);
                
                    if($getid!=0){
                        echo json_encode(array("status"=>"success","file_patch"=>$config['upload_path'].$data["file_name"],"file_url"=>base_url().$config['upload_path'].$data["file_name"]));
                    }else{
                        unlink(getcwd()."/".$data_image["image"]);
                        echo json_encode(array("status"=>"error","errors"=>_l("Data Set error 1!",$this)));
                    }
                }
            }else{
                echo json_encode(array("status"=>"error","errors"=>_l('Cannot find url!',$this)));
            }
    }

   function delete_image($image_id) 
   {
        validate_permissions('Somaiya_general_admin', 'delete_image', $this->config->item('method_for_delete'), $this->default_institute_id);
      $this->Somaiya_general_admin_model->delete_image($image_id);
      $this->session->set_flashdata('message','Image has been deleted..');
      redirect('Somaiya_general_admin/uploaded_images_manager');
   }

    function edit_image($image_id) 
    {
        $this->data['main_menu_type'] = "masters";
        $this->data['sub_menu_type'] = "media_files";
        $this->data['child_menu_type'] = "media_files";
        $this->data['sub_child_menu_type'] = "";

        validate_permissions('Somaiya_general_admin', 'edit_image', $this->config->item('method_for_edit'), $this->default_institute_id);

        $rules =    [
                    [
                            'field' => 'data[image]',
                            'rules' => 'required'
                    ]
                    
               ];

            $this->form_validation->set_rules($rules);
            $this->data['page'] = "edit_image";
            $this->data["data_list"] = $this->Somaiya_general_admin_model->get_image($image_id);

      if ($this->form_validation->run() == FALSE)
      {
        $this->data['content']= $this->load->view($this->mainTemplate.'/edit_image',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);

      }
      else
      {
         if(isset($_FILES["data[image]"]['name']))
         {
            /* Start Uploading File */
            $config =   [
                          'upload_path'   => './upload_file/',
                           'allowed_types' => 'gif|jpg|png',
                           'max_size'      => 1000,
                           'max_width'     => 1024,
                           'max_height'    => 768
                        ];

               $this->load->library('upload', $config);

               if ( ! $this->upload->do_upload())
               {
                        $this->data['page'] = "edit_image";

                $error = array('error' => $this->upload->display_errors());
                $this->data['content']= $this->load->view($this->mainTemplate.'/edit_image',$this->data,true);
                $this->load->view($this->mainTemplate,$this->data);
               }
               else
               {
                       $file = $this->upload->data();
                       $data['file'] = 'upload_file/' . $file['file_name'];
                       
               }
         }
                $data['name']   = set_value('name');
                $data['image']   = set_value('image');
                 $data['image_id']   = set_value('image_id');
         
         $this->Somaiya_general_admin_model->update_image($image_id,$data);
         $this->session->set_flashdata('message','New image has been updated..');
         redirect('admin/uploaded_images_manager/');
      }
   }


    /** VIEW PROFILE CODE **/

    function viewprofile()
    {
        $this->data['data_list']=$this->Somaiya_general_admin_model->get_view_user($user_id);
        $this->data['title'] = _l("View Profile",$this);
        $this->data['page'] = "viewprofile";
        $this->data['content']=$this->load->view($this->mainTemplate.'/viewprofile',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }



    /** PROGRAMS & DETAILS CODE **/

    function program($id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "programs";
        $this->data['child_menu_type'] = "programs";
        $this->data['sub_child_menu_type'] = "";

        $inst_id = $id ? $id : $this->default_institute_id;
        validate_permissions('Somaiya_general_admin', 'program', $this->config->item('method_for_view'), $inst_id);

        if($id=='') {
            $id=0;
        }

        $this->data['data_list']=$this->Somaiya_general_admin_model->get_all_program_inst($id);
        //echo "<pre>"; print_r($this->data['data_list']);exit();
        $this->data['institutes_details'] = $this->Somaiya_general_admin_model->get_institute_detail($_SESSION['inst_id']);
        $this->data['title'] = _l("program",$this);
        $this->data['page'] = "program";
        $this->data['content']=$this->load->view($this->mainTemplate.'/program',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);  
    }


    function view_program_institute()
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "programs";
        $this->data['child_menu_type'] = "";
        $this->data['sub_child_menu_type'] = "";

        $inst_id = $this->default_institute_id;
        validate_permissions('Somaiya_general_admin', 'program', $this->config->item('method_for_view'), $inst_id);

        $this->data['page'] = "Programmes";
        $this->data['institutes_list_program'] = $this->Somaiya_general_admin_model->get_all_institute_program();
        $this->data['content']= $this->load->view($this->mainTemplate.'/view_program_institute',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }


    /* PROGRAMS & DETAILS CONTENT CODE */

    function programcontents($data_type=null,$relation_id=null)
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "programs";
        $this->data['child_menu_type'] = "programs";
        $this->data['sub_child_menu_type'] = "";

        $inst_id = isset($_SESSION['inst_id']) ? $_SESSION['inst_id'] : $this->default_institute_id;
        validate_permissions('Somaiya_general_admin', 'program', $this->config->item('method_for_view'), $inst_id);

        if($data_type!=null && $relation_id!=null && is_numeric($relation_id)){
            $accept_type = array("program");
            if(!in_array($data_type,$accept_type)){
                $this->session->set_flashdata('error', _l('Your request is problem!',$this));
                redirect(base_url()."admin/gallery");
            }
            $this->data['data_list']=$this->Somaiya_general_admin_model->get_all_programcontents($data_type,$relation_id);
            $this->data['institutes_details'] = $this->Somaiya_general_admin_model->get_institute_detail($_SESSION['inst_id']);
            if($data_type=="program"){
                $data = $this->Somaiya_general_admin_model->get_program_detail($relation_id);
                $add_on_title = $data["COURSE_NAME"];
            }
        }else{
            $this->data['data_list']=$this->Somaiya_general_admin_model->get_all_programcontents();
            $this->data['institutes_details'] = $this->Somaiya_general_admin_model->get_institute_detail($_SESSION['inst_id']);
            $add_on_title = "";
        }
        if($data_type!=null) $this->data['data_type'] = $data_type;
        if($relation_id!=null) $this->data['relation_id'] = $relation_id;
        $this->data['title'] = $add_on_title;
        $this->data['page'] = "programcontents";
        $this->data['content']=$this->load->view($this->mainTemplate.'/programcontents',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function editprogramcontents($id=0,$data_type=null,$relation_id=null)
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "programs";
        $this->data['child_menu_type'] = "programs";
        $this->data['sub_child_menu_type'] = "";

        $inst_id = isset($_SESSION['inst_id']) ? $_SESSION['inst_id'] : '';

        if($id!=0)
        {
            $this->data['data']=$this->Somaiya_general_admin_model->get_programcontents_detail($id);
            if($this->data['data']==null)
                redirect(base_url()."admin/programcontents");
            if(isset($this->data['data']['contents_more'])) { $this->data['data']['contents_more'] = spyc_load($this->data['data']['contents_more']); }
            if(isset($this->data['data']["data_type"]) && $this->data['data']["data_type"]!="") $data_type = $this->data['data_type'] = $this->data['data']["data_type"];
            if(isset($this->data['data']["relation_id"]) && $this->data['data']["relation_id"]!=0) $relation_id = $this->data['relation_id'] = $this->data['data']["relation_id"];
        }elseif($data_type==null || $relation_id==null){
            $this->session->set_flashdata('error', _l('Your request is not valid.',$this));
            redirect(base_url()."admin/programcontents/");
        }else{
            if($data_type!=null) $this->data['data_type'] = $data_type;
            if($relation_id!=null) $this->data['relation_id'] = $relation_id;
        }
        $this->load->library('spyc');
        if($data_type=="program" && $relation_id!=null){
            $page = $this->Somaiya_general_admin_model->get_program_detail($relation_id);
        }else{
            $this->data['fields'] = array("icon","image","description","full_description");
        }
        $icons = spyc_load_file(getcwd()."/icons.yml");
        $this->data['faicons'] = $icons["fa"];
        $this->data['program_name']     = $this->Somaiya_general_admin_model->get_program_name($relation_id);
        $this->data['lang_name']        = $this->Somaiya_general_admin_model->get_language_name($id);
        $this->data['languages']        = $this->Somaiya_general_admin_model->get_all_language();
        $this->data['widgetvalue']      = $this->Somaiya_general_admin_model->get_all_widget($id);
        $this->data['courseshortcode']  = $this->Somaiya_general_admin_model->get_programcontents_courseshortcode($id);
        $this->data['title']            = _l("contents",$this);
        $this->data['page']             = "programcontents";
        $this->data['content']          = $this->load->view($this->mainTemplate.'/programcontents_edit',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function programcontents_manipulate($id=null)
    {   //echo "<pre>"; print_r($_POST);exit();
            if($this->Somaiya_general_admin_model->programcontents_manipulate($_POST, $id))
            {
                $this->session->set_flashdata('success', _l('Updated contents',$this));
            }
            else
            {
                $this->session->set_flashdata('error', _l('Updated contents error. Please try later',$this));
            }
            redirect(base_url()."admin/programcontents/".(isset($_POST["data_type"])?$_POST["data_type"]."/":"").(isset($_POST["data_type"])?$_POST["relation_id"]."/":""));
    }

    function deleteprogramcontents($id=0,$data_type=null,$relation_id=null)
    {
        $inst_id = isset($_SESSION['inst_id']) ? $_SESSION['inst_id'] : '';

        $this->db->trans_start();
        $this->db->delete('program_contents', array('contents_id' => $id));
        $this->db->trans_complete();
        $this->session->set_flashdata('success', _l('Deleted contents',$this));
        redirect(base_url()."admin/programcontents/".($data_type!=null?$data_type."/":"").($relation_id!=null?$relation_id."/":""));
    }

    function deletewidgets(){
        $deleteid  = $this->input->post('image_id');
        $this->db->delete('program_widgets', array('p_id' => $deleteid));
        $verify = $this->db->affected_rows();
        echo $verify;
    }

    function deletespecializationwidgets(){
        $deleteid  = $this->input->post('image_id');
        $this->db->delete('program_specialization_widgets', array('p_id' => $deleteid));
        $verify = $this->db->affected_rows();
        echo $verify;
    }


    /* PROGRAMS & DETAILS CONTENT CODE SPECIALIZATION*/

    function programspecialization($data_type=null,$relation_id=null)
    {
        $inst_id = isset($_SESSION['inst_id']) ? $_SESSION['inst_id'] : $this->default_institute_id;
        validate_permissions('Somaiya_general_admin', 'program', $this->config->item('method_for_view'), $inst_id);

        if($data_type!=null && $relation_id!=null && is_numeric($relation_id)){
            $accept_type = array("program");
            if(!in_array($data_type,$accept_type)){
                $this->session->set_flashdata('error', _l('Your request is problem!',$this));
                redirect(base_url()."admin/gallery");
            }
            $this->data['data_list']=$this->Somaiya_general_admin_model->get_all_programspecialization($data_type,$relation_id);
            $this->data['institutes_details'] = $this->Somaiya_general_admin_model->get_institute_detail($_SESSION['inst_id']);
            if($data_type=="program"){
                $data = $this->Somaiya_general_admin_model->get_program_detail($relation_id);
                $add_on_title = $data["COURSE_NAME"];
            }
        }else{
            $this->data['data_list']=$this->Somaiya_general_admin_model->get_all_programspecialization();
            $this->data['institutes_details'] = $this->Somaiya_general_admin_model->get_institute_detail($_SESSION['inst_id']);
            $add_on_title = "";
        }
        if($data_type!=null) $this->data['data_type'] = $data_type;
        if($relation_id!=null) $this->data['relation_id'] = $relation_id;
        $this->data['title'] = $add_on_title;
        $this->data['page'] = "programspecialization";
        $this->data['content']=$this->load->view($this->mainTemplate.'/programspecialization',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function editprogramspecialization($id=0,$data_type=null,$relation_id=null)
    {
        $inst_id = isset($_SESSION['inst_id']) ? $_SESSION['inst_id'] : '';

        if($id!=0)
        {
            $this->data['data']=$this->Somaiya_general_admin_model->get_programspecialization_detail($id);
            if($this->data['data']==null)
                redirect(base_url()."admin/programspecialization");
            if(isset($this->data['data']['contents_more'])) { $this->data['data']['contents_more'] = spyc_load($this->data['data']['contents_more']); }
            if(isset($this->data['data']["data_type"]) && $this->data['data']["data_type"]!="") $data_type = $this->data['data_type'] = $this->data['data']["data_type"];
            if(isset($this->data['data']["relation_id"]) && $this->data['data']["relation_id"]!=0) $relation_id = $this->data['relation_id'] = $this->data['data']["relation_id"];
        }elseif($data_type==null || $relation_id==null){
            $this->session->set_flashdata('error', _l('Your request is not valid.',$this));
            redirect(base_url()."admin/programspecialization/");
        }else{
            if($data_type!=null) $this->data['data_type'] = $data_type;
            if($relation_id!=null) $this->data['relation_id'] = $relation_id;
        }
        $this->load->library('spyc');
        if($data_type=="program" && $relation_id!=null){
            $page = $this->Somaiya_general_admin_model->get_program_detail($relation_id);
        }else{
            $this->data['fields'] = array("icon","image","description","full_description");
        }
        $icons = spyc_load_file(getcwd()."/icons.yml");
        $this->data['faicons'] = $icons["fa"];
        $this->data['languages'] = $this->Somaiya_general_admin_model->get_all_language();
        $this->data['widgetvalue'] = $this->Somaiya_general_admin_model->get_all_widget($id);
        $this->data['courseshortcode'] = $this->Somaiya_general_admin_model->get_programspecialization_courseshortcode($id);
        $this->data['title'] = _l("contents",$this);
        $this->data['page'] = "programspecialization";
        $this->data['content']=$this->load->view($this->mainTemplate.'/programspecialization_edit',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function programspecialization_manipulate($id=null)
    {
            // if(isset($_POST["data"]["contents_more"])){
            //     $_POST["data"]["contents_more"] = Spyc::YAMLDump($_POST["data"]["contents_more"]);
            // }
            // $_POST["data"]['publish'] = isset($_POST["publish"]) ? $_POST["publish"] : [];
            // if ($this->Somaiya_general_admin_model->programspecialization_manipulate($_POST["data"],$id))
            // {
            //     $this->session->set_flashdata('success', _l('Updated contents',$this));
            // }
            // else
            // {
            //     $this->session->set_flashdata('error', _l('Updated contents error. Please try later',$this));
            // }
            // redirect(base_url()."admin/programspecialization/".(isset($_POST["data"]["data_type"])?$_POST["data"]["data_type"]."/":"").(isset($_POST["data"]["data_type"])?$_POST["data"]["relation_id"]."/":""));

        if($this->Somaiya_general_admin_model->programspecialization_manipulate($_POST, $id))
            {
                $this->session->set_flashdata('success', _l('Updated contents',$this));
            }
            else
            {
                $this->session->set_flashdata('error', _l('Updated contents error. Please try later',$this));
            }
            redirect(base_url()."admin/programspecialization/".(isset($_POST["data_type"])?$_POST["data_type"]."/":"").(isset($_POST["data_type"])?$_POST["relation_id"]."/":""));
    }

    function deleteprogramspecialization($id=0,$data_type=null,$relation_id=null)
    {
        $inst_id = isset($_SESSION['inst_id']) ? $_SESSION['inst_id'] : '';

        $this->db->trans_start();
        $this->db->delete('program_specialization', array('contents_id' => $id));
        $this->db->trans_complete();
        $this->session->set_flashdata('success', _l('Deleted contents',$this));
        redirect(base_url()."admin/programspecialization/".($data_type!=null?$data_type."/":"").($relation_id!=null?$relation_id."/":""));
    }


    function save_specialization()
    {   
        $checkvalue = $_GET["checked"];
        $relatedvalue = $_GET["msgId"];
        $query=$this->db->query("UPDATE edu_map_course_head SET Specialization_parent = '".$checkvalue."' where MAP_COURSE_ID = '".$relatedvalue."'");
        echo 'Post Order has been updated';//exit();
    }
    

    function ajax_check_url()
    {
        if($this->input->post())
        { 
            $result = $this->custom_unique_url($this->input->post('url'), '');
            echo $result;exit;
        }
    }

    public function custom_unique_url($str, $func)
    {
        $this->form_validation->set_message('custom_unique_url', "URL already exist");

        $result = TRUE;
        if(!empty($str))
        {
            $sql = 'SELECT * FROM program_specialization WHERE url="'.$str.'"';
            if(isset($_POST['contents_id']) && !empty($_POST['contents_id']))
            {
                $sql .= ' AND contents_id != "'.$_POST['contents_id'].'"';
            }
            $result = $this->common_model->custom_query($sql);

            if(isset($result[0]) && !empty($result[0]))
            {
                $result = FALSE;
            }
            else
            {
                $result = TRUE;
            }
        }
        return $result;
    }


    function ajax_check_program_url()
    {
        if($this->input->post())
        { 
            $result = $this->custom_program_url($this->input->post('url'), '');
            echo $result;exit;
        }
    }


    public function custom_program_url($str, $func)
    {
        $this->form_validation->set_message('custom_program_url', "URL already exist");

        $result = TRUE;
        if(!empty($str))
        {
            $sql = 'SELECT * FROM program_contents WHERE url="'.$str.'"';
            if(isset($_POST['contents_id']) && !empty($_POST['contents_id']))
            {
                $sql .= ' AND contents_id != "'.$_POST['contents_id'].'"';
            }
            if(isset($_POST['relation_id']) && !empty($_POST['relation_id']))
            {
                $sql .= ' AND relation_id != "'.$_POST['relation_id'].'"';
            }
            $result = $this->common_model->custom_query($sql);

            if(isset($result[0]) && !empty($result[0]))
            {
                $result = FALSE;
            }
            else
            {
                $result = TRUE;
            }
        }
        return $result;
    }
    

    function ajax_check_common_language()
    { 
        if($this->input->post())
        {
            $result = $this->unique_common_language();
            echo $result;exit;
        }
    }

    function unique_common_language()
    {   
        $contents_id                = isset($_POST['contents_id']) ? $_POST['contents_id'] : '';
        $relation_id                = isset($_POST['relation_id']) ? $_POST['relation_id'] : '';
        $language_id                = isset($_POST['language_id']) ? $_POST['language_id'] : '';
        $formname                   = isset($_POST['formname']) ? $_POST['formname'] : '';
        $errormessage               = 'Content for this language is already exist.';
        $this->form_validation->set_message('unique_common_language', $errormessage);

        if(empty($contents_id) and !empty($relation_id) and $formname == 'events')
        {
            $content = $this->common_model->custom_query('Select * FROM eventcontents WHERE language_id = "'.$language_id.'" AND relation_id = "'.$relation_id.'" AND contents_id != "'.$contents_id.'"');
        }

        else if(empty($contents_id) and !empty($relation_id) and $formname == 'announcement')
        {
            $content = $this->common_model->custom_query('Select * FROM contentsannouncement WHERE language_id = "'.$language_id.'" AND relation_id = "'.$relation_id.'" AND contents_id != "'.$contents_id.'"');
        }

        else if(empty($contents_id) and !empty($relation_id) and $formname == 'pressrelease')
        {
            $content = $this->common_model->custom_query('Select * FROM contentspressrelease WHERE language_id = "'.$language_id.'" AND relation_id = "'.$relation_id.'" AND contents_id != "'.$contents_id.'"');
        }

        else if(empty($contents_id) and !empty($relation_id) and $formname == 'mediacoverage')
        {
            $content = $this->common_model->custom_query('Select * FROM contentsmediacoverage WHERE language_id = "'.$language_id.'" AND relation_id = "'.$relation_id.'" AND contents_id != "'.$contents_id.'"');
        }

        else if(empty($contents_id) and !empty($relation_id) and $formname == 'programme')
        {
            $content = $this->common_model->custom_query('Select * FROM program_contents WHERE language_id = "'.$language_id.'" AND relation_id = "'.$relation_id.'" AND contents_id != "'.$contents_id.'"');
        }

        else if(empty($contents_id) and !empty($relation_id) and $formname == 'programme_specialization')
        {
            $content = $this->common_model->custom_query('Select * FROM program_specialization WHERE language_id = "'.$language_id.'" AND relation_id = "'.$relation_id.'" AND contents_id != "'.$contents_id.'"');
        }
        
        else if(empty($contents_id) and !empty($relation_id) and $formname == 'page')
        {
            $content = $this->common_model->custom_query('Select * FROM extensions WHERE language_id = "'.$language_id.'" AND relation_id = "'.$relation_id.'" AND extension_id != "'.$contents_id.'"');
        }

        else if(empty($contents_id) and !empty($relation_id) and $formname == 'post')
        {
            $content = $this->common_model->custom_query('Select * FROM contents WHERE language_id = "'.$language_id.'" AND relation_id = "'.$relation_id.'" AND contents_id != "'.$contents_id.'"');
        }

        else if(empty($contents_id) and !empty($relation_id) and $formname == 'donation')
        {
            $content = $this->common_model->custom_query('Select * FROM contentsdonation WHERE language_id = "'.$language_id.'" AND relation_id = "'.$relation_id.'" AND contents_id != "'.$contents_id.'"');
        }

        if(isset($content[0]) && !empty($content[0]))
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }


    /* PROGRAMS & DETAILS URL CODE */

    function program_url()
    {
        $this->data['data_list']=$this->Somaiya_general_admin_model->get_all_program_url();
        $this->data['title'] = _l("program",$this);
        $this->data['page'] = "program";
        $this->data['content']=$this->load->view($this->mainTemplate.'/program_url',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }


    function ajax_check_pro_url()
    {
        if($this->input->post())
        { 
            $result = $this->custom_pro_url($this->input->post('url'), '');
            echo $result;exit;
        }
    }


    public function custom_pro_url($str, $func)
    {
        $this->form_validation->set_message('custom_pro_url', "URL already exist");

        $result = TRUE;
        if(!empty($str))
        {
            $sql = 'SELECT * FROM program_contents WHERE url="'.$str.'"';
            // if(isset($_POST['contents_id']) && !empty($_POST['contents_id']))
            // {
            //     $sql .= ' AND relation_id != "'.$_POST['relation_id'].'"';
            // }
            $result = $this->common_model->custom_query($sql);

            if(isset($result[0]) && !empty($result[0]))
            {
                $result = FALSE;
            }
            else
            {
                $result = TRUE;
            }
        }
        return $result;
    }

    function program_url_manipulate($id=null)
    {
        $url = $this->input->post('url');
        $relation_id = $this->input->post('map_course_id');
        $contents_id = $this->input->post('contents_id');
        if(empty($contents_id)) 
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Page Content is empty']);
            redirect(base_url().'admin/program_url');
        } else 
        {   
            for($i=0; $i<count($url); $i++)
            { 
                $query=$this->db->query("UPDATE program_contents SET url = '".$url."' where relation_id = '".$relation_id."'");
            }
            $this->session->set_flashdata('requeststatus', ['error' => 0, 'message' => 'Updated']);
            redirect(base_url()."admin/program_url");
        }
    }


    function program_specialurl_manipulate($id=null)
    {
        $url = $this->input->post('specialurl');
        $relation_id = $this->input->post('map_course_id_special');
        $contents_id = $this->input->post('contents_id_special');
        if(empty($contents_id)) 
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Page Content is empty']);
            redirect(base_url().'admin/program_url');
        } else 
        {   
            for($i=0; $i<count($url); $i++)
            { 
                $query=$this->db->query("UPDATE program_specialization SET url = '".$url."' where contents_id = '".$contents_id."'");
            }
            $this->session->set_flashdata('requeststatus', ['error' => 0, 'message' => 'Updated']);
            redirect(base_url()."admin/program_url");
        }
    }
    
    
    function user_enquiry_program($id='')
    {
        $this->data['main_menu_type'] = "masters";
        $this->data['sub_menu_type'] = "user_enquiry_program";
        $this->data['child_menu_type'] = "user_enquiry_program";
        $this->data['sub_child_menu_type'] = "";

        $inst_id = $id ? $id : $this->default_institute_id;
        validate_permissions('Somaiya_general_admin', 'user_enquiry_program', $this->config->item('method_for_view'), $inst_id);

        $this->data['data_list']=$this->Somaiya_general_admin_model->get_all_user_enquiry_program();
        $this->data['title'] = _l("user_enquiry_program",$this);
        $this->data['page'] = "user_enquiry_program";
        $this->data['content']=$this->load->view($this->mainTemplate.'/user_enquiry_program',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);  
    }

    function save_programme_order()
    {   
        $programme_id = $_POST["programme_id_array"];
        
        $i=1;
        foreach($programme_id as $k=>$v){
            $query=$this->db->query("UPDATE program_widgets SET widget_order = '".$i."' where p_id = '".$v."'");


            $i++;
        }

        echo 'Programme Order has been updated';
    }

    function save_projectimg_order()
    {   
        $programme_id = $_POST["programme_id_array"];

        $i=1;
        foreach($programme_id as $k=>$v){
            $query=$this->db->query("UPDATE area_banner_images SET area_order = '".$i."' where id = '".$v."' and type = 'project_banner_images' ");


            $i++;
        }

        echo 'Project Banner has been updated';
    }



    /* Programme Specialization new */


    function programspecializationlang($data_type=null,$relation_id=null)
    {   
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "programs";
        $this->data['child_menu_type'] = "programs";
        $this->data['sub_child_menu_type'] = "";

        $inst_id = isset($_SESSION['inst_id']) ? $_SESSION['inst_id'] : $this->default_institute_id;
        validate_permissions('Somaiya_general_admin', 'program', $this->config->item('method_for_view'), $inst_id);

        if($data_type!=null && $relation_id!=null && is_numeric($relation_id)){
            $accept_type = array("program");
            if(!in_array($data_type,$accept_type)){
                $this->session->set_flashdata('error', _l('Your request is problem!',$this));
                redirect(base_url()."admin/gallery");
            }
            $this->data['data_list']=$this->Somaiya_general_admin_model->get_all_programspecializationlang($data_type,$relation_id);
            $this->data['institutes_details'] = $this->Somaiya_general_admin_model->get_institute_detail($_SESSION['inst_id']);
            if($data_type=="program"){
                $data = $this->Somaiya_general_admin_model->get_programspecializationlang_detail($relation_id);
                $add_on_title = $data["name"];
            }
        }else{
            $this->data['data_list']=$this->Somaiya_general_admin_model->get_all_programspecializationlang();
            $this->data['institutes_details'] = $this->Somaiya_general_admin_model->get_institute_detail($_SESSION['inst_id']);
            $add_on_title = "";
        }
        if($data_type!=null) $this->data['data_type'] = $data_type;
        if($relation_id!=null) $this->data['relation_id'] = $relation_id;
        $this->data['title'] = $add_on_title;
        $this->data['page'] = "programspecializationlang";
        $this->data['content']=$this->load->view($this->mainTemplate.'/programspecializationlang',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function editprogramspecializationlang($id=0,$data_type=null,$relation_id=null)
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "programs";
        $this->data['child_menu_type'] = "programs";
        $this->data['sub_child_menu_type'] = "";

        $inst_id = isset($_SESSION['inst_id']) ? $_SESSION['inst_id'] : '';

        if($id!=0)
        {
            $this->data['data']=$this->Somaiya_general_admin_model->get_programspecializationlang_detail($id);
            //echo "<pre>"; print_r($this->data['data']);exit();
            if($this->data['data']==null)
                redirect(base_url()."admin/programspecializationlang");
            if(isset($this->data['data']['contents_more'])) { $this->data['data']['contents_more'] = spyc_load($this->data['data']['contents_more']); }
            if(isset($this->data['data']["data_type"]) && $this->data['data']["data_type"]!="") $data_type = $this->data['data_type'] = $this->data['data']["data_type"];
            if(isset($this->data['data']["relation_id"]) && $this->data['data']["relation_id"]!=0) $relation_id = $this->data['relation_id'] = $this->data['data']["relation_id"];
        }elseif($data_type==null || $relation_id==null){
            $this->session->set_flashdata('error', _l('Your request is not valid.',$this));
            redirect(base_url()."admin/programspecializationlang/");
        }else{
            if($data_type!=null) $this->data['data_type'] = $data_type;
            if($relation_id!=null) $this->data['relation_id'] = $relation_id;
            $this->data['course_name']=$this->Somaiya_general_admin_model->get_programspecializationlang_detail_course($relation_id);
            //echo "<pre>"; print_r($this->data['course_name']);exit();
        }
        $this->load->library('spyc');
        if($data_type=="program" && $relation_id!=null){
            $page = $this->Somaiya_general_admin_model->get_programspecializationlang_detail($relation_id);
        }else{
            $this->data['fields'] = array("icon","image","description","full_description");
        }
        $icons = spyc_load_file(getcwd()."/icons.yml");
        $this->data['faicons']          = $icons["fa"];
        $this->data['lang_name']        = $this->Somaiya_general_admin_model->get_language_name_specialization($id);
        $this->data['languages']        = $this->Somaiya_general_admin_model->get_all_language();
        $this->data['widgetvalue']      = $this->Somaiya_general_admin_model->get_all_specialization_widget($id);
        $this->data['title']            = _l("contents",$this);
        $this->data['page']             = "programspecializationlang";
        $this->data['content']          = $this->load->view($this->mainTemplate.'/programspecializationlang_edit',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function programspecializationlang_manipulate($id=null)
    {   

        if($this->Somaiya_general_admin_model->programspecializationlang_manipulate($_POST, $id))
            {
                $this->session->set_flashdata('success', _l('Updated contents',$this));
            }
            else
            {
                $this->session->set_flashdata('error', _l('Updated contents error. Please try later',$this));
            }
            redirect(base_url()."admin/programspecializationlang/".(isset($_POST["data_type"])?$_POST["data_type"]."/":"").(isset($_POST["data_type"])?$_POST["relation_id"]."/":""));
    }

    function deleteprogramspecializationlang($id=0,$data_type=null,$relation_id=null)
    {
        $inst_id = isset($_SESSION['inst_id']) ? $_SESSION['inst_id'] : '';

        $this->db->trans_start();
        $this->db->delete('program_specialization', array('contents_id' => $id));
        $this->db->trans_complete();
        $this->session->set_flashdata('success', _l('Deleted contents',$this));
        redirect(base_url()."admin/programspecializationlang/".($data_type!=null?$data_type."/":"").($relation_id!=null?$relation_id."/":""));
    }

    function keywords()
    {
        $this->data['data_keywords']=$this->Somaiya_general_admin_model->get_all_keywords();
        $this->data['title'] = _l("Keywords",$this);
        $this->data['page'] = "Keywords";
        $this->data['content']=$this->load->view($this->mainTemplate.'/keywords',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);  
    }

    function deletekeywords($id=0)
    {
        $this->db->trans_start();
        $this->db->delete('keyword_search_count', array('id' => $id));
        $this->db->trans_complete();
        $this->session->set_flashdata('success', _l('Deleted Group',$this));
        redirect(base_url()."admin/keywords/");
    }


    function get_keywords_list($id='', $conditions=[], $order_by='')
    {
        $sql = 'SELECT * FROM keyword_search_count WHERE (1=1) ';
        
        foreach ($conditions as $key => $value) {
            $sql .= ' AND '.$key.' = "'.$value.'"';
        }
        if($id)
        {
            $sql .= ' AND id = "'.$id.'"';
        }
        if($order_by)
        {
            $sql .= ' ORDER BY "'.$order_by.'"';
        }
        else
        {
            $sql .= ' ORDER BY id DESC';
        }
        $result = $this->Somaiya_general_admin_model->keywords_query($sql);
        return $result;
    }

    function export_keywords()
    {
        // $inst_id = $this->default_institute_id;
        // validate_permissions('Somaiya_general_admin', 'export_keywords', $this->config->item('method_for_export'), $inst_id); 

        $email_list = $this->get_keywords_list();
        if(!empty($email_list))
        {
            $this->load->library("excel");
            $object = new PHPExcel();
            $object->setActiveSheetIndex(0);
            $table_columns = array("Keyword", "Page", "URL", "Counter");
            $column = 0;

            foreach($table_columns as $field)
            {
                $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                $column++;
            }

            $excel_row = 2;

            foreach($email_list as $row)
            {
                $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['keyword']);
                $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['page']);
                $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['url']);
                $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row['counter']);
                $excel_row++;
            }

            // $fileName = time() . '.xls';
            $fileName = 'Keywords' . '.xls';
            $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$fileName.'"');
            $object_writer->save('php://output');
        }
        else
        {
            $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'No record found.']);
            redirect(base_url()."keywords/");
        }
    }

    // start user module changes code
    function get_user_groups()
    {
        $options        = '<option value="">-- Select User Groups --</option>';
        $group_list  = $this->Somaiya_general_admin_model->get_all_groups();

            if(!empty($group_list))
            {
                foreach ($group_list as $key => $value) {
                    $selected           = '';
                    // if($value['group_id'] == $group_id)
                    // {
                    //     $selected       = 'selected="selected"';
                    // }
                    $options            .= '<option value="'.$value['group_id'].'" '.$selected.'>'.$value['group_name'].'</option>';
                }
            }

            echo json_encode($options);exit;

    }

    function get_user_institute_options()
    {
        $options        = '<option value="">-- Select Institute --</option>';
        $institute_list  = $this->Somaiya_general_admin_model->get_all_institutes();

            if(!empty($institute_list))
            {
                foreach ($institute_list as $key => $value) {
                    $selected           = '';
                    // if($value['group_id'] == $group_id)
                    // {
                    //     $selected       = 'selected="selected"';
                    // }
                    $options            .= '<option value="'.$value['INST_ID'].'" '.$selected.'>'.$value['INST_NAME'].'</option>';
                }
            }

            echo json_encode($options);exit;

    }

    function get_all_username_options()
    {
        $options        = '<option value="">-- Select Username --</option>';
        $username_list  = $this->Somaiya_general_admin_model->get_all_username_options();

            if(!empty($username_list))
            {
                foreach ($username_list as $key => $value) {
                    $selected           = '';
                    $options            .= '<option value="'.$value['username'].'" '.$selected.'>'.$value['username'].'</option>';
                }
            }

            echo json_encode($options);exit;

    }

    function get_all_user_fullname_options()
    {
        $options        = '<option value="">-- Select User Fullname --</option>';
        $user_fullname_list  = $this->Somaiya_general_admin_model->get_all_user_fullname_options();

            if(!empty($user_fullname_list))
            {
                foreach ($user_fullname_list as $key => $value) {
                    $selected           = '';
                    $options            .= '<option value="'.$value['fullname'].'" '.$selected.'>'.$value['fullname'].'</option>';
                }
            }

            echo json_encode($options);exit;

    }

    function get_all_user_email_options()
    {
        $options        = '<option value="">-- Select User Email --</option>';
        $user_email_list  = $this->Somaiya_general_admin_model->get_all_user_email_options();

            if(!empty($user_email_list))
            {
                foreach ($user_email_list as $key => $value) {
                    $selected           = '';
                    $options            .= '<option value="'.$value['email'].'" '.$selected.'>'.$value['email'].'</option>';
                }
            }

            echo json_encode($options);exit;

    }

    function user_ajax_list()
    {
            if($this->session->userdata('user_id') == 1)
            {
                $condition      = ['u.status !' => '-1'];
            }
            else
            {
                //$condition      = ['u.status !' => '-1', 'u.created_by' => $this->session->userdata('user_id')]; // hide this because user table 'created_by' column missing. 
                $condition      = ['u.status !' => '-1'];
            }
            
            $list               = $this->Somaiya_general_admin_model->get_users_data($condition, '', '', '');
            $tabledata          = [];
            $no                 = isset($_GET['offset']) ? $_GET['offset'] : 0;
            //echo "<pre>";print_r($list);exit;

            foreach ($list as $key => $value) {

                if($value->status == 1)
                {
                    $status     = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$value->user_id.', 0);"><div class="label label-default label-form wd-100-px background-green">Active</div></a>';
                }
                else if($value->status == 0)
                {
                    $status     = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$value->user_id.', 1);"><div class="label label-default label-form wd-100-px background-red">In-Active</div></a>';
                }

                if(isset($value->permission))
                {
                    $permission = explode("|", $value->permission);

                    $user_permission_link = '';
                    foreach ($permission as $permi_key => $permi_value) {
                        $group_permission = explode(":", $permi_value);
                        $user_permission_link .= '<a class="text-black" href="'.base_url().'permissions/edit_permissions/'.$group_permission[1].'" target="_blank"><div class="label label-default label-form wd-100-px background-red">'.$group_permission[0].'</div></a><br>';
                    }
                }
                else
                {
                    $user_permission_link = '';
                }

                $send_credential_to_user = '<a class="text-black" href="javascript:void(0);" onclick="send_credential_to_user('.$value->user_id.');"><div class="label label-default label-form wd-100-px background-red">Send Credential</div></a>';

                $no++;
                $row                                            = [];
                $row['sr_no']                                   = $no;
                $row['user_id']                                 = $value->user_id;
                $row['fullname']                                = $value->fullname;
                $row['email']                                   = $value->email;
                $row['username']                                = $value->username;
                $row['status']                                  = $status;
                $row['permission']                              = $user_permission_link;
                $row['send_credential_to_user']                 = $send_credential_to_user;
                $institute_name                                 = $value->INST_NAME;
                $group_name                                     = '';
                $login_type                                     = '';


                if(!empty($value->group_name))
                {
                    $group_name                             = isset($value->group_name) ? $value->group_name : '';
                }
                if(!empty($value->login_type))
                {
                    if($value->login_type == 1)
                    {
                        $login_type = 'CMS';
                    }
                    elseif ($value->login_type == 2) {
                        $login_type = 'Email';
                    }
                    else
                    {
                        $login_type = 'NA';
                    }
                }
                
                $row['group_name']                      = $group_name;
                $row['login_type']                      = $login_type;
                $row['institute_name']                  = $institute_name;

                $edit                                           = '<a data-toggle="tooltip" class="btn btn-sm btn-primary m-r-5" href="'.base_url().'admin/edituser/'.$value->user_id.'" title="Edit"><i class="icon-pencil"></i></a>';
                $delete                                         = '<a class="btn btn-sm btn-danger" href="javascript:void(0);" title="Delete" onclick="change_status('.$value->user_id.', -1);"><i class="icon-trash"></i></a>';
                $aws_bucket                                     = '<a href="'.base_url().'admin/get_user_aws_bucket_list/'.$value->user_id.'" class="btn custblue btn-sm" title="Aws Bucket Access"><i title="Configuration" class="icon-settings"></i></a>';
                
                $row['action']                                  = '<div class="wd-130-px m-0-auto">'.$edit.$delete.$aws_bucket.'</div>';
                //$row['action']                                  = '<div class="wd-130-px m-0-auto">'.$edit.$delete.'</div>';
                
                $tabledata[]                                    = $row;
            }

            $output             = array(
                                        "total"      => $this->Somaiya_general_admin_model->get_users_data($condition, '', '', 'allcount'),
                                        "rows"       => $tabledata,
                                    );

            echo json_encode($output);
        
    }

    function user_change_status($id='', $status='')
        {

            
            $error      = 1;
            $message    = 'Invalid request';
            if($id)
            {
                $details = $this->Somaiya_general_admin_model->get_user_details($id);

                if(!empty($details))
                {
                    if($status == -1)
                    {
                        $message = 'deleted';
                    }
                    else if($status == 1)
                    {
                        $message = 'activated';
                    }
                    else if($status == 0)
                    {
                        $message = 'in-activated';
                    }

                    if($this->Somaiya_general_admin_model->change_user_status($id, $status))
                    {
                        $error      = 0;
                        $message    = 'User successfully '.$message;
                    }
                    else
                    {
                        $error      = 1;
                        $message    = 'Unable to perform this action';
                    }
                }
                else
                {
                    $error      = 1;
                    $message    = 'No user found';
                }
            }
            $this->session->set_flashdata('status', ['error' => $error, 'message' => $message]);
            redirect(base_url().'admin/user');
        }

        function send_credential_to_user($user_id='')
        {
            $error      = 1;
            $message    = 'Invalid request';
            if($user_id)
            {
                $details = $this->Somaiya_general_admin_model->get_user_details($user_id);

                if(!empty($details))
                {
                    // echo "<pre>";
                    // print_r($details);
                    // exit();
                    $email_msg['methods'] = $this->get_nested_modules();
                    $email_msg['select_all_data'] = array();

                    $get_user_group_by_institute = $this->Somaiya_general_admin_model->get_user_groupDetails($user_id);
                    
                    // echo "<pre>";
                    // print_r($get_user_group_by_institute);
                    // echo "<br>-----------------<br>";
                    // exit();

                    $users_application_permissions = array();
                    foreach ($get_user_group_by_institute as $key => $value) {
                      //$users_application_permissions[] = implode('|', $sub);
                        //echo "i = ".$value['institute_id'];
                        $users_application_permissions[] = $this->Somaiya_general_admin_model->get_userApplicationPermissionByGroupAndInstituteId($value['group_id'],$value['institute_id']);

                    }

                    // following code used for get user page permissions

                    $user_page_permissions = array();
                    foreach ($get_user_group_by_institute as $key => $value) {
                        $user_page_permissions[] = $this->Somaiya_general_admin_model->get_userPagePermissionByGroupAndInstituteId($value['group_id'],$value['institute_id']);
                    }
                    
                    // echo "<pre>";
                    // print_r($user_page_permissions);   
                    // echo "<br>------------------<br>";

                    

                    foreach ($user_page_permissions as $key => $value) {
                        foreach ($value as $key1 => $value1) {
                            $menu_data = $this->nested_menu($value1['pr_inst_id']);
                            $user_page_permissions[$key][$key1]['menu_data']    = $menu_data;
                            //$user_page_permissions[$key][$key1]['otherpage']    = $this->Permissions_model->get_other_page($menu_data['permission_page_ids'], $value1['pr_inst_id']);
                            $user_page_permissions[$key][$key1]['otherpage']    = $this->Somaiya_general_admin_model->get_other_page($menu_data['permission_page_ids'], $value1['pr_inst_id']);
                        }
                        
                    }

                    // echo "<pre>";
                    // print_r($user_page_permissions);   
                    // exit();

                    /*$users_add_page_permissions = array();
                    foreach ($get_user_group_by_institute as $key => $value) {
                        $users_add_page_permissions[] = $this->Somaiya_general_admin_model->get_userAddPagePermissionByGroupAndInstituteId($value['group_id'],$value['institute_id']);

                    }

                    $users_edit_page_permissions = array();
                    foreach ($get_user_group_by_institute as $key => $value) {
                        $users_edit_page_permissions[] = $this->Somaiya_general_admin_model->get_userEditPagePermissionByGroupAndInstituteId($value['group_id'],$value['institute_id']);

                    }

                    
                    $users_delete_page_permissions = array();
                    foreach ($get_user_group_by_institute as $key => $value) {
                        $users_delete_page_permissions[] = $this->Somaiya_general_admin_model->get_userDeletePagePermissionByGroupAndInstituteId($value['group_id'],$value['institute_id']);

                    }

                    $users_view_page_permissions = array();
                    foreach ($get_user_group_by_institute as $key => $value) {
                        $users_view_page_permissions[] = $this->Somaiya_general_admin_model->get_userViewPagePermissionByGroupAndInstituteId($value['group_id'],$value['institute_id']);

                    }

                    echo "<pre>";
                    print_r($users_add_page_permissions);
                    echo "<br>-------------<br>";
                    echo "<pre>";
                    print_r($users_edit_page_permissions);
                    echo "<br>-------------<br>";
                    echo "<pre>";
                    print_r($users_delete_page_permissions);                    
                    //exit();
                    echo "<pre>";
                    print_r($users_view_page_permissions);                    
                    exit();*/


                    // send email to user with login credential
                    if($details['email'] != "")
                    {
                        $to_email=$details['email'];
                        $from = 'noreply@somaiya.edu';
                        
                        $email_msg['fullname'] = $details['fullname'];
                        $email_msg['username'] = $details['username'];
                        //$password_hash = $details['password'];

                        $email_msg['users_application_permissions'] = $users_application_permissions;
                        
                        // $email_msg['add_permissions']    = $users_add_page_permissions;
                        // $email_msg['edit_permissions']   = $users_edit_page_permissions;
                        // $email_msg['delete_permissions'] = $users_delete_page_permissions;
                        // $email_msg['view_permissions']   = $users_view_page_permissions;
                        $email_msg['user_page_permissions']   = $user_page_permissions;

                        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

                        $default_pwd = substr(str_shuffle($str_result), 
                           0, 8); // create 8 digit password
                        $default_hash_pwd = password_hash($default_pwd, PASSWORD_DEFAULT);
                        
                        if($this->Somaiya_general_admin_model->update_user_password($default_hash_pwd, $user_id))
                        {
                            $email_msg['default_pwd'] = $default_pwd;
                            $msg = $this->load->view('somaiya_general_admin/users_create_email_template',$email_msg,true);

                            //echo "<pre>";
                            //print_r($msg);
                            //exit();

                            $config=array(
                                'charset'=>'utf-8',
                                'wordwrap'=> TRUE,
                                'mailtype' => 'html'
                            );

                            $to   = $to_email;
                            $this->load->config('email');
                            $this->load->library('email');
                            $this->email->clear();
                            $this->email->initialize($config);

                            $this->email->from($from, 'Somaiya Groups');
                            $list = $to;
                            $this->email->to($list);
                            $this->email->subject('Somaiya Groups - CMS Login Credential');
                            $this->email->message($msg);

                            if ($this->email->send()) {
                                // echo 'Your email was sent, thanks chamil.';
                            } else {
                                show_error($this->email->print_debugger());
                            }
                        }
                        
                    }
                    
                }
                else
                {
                    $error      = 1;
                    $message    = 'No user found';
                }
            }
            $this->session->set_flashdata('status', ['error' => $error, 'message' => $message]);
            redirect(base_url().'admin/user');
        }

        function get_filtered_user_email_id()
        {
            if (!$this->input->is_ajax_request())
            {
                //echo "cant access url directly";  
                show_404(); // Output "Page not found" error.
                exit();
            }

            $login_type = $this->security->xss_clean($this->input->post('selected_login_type'));
            //echo "in controller = ".$login_type."<br>----------<br>";
            $user_group = $this->security->xss_clean($this->input->post('selected_user_group'));
            $institutes = $this->security->xss_clean($this->input->post('selected_institute'));
            $status = $this->security->xss_clean($this->input->post('selected_status'));
            $username = $this->security->xss_clean($this->input->post('selected_username'));
            $fullname = $this->security->xss_clean($this->input->post('selected_fullname'));
            $email = $this->security->xss_clean($this->input->post('selected_email'));

            $email_ids = $this->Somaiya_general_admin_model->get_filtered_user_email_id($login_type,$user_group,$institutes,$status,$username,$fullname,$email);

            echo implode(', ', array_column($email_ids, 'email'));

            // echo "<pre>";
            // print_r($email_ids);
            // exit();
            
        }

        function user_send_email_form_submit()
        {
            if (!$this->input->is_ajax_request())
            {
                //echo "cant access url directly";  
                show_404(); // Output "Page not found" error.
                exit();
            }

            $response = array();
            $post_submit = $this->input->post();
            if(!empty($post_submit))
            {
                $this->form_validation->set_rules('send_email_subject', 'Email Subject', 'trim|required|xss_clean',array('required'=>'Email Subject is required'));

                $this->form_validation->set_rules('send_email_body', 'Email Body', 'trim|required|xss_clean',array('required'=>'Email Body is required'));
                
                
                if($this->form_validation->run() == FALSE)
                {
                    $response['status'] = 'failure';
                    $response['message'] = 'Validation Error';
                    $response['error'] = array('send_email_subject'=>strip_tags(form_error('send_email_subject')),'send_email_body'=>strip_tags(form_error('send_email_body')));
                }
                else
                {
                    // add send email functionality here
                    // echo "<pre>";
                    // print_r($post_submit);
                    //exit();
                    //echo "<br>------------<br>";

                    $send_email_ids = $this->security->xss_clean($this->input->post('send_email_ids'));
                    $email_subject = $this->security->xss_clean($this->input->post('send_email_subject'));
                    $email_body = $this->security->xss_clean($this->input->post('send_email_body')); 

                    //$to_email=array('ajit.ts@somaiya.edu','varsha.bhoomkar@somaiya.edu');
                    $to_email = explode(',', $send_email_ids);
                    $from = 'noreply@somaiya.edu';

                    //$msg = $email_body;
                    $data['send_email_ids']     = $send_email_ids;
                    $data['email_subject']      = $email_subject;
                    $data['email_body']         = $email_body;

                    $msg = $this->load->view('somaiya_general_admin/users_send_email_template',$data,true);

                    $config=array(
                        'charset'=>'utf-8',
                        'wordwrap'=> TRUE,
                        'mailtype' => 'html'
                    );


                    $to   = $to_email;
                    $this->load->config('email');
                    $this->load->library('email');
                    $this->email->clear();
                    $this->email->initialize($config);

                    $this->email->from($from, 'Somaiya Vidyavihar');
                    $list = $to;
                    $this->email->to($list);
                    $data = array();
                    $this->email->subject($email_subject);
                    $this->email->message($msg);
                    //$this->email->set_mailtype("html");


                    if ($this->email->send()) {
                        // echo 'Your email was sent, thanks chamil.';
                        $success_msg = 'Successfully Sent Email';
                    } else {
                        show_error($this->email->print_debugger());
                        $success_msg = 'Unsuccessfully Sent Email';
                    }

                    $response['status'] = 'success';
                    $response['message']= $success_msg;
                    $response['error']  = '';
                }
            }
            else
            {
                $response['status'] = 'failure';
                $response['message'] = 'Data Not Posted';
                $response['error']  = '';
            }

            echo json_encode($response);
            exit();
        }

    function test_user_authtoken()
    {
        //echo "in test function";
        $bucket_list = array();
        $this->data['bucket_list'] = $bucket_list;
        //$this->load->view($this->mainTemplate.'/get_user_authtoken_using_patch',$this->data,true);   
        $this->load->view($this->mainTemplate.'/get_user_authtoken_using_patch',$this->data,false);
    }

    function user_authtoken_using_patch()
    {
        $user_googleauth_email_id = $this->input->post('user_email_id');
        $user_googleauth_unique_id = $this->input->post('user_unique_id');

        $this->session->set_userdata('googleuserId', $user_googleauth_unique_id);
        $this->session->set_userdata('googleuserEmailId', $user_googleauth_email_id);
        //echo "inside authtoken function<br>";
        $this->google_auth();

    }

    function google_auth()
    {  
        // ini_set('display_errors', '1');
        // ini_set('display_startup_errors', '1');
        // error_reporting(E_ALL);
        //$user_googleauth_email_id = 'firoza@somaiya.edu';
        //$user_googleauth_unique_id = 48;
        //$user_googleauth_email_id = $this->input->post('user_email_id');
        //$user_googleauth_unique_id = $this->input->post('user_unique_id');
        //echo "inside google_auth function";

        //require_once 'C:/xampp/htdocs/edu/vendor/autoload.php';
        require_once '/var/www/html/somaiya.com/vendor/autoload.php';
        define('SCOPE_FOR_PATCH', 'https://www.googleapis.com/auth/admin.directory.user');

        $client = new Google\Client();
        $client->setAuthConfigFile('client_secrets.json');
        $client->setRedirectUri('https://' . $_SERVER['HTTP_HOST'] . '/admin/google_auth');
        $client->addScope(SCOPE_FOR_PATCH);

        //echo "host : ".$_SERVER['HTTP_HOST']."<br>";
        // echo "<pre>";
        // print_r($client);
        // echo "<br>---------------<br>";

        if (!isset($_GET['code'])) 
        {
            // echo "inside if condition";
            // exit();
            $auth_url = $client->createAuthUrl();
            header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
            
        } 
        else 
        {
            //echo "inside else part";

            $user_googleauth_email_id = $this->session->userdata("googleuserEmailId");
            $user_googleauth_unique_id = $this->session->userdata("googleuserId");
            
            // echo "email : ".$user_googleauth_email_id.", unique id : ".$user_googleauth_unique_id;
            // exit();

            $client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            $redirect_uri = 'https://' . $_SERVER['HTTP_HOST'] . '/admin/google_auth';
            $user_access_token = $_SESSION['access_token']['access_token'];
            //echo "access_token : ".$user_access_token;

            try 
            {

                $api_link = "https://admin.googleapis.com/admin/directory/v1/users/".$user_googleauth_email_id."?key=AIzaSyBxY1_uE5bI7GN5trFgAeKwSzEvE09dm0A";
                $authorization = "Authorization: Bearer ".$user_access_token;

                $post_data = array();

                $ch = curl_init($api_link);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$post_data);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);


                $oracle_response = curl_exec($ch);
				$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $fetch_oracle_response = json_decode($oracle_response,true);
                // echo "<pre>";
                // print_r($fetch_oracle_response);
                // exit();
                $bucket_list = array();
                
                if($httpcode == 200)
                {
					if(isset($fetch_oracle_response['customSchemas']['SSO']['role']))
					{
						$bucket_list_array = $fetch_oracle_response['customSchemas']['SSO']['role'];

						

						if(isset($bucket_list_array) && !empty($bucket_list_array))
						{
							foreach ($bucket_list_array as $key => $value) {
								$bucket_list[] = $value['customType'];
							}
						}
					  
						$this->data['bucket_list'] = $bucket_list;
						// echo "<pre>";
						// print_r($bucket_list);
						// echo "<br>---------------<br>";
						if(!empty($bucket_list))
						{
							$this->session->set_flashdata('bucket_list_data', $bucket_list);
							//$this->session->set_flashdata('empty_bucket_list_mesage', '');
							$this->session->set_flashdata('empty_bucket_list_mesage', 'Bucket List Found');
							$this->session->set_flashdata('user_permission', '');
						}
						else
						{
							$this->session->set_flashdata('bucket_list_data', $bucket_list);
							$this->session->set_flashdata('empty_bucket_list_mesage', 'No Bucket List Found');
							$this->session->set_flashdata('user_permission', '');
						}
						// echo "<br>redirection user id : ".$user_googleauth_unique_id;
						// exit();
						redirect(base_url().'admin/get_user_aws_bucket_list/'.$user_googleauth_unique_id, 'refresh');
					}
					else
					{

						$this->session->set_flashdata('bucket_list_data', $bucket_list);
						$this->session->set_flashdata('empty_bucket_list_mesage', 'No Bucket List Found');
						$this->session->set_flashdata('user_permission', '');
						redirect(base_url().'admin/get_user_aws_bucket_list/'.$user_googleauth_unique_id, 'refresh');
					}
				}
                else
                {
                    $this->session->set_flashdata('bucket_list_data', $bucket_list);
                    $this->session->set_flashdata('user_permission', 'Not Authorized to access this resource/api');
                    $this->session->set_flashdata('empty_bucket_list_mesage', 'No Bucket List Found');
                    redirect(base_url().'admin/get_user_aws_bucket_list/'.$user_googleauth_unique_id, 'refresh');

                    
                }
                

            }
            catch (Exception $ex) { curl_close($curl); }
        }

        // echo "<br>---------After Add S3 Code----------<br>";
        // echo "<br>email id : ".$user_googleauth_email_id;
        // echo "<br>user id : ".$user_googleauth_unique_id;

       
    }
    
    function selected_bucket_form()
    {
        $selected_buckets = $this->input->post('bucket_check');
        $user_googleauth_email_id = $this->input->post('user_email_id');
        $user_googleauth_unique_id = $this->input->post('user_unique_id');

        $this->session->set_userdata('selectedgoogleuserId', $user_googleauth_unique_id);
        $this->session->set_userdata('selectedgoogleuserEmailId', $user_googleauth_email_id);
        

        // $this->google_auth();

        // echo "<pre>";
        // print_r($selected_buckets);
        // exit();

        if(isset($selected_buckets) && !empty($selected_buckets))
        {
            $bucket_role = array();

            foreach ($selected_buckets as $key => $value) {
                $bucket_role[] = '{
                      "type": "custom",
                      "customType": "'.$value.'",
                      "value": "arn:aws:iam::643208510295:role/'.$value.'-role,arn:aws:iam::643208510295:saml-provider/SomaiyaGoogleApps"                  
                    }'; 
            }

            $selected_buckets_final_array = '{
              "customSchemas": {
                "SSO": {
                  "role": [
                    '.implode(",", $bucket_role).'
                  ]
                }
              }
            }';

        }
        else
        {
            $selected_buckets_final_array = '{
              "customSchemas": {
                "SSO": {
                  "role": [
                            {
                              "type": "custom",
                              "customType": "svv-dummy",
                              "value": "arn:aws:iam::643208510295:role/svv-dummy-role,arn:aws:iam::643208510295:saml-provider/SomaiyaGoogleApps"                  
                            }
                  ]
                }
              }
            }';
        }



        // echo "<pre>";
        // print_r($selected_buckets_final_array);
        // echo "<br>--------------------<br>";
        $this->session->set_userdata('selecteduserBucketList', $selected_buckets_final_array);
        //exit();

        //$this->selected_buckets_pass_through_api($user_googleauth_unique_id,$user_googleauth_email_id,$selected_buckets_final_array);
        $this->selected_buckets_pass_through_api();
        /*try 
            {

                $api_link = "https://admin.googleapis.com/admin/directory/v1/users/firoza@somaiya.edu?key=AIzaSyBxY1_uE5bI7GN5trFgAeKwSzEvE09dm0A";
                //$authorization = "Authorization: Bearer ".$user_access_token;
                $authorization = "Authorization: Bearer ya29.a0AfH6SMB3AOo4GEsa-hrGrh55xqOlWgYgFv3uODuc-fOjCI68n2MZyBVopJlcDQIH41wtnLxbhuSx2QhGpsCjB06j1yaq2ZzXLgtYE4-L27q7a0ffQ8FDKGoRrkN-VcALYvxCvPfFU4kk90Lur_HMS0-yfUgBYQ";

                $post_data = $final_json_array;

                $ch = curl_init($api_link);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$post_data);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);


                $oracle_response = curl_exec($ch);
                $fetch_oracle_response = json_decode($oracle_response,true);
                echo "<pre>";
                print_r($fetch_oracle_response);
                exit();
                

            }
            catch (Exception $ex) { curl_close($curl); }*/
    }
    
    function selected_buckets_pass_through_api()
    {  
        
        //require_once 'C:/xampp/htdocs/edu/vendor/autoload.php';
        require_once '/var/www/html/somaiya.com/vendor/autoload.php';
        define('SCOPE_FOR_PATCH', 'https://www.googleapis.com/auth/admin.directory.user');

        // echo "In selecte bucket function";
        // exit();

        $client = new Google\Client();
        $client->setAuthConfigFile('client_secrets.json');
        $client->setRedirectUri('https://' . $_SERVER['HTTP_HOST'] . '/admin/selected_buckets_pass_through_api');
        $client->addScope(SCOPE_FOR_PATCH);

        if (!isset($_GET['code'])) 
        {
            //echo "inside if condition";
            $auth_url = $client->createAuthUrl();
            header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
            
        } 
        else 
        {

            $user_googleauth_email_id = $this->session->userdata("selectedgoogleuserEmailId");
            $user_googleauth_unique_id = $this->session->userdata("selectedgoogleuserId");
            $selected_buckets_final_array = $this->session->userdata("selecteduserBucketList");
            
            $client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            $redirect_uri = 'https://' . $_SERVER['HTTP_HOST'] . '/admin/selected_buckets_pass_through_api';
            $user_access_token = $_SESSION['access_token']['access_token'];
            //echo "access_token : ".$user_access_token;

            // echo "user id : ".$user_googleauth_unique_id."<br>";
            // echo "user email id : ".$user_googleauth_email_id."<br>";
            // echo "<pre>";
            // print_r($selected_buckets_final_array);
            // echo "<br>----------------------------<br>";
            // exit();

            try 
            {

                //$api_link = "https://admin.googleapis.com/admin/directory/v1/users/firoza@somaiya.edu?key=AIzaSyBxY1_uE5bI7GN5trFgAeKwSzEvE09dm0A";
                //$authorization = "Authorization: Bearer ya29.a0AfH6SMB3AOo4GEsa-hrGrh55xqOlWgYgFv3uODuc-fOjCI68n2MZyBVopJlcDQIH41wtnLxbhuSx2QhGpsCjB06j1yaq2ZzXLgtYE4-L27q7a0ffQ8FDKGoRrkN-VcALYvxCvPfFU4kk90Lur_HMS0-yfUgBYQ";

                $api_link = "https://admin.googleapis.com/admin/directory/v1/users/".$user_googleauth_email_id."?key=AIzaSyBxY1_uE5bI7GN5trFgAeKwSzEvE09dm0A";
                $authorization = "Authorization: Bearer ".$user_access_token;

                $post_data = $selected_buckets_final_array;

                $ch = curl_init($api_link);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$post_data);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);


                $oracle_response = curl_exec($ch);
                $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $fetch_oracle_response = json_decode($oracle_response,true);
                
                // echo "<pre>";
                // print_r($fetch_oracle_response);
                // echo "<br>---------------<br>";
                // exit();
                
                if($httpcode == 200)
                {
                    $this->session->set_flashdata('requeststatus', ['error' => 0, 'message' => 'successfully add buckets']);
                    redirect(base_url().'admin/user/', 'refresh');
                }
                else
                {
                    $this->session->set_flashdata('requeststatus', ['error' => 1, 'message' => 'Please try again later']);

                    redirect(base_url().'admin/user/', 'refresh');
                }
                

            }
            catch (Exception $ex) { curl_close($curl); }

        }

        // echo "<br>---------After Add S3 Code----------<br>";
        // echo "user id : ".$user_googleauth_unique_id."<br>";
        // echo "user email id : ".$user_googleauth_email_id."<br>";
        // echo "<pre>";
        // print_r($selected_buckets_final_array);
        // exit();
       
    }
    
    function get_user_aws_bucket_list($user_id)
    {
        // ini_set('display_errors', '1');
        // ini_set('display_startup_errors', '1');
        // error_reporting(E_ALL);
        $this->data['main_menu_type'] = "user_management";
        $this->data['sub_menu_type'] = "users";
        $this->data['child_menu_type'] = "users";
        $this->data['sub_child_menu_type'] = "";

        // $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        // validate_permissions('admin', 'edituser', $per_action);
        
        //$this->data['title'] = _l("User",$this);
        $user_data = $this->Somaiya_general_admin_model->get_user_email_id($user_id);
        $this->data['user_email_id'] = $user_data[0]['email'];
        $this->data['user_id'] = $user_id;
        $this->data['page'] = "user";
        $this->data['content']=$this->load->view($this->mainTemplate.'/get_user_authtoken_using_patch',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }
    
    function get_nested_modules($parent = 0) {
        $items      = array();
        $results    = $this->common_model->custom_query('Select * from user_module where parent_id="'.$parent.'" order by module_id ASC');
        foreach($results as $result) {
            $child_array        = $this->get_nested_modules($result['module_id']);
            $result['methods']  = $this->get_permission_methods($result['module_id']);

            // echo "<pre>";print_r($result['methods']);//exit;

            if(!empty($result['methods']))
            {
                foreach ($result['methods'] as $mkey => $mvalue) {
                    $this->permission_method_ids[$mvalue['pm_id']] = ['pm_id' => $mvalue['pm_id'], 'pm_method' => $mvalue['pm_method']];
                }
                // $pm_id          = array_column($result['methods'], 'pm_id');
                // $this->permission_method_ids = array_merge($this->permission_method_ids, $pm_id);
            }

            if(sizeof($child_array) == 0) {
                $result['sub_module'] = [];
                array_push($items, $result);
            } else {
                $result['sub_module'] = $child_array;
                array_push($items, $result);
            }
        }
        return $items;
    }

    function get_permission_methods($module_id='')
    {
        $results        = [];
        if($module_id)
        {
            $results    = $this->common_model->custom_query('Select * from user_permission_method where pm_module_id="'.$module_id.'" order by pm_order ASC');
        }
        return $results;
    }

    function nested_menu($instituteId)
    {
        $this->permission_page_ids      = [];

        $result = [];
        $i = 0;
        $menu_data = $this->Somaiya_general_admin_model->get_all_menu_for_pages(array('sub_menu' => 0, 'sub_sub_menu' => 0, 'menu.institute_id' => $instituteId));

        foreach ($menu_data as $menukey => $menu) {
            if(!in_array($menu['page_id'], $this->permission_page_ids))
            {
                $this->permission_page_ids[] = $menu['page_id'];
            }

            $result['main_menu_data'][$i] = $menu;
            $j = 0;
            $child_menu_data = [];
            $rowspan = 0;
            $child_rowspan = 0;
            $sub_menu_data = $this->Somaiya_general_admin_model->get_all_menu_for_pages(array('sub_menu' => $menu['menu_id'], 'sub_sub_menu' => 0, 'institute_id' => $instituteId));
            foreach ($sub_menu_data as $submenukey => $sub_menu) {
                if(!in_array($sub_menu['page_id'], $this->permission_page_ids))
                {
                    $this->permission_page_ids[] = $sub_menu['page_id'];
                }

                $result['main_menu_data'][$i]['sub_menu_data'][$j] = $sub_menu;
                $child_menu_data = $this->Somaiya_general_admin_model->get_all_menu_for_pages(array('sub_menu' => $sub_menu['menu_id'], 'sub_sub_menu' => 0, 'institute_id' => $instituteId));
                $page_id = array_column($child_menu_data, 'page_id');
                if(!empty($page_id))
                {
                    $this->permission_page_ids = array_merge($this->permission_page_ids, array_filter($page_id));
                }

                $result['main_menu_data'][$i]['sub_menu_data'][$j]['child_menu_data'] = $child_menu_data;
                $child_rowspan = $child_rowspan + count($child_menu_data);
                if(count($child_menu_data) > 0)
                {
                    $rowspan = $rowspan + count($child_menu_data);
                }
                else
                {
                    $rowspan = $rowspan + 1;
                }
                ++$j;
            }
            $result['main_menu_data'][$i]['rowspan'] = $rowspan;
            ++$i;
        }
        $permission_page_ids = array_values(array_filter($this->permission_page_ids));
        return ['menu_data' => $result, 'permission_page_ids' => $permission_page_ids];
    }

        // end user module changes code

    // end user module changes
	
	// start page content history code

    function page_content_history($page_id='', $contents_id='')
    {
        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "page";
        $this->data['child_menu_type'] = "";
        $this->data['sub_child_menu_type'] = "";

        validate_permissions('Somaiya_general_admin', 'page', $this->config->item('method_for_view'), $this->default_institute_id);
        $this->data['institutes_details']   = $this->Somaiya_general_admin_model->get_institute_detail($_SESSION['inst_id']);
        $this->data['title'] = _l("Page Content History",$this);
        $this->data['page'] = "page_content_history";
        $this->data['page_id'] = $page_id;
        $this->data['contents_id'] = $contents_id;
        $this->data['content']=$this->load->view($this->mainTemplate.'/page_content_history',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }

    function page_content_history_ajax_list($page_id='', $contents_id='')
    {

        $this->data['main_menu_type'] = "institute_menu";
        $this->data['sub_menu_type'] = "page";
        $this->data['child_menu_type'] = "";
        $this->data['sub_child_menu_type'] = "";


        //$content_data = $this->Somaiya_general_admin_model->get_page_content_history($page_id,$contents_id);
        $this->data['institutes_details']   = $this->Somaiya_general_admin_model->get_institute_detail($_SESSION['inst_id']);
        $institute_url = $this->data['institutes_details']['institute_url'];


        $condition = '';
        // if($this->session->userdata('user_id') == 1)
        // {
        //     $condition      = ['u.status !' => '-1'];
        // }
        // else
        // {
        //     //$condition      = ['u.status !' => '-1', 'u.created_by' => $this->session->userdata('user_id')]; // hide this because user table 'created_by' column missing. 
        // }
        
        $list               = $this->Somaiya_general_admin_model->get_page_content_history_data($condition, '', '', '');
        $tabledata          = [];
        $no                 = isset($_GET['offset']) ? $_GET['offset'] : 0;
        //echo "<pre>";print_r($list);exit;

        foreach ($list as $key => $value) {

            // if($value->status == 1)
            // {
            //     $status     = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$value->user_id.', 0);"><div class="label label-default label-form wd-100-px background-green">Active</div></a>';
            // }
            // else if($value->status == 0)
            // {
            //     $status     = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$value->user_id.', 1);"><div class="label label-default label-form wd-100-px background-red">In-Active</div></a>';
            // }

            
            
            $no++;
            $row                                            = [];
            $row['sr_no']                                   = $no;
            $row['pch_id']                                  = $value->pch_id;
            $row['name']                                    = $value->name;
            $row['language_name']                           = $value->language_name;
            $row['description']                             = $value->description;
            $row['meta_title']                              = $value->meta_title;
            //$row['status']                                  = $status;
            $row['meta_description']                        = $value->meta_description;
            $row['meta_keywords']                           = $value->meta_keywords;
			$row['userfullname']                            = $value->userfullname;
            $row['type']                                    = $value->type;
            
            if($value->modified_on == '0000-00-00 00:00:00')
            {
                $row['created_on']                              = date("d-m-Y h:i:s",strtotime($value->created_on));
            }
            else
            {
                $row['created_on']                              = date("d-m-Y h:i:s",strtotime($value->modified_on));
            }
            
            
            //$edit                                           = '<a data-toggle="tooltip" class="btn btn-sm btn-primary m-r-5" href="'.base_url().'admin/edituser/'.$value->user_id.'" title="Edit"><i class="icon-pencil"></i></a>';
            //$delete                                         = '<a class="btn btn-sm btn-danger" href="javascript:void(0);" title="Delete" onclick="change_status('.$value->user_id.', -1);"><i class="icon-trash"></i></a>';
            $restore                                        = '<a href="'.base_url().'admin/update_page_content_by_history_records/'.$value->page_id.'/'.$value->extension_id.'/'.$value->pch_id.'" class="" title="Restore"><i class="fa fa-undo" aria-hidden="true"></i></a>';
            $preview                                        = '<a href="'.$institute_url.'/en/'.$value->slug.'?pch_id='.$value->pch_id.'" class="btn custblue btn-sm" title="Preview" target="_blank"><i title="Preview" class="icon-eye"></i></a>';


            //$row['action']                                  = '<div class="wd-130-px m-0-auto">'.$edit.$delete.$aws_bucket.'</div>';
            $row['action']                                  = '<div class="wd-130-px m-0-auto">'.$restore.$preview.'</div>';
            
            $tabledata[]                                    = $row;
        }

        $output             = array(
                                    "total"      => $this->Somaiya_general_admin_model->get_page_content_history_data($condition, '', '', 'allcount'),
                                    "rows"       => $tabledata,
                                );

        echo json_encode($output);
          
    }

    function update_page_content_by_history_records($page_id='',$content_id='',$pch_id='')
    {
        //echo "inside update page content history records function";
        //echo $page_id.'/'.$content_id.'/'.$pch_id;

        $page_content_history_records = $this->Somaiya_general_admin_model->get_page_content_history_records($page_id,$content_id,$pch_id);

        // echo "<pre>";
        // print_r($page_content_history_records);

        // exit();
        $update_type_in_cintent_history = array();
        $update_type_in_cintent_history['type'] = "restore";
        $update_type_in_cintent_history['modified_on'] = date('Y-m-d H:i:s');


        $update_content_data = array();

        $update_content_data['name']                                     = $page_content_history_records[0]['name'];
        $update_content_data['language_id']                              = $page_content_history_records[0]['language_id'];
        $update_content_data['meta_title']                               = $page_content_history_records[0]['meta_title'];
        $update_content_data['meta_description']                         = $page_content_history_records[0]['meta_description'];
        $update_content_data['meta_keywords']                            = $page_content_history_records[0]['meta_keywords'];
        $update_content_data['meta_image']                               = $page_content_history_records[0]['meta_image'];
        $update_content_data['public']                                   = $page_content_history_records[0]['status'];
        $update_content_data['description']                              = $page_content_history_records[0]['description'];
        //$update_content_data['updated_date']                             = date('Y');
		$update_content_data['updated_date']                             = date('Y-m-d H:i:s');
        $update_content_data['user_id']                                  = $this->session->userdata['user_id'];
		$update_content_data['restore_pch_id']                           = $pch_id;

        

        $response = $this->Somaiya_general_admin_model->update_page_content_by_history_records($page_id,$content_id,$pch_id,$update_content_data,$update_type_in_cintent_history);
         if(isset($response['status']) && $response['status'] == 'success')
        {
            $msg = ['error' => 0, 'message' => 'Page content successfully updated'];
        }
        else
        {
            $msg = ['error' => 0, 'message' => $response['message']];
        }

        redirect(base_url().'admin/editextension/'.$page_id.'/'.$content_id);

    }
    // end page content history code
    
}