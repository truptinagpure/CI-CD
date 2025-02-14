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
class Projects_model extends CI_Model
{
    private $user_id;
    private $table;
    function __construct()
    {
        parent::__construct();
        $CI =& get_instance();
        $this->user_id = $CI->session->userdata['user_id'];
        $this->table = 'projects';
    }

    // function get_all_projects()
    // {
    //     $this->db->select("*");
    //     $this->db->from($this->table);
    //     $this->db->order_by('project_id', 'DESC');
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

    function get_all_projects_category($inst_id,$public)
    {   
   
        $this->db->where('institute_id', $inst_id);
        $this->db->where('project_category.status =', $public);
        $this->db->select("*");
        $this->db->from('project_category');
        $this->db->order_by('id  ', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_projects($id)
    {
        $this->db->select("*");
        $this->db->from($this->table);
       if(!empty($id)){
        $this->db->where("institute_id", $id);
    }
        $this->db->order_by('project_id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_project($id='', $conditions=[])
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->join('project_content', 'project_content.project_id=projects.project_id');
        $this->db->where('projects.project_id', $id);
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

    function manage_projects($data=[], $id='', $filename, $fileNamefeatured, $fileLogo,$project_documents)
    {  
        $allowed_inst_ids           = [];
        $allowed_dept_ids           = [];
        $save_data                  = [];
        foreach ($_POST['institute_id'] as $key => $value) 
        {
            $allowed_inst_ids[] = $value;
        }

        $save_data = !empty($allowed_inst_ids) ? implode(',', $allowed_inst_ids) : '';


        $save_datadept                  = [];
        foreach ($_POST['department_id'] as $key => $value) 
        {
            $allowed_dept_ids[] = $value;
        }

        $save_datadept = !empty($allowed_dept_ids) ? implode(',', $allowed_dept_ids) : '';

        $allowed_lab_ids           = [];
        $save_lab                  = [];
  
        if($id)
        {
            if(!empty($this->get_project($id)))
            {  //$update['lab_id']           = $data['Existing'];
             // $update['contact_no']       = $data['user_array_checkexi'];
                $update['name']             = $data['name'];
                $update['short_title']      = $data['short_title'];
                $update['area_id']          = $data['area_id'];
                 $update['area_specialization'] = $data['area_specialization'];
                $update['institute_id']     = $save_data;
                $update['featured_project'] = $data['featured_project'];
                $update['project_status']   = $data['project_status'];
                $update['category_id']      = $data['category_id'];
                $update['project_level']    = $data['project_level'];
                $update['department']       = $save_datadept;
                
              //   $update['Written_by']    = $data['Written_by'];
                $update['tags']             = $data['tags'];
                $update['date']             =$data['date'];
                $update['end_date']             =$data['end_date'];
                $update['duration']         = $data['duration'];
                $update['type']             = $data['type'];
                $update['pdf_path']         = $data['pdf_path'];
                $update['public']           = $data['public'];
                  $update['consultancy_offered_by']           = $data['consultancy_offered_by'];
                $update['modified_on']      = date('Y-m-d H:i:s');
                $update['modified_by']      = $this->user_id;
                $this->db->where('project_id', $id);
                $this->db->update($this->table, $update);

                if($fileNamefeatured!=''){
                    $this->db->where('project_id', $id);
                    $this->db->update('projects', array('image' => $fileNamefeatured));
                }

                if($filename!=''){ 
                  $filename1 = explode(',',$filename);
                  foreach($filename1 as $file){
                    $file_data = array(
                        'image' => $file,
                        'type' => 'project_banner_images',
                        'area_id' => $id
                    );
                    $this->db->insert('area_banner_images', $file_data);
                  }
                }


                $upd['project_id']    = $data['project_id'];
                $upd['language_id']   = $data['language_id'];
                $upd['title']         = $data['name'];
                $upd['description']   = $data['description'];
                $upd['content']       = $data['content'];
                $upd['public']        = $data['public'];
                $upd['created_on']    = date('Y-m-d H:i:s');
                $upd['created_by']    = $this->user_id;
                $upd['modified_on']   = date('Y-m-d H:i:s');
                $upd['modified_by']   = $this->user_id;
                $this->db->where('project_content_id', $data['project_content_id']);
                $this->db->update('project_content', $upd);

            if(!empty($project_documents))
                {   
                    foreach ($project_documents as $key => $value) {
                        $save_document['document'] = $value;
                        $save_document['relation_id'] = $id;
                        $this->db->insert('project_documents',array("document"=>$value,"relation_id"=>$id));
                    }
                }
                if($id!=null) 
                {
                    if ($fileLogo != '') 
                    {
                        $save = [];
                        $save_user_group = [];
                        foreach ($data['pname'] as $key => $value) 
                        {

                            $save['name'] = $value;
                            $save['amount'] = $data['amount'][$key];
                            $save['pid'] = $data['id2'][$key];
                            $save_group_inst[] = $save;
                        }


                        $project_id = $this->input->post('project_id');
                        $id2 = $this->input->post('id2');

                        if($id2 == '')
                        { 

                            if(isset($data['user_array_check']) && $data['user_array_check'] == 1){ 
                                foreach($save_group_inst as $result){     
                                    $this->db->insert('project_donor',array("name"=>$result['name'],"amount"=>$result['amount'],"project_id"=>$project_id));
                                    $pinsert[] = $this->db->insert_id();
                                }

                                    if($fileLogo!='' ){
                                            $filename1 = explode(',',$fileLogo);
                                            $key1 = 0;
                                            foreach($filename1 as $file){
                                                $file_data = array(
                                                'logo' => $file
                                                );
                                                $this->db->where('pid', $pinsert[$key1]);
                                                $this->db->update('project_donor',$file_data);
                                                ++$key1;
                                            }
                                    }
                            }
                        } 

                        if(isset($data['user_array_check']) && $data['user_array_check'] == 2)
                        { 
                            
                            if (!empty($save_group_inst))  {  
                                foreach($save_group_inst as $key => $result){ 
                                    if($result['pid'] == ''){
                                        $this->db->insert('project_donor',array("name"=>$result['name'],"amount"=>$result['amount'],"project_id"=>$project_id));
                                        $pinsert[] = $this->db->insert_id();

                                        if($fileLogo!='' ){
                                            $filename1 = explode(',',$fileLogo);
                                            $key1 = 0;
                                            foreach($filename1 as $file){
                                                $file_data = array(
                                                'logo' => $file
                                                );
                                                $this->db->where('pid', $pinsert[$key1]);
                                                $this->db->update('project_donor',$file_data);
                                                ++$key1;
                                            }
                                        }
                                    }


                                    $this->db->where('pid',$result['pid']);
                                    $this->db->update('project_donor',array("name"=>$result['name'],"amount"=>$result['amount'],"project_id"=>$project_id)); 
                                }
                            }
                        } 
                    }



                    if ($data['sig_name'] != '') 
                    {
                        $save = [];
                        $save_signature_group = [];
                        foreach ($data['sig_name'] as $key => $value) 
                        {

                            $save['name'] = $value;
                            $save['BSCIL_MEMBER_ID'] = $data['sig_bscil'][$key];
                            $save['e_id'] = $data['sigempid'][$key];
                            $save['institute_id'] = $data['Institute_name_id'][$key];
                            $save['designation'] = $data['Signature_designation'][$key];
                            $save['publish_on'] = $data['Signature_date'][$key];
                            $save['id'] = $data['idsig'][$key];
                            $save_groupsignature_inst[] = $save;
                        }


                        $project_id = $this->input->post('project_id');
                        $id2 = $this->input->post('idsig');

                        if($id2 == '')
                        { 

                            if(isset($data['user_array_checksignature']) && $data['user_array_checksignature'] == 1){ 
                                foreach($save_groupsignature_inst as $result){    
                                    $this->db->insert('project_signature',array("name"=>$result['name'],"BSCIL_MEMBER_ID"=>$result['BSCIL_MEMBER_ID'],"e_id"=>$result['e_id'],"institute_id"=>$result['institute_id'],"designation"=>$result['designation'],"publish_on"=>$result['publish_on'],"project_id"=>$project_id));
                                    $pinsert[] = $this->db->insert_id();
                                }
                            }
                        } 

                        if(isset($data['user_array_checksignature']) && $data['user_array_checksignature'] == 2)
                        { 
                            
                            if (!empty($save_groupsignature_inst))  {  
                                foreach($save_groupsignature_inst as $key => $result){ 
                                    if($result['id'] == ''){ 
                                        $this->db->insert('project_signature',array("name"=>$result['name'],"BSCIL_MEMBER_ID"=>$result['BSCIL_MEMBER_ID'],"e_id"=>$result['e_id'],"institute_id"=>$result['institute_id'],"designation"=>$result['designation'],"publish_on"=>$result['publish_on'],"project_id"=>$project_id));
                                        $pinsert[] = $this->db->insert_id();
                                    }


                                    $this->db->where('id',$result['id']);
                                    $this->db->update('project_signature',array("name"=>$result['name'],"BSCIL_MEMBER_ID"=>$result['BSCIL_MEMBER_ID'],"e_id"=>$result['e_id'],"institute_id"=>$result['institute_id'],"designation"=>$result['designation'],"publish_on"=>$result['publish_on'],"project_id"=>$project_id)); 
                                }
                                //echo "<pre>";print_r($this->db->last_query());exit;
                            }
                        } 
                    }




                        if (isset($data['Existing'] )) 
                        {
                            $save1 = [];
                            $save_user_group1 = [];
                            foreach ($data['empid'] as $key1 => $value1) 
                            {

                                $save1['e_id'] = $value1;
                                $save1['name'] = $data['existing_name'][$key1];
                                $save1['institute_id'] = $data['Institute_name'][$key1];
                                $save1['about_employee'] = $data['Existing_about'][$key1];
                                $save1['email'] = $data['Existing_email'][$key1];
                                 $save1['type'] = $data['existing_type'][$key1];
                                $save1['prid'] = $data['idexi'][$key1];
                                $save1['existing_bscil'] = $data['existing_bscil'][$key1];
                                $save_group_inst1[] = $save1;
                            }
                            foreach($save_group_inst1 as $result)
                            { 
                                if(isset($result['existing_bscil']) && !empty($result['existing_bscil'] ))
                                {
                                    $this->db->select('BSCIL_MEMBER_ID');
                                    $this->db->from('edu_member_dir');
                                    $this->db->where('BSCIL_MEMBER_ID', $result['existing_bscil'] );
                                    $this->db->where('MEMBER_STATUS', "A");
                                    $num_results = $this->db->count_all_results();
                                    if($num_results>0)
                                    {
                                    $this->db->select('BSCIL_MEMBER_ID');
                                    $this->db->from('member_strengths');
                                    $this->db->where('BSCIL_MEMBER_ID', $result['existing_bscil'] );
                                    $this->db->where('interest_id', $data['area_id']);
                                    $num_results = $this->db->count_all_results();
                                    if($num_results>0){
                                        
                                        //if query finds one row relating to this user then execute code accordingly here
                                    }else{
                                             $this->db->insert('member_strengths',array("BSCIL_MEMBER_ID"=>$result['existing_bscil'] ,"INTEREST_TYPE"=>"RESEARCH SPECIALISATION","INTEREST_NAME"=>$data['area_name'],"interest_id"=>$data['area_id']));
                                        }
                                    }
                                }
                            }

                            $project_id = $this->input->post('project_id');
                            $id2 = $this->input->post('idexi');
                            $Existing = $data['Existing'];
                            if($id2 == '')
                            { 

                                if(isset($data['user_array_checkexi']) && $data['user_array_checkexi'] == 1){ 
                                    foreach($save_group_inst1 as $result){     
                                        $this->db->insert('project_research_team',array("team_type"=>$data['Existing'],"e_id"=>$result['e_id'] ,"name"=>$result['name'],"about_employee"=>$result['about_employee'],"institute_id"=>$result['institute_id'],"email"=>$result['email'],"type"=>$result['type'],"project_id"=>$project_id,"BSCIL_MEMBER_ID"=>$result['existing_bscil']));
                                        $pinsert[] = $this->db->insert_id();
                                    }

                                        
                                }
                            } 

                            if(isset($data['user_array_checkexi']) && $data['user_array_checkexi'] == 2)
                            { 
                                
                                if (!empty($save_group_inst1))  {  
                                    foreach($save_group_inst1 as $key => $result1){ 
                                        if($result1['prid'] == ''){
                                            $this->db->insert('project_research_team',array("team_type"=>$data['Existing'],"e_id"=>$result1['e_id'] ,"name"=>$result1['name'],"about_employee"=>$result1['about_employee'],"institute_id"=>$result1['institute_id'],"email"=>$result1['email'],"type"=>$result1['type'],"project_id"=>$project_id,"BSCIL_MEMBER_ID"=>$result1['existing_bscil']));
                                            $pinsert[] = $this->db->insert_id();
                                        }


                                        $this->db->where('prid',$result1['prid']);
                                        $this->db->update('project_research_team',array("e_id"=>$result1['e_id'] ,"name"=>$result1['name'],"about_employee"=>$result1['about_employee'],"institute_id"=>$result1['institute_id'],"email"=>$result1['email'],"type"=>$result1['type'],"project_id"=>$project_id,"BSCIL_MEMBER_ID"=>$result1['existing_bscil'])); 
                                    }
                                }
                            } 
                        }

                    //end existing


                 if (isset($data['External'] )) 
                    {
                        $save4 = [];
                        $save_user_group4 = [];



                        $project_id = $this->input->post('project_id');
                        $id21 = $this->input->post('idext2');
                      
                        if($id21== '')
                        { 
                    foreach ($data['Extname'] as $key => $value4) 
                        {  $save4['name'] = $value4;
                     $save4['department'] = $data['ExtInstname'][$key];
                             $save4['designation'] = $data['Extdesig'][$key];
                            $save4['about_employee'] = $data['Extabout_emp'][$key];
                            $save4['email'] = $data['external_email'][$key];
                             $save4['type'] = $data['external_type'][$key];
                          //  $save4['prid'] = $data['idext2'][$key];
                            $save_group_inst4[] = $save4;
                        }
                            if(isset($data['user_array_checkExt']) && $data['user_array_checkExt'] == 1){ 
                                foreach($save_group_inst4 as $result){     
                                    $this->db->insert('project_research_team',array("team_type"=>$data['External'],"name"=>$result['name'],"department"=>$result['department'],"designation"=>$result['designation'],"about_employee"=>$result['about_employee'],"email"=>$result['email'],"type"=>$result['type'],"project_id"=>$project_id));
                                    $pinsert[] = $this->db->insert_id();
                                }

                                
                            }
                        } 

                        if(isset($data['user_array_checkExt']) && $data['user_array_checkExt'] == 2)
                        {  
                            foreach ($data['Extname'] as $key => $value4) 
                        {

                
                            $save4['name'] = $value4;
                              $save4['department'] = $data['ExtInstname'][$key];
                             $save4['designation'] = $data['Extdesig'][$key];
                             $save4['about_employee'] = $data['Extabout_emp'][$key];
                            $save4['email'] = $data['external_email'][$key];
                             $save4['type'] = $data['external_type'][$key];
                            $save4['prid'] = $data['idext2'][$key];
                            $save_group_inst4[] = $save4;
                        }
                            
                            if (!empty($save_group_inst4))  {  
                                foreach($save_group_inst4 as $key => $result){ 
                                    if($result['prid'] == ''){
                                        $this->db->insert('project_research_team',array("team_type"=>$data['External'],"name"=>$result['name'],"department"=>$result['department'],"designation"=>$result['designation'],"about_employee"=>$result['about_employee'],"email"=>$result['email'],"type"=>$result['type'],"project_id"=>$project_id));
                                        $pinsert[] = $this->db->insert_id();
                                    }


                                    $this->db->where('prid',$result['prid']);
                                    $this->db->update('project_research_team',array("name"=>$result['name'],"department"=>$result['department'],"designation"=>$result['designation'],"about_employee"=>$result['about_employee'],"email"=>$result['email'],"type"=>$result['type'],"project_id"=>$project_id)); 
                                }
                            }
                        } 
                    }

                    //end existing


                }


                if($this->db->affected_rows() > 0 )
                {
                    $return = ['error' => 0, 'message' => 'Project successfully updated'];
                }
                else
                {
                    $return = ['error' => 0, 'message' => 'Project successfully updated'];
                    //$return = ['error' => 1, 'message' => 'Unable to update project'];
                }
            }
            else
            {
                $return = ['error' => 1, 'message' => 'Project not found'];
            }
        }
        else
        {    // $insert['lab_id']               = $save_lab;
             //  $insert['contact_no']           = $data['contact_no'];
            $insert['name']                 = $data['name'];
            $insert['short_title']      = $data['short_title'];
            $insert['area_id']              = $data['area_id'];
              $insert['area_specialization']              = $data['area_specialization'];
            $insert['institute_id']         = $save_data;
            $insert['type']                 = $data['type'];
            $insert['featured_project']     = $data['featured_project'];
            $insert['project_status']       = $data['project_status'];
            $insert['category_id']          = $data['category_id'];
            $insert['project_level']        = $data['project_level'];
            $insert['department']       = $save_datadept;
            $insert['tags']                 = $data['tags'];
           // $insert['Written_by']           = $data['Written_by'];
            $insert['date']                 = $data['date'];
            $insert['end_date']             =$data['end_date'];
            $insert['duration']             = $data['duration'];
            $insert['pdf_path']             = $data['pdf_path'];
            $insert['public']               = $data['public'];
            $insert['consultancy_offered_by']               = $data['consultancy_offered_by'];
            $insert['created_on']           = date('Y-m-d H:i:s');
            $insert['created_by']           = $this->user_id;
            $insert['modified_on']          = date('Y-m-d H:i:s');
            $insert['modified_by']          = $this->user_id;
            $this->db->insert($this->table, $insert);
            $insert_id = $this->db->insert_id();

            $this->db->where('project_id', $insert_id);
            $this->db->update('projects', array('image' => $fileNamefeatured));

            if($filename!='' ){
                  $filename1 = explode(',',$filename);
                  foreach($filename1 as $file){
                    $file_data = array(
                        'image' => $file,
                        'type' => 'project_banner_images',
                        'area_id' => $insert_id
                    );
                    $this->db->insert('area_banner_images', $file_data);
                  }
            }

          

            $ins['project_id']    = $insert_id;
            $ins['language_id']   = $data['language_id'];
            $ins['title']         = $data['name'];
            $ins['description']   = $data['description'];
            $ins['content']       = $data['content'];

            $ins['public']       = $data['public'];
            $ins['created_on']   = date('Y-m-d H:i:s');
            $ins['created_by']   = $this->user_id;
            $ins['modified_on']  = date('Y-m-d H:i:s');
            $ins['modified_by']  = $this->user_id;
            $this->db->insert('project_content', $ins);
            $ins_id = $this->db->insert_id();

  if(!empty($project_documents))
                {
                    foreach ($project_documents as $key => $value) {
                        $save_document['document'] = $value;
                        $save_document['relation_id'] = $insert_id;
                        $this->db->insert('project_documents',array("document"=>$value,"relation_id"=>$insert_id));
                    }

            }
//echo "<pre>";print_r($this->db->last_query());exit;
            $pname = $this->input->post('pname');
            $amount = $this->input->post('amount');

            if ($fileLogo != '') 
            {
                $save = [];
                $save_user_group = [];
                foreach ($data['pname'] as $key => $value) {
                    $save['name'] = $value;
                    $save['amount'] = $data['amount'][$key];
                    $save_group_inst[] = $save;
                }

                foreach($save_group_inst as $result)
                {     
                    $this->db->insert('project_donor',array("name"=>$result['name'],"amount"=>$result['amount'],"project_id"=>$insert_id));
                    $pinsert[] = $this->db->insert_id();

                    if($fileLogo!='' )
                    {
                        $filename1 = explode(',',$fileLogo);
                        $key1 = 0;
                        foreach($filename1 as $file)
                        {
                            $file_data = array(
                            'logo' => $file
                            );
                            $this->db->where('pid', $pinsert[$key1]);
                            $this->db->update('project_donor',$file_data);
                            ++$key1;
                        }
                    }
                }
            } 



            if ($data['sig_name'] != '') 
            {
                $save = [];
                $save_signature_group = [];
                foreach ($data['sig_name'] as $key => $value) 
                {

                    $save['name'] = $value;
                    $save['BSCIL_MEMBER_ID'] = $data['sig_bscil'][$key];
                    $save['e_id'] = $data['sigempid'][$key];
                    $save['institute_id'] = $data['Institute_name_id'][$key];
                    $save['designation'] = $data['Signature_designation'][$key];
                    $save['publish_on'] = $data['Signature_date'][$key];
                    $save['id'] = $data['idsig'][$key];
                    $save_groupsignature_inst[] = $save;
                }


                foreach($save_groupsignature_inst as $result)
                {    
                $this->db->insert('project_signature',array("name"=>$result['name'],"BSCIL_MEMBER_ID"=>$result['BSCIL_MEMBER_ID'],"e_id"=>$result['e_id'],"institute_id"=>$result['institute_id'],"designation"=>$result['designation'],"publish_on"=>$result['publish_on'],"project_id"=>$insert_id)); 
                 $pinsert[] = $this->db->insert_id();
                }

            }




//*/existing data start
    if (isset($data['Existing']) )
            {
                 $save1 = [];
                        $save_user_group = [];
                        foreach ($data['empid'] as $key1 => $value1) 
                        {

                            $save1['e_id'] = $value1;
                            $save1['name'] = $data['existing_name'][$key1];
                             $save1['about_employee'] = $data['Existing_about'][$key1];
                            $save1['institute_id'] = $data['Institute_name'][$key1];
                            $save1['email'] = $data['Existing_email'][$key1];
                             $save1['type'] = $data['existing_type'][$key1];
                              $save1['existing_bscil'] = $data['existing_bscil'][$key1];
                           // $save1['prid'] = $data['idexi2'][$key1];
                            $save_group_inst[] = $save1;
                        }

                foreach($save_group_inst as $result){ 
                    if(isset($result['existing_bscil']) && !empty($result['existing_bscil'] ))
                    {
                    $this->db->select('BSCIL_MEMBER_ID');
                    $this->db->from('edu_member_dir');
                    $this->db->where('BSCIL_MEMBER_ID', $result['existing_bscil'] );
                    $this->db->where('MEMBER_STATUS', "A");
                    $num_results = $this->db->count_all_results();
                    if($num_results>0)
                    {
                    $this->db->select('BSCIL_MEMBER_ID');
                    $this->db->from('member_strengths');
                    $this->db->where('BSCIL_MEMBER_ID', $result['existing_bscil'] );
                    $this->db->where('interest_id', $data['area_id']);
                    $num_results = $this->db->count_all_results();
                    if($num_results>0){
                        
                        //if query finds one row relating to this user then execute code accordingly here
                    }else{
                             $this->db->insert('member_strengths',array("BSCIL_MEMBER_ID"=>$result['existing_bscil'] ,"INTEREST_TYPE"=>"RESEARCH SPECIALISATION","INTEREST_NAME"=>$data['area_name'],"interest_id"=>$data['area_id']));
                        }
                    }
                    }
                    }
                      
                        
                     //   $id2 = $this->input->post('idexi2');
                        $Existing = $data['Existing'];
                      
                foreach($save_group_inst as $result)
                {    
               $this->db->insert('project_research_team',array("team_type"=>$Existing,"e_id"=>$result['e_id'] ,"name"=>$result['name'],"about_employee"=>$result['about_employee'],"institute_id"=>$result['institute_id'],"email"=>$result['email'],"type"=>$result['type'],"project_id"=>$insert_id,"BSCIL_MEMBER_ID"=>$result['existing_bscil']));
                 $pinsert[] = $this->db->insert_id();
                }
            } 

//end existing

//external data start

    if (isset($data['External']) && $data['External']!= '') 
            {
                 $save2 = [];
                        $save_user_group2 = [];
                        foreach ($data['Extname'] as $key1 => $value2) 
                        {

                
                            $save2['name'] = $value2;
                               $save2['department'] = $data['ExtInstname'][$key1];
                             $save2['designation'] = $data['Extdesig'][$key1];
                            $save2['about_employee'] = $data['Extabout_emp'][$key1];
                            $save2['email'] = $data['external_email'][$key1];
                             $save2['type'] = $data['external_type'][$key1];
                         //   $save['prid'] = $data['idext2'][$key];
                            $save_group_inst2[] = $save2;
                        }
                      
                       
                      
                foreach($save_group_inst2 as $result2)
                {    
                $this->db->insert('project_research_team',array("team_type"=>$data['External'],"name"=>$result2['name'],"department"=>$result2['department'],"designation"=>$result2['designation'],"about_employee"=>$result2['about_employee'],"email"=>$result2['email'],"type"=>$result2['type'],"project_id"=>$insert_id)); 
                 $pinsert[] = $this->db->insert_id();
                }
            } 

//end external

            if($insert_id)
            {
                $return = ['error' => 0, 'message' => 'Project successfully added'];
            }
            else
            {
                $return = ['error' => 1, 'message' =>'Project not  added'];
            }
        }
        return $return;
    }

    function data_image($id)
    {
        $query=$this->db->query("SELECT *
                                 FROM  area_banner_images as photo
                                 WHERE photo.area_id = $id AND photo.type = 'project_banner_images' order by photo.area_order ASC ");
        return $query->result_array();
    }

    function get_all_uservalue($id)
    {
        $this->db->select('*');
        $this->db->from('project_donor');
        $this->db->where('project_id', $id);
        $query = $this->db->get();
        return  $query->result_array();
    }

    function get_all_Existing($id)
    {
        $this->db->select('*,edu_institute_dir.INST_ID,edu_institute_dir.INST_NAME');
        $this->db->from('project_research_team');
            $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=project_research_team.institute_id");
          $this->db->where('project_research_team.team_type', 'Existing');
        $this->db->where('project_research_team.project_id', $id);
        $query = $this->db->get();
        return  $query->result_array();
    }
    function get_all_External($id)
    {
        $this->db->select('*');
        $this->db->from('project_research_team');
          $this->db->where('team_type', 'External');
        $this->db->where('project_id', $id);
        $query = $this->db->get();
        return  $query->result_array();
    }

    function get_all_signatures($id)
    {
        $this->db->select('*,edu_institute_dir.INST_ID,edu_institute_dir.INST_NAME');
        $this->db->from('project_signature');
        $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=project_signature.institute_id");
        $this->db->where('project_signature.project_id', $id);
        $query = $this->db->get();
        return  $query->result_array();
    }

/*function getEmployeeDetails($eid='')
    {
       $this->db->select('*,edu_institute_dir.INST_ID,edu_institute_dir.INST_NAME');
       $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=edu_member_dir.INST_ID");
      $this->db->where('edu_member_dir.MEMBER_ID', $eid);
       $this->db->where('edu_member_dir.MEMBER_STATUS', "A");
      $records = $this->db->get('edu_member_dir');
      $response = $records->result_array();
      return $response;
  
    }*/
        function search_faculty_by_name($keywords)
    {
        $this->db->select('edu_member_dir.MEMBER_ID,edu_member_dir.SALUTATION,edu_member_dir.BSCIL_MEMBER_ID, concat(edu_member_dir.SALUTATION," ",edu_member_dir.FIRST_NAME," ",edu_member_dir.MIDDLE_NAME," ",edu_member_dir.LAST_NAME) as fullname,edu_member_dir.EMAIL_ID,edu_institute_dir.INST_ID,edu_institute_dir.INST_NAME');
         $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=edu_member_dir.INST_ID");
        $this->db->like('edu_member_dir.FIRST_NAME', $keywords , 'both');
        $this->db->or_like('edu_member_dir.MIDDLE_NAME', $keywords , 'both');
        $this->db->or_like('edu_member_dir.LAST_NAME', $keywords , 'both');
         $this->db->or_like("concat_ws(' ',edu_member_dir.SALUTATION,edu_member_dir.FIRST_NAME,edu_member_dir.MIDDLE_NAME,edu_member_dir.LAST_NAME)",TRIM($keywords));
        $this->db->where('edu_member_dir.MEMBER_STATUS', "A");

       
        $records = $this->db->get('edu_member_dir');
        $response = $records->result_array();
        //print_r($this->db->last_query());exit();  
        return $response;
    }

function getEmployeeDetails($eid='')
    {
       $this->db->select('*,edu_institute_dir.INST_ID,edu_institute_dir.INST_NAME');
       $this->db->join('edu_institute_dir',"edu_institute_dir.INST_ID=edu_member_dir.INST_ID");
      $this->db->where('edu_member_dir.MEMBER_ID', $eid);
       $this->db->where('edu_member_dir.MEMBER_STATUS', "A");
      $records = $this->db->get('edu_member_dir');
      $response = $records->result_array();
      return $response;
  
    }

    function document_upload($id)
    {  
        $this->db->select('*');
        $this->db->from('project_documents');
        $this->db->where('relation_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

     function get_departmentsByInstitute($institute_id)
    {
        $this->db->select("d.Department_Id, d.Department_Name");
        $this->db->from('edu_department_dir d');
        //$this->db->join('department_by_institute di, d.Department_Id = di.department_id','left');
        $this->db->join('department_by_institute di',"FIND_IN_SET(d.Department_Id,di.department_id)",'left');
        $this->db->where('status', 1);
        $this->db->where('di.institute_id', $institute_id);
        $query = $this->db->get();
        return $query->result_array();
    }
       function get_area_Specialization($area_id)
    {
        $this->db->select("*");
        $this->db->from('area_specialization');
        $this->db->where('area_id', $area_id);
        $query = $this->db->get();
        return $query->result_array();
    }
}
