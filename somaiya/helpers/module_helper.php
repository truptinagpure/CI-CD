<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    

    function view_project($project_id,$institute_id,$model_name,$lang)
    {
        $ci =& get_instance();
        $ci->data['project_details']     =  $model_name->get_project_details($project_id);
        $title = $model_name->get_project_details_metatitle($project_id);

        if($title[0]['meta_title'] == '') 
        {
            $ci->data['title'] = $title[0]['name'];
        } else 
        {
            $ci->data['title'] = $title[0]['meta_title'];
        }
        if($title[0]['meta_description'] == '') 
        {
            $ci->data['description'] = $title[0]['name'];
        } else 
        {
            $ci->data['description'] = $title[0]['meta_description'];
        }
      
        $ci->db->select("project_id");
        $ci->db->from('projects ');
        $ci->db->where('project_id', $project_id);
        $query = $ci->db->get();

        if ($query->num_rows() > 0)
        { 
            $ci->data['project_id']          = $project_id;
            $ci->data['lang1']               = $lang;
            $ci->data['project_banner']      = $model_name->get_project_banner($project_id);
            $ci->data['project_details']     = $model_name->get_project_details($project_id);
            $ci->data['project_content']     = $model_name->get_project_content($project_id);
            $ci->data['related_projects']    = $model_name->get_related_projects(isset($project_details['area_id']) ? $project_details['area_id'] : '', isset($project_details['project_id']) ? $project_details['project_id'] : '', $ci->data['id_of_institute']);
            $ci->data['projects_funders']    = $model_name->get_project_funder($project_id);
            
            if(isset($ci->data['project_details']))
            {
                $ci->data['page_type'] = 'project';
                $ci->data['og_title'] = $ci->data['project_details']['name'];
                $ci->data['og_description'] = '';
                $ci->data['og_image'] = base_url().'upload_file/images20/'.$ci->data['project_banner'][0]['image'];
                $ci->data['og_url'] = base_url($lang.'/view-project/'.$project_id);
                
            }
            $ci->data['project_research_principle_Inv']       = $model_name->get_project_Principle_Investi($project_id);
            $ci->data['project_research_co_Inv']              = $model_name->get_project_Co_Investi($project_id);
            $ci->data['project_doner']                        = $model_name->get_project_doner($project_id);
            $ci->data['project_tags']                         = $model_name->get_project_tags($project_id);
            $ci->data['random_projects']                      = $model_name->get_random_project();
            $ci->data['project_article']                      = $model_name->get_project_article($project_id);
            $ci->data['project_student_team']                  = $model_name->get_project_student_team($project_id);

        }
        return  $ci->data;
    }


    function view_event($event_id,$institute_id,$model_name,$lang)
    {
        $ci =& get_instance();
        $title = $model_name->viewEvent($event_id);
        $ci->data['title']        = $title[0]['event_name'];
        $ci->data['description']  = $title[0]['event_name'];
        $ci->data['event_listing_single'] = $model_name->event_listing_single($institute_id);
        $ci->data['data'] = $model_name->viewEvent($event_id);
        $ci->data['page_type'] = 'event';
        $ci->data['og_title'] = $ci->data['title'];
        $ci->data['og_description'] = $ci->data['data'][0]['description'];
        $ci->data['og_image'] = base_url().'upload_file/images20/'.$ci->data['data'][0]['image'];
        // $ci->data['og_image_url'] = base_url().'upload_file/images20/'.$ci->data['data'][0]['image'];
        // $ci->data['og_image_secure_url'] = base_url().'upload_file/images20/'.$ci->data['data'][0]['image'];
        $ci->data['og_url'] = base_url($lang.'/view-events/'.$event_id);
        return  $ci->data;
    }


    function view_media_coverage($alias,$mediacoverage_id,$modelname,$lang)
    {
		$ci =& get_instance();

        $ci->data['data'] = $modelname->viewMediaCoverage($mediacoverage_id);
        $title = $modelname->viewMediaCoverage($mediacoverage_id);
        $ci->data['title']        = $title[0]['title'];
        $ci->data['description']  = $title[0]['title'];
        // $ci->data['media_coverage_listing_single'] = $modelname->media_coverage_listing_single();
        $ci->data['page_type'] = 'mediacoverage';
        $ci->data['og_title'] = $ci->data['title'];
        $ci->data['og_description'] = $ci->data['data'][0]['description'];
        $ci->data['og_image'] = base_url().'upload_file/images20/'.$ci->data['data'][0]['image'];
        $ci->data['og_url'] = base_url($lang.'/view-media-coverage/'.$mediacoverage_id);
        return  $ci->data;
    }


    function view_press_realease($instituteid,$pressrelease_id,$modelname,$lang)
    {

        $ci =& get_instance();
        $title = $modelname->viewPressRealease($pressrelease_id);
        $ci->data['title']        = $title[0]['title'];
        $ci->data['description']  = $title[0]['title'];
        $ci->data['press_realease_listing_single'] = $modelname->press_realease_listing_single($instituteid);
        $ci->data['data'] = $modelname->viewPressRealease($pressrelease_id);
        return  $ci->data;
    }

    function view_announcement($instituteid,$announcement_id,$modelname,$lang)
    {
        $ci =& get_instance();
        $title = $modelname->viewAnnouncement($announcement_id);
        $ci->data['title']        = $title[0]['title'];
        $ci->data['description']  = $title[0]['title'];
        $ci->data['data'] = $modelname->viewAnnouncement($announcement_id);
        $ci->data['page_type'] = 'announcement';
        $ci->data['og_title'] = $ci->data['data'][0]['title'];
        $ci->data['og_description'] = $ci->data['data'][0]['description'];
        $ci->data['og_image'] = base_url().'upload_file/images20/'.$ci->data['data'][0]['image'];
        $ci->data['og_url'] = base_url($lang.'/view-announcement/'.$announcement_id);
        return  $ci->data;     
    }

    function view_member($alias,$member_id,$modelname,$lang)
    {
        $ci =& get_instance();
        $ci->db->select('MEMBER_ID');
        $query = $ci->db->get_where('edu_member_dir', array('MEMBER_ID' => $alias, 'MEMBER_STATUS' => 'A'), 1, 0);

        if ($query->num_rows() > 0)
        {
            $ci->data['data'] = $modelname->viewMember($member_id);
           $title = $modelname->viewMember($member_id);
            foreach ($title as  $value) {
                 $ci->data['title'] = ucwords(strtolower($value['FIRST_NAME']))." ".ucwords(strtolower($value['MIDDLE_NAME']))." ".ucwords(strtolower($value['LAST_NAME']))." - Faculty Profile";
                 $ci->data['description'] = ucwords(strtolower($value['FIRST_NAME']))." ".ucwords(strtolower($value['MIDDLE_NAME']))." ".ucwords(strtolower($value['LAST_NAME']))." - Faculty Profile";
            }
            $ci->data['member_listing_single']                    = $modelname->member_listing_single($member_id);
            $ci->data['member_listing_single_subject']            = $modelname->member_listing_single_subject($member_id);
            $ci->data['member_listing_single_education']          = $modelname->member_listing_single_education($member_id);
            $ci->data['member_listing_single_experience']         = $modelname->member_listing_single_experience($member_id);
            $ci->data['member_listing_single_strengths']          = $modelname->member_listing_single_strengths($member_id);
            $ci->data['member_listing_single_research_papers']    = $modelname->member_listing_single_research_papers($member_id);
            $ci->data['member_listing_single_proceedings']        = $modelname->member_listing_single_proceedings($member_id);
            $ci->data['member_listing_single_books']              = $modelname->member_listing_single_books($member_id);
            $ci->data['member_listing_single_book_chapters']      = $modelname->member_listing_single_book_chapters($member_id);
            $ci->data['member_listing_single_ipr']                = $modelname->member_listing_single_ipr($member_id);
            $ci->data['member_projects']                          = $modelname->member_projects($member_id);
           
        }
        return  $ci->data;   
    }


    function gallery_view($url_view,$g_id,$modelname,$lang)
    {
        $ci =& get_instance();
        $title = $modelname->getGalleriesnew($g_id);
        $ci->data['title']        = $title[0]['title'];
        $ci->data['description']  = $title[0]['title'];
        $ci->data['gallery_listing_single'] = $modelname->gallery_listing_single($url_view);
        $ci->data['gallery'] = $modelname->getGalleries($g_id);
        $ci->data['gallerynew'] = $modelname->getGalleriesnew($g_id);
        
        if(isset($ci->data['gallery']))
        {
            $ci->data['page_type'] = 'gallery';
            $ci->data['og_title'] = $ci->data['title'];
            $ci->data['og_description'] = '';
            $ci->data['og_image'] = base_url().'upload_file/images20/'.$ci->data['gallery'][0]['image'];
            $ci->data['og_url'] = base_url($lang.'/gallery-view/'.$g_id);
            
        }
        return  $ci->data;   
    }


    function view_post_details($post_id,$modelname,$lang)
    {
        $ci =& get_instance();
        $ci->data['lang1']                      = $lang;
        $conditions['search']['post_id']        = $post_id;
        $conditions['search']['whats_new']      = 1;
        $title                                  = $modelname->post_listing($conditions);
        $ci->data['title']                      = $title[0]['post_name'];
        $ci->data['description']                = $title[0]['post_name'];
        $ci->data['posts']                      = $modelname->post_listing($conditions);
        $conditions1['id_not_equal_to']         = $post_id;
        $conditions1['start']                   = 0;
        $conditions1['limit']                   = 3;
        $conditions1['search']['whats_new']     = 1;
        $ci->data['relatedposts']               = $modelname->post_listing($conditions1);
        return  $ci->data;   
    }

    function view_publication($acc_id,$type,$member_id,$modelname,$lang)
    {   
        $ci =& get_instance();
        $acc_id = $ci->security->xss_clean($acc_id);
        $type                                       = $ci->security->xss_clean($_GET['type']);
        $member_id                                  = $ci->security->xss_clean($_GET['id']);
        $title                                      = $ci->Research_model->accomplishment_publication($acc_id,$type);
        $ci->data['title']                          = $title[0]['Title'];
        $ci->data['description']                    = $title[0]['Title'];
        $ci->data['publication_related']            = $ci->Research_model->get_related_publisher($acc_id,$type,$member_id);
        $ci->data['publication_details']            = $ci->Research_model->accomplishment_publication($acc_id,$type);
        //echo "<pre>"; print_r($ci->data['publication_details']);exit();
        return  $ci->data;   
    }


    function view_newsletters($newsletter_type_id,$modelname,$lang)
    {
        $ci =& get_instance();
        $newsletter_type_id = $ci->security->xss_clean($newsletter_type_id);
        $conditions = [];
        $ci->data['lang']                         = $lang;
        $ci->data['title']                        = 'View Newsletter';
        $ci->data['newsletter_type_id']           = $newsletter_type_id;
        if(!empty($newsletter_type_id))
        {   
            $conditions['search']['newsletter_type_id'] = $newsletter_type_id;
        }
        $ci->data['newsletter_type']              = $modelname->get_newsletter_types($conditions);
        $ci->data['newsletter_archives']          = $modelname->get_archive_newsletter_year($conditions);
        return  $ci->data;   
    }


    function view_covid($covid_id,$modelname,$lang)
    {
        $ci =& get_instance();      
        $covid_id = $ci->security->xss_clean($covid_id);          
     
        $ci->data['covid_data'] = $modelname->view_covid($covid_id, $ci->data['id_of_institute']);
        $ci->data['recent_covid_data'] = $modelname->recent_covid_data($covid_id, $ci->data['id_of_institute']);
        
        $ci->data['title']        = $ci->data['covid_data'][0]['title'];
        $ci->data['description']  = $ci->data['covid_data'][0]['description'];
        
        $ci->data['og_page_type'] = 'covid';
        $ci->data['og_title'] = $ci->data['covid_data'][0]['title'];;
        $ci->data['og_description'] = $ci->data['covid_data'][0]['description'];
        $ci->data['og_image'] = '';
        $ci->data['og_url'] = base_url($lang.'/view-covid/'.$covid_id);
        return  $ci->data;  
    }
    

    function career_detail($job_id,$modelname,$lang)
    {   
        $ci =& get_instance();  
        $ci->data['lang1']            = $lang;
        $title                        = $modelname->career_detail($job_id);
        $ci->data['title']            = $title[0]['job_name'];
        $ci->data['description']      = $title[0]['job_name'];
        $ci->data['related_jobs']     = $modelname->related_jobs();
        $ci->data['data']             = $modelname->career_detail($job_id);
        $ci->data['career_documents'] = $modelname->career_documents($job_id);
        return  $ci->data;
    }


    function success($lang)
    {
        $ci =& get_instance();

        $conditions = [];
        //echo "<pre>";print_r("Inside module helper");exit;
        $ci->data['lang']                         = $lang;
        $ci->data['title']                        = 'Success';
        $instituteid    = $ci->security->xss_clean($ci->input->post('selectInstitute'));
        $email          = $ci->security->xss_clean($ci->input->post('selectQuery'));
        $username       = $ci->security->xss_clean($ci->input->post('textName'));
        $fromEmail      = $ci->security->xss_clean($ci->input->post('textEmail'));
        $number         = $ci->security->xss_clean($ci->input->post('textNumber'));
        $Message        = $ci->security->xss_clean($ci->input->post('textComment'));
        
        $query  = $ci->db->query("SELECT INST_NAME FROM edu_institute_dir WHERE INST_ID=".$instituteid."");
        $row    = $query->row()->INST_NAME;

        // $email          = 'varsha.bhoomkar@somaiya.edu';
        if($instituteid == 16 OR $instituteid == 17 OR $instituteid == 18 OR $instituteid == 21 OR $instituteid == 31 OR $instituteid == 32 OR $instituteid == 34 OR $instituteid == 35 OR $instituteid == 47)
        {
            if (strpos($email, 'admission') !== false) {
                $post_data = array (
                                  array (
                                    "Attribute" => "FirstName",
                                    "Value" => "$username",
                                  ),
                                  array (
                                    "Attribute" => "EmailAddress",
                                    "Value" => "$fromEmail",
                                  ),
                                  array (
                                    "Attribute" => "Phone",
                                    "Value" => "$number",
                                  ),
                                  array (
                                    "Attribute" => "mx_Enq_Msg",
                                    "Value" => "$Message",
                                  ),
                                  array (
                                    "Attribute" => "mx_Enq_College",
                                    "Value" => "$row",
                                  ),
                                  array (
                                    "Attribute" => "mx_Enq_auth",
                                    "Value" => "1",
                                  ),
                                  array (
                                    "Attribute" => "Source",
                                    "Value" => "Website",
                                  )
                            );
                //echo "<pre>-----"; print_r($post_data);
                $data_string = json_encode($post_data);
                //echo "<pre>-----"; print_r($data_string);exit();
                try { 
                $curl = curl_init('https://api-in21.leadsquared.com/v2/LeadManagement.svc/Lead.Capture?accessKey=u$r8500de2a6867190e51ca2e708817fb4d&secretKey=46306f3fe11f44c5592e8ceea12dca72443bdc04'); 
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST"); 
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
                curl_setopt($curl, CURLOPT_HEADER, 0); 
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string); 
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
                curl_setopt($curl, CURLOPT_HTTPHEADER, array( "Content-Type:application/json", "Content-Length:".strlen($data_string) )); 
                $json_response = curl_exec($curl);
                //echo $json_response; 
                curl_close($curl); } 
                catch (Exception $ex) { curl_close($curl); }
            }
            else
            {

                $msg .= "Institute Name : ".$row."<br />\r\n";
                $msg .= "User Name : ".$username."<br />\r\n";
                $msg .= "Contact Number : ".$number."<br />\r\n";
                $msg .= "Email : ".$fromEmail."<br />\r\n";
                $msg .= "Message : ".$Message."<br />\r\n";

                $path = explode(",", $email);
                $to   = $path;
                $from = "noreply@somaiya.edu";
                $ci->load->config('email');
                $ci->load->library('email');
                $ci->email->clear();
                $ci->email->from($from, 'Contact Us');
                $list = $to;
                $ci->email->to($list);
                $data = array();
                $ci->email->subject('Contact Us');
                $ci->email->message($msg);


                if ($ci->email->send()) {
                    // echo 'Your email was sent, thanks chamil.';
                } else {
                    show_error($ci->email->print_debugger());
                }
            }
        }
        else
        {
            $msg .= "Institute Name : ".$row."<br />\r\n";
            $msg .= "User Name : ".$username."<br />\r\n";
            $msg .= "Contact Number : ".$number."<br />\r\n";
            $msg .= "Email : ".$fromEmail."<br />\r\n";
            $msg .= "Message : ".$Message."<br />\r\n";

            $path = explode(",", $email);
            $to   = $path;
            $from = "noreply@somaiya.edu";
            $ci->load->config('email');
            $ci->load->library('email');
            $ci->email->clear();
            $ci->email->from($from, 'Contact Us');
            $list = $to;
            $ci->email->to($list);
            $data = array();
            $ci->email->subject('Contact Us');
            $ci->email->message($msg);


            if ($ci->email->send()) {
                // echo 'Your email was sent, thanks chamil.';
            } else {
                show_error($ci->email->print_debugger());
            }
        }
        return  $ci->data; 
    }



    // function program_detail($instituteid,$program_id,$modelname,$lang)
    // {
    //     $ci =& get_instance();
    //     $ci->data['lang']           = $lang;
    //     $title                      = $modelname->program_detail_new($program_id);
    //     $ci->data['title']          = $title[0]['title'];
    //     $ci->data['description']    = $title[0]['title'];
    //     $ci->data['program_widget'] = $modelname->program_widget_new($program_id);
    //     $ci->data['data']           = $modelname->program_detail_new($program_id);
    //     $ci->data['keyword']        = $modelname->meta_tags($program_id);
    //     $ci->data['url']            = $modelname->getsiteURL($program_id, $instituteid);
    //     return  $ci->data;     
    // }
	
	function success_contact_msg($user_contact_data)
    {
        $ci =& get_instance();

        $conditions = [];
        //echo "<pre>";print_r("Inside module helper");exit;
        $ci->data['lang']   = 'en';
        $ci->data['title']  = 'Success';
        $instituteid        = $user_contact_data['selectInstitute'];
        $email              = $user_contact_data['selectQuery'];
        $username           = $user_contact_data['textName'];
        
        $fromEmail          = $user_contact_data['textEmail'];
        
        $number             = $user_contact_data['textNumber'];
        $Message            = $user_contact_data['textComment'];
        
        $query  = $ci->db->query("SELECT INST_NAME FROM edu_institute_dir WHERE INST_ID=".$instituteid."");
        $row    = $query->row()->INST_NAME;

        // $email          = 'varsha.bhoomkar@somaiya.edu';
        if($instituteid == 16 OR $instituteid == 17 OR $instituteid == 18 OR $instituteid == 21 OR $instituteid == 31 OR $instituteid == 32 OR $instituteid == 34 OR $instituteid == 35 OR $instituteid == 47)
        {
            
            if (strpos($email, 'admission') !== false) {
                $post_data = array (
                                  array (
                                    "Attribute" => "FirstName",
                                    "Value" => "$username",
                                  ),
                                  array (
                                    "Attribute" => "EmailAddress",
                                    "Value" => "$fromEmail",
                                  ),
                                  array (
                                    "Attribute" => "Phone",
                                    "Value" => "$number",
                                  ),
                                  array (
                                    "Attribute" => "mx_Enq_Msg",
                                    "Value" => "$Message",
                                  ),
                                  array (
                                    "Attribute" => "mx_Enq_College",
                                    "Value" => "$row",
                                  ),
                                  array (
                                    "Attribute" => "mx_Enq_auth",
                                    "Value" => "1",
                                  ),
                                  array (
                                    "Attribute" => "Source",
                                    "Value" => "Website",
                                  )
                            );
                //echo "<pre>-----"; print_r($post_data);
                $data_string = json_encode($post_data);
                //echo "<pre>-----"; print_r($data_string);exit();
                try { 
                $curl = curl_init('https://api-in21.leadsquared.com/v2/LeadManagement.svc/Lead.Capture?accessKey=u$r8500de2a6867190e51ca2e708817fb4d&secretKey=46306f3fe11f44c5592e8ceea12dca72443bdc04'); 
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST"); 
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
                curl_setopt($curl, CURLOPT_HEADER, 0); 
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string); 
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
                curl_setopt($curl, CURLOPT_HTTPHEADER, array( "Content-Type:application/json", "Content-Length:".strlen($data_string) )); 
                $json_response = curl_exec($curl);
                //echo $json_response; 
                curl_close($curl); } 
                catch (Exception $ex) { curl_close($curl); }
            }
            else
            {

                $msg .= "Institute Name : ".$row."<br />\r\n";
                $msg .= "User Name : ".$username."<br />\r\n";
                $msg .= "Contact Number : ".$number."<br />\r\n";
                $msg .= "Email : ".$fromEmail."<br />\r\n";
                $msg .= "Message : ".$Message."<br />\r\n";

                $path = explode(",", $email);
                $to   = $path;
                $from = "noreply@somaiya.edu";
                $ci->load->config('email');
                $ci->load->library('email');
                $ci->email->clear();
                $ci->email->from($from, 'Contact Us');
                $list = $to;
                $ci->email->to($list);
                $data = array();
                $ci->email->subject('Contact Us');
                $ci->email->message($msg);


                if ($ci->email->send()) {
                    // echo 'Your email was sent, thanks chamil.';
                } else {
                    show_error($ci->email->print_debugger());
                }
            }
        }
        else
        {
            
            $msg .= "Institute Name : ".$row."<br />\r\n";
            $msg .= "User Name : ".$username."<br />\r\n";
            $msg .= "Contact Number : ".$number."<br />\r\n";
            $msg .= "Email : ".$fromEmail."<br />\r\n";
            $msg .= "Message : ".$Message."<br />\r\n";

            $path = explode(",", $email);
            $to   = $path;
            $from = "noreply@somaiya.edu";
            $ci->load->config('email');
            $ci->load->library('email');
            $ci->email->clear();
            $ci->email->from($from, 'Contact Us');
            $list = $to;
            $ci->email->to($list);
            $data = array();
            $ci->email->subject('Contact Us');
            $ci->email->message($msg);


            if ($ci->email->send()) {
                // echo 'Your email was sent, thanks chamil.';
            } else {
                show_error($ci->email->print_debugger());
            }
        }
        return  $ci->data; 
    }