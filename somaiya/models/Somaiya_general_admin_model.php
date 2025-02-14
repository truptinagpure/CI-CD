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
class Somaiya_general_admin_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_assigned_institute_list()
    {
        if($this->session->userdata['user_id'] != 1)
        {
            $this->db->select("ugi.institute_id, eid.INST_ID, eid.INST_NAME, eid.INST_SHORTNAME");
            $this->db->from('user_groups_institute ugi');
            $this->db->join('edu_institute_dir eid', 'ugi.institute_id = eid.INST_ID');
            $this->db->where('ugi.user_id', $this->session->userdata['user_id']);
        }
        else
        {
            $this->db->select("eid.*");
            $this->db->from('edu_institute_dir eid');
        }
        $this->db->order_by('eid.INST_ID','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_assigned_institute($INST_ID)
    {
        $this->db->select("eid.*");
        $this->db->from('edu_institute_dir eid');
        $this->db->where('eid.INST_ID', $INST_ID);
        $query = $this->db->get();
        return $query->result_array();
    }

    /* SETTINGS CODE */

    function get_website_info()
    {
        $this->db->select('*');
        $this->db->from('setting');
        $query = $this->db->get();
        return $query->result_array();
    }

    function edit_setting($data=null){
        $this->db->set('id', 1);
        $this->db->update('setting', $data);
        return true;
    }


    /* LANGUAGE CODE */


    function get_all_language()
    {
        $this->db->select("*");
        $this->db->from('languages');
        $this->db->order_by('sort_order','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_language_detail($id)
    {
        $this->db->select('*');
        $this->db->from('languages');
        $this->db->where('language_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
    function language_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if (!isset($data['rtl'])) {
            $data['rtl']=0;
        }
        if (!isset($data['public'])) {
            $data['public']=0;
        }
        if(isset($data["public"]) && count($data["public"])!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }
        if (!isset($data['default'])) {
            $data['default']=0;
        }

        if ($this->session->userdata('group') != 1 && isset($data['default'])) {
            unset($data['default']);
        }
        if ($this->session->userdata('group') != 1 && isset($data['public'])) {
            unset($data['public']);
        }

        if(isset($data['default']) && $data['default']==1)
        {
            $this->db->set('default',0);
            $this->db->update('languages');
        }

        if($id!=null) // update
        {
            $this->db->where('language_id',$id);
            $this->db->update('languages',$data);
        }
        else    //add
        {
            $data['created_date']=time();
            $this->db->insert('languages',$data);
        }
        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    /* MAIN MENU CODE */

     function get_all_subsubmenu($conditions=null)
    {
        $this->db->select('*');
        $this->db->from('menu');
        $this->db->order_by('menu_order','ASC');     
        if($conditions!=null) $this->db->where($conditions);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_submenu($conditions=null)
    {
        $this->db->select('menu_id,menu_name,sub_menu,menu_order,public');
        $this->db->from('menu');
        if($conditions!=null) $this->db->where($conditions);
        // $this->db->where('sub_menu!=0');
        $this->db->order_by('menu_order','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_all_menu($conditions=null)
    {
        $this->db->select('*');
        $this->db->from('menu');
        $this->db->order_by('menu_order','ASC');     
        if($conditions!=null) $this->db->where($conditions);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_all_menu_for_pages($conditions=null)
    {
        $this->db->select('*');
        $this->db->from('menu');
        $this->db->where('public', 1);
        $this->db->order_by('menu_order','ASC');     
        if($conditions!=null) $this->db->where($conditions);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_menu_detail($id)
    {
        $this->db->select('*');
        $this->db->from('menu');
        $this->db->where('menu_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
    function menu_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
            unset($data["titles"]);
        }

        if(isset($data['default']))
        {
            $this->db->set('default',0);
            $this->db->update('menu');
        }

        if(isset($data["public"]) && count($data["public"])!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }


        if(isset($data["target"]) && count($data["target"])!=0){
            $data["target"]=1;
        } else {
            $data["target"]=0;
        }

        if($id!=null) // update
        {
            $this->db->where('menu_id',$id);
            $this->db->update('menu',$data);
        }
        else    //add
        {
            $data['created_date']=time();
            $this->db->insert('menu',$data);
            $id=$this->db->insert_id();
        }

        if(isset($titles)){
            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"menu"));
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"menu"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    /* USER CODE */

    function get_user_detail($id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function user_manipulate($data, $id=null)
    {   
        $this->db->trans_start();

        // $institute      = $this->input->post('institute_id[]');
        $login_type     = $this->input->post('login_type');
        $username       = $this->input->post('username');
        $fullname       = $this->input->post('fullname');
        $email          = $this->input->post('email');

        $status         = $this->input->post('status');

        $password       = '';
        if(isset($data['password']) && $data['password'] != "")
        {
            $password   = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        if($login_type == 2)
        {
            $username   = '';
        }

        $processdata    = array(
                                'login_type'    => $login_type,
                                'username'      => $username,
                                'fullname'      => $fullname,
                                'email'         => $email,
                                'password'      => $password,
                                'status'      => $status
                            );

        if(isset($processdata['password']) && $processdata["password"] == "")
        {
            unset($processdata['password']);
        }

        if($id!=null) // update
        {   
            $this->db->where('user_id', $id);
            $this->db->update('users', $processdata);

            $save = [];
            $save_user_group = [];
            foreach ($data['group_array'] as $key => $value) {
                $save['group_id'] = $value;
                $save['institute_id'] = $data['institute_array'][$key];
                $save['ugiid'] = $data['ugiid'][$key];
                $save_group_inst[] = $save;
            }

            // echo"<pre>";print_r($save_group_inst);

            $relation_id = $this->input->post('relation_id');
            $id2 = $this->input->post('ugiid');
            // print_r($id2);exit();

            if($id2 == ''){ 
                if(isset($data['user_array_check']) && $data['user_array_check'] == 1){ //echo"m in insert";exit();
                    foreach($save_group_inst as $key => $result){ 
                        $this->db->insert('user_groups_institute',array("group_id"=>$result['group_id'],"institute_id"=>$result['institute_id'],"user_id"=>$id));
                        // echo "<pre>";print_r($this->db->last_query());exit;
                    }
                }
            } 

            if(isset($data['user_array_check']) && $data['user_array_check'] == 2){ //echo"m in update";exit();
                if (!empty($save_group_inst))  {  
                    foreach($save_group_inst as $key => $result){ 
                        if($result['ugiid'] == ''){
                            $this->db->insert('user_groups_institute',array("group_id"=>$result['group_id'],"institute_id"=>$result['institute_id'],"user_id"=>$id));
                        }
                        $this->db->where('ugiid',$result['ugiid']);
                        $this->db->update('user_groups_institute',array("group_id"=>$result['group_id'],"institute_id"=>$result['institute_id'],"user_id"=>$relation_id)); 
                        // echo "<pre>";print_r($this->db->last_query());exit;
                    }
                }
            }

        }
        else    //add
        {   
            $processdata['created_date'] = date('d/m/Y');
            $this->db->insert('users', $processdata);
            $id = $this->db->insert_id();

            $save = [];
            $save_user_group = [];
            foreach ($data['group_array'] as $key => $value) {
                $save['group_id'] = $value;
                $save['institute_id'] = $data['institute_array'][$key];
                $save_group_inst[] = $save;
            }

            $i=0;
            foreach($save_group_inst as $result){     
                $this->db->insert('user_groups_institute',array("group_id"=>$result['group_id'],"institute_id"=>$result['institute_id'],"user_id"=>$id));
                $i++;    
            } 
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    function get_all_user()
    {

        $this->db->select("*,GROUP_CONCAT(edu_institute_dir.INST_NAME) AS institute_namenew");
        $this->db->from('users');
        $this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID,users.institute_id)",'left');
        $this->db->group_by("users.user_id");
        $this->db->order_by('users.user_id','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_uservalue($id)
    {
        $this->db->select('*');
        $this->db->from('user_groups_institute');
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        return  $query->result_array();
    }


    /* USER GROUPS CODE */


    function get_all_groups()
    {
        $this->db->select("*");
        $this->db->from('groups');
        $this->db->order_by('group_id','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_groups_detail($id)
    {
        $this->db->select('*');
        $this->db->from('groups');
        $this->db->where('group_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
    function groups_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if(isset($data["public"]) && count($data["public"])!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }

        if (isset($data['password']) && $data["password"]=="") {
            unset($data['password']);
        }elseif(isset($data['password']) && $data['password']!=""){
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        if($id!=null) // update
        {
            $pname = $this->input->post('permissions[]');
            $vv = $this->input->post('value');
            $name = implode(',', $pname);
            $group_name = $this->input->post('data[group_name]');
            $data = array( 
            'group_name' =>  $group_name 
            //'permissions' => implode(",", $pname)       
            );
            $this->db->where('group_id',$id);
            $this->db->update('groups',$data);
        }
        else    //add
        {
            $pname = $this->input->post('permissions[]');
            $vv = $this->input->post('value');
            $name = implode(',', $pname);
            $group_name = $this->input->post('data[group_name]');
            $data = array( 
            'group_name' =>  $group_name
            //'permissions' => implode(",", $pname)       
            );
            $this->db->insert('groups',$data);
        }
        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    function get_session_permissions($group_id,$user_id)
    {
        $this->db->select("groups.permissions");
        $this->db->from('groups');
        $this->db->join('users', 'users.group_id=groups.group_id');
        $this->db->where('users.user_id', $user_id);
        $this->db->where('groups.group_id', $group_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_session_permissions_institute($user_id)
    {
        $this->db->select("users.institute_id,GROUP_CONCAT(edu_institute_dir.INST_NAME) AS institute_name");
        $this->db->from('users');
        $this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID,users.institute_id)",'left');
        $this->db->where('users.user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }


    function get_session_permissions_institute_new($user_id)
    {
        $this->db->select("user_permissions.pr_inst_id,GROUP_CONCAT(edu_institute_dir.INST_NAME) AS institute_name");
        $this->db->from('user_permissions');
        $this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID,user_permissions.pr_inst_id)",'left');
        $this->db->join('user_groups_institute',"FIND_IN_SET(user_groups_institute.institute_id,user_permissions.pr_inst_id)",'left');
        $this->db->where('user_groups_institute.user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /* PAGE CONTENTS CODE */

    function get_extension_user_detail($id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }


    /* PAGE CODE */

    function get_all_page()
    {
        $this->db->select("*");
        $this->db->from('page');
        $this->db->order_by('page_id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

     function get_all_page_institute($id)
    {
        $this->db->select("*, page.created_date as created_date ,page.public as public");
        $this->db->from('page');
        $this->db->join('extensions', 'extensions.relation_id=page.page_id','left');
        $this->db->join('users', 'users.user_id=extensions.user_id','left');
        $this->db->join('edu_institute_dir', 'edu_institute_dir.INST_ID=page.institute_id','left');
        $this->db->where('page.institute_id', $id);
        $this->db->order_by('page.created_date','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_search_page($data)
    {
        $this->db->select("*");
        $this->db->from('page');
        foreach ($data as $key=>$value) {
            $this->db->where($key,$value);
        }
        $this->db->order_by('page_id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_page($id='', $conditions=[])
    {
        $this->db->select('*');
        $this->db->from('page');
        $this->db->join('extensions', 'extensions.relation_id=page.page_id');
        $this->db->where('page.page_id', $id);
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

    function manage_page($data=[], $id='')
    { 
        $this->db->trans_start();

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
        }
        unset($data["titles"]);
		
		$pch_page_id = 0;
        $pch_extensions_id = 0;
		
        if($id)
        {
            if(!empty($this->get_page($id)))
            {
                $update['page_name']                = $data['page_name'];
                $update['slug']                     = $data['slug'];
                $update['page_type']                = $data['page_type'];
                $update['institute_id']             = $data['institute_id'];
                $update['gallery_id']               = $data['gallery_id'];
                $update['public']                   = $data['public'];
				$update['video_url']                = $data['video_url'];
                $update['created_date']             = date('Y-m-d H:i:s');
                $this->db->where('page_id', $id);
                $this->db->update('page', $update);

                $upd['name']                        = $this->input->post('page_name');
                $upd['language_id']                 = $this->input->post('language_id');
                $upd['description']                 = $this->input->post('description');
                $upd['meta_title']                  = $this->input->post('meta_title');
                $upd['meta_description']            = $this->input->post('meta_description');
                $upd['meta_keywords']               = $this->input->post('meta_keywords');
                $upd['meta_image']                  = $this->input->post('meta_image');
                $upd['image']                       = $this->input->post('image');
                $upd['public']                      = $this->input->post('public');
                $upd['updated_date']                = date('Y-m-d H:i:s');
                $upd['user_id']                     = $this->session->userdata['user_id'];
                
				$pch_page_id = $id;
                $pch_extensions_id = $data['extension_id'];
				
				$this->db->where('extension_id', $data['extension_id']);
                $this->db->update('extensions', $upd);

                if(isset($titles)){
                    $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"page"));
                    foreach ($titles as $key=>$value) {
                        if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"page"));
                    }
                }

                if($this->db->affected_rows() > 0)
                {
                    $return = ['error' => 0, 'message' => 'Page successfully updated'];
                }
                else
                {
                    $return = ['error' => 1, 'message' => 'Unable to update Page'];
                }
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Page not found'];
            }
        }
        else
        {   
            $insert['page_name']                = $data['page_name'];
            $insert['slug']                     = $data['slug'];
            $insert['page_type']                = $data['page_type'];
            $insert['institute_id']             = $data['institute_id'];
            $insert['gallery_id']               = $data['gallery_id'];
            $insert['public']                   = $data['public'];
			$insert['video_url']                = $data['video_url'];
            $insert['created_date']             = date('Y-m-d H:i:s');
            $this->db->insert('page', $insert);
            $insert_id = $this->db->insert_id();

            $ins['name']             = $this->input->post('page_name');
            $ins['description']      = $this->input->post('description');
            $ins['relation_id']      = $insert_id;
            $ins['language_id']      = $this->input->post('language_id');
            $ins['public']           = $this->input->post('public');
            $ins['meta_title']       = $this->input->post('meta_title');
            $ins['meta_description'] = $this->input->post('meta_description');
            $ins['meta_keywords']    = $this->input->post('meta_keywords');
            $ins['meta_image']       = $this->input->post('meta_image');
            $ins['image']            = $this->input->post('image');
            $ins['data_type']        = $this->input->post('data_type');
            $ins['created_date']     = date('Y-m-d H:i:s');
            $ins['updated_date']     = date('Y-m-d H:i:s');
            $ins['user_id']          = $this->session->userdata['user_id'];
            $this->db->insert('extensions', $ins);
            $ins_id = $this->db->insert_id();
			
			$pch_page_id = $insert_id;
            $pch_extensions_id = $ins_id;

            $name=$this->input->post('page_name');
            if(isset($titles)){
                $this->db->delete('titles', array("relation_id"=>$insert_id,"data_type"=>"page"));
                foreach ($titles as $key=>$value) {
                    if($key==1) $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$name,"relation_id"=>$insert_id,"data_type"=>"page"));
                    else if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$insert_id,"data_type"=>"page"));
                }
            }
            

            if($insert_id)
            {
                $return = ['error' => 0, 'message' => 'Page successfully added'];
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Unable to add Page'];
            }
        }
		
		// start add code for insert page content history
        $page_content_history_insert['page_id']             = $pch_page_id;
        $page_content_history_insert['extension_id']        = $pch_extensions_id;
        $page_content_history_insert['language_id']         = $this->input->post('language_id');
		$page_content_history_insert['type']                = 'insert';
        $page_content_history_insert['name']                = $this->input->post('page_name');
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


        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }

        return $return;
    }


    function get_all_galleryids()
    {
       $this->db->select('*');
       $this->db->from('galleries');
       $this->db->order_by('galleries.g_id','DESC');
       $query = $this->db->get();
       return $query->result_array();
    }

    
    /* GALLERY CODE */

    function get_gallery($data_type=null,$relation_id=null)
    {
        $this->db->select("*");
        $this->db->from('gallery');
        $this->db->where('data_type',$data_type);
        $this->db->where('relation_id',$relation_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_gallery_detail($gallery_id)
    {
        $this->db->select("*");
        $this->db->from('gallery');
        $this->db->where('gallery_id',$gallery_id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:0;
    }
    function get_insert_gallery($data){
        $this->db->trans_start();
        $data['created_date']=time();
        $this->db->insert('gallery',$data);
        $id=$this->db->insert_id();
        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return $id;
        }
    }
    function gallery_manipulate($data,$id=null)
    {
        $this->db->trans_start();
        if(!isset($data['status'])){
            $data['status']=0;
        }

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
        }
        unset($data["titles"]);

        if($id!=null && $id!=0) // update
        {
            $this->db->where('gallery_id',$id);
            $data['updated_date']=time();
            $this->db->update('gallery',$data);
        }
        else    //add
        {
            $data['user_id']=$this->session->userdata['user_id'];
            $data['created_date']=time();
            $this->db->insert('gallery',$data);
            $id=$this->db->insert_id();

        }
        $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"gallery"));
        if(isset($titles)){
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"gallery"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }
    function get_gallery_image($gallery_id)
    {
        $this->db->select("*");
        $this->db->from('gallery_image');
        $this->db->where('gallery_id',$gallery_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_gallery_image_detail($gallery_image_id)
    {
        $this->db->select("*");
        $this->db->from('gallery_image');
        $this->db->where('image_id',$gallery_image_id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:0;
    }
    function get_insert_gallery_image($data){
        $this->db->trans_start();
        $data['created_date']=time();
        $this->db->insert('gallery_image',$data);
        $id=$this->db->insert_id();
        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return $id;
        }
    }

    function get_all_images_modal(){
        $this->db->select("*");
        $this->db->from('images');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_all_images($limit, $start){
        $this->db->limit($limit, $start);
        $this->db->select("*");
        $this->db->from('images');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_all_images_edit(){
       // $this->db->limit($limit, $start);
        $this->db->select("*");
        $this->db->from('images');
        $query = $this->db->get();
        return $query->result_array();
    }
    function insert_image($data){
        $this->db->trans_start();
        $data['created_date']=time();
        $data['user_id']=$this->session->userdata['user_id'];
        $this->db->insert('images',$data);
        $id=$this->db->insert_id();
        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return $id;
        }
    }
    function get_image_detail($image_id)
    {
        $this->db->select("*");
        $this->db->from('images');
        $this->db->where('image_id',$image_id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:0;
    }
    function get_all_titles($data_type=null,$relation_id=null)
    {
        $this->db->select("*");
        $this->db->from('titles');
        $this->db->where('data_type',$data_type);
        $this->db->where('relation_id',$relation_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function count_extensions($where = null)
    {
        $this->db->select("count(*)");
        $this->db->from('extensions');
        if($where!=null){
            foreach($where as $key=>$value){
                $this->db->where($key,$value);
            }
        }
        $this->db->where("status",1);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]["count(*)"])?$result[0]["count(*)"]:0;
    }
    function count_comment($where = null)
    {
        $this->db->select("count(*)");
        $this->db->from('comments');
        if($where!=null){
            foreach($where as $key=>$value){
                $this->db->where($key,$value);
            }
        }
        $this->db->where("status",1);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]["count(*)"])?$result[0]["count(*)"]:0;
    }
    function count_page($where = null)
    {
        $this->db->select("count(*)");
        $this->db->from('page');
        if($where!=null){
            foreach($where as $key=>$value){
                $this->db->where($key,$value);
            }
        }
        $this->db->where("public",1);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]["count(*)"])?$result[0]["count(*)"]:0;
    }
    function count_gallery($where = null)
    {
        $this->db->select("count(*)");
        $this->db->from('gallery');
        if($where!=null){
            foreach($where as $key=>$value){
                $this->db->where($key,$value);
            }
        }
        $this->db->where("status",1);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]["count(*)"])?$result[0]["count(*)"]:0;
    }
    function count_gallery_image($where = null)
    {
        $this->db->select("count(*)");
        $this->db->from('gallery_image');
        if($where!=null){
            foreach($where as $key=>$value){
                $this->db->where($key,$value);
            }
        }
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]["count(*)"])?$result[0]["count(*)"]:0;
    }
    function count_uploaded_image($where = null)
    {
        $this->db->select("count(*)");
        $this->db->from('images');
        if($where!=null){
            foreach($where as $key=>$value){
                $this->db->where($key,$value);
            }
        }
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]["count(*)"])?$result[0]["count(*)"]:0;
    }
    function count_users($where = null)
    {
        $this->db->select("count(*)");
        $this->db->from('users');
        if($where!=null){
            foreach($where as $key=>$value){
                $this->db->where($key,$value);
            }
        }
        $this->db->where("status",1);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]["count(*)"])?$result[0]["count(*)"]:0;
    }
    function get_all_setting_options(){
        $this->db->select("*");
        $this->db->from('setting_options_per_lang');
        $query = $this->db->get();
        return $query->result_array();
    }
    function check_setting_options($language_id){
        $this->db->select("count(*)");
        $this->db->from('setting_options_per_lang');
        $this->db->where('language_id',$language_id);
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]["count(*)"])?$result[0]["count(*)"]:0;
    }
    function edit_setting_options($language_id,$data){
        $this->db->where('language_id',$language_id);
        $this->db->update('setting_options_per_lang', $data);
    }
    function insert_setting_options($language_id,$data){
        $data['language_id']= $language_id;
        $this->db->insert('setting_options_per_lang', $data);
    }
    function get_all_statistic(){
        $this->db->select("*");
        $this->db->from('statistic');
        $this->db->order_by('statistic_date','DESC');
        $this->db->limit(14);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_statistic_max_visitors(){
        $this->db->select("max(visitors)");
        $this->db->from('statistic');
        $query = $this->db->get();
        $result = $query->result_array();
        return isset($result[0]["max(visitors)"])?$result[0]["max(visitors)"]:0;
    }
    function get_statistic_total_visits(){
        $this->db->select("sum(visits)");
        $this->db->from('statistic');
        $query = $this->db->get();
        $result = $query->result_array();
        $return = isset($result[0]["sum(visits)"])?$result[0]["sum(visits)"]:0;
        $this->db->select("sum(count_view)");
        $this->db->from('visitors');
        $query = $this->db->get();
        $result = $query->result_array();
        $return += isset($result[0]["sum(count_view)"])?$result[0]["sum(count_view)"]:0;
        return $return;
    }
    function get_statistic_total_visitors(){
        $this->db->select("sum(visitors)");
        $this->db->from('statistic');
        $query = $this->db->get();
        $result = $query->result_array();
        $return = isset($result[0]["sum(visitors)"])?$result[0]["sum(visitors)"]:0;
        $this->db->select("count(*)");
        $this->db->from('visitors');
        $query = $this->db->get();
        $result = $query->result_array();
        $return += isset($result[0]["count(*)"])?$result[0]["count(*)"]:0;
        return $return;
    }

    /* FOOTER MENU CODE */

    function get_all_footermenu($conditions=null)
    {
        $this->db->select('*');
        $this->db->from('footermenu');
        $this->db->order_by('menu_order','ASC');
        if($conditions!=null) $this->db->where($conditions);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_footermenu_detail($id)
    {
        $this->db->select('*');
        $this->db->from('footermenu');
        $this->db->where('menu_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
    function footermenu_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
            unset($data["titles"]);
        }

        if(isset($data['default']))
        {
            $this->db->set('default',0);
            $this->db->update('footermenu');
        }

        if(isset($data["public"]) && count($data["public"])!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }

        if(isset($data["target"]) && count($data["target"])!=0){
            $data["target"]=1;
        } else {
            $data["target"]=0;
        }

        if($id!=null) // update
        {
            $this->db->where('menu_id',$id);
            $this->db->update('footermenu',$data);
        }
        else    //add
        {
            $data['created_date']=time();
            $this->db->insert('footermenu',$data);
            $id=$this->db->insert_id();
        }

        if(isset($titles)){
            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"footermenu"));
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"footermenu"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    /* SECONDARY FOOTER MENU */

    function get_all_secondary_footermenu($conditions=null)
    {
        $this->db->select('*');
        $this->db->from('secondary_footermenu');
        $this->db->order_by('menu_order','ASC');
        if($conditions!=null) $this->db->where($conditions);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_secondary_footermenu_detail($id)
    {
        $this->db->select('*');
        $this->db->from('secondary_footermenu');
        $this->db->where('menu_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
    function secondaryfootermenu_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        // if ($this->session->userdata('group_id') != 1 && isset($data['default'])) {
        //     unset($data['default']);
        // }
        // if ($this->session->userdata('group_id') != 1 && isset($data['public'])) {
        //     unset($data['public']);
        // }

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
            unset($data["titles"]);
        }

          if(isset($data["public"]) && count($data["public"])!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }

        if(isset($data['default']))
        {
            $this->db->set('default',0);
            $this->db->update('secondary_footermenu');
        }



        if($id!=null) // update
        {
            $this->db->where('menu_id',$id);
            $this->db->update('secondary_footermenu',$data);
        }
        else    //add
        {
            $data['created_date']=time();
            $this->db->insert('secondary_footermenu',$data);
            $id=$this->db->insert_id();
        }

        if(isset($titles)){
            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"secondary_footermenu"));
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"secondary_footermenu"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    /* HEADER MENU CODE */

    function get_all_headermenu($conditions=null)
    {
        $this->db->select('*');
        $this->db->from('headermenu');
        $this->db->order_by('menu_order','ASC');
        if($conditions!=null) $this->db->where($conditions);
        $query = $this->db->get();
        return $query->result_array();
    }
     function get_all_headermenu_institute($conditions=null)
    {
        $this->db->select('*');
        // $this->db->from('headermenu');
        $this->db->order_by('menu_order','ASC');
        if($conditions!=null) $this->db->where($conditions);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_headermenu_detail($id)
    {
        $this->db->select('*');
        $this->db->from('headermenu');
        $this->db->where('menu_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
   
    function headermenu_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
            unset($data["titles"]);
        }

        if(isset($data['default']))
        {
            $this->db->set('default',0);
            $this->db->update('headermenu');
        }

        if(isset($data["public"]) && count($data["public"])!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }


        if(isset($data["target"]) && count($data["target"])!=0){
            $data["target"]=1;
        } else {
            $data["target"]=0;
        }


        if($id!=null) // update
        {
            $this->db->where('menu_id',$id);
            $this->db->update('headermenu',$data);
        }
        else    //add
        {
            $data['created_date']=time();
            $this->db->insert('headermenu',$data);
            $id=$this->db->insert_id();
        }

        if(isset($titles)){
            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"headermenu"));
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"headermenu"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    /* POST CODE */

   function get_all_post()
    {
        $this->db->select("*");
        $this->db->from('post');
        $this->db->order_by('post_id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_search_post($data)
    {
        $this->db->select("*");
        $this->db->from('post');
        foreach ($data as $key=>$value) {
            $this->db->where($key,$value);
        }
        $this->db->order_by('post_id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_post($id='', $conditions=[])
    {
        $this->db->select('*');
        $this->db->from('post');
        $this->db->join('contents', 'contents.relation_id=post.post_id');
        $this->db->where('post.post_id', $id);
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

    function manage_post($data=[], $id='')
    { 
        $this->db->trans_start();

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
        }
        unset($data["titles"]);

        if($id)
        {
            if(!empty($this->get_post($id)))
            {
                $update['post_name']                = $data['post_name'];
                $update['person_name']              = $data['person_name'];
                $update['designation']              = $data['designation'];
                $update['category_id']              = $data['category_id'];
                $update['institute_id']             = $data['institute_id'];
                $update['html_slider']              = $data['html_slider'];
                $update['whats_new']                = $data['whats_new'];
                $update['whats_new_expiry_date']    = $data['whats_new_expiry_date'];
                $update['public']                   = $data['public'];
                $update['created_date']             = date('Y-m-d H:i:s');
                $this->db->where('post_id', $id);
                $this->db->update('post', $update);

                $upd['name']             = $this->input->post('post_name');
				$upd['category_id']      = $this->input->post('category_id');
                $upd['language_id']      = $this->input->post('language_id');
                $upd['description']      = $this->input->post('description');
                $upd['image']            = $this->input->post('image');
                $upd['location']         = $this->input->post('location');
                $upd['paper']            = $this->input->post('paper');
                $upd['publish_date']     = $this->input->post('publish_date');
                $upd['meta_title']       = $this->input->post('meta_title');
                $upd['meta_description'] = $this->input->post('meta_description');
                $upd['meta_keywords']    = $this->input->post('meta_keywords');
                $upd['meta_image']       = $this->input->post('meta_image');
                $upd['public']           = $this->input->post('public');
                $upd['updated_date']     = date('Y-m-d H:i:s');
                $upd['user_id']          = $this->session->userdata['user_id'];
                $this->db->where('contents_id', $data['contents_id']);
                $this->db->update('contents', $upd);

                if(isset($titles)){
                    $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"post"));
                    foreach ($titles as $key=>$value) {
                        if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"post"));
                    }
                }

                if($this->db->affected_rows() > 0)
                {
                    $return = ['error' => 0, 'message' => 'Post successfully updated'];
                }
                else
                {
                    $return = ['error' => 1, 'message' => 'Unable to update Post'];
                }
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Post not found'];
            }
        }
        else
        {   
            $insert['post_name']                = $data['post_name'];
            $insert['person_name']              = $data['person_name'];
            $insert['designation']              = $data['designation'];
            $insert['category_id']              = $data['category_id'];
            $insert['institute_id']             = $data['institute_id'];
            $insert['html_slider']              = $data['html_slider'];
            $insert['whats_new']                = $data['whats_new'];
            $insert['whats_new_expiry_date']    = $data['whats_new_expiry_date'];
            $insert['public']                   = $data['public'];
            $insert['created_date']             = date('Y-m-d H:i:s');
            $this->db->insert('post', $insert);
            $insert_id = $this->db->insert_id();

            $ins['name']             = $this->input->post('post_name');
			$ins['category_id']      = $this->input->post('category_id');
            $ins['description']      = $this->input->post('description');
            $ins['relation_id']      = $insert_id;
            $ins['image']            = $this->input->post('image');
            $ins['language_id']      = $this->input->post('language_id');
            $ins['public']           = $this->input->post('public');
            $ins['location']         = $this->input->post('location');
            $ins['paper']            = $this->input->post('paper');
            $ins['publish_date']     = $this->input->post('publish_date');
            $ins['meta_title']       = $this->input->post('meta_title');
            $ins['meta_description'] = $this->input->post('meta_description');
            $ins['meta_keywords']    = $this->input->post('meta_keywords');
            $ins['meta_image']       = $this->input->post('meta_image');
            $ins['data_type']        = $this->input->post('data_type');
            $ins['created_date']     = date('Y-m-d H:i:s');
            $ins['updated_date']     = date('Y-m-d H:i:s');
            $ins['user_id']          = $this->session->userdata['user_id'];
            $this->db->insert('contents', $ins);
            $ins_id = $this->db->insert_id();


            $name=$this->input->post('post_name');
            if(isset($titles)){
                $this->db->delete('titles', array("relation_id"=>$insert_id,"data_type"=>"post"));
                foreach ($titles as $key=>$value) {
                    if($key==1) $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$name,"relation_id"=>$insert_id,"data_type"=>"post"));
                    else if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$insert_id,"data_type"=>"post"));
                }
            }
            

            if($insert_id)
            {
                $return = ['error' => 0, 'message' => 'Post successfully added'];
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Unable to add Post'];
            }
        }


        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }

        return $return;
    }


        /* NEWS CODE */
    
    function get_all_news()
    {
        $this->db->select("*");
        $this->db->from('news');
        $this->db->order_by('news_order','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
     function get_news_detail($id)
    {
        $this->db->select('*');
        $this->db->from('news');
        $this->db->where('news_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function news_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if(isset($data['default']) && $data['default']==1)
        {
            $this->db->set('default',0);
            $this->db->update('languages');
        }

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
        }
        unset($data["titles"]);

        if(isset($data["public"]) && count($data["public"])!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }

        if($id!=null) // update
        {
            $this->db->where('news_id',$id);
            $this->db->update('news',$data);
        }
        else    //add
        {
            $data['created_date']=date('d/m/Y');
            $this->db->insert('news',$data);
            $id=$this->db->insert_id();

        }

        if(isset($titles)){
            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"news"));
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"news"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    function get_news_location($id)
    {
        $this->db->select("*");
        $this->db->from('locations');
        $this->db->join('news',"news.location_id=locations.location_id",'left');
        $this->db->join('category',"category.category_id=news.category_id");
        $this->db->where('news.institute_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_categories()
    {
        $this->db->select("*");
        $this->db->from('category');
        $this->db->where("public",1);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_departments()
    {
        $this->db->select("*");
        $this->db->from('edu_department_dir');
        $query = $this->db->get();
        return $query->result_array();
    }

    /* NEWS CONTENTS CODE */

    function get_all_newscontents($data_type=null,$relation_id=null)
    {
        $this->db->select("*,contentsnews.public,contentsnews.created_date,contentsnews.status");
        $this->db->from('contentsnews');
        $this->db->join('languages','languages.language_id=contentsnews.language_id');
        if($data_type!=null){
            $this->db->where('data_type',$data_type);
        }
        if($relation_id!=null){
            $this->db->where('relation_id',$relation_id);
        }
        $this->db->order_by('contentsnews.Status','DESC');
        $this->db->order_by('contentsnews.created_date','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_newscontents_detail($id)
    {
        $this->db->select('*');
        $this->db->from('contentsnews');
        $this->db->where('contents_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function newscontents_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if(isset($data["public"]) && count($data["public"])!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }

        if($id!=null && $id!=0) // update
        {
            $this->db->where('contents_id',$id);
            $data['updated_date']=date('d/m/Y');
            $this->db->update('contentsnews',$data);
        }
        else    //add
        {
            $data['user_id']=$this->session->userdata['user_id'];
            $data['created_date']=date('d/m/Y');
            $this->db->insert('contentsnews',$data);
            $id=$this->db->insert_id();

        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }



    /* EVENTS CODE */
    
    function get_event($id='', $conditions=[])
    {
        $this->db->select('*');
        $this->db->from('event');
        $this->db->join('eventcontents', 'eventcontents.relation_id=event.event_id',"left");
        $this->db->where('event.event_id', $id);
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

    function manage_events($data=[], $id='')
    {  
        $this->db->trans_start();

        $allowed_inst_ids           = [];
        $save_data                  = [];
        foreach ($_POST['institute_id'] as $key => $value) 
        {
            $allowed_inst_ids[] = $value;
        }

        $save_data = !empty($allowed_inst_ids) ? implode(',', $allowed_inst_ids) : '';


        $allowed_event_type_ids           = [];
        $save_event_type                  = [];
        foreach ($_POST['event_type'] as $key => $value) 
        {
            $allowed_event_type_ids[] = $value;
        }

        $save_event_type = !empty($allowed_event_type_ids) ? implode(',', $allowed_event_type_ids) : '';


        $allowed_audience_type_ids           = [];
        $save_audience_type                  = [];
        foreach ($_POST['audience_type'] as $key => $value) 
        {
            $allowed_audience_type_ids[] = $value;
        }

        $save_audience_type = !empty($allowed_audience_type_ids) ? implode(',', $allowed_audience_type_ids) : '';

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
        }
        unset($data["titles"]);

        if($id)
        {
            if(!empty($this->get_event($id)))
            {
                $update['event_name']               = $data['event_name'];
                $update['event_type']               = $save_event_type;
                $update['audience_type']            = $save_audience_type;
                $update['institute_id']             = $save_data;
                $update['location_id']              = $data['location_id'];
                $update['location_other']           = $data['location_other'];
                $update['featured_event']           = $data['featured_event'];
                $update['sticky_event']             = $data['sticky_event'];
                $update['whats_new']                = $data['whats_new'];
                $update['sportsdisplay']            = $data['sportsdisplay'];
                $update['whats_new_expiry_date']    = $data['whats_new_expiry_date'];
                $update['public']                   = $data['public'];
                $update['created_date']             = date('Y-m-d H:i:s');
                $update['user_id']                  = $this->session->userdata['user_id'];
                $this->db->where('event_id', $id);
                $this->db->update('event', $update);


                $upd['name']             = $this->input->post('event_name');
                $upd['language_id']      = $this->input->post('language_id');
                $upd['description']      = $this->input->post('description');
                $upd['image']            = $this->input->post('image');
                $upd['to_date']          = $this->input->post('to_date');
                $upd['from_date']        = $this->input->post('from_date');
                $upd['public']           = $this->input->post('public');
                $upd['updated_date']     = date('Y-m-d H:i:s');
                $upd['user_id']          = $this->session->userdata['user_id'];
                $this->db->where('contents_id', $data['contents_id']);
                $this->db->update('eventcontents', $upd);


                if(isset($titles)){
                    $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"event"));
                    foreach ($titles as $key=>$value) {
                        if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"event"));
                    }
                }


                if($this->db->affected_rows() > 0)
                {
                    $return = ['error' => 0, 'message' => 'Event successfully updated'];
                }
                else
                {
                    $return = ['error' => 1, 'message' => 'Unable to update Event'];
                }
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Event not found'];
            }
        }
        else
        {   
            $insert['event_name']               = $data['event_name'];
            $insert['event_type']               = $save_event_type;
            $insert['audience_type']            = $save_audience_type;
            $insert['institute_id']             = $save_data;
            $insert['location_id']              = $data['location_id'];
            $insert['location_other']           = $data['location_other'];
            $insert['featured_event']           = $data['featured_event'];
            $insert['sticky_event']             = $data['sticky_event'];
            $insert['whats_new']                = $data['whats_new'];
            $insert['sportsdisplay']            = $data['sportsdisplay'];
            $insert['whats_new_expiry_date']    = $data['whats_new_expiry_date'];
            $insert['public']                   = $data['public'];
            $insert['created_date']             = date('Y-m-d H:i:s');
            $insert['user_id']                  = $this->session->userdata['user_id'];
            $this->db->insert('event', $insert);
            $insert_id = $this->db->insert_id();

            $ins['name']             = $this->input->post('event_name');
            $ins['description']      = $this->input->post('description');
            $ins['relation_id']      = $insert_id;
            $ins['image']            = $this->input->post('image');
            $ins['language_id']      = $this->input->post('language_id');
            $ins['public']           = $this->input->post('public');
            $ins['to_date']          = $this->input->post('to_date');
            $ins['from_date']        = $this->input->post('from_date');
            $ins['data_type']        = $this->input->post('data_type');
            $ins['created_date']     = date('Y-m-d H:i:s');
            $ins['updated_date']     = date('Y-m-d H:i:s');
            $ins['user_id']          = $this->session->userdata['user_id'];
            $this->db->insert('eventcontents', $ins);
            $ins_id = $this->db->insert_id();

            $event_name=$this->input->post('event_name');
            if(isset($titles)){
                $this->db->delete('titles', array("relation_id"=>$insert_id,"data_type"=>"event"));
                foreach ($titles as $key=>$value) {
                    if($key==1) $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$event_name,"relation_id"=>$insert_id,"data_type"=>"event"));
                    else if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$insert_id,"data_type"=>"event"));
                }
            }

            if($insert_id)
            {
                $return = ['error' => 0, 'message' => 'Event successfully added'];
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Unable to add event'];
            }
        }


        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }

        return $return;
    }

    function get_event_location($id)
    {
        if($id == 50){
        $this->db->select("*,event.public as publish");
        $this->db->from('locations');
        $this->db->join('event',"event.location_id=locations.location_id");
		$this->db->order_by("event.event_id", 'DESC');
        $query = $this->db->get();
        return $query->result_array();
        } else {
        $this->db->select("*,event.public as publish");
        $this->db->from('locations');
        $this->db->join('event',"event.location_id=locations.location_id");
        $this->db->where("event.institute_id", $id);
		$this->db->order_by("event.event_id", 'DESC');
        $query = $this->db->get();
        return $query->result_array();
        }
    }



    /* EVENT EVENT_TYPE CODE */


    function get_eventtype()
    {
        $this->db->select("*");
        $this->db->from('event_type');
        $this->db->order_by('event_type_id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
     function get_eventtype_detail($id)
    {
        $this->db->select('*');
        $this->db->from('event_type');
        $this->db->where('event_type_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function eventtype_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if(isset($data['default']) && $data['default']==1)
        {
            $this->db->set('default',0);
            $this->db->update('languages');
        }

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
        }
        unset($data["titles"]);


        if($id!=null) // update
        {
            $this->db->where('event_type_id',$id);
            $this->db->update('event_type',$data);
        }
        else    //add
        {
            $this->db->insert('event_type',$data);
            $id=$this->db->insert_id();

        }

        if(isset($titles)){
            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"event_type"));
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"event_type"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }




    /* EVENT AUDIENCE_TYPE CODE */


    function get_auditype()
    {
        $this->db->select("*");
        $this->db->from('event_audience_type');
        $this->db->order_by('audience_type_id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
     function get_auditype_detail($id)
    {
        $this->db->select('*');
        $this->db->from('event_audience_type');
        $this->db->where('audience_type_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function auditype_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if(isset($data['default']) && $data['default']==1)
        {
            $this->db->set('default',0);
            $this->db->update('languages');
        }

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
        }
        unset($data["titles"]);


        if($id!=null) // update
        {
            $this->db->where('audience_type_id',$id);
            $this->db->update('event_audience_type',$data);
        }
        else    //add
        {
            $this->db->insert('event_audience_type',$data);
            $id=$this->db->insert_id();

        }

        if(isset($titles)){
            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"event_audience_type"));
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"event_audience_type"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }


    
    
    function get_view_user($user_id)
    {
        $this->db->select("*");
        $this->db->from('users');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    // function get_typical_category($id)
    // {
    //     $this->db->select("*");
    //     $this->db->from('category');
    //     $this->db->join('post',"post.category_id=category.category_id");
    //     $this->db->where('institute_id', $id);
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

    function get_typical_category($id)
    {
        $this->db->select("*");
        $this->db->from('post');
        $this->db->where('institute_id', $id);
        $this->db->order_by('post_order','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function delete_image($image_id)
    {
        try {
            $this->db->where('image_id',$image_id)->delete('images');
            return true;
        }

        //catch exception
        catch(Exception $e) {
          echo $e->getMessage();
        }
    }

    function record_count() {
        return $this->db->count_all("images");
        //return $query->result_array();

    }
       public function fetch_images($limit, $start) {
        $this->db->limit($limit, $start);
        $this->db->select("*");
        $this->db->from('images');
        $query = $this->db->get();
        return $query->result_array();;
   }

    function find_image($image_id)
    {
        $row = $this->db->where('image_id',$image_id)->limit(1)->get('images');
        return $row;
    }

    function update_image($image_id, $data)
    {
        try {
            $this->db->where('image_id',$image_id)->delete('images');
            return true;
        }

        //catch exception
        catch(Exception $e) {
          echo $e->getMessage();
        }
    }

      function get_image($image_id)
    {
        $this->db->select("image,name,image_id");
        $this->db->from('images');
        $this->db->where('image_id',$image_id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:0;
    }

    /* Gallery Module Code */

     
    // function upload_image($inputdata,$filename)
    // {
    //   $this->db->insert('galleries', $inputdata); 
    //   $insert_id = $this->db->insert_id();

    //   if($filename!='' ){
    //   $filename1 = explode(',',$filename);
    //   foreach($filename1 as $file){
    //   $file_data = array(
    //   'image' => $file,
    //   'g_id' => $insert_id
    //   );
    //   $this->db->insert('photos', $file_data);
    //   }
    //   }
    // }

    function upload_image($inputdata,$images,$fileNamefeatured)
    {  
      $this->db->insert('galleries', $inputdata); 
      $insert_id = $this->db->insert_id();


      // $this->db->where('g_id', $insert_id);
      // $this->db->update('galleries', array('featured_img' => $fileNamefeatured));

      if(!empty($images)){
      // $filename1 = explode(',',$filename);
      foreach($images as $file){
      $file_data = array(
      'image' => $file['image'],
      'image_name' => $file['name'],
      'image_description' => $file['description'],
      'g_id' => $insert_id
      );
      $this->db->insert('photos', $file_data);
      }
      }
    }

    function view_data($abc){
        if($abc == 50) {
            $query=$this->db->query("SELECT *, inst.public as publish, ud.public as public
                                 FROM galleries ud 
                                 LEFT JOIN edu_institute_dir as inst
                                 ON ud.gallery_for = inst.INST_ID
                                 LEFT JOIN galleries_type as gal 
                                 ON ud.type_id = gal.id 
                                 ORDER BY ud.date DESC");
            return $query->result_array();
        } else {
            $query=$this->db->query("SELECT *, inst.public as publish, ud.public as public
                                 FROM galleries ud 
                                 LEFT JOIN edu_institute_dir as inst
                                 ON ud.gallery_for = inst.INST_ID
                                 LEFT JOIN galleries_type as gal 
                                 ON ud.type_id = gal.id 
                                 WHERE  ud.gallery_for IN ($abc)
                                 ORDER BY ud.date DESC");
            return $query->result_array();
        }
    }

    function edit_data($id){
        $query=$this->db->query("SELECT ud.*
                                 FROM galleries ud 
                                 WHERE ud.g_id = $id");
        return $query->result_array();
    }

    function edit_data_image($id){
        $query=$this->db->query("SELECT *
                                 FROM galleries ud 
                                 RIGHT JOIN photos as photo
                                 ON ud.g_id = photo.g_id 
                                 WHERE ud.g_id = $id");
        return $query->result_array();
    }

    function edit_data_image_delete($deleteid){
        $query=$this->db->query("SELECT galleries.name
                                 FROM galleries ud 
                                 RIGHT JOIN photos as photo
                                 ON ud.g_id = photo.g_id 
                                 WHERE photo.id = $deleteid");
        return $query->result_array();
    }

    function edit_upload_image($user_id,$inputdata,$images,$fileNamefeatured)
    {
        $this->db->where('g_id', $user_id);
        $this->db->update('galleries', $inputdata);

        if(!empty($images)){
            foreach($images as $file){
                $file_data  =    array(
                                      'image' => $file['image'],
                                      'image_name' => $file['name'],
                                      'image_description' => $file['description'],
                                      'g_id' => $user_id
                                    );
                $this->db->insert('photos', $file_data);
            }
        }
    }


    function gallery_count() {
        return $this->db->count_all("galleries");
        //return $query->result_array();

    }

    function delete_gallery($user_id)
    {
        try {
            $this->db->where('g_id',$user_id)->delete('galleries');
            return true;
        }

        //catch exception
        catch(Exception $e) {
          echo $e->getMessage();
        }
    }

    function get_search_gallery($data)
    {
        $this->db->select("*");
        $this->db->from('galleries');
        foreach ($data as $key=>$value) {
            $this->db->where($key,$value);
        }
        $this->db->order_by('g_id','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }



    /* Gallery Types CODE */


    function get_galtype()
    {
        $this->db->select("*");
        $this->db->from('galleries_type');
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
     function get_galtype_detail($id)
    {
        $this->db->select('*');
        $this->db->from('galleries_type');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function galtype_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if(isset($data['default']) && $data['default']==1)
        {
            $this->db->set('default',0);
            $this->db->update('languages');
        }

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
        }
        unset($data["titles"]);

        if(isset($data["public"]) && count($data["public"])!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }

        if($id!=null) // update
        {
            $this->db->where('id',$id);
            $this->db->update('galleries_type',$data);
        }
        else    //add
        {
            $this->db->insert('galleries_type',$data);
            $id=$this->db->insert_id();

        }

        if(isset($titles)){
            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"galleries_type"));
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"galleries_type"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }


    function get_gallerytype($abc)
    {
        $this->db->select("*");
        $this->db->from('institute_galleries_type');
        $this->db->join('galleries_type',"FIND_IN_SET(galleries_type.id,institute_galleries_type.type_id)",'left');
        $this->db->where('institute_galleries_type.institute_id', $abc);
        $this->db->order_by('institute_galleries_type.ig_id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /* ANNOUNCEMENTS CODE */

    
    function get_announcement($id='', $conditions=[])
    {
        $this->db->select('*,announcement.title as name');
        $this->db->from('announcement');
        $this->db->join('contentsannouncement', 'contentsannouncement.relation_id=announcement.announcement_id');
        $this->db->where('announcement.announcement_id', $id);
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

    function manage_announcement($data=[], $id='')
    {  
        $this->db->trans_start();

        $allowed_inst_ids           = [];
        $save_data                  = [];
        foreach ($_POST['institute_id'] as $key => $value) 
        {
            $allowed_inst_ids[] = $value;
        }

        $save_data = !empty($allowed_inst_ids) ? implode(',', $allowed_inst_ids) : '';


        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
        }
        unset($data["titles"]);

        if($id)
        {
            if(!empty($this->get_announcement($id)))
            {
                $update['title']                    = $data['name'];
                $update['category_id']              = $data['category_id'];
                $update['institute_id']             = $save_data;
                $update['whats_new']                = $data['whats_new'];
                $update['whats_new_expiry_date']    = $data['whats_new_expiry_date'];
                $update['public']                   = $data['public'];
                $update['created_date']             = date('Y-m-d H:i:s');
                $update['user_id']                  = $this->session->userdata['user_id'];
                $this->db->where('announcement_id', $id);
                $this->db->update('announcement', $update);


                $upd['title']            = $this->input->post('name');
                $upd['language_id']      = $this->input->post('language_id');
                $upd['description']      = $this->input->post('description');
                $upd['image']            = $this->input->post('image');
                $upd['persons']          = $this->input->post('persons');
                $upd['date']             = $this->input->post('date');
                $upd['public']           = $this->input->post('public');
                $upd['updated_date']     = date('Y-m-d H:i:s');
                $upd['user_id']          = $this->session->userdata['user_id'];
                $this->db->where('contents_id', $data['contents_id']);
                $this->db->update('contentsannouncement', $upd);


                if(isset($titles)){
                    $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"announcement"));
                    foreach ($titles as $key=>$value) {
                        if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"announcement"));
                    }
                }

                if($this->db->affected_rows() > 0)
                {
                    $return = ['error' => 0, 'message' => 'Announcement successfully updated'];
                }
                else
                {
                    $return = ['error' => 1, 'message' => 'Unable to update Announcement'];
                }
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Announcement not found'];
            }
        }
        else
        {   
            $insert['title']                    = $data['name'];
            $insert['institute_id']             = $save_data;
            $insert['category_id']              = $data['category_id'];
            $insert['whats_new']                = $data['whats_new'];
            $insert['whats_new_expiry_date']    = $data['whats_new_expiry_date'];
            $insert['public']                   = $data['public'];
            $insert['created_date']             = date('Y-m-d H:i:s');
            $insert['user_id']                  = $this->session->userdata['user_id'];
            $this->db->insert('announcement', $insert);
            $insert_id = $this->db->insert_id();

            $ins['title']            = $this->input->post('name');
            $ins['description']      = $this->input->post('description');
            $ins['relation_id']      = $insert_id;
            $ins['image']            = $this->input->post('image');
            $ins['language_id']      = $this->input->post('language_id');
            $ins['public']           = $this->input->post('public');
            $ins['date']             = $this->input->post('date');
            $ins['persons']          = $this->input->post('persons');
            $ins['data_type']        = $this->input->post('data_type');
            $ins['created_date']     = date('Y-m-d H:i:s');
            $ins['updated_date']     = date('Y-m-d H:i:s');
            $ins['user_id']          = $this->session->userdata['user_id'];
            $this->db->insert('contentsannouncement', $ins);
            $ins_id = $this->db->insert_id();


            $name=$this->input->post('name');
            if(isset($titles)){
                $this->db->delete('titles', array("relation_id"=>$insert_id,"data_type"=>"announcement"));
                foreach ($titles as $key=>$value) {
                    if($key==1) $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$name,"relation_id"=>$insert_id,"data_type"=>"announcement"));
                    else if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$insert_id,"data_type"=>"announcement"));
                }
            }


            if($insert_id)
            {
                $return = ['error' => 0, 'message' => 'Announcement successfully added'];
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Unable to add Announcement'];
            }
        }


        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }

        return $return;
    }

    function get_announcement_location($id)
    {
        if($id == 50){
        $this->db->select("*,GROUP_CONCAT(edu_institute_dir.INST_NAME) AS institute_namenew,announcement.title as name, announcement.public as publish");
        $this->db->from('announcement');
        $this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID,announcement.institute_id)",'left');
        $this->db->join('category',"category.category_id=announcement.category_id");
        $this->db->group_by("announcement.announcement_id");
        $this->db->order_by('announcement.announcement_id','DESC');
        $query = $this->db->get();
        return $query->result_array();
        } else {
            $this->db->select("*,GROUP_CONCAT(edu_institute_dir.INST_NAME) AS institute_namenew,announcement.title as name, announcement.public as publish");
            $this->db->from('announcement');
            $this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID,announcement.institute_id)",'left');
            $this->db->join('category',"category.category_id=announcement.category_id");
            $this->db->where("announcement.institute_id", $id);
            $this->db->group_by("announcement.announcement_id");
            $this->db->order_by('announcement.announcement_id','DESC');
            $query = $this->db->get();
            return $query->result_array();
        }
    }



    /* PRESS REALEASE CODE */
    
    function get_pressrelease($id='', $conditions=[])
    {
        $this->db->select('*,pressrelease.title as name');
        $this->db->from('pressrelease');
        $this->db->join('contentspressrelease', 'contentspressrelease.relation_id=pressrelease.pressrelease_id');
        $this->db->where('pressrelease.pressrelease_id', $id);
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

    function manage_pressrelease($data=[], $id='')
    {  
        $this->db->trans_start();

        $allowed_inst_ids           = [];
        $save_data                  = [];
        foreach ($_POST['institute_id'] as $key => $value) 
        {
            $allowed_inst_ids[] = $value;
        }

        $save_data = !empty($allowed_inst_ids) ? implode(',', $allowed_inst_ids) : '';


        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
        }
        unset($data["titles"]);

        if($id)
        {
            if(!empty($this->get_pressrelease($id)))
            {
                $update['title']                    = $data['name'];
                $update['category_id']              = $data['category_id'];
                $update['institute_id']             = $save_data;
                $update['date']                     = $this->input->post('date');
                $update['whats_new']                = $data['whats_new'];
                $update['whats_new_expiry_date']    = $data['whats_new_expiry_date'];
                $update['public']                   = $data['public'];
                $update['created_date']             = date('Y-m-d H:i:s');
                $update['user_id']                  = $this->session->userdata['user_id'];
                $this->db->where('pressrelease_id', $id);
                $this->db->update('pressrelease', $update);


                $upd['title']            = $this->input->post('name');
                $upd['language_id']      = $this->input->post('language_id');
                $upd['description']      = $this->input->post('description');
                $upd['persons']          = $this->input->post('persons');
                $upd['public']           = $this->input->post('public');
                $upd['updated_date']     = date('Y-m-d H:i:s');
                $upd['user_id']          = $this->session->userdata['user_id'];
                $this->db->where('contents_id', $data['contents_id']);
                $this->db->update('contentspressrelease', $upd);

                if(isset($titles)){
                    $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"pressrelease"));
                    foreach ($titles as $key=>$value) {
                        if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"pressrelease"));
                    }
                }

                if($this->db->affected_rows() > 0)
                {
                    $return = ['error' => 0, 'message' => 'Pressrelease successfully updated'];
                }
                else
                {
                    $return = ['error' => 1, 'message' => 'Unable to update Pressrelease'];
                }
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Pressrelease not found'];
            }
        }
        else
        {   
            $insert['title']                    = $data['name'];
            $insert['institute_id']             = $save_data;
            $insert['category_id']              = $data['category_id'];
            $insert['whats_new']                = $data['whats_new'];
            $insert['whats_new_expiry_date']    = $data['whats_new_expiry_date'];
            $insert['date']                     = $this->input->post('date');
            $insert['public']                   = $data['public'];
            $insert['created_date']             = date('Y-m-d H:i:s');
            $insert['user_id']                  = $this->session->userdata['user_id'];
            $this->db->insert('pressrelease', $insert);
            $insert_id = $this->db->insert_id();

            $ins['title']            = $this->input->post('name');
            $ins['description']      = $this->input->post('description');
            $ins['relation_id']      = $insert_id;
            $ins['language_id']      = $this->input->post('language_id');
            $ins['public']           = $this->input->post('public');
            $ins['persons']          = $this->input->post('persons');
            $ins['data_type']        = $this->input->post('data_type');
            $ins['created_date']     = date('Y-m-d H:i:s');
            $ins['updated_date']     = date('Y-m-d H:i:s');
            $ins['user_id']          = $this->session->userdata['user_id'];
            $this->db->insert('contentspressrelease', $ins);
            $ins_id = $this->db->insert_id();


            $name=$this->input->post('name');
            if(isset($titles)){
                $this->db->delete('titles', array("relation_id"=>$insert_id,"data_type"=>"pressrelease"));
                foreach ($titles as $key=>$value) {
                    if($key==1) $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$name,"relation_id"=>$insert_id,"data_type"=>"pressrelease"));
                    else if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$insert_id,"data_type"=>"pressrelease"));
                }
            }


            if($insert_id)
            {
                $return = ['error' => 0, 'message' => 'Pressrelease successfully added'];
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Unable to add Pressrelease'];
            }
        }


        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }

        return $return;
    }
    
    function get_pressrelease_location($id)
    {
        if($id == 50){
        $this->db->select("*,GROUP_CONCAT(edu_institute_dir.INST_NAME) AS institute_namenew,pressrelease.title as name, pressrelease.public as publish");
        $this->db->from('pressrelease');
        $this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID,pressrelease.institute_id)",'left');
        $this->db->join('category',"category.category_id=pressrelease.category_id");
        $this->db->group_by("pressrelease.pressrelease_id");
        $this->db->order_by('pressrelease.pressrelease_id','DESC');
        $query = $this->db->get();
        return $query->result_array();        
        } else {
            $this->db->select("*,pressrelease.title as name, pressrelease.public as publish");
            $this->db->from('pressrelease');
            $this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID,pressrelease.institute_id)",'left');
            $this->db->join('category',"category.category_id=pressrelease.category_id");
            $this->db->where("pressrelease.institute_id", $id);
            $this->db->group_by("pressrelease.pressrelease_id");
            $this->db->order_by('pressrelease.pressrelease_id','DESC');
            $query = $this->db->get();
            return $query->result_array();
        }
    }


    /* MEDIA COVERAGE CODE */

    
    function get_mediacoverage($id='', $conditions=[])
    {
        $this->db->select('*,mediacoverage.title as name');
        $this->db->from('mediacoverage');
        $this->db->join('contentsmediacoverage', 'contentsmediacoverage.relation_id=mediacoverage.mediacoverage_id');
        $this->db->where('mediacoverage.mediacoverage_id', $id);
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

    function manage_mediacoverage($data=[], $id='')
    {  
        $this->db->trans_start();

        $allowed_inst_ids           = [];
        $save_data                  = [];
        foreach ($_POST['institute_id'] as $key => $value) 
        {
            $allowed_inst_ids[] = $value;
        }

        $save_data = !empty($allowed_inst_ids) ? implode(',', $allowed_inst_ids) : '';


        $allowed_cat_ids           = [];
        $save_cat                  = [];
        foreach ($_POST['category_id'] as $key => $value) 
        {
            $allowed_cat_ids[] = $value;
        }

        $save_cat = !empty($allowed_cat_ids) ? implode(',', $allowed_cat_ids) : '';


        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
        }
        unset($data["titles"]);

        if($id)
        {
            if(!empty($this->get_mediacoverage($id)))
            {
                $update['title']                    = $data['name'];
                // $update['category_id']              = $data['category_id'];
                $update['category_id']              = $save_cat;
                $update['type']                     = $data['type'];
                $update['source']                   = $data['source'];
                $update['institute_id']             = $save_data;
                $update['link_to_epaper']           = $data['link_to_epaper'];
                $update['whats_new']                = $data['whats_new'];
                $update['whats_new_expiry_date']    = $data['whats_new_expiry_date'];
                $update['public']                   = $data['public'];
                $update['created_date']             = date('Y-m-d H:i:s');
                $update['user_id']                  = $this->session->userdata['user_id'];
                $this->db->where('mediacoverage_id', $id);
                $this->db->update('mediacoverage', $update);


                $upd['title']            = $this->input->post('name');
                $upd['language_id']      = $this->input->post('language_id');
                $upd['description']      = $this->input->post('description');
                $upd['persons']          = $this->input->post('persons');
                $upd['date']             = $this->input->post('date');
                $upd['public']           = $this->input->post('public');
                $upd['updated_date']     = date('Y-m-d H:i:s');
                $upd['user_id']          = $this->session->userdata['user_id'];
                $this->db->where('contents_id', $data['contents_id']);
                $this->db->update('contentsmediacoverage', $upd);

                if(isset($titles)){
                    $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"mediacoverage"));
                    foreach ($titles as $key=>$value) {
                        if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"mediacoverage"));
                    }
                }

                if($this->db->affected_rows() > 0)
                {
                    $return = ['error' => 0, 'message' => 'Mediacoverage successfully updated'];
                }
                else
                {
                    $return = ['error' => 1, 'message' => 'Unable to update Mediacoverage'];
                }
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Mediacoverage not found'];
            }
        }
        else
        {   
            $insert['title']                    = $data['name'];
            $insert['institute_id']             = $save_data;
            // $insert['category_id']              = $data['category_id'];
            $insert['category_id']              = $save_cat;
            $insert['type']                     = $data['type'];
            $insert['source']                   = $data['source'];
            $insert['link_to_epaper']           = $data['link_to_epaper'];
            $insert['whats_new']                = $data['whats_new'];
            $insert['whats_new_expiry_date']    = $data['whats_new_expiry_date'];
            $insert['public']                   = $data['public'];
            $insert['created_date']             = date('Y-m-d H:i:s');
            $insert['user_id']                  = $this->session->userdata['user_id'];
            $this->db->insert('mediacoverage', $insert);
            $insert_id = $this->db->insert_id();

            $ins['title']            = $this->input->post('name');
            $ins['description']      = $this->input->post('description');
            $ins['relation_id']      = $insert_id;
            $ins['language_id']      = $this->input->post('language_id');
            $ins['public']           = $this->input->post('public');
            $ins['persons']          = $this->input->post('persons');
            $ins['date']             = $this->input->post('date');
            $ins['data_type']        = $this->input->post('data_type');
            $ins['created_date']     = date('Y-m-d H:i:s');
            $ins['updated_date']     = date('Y-m-d H:i:s');
            $ins['user_id']          = $this->session->userdata['user_id'];
            $this->db->insert('contentsmediacoverage', $ins);
            $ins_id = $this->db->insert_id();


            $name=$this->input->post('name');
            if(isset($titles)){
                $this->db->delete('titles', array("relation_id"=>$insert_id,"data_type"=>"mediacoverage"));
                foreach ($titles as $key=>$value) {
                    if($key==1) $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$name,"relation_id"=>$insert_id,"data_type"=>"mediacoverage"));
                    else if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$insert_id,"data_type"=>"mediacoverage"));
                }
            }
            

            if($insert_id)
            {
                $return = ['error' => 0, 'message' => 'Mediacoverage successfully added'];
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Unable to add Mediacoverage'];
            }
        }


        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }

        return $return;
    }

    // function get_mediacoverage_location($id)
    // {
    //     if($id == 50){
    //     $this->db->select("*,GROUP_CONCAT(edu_institute_dir.INST_NAME) AS institute_namenew,mediacoverage.title as name, mediacoverage.public as publish");
    //     $this->db->from('mediacoverage');
    //     $this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID,mediacoverage.institute_id)",'left');
    //     $this->db->join('category',"category.category_id=mediacoverage.category_id");
    //     $this->db->join('mediacoverage_source',"mediacoverage_source.id=mediacoverage.source");
    //     $this->db->group_by("mediacoverage.mediacoverage_id");
    //     $this->db->order_by('mediacoverage.mediacoverage_id','DESC');
    //     $query = $this->db->get();
    //     return $query->result_array();
    //     } else {
    //         $this->db->select("*,mediacoverage.title as name, mediacoverage.public as publish");
    //         $this->db->from('mediacoverage');
    //         $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=mediacoverage.institute_id",'left');
    //         $this->db->join('category',"category.category_id=mediacoverage.category_id");
    //         $this->db->join('mediacoverage_source',"mediacoverage_source.id=mediacoverage.source");
    //         $this->db->where("mediacoverage.institute_id", $id);
    //         $this->db->group_by("mediacoverage.mediacoverage_id");
    //         $this->db->order_by('mediacoverage.mediacoverage_id','DESC');
    //         $query = $this->db->get();
    //         return $query->result_array();
    //     }
    // }

    function get_mediacoverage_location($id)
    {
        if($id == 50){
        $this->db->select("*,GROUP_CONCAT(DISTINCT(edu_institute_dir.INST_NAME)) AS institute_namenew,GROUP_CONCAT(DISTINCT(category.category_name)) AS category_namenew,mediacoverage.title as name, mediacoverage.public as publish");
        $this->db->from('mediacoverage');
        $this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID,mediacoverage.institute_id)",'left');
        $this->db->join('category',"FIND_IN_SET(category.category_id,mediacoverage.category_id)",'left');
        $this->db->join('mediacoverage_source',"mediacoverage_source.id=mediacoverage.source");
        $this->db->group_by("mediacoverage.mediacoverage_id");
        $this->db->order_by('mediacoverage.mediacoverage_id','DESC');
        $query = $this->db->get();
        return $query->result_array();
        } else {
            $this->db->select("*,GROUP_CONCAT(DISTINCT(edu_institute_dir.INST_NAME)) AS institute_namenew,GROUP_CONCAT(DISTINCT(category.category_name)) AS category_namenew,mediacoverage.title as name, mediacoverage.public as publish");
            $this->db->from('mediacoverage');
            $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=mediacoverage.institute_id",'left');
            $this->db->join('category',"FIND_IN_SET(category.category_id,mediacoverage.category_id)",'left');
            $this->db->join('mediacoverage_source',"mediacoverage_source.id=mediacoverage.source");
            $this->db->where("mediacoverage.institute_id", $id);
            $this->db->group_by("mediacoverage.mediacoverage_id");
            $this->db->order_by('mediacoverage.mediacoverage_id','DESC');
            $query = $this->db->get();
            return $query->result_array();
        }
    }

    /* MEDIA COVERAGE SOURCE TYPE CODE */


    function get_source()
    {
        $this->db->select("*");
        $this->db->from('mediacoverage_source');
		$this->db->where('public',1);
        //$this->db->order_by('id','ASC');
		$this->db->order_by('source_name','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
     function get_source_detail($id)
    {
        $this->db->select('*');
        $this->db->from('mediacoverage_source');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function source_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if(isset($data['default']) && $data['default']==1)
        {
            $this->db->set('default',0);
            $this->db->update('languages');
        }

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
        }
        unset($data["titles"]);

        if(isset($data["public"]) && count($data["public"])!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }

        if($id!=null) // update
        {
            $this->db->where('id',$id);
            $this->db->update('mediacoverage_source',$data);
        }
        else    //add
        {
            $this->db->insert('mediacoverage_source',$data);
            $id=$this->db->insert_id();

        }

        if(isset($titles)){
            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"mediacoverage_source"));
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"mediacoverage_source"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    

                /* PUBLICATION CODE */
    
    function get_all_publication()
    {
        $this->db->select("*");
        $this->db->from('publication');
        $this->db->order_by('publication_order','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
     function get_publication_detail($id)
    {
        $this->db->select('*');
        $this->db->from('publication');
        $this->db->where('publication_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function publication_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if(isset($data['default']) && $data['default']==1)
        {
            $this->db->set('default',0);
            $this->db->update('languages');
        }

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
        }
        unset($data["titles"]);

        if(isset($data["public"]) && count($data["public"])!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }

        if($id!=null) // update
        {
            $this->db->where('publication_id',$id);
            $this->db->update('publication',$data);
        }
        else    //add
        {
            $data['created_date']=date('d/m/Y');
            $this->db->insert('publication',$data);
            $id=$this->db->insert_id();

        }

        if(isset($titles)){
            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"publication"));
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"publication"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    function get_all_publication_inst($id)
    {
        if($id == 50){
            $this->db->select("*");
            $this->db->from('publication');
            $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=publication.institute_id",'left');
            $this->db->order_by('publication.publication_id','DESC');
            $query = $this->db->get();
            return $query->result_array();
        } else {
            $this->db->select("*");
            $this->db->from('publication');
            $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=publication.institute_id",'left');
            $this->db->where('publication.institute_id', $id);
            $this->db->order_by('publication.publication_id','DESC');
            $query = $this->db->get();
            return $query->result_array();
        }
    }


    /* PUBLICATION CONTENTS CODE */

    function get_all_publicationcontents($data_type=null,$relation_id=null)
    {
        $this->db->select("*,contentspublication.public,contentspublication.created_date,contentspublication.status");
        $this->db->from('contentspublication');
        $this->db->join('languages','languages.language_id=contentspublication.language_id');
        if($data_type!=null){
            $this->db->where('data_type',$data_type);
        }
        if($relation_id!=null){
            $this->db->where('relation_id',$relation_id);
        }
        $this->db->order_by('contentspublication.Status','DESC');
        $this->db->order_by('contentspublication.created_date','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_publicationcontents_detail($id)
    {
        $this->db->select('*');
        $this->db->from('contentspublication');
        $this->db->where('contents_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function publicationcontents_manipulate($data,$id=null)
    {
        // print_r($data['coauthor_array']);
        // exit;
        $this->db->trans_start();

        if(isset($data["public"]) && count($data["public"])!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }

        if($id!=null && $id!=0) // update
        {
            // $this->db->where('contents_id',$id);
            // $data['updated_date']=date('d/m/Y');
            // $this->db->update('contentspublication',$data);


            $title = $this->input->post('data[title]');           
            $keywords = $this->input->post('data[keywords]');           
            $language_id = $this->input->post('data[language_id]'); 
            $fautherFname = $this->input->post('data[fautherFname]');
            $fautherMname = $this->input->post('data[fautherMname]');
            $fautherLname = $this->input->post('data[fautherLname]');
            $fautherStaffID = $this->input->post('data[fautherStaffID]');

            $corautherFname = $this->input->post('data[corautherFname]');          
            $corautherMname = $this->input->post('data[corautherMname]');
            $corautherLname = $this->input->post('data[corautherLname]');
            $corautherStaffID = $this->input->post('data[corautherStaffID]');
            $corautherEmail = $this->input->post('data[corautherEmail]');
            $publication_name = $this->input->post('data[publication_name]');
            $year = $this->input->post('data[year]');
            $volume = $this->input->post('data[volume]');
            $Page_nos = $this->input->post('data[Page_nos]');
            $ISSN_no = $this->input->post('data[ISSN_no]');
            $DOI = $this->input->post('data[DOI]');
            $journal_ranking = $this->input->post('data[journal_ranking]');
            $public = $this->input->post('data[public]');
            $relation_id = $this->input->post('data[relation_id]');
            $data_type = $this->input->post('data[data_type]');
            $user_id = $this->session->userdata['user_id'];
            $public12 = $this->input->post('data[public]');
            if(isset($public12) && count($public12)!=0){
            $public12=1;
            } else {
                $public12=0;
            }
            $public =$public12;

            $data3 = array( 
            'title' =>  $title,
            'keywords' =>  $keywords,
            'language_id' =>  $language_id,
            'fautherFname' =>  $fautherFname,
            'fautherMname' =>  $fautherMname,
            'fautherLname' =>  $fautherLname,
            'fautherStaffID' =>  $fautherStaffID, 
            'corautherFname' => $corautherFname,
            'corautherMname' =>  $corautherMname,
            'corautherLname' =>  $corautherLname,
            'corautherStaffID' =>  $corautherStaffID,
            'corautherEmail' =>  $corautherEmail,
            'publication_name' =>  $publication_name,
            'year' =>  $year,
            'volume' =>  $volume, 
            'Page_nos' => $Page_nos,
            'ISSN_no' =>  $ISSN_no,
            'DOI' =>  $DOI,
            'journal_ranking' =>  $journal_ranking,
            'public' =>  $public,
            'relation_id' =>  $relation_id,
            'data_type' =>  $data_type,
            'user_id' => $user_id,
            'public' => $public
            );

            $this->db->where('contents_id',$id);
            $data['updated_date']=date('d/m/Y');
            $this->db->update('contentspublication',$data3);

            $coautherFname = $this->input->post('data[coautherFname]');
            $coautherMname = $this->input->post('data[coautherMname]');
            $coautherLname = $this->input->post('data[coautherLname]');
            $coautherStaffID = $this->input->post('data[coautherStaffID]');
            $rel_id = $relation_id;
            $id2 = $this->input->post('data[id2]');

            if($id2 == ''){ //print_r("expression");exit();
                // $rr = $data['coauthor_array'];
                // print_r($rr);
                // exit();
                $i=0;
            foreach($data['coauthor_array'] as $result){ 
                
                // print_r($result['coautherFname']);
                // exit();
                // insert statement
                $this->db->insert('publication_coauthor',array("coautherFname"=>$result['coautherFname'],"coautherMname"=>$result['coautherMname'],"coautherLname"=>$result['coautherLname'],"coautherStaffID"=>$result['coautherStaffID'],"rel_id"=>$rel_id));

                // $sql = "INSERT INTO publication_coauthor(coautherFname, coautherMname, coautherLname, coautherStaffID, rel_id) VALUES(".$result['coautherFname'].", ".$result['coautherMname'].", ".$result['coautherLname'].", ".$result['coautherStaffID'].", ".$rel_id.")";
                    // mysqli_query($sql);
                // print_r($sql);
                $i++;
             
              }
// exit();

            } else {  //print_r("dfdf");exit();

                    $i=0;
                    foreach($data['coauthor_array'] as $result){ 
                        

                        // update statement
                        // $this->db->where('id',$id);
                        // $this->db->update('publication_coauthor',$result[$i]['coautherFname']);

                        $this->db->where('id',$id2);
                        $this->db->update('publication_coauthor',array("coautherFname"=>$result['coautherFname'],"coautherMname"=>$result['coautherMname'],"coautherLname"=>$result['coautherLname'],"coautherStaffID"=>$result['coautherStaffID'],"rel_id"=>$rel_id)); 

                        $i++;
                     
                      }
            }
        }
        else    //add
        {
            // $data['user_id']=$this->session->userdata['user_id'];
            // $data['created_date']=date('d/m/Y');
            // $this->db->insert('contentspublication',$data);
            // $id=$this->db->insert_id();


            $title = $this->input->post('data[title]');           
            $keywords = $this->input->post('data[keywords]');           
            $language_id = $this->input->post('data[language_id]'); 
            $fautherFname = $this->input->post('data[fautherFname]');
            $fautherMname = $this->input->post('data[fautherMname]');
            $fautherLname = $this->input->post('data[fautherLname]');
            $fautherStaffID = $this->input->post('data[fautherStaffID]');

            $corautherFname = $this->input->post('data[corautherFname]');          
            $corautherMname = $this->input->post('data[corautherMname]');
            $corautherLname = $this->input->post('data[corautherLname]');
            $corautherStaffID = $this->input->post('data[corautherStaffID]');
            $corautherEmail = $this->input->post('data[corautherEmail]');
            $publication_name = $this->input->post('data[publication_name]');
            $year = $this->input->post('data[year]');
            $volume = $this->input->post('data[volume]');
            $Page_nos = $this->input->post('data[Page_nos]');
            $ISSN_no = $this->input->post('data[ISSN_no]');
            $DOI = $this->input->post('data[DOI]');
            $journal_ranking = $this->input->post('data[journal_ranking]');
            $public = $this->input->post('data[public]');
            $relation_id = $this->input->post('data[relation_id]');
            $data_type = $this->input->post('data[data_type]');
            $user_id = $this->session->userdata['user_id'];
            $public12 = $this->input->post('data[public]');
            if(isset($public12) && count($public12)!=0){
            $public12=1;
            } else {
                $public12=0;
            }
            $public =$public12;

            $data3 = array( 
            'title' =>  $title,
            'keywords' =>  $keywords,
            'language_id' =>  $language_id,
            'fautherFname' =>  $fautherFname,
            'fautherMname' =>  $fautherMname,
            'fautherLname' =>  $fautherLname,
            'fautherStaffID' =>  $fautherStaffID, 
            'corautherFname' => $corautherFname,
            'corautherMname' =>  $corautherMname,
            'corautherLname' =>  $corautherLname,
            'corautherStaffID' =>  $corautherStaffID,
            'corautherEmail' =>  $corautherEmail,
            'publication_name' =>  $publication_name,
            'year' =>  $year,
            'volume' =>  $volume, 
            'Page_nos' => $Page_nos,
            'ISSN_no' =>  $ISSN_no,
            'DOI' =>  $DOI,
            'journal_ranking' =>  $journal_ranking,
            'public' =>  $public,
            'relation_id' =>  $relation_id,
            'data_type' =>  $data_type,
            'user_id' => $user_id,
            'public' => $public
            );

            // print_r($data);
            $data['created_date']=date('d/m/Y');
            $this->db->insert('contentspublication',$data3);
            $id=$this->db->insert_id();

            $coautherFname = $this->input->post('data[coautherFname]');
            $coautherMname = $this->input->post('data[coautherMname]');
            $coautherLname = $this->input->post('data[coautherLname]');
            $coautherStaffID = $this->input->post('data[coautherStaffID]');
            $rel_id = $relation_id;


            // print_r($data['coauthor_array']);
            // exit();
            $i=0;
            foreach($data['coauthor_array'] as $result){ 
                
                // print_r($result['coautherFname']);
                // exit();
                // insert statement
                $this->db->insert('publication_coauthor',array("coautherFname"=>$result['coautherFname'],"coautherMname"=>$result['coautherMname'],"coautherLname"=>$result['coautherLname'],"coautherStaffID"=>$result['coautherStaffID'],"rel_id"=>$rel_id));

                // $sql = "INSERT INTO publication_coauthor(coautherFname, coautherMname, coautherLname, coautherStaffID, rel_id) VALUES(".$result['coautherFname'].", ".$result['coautherMname'].", ".$result['coautherLname'].", ".$result['coautherStaffID'].", ".$rel_id.")";
                    // mysqli_query($sql);
                // print_r($sql);
                $i++;
             
              } //exit();

        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }


    
    function get_all_coauthor($relation_id)
    {
        $this->db->select('*');
        $this->db->from('publication_coauthor');
        $this->db->where('rel_id', $relation_id);
        $query = $this->db->get();
        return  $query->result_array();
        // return count($return)!=0?$return[0]:null;
    }




        /* PROGRAM & DETAILS CODE */

         function get_all_institute_program()
        {

        $this->db->select('DISTINCT(edu_map_course_head.INST_ID) AS institute_id , edu_institute_dir.INST_NAME as INST_NAME, edu_institute_dir.INST_SHORTNAME as INST_SHORTNAME');
        $this->db->from('edu_map_course_head');
        $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=edu_map_course_head.INST_ID",'left');
        $this->db->where('edu_institute_dir.INST_ID !=',NULL);  
        $this->db->group_by("edu_map_course_head.MAP_COURSE_ID");
        $this->db->order_by("edu_institute_dir.INST_NAME","DESC");
        $query = $this->db->get();
        return $query->result_array();
        }

    
        function get_all_program()
    {
        // $this->db->select("*");
        // $this->db->from('edu_map_course_class_head');
        // $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=edu_map_course_class_head.MAP_CO_INST_ID",'left'); 
        // $this->db->join('edu_course_dir',"edu_course_dir.COURSE_ID=edu_map_course_class_head.MAP_CO_COURSE_ID",'left');
        // $this->db->join('edu_stream_dir',"edu_stream_dir.STREAM_ID=edu_map_course_class_head.MAP_CO_STREAM_ID",'left');
        // $this->db->join('edu_class_dir',"edu_class_dir.CLASS_ID=edu_map_course_class_head.MAP_CO_CLASS_ID",'left'); 
        // $this->db->order_by('MAP_CO_ID','ASC');
        // $query = $this->db->get();
        // return $query->result_array();

        $this->db->select('*');
        $this->db->from('edu_map_course_head');
        $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=edu_map_course_head.INST_ID",'left'); 
        $this->db->join('edu_course_dir',"edu_course_dir.COURSE_ID=edu_map_course_head.COURSE_ID",'left');
        $this->db->join('edu_stream_dir',"edu_stream_dir.STREAM_ID=edu_map_course_head.AREA_OF_STUDY_ID",'left');
        $this->db->where('edu_map_course_head.public',1);
        $this->db->order_by('edu_map_course_head.MAP_COURSE_ID','DESC');
        $query = $this->db->get();
        return $query->result_array();


    }
     function get_program_detail($id)
    {
        $this->db->select('*');
        $this->db->from('edu_map_course_head');
        $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=edu_map_course_head.INST_ID",'left'); 
        $this->db->join('edu_course_dir',"edu_course_dir.COURSE_ID=edu_map_course_head.COURSE_ID",'left');
        $this->db->join('edu_stream_dir',"edu_stream_dir.STREAM_ID=edu_map_course_head.AREA_OF_STUDY_ID",'left');
        $this->db->where('MAP_COURSE_ID', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function program_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if(isset($data['default']) && $data['default']==1)
        {
            $this->db->set('default',0);
            $this->db->update('languages');
        }

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
        }
        unset($data["titles"]);

        if(isset($data["public"]) && count($data["public"])!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }

        if($id!=null) // update
        {
            $this->db->where('MAP_COURSE_ID',$id);
            $this->db->update('edu_map_course_head',$data);
        }
        else    //add
        {
            $data['created_date']=date('d/m/Y');
            $this->db->insert('edu_map_course_head',$data);
            $id=$this->db->insert_id();

        }

        if(isset($titles)){
            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"program"));
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"program"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }


    function get_all_program_inst($id='')
    {
        if($id == 50){
            $this->db->select("*,edu_map_course_head.COURSE_CODE as coursecode");
            $this->db->from('edu_map_course_head');
            // $this->db->join('program_contents',"program_contents.relation_id=edu_map_course_head.MAP_COURSE_ID",'left');
            $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=edu_map_course_head.INST_ID",'left');
            $this->db->join('edu_course_dir',"edu_course_dir.COURSE_ID=edu_map_course_head.COURSE_ID",'left');
            $this->db->where('edu_map_course_head.public',1);
            $this->db->order_by('edu_course_dir.COURSE_NAME','ASC');
            $query = $this->db->get();
            return $query->result_array();
        } else {
            $this->db->select("*,edu_map_course_head.COURSE_CODE as coursecode");
            $this->db->from('edu_map_course_head');
            // $this->db->join('program_contents',"program_contents.relation_id=edu_map_course_head.MAP_COURSE_ID",'left');
            $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=edu_map_course_head.INST_ID",'left');
            $this->db->join('edu_course_dir',"edu_course_dir.COURSE_ID=edu_map_course_head.COURSE_ID",'left');
            $this->db->where('edu_map_course_head.INST_ID', $id);
            $this->db->where('edu_map_course_head.public',1);
            $this->db->order_by('edu_course_dir.COURSE_NAME','ASC');
            $query = $this->db->get();
            return $query->result_array();
        }
        
    }

    /* PROGRAM & DETAILS CONTENTS CODE */

    function get_all_programcontents($data_type=null,$relation_id=null)
    {
        $this->db->select("*,program_contents.public,program_contents.created_date");
        $this->db->from('program_contents');
        $this->db->join('languages','languages.language_id=program_contents.language_id');
        if($data_type!=null){
            $this->db->where('data_type',$data_type);
        }
        if($relation_id!=null){
            $this->db->where('relation_id',$relation_id);
        }
        $this->db->order_by('program_contents.created_date','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_programcontents_detail($id)
    {
        $this->db->select('*,program_contents.relation_id,program_widgets.relation_id as relation');
        $this->db->from('edu_map_course_head');
        $this->db->join('program_contents','program_contents.relation_id=edu_map_course_head.MAP_COURSE_ID','left');
        $this->db->join('program_widgets','program_widgets.relation_id=edu_map_course_head.MAP_COURSE_ID','left');
        $this->db->where('program_contents.contents_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function get_program_name($relation_id)
    {
        $this->db->select("edu_course_dir.COURSE_NAME as title");
        $this->db->from('edu_map_course_head');
        $this->db->join('edu_course_dir',"edu_course_dir.COURSE_ID=edu_map_course_head.COURSE_ID",'left');
        $this->db->where('edu_map_course_head.MAP_COURSE_ID', $relation_id);
        $this->db->order_by('edu_map_course_head.MAP_COURSE_ID','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_language_name($id)
    {
        $this->db->select("languages.language_id as language_id,languages.language_name as language_name");
        $this->db->from('languages');
        $this->db->join('program_contents',"program_contents.language_id=languages.language_id",'left');
        $this->db->where('program_contents.contents_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_programcontents_courseshortcode($id)
    {
        // $this->db->select('*,edu_map_course_head.COURSE_CODE as coursecode');
        // $this->db->from('edu_map_course_head');
        // $this->db->join('program_contents','program_contents.relation_id=edu_map_course_head.MAP_COURSE_ID','left');
        // $this->db->join('edu_course_dir','edu_course_dir.COURSE_ID=edu_map_course_head.COURSE_ID','left');
        // $this->db->join('edu_stream_dir',"edu_stream_dir.STREAM_ID=edu_map_course_head.AREA_OF_STUDY_ID",'left');
        // $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=edu_map_course_head.INST_ID",'left');
        // $this->db->join('locations',"locations.location_id=edu_map_course_head.LOCATION_ID",'left');
        // $this->db->join('edu_levelofstudy_dir',"edu_levelofstudy_dir.LEVEL_OF_STUDY_ID=edu_map_course_head.LEVEL_OF_STUDY_ID",'left');  
        // $this->db->join('edu_areaofstudy_dir',"edu_areaofstudy_dir.AREA_OF_STUDY_ID=edu_map_course_head.AREA_OF_STUDY_ID",'left');    
        // $this->db->join('edu_discipline_dir',"edu_discipline_dir.DISCIPLINE_ID=edu_map_course_head.DISCIPLINE_ID",'left');    
        // $this->db->join('edu_coursetype_dir',"edu_coursetype_dir.COURSE_TYPE_ID=edu_map_course_head.COURSE_TYPE_ID",'left');    
        // $this->db->where('edu_map_course_head.MAP_COURSE_ID', $id);
        // $query = $this->db->get();
        // $return = $query->result_array();
        // return count($return)!=0?$return[0]:null;

        $this->db->select('*,edu_map_course_head.COURSE_CODE as program_code');
        $this->db->from('edu_map_course_head');
        $this->db->join('program_contents',"program_contents.relation_id=edu_map_course_head.MAP_COURSE_ID");
        $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=edu_map_course_head.INST_ID",'left');
        $this->db->join('edu_course_dir',"edu_course_dir.COURSE_ID=edu_map_course_head.COURSE_ID",'left');
        $this->db->join('edu_areaofstudy_dir',"edu_areaofstudy_dir.AREA_OF_STUDY_ID=edu_map_course_head.AREA_OF_STUDY_ID",'left'); 
        $this->db->join('edu_levelofstudy_dir',"edu_levelofstudy_dir.LEVEL_OF_STUDY_ID=edu_map_course_head.LEVEL_OF_STUDY_ID",'left');
        $this->db->join('edu_coursetype_dir',"edu_coursetype_dir.COURSE_TYPE_ID=edu_map_course_head.COURSE_TYPE_ID",'left'); 
        $this->db->join('edu_discipline_dir',"edu_discipline_dir.DISCIPLINE_ID=edu_map_course_head.DISCIPLINE_ID",'left'); 
        $this->db->join('locations',"locations.location_id=edu_map_course_head.LOCATION_ID",'left');
        $this->db->where('program_contents.contents_id',$id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
    
    function programcontents_manipulate($data,$id=null)
    {   
        $this->db->trans_start();

        $title              = $this->input->post('title');           
        $description        = $this->input->post('description');
        $read_more_in       = $this->input->post('read_more_in');                                 
        $language_id        = $this->input->post('language_id'); 
        $apply              = $this->input->post('apply');
        $relation_id        = $this->input->post('relation_id');
        $data_type          = $this->input->post('data_type');
        $public12           = $this->input->post('public');
        $meta_title         = $this->input->post('meta_title');
        $meta_description   = $this->input->post('meta_description');
        $meta_keywords      = $this->input->post('meta_keywords');
        $meta_image         = $this->input->post('meta_image');
        $programme_keywords = $this->input->post('programme_keywords');
        $url                = $this->input->post('url');
        $enable_apply_now   = $this->input->post('enable_apply_now');
        $enable_enquire_now = $this->input->post('enable_enquire_now');
        $enable_admission   = $this->input->post('enable_admission');
        $display_on_stage   = $this->input->post('display_on_stage');

        if(isset($public12) && count($public12)!=0){
        $public12=1;
        } else {
            $public12=0;
        }
        $public =$public12;

        $processdata    = array(
                                'title'             =>  $title,
                                'description'       =>  $description,
                                'read_more_in'      =>  $read_more_in,
                                'language_id'       =>  $language_id,
                                'apply'             =>  $apply,
                                'relation_id'       =>  $relation_id,
                                'data_type'         =>  'program',
                                'meta_title'        =>  $meta_title,
                                'meta_description'  =>  $meta_description,
                                'meta_keywords'     =>  $meta_keywords,
                                'meta_image'        =>  $meta_image,
                                'programme_keywords'=>  $programme_keywords,
                                'url'               =>  $url,
                                'enable_apply_now'               =>  $enable_apply_now,
                                'enable_enquire_now'             =>  $enable_enquire_now,
                                'enable_admission'               =>  $enable_admission,
                                'public'            => $public,
                                'display_on_stage'            => $display_on_stage
                            );

        if($id!=null) // update
        {   
            $this->db->where('contents_id', $id);
            $this->db->update('program_contents', $processdata);

            $save = [];
            $save_user_group = [];
            foreach ($data['widget_name'] as $key => $value) {
                $save['widget_name']            = $value;
                $save['p_id']                   = isset($data['p_id'][$key]) ? $data['p_id'][$key] : '';
                $save['widgets']                = $data['widgets'][$key];
                $save['publish']                = $data['publish'][$key];
                $save['widget_title_display']   = $data['widget_title_display'][$key];
                $save['widget_order']           = isset($data['widget_order'][$key]) ? $data['widget_order'][$key] : '';
                $save_group_inst[]  = $save;
            }

            // echo"<pre>";print_r($save_group_inst);exit();

            // $relation_id = $this->input->post('relation_id');
            $id2 = $this->input->post('p_id');
            // print_r($id2);exit();

            if($id2 == ''){ 
                if(isset($data['widgets_array_check']) && $data['widgets_array_check'] == 1){ //echo"m in insert";exit();
                    foreach($save_group_inst as $key => $result){ 
                        $this->db->insert('program_widgets',array("name"=>$result['widget_name'],"desvalue"=>$result['widgets'],"relation_id"=>$id,"publish"=>$result['publish'],"widget_title_display"=>$result['widget_title_display'],"widget_order"=>1));
                        // echo "<pre>";print_r($this->db->last_query());exit;
                    }
                }
            } 

            if(isset($data['widgets_array_check']) && $data['widgets_array_check'] == 2){ //echo"m in update";exit();
                if (!empty($save_group_inst))  {  //echo "<pre>"; print_r($save_group_inst);
                //echo "<br>---------------</br>";//exit();
                    foreach($save_group_inst as $key => $result){ 
                        if($result['p_id'] == ''){
                            //echo "empty<br>";
                            $last_row=$this->db->select('widget_order')->order_by('widget_order',"desc")->limit(1)->get('program_widgets')->row();
                            $w_order = $last_row->widget_order; 
                            $widget_order = $w_order + 1;
                            $this->db->insert('program_widgets',array("name"=>$result['widget_name'],"desvalue"=>$result['widgets'],"relation_id"=>$id,"publish"=>$result['publish'],"widget_title_display"=>$result['widget_title_display'],"widget_order"=>$widget_order));
                        } else {
                            //echo "not empty<br>";
                            $this->db->where('p_id',$result['p_id']);
                            $this->db->update('program_widgets',array("name"=>$result['widget_name'],"desvalue"=>$result['widgets'],"relation_id"=>$id,"publish"=>$result['publish'],"widget_title_display"=>$result['widget_title_display'])); 
                        }
                        //echo "<pre>";print_r($this->db->last_query());exit;
                        $str = $this->db->last_query();
                           
                        //echo "<pre>";
                        //print_r($str);
                        //echo "<br>+++++<br>";
                    }
                     // exit();
                }
            }

        }
        else    //add
        {   
            $processdata['created_date'] = date('d/m/Y');
            $this->db->insert('program_contents', $processdata);
            $id = $this->db->insert_id();

            $save = [];
            $save_user_group = [];
            foreach ($data['widget_name'] as $key => $value) {
                $save['widget_name']            = $value;
                $save['widgets']                = $data['widgets'][$key];
                $save['publish']                = $data['publish'][$key];
                $save['widget_title_display']   = $data['widget_title_display'][$key];
                $save_group_inst[]  = $save;
            }

            $i=0;
            foreach($save_group_inst as $result){     

                $this->db->insert('program_widgets',array("name"=>$result['widget_name'],"desvalue"=>$result['widgets'],"relation_id"=>$id,"publish"=>$result['publish'],"widget_title_display"=>$result['widget_title_display'],"widget_order"=>1));


                $i++;    
            } 
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }






    /* PROGRAM & DETAILS CONTENTS CODE SPECIALIZATION*/

    // function get_all_programspecialization($data_type=null,$relation_id=null)
    // {
    //     $this->db->select("*,program_specialization.public,program_specialization.created_date");
    //     $this->db->from('program_specialization');
    //     $this->db->join('edu_map_course_head','edu_map_course_head.MAP_COURSE_ID=program_specialization.relation_id');
    //     $this->db->join('languages','languages.language_id=program_specialization.language_id');
    //     if($data_type!=null){
    //         $this->db->where('data_type',$data_type);
    //     }
    //     if($relation_id!=null){
    //         $this->db->where('relation_id',$relation_id);
    //     }
    //     $this->db->order_by('program_specialization.created_date','DESC');
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

    function get_programspecialization_detail($id)
    {
        $this->db->select('*,program_specialization.relation_id,program_widgets.relation_id as relation');
        $this->db->from('edu_map_course_head');
        $this->db->join('program_specialization','program_specialization.relation_id=edu_map_course_head.MAP_COURSE_ID','left');
        $this->db->join('program_widgets','program_widgets.relation_id=edu_map_course_head.MAP_COURSE_ID','left');
        $this->db->where('program_specialization.contents_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }


    function get_programspecialization_courseshortcode($id)
    {
        $this->db->select('*,edu_map_course_head.COURSE_CODE as program_code');
        $this->db->from('edu_map_course_head');
        $this->db->join('program_specialization',"program_specialization.relation_id=edu_map_course_head.MAP_COURSE_ID");
        $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=edu_map_course_head.INST_ID",'left');
        $this->db->join('edu_course_dir',"edu_course_dir.COURSE_ID=edu_map_course_head.COURSE_ID",'left');
        $this->db->join('edu_areaofstudy_dir',"edu_areaofstudy_dir.AREA_OF_STUDY_ID=edu_map_course_head.AREA_OF_STUDY_ID",'left'); 
        $this->db->join('edu_levelofstudy_dir',"edu_levelofstudy_dir.LEVEL_OF_STUDY_ID=edu_map_course_head.LEVEL_OF_STUDY_ID",'left');
        $this->db->join('edu_coursetype_dir',"edu_coursetype_dir.COURSE_TYPE_ID=edu_map_course_head.COURSE_TYPE_ID",'left'); 
        $this->db->join('edu_discipline_dir',"edu_discipline_dir.DISCIPLINE_ID=edu_map_course_head.DISCIPLINE_ID",'left'); 
        $this->db->join('locations',"locations.location_id=edu_map_course_head.LOCATION_ID",'left');
        $this->db->where('program_specialization.contents_id',$id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
    
    // function programspecialization_manipulate($data,$id=null)
    // {
    //     $this->db->trans_start();

    //     if(isset($data["public"]) && count($data["public"])!=0){
    //         $data["public"]=1;
    //     } else {
    //         $data["public"]=0;
    //     }

    //     if($id!=null) // update
    //     { 
    //         $specialization_name = $this->input->post('data[specialization_name]');
    //         // $url = $this->input->post('url');           
    //         $description = $this->input->post('data[description]');
    //         $read_more_in = $this->input->post('data[read_more_in]');                                 
    //         $language_id = $this->input->post('data[language_id]'); 
    //         $apply = $this->input->post('data[apply]');
    //         $relation_id = $this->input->post('data[relation_id]');
    //         $data_type = $this->input->post('data[data_type]');
    //         $public12 = $this->input->post('data[public]');

    //         $meta_title = $this->input->post('data[meta_title]');
    //         $meta_description = $this->input->post('data[meta_description]');
    //         $meta_keywords = $this->input->post('data[meta_keywords]');
    //         $meta_image = $this->input->post('data[meta_image]');

    //         if(isset($public12) && count($public12)!=0){
    //         $public12=1;
    //         } else {
    //             $public12=0;
    //         }
    //         $public =$public12;

    //         $data3 = array( 
    //         'specialization_name' =>  $specialization_name,
    //         // 'url' =>  $url,
    //         'description' =>  $description,
    //         'read_more_in' =>  $read_more_in,
    //         'language_id' =>  $language_id,
    //         'apply' =>  $apply,
    //         'relation_id' =>  $relation_id,
    //         'data_type' =>  $data_type,
    //         'meta_title' =>  $meta_title,
    //         'meta_description' =>  $meta_description,
    //         'meta_keywords' =>  $meta_keywords,
    //         'meta_image' =>  $meta_image,
    //         'public' => $public
    //         );
            
    //         $this->db->where('contents_id',$id);
    //         $data['updated_date']=date('d/m/Y');
    //         $this->db->update('program_specialization',$data3);
    //         // $ss=$this->db->last_query();
    //         // print_r($ss);exit();

    //         $relation_id = $this->input->post('data[relatiprogram_specializationon_id]');
    //         $id2 = $this->input->post('data[id2]');

    //         if($id2 == ''){ 
    //             $counter = 0;
    //             if(isset($data['widgets_array_check']) && $data['widgets_array_check'] == 1){
    //                 foreach($data['widgets_array'] as $key => $result){ 
    //                     $publish = isset($data["publish"][$counter]) ? $data["publish"][$counter] : 0;
    //                     $this->db->insert('program_widgets',array("name"=>$result['widget_name'],"desvalue"=>$result['widgets'],"relation_id"=>$id,"publish"=>$publish));

    //                     ++$counter;
    //                   }
    //             }
    //         } 

    //         if(isset($data['widgets_array_check']) && $data['widgets_array_check'] == 2){
    //             if (!empty($data['widgets_array']))  {  
    //                 $counter1 = 0;
    //                     foreach($data['widgets_array'] as $key => $result){ 
    //                         $publish = isset($data["publish"][$counter1]) ? $data["publish"][$counter1] : 0;

    //                  $this->db->delete('program_widgets', array("p_id"=>$result['id2']));

    //                          $this->db->insert('program_widgets',array("name"=>$result['widget_name'],"desvalue"=>$result['widgets'],"relation_id"=>$id,"publish"=>$publish));

    //                         $this->db->where('p_id',$result['id2']);
    //                         $this->db->update('program_widgets',array("name"=>$result['widget_name'],"desvalue"=>$result['widgets'],"relation_id"=>$relation_id,"publish"=>$publish)); 
    //                      ++$counter1;
    //                       }
    //             }
    //         }

    //     }
    //     else    //add
    //     {
            
    //         $specialization_name = $this->input->post('data[specialization_name]');
    //         // $url = $this->input->post('url');               
    //         $description = $this->input->post('data[description]');
    //         $read_more_in = $this->input->post('data[read_more_in]');                                 
    //         $language_id = $this->input->post('data[language_id]'); 
    //         $apply = $this->input->post('data[apply]');
    //         $relation_id = $this->input->post('data[relation_id]');
    //         $data_type = $this->input->post('data[data_type]');
    //         $public12 = $this->input->post('data[public]');

    //         $meta_title = $this->input->post('data[meta_title]');
    //         $meta_description = $this->input->post('data[meta_description]');
    //         $meta_keywords = $this->input->post('data[meta_keywords]');
    //         $meta_image = $this->input->post('data[meta_image]');

    //         if(isset($public12) && count($public12)!=0){
    //         $public12=1;
    //         } else {
    //             $public12=0;
    //         }
    //         $public =$public12;

    //         $data3 = array( 
    //         'specialization_name' =>  $specialization_name,
    //         // 'url' =>  $url,
    //         'description' =>  $description,
    //         'read_more_in' =>  $read_more_in,
    //         'language_id' =>  $language_id,
    //         'apply' =>  $apply,
    //         'relation_id' =>  $relation_id,
    //         'data_type' =>  $data_type,
    //         'meta_title' =>  $meta_title,
    //         'meta_description' =>  $meta_description,
    //         'meta_keywords' =>  $meta_keywords,
    //         'meta_image' =>  $meta_image,
    //         'public' => $public
    //         );
            
    //         $data['created_date']=date('d/m/Y');
    //         $this->db->insert('program_specialization',$data3);
    //         $id=$this->db->insert_id();

    //         $widgetName = $this->input->post('data[widget_name]');
    //         $Widgets = $this->input->post('data[widgets]');
    //         $relation_id = $this->input->post('data[relation_id]');
            

    //         $i=0;
    //             foreach($data['widgets_array'] as $result){ 
    //                 $publish = isset($data["publish"][$counter1]) ? $data["publish"][$counter1] : 0;
    //                 $this->db->insert('program_widgets',array("name"=>$result['widget_name'],"desvalue"=>$result['widgets'],"relation_id"=>$id,"publish"=>$publish));

    //                 $i++;
                 
    //               } 

            
    //     }

    //     $this->db->trans_complete();
    //     // end TRANSACTION
    //     if ($this->db->trans_status() == FALSE)
    //     {
    //         return 0;
    //     }
    //     else
    //     {
    //         return 1;
    //     }
    // }



    // function programspecialization_manipulate($data,$id=null)
    // {   
    //     $this->db->trans_start();

    //     $specialization_name= $this->input->post('specialization_name');           
    //     $description        = $this->input->post('description');
    //     $read_more_in       = $this->input->post('read_more_in');                                 
    //     $language_id        = $this->input->post('language_id'); 
    //     $apply              = $this->input->post('apply');
    //     $relation_id        = $this->input->post('relation_id');
    //     $data_type          = $this->input->post('data_type');
    //     $public12           = $this->input->post('public');
    //     $meta_title         = $this->input->post('meta_title');
    //     $meta_description   = $this->input->post('meta_description');
    //     $meta_keywords      = $this->input->post('meta_keywords');
    //     $meta_image         = $this->input->post('meta_image');
    //     //$programme_keywords = $this->input->post('programme_keywords');
    //     $url                = $this->input->post('url');

    //     if(isset($public12) && count($public12)!=0){
    //     $public12=1;
    //     } else {
    //         $public12=0;
    //     }
    //     $public =$public12;

    //     $processdata    = array(
    //                             'specialization_name'=>  $specialization_name,
    //                             'description'       =>  $description,
    //                             'read_more_in'      =>  $read_more_in,
    //                             'language_id'       =>  $language_id,
    //                             'apply'             =>  $apply,
    //                             'relation_id'       =>  $relation_id,
    //                             'data_type'         =>  'program',
    //                             'meta_title'        =>  $meta_title,
    //                             'meta_description'  =>  $meta_description,
    //                             'meta_keywords'     =>  $meta_keywords,
    //                             'meta_image'        =>  $meta_image,
    //                             //'programme_keywords'=>  $programme_keywords,
    //                             'url'               =>  $url,
    //                             'public'            => $public
    //                         );

    //     if($id!=null) // update
    //     {   
    //         $this->db->where('contents_id', $id);
    //         $this->db->update('program_specialization', $processdata);

    //         $save = [];
    //         $save_user_group = [];
    //         foreach ($data['widget_name'] as $key => $value) {
    //             $save['widget_name']            = $value;
    //             $save['p_id']                   = isset($data['p_id'][$key]) ? $data['p_id'][$key] : '';
    //             $save['widgets']                = $data['widgets'][$key];
    //             $save['publish']                = $data['publish'][$key];
    //             $save['widget_title_display']   = $data['widget_title_display'][$key];
    //             $save['widget_order']           = isset($data['widget_order'][$key]) ? $data['widget_order'][$key] : '';
    //             $save_group_inst[]  = $save;
    //         }

    //         // echo"<pre>";print_r($save_group_inst);exit();

    //         // $relation_id = $this->input->post('relation_id');
    //         $id2 = $this->input->post('p_id');
    //         // print_r($id2);exit();

    //         if($id2 == ''){ 
    //             if(isset($data['widgets_array_check']) && $data['widgets_array_check'] == 1){ //echo"m in insert";exit();
    //                 foreach($save_group_inst as $key => $result){ 
    //                     $this->db->insert('program_widgets',array("name"=>$result['widget_name'],"desvalue"=>$result['widgets'],"relation_id"=>$id,"publish"=>$result['publish'],"widget_title_display"=>$result['widget_title_display'],"widget_order"=>1));
    //                     // echo "<pre>";print_r($this->db->last_query());exit;
    //                 }
    //             }
    //         } 

    //         if(isset($data['widgets_array_check']) && $data['widgets_array_check'] == 2){ //echo"m in update";exit();
    //             if (!empty($save_group_inst))  {  //echo "<pre>"; print_r($save_group_inst);
    //             //echo "<br>---------------</br>";//exit();
    //                 foreach($save_group_inst as $key => $result){ 
    //                     if($result['p_id'] == ''){
    //                         //echo "empty<br>";
    //                         $last_row=$this->db->select('widget_order')->order_by('widget_order',"desc")->limit(1)->get('program_widgets')->row();
    //                         $w_order = $last_row->widget_order; 
    //                         $widget_order = $w_order + 1;
    //                         $this->db->insert('program_widgets',array("name"=>$result['widget_name'],"desvalue"=>$result['widgets'],"relation_id"=>$id,"publish"=>$result['publish'],"widget_title_display"=>$result['widget_title_display'],"widget_order"=>$widget_order));
    //                     } else {
    //                         //echo "not empty<br>";
    //                         $this->db->where('p_id',$result['p_id']);
    //                         $this->db->update('program_widgets',array("name"=>$result['widget_name'],"desvalue"=>$result['widgets'],"relation_id"=>$id,"publish"=>$result['publish'],"widget_title_display"=>$result['widget_title_display'])); 
    //                     }
    //                     //echo "<pre>";print_r($this->db->last_query());exit;
    //                     $str = $this->db->last_query();
                           
    //                     //echo "<pre>";
    //                     //print_r($str);
    //                     //echo "<br>+++++<br>";
    //                 }
    //                  // exit();
    //             }
    //         }

    //     }
    //     else    //add
    //     {   
    //         $processdata['created_date'] = date('d/m/Y');
    //         $this->db->insert('program_specialization', $processdata);
    //         $id = $this->db->insert_id();

    //         $save = [];
    //         $save_user_group = [];
    //         foreach ($data['widget_name'] as $key => $value) {
    //             $save['widget_name']            = $value;
    //             $save['widgets']                = $data['widgets'][$key];
    //             $save['publish']                = $data['publish'][$key];
    //             $save['widget_title_display']   = $data['widget_title_display'][$key];
    //             $save_group_inst[]  = $save;
    //         }

    //         $i=0;
    //         foreach($save_group_inst as $result){     

    //             $this->db->insert('program_widgets',array("name"=>$result['widget_name'],"desvalue"=>$result['widgets'],"relation_id"=>$id,"publish"=>$result['publish'],"widget_title_display"=>$result['widget_title_display'],"widget_order"=>1));


    //             $i++;    
    //         } 
    //     }

    //     $this->db->trans_complete();
    //     // end TRANSACTION
    //     if ($this->db->trans_status() == FALSE)
    //     {
    //         return 0;
    //     }
    //     else
    //     {
    //         return 1;
    //     }
    // }
    

    function get_all_widget($id)
    {
        $this->db->select('*');
        $this->db->from('program_widgets');
        $this->db->where('relation_id', $id);
        $this->db->order_by('widget_order','ASC');
        $query = $this->db->get();
        return  $query->result_array();
    }

    function get_all_specialization_widget($id)
    {
        $this->db->select('*');
        $this->db->from('program_specialization_widgets');
        $this->db->where('relation_id', $id);
        $this->db->order_by('widget_order','ASC');
        $query = $this->db->get();
        return  $query->result_array();
    }

    function get_all_stream()
    {
        $this->db->select("*");
        $this->db->from('edu_stream_dir');
        $query = $this->db->get();
        return $query->result_array();
    }


    function get_all_course()
    {
        $this->db->select("*");
        $this->db->from('edu_course_dir');
        $query = $this->db->get();
        return $query->result_array();
    }


    function get_all_class()
    {
        $this->db->select("*");
        $this->db->from('edu_class_dir');
        $query = $this->db->get();
        return $query->result_array();
    }




    /* VARSHA'S CODE END */


    /**********INSTITUTE MODEL CODE START *******************************/
  function get_all_institute()
    {
        $this->db->select("*,edu_institute_dir.public as publish");
        $this->db->from('edu_institute_dir');
        $this->db->join('locations','locations.location_id=edu_institute_dir.location_id','left');
        // $this->db->join('institute_category','institute_category.inst_cat_id=edu_institute_dir.INSTITUTE_CATEGORY','left');
        $this->db->order_by('INST_ID','ASC');        
        // $this->db->_compile_select(); 
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_institute_category()
    {
        $this->db->select("*");
        $this->db->from('`institute_category`');
        $this->db->order_by('inst_cat_id','ASC');        
        // $this->db->_compile_select(); 
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_institute_detail($id)
    {
        $this->db->select('*');
        $this->db->from('edu_institute_dir');
        $this->db->where('INST_ID', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function institute_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if(isset($data["public"]) && count($data["public"])!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }
        if(isset($data["pages"]) && count($data["pages"])!=0){
            $data["pages"]=1;
        } else {
            $data["pages"]=0;
        }
        if(isset($data["posts"]) && count($data["posts"])!=0){
            $data["posts"]=1;
        } else {
            $data["posts"]=0;
        }
        if(isset($data["news"]) && count($data["news"])!=0){
            $data["news"]=1;
        } else {
            $data["news"]=0;
        }
        if(isset($data["event"]) && count($data["event"])!=0){
            $data["event"]=1;
        } else {
            $data["event"]=0;
        }
        if(isset($data['default']) && $data['default']==1)
        {
            $this->db->set('default',0);
            $this->db->update('languages');
        }

        // $location=$data['institute_location'];

        // $this->db->select('*');
        // $this->db->from('locations');
        // $this->db->where('location_name', $location);
        // $query = $this->db->get();
        // $return = $query->result_array();
        // $data['location_id']=$return[0]['location_id'];


        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
        }
        unset($data["titles"]);

        if($id!=null) // update
        {
            $this->db->where('INST_ID',$id);
            $this->db->update('edu_institute_dir',$data);
        }
        else    //add
        {
            //$data['created']=time();
            $this->db->insert('edu_institute_dir',$data);
            $id=$this->db->insert_id();

        }

        if(isset($titles)){
            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"category"));
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"category"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    /**********INSTITUTE MODEL CODE END *******************************/

    /****LOCATION***/
    
    function get_all_locations()
    {
        $this->db->select("*");
        $this->db->from('locations');
        $this->db->order_by('location_id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**** BANNER MANAGEMENT ***/

    /*****

    BANNER IMAGE
    */
     function get_all_banner_images_modal(){
        $this->db->select("*");
        $this->db->from('banner_images');
        $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=banner_images.institute_id",'left');
        $this->db->order_by('image_id','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_all_banner_images($limit, $start){
        $this->db->limit($limit, $start);
        $this->db->select("*");
         $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=banner_images.institute_id",'left');
        $this->db->order_by('image_id','DESC');
        $this->db->from('banner_images');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_all_banner_images_edit(){
       // $this->db->limit($limit, $start);
        $this->db->select("*");
        $this->db->from('banner_images');
        $query = $this->db->get();
        return $query->result_array();
    }
    function insert_banner_images($data=''){
    // print_r($data);exit;
    // print_r($_POST);exit;      
        $this->db->trans_start();
       
        // if($data['name']!="") {
        //     $data['image']=$data['imagepath'];
        // } 
        $data['created_date']=time();
        $data['user_id']=$this->session->userdata['user_id'];

        if(isset($data['image_id']) AND ($data['image_id']!=0 OR $data['image_id']!='')) {
            // echo "update";exit;
        $this->db->where('image_id',$data['image_id']);
            $this->db->update('banner_images',$data);
        } else {
        // echo "insert";exit;
                $data['image_id']=$this->db->insert_id();
          $this->db->insert('banner_images',$data);
        
        }
        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return TRUE;
        }
    }
    function get_banner_images_detail($image_id)
    {
        $this->db->select("*");
        $this->db->from('banner_images');
        $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=banner_images.institute_id",'left');
        $this->db->where('image_id',$image_id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:0;
    }

     function delete_banner_image($image_id)
    {
        try {
            $this->db->where('image_id',$image_id)->delete('banner_images');
            return true;
        }

        //catch exception
        catch(Exception $e) {
          echo $e->getMessage();
        }
    }
    function update_banner_image($image_id, $data)
    {
        try {
            $this->db->where('image_id',$image_id)->update('banner_images');
            return true;
        }

        //catch exception
        catch(Exception $e) {
          echo $e->getMessage();
        }
    }

       function get_banner_image($image_id)
    {
        $this->db->select("image,name,image_id");
        $this->db->from('banner_images');
        $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=banner_images.institute_id",'left');
        $this->db->where('image_id',$image_id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:0;
    }

    /**************************/

    /***AJAX function ***/

    function upload_image_banner($inputdata,$filename)
    {
      // $this->db->insert('banners', $inputdata); 
      // $insert_id = $this->db->insert_id();

      if($filename!='' ){
      $filename1 = explode(',',$filename);
      foreach($filename1 as $file){
      $file_data = array(
      'image' => $file
      );
      $this->db->insert('banner_photos', $file_data);
      }
      }
    }

    /**** VIDEO MANAGEMENT ***/

    function get_all_video_modal(){
        $this->db->select("*");
        $this->db->from('video_management');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_all_videos($id){
        // $this->db->limit($limit, $start);
        if($id == 50){
            $this->db->select("*");
            $this->db->from('video_management');
            $this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID,video_management.institute_id)",'left');
            $this->db->group_by("video_management.video_id");
            $this->db->order_by('video_management.video_id','DESC');
            $query = $this->db->get();
            return $query->result_array();
        } else {
            $this->db->select("*");
            $this->db->from('video_management');
            $this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID,video_management.institute_id)",'left');
            $this->db->where_in("video_management.institute_id", $id);
            $this->db->group_by("video_management.video_id");
            $this->db->order_by('video_management.video_id','DESC');
            $query = $this->db->get();
            return $query->result_array();
        }
    }
    function get_all_video_edit(){
       // $this->db->limit($limit, $start);
        $this->db->select("*");
        $this->db->from('video_management');
        $query = $this->db->get();
        return $query->result_array();
    }
    function insert_videos($data,$videoPath){       
        $this->db->trans_start();

       
        $fvideo=$data['featured_video'];
        if($fvideo=="on") {
            $data['featured_video']=1;
        } else {
            $data['featured_video']=0;
        }
        // $data['created_date']=time();
        $data['user_id']=$this->session->userdata['user_id'];
        $this->db->insert('video_management',$data);
        $id=$this->db->insert_id();
        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return $id;
        }
    }

      function get_video_detail($id)
    {
        $this->db->select('*');
        $this->db->from('video_management');
        $this->db->where('video_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function video_manipulate($data,$id=null)
    {
        // print_r($data);exit;
        $this->db->trans_start();

        if(isset($data['default']) && $data['default']==1)
        {
            $this->db->set('default',0);
            $this->db->update('languages');
        }

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
        }
        unset($data["titles"]);

        // $fvideo=$data['featured_video'];
        // if($fvideo=="on") {
        //     $data['featured_video']=1;
        // } else {
        //     $data['featured_video']=0;
        // }
        if(isset($data["spotlight_video"]) && $data["spotlight_video"]!=0){
            $data["spotlight_video"]=1;
        } else {
            $data["spotlight_video"]=0;
        }

        if(isset($data["public"]) && $data["public"]!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }

          // $data['created_date'];
        // $data['created_date']=strtotime($data['created_date']);

       
        if($id!=null) // update
        {
            $this->db->where('video_id',$id);
            $this->db->update('video_management',$data);
        }
        else    //add
        {
          
            $this->db->insert('video_management',$data);
            $id=$this->db->insert_id();

        }

        if(isset($titles)){
            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"page"));
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"page"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }
    function get_videos_detail($video_id)
    {
        $this->db->select("*");
        $this->db->from('video_management');
        $this->db->where('video_id',$video_id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:0;
    }

     function delete_video($video_id)
    {
          
       if(isset($video_id)) {
            // $this->db->where('video_id',$video_id)->delete('video_management');
              $this->db->delete('video_management', array("video_id"=>$video_id));
              return true;
          }else {
            return false;
          }          
              return true;
    }

    function update_video($video_id, $data)
    {
        try {
            $this->db->where('video_id',$video_id)->update('video_management');
            return true;
        }

        //catch exception
        catch(Exception $e) {
          echo $e->getMessage();
        }
    }

    // function get_video($video_id)
    // {
    //     $this->db->select("video,name,video_id");
    //     $this->db->from('video_management');
    //     $this->db->where('video_id',$video_id);
    //     $query = $this->db->get();
    //     $return = $query->result_array();
    //     return count($return)!=0?$return[0]:0;
    // }


    /** NEW VIDEO CODE **/

    function get_video($id='', $conditions=[])
    {
        $this->db->select('*,video_management.video_text as name');
        $this->db->from('video_management');
        $this->db->where('video_management.video_id', $id);
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

    function manage_video($data=[], $id='')
    {  
        $this->db->trans_start();

        if($id)
        {
            if(!empty($this->get_video($id)))
            {
                $update['video_text']               = $data['video_text'];
                $update['video_description']        = $data['video_description'];
                $update['institute_id']             = $data['institute_id'];
                $update['video_url']                = $data['video_url'];
                $update['created_date']             = $data['created_date'];
                $update['embed_code']               = $data['embed_code'];
                $update['spotlight_video']          = $data['spotlight_video'];
                $update['featured_video']           = $data['featured_video'];
                $update['public']                   = $data['public'];
                $update['user_id']                  = $this->session->userdata['user_id'];
                $this->db->where('video_id', $id);
                $this->db->update('video_management', $update);

                if($this->db->affected_rows() > 0)
                {
                    $return = ['error' => 0, 'message' => 'Video successfully updated'];
                }
                else
                {
                    $return = ['error' => 1, 'message' => 'Unable to update Video'];
                }
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Video not found'];
            }
        }
        else
        {   
            $insert['video_text']               = $data['video_text'];
            $insert['video_description']        = $data['video_description'];
            $insert['institute_id']             = $data['institute_id'];
            $insert['video_url']                = $data['video_url'];
            $insert['created_date']             = $data['created_date'];
            $insert['embed_code']               = $data['embed_code'];
            $insert['spotlight_video']          = $data['spotlight_video'];
            $insert['featured_video']           = $data['featured_video'];
            $insert['public']                   = $data['public'];
            $insert['user_id']                  = $this->session->userdata['user_id'];
            $this->db->insert('video_management', $insert);
            $insert_id = $this->db->insert_id();

            if($insert_id)
            {
                $return = ['error' => 0, 'message' => 'Video successfully added'];
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Unable to add Video'];
            }
        }


        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }

        return $return;
    }

    /***********************************************/

        /**** htmlcontentslider MANAGEMENT ***/
    function get_all_htmlcontentslider(){
        // $this->db->limit($limit, $start);
        $this->db->select("*");
        $this->db->from('htmlcontentslider');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_all_htmlcontentslider_edit(){
       // $this->db->limit($limit, $start);
        $this->db->select("*");
        $this->db->from('htmlcontentslider');
        $query = $this->db->get();
        return $query->result_array();
    }
    function insert_htmlcontentslider($data,$videoPath){       
        $this->db->trans_start();

       
      
        // $data['created_date']=time();
        $data['user_id']=$this->session->userdata['user_id'];
        $this->db->insert('htmlcontentslider',$data);
        $id=$this->db->insert_id();
        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return $id;
        }
    }

      function get_htmlcontentslider_detail($id)
    {
        $this->db->select('*');
        $this->db->from('htmlcontentslider');
        $this->db->where('htmlcontentslider_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function htmlcontentslider_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if(isset($data['default']) && $data['default']==1)
        {
            $this->db->set('default',0);
            $this->db->update('languages');
        }

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
        }
        unset($data["titles"]);

        
          // $data['created_date'];
        // $data['created_date']=strtotime($data['created_date']);

       
        if($id!=null) // update
        {
            $this->db->where('htmlcontentslider_id',$id);
            $this->db->update('htmlcontentslider',$data);
        }
        else    //add
        {
          
            $this->db->insert('htmlcontentslider',$data);
            $id=$this->db->insert_id();

        }

        if(isset($titles)){
            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"page"));
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"page"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }
   

     function delete_htmlcontentslider($video_id)
    {
          
       if(isset($video_id)) {
            // $this->db->where('video_id',$video_id)->delete('video_management');
              $this->db->delete('htmlcontentslider', array("video_id"=>$video_id));
              return true;
          }else {
            return false;
          }          
              return true;
    }
    /***************************************************************/ 



    /* Banner Managenment Module Code */


    function get_all_institute_banner ()
    {

        $this->db->select('DISTINCT(banner_images.institute_id) AS institute_id , edu_institute_dir.INST_NAME as INST_NAME');
        $this->db->from('banner_images');
        $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=banner_images.institute_id",'left');
        $this->db->group_by("banner_images.image_id");
        $this->db->order_by("banner_images.image_id","DESC");
        $query = $this->db->get();
        return $query->result_array();
    }

    function upload_image_bannernew($inputdata)
    {  
      //$subcheck = (isset($_POST['public'])) ? 1 : 0;
      $this->db->insert('banner_images', $inputdata); 
      $insert_id = $this->db->insert_id();

    }

    // function view_data_banner(){
    //     $query=$this->db->query("SELECT *
    //                              FROM banner_images ud 
    //                              LEFT JOIN edu_institute_dir as inst
    //                              ON ud.institute_id = inst.INST_ID 
    //                              ORDER BY ud.image_id DESC");
    //     return $query->result_array();
    // }


    function view_data_banner($id='')
    {
        if($id == 50){
            $this->db->select("*,banner_images.public as pub");
            $this->db->from('banner_images');
            $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=banner_images.institute_id",'left');
            $this->db->order_by('banner_images.row_order','ASC');
            $query = $this->db->get();
            return $query->result_array();
        } else {
            $this->db->select("*,banner_images.public as pub");
            $this->db->from('banner_images');
            $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=banner_images.institute_id",'left');
            $this->db->where('banner_images.institute_id', $id);
            $this->db->order_by('banner_images.row_order','ASC');
            $query = $this->db->get();
            return $query->result_array();
        }
        
    }

    function edit_data_banner($id){
        $query=$this->db->query("SELECT ud.*
                                 FROM banner_images ud 
                                 WHERE ud.image_id = $id");
        return $query->result_array();
    }

    function edit_data_image_banner($edit_id){
        $query=$this->db->query("SELECT *
                                 FROM banner_images ud 
                                 WHERE ud.image_id = $edit_id");
        return $query->result_array();
    }

    function edit_data_image_delete_banner($deleteid){
        $query=$this->db->query("SELECT *
                                 FROM banner_images ud 
                                 WHERE ud.image_id = $deleteid");
        return $query->result_array();
    }

    function edit_upload_image_banner($user_id,$inputdata,$filename ='')
    {
        if(isset($inputdata["public"]) && count($inputdata["public"])!=0){
            $inputdata["public"]=1;
        } else {
            $inputdata["public"]=0;
        }
        $this->db->where('image_id', $user_id);
        $this->db->update('banner_images', $inputdata);
    }


    function delete_banner($user_id)
    {
        try {
            $this->db->where('image_id',$user_id)->delete('banner_images');
            return true;
        }

        //catch exception
        catch(Exception $e) {
          echo $e->getMessage();
        }
    }

    function get_search_banner($data)
    {
        $this->db->select("*");
        $this->db->from('banner_images');
        foreach ($data as $key=>$value) {
            $this->db->where($key,$value);
        }
        $this->db->order_by('image_id','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }



    /* Added code for the newsletter export and listing */

    
    // Unique to models with multiple tables
    function set_table($table) {
        $this->table = $table;
    }

    // Get table from table property
    function get_table() {
        return $this->table;
    }

     // Get where column id is ... return query
    function get_where($col, $val) {
        $table = $this->get_table();
        $this->db->where($col, $val);
        $query = $this->db->get($table);
        return $query->row_array();
    }

    function newsletter_query($sql) {
        $query = $this->db->query($sql);
        if(is_object($query))
            return $query->result_array();
        else
            return $query;
    }

    function newsletter_delete($col, $val) {
        if(!empty($this->get_where($col, $val)))
        {
            $table      = $this->get_table();
            $this->db->where($col, $val);
            $res        = $this->db->delete($table);
            $error      = $res ? 0 : 1;
            $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
            $res        = ['error' => $error, 'message' => $message];
        }
        else
        {
            $error      = 1;
            $message    = 'Record does not exist in database';
        }
        $res            = ['error' => $error, 'message' => $message];
        return $res;
    }



     /* Institute Gallery Types CODE */

     function get_institutegaltype()
    {
        $this->db->select("galleries_type.id,galleries_type.type_name");
        $this->db->from('institute_galleries_type');
        $this->db->join('galleries_type',"FIND_IN_SET(galleries_type.id,institute_galleries_type.type_id)",'left');
        //$this->db->where('institute_galleries_type.institute_galleries_type',$institute_id)
        //$this->db->order_by('ig_id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_instgaltype()
    {
        $this->db->select("*,GROUP_CONCAT(galleries_type.type_name) AS type_name");
        $this->db->from('institute_galleries_type');
        $this->db->join('edu_institute_dir','edu_institute_dir.INST_ID=institute_galleries_type.institute_id');
        $this->db->join('galleries_type',"FIND_IN_SET(galleries_type.id,institute_galleries_type.type_id)",'left');
        $this->db->group_by('ig_id');
        $this->db->order_by('ig_id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_instgaltype_detail($id)
    {
        $this->db->select("*");
        $this->db->from('institute_galleries_type');
        $this->db->where('institute_galleries_type.ig_id',$id);
        $this->db->order_by('ig_id','ASC');
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function instgaltype_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if($id!=null) // update
        {
            $institute = $this->input->post('data[institute_id]');
            $type_id = $this->input->post('data[type_id][]');

            $type_id2 = implode(',', $type_id);
            $data = array( 
            'type_id' =>  $type_id2,
            'institute_id' => $institute       
            );
            // print_r($data);
            // exit();
            $this->db->where('ig_id',$id);
            $this->db->update('institute_galleries_type',$data);
        }
        else    //add
        {
            $institute = $this->input->post('data[institute_id]');
            $type_id = $this->input->post('data[type_id][]');

            $type_id2 = implode(',', $type_id);
            $data = array( 
            'type_id' =>  $type_id2,
            'institute_id' => $institute       
            );
            // print_r($data);
            // exit();
            $this->db->insert('institute_galleries_type',$data);
            $id=$this->db->insert_id();
        }

        if(isset($titles)){
            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"institute_galleries_type"));
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"institute_galleries_type"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }



    /* Donation Module */

    function get_donation($id='', $conditions=[])
    {
        $this->db->select('*');
        $this->db->from('donation');
        $this->db->join('contentsdonation', 'contentsdonation.relation_id=donation.donation_id');
        $this->db->where('donation.donation_id', $id);
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

    function manage_donations($data=[], $id='', $donation_documents)
    {  
        $this->db->trans_start();

        $allowed_inst_ids           = [];
        $save_data                  = [];
        foreach ($_POST['institute_id'] as $key => $value) 
        {
            $allowed_inst_ids[] = $value;
        }

        $save_data = !empty($allowed_inst_ids) ? implode(',', $allowed_inst_ids) : '';

        $allowed_subdontype_ids           = [];
        $save_subdontype                  = [];
        foreach ($_POST['sub_donation_type'] as $key => $value) 
        {
            $allowed_subdontype_ids[] = $value;
        }

        $save_subdontype = !empty($allowed_subdontype_ids) ? implode(',', $allowed_subdontype_ids) : '';


        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
        }
        unset($data["titles"]);

        if($id)
        {
            if(!empty($this->get_event($id)))
            {
                $update['project_name']             = $data['project_name'];
                $update['dontype_id']               = $data['dontype_id'];
                $update['sub_dontype_id']           = $save_subdontype;
                $update['institute_id']             = $save_data;
                $update['tax_benefit']              = $data['tax_benefit'];
                $update['featured']                 = $data['featured'];
                $update['public']                   = $data['public'];
                $update['created_date']             = date('Y-m-d H:i:s');
                $update['user_id']                  = $this->session->userdata['user_id'];
                $this->db->where('donation_id', $id);
                $this->db->update('donation', $update);


                $upd['name']             = $this->input->post('project_name');
                $upd['description']      = $this->input->post('description');
                $upd['image']            = $this->input->post('image');
                $upd['language_id']      = $this->input->post('language_id');
                $upd['public']           = $this->input->post('public');
                $upd['start_date']       = $this->input->post('start_date');
                $upd['end_date']         = $this->input->post('end_date');
                $upd['goal_amount']      = $this->input->post('goal_amount');
                $upd['quantity_amount']  = $this->input->post('quantity_amount');
                $upd['never_ending']     = $this->input->post('never_ending');
                $upd['radio_amount']     = $this->input->post('radio_amount');
                $upd['email_doc']        = $this->input->post('email_doc');
                $upd['updated_date']     = date('Y-m-d H:i:s');
                $upd['user_id']          = $this->session->userdata['user_id'];
                $this->db->where('contents_id', $data['contents_id']);
                $this->db->update('contentsdonation', $upd);


                if(isset($titles)){
                    $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"donation"));
                    foreach ($titles as $key=>$value) {
                        if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"donation"));
                    }
                }

                if(!empty($donation_documents))
                {
                    foreach ($donation_documents as $key => $value) {
                        $save_document['document'] = $value;
                        $save_document['relation_id'] = $id;
                        $this->db->insert('donation_document',array("document"=>$value,"relation_id"=>$id));
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
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Donation not found'];
            }
        }
        else
        {   
            $insert['project_name']             = $data['project_name'];
            $insert['dontype_id']               = $data['dontype_id'];
            $insert['sub_dontype_id']           = $save_subdontype;
            $insert['institute_id']             = $save_data;
            $insert['tax_benefit']              = $data['tax_benefit'];
            $insert['featured']                 = $data['featured'];
            $insert['public']                   = $data['public'];
            $insert['created_date']             = date('Y-m-d H:i:s');
            $insert['user_id']                  = $this->session->userdata['user_id'];
            $this->db->insert('donation', $insert);
            $insert_id = $this->db->insert_id();

            $ins['name']             = $this->input->post('project_name');
            $ins['description']      = $this->input->post('description');
            $ins['relation_id']      = $insert_id;
            $ins['image']            = $this->input->post('image');
            $ins['language_id']      = $this->input->post('language_id');
            $ins['public']           = $this->input->post('public');
            $ins['start_date']       = $this->input->post('start_date');
            $ins['end_date']         = $this->input->post('end_date');
            $ins['goal_amount']      = $this->input->post('goal_amount');
            $ins['quantity_amount']  = $this->input->post('quantity_amount');
            $ins['never_ending']     = $this->input->post('never_ending');
            $ins['radio_amount']     = $this->input->post('radio_amount');
            $ins['email_doc']        = $this->input->post('email_doc');
            $ins['data_type']        = $this->input->post('data_type');
            $ins['created_date']     = date('Y-m-d H:i:s');
            $ins['updated_date']     = date('Y-m-d H:i:s');
            $ins['user_id']          = $this->session->userdata['user_id'];
            $this->db->insert('contentsdonation', $ins);
            $ins_id = $this->db->insert_id();

            $project_name=$this->input->post('project_name');
            if(isset($titles)){
                $this->db->delete('titles', array("relation_id"=>$insert_id,"data_type"=>"donation"));
                foreach ($titles as $key=>$value) {
                    if($key==1) $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$project_name,"relation_id"=>$insert_id,"data_type"=>"donation"));
                    else if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$insert_id,"data_type"=>"donation"));
                }
            }

            if(!empty($donation_documents))
                {
                    foreach ($donation_documents as $key => $value) {
                        $save_document['document'] = $value;
                        $save_document['relation_id'] = $insert_id;
                        $this->db->insert('donation_document',array("document"=>$value,"relation_id"=>$insert_id));
                    }
            }

            if($insert_id)
            {
                $return = ['error' => 0, 'message' => 'Donation successfully added'];
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Unable to add donation'];
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }

        return $return;
    }

    function get_all_donation($abc)
    {   
        if($abc != '50'){
            $this->db->where('institute_id', $abc);
        }
        $this->db->select("*");
        $this->db->from('donation');
        $this->db->order_by('donation_id','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
     
    function get_donationdoc_detail($donation_id)
    {  
        $this->db->select('*');
        $this->db->from('donation_document');
        $this->db->where('relation_id', $donation_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /* Donation Type */

    function get_all_donation_type()
    {
        $this->db->select("*");
        $this->db->from('donation_type');
        $this->db->order_by('dontype_id','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_donation_type_don()
    {
        $this->db->select("*");
        $this->db->from('donation_type');
        $this->db->where('public',1);
        $this->db->order_by('dontype_id','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_donation_type_detail($id)
    {
        $this->db->select('*');
        $this->db->from('donation_type');
        $this->db->where('dontype_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function donation_type_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if(isset($data["public"]) && count($data["public"])!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }

        if(isset($data['default']) && $data['default']==1)
        {
            $this->db->set('default',0);
            $this->db->update('languages');
        }

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
        }
        unset($data["titles"]);

        if($id!=null) // update
        {
            $this->db->where('dontype_id',$id);
            $this->db->update('donation_type',$data);
        }
        else    //add
        {
            //$data['created_date']=time();
            $this->db->insert('donation_type',$data);
            $id=$this->db->insert_id();

        }

        if(isset($titles)){
            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"donation_type"));
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"donation_type"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }
    function get_search_donation_type($data)
    {
        $this->db->select("*");
        $this->db->from('donation_type');
        foreach ($data as $key=>$value) {
            $this->db->where($key,$value);
        }
        $this->db->order_by('donation_type','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
     function get_typical_donation_type()
    {
        $this->db->select("*");
        $this->db->from('donation_type');
        $this->db->join('donation',"donation.dontype_id=donation_type.dontype_id");
        $query = $this->db->get();
        return $query->result_array();
    }



    function get_all_donation_type_sub()
    {
        $this->db->select("*");
        $this->db->from('sub_donation_type');
        $this->db->join('donation_type',"donation_type.dontype_id=sub_donation_type.donation_type");
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_donation_type_sub_don()
    {
        $this->db->select("*");
        $this->db->from('sub_donation_type');
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_donation_type_sub_detail($id)
    { 
        $this->db->select('*');
        $this->db->from('sub_donation_type');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function donation_type_sub_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if($id!=null) // update
        {
            $this->db->where('id',$id);
            $this->db->update('sub_donation_type',$data);
        }
        else    //add
        {
            //$data['created_date']=time();
            $this->db->insert('sub_donation_type',$data);
            $id=$this->db->insert_id();

        }

        if(isset($titles)){
            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"sub_donation_type"));
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"sub_donation_type"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }


    function subcat_select($cat)
    {
        $this->db->select('sub_donation_type.id,sub_donation_type.sub_donation_type');
        $this->db->from('sub_donation_type');
        $this->db->join('donation_type',"donation_type.dontype_id=sub_donation_type.donation_type","left");
        $this->db->where('sub_donation_type.donation_type', $cat);
        $query = $this->db->get();
        return $query->result_array();
    }
    


        /* Whatsnew CODE */
    
    function get_all_whatsnew($institute)
    {
        $this->db->select("*");
        $this->db->from('whatsnew');
        $this->db->where('institute_id', $institute);
        $query = $this->db->get();
        return $query->result_array();
    }
     function get_whatsnew_detail($id)
    {
        $this->db->select('*');
        $this->db->from('whatsnew');
        $this->db->where('whatsnew_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function whatsnew_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if(isset($data["public"]) && count($data["public"])!=0){
            $data["public"]=1;
        } else {
            $data["public"]=0;
        }

        if(isset($data['default']) && $data['default']==1)
        {
            $this->db->set('default',0);
            $this->db->update('languages');
        }

        if(isset($data["titles"]) && count($data["titles"])!=0){
            $titles = $data["titles"];
        }
        unset($data["titles"]);


        if($id!=null) // update
        {
            $this->db->where('whatsnew_id',$id);
            $this->db->update('whatsnew',$data);
        }
        else    //add
        {
            //$data['created_date']=time();
            $this->db->insert('whatsnew',$data);
            $id=$this->db->insert_id();

        }


        if(isset($titles)){
            $this->db->delete('titles', array("relation_id"=>$id,"data_type"=>"whatsnew"));
            foreach ($titles as $key=>$value) {
                if($value!='') $this->db->insert('titles',array("language_id"=>$key,"title_caption"=>$value,"relation_id"=>$id,"data_type"=>"whatsnew"));
            }
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }
    


    /* PROGRAM & DETAILS URL CODE */

    // function get_all_program_url()
    // {

    //     $this->db->select("*,edu_map_course_head.COURSE_CODE as coursecode");
    //     $this->db->from('edu_map_course_head');
    //     $this->db->join('program_contents',"program_contents.relation_id=edu_map_course_head.MAP_COURSE_ID",'left');
    //     $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=edu_map_course_head.INST_ID",'left');
    //     $this->db->join('edu_course_dir',"edu_course_dir.COURSE_ID=edu_map_course_head.COURSE_ID",'left');
    //     $this->db->order_by('edu_map_course_head.MAP_COURSE_ID','DESC');
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

    function get_all_program_url()
    {
        $this->db->select("*,edu_map_course_head.COURSE_CODE as coursecode,program_contents.url as url, program_specialization.url as specialurl, program_contents.contents_id as contents_id, program_specialization.contents_id as contents_id_special");
        $this->db->from('edu_map_course_head');
        $this->db->join('program_contents',"program_contents.relation_id=edu_map_course_head.MAP_COURSE_ID",'left');
        $this->db->join('program_specialization',"program_specialization.relation_id=edu_map_course_head.MAP_COURSE_ID",'left');
        $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=edu_map_course_head.INST_ID",'left');
        $this->db->join('edu_course_dir',"edu_course_dir.COURSE_ID=edu_map_course_head.COURSE_ID",'left');
        $this->db->order_by('edu_map_course_head.MAP_COURSE_ID','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }


    function get_all_successstory()
    {
        $this->db->select("*");
        $this->db->from('successstory');
        $query = $this->db->get();
        return $query->result_array();
    }
     function get_successstory_detail($id)
    {
        $this->db->select('*');
        $this->db->from('successstory');
        $this->db->where('successstory_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function successstory_manipulate($data,$id=null)
    {
        $this->db->trans_start();

        if($id!=null) // update
        {
            $title      = $this->input->post('title');
            $name       = $this->input->post('name');
            $desc       = $this->input->post('description');
            $image      = $this->input->post('image');
            $public     = $this->input->post('public');

            $data = array( 
            'title'     =>  $title,
            'name'      => $name,
            'description'      => $desc,
            'image'     => $image,
            'public'    => $public,       
            );
            $this->db->where('successstory_id',$id);
            $this->db->update('successstory',$data);
        }
        else    //add
        {
            $title      = $this->input->post('title');
            $name       = $this->input->post('name');
            $desc       = $this->input->post('description');
            $image      = $this->input->post('image');
            $public     = $this->input->post('public');

            $data = array( 
            'title'     =>  $title,
            'name'      => $name,
            'description'      => $desc,
            'image'     => $image,
            'public'    => $public,       
            );
            $this->db->insert('successstory',$data);
            $id=$this->db->insert_id();
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    function get_all_user_enquiry_program()
    {
        
        // $this->db->select('user_enquiry_details.*,GROUP_CONCAT(edu_course_dir.COURSE_NAME) AS course_name');
        $this->db->select('*');
        $this->db->from('user_enquiry_details');
        // $this->db->join('edu_course_dir',"FIND_IN_SET(edu_course_dir.COURSE_ID,user_enquiry_details.course_id)",'left');
        $this->db->order_by('user_enquiry_details.id',"DESC");
        $this->db->group_by("user_enquiry_details.id");
        $query = $this->db->get();
        $result= ($query->num_rows() > 0)?$query->result_array():FALSE;

        //$str = $this->db->last_query();
        // echo "<pre>";
        // print_r($str);
        // exit;

        return $result;

    }


    function get_all_sidebarmenu($id){
        $this->db->select("permission,institute_id,pr_id");
                $this->db->from('module_permission ');
                $this->db->where('institute_id', $id );
                 $this->db->order_by('institute_id','ASC');
            $query = $this->db->get();
            //return $query->result_array();

             $return = $query->result_array();
            return count($return)!=0?$return[0]:null;
    }

    function get_sidebarchild_menu(){
        $this->db->select("*");
        $this->db->from('sidebar_module ');
        $this->db->where('status', '1' );
        $this->db->order_by('sort_order','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }


    /* Programme Specialization new */

    function get_programspecializationlang_detail($id)
    {
        $this->db->select('program_specialization.*,program_specialization.relation_id,program_specialization_widgets.relation_id as relation,program_specialization.public as public, program_specialization_list.public as public1, program_specialization_list.specialization_name as name, program_specialization.specialization_name as specialization_name, edu_map_course_head.MAP_COURSE_ID, edu_map_course_head.COURSE_ID , edu_course_dir.COURSE_ID, edu_course_dir.COURSE_NAME, program_specialization.url as urlold, program_specialization_list.url as url');
        $this->db->from('program_specialization');
        $this->db->join('program_specialization_list','program_specialization_list.sp_id=program_specialization.relation_id','left');
        $this->db->join('edu_map_course_head','edu_map_course_head.MAP_COURSE_ID=program_specialization_list.relation_id');
        $this->db->join('edu_course_dir',"edu_course_dir.COURSE_ID=edu_map_course_head.COURSE_ID");
        // $this->db->join('program_widgets','program_widgets.relation_id=program_specialization.contents_id','left');
        $this->db->join('program_specialization_widgets','program_specialization_widgets.relation_id=program_specialization.contents_id','left');
        $this->db->where('program_specialization.contents_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }
    
    function get_programspecializationlang_detail_course($relation_id)
    {
        $this->db->select('edu_course_dir.COURSE_NAME');
        $this->db->from('program_specialization');
        $this->db->join('program_specialization_list','program_specialization_list.sp_id=program_specialization.relation_id','left');
        $this->db->join('edu_map_course_head','edu_map_course_head.MAP_COURSE_ID=program_specialization_list.relation_id');
        $this->db->join('edu_course_dir',"edu_course_dir.COURSE_ID=edu_map_course_head.COURSE_ID");
        // $this->db->join('program_widgets','program_widgets.relation_id=program_specialization.contents_id','left');
        $this->db->join('program_specialization_widgets','program_specialization_widgets.relation_id=program_specialization.contents_id','left');
        $this->db->where('program_specialization_list.sp_id', $relation_id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0?$return[0]:null;
    }

    function get_all_programspecialization($data_type=null,$relation_id=null)
    {
        $this->db->select("*,program_specialization_list.public");
        $this->db->from('program_specialization_list');
        $this->db->join('edu_map_course_head','edu_map_course_head.MAP_COURSE_ID=program_specialization_list.relation_id');
        if($data_type!=null){
            $this->db->where('data_type',$data_type);
        }
        if($relation_id!=null){
            $this->db->where('relation_id',$relation_id);
        }
        $this->db->order_by('program_specialization_list.sp_id','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function programspecialization_manipulate($data,$id=null)
    {   
        //echo "<pre>"; print_r($data);exit();
        $this->db->trans_start();
        
        if($id!=null) // update
        {   
            $update['specialization_name']      = $data['specialization_name'];
            $update['data_type']                = 'program';
            $update['url']                      = $data['url'];
            $update['public']                   = $data['public'];
            $this->db->where('sp_id', $id);
            $this->db->update('program_specialization_list', $update);


            $upd['specialization_name'] = $this->input->post('specialization_name');
            $upd['language_id']         = $this->input->post('language_id');
            $upd['description']         = $this->input->post('description');
            $upd['read_more_in']        = $this->input->post('read_more_in');
            $upd['apply']               = $this->input->post('apply');
            $upd['data_type']           = $this->input->post('data_type');
            $upd['meta_title']          = $this->input->post('meta_title');
            $upd['meta_description']    = $this->input->post('meta_description');
            $upd['meta_keywords']       = $this->input->post('meta_keywords');
            $upd['meta_image']          = $this->input->post('meta_image');
            $upd['public']              = $this->input->post('public');
            $this->db->where('contents_id', $data['contents_id']);
            $this->db->update('program_specialization', $upd);


            // $this->db->where('sp_id', $id);
            // $this->db->update('program_specialization_list', $processdata2);

            // $this->db->where('contents_id', $id);
            // $this->db->update('program_specialization', $processdata);

            $save = [];
            $save_user_group = [];
            foreach ($data['widget_name'] as $key => $value) {
                $save['widget_name']            = $value;
                $save['p_id']                   = isset($data['p_id'][$key]) ? $data['p_id'][$key] : '';
                $save['widgets']                = $data['widgets'][$key];
                $save['publish']                = $data['publish'][$key];
                $save['widget_title_display']   = $data['widget_title_display'][$key];
                $save['widget_order']           = isset($data['widget_order'][$key]) ? $data['widget_order'][$key] : '';
                $save_group_inst[]  = $save;
            }

            // echo"<pre>";print_r($save_group_inst);exit();

            // $relation_id = $this->input->post('relation_id');
            $id2 = $this->input->post('p_id');
            // print_r($id2);exit();

            if($id2 == ''){ 
                if(isset($data['widgets_array_check']) && $data['widgets_array_check'] == 1){ //echo"m in insert";exit();
                    foreach($save_group_inst as $key => $result){ 
                        $this->db->insert('program_widgets',array("name"=>$result['widget_name'],"desvalue"=>$result['widgets'],"relation_id"=>$id,"publish"=>$result['publish'],"widget_title_display"=>$result['widget_title_display'],"widget_order"=>1));
                        // echo "<pre>";print_r($this->db->last_query());exit;
                    }
                }
            } 

            if(isset($data['widgets_array_check']) && $data['widgets_array_check'] == 2){ //echo"m in update";exit();
                if (!empty($save_group_inst))  {  //echo "<pre>"; print_r($save_group_inst);
                //echo "<br>---------------</br>";//exit();
                    foreach($save_group_inst as $key => $result){ 
                        if($result['p_id'] == ''){
                            //echo "empty<br>";
                            $last_row=$this->db->select('widget_order')->order_by('widget_order',"desc")->limit(1)->get('program_widgets')->row();
                            $w_order = $last_row->widget_order; 
                            $widget_order = $w_order + 1;
                            $this->db->insert('program_widgets',array("name"=>$result['widget_name'],"desvalue"=>$result['widgets'],"relation_id"=>$id,"publish"=>$result['publish'],"widget_title_display"=>$result['widget_title_display'],"widget_order"=>$widget_order));
                        } else {
                            //echo "not empty<br>";
                            $this->db->where('p_id',$result['p_id']);
                            $this->db->update('program_widgets',array("name"=>$result['widget_name'],"desvalue"=>$result['widgets'],"relation_id"=>$id,"publish"=>$result['publish'],"widget_title_display"=>$result['widget_title_display'])); 
                        }
                        //echo "<pre>";print_r($this->db->last_query());exit;
                        $str = $this->db->last_query();
                           
                        //echo "<pre>";
                        //print_r($str);
                        //echo "<br>+++++<br>";
                    }
                     // exit();
                }
            }

        }
        else    //add
        {   
            
            $insert['specialization_name']      = $data['specialization_name'];
            $insert['data_type']                = 'program';
            $insert['url']                      = $data['url'];
            $insert['public']                   = $data['public'];
            $insert['relation_id']              = $data['relation_id'];
            $this->db->insert('program_specialization_list', $insert);
            $insert_id = $this->db->insert_id();
            
            $ins['specialization_name'] = $this->input->post('specialization_name');
            $ins['language_id']         = $this->input->post('language_id');
            $ins['description']         = $this->input->post('description');
            $ins['read_more_in']        = $this->input->post('read_more_in');
            $ins['apply']               = $this->input->post('apply');
            $ins['data_type']           = 'program';
            $ins['meta_title']          = $this->input->post('meta_title');
            $ins['meta_description']    = $this->input->post('meta_description');
            $ins['meta_keywords']       = $this->input->post('meta_keywords');
            $ins['meta_image']          = $this->input->post('meta_image');
            $ins['public']              = $this->input->post('public');
            $ins['relation_id']         = $insert_id;
            $this->db->insert('program_specialization', $ins);
            $ins_id = $this->db->insert_id();

            $save = [];
            $save_user_group = [];
            foreach ($data['widget_name'] as $key => $value) {
                $save['widget_name']            = $value;
                $save['widgets']                = $data['widgets'][$key];
                $save['publish']                = $data['publish'][$key];
                $save['widget_title_display']   = $data['widget_title_display'][$key];
                $save_group_inst[]  = $save;
            }

            $i=0;
            foreach($save_group_inst as $result){     

                $this->db->insert('program_widgets',array("name"=>$result['widget_name'],"desvalue"=>$result['widgets'],"relation_id"=>$ins_id,"publish"=>$result['publish'],"widget_title_display"=>$result['widget_title_display'],"widget_order"=>1));


                $i++;    
            } 
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    function get_all_programspecializationlang($data_type=null,$relation_id=null)
    {
        $this->db->select("program_specialization.*,languages.*,program_specialization.public,program_specialization_list.relation_id as bkid,program_specialization_list.specialization_name as name");
        $this->db->from('program_specialization');
        $this->db->join('program_specialization_list','program_specialization_list.sp_id=program_specialization.relation_id');
        $this->db->join('languages','languages.language_id=program_specialization.language_id');
        if($data_type!=null){
            $this->db->where('program_specialization.data_type',$data_type);
        }
        if($relation_id!=null){
            $this->db->where('program_specialization.relation_id',$relation_id);
        }
        $this->db->order_by('program_specialization.contents_id','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function programspecializationlang_manipulate($data,$id=null)
    {   
        $this->db->trans_start();

        $specialization_name= $this->input->post('specialization_name');
        $description        = $this->input->post('description');
        $read_more_in       = $this->input->post('read_more_in');                                 
        $language_id        = $this->input->post('language_id'); 
        $apply              = $this->input->post('apply');
        $programme_keywords = $this->input->post('programme_keywords');
        $relation_id        = $this->input->post('relation_id');
        $data_type          = $this->input->post('data_type');
        $public12           = $this->input->post('public');
        $meta_title         = $this->input->post('meta_title');
        $meta_description   = $this->input->post('meta_description');
        $meta_keywords      = $this->input->post('meta_keywords');
        $meta_image         = $this->input->post('meta_image');
        //$programme_keywords = $this->input->post('programme_keywords');
        $url                = $this->input->post('url');
        $title_name_2       = $this->input->post('title_name_2');

        $processdata    = array(
                                'specialization_name'=>  $specialization_name,
                                'title_name_2'      =>  $title_name_2,
                                'description'       =>  $description,
                                'read_more_in'      =>  $read_more_in,
                                'language_id'       =>  $language_id,
                                'apply'             =>  $apply,
                                'programme_keywords'=>  $programme_keywords,
                                'relation_id'       =>  $relation_id,
                                'data_type'         =>  'program',
                                'meta_title'        =>  $meta_title,
                                'meta_description'  =>  $meta_description,
                                'meta_keywords'     =>  $meta_keywords,
                                'meta_image'        =>  $meta_image,
                                'public'            => $public12
                            );

        $prspecial = array(
            'url'       => $url
        );

        if($id!=null) // update
        {   
            $this->db->where('contents_id', $id);
            $this->db->update('program_specialization', $processdata);

            $this->db->where('sp_id', $relation_id);
            $this->db->update('program_specialization_list', $prspecial);

            $save = [];
            $save_user_group = [];
            foreach ($data['widget_name'] as $key => $value) {
                $save['widget_name']            = $value;
                $save['p_id']                   = isset($data['p_id'][$key]) ? $data['p_id'][$key] : '';
                $save['widgets']                = $data['widgets'][$key];
                $save['publish']                = $data['publish'][$key];
                $save['widget_title_display']   = $data['widget_title_display'][$key];
                $save['widget_order']           = isset($data['widget_order'][$key]) ? $data['widget_order'][$key] : '';
                $save_group_inst[]  = $save;
            }

            // echo"<pre>";print_r($save_group_inst);exit();

            // $relation_id = $this->input->post('relation_id');
            $id2 = $this->input->post('p_id');
            // print_r($id2);exit();

            if($id2 == ''){ 
                if(isset($data['widgets_array_check']) && $data['widgets_array_check'] == 1){ //echo"m in insert";exit();
                    foreach($save_group_inst as $key => $result){ 
                        $this->db->insert('program_specialization_widgets',array("name"=>$result['widget_name'],"desvalue"=>$result['widgets'],"relation_id"=>$id,"publish"=>$result['publish'],"widget_title_display"=>$result['widget_title_display'],"widget_order"=>1));
                        // echo "<pre>";print_r($this->db->last_query());exit;
                    }
                }
            } 

            if(isset($data['widgets_array_check']) && $data['widgets_array_check'] == 2){ //echo"m in update";exit();
                if (!empty($save_group_inst))  {  //echo "<pre>"; print_r($save_group_inst);
                //echo "<br>---------------</br>";//exit();
                    foreach($save_group_inst as $key => $result){ 
                        if($result['p_id'] == ''){
                            //echo "empty<br>";
                            $last_row=$this->db->select('widget_order')->order_by('widget_order',"desc")->limit(1)->get('program_specialization_widgets')->row();
                            $w_order = $last_row->widget_order; 
                            $widget_order = $w_order + 1;
                            $this->db->insert('program_specialization_widgets',array("name"=>$result['widget_name'],"desvalue"=>$result['widgets'],"relation_id"=>$id,"publish"=>$result['publish'],"widget_title_display"=>$result['widget_title_display'],"widget_order"=>$widget_order));
                        } else {
                            //echo "not empty<br>";
                            $this->db->where('p_id',$result['p_id']);
                            $this->db->update('program_specialization_widgets',array("name"=>$result['widget_name'],"desvalue"=>$result['widgets'],"relation_id"=>$id,"publish"=>$result['publish'],"widget_title_display"=>$result['widget_title_display'])); 
                        }
                        //echo "<pre>";print_r($this->db->last_query());exit;
                        $str = $this->db->last_query();
                           
                        //echo "<pre>";
                        //print_r($str);
                        //echo "<br>+++++<br>";
                    }
                     // exit();
                }
            }

        }
        else    //add
        {   
            $processdata['created_date'] = date('d/m/Y');
            $this->db->insert('program_specialization', $processdata);
            $id = $this->db->insert_id();

            $save = [];
            $save_user_group = [];
            foreach ($data['widget_name'] as $key => $value) {
                $save['widget_name']            = $value;
                $save['widgets']                = $data['widgets'][$key];
                $save['publish']                = $data['publish'][$key];
                $save['widget_title_display']   = $data['widget_title_display'][$key];
                $save_group_inst[]  = $save;
            }

            $i=0;
            foreach($save_group_inst as $result){     

                $this->db->insert('program_specialization_widgets',array("name"=>$result['widget_name'],"desvalue"=>$result['widgets'],"relation_id"=>$id,"publish"=>$result['publish'],"widget_title_display"=>$result['widget_title_display'],"widget_order"=>1));


                $i++;    
            } 
        }

        $this->db->trans_complete();
        // end TRANSACTION
        if ($this->db->trans_status() == FALSE)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    function get_language_name_specialization($id)
    {
        $this->db->select("languages.language_id as language_id,languages.language_name as language_name");
        $this->db->from('languages');
        $this->db->join('program_specialization',"program_specialization.language_id=languages.language_id",'left');
        $this->db->where('program_specialization.contents_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }


    function get_all_keywords()
    {
        $this->db->select('*');
        $this->db->from('keyword_search_count');
        $query = $this->db->get();
        return  $query->result_array();
    }

    function keywords_query($sql) {
        $query = $this->db->query($sql);
        if(is_object($query))
            return $query->result_array();
        else
            return $query;
    }
	
	// start user module changes

    function get_users_data($conditions=[], $limit='', $offset=0, $allcount='')
    {
        $order          = '';
        $where          = '1=1';
        $like_sql       = '';
        $limit_offset   = '';

        // Like
        if(isset($_GET['search']) && !empty($_GET['search']) && $_GET['search'] != 'undefined')
        {
            $term       = $_GET['search'];
            $like_sql   = ' AND
                            (
                                u.fullname LIKE "%'.$term.'%" ESCAPE "!"
                                OR u.firstname LIKE "%'.$term.'%" ESCAPE "!"
                                OR u.lastname LIKE "%'.$term.'%" ESCAPE "!"
                                OR u.username LIKE "%'.$term.'%" ESCAPE "!"
                                OR u.email LIKE "%'.$term.'%" ESCAPE "!"
                                OR g.group_name LIKE "%'.$term.'%" ESCAPE "!"
                            )
                        ';
        }

        // Where
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $where .= ' AND '.$key.'='.$value;
            }
        }

        // Custom Filter
        if(isset($_GET['custom_search']) && !empty($_GET['custom_search']))
        {
            $login_type                 = isset($_GET['custom_search']['login_type']) ? $_GET['custom_search']['login_type'] : [];
            $user_group                 = isset($_GET['custom_search']['user_group']) ? $_GET['custom_search']['user_group'] : [];
            $user_institute                 = isset($_GET['custom_search']['user_institute']) ? $_GET['custom_search']['user_institute'] : [];
            $status                     = isset($_GET['custom_search']['status']) ? $_GET['custom_search']['status'] : '';
            $user_username                     = isset($_GET['custom_search']['user_username']) ? $_GET['custom_search']['user_username'] : '';
            $user_fullname                     = isset($_GET['custom_search']['user_fullname']) ? $_GET['custom_search']['user_fullname'] : '';
            $user_email                     = isset($_GET['custom_search']['user_email']) ? $_GET['custom_search']['user_email'] : '';
         
            if(!empty($login_type))
            {
                $find_or    = '(';
                $space_or   = '';
                foreach ($login_type as $ikey => $ivalue) {
                    if($ikey > 0)
                    {
                        $space_or = ' OR ';
                    }
                    $find_or .= $space_or.'FIND_IN_SET('.$ivalue.', u.login_type)';
                }
                $find_or    .= ')';
                $where      .= ' AND '.$find_or;
            }
            
            if(!empty($user_group))
            {
                $g_find_or    = '(';
                $g_space_or   = '';
                foreach ($user_group as $gkey => $gvalue) {
                    if($gkey > 0)
                    {
                        $g_space_or = ' OR ';
                    }
                    //$g_find_or .= $g_space_or.'FIND_IN_SET('.$gvalue.', u.group_id)';
                    $g_find_or .= $g_space_or.'FIND_IN_SET('.$gvalue.', ugi.group_id)';
                }
                $g_find_or  .= ')';
                $where      .= ' AND '.$g_find_or;
            }

            if(!empty($user_institute))
            {
                $ui_find_or    = '(';
                $ui_space_or   = '';
                foreach ($user_institute as $uikey => $uivalue) {
                    if($uikey > 0)
                    {
                        $ui_space_or = ' OR ';
                    }
                    $ui_find_or .= $ui_space_or.'FIND_IN_SET('.$uivalue.', ugi.institute_id)';
                }
                $ui_find_or  .= ')';
                $where      .= ' AND '.$ui_find_or;
            }

            if($status != '')
            {
                $where  .= ' AND u.status IN ('.implode(',', $status).')';
            }

            if(!empty($user_username))
            {
                $where  .= ' AND u.username IN ('."'".implode ( "', '", $user_username )."'".')';
            }

            if(!empty($user_fullname))
            {
                $where  .= ' AND u.fullname IN ('."'".implode("', '", $user_fullname)."'".')';
            }

            if(!empty($user_email))
            {
                $where  .= ' AND u.email IN ('."'".implode("', '", $user_email)."'".')';
            }
        }

        // Order
        if(isset($_GET['order']) && !empty($_GET['order']) && isset($_GET['sort']) && !empty($_GET['sort']))
        {
            /*if($_GET['sort'] == 'created_on')
            {
                $sort_by = 'u.created_on';
            }*/
            if($_GET['sort'] == 'created_date')
            {
                $sort_by = 'u.created_date';
            }
            else if($_GET['sort'] == 'fullname')
            {
                $sort_by = 'u.fullname';
            }
            else
            {
                $sort_by = 'u.id';
            }

            if(isset($_GET['order']) && !empty($_GET['order']))
            {
                $by      = $_GET['order'];
            }
            else
            {
                $by      = 'DESC';
            }
            $order       = 'ORDER BY '.$sort_by.' '.$by;
        } 
        else
        {
            $order       = 'ORDER BY u.user_id DESC';
        }

        // Limit
        if(empty($allcount))
        {
            if(isset($_GET['limit']) && $_GET['limit'] != -1)
            {
                $offset = $_GET['offset'];
                $limit = $_GET['limit'];
            }
            else if($limit)
            {
                $limit = $limit;
            }
            $offset = !empty($offset) ? $offset : 0;
            $limit_offset = !empty($limit) ? 'LIMIT '.$limit.' OFFSET '.$offset : '';
        }

        /*$sql =  '
                    SELECT u.user_id, u.username, u.fullname, u.firstname, u.lastname, u.email, u.status, u.login_type, g.group_id, g.group_name, i.INST_ID, i.INST_NAME FROM user_groups_institute ugi LEFT JOIN users u ON ugi.user_id = u.user_id LEFT JOIN groups g ON ugi.group_id = g.group_id LEFT JOIN edu_institute_dir i ON ugi.institute_id = i.INST_ID
                    WHERE '.$where.'
                    '.$like_sql.'
                    '.$order.'
                    '.$limit_offset.'
                ';*/

        $sql =  '
                    SELECT DISTINCT(u.user_id), u.username, u.fullname, u.firstname, u.lastname, u.email, u.status, u.login_type, GROUP_CONCAT(DISTINCT g.group_id SEPARATOR " | ") as group_id , GROUP_CONCAT(DISTINCT g.group_name SEPARATOR " | ") as group_name , GROUP_CONCAT(DISTINCT i.INST_ID SEPARATOR " | ") as INST_ID , GROUP_CONCAT(DISTINCT i.INST_NAME SEPARATOR " | ") as INST_NAME, GROUP_CONCAT(DISTINCT up.pr_id SEPARATOR " | "), GROUP_CONCAT(DISTINCT CONCAT(g.group_name,":",up.pr_id) SEPARATOR " | ") as permission FROM users u LEFT JOIN user_groups_institute ugi ON u.user_id = ugi.user_id LEFT JOIN groups g ON ugi.group_id = g.group_id LEFT JOIN edu_institute_dir i ON ugi.institute_id = i.INST_ID LEFT JOIN user_permissions up on ugi.group_id = up.pr_group_id AND ugi.institute_id = up.pr_inst_id
                    WHERE '.$where.'
                    '.$like_sql.' group by u.user_id
                    '.$order.'
                    '.$limit_offset.'
                ';
        $query = $this->db->query($sql);
        //echo "<pre>";print_r($this->db->last_query());exit;

        if($allcount == 'allcount')
        {
            return $query->num_rows();
        }
        else
        {
            return $query->result();
        }
    }

    function get_user_details($id='')
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_id', $id);
        /*if($this->session->userdata('role') != 1)
        {
            $this->db->where('created_by', $this->session->userdata('user_id'));
        }*/
        $this->db->where('status !=', '-1');
        $query = $this->db->get();
        return $query->row_array();
    }

    function change_user_status($id='', $status)
    {
        if($status == -1)
        {
            $this->db->where('user_id', $id);
            $this->db->delete('users'); 

            return 1;
        }
        else
        {
            $update['status']           = $status;
            //$update['modified_on']      = date('Y-m-d H:i:s');
            //$update['modified_by']      = $this->session->userdata('user_id');

            $this->db->where('user_id', $id);
            $this->db->update('users', $update);

            return $this->db->affected_rows();
        }
        
    }
    
    function get_all_institutes()
    {
        $this->db->select("INST_ID,INST_NAME");
        $this->db->from('edu_institute_dir');
        $this->db->where('ENABLE_DISABLE','E');
        $this->db->order_by('INST_NAME','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
	function get_filtered_user_email_id($login_type,$user_group,$institutes,$status,$username,$fullname,$email)
    {
        $where = '1=1 and u.email !=""';
        //echo "login_type = ".$login_type."<br>";
        if(!empty($login_type))
            {
                $where  .= ' AND u.login_type IN ('.$login_type.')';
            }
            
            if(!empty($user_group))
            {
                $where  .= ' AND ugi.group_id IN ('.$user_group.')';
            }

            if(!empty($user_institute))
            {
                $where  .= ' AND ugi.institute_id IN ('.$user_institute.')';
            }

            if($status != '')
            {
                $where  .= ' AND u.status IN ('.$status.')';
            }

            if($username != '')
            {
                $where  .= ' AND u.username IN ('."'".str_replace(",", "','", $username)."'".')';
            }

            if($fullname != '')
            {
                $where  .= ' AND u.fullname IN ('."'".str_replace(",", "','", $fullname)."'".')';
            }

            if($email != '')
            {
                $where  .= ' AND u.email IN ('."'".str_replace(",", "','", $email)."'".')';
            }

            $sql =  '
                    SELECT distinct(u.user_id), u.email FROM user_groups_institute ugi LEFT JOIN users u ON ugi.user_id = u.user_id
                    WHERE '.$where.'
                    ';
        $query = $this->db->query($sql);
        //echo "<pre>";print_r($this->db->last_query());exit;
        return $query->result_array();

    }

    function get_all_username_options()
    {
        $this->db->select("distinct(username)");
        $this->db->from('users');
        //$this->db->where('status',1);
        $this->db->order_by('username','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_user_fullname_options()
    {
        $this->db->select("distinct(user_id),fullname");
        $this->db->from('users');
        //$this->db->where('status',1);
        $this->db->order_by('fullname','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_user_email_options()
    {
        $this->db->select("distinct(user_id),email");
        $this->db->from('users');
        //$this->db->where('status',1);
        $this->db->where('email !=','');
        $this->db->order_by('email','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function update_user_password($password,$user_id)
    {
        $this->db->set('password', $password);
        $this->db->where('user_id', $user_id);
        $this->db->update('users');
        return true;
    }
	
	function get_user_email_id($user_id)
    {
        $this->db->select("user_id,email");
        $this->db->from('users');
        //$this->db->where('status',1);
        $this->db->where('user_id =',$user_id);
        $query = $this->db->get();
        return $query->result_array();
    }
	
	function get_user_groupDetails($user_id)
    {
        $this->db->select("group_id,institute_id");
        $this->db->from('user_groups_institute');
        //$this->db->where('status',1);
        $this->db->where('user_id =',$user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_userApplicationPermissionByGroupAndInstituteId($group_id,$institute_id)
    {
        $this->db->simple_query('SET SESSION group_concat_max_len=20000');   // used this line to increase group_concat limit, by default it is 1024 character.
        $this->db->select("up.permissions,up.pr_group_id,pr_inst_id, g.group_name, i.INST_NAME,group_concat(upm.pm_name SEPARATOR ',') as permission_name");
        $this->db->from('user_permissions up');
        $this->db->join('groups g','up.pr_group_id = g.group_id');
        $this->db->join('edu_institute_dir i','up.pr_inst_id = i.INST_ID');
        $this->db->join('user_permission_method upm',"FIND_IN_SET(upm.pm_id,up.permissions)",'left');
        //$this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID,users.institute_id)",'left');
        $this->db->where('up.pr_group_id',$group_id);
        $this->db->where('up.pr_inst_id',$institute_id);
        $this->db->group_by("up.pr_group_id");
        $query = $this->db->get();
        // $str = $this->db->last_query();
        // echo "<pre>"; print_r($str); exit;
        return $query->result_array();
    }

    function get_userAddPagePermissionByGroupAndInstituteId($group_id,$institute_id)
    {
        $this->db->simple_query('SET SESSION group_concat_max_len=20000');   // used this line to increase group_concat limit, by default it is 1024 character.
        $this->db->select("up.add_permissions, up.pr_group_id,pr_inst_id, g.group_name, i.INST_NAME,group_concat(p.page_name SEPARATOR ',') as add_page_name");
        $this->db->from('user_page_permissions up');
        $this->db->join('groups g','up.pr_group_id = g.group_id');
        $this->db->join('edu_institute_dir i','up.pr_inst_id = i.INST_ID');
        $this->db->join('page p',"FIND_IN_SET(p.page_id,up.add_permissions)",'left');
        //$this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID,users.institute_id)",'left');
        $this->db->where('up.pr_group_id',$group_id);
        $this->db->where('up.pr_inst_id',$institute_id);
        $this->db->group_by("up.pr_group_id");
        $query = $this->db->get();
        // $str = $this->db->last_query();
        // echo "<pre>"; print_r($str); exit;
        return $query->result_array();
    }

    function get_userEditPagePermissionByGroupAndInstituteId($group_id,$institute_id)
    {
        $this->db->simple_query('SET SESSION group_concat_max_len=20000');   // used this line to increase group_concat limit, by default it is 1024 character.
        $this->db->select("up.edit_permissions, up.pr_group_id,pr_inst_id, g.group_name, i.INST_NAME,group_concat(p.page_name SEPARATOR ',') as edit_page_name");
        $this->db->from('user_page_permissions up');
        $this->db->join('groups g','up.pr_group_id = g.group_id');
        $this->db->join('edu_institute_dir i','up.pr_inst_id = i.INST_ID');
        $this->db->join('page p',"FIND_IN_SET(p.page_id,up.edit_permissions)",'left');
        //$this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID,users.institute_id)",'left');
        $this->db->where('up.pr_group_id',$group_id);
        $this->db->where('up.pr_inst_id',$institute_id);
        $this->db->group_by("up.pr_group_id");
        $query = $this->db->get();
        // $str = $this->db->last_query();
        // echo "<pre>"; print_r($str); exit;
        return $query->result_array();
    }

    function get_userDeletePagePermissionByGroupAndInstituteId($group_id,$institute_id)
    {
        $this->db->simple_query('SET SESSION group_concat_max_len=20000');   // used this line to increase group_concat limit, by default it is 1024 character.
        $this->db->select("up.delete_permissions,pr_inst_id, g.group_name, i.INST_NAME,group_concat(p.page_name SEPARATOR ',') as delete_page_name");
        $this->db->from('user_page_permissions up');
        $this->db->join('groups g','up.pr_group_id = g.group_id');
        $this->db->join('edu_institute_dir i','up.pr_inst_id = i.INST_ID');
        $this->db->join('page p',"FIND_IN_SET(p.page_id,up.delete_permissions)",'left');
        //$this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID,users.institute_id)",'left');
        $this->db->where('up.pr_group_id',$group_id);
        $this->db->where('up.pr_inst_id',$institute_id);
        $this->db->group_by("up.pr_group_id");
        $query = $this->db->get();
        // $str = $this->db->last_query();
        // echo "<pre>"; print_r($str); exit;
        return $query->result_array();
    }

    function get_userViewPagePermissionByGroupAndInstituteId($group_id,$institute_id)
    {
        $this->db->simple_query('SET SESSION group_concat_max_len=20000');   // used this line to increase group_concat limit, by default it is 1024 character.
        $this->db->select("up.view_permissions,pr_inst_id, g.group_name, i.INST_NAME,group_concat(p.page_name SEPARATOR ',') as view_page_name");
        $this->db->from('user_page_permissions up');
        $this->db->join('groups g','up.pr_group_id = g.group_id');
        $this->db->join('edu_institute_dir i','up.pr_inst_id = i.INST_ID');
        $this->db->join('page p',"FIND_IN_SET(p.page_id,up.delete_permissions)",'left');
        //$this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID,users.institute_id)",'left');
        $this->db->where('up.pr_group_id',$group_id);
        $this->db->where('up.pr_inst_id',$institute_id);
        $this->db->group_by("up.pr_group_id");
        $query = $this->db->get();
        // $str = $this->db->last_query();
        // echo "<pre>"; print_r($str); exit;
        return $query->result_array();
    }
	
	function get_userPagePermissionByGroupAndInstituteId($group_id,$institute_id)
    {
        
        $this->db->select("up.add_permissions, up.edit_permissions, up.view_permissions, up.delete_permissions, up.pr_group_id, pr_inst_id, g.group_name, i.INST_NAME");
        $this->db->from('user_page_permissions up');
        $this->db->join('groups g','up.pr_group_id = g.group_id');
        $this->db->join('edu_institute_dir i','up.pr_inst_id = i.INST_ID');
        $this->db->join('page p',"FIND_IN_SET(p.page_id,up.delete_permissions)",'left');
        //$this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID,users.institute_id)",'left');
        $this->db->where('up.pr_group_id',$group_id);
        $this->db->where('up.pr_inst_id',$institute_id);
        $this->db->group_by("up.pr_group_id");

        // $this->db->select('*');
        // $this->db->from('user_page_permissions');
        // $this->db->where('pr_id', $id);
        $query = $this->db->get();
        $return = $query->result_array();
        return $return;
        //return count($return)!=0?$return[0]:null;
    }
	
	function get_other_page($page_ids=[], $inst_id)
    {
        $this->db->select('*');
        $this->db->from('page');
        // $this->db->where('page_id', implode(',', $page_ids));
        //$this->db->where('`page_id` NOT IN ('.implode(',', $page_ids).')');
        if($page_ids)
        {
            $this->db->where('`page_id` NOT IN ('.implode(',', $page_ids).')');
        }
        
        if($inst_id)
        {
            $this->db->where('institute_id', $inst_id);
        }
        $query = $this->db->get();
        // echo "<pre>";print_r($this->db->last_query());exit;
        return $query->result_array();
    }
	
    // end user module changes
	
	// start page content history code
    
    function get_page_content_history_data($conditions=[], $limit='', $offset=0, $allcount='')
    {
        $order          = '';
        $where          = '1=1';
        $like_sql       = '';
        $limit_offset   = '';

        // default filter value
        if(isset($_GET['page_id']) && !empty($_GET['page_id']) && $_GET['page_id'] != 'undefined')
        {
            $where .= ' AND pch.page_id = '.$_GET['page_id'];
        }

        if(isset($_GET['content_id']) && !empty($_GET['content_id']) && $_GET['content_id'] != 'undefined')
        {
            $where .= ' AND pch.extension_id = '.$_GET['content_id'];
        }

        // Like
        if(isset($_GET['search']) && !empty($_GET['search']) && $_GET['search'] != 'undefined')
        {
            $term       = $_GET['search'];
            $like_sql   = ' AND
                            (
                                pch.name LIKE "%'.$term.'%" ESCAPE "!"
                                OR pch.description LIKE "%'.$term.'%" ESCAPE "!"                                
                            )
                        ';
        }

        // Where
        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $where .= ' AND '.$key.'='.$value;
            }
        }

        // Custom Filter
        if(isset($_GET['custom_search']) && !empty($_GET['custom_search']))
        {
            // $login_type                 = isset($_GET['custom_search']['login_type']) ? $_GET['custom_search']['login_type'] : [];
            
            // if(!empty($login_type))
            // {
            //     $find_or    = '(';
            //     $space_or   = '';
            //     foreach ($login_type as $ikey => $ivalue) {
            //         if($ikey > 0)
            //         {
            //             $space_or = ' OR ';
            //         }
            //         $find_or .= $space_or.'FIND_IN_SET('.$ivalue.', u.login_type)';
            //     }
            //     $find_or    .= ')';
            //     $where      .= ' AND '.$find_or;
            // }
            
        }

        // Order
        if(isset($_GET['order']) && !empty($_GET['order']) && isset($_GET['sort']) && !empty($_GET['sort']))
        {
            /*if($_GET['sort'] == 'created_on')
            {
                $sort_by = 'u.created_on';
            }*/
            if($_GET['sort'] == 'created_on')
            {
                $sort_by = 'pch.created_on';
            }
            else if($_GET['sort'] == 'name')
            {
                $sort_by = 'pch.name';
            }
            else
            {
                $sort_by = 'pch.pch_id';
            }

            if(isset($_GET['order']) && !empty($_GET['order']))
            {
                $by      = $_GET['order'];
            }
            else
            {
                $by      = 'DESC';
            }
            $order       = 'ORDER BY '.$sort_by.' '.$by;
        } 
        else
        {
            $order       = 'ORDER BY pch.pch_id DESC';
        }

        // Limit
        if(empty($allcount))
        {
            if(isset($_GET['limit']) && $_GET['limit'] != -1)
            {
                $offset = $_GET['offset'];
                $limit = $_GET['limit'];
            }
            else if($limit)
            {
                $limit = $limit;
            }
            $offset = !empty($offset) ? $offset : 0;
            $limit_offset = !empty($limit) ? 'LIMIT '.$limit.' OFFSET '.$offset : '';
        }

        $sql =  '
                    SELECT DISTINCT(pch.pch_id), pch.page_id, pch.extension_id, pch.name, pch.description, pch.meta_title, pch.meta_description, pch.meta_keywords, pch.status, pch.created_on, l.language_name, concat(u.firstname," ",u.lastname) as userfullname, p.slug, pch.type, pch.modified_on FROM page_content_history pch LEFT JOIN languages l ON pch.language_id = l.language_id LEFT JOIN users u ON pch.created_by = u.user_id LEFT JOIN page p ON pch.page_id = p.page_id
					
                    WHERE '.$where.'
                    '.$like_sql.'
                    '.$order.'
                    '.$limit_offset.'
                ';
        $query = $this->db->query($sql);
        //echo "<pre>";print_r($this->db->last_query());exit;

        if($allcount == 'allcount')
        {
            return $query->num_rows();
        }
        else
        {
            return $query->result();
        }
    }

    function page_content_history_insert($page_content_history_data)
    {
        $response['status']         = 'failed';
        $table                      = 'page_content_history';

        $res                        = $this->db->insert($table, $page_content_history_data);
        $insert_id = $this->db->insert_id();

        if($res)
        {
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

    function get_page_content_history_records($page_id,$content_id,$pch_id)
    {
        $this->db->select("*");
        $this->db->from('page_content_history');
        //$this->db->where('page_id =',$page_id);
        //$this->db->where('extension_id =',$contents_id);
        $this->db->where('pch_id =',$pch_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function update_page_content_by_history_records($page_id,$content_id,$pch_id,$update_content_data,$update_type_in_cintent_history)
    {
        $response['status']         = 'error';
        $table                      = 'extensions';
        $table_two                  = 'page_content_history';

        $this->db->where('extension_id', $content_id);
        $update                     = $this->db->update($table, $update_content_data);

        // $str = $this->db->last_query();
   
        // echo "<pre>";
        // print_r($str);
        // echo "<br>----------------<br>";

        if($update)
        {
            $response['status']     = 'success';
            $response[$col]         = $val;
            
            $this->db->where('pch_id', $pch_id);
            $update                     = $this->db->update($table_two, $update_type_in_cintent_history);
        }
        else
        {
            $response['status']     = 'error';
            $response['message']    = $this->db->_error_message();
        }
        return $response;
    }
    // end page content history code
}