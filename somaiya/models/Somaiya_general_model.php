<?php
/**
 * Created by Somaiya Team.
 * User: Somaiya
 * Date: 9/15/2016
 * Time: 11:19 PM
 * Project: Somaiya Vidyavihar
 * Website: http://www.somaiya.com
 */
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Somaiya_general_model extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->data['id_of_institute'] = $this->config->item('somaiya_institute_id');
    }

    // Select from "setting" table
    function getWebsiteInfo()
    {
        $this->db->select('*');
        $this->db->from('setting');
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)?$return[0]:0;
    }

    // Select setting's options in one language from "setting_options_per_lang" table 
    function getWebsiteInfoOptions($language_id=null)
    {
        $this->db->select('*');
        $this->db->from('setting_options_per_lang');
        if($language_id!=null)
            $this->db->where('language_id',$language_id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)?$return[0]:0;
    }

    // Select a list from "languages" table
    function getLanguages()
    {
        $this->db->select('*');
        $this->db->from('languages');
        $this->db->where('public',1);
        $query = $this->db->get();
        return $query->result_array();
    }

    // Select a row with "code" field from "languages" table
    function getLanguageByCode($code)
    {
        $this->db->select('*');
        $this->db->from('languages');
        $this->db->where('public',1);
        $this->db->where('code',$code);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)?$return[0]:0;
    }

    // Select a row from "languages" table (main condition: default = 0)
    function getLanguageDefault()
    {
        $this->db->select('*');
        $this->db->from('languages');
        $this->db->where('public',1);
        $this->db->where('default',1);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)?$return[0]:0;
    }

    // Select a list from "pages" table if preview = 1
    function getPreviewPages()
    {
        $this->db->select('*');
        $this->db->from('page');
        $this->db->join('titles',"titles.relation_id=page_id");
        $this->db->where('titles.data_type',"page");
        $this->db->where('titles.language_id',$_SESSION["language"]["language_id"]);
        $this->db->where('preview',1);
        $this->db->where('public',1);
        $this->db->order_by('page_order',"ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

    // Select a list from "extensions" table
    function getExtensionsByPageId($page_id,$order_by="extension_order",$sort="DESC",$limit=null,$offset=0)
    {
        $this->db->select('*');
        $this->db->from('extensions');
        $this->db->where("relation_id",$page_id);
        $this->db->where('data_type',"page");
        $this->db->where('extensions.language_id',$_SESSION["language"]["language_id"]);
        //$this->db->where('status',1);
        $this->db->where('public',1);
        $this->db->order_by($order_by,$sort);
        if($limit!=null) $this->db->limit($limit,$offset);
        $query = $this->db->get();
        return $query->result_array();
    }

    // Select a list from "extensions" table
    function getExtensionRelated($page_id,$extension_id,$order_by="created_date",$sort="DESC",$limit=null,$offset=0)
    {
        $this->db->select('*');
        $this->db->from('extensions');
        $this->db->where("relation_id",$page_id);
        $this->db->where('data_type',"page");
        $this->db->where('extensions.language_id',$_SESSION["language"]["language_id"]);
        //$this->db->where('status',1);
        $this->db->where('public',1);
        $this->db->where('extension_id != '.$extension_id);
        $this->db->order_by($order_by,$sort);
        if($limit!=null) $this->db->limit($limit,$offset);
        $query = $this->db->get();
        return $query->result_array();
    }

    // Select a row from "extensions" table with extension_id
    function getExtensionByExtensionId($id)
    {
        $this->db->select('*,extensions.image');
        $this->db->from('extensions');
        $this->db->join('users', 'extensions.user_id = users.user_id',"left");
        $this->db->join('page', 'page.page_id = extensions.relation_id');
        $this->db->join('languages', 'languages.language_id = extensions.language_id',"left");
        $this->db->join('titles', 'page.page_id = titles.relation_id');
        $this->db->where('extensions.data_type',"page");
        $this->db->where('titles.data_type',"page");
        $this->db->where('titles.language_id',$_SESSION["language"]["language_id"]);
        // $this->db->where('extensions.status',1);
        $this->db->where('extensions.public',1);
        $this->db->where('extensions.extension_id',$id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)?$return[0]:0;
    }

    // Select a row from "page" table with page_id OR by slug
    function getPageDetail($slug)
    {   
        $inti = $this->data['id_of_institute'];
        $this->db->select('*,page.slug');
        $this->db->from('page');
        $this->db->join('titles', "relation_id=page_id");
        $this->db->where('slug', $slug);
        $this->db->where('page.institute_id',$inti);
        $this->db->where('data_type', 'page');
        $this->db->where('titles.language_id',$_SESSION["language"]["language_id"]);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)?$return[0]:0;
    }

    function getPageSlug($id1)
    {
        $this->db->select('*,page.slug');
        $this->db->from('page');
        $this->db->join('titles', "relation_id=page_id");
        $this->db->where('page_id', $id1);
        $this->db->where('data_type', 'page');
        $this->db->where('titles.language_id',$_SESSION["language"]["language_id"]);
        $this->db->where('institute_id', $institute_id);
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)?$return[0]:0;
    }


    /* display banner images on slider homepage */

    function get_homepage_banner($institute_banner)
    {    
        $curdate =date("Y-m-d");
        $this->db->select("*");
        $this->db->from('banner_images');
        $this->db->where("FIND_IN_SET(".$institute_banner.", institute_id)");
        $this->db->where("(valid_upto IS NULL
            OR valid_upto = '0000-00-00'
            OR valid_upto>='".$curdate."')", NULL, FALSE);        
        $this->db->where('public',1);
        $this->db->order_by('row_order','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }


    /* Whats New on Homepage */

    public function getWhatsNewPost($date,$institute_post)
    {   
        $sql = "SELECT p.post_id, p.post_name as whats_name, p.publish_date as whats_date
                FROM post_new p
                INNER JOIN contentspost_new c ON c.post_id = p.post_id 
                WHERE p.public = 1
                AND p.whats_new = 1
                AND p.whats_new_expiry_date >= '".date('Y-m-d')."'
                AND FIND_IN_SET(`p`.`institute_id`, ('".$institute_post."'))
                AND c.language_id = '1'
                GROUP BY p.post_id";

        $query = $this->db->query($sql);
        $result = [];
        foreach ($query->result_array() as $key => $value) {
            $push['id']         = $value['post_id'];
            $push['whats_name'] = $value['whats_name'];
            $push['whats_date'] = $value['whats_date'];
            $push['whats_type'] = 'Post';
            $result[]           = $push;
        }
        return $result;
    }

    public function getWhatsNewEvent($date,$institute_post)
    {
        
        $sql = "SELECT e.event_id, e.event_name as whats_name, e.to_date as whats_date
                FROM event_new e
                INNER JOIN eventcontents_new c ON c.event_id = e.event_id 
                WHERE e.public = 1
                AND e.whats_new = 1
                AND e.whats_new_expiry_date >= '".date('Y-m-d')."'
                AND FIND_IN_SET(`e`.`institute_id`, ('".$institute_post."'))
                AND c.language_id = '1'
                GROUP BY e.event_id";

        $query = $this->db->query($sql);
        $result = [];
        foreach ($query->result_array() as $key => $value) {
            $push['id']         = $value['event_id'];
            $push['whats_name'] = $value['whats_name'];
            $push['whats_date'] = $value['whats_date'];
            $push['whats_type'] = 'Event';
            $result[]           = $push;
        }
        return $result;
    }

    public function getWhatsNewAnnouncement($date,$institute_post)
    {
                
        $sql = "SELECT a.announcement_id, a.title as whats_name, a.date as whats_date
                FROM announcement_new a
                INNER JOIN contentsannouncement_new c ON c.announcement_id = a.announcement_id
                WHERE a.public = 1
                AND a.whats_new = 1
                AND a.whats_new_expiry_date >= '".date('Y-m-d')."'
                AND FIND_IN_SET(`a`.`institute_id`, ('".$institute_post."'))
                GROUP BY a.announcement_id";

        $query = $this->db->query($sql);
        $result = [];
        foreach ($query->result_array() as $key => $value) {
            $push['id']         = $value['announcement_id'];
            $push['whats_name'] = $value['whats_name'];
            $push['whats_date'] = $value['whats_date'];
            $push['whats_type'] = 'Announcement';
            $result[]           = $push;
        }
        return $result;
    }

    public function getWhatsNewMediaCoverage($date,$institute_post)
    {
        
        $sql = "SELECT m.mediacoverage_id, m.title as whats_name, m.date as whats_date
                FROM mediacoverage_new m
                INNER JOIN contentsmediacoverage_new c ON c.mediacoverage_id = m.mediacoverage_id
                WHERE m.public = 1
                AND m.whats_new = 1
                AND m.whats_new_expiry_date >= '".date('Y-m-d')."'
                AND FIND_IN_SET(`m`.`institute_id`, ('".$institute_post."'))
                AND c.language_id = '1'
                GROUP BY m.mediacoverage_id";

        $query =$this->db->query($sql);
        $result = [];
        foreach ($query->result_array() as $key => $value) {
            $push['id']         = $value['mediacoverage_id'];
            $push['whats_name'] = $value['whats_name'];
            $push['whats_date'] = $value['whats_date'];
            $push['whats_type'] = 'Media Coverage';
            $result[]           = $push;
        }
        return $result;
    }

    public function getWhatsNewPressRelease($date,$institute_post)
    {
        $sql = "SELECT p.pressrelease_id, p.title as whats_name, p.date as whats_date
                FROM pressrelease p
                INNER JOIN titles t ON t.relation_id = p.pressrelease_id
                INNER JOIN contentspressrelease c ON c.relation_id = p.pressrelease_id
                WHERE p.public = 1
                AND p.whats_new = 1
                AND p.whats_new_expiry_date >= '".date('Y-m-d')."'
                AND FIND_IN_SET(`p`.`institute_id`, ('".$institute_post."'))
                AND t.language_id = '1'
                AND t.data_type = 'pressrelease'
                AND c.data_type = 'pressrelease'
                GROUP BY p.pressrelease_id";

        $query =$this->db->query($sql);
        $result = [];
        foreach ($query->result_array() as $key => $value) {
            $push['id']         = $value['pressrelease_id'];
            $push['whats_name'] = $value['whats_name'];
            $push['whats_date'] = $value['whats_date'];
            $push['whats_type'] = 'Press Release';
            $result[]           = $push;
        }
        return $result;
    }

    public function getWhatsNewdata($date,$institute_post)
    {
        $sql = "SELECT p.whatsnew_id, p.title as whats_name, p.whats_new_expiry_date as whats_date, p.url as whats_url, p.newtab as whats_newtab, p.publish_date as whats_publish_date
                FROM whatsnew p
                WHERE p.public = 1
                AND p.whats_new_expiry_date >= '".date('Y-m-d')."'
                AND FIND_IN_SET(`p`.`institute_id`, ('".$institute_post."'))
                GROUP BY p.whatsnew_id";

        $query =$this->db->query($sql);
        $result = [];
        foreach ($query->result_array() as $key => $value) {
            $push['id']                 = $value['whatsnew_id'];
            $push['whats_name']         = $value['whats_name'];
            $push['whats_url']          = $value['whats_url'];
            $push['whats_newtab']       = $value['whats_newtab'];
            if($institute_post == 17)
            {
                $push['whats_publish_date'] = $value['whats_publish_date'];
            }
            else
            {
                $push['whats_date']         = $value['whats_publish_date'];
            }
            $push['whats_type']         = 'Whats New';
            $result[]                   = $push;
        }
        return $result;
    }

    public function getWhatsNewNotices($date,$institute_post)
    {
        $sql = "SELECT n.id, n.name as whats_name, n.date as whats_date, n.notices_cat_id, n.academic_year
                FROM notices n
                WHERE n.status = 1
                AND n.whats_new = 1
                AND n.whats_new_expiry_date >= '".date('Y-m-d')."'
                AND FIND_IN_SET(`n`.`institute_id`, ('".$institute_post."'))
                GROUP BY n.id";

        $query =$this->db->query($sql);

        $result = [];
        foreach ($query->result_array() as $key => $value) {
            $push['id']         = $value['id'];
            $push['whats_name'] = $value['whats_name'];
            $push['whats_date'] = $value['whats_date'];
            $push['whats_type'] = 'Notices';
            // note: get only first category value because its used for redirect to notice page.
            $push['notices_cat_id'] = reset(explode(',', $value['notices_cat_id']));
            $push['academic_year'] = $value['academic_year'];
            $result[]           = $push;
        }
        return $result;
    }

    function getWhatsNewHome($date,$institute_post)
    {
        $post           = $this->getWhatsNewPost($date,$institute_post);
        $events         = $this->getWhatsNewEvent($date,$institute_post);
        $announcement   = $this->getWhatsNewAnnouncement($date,$institute_post);
        $mediacoverage  = $this->getWhatsNewMediaCoverage($date,$institute_post);
        $pressrelease   = $this->getWhatsNewPressRelease($date,$institute_post);
        $whatsnew       = $this->getWhatsNewdata($date,$institute_post);
        $notices        = $this->getWhatsNewNotices($date,$institute_post);

        $result         = array_merge($events, $announcement);
        $result1        = array_merge($mediacoverage, $pressrelease);
        $result2        = array_merge($post, $result1);
        $result3        = array_merge($whatsnew, $result2);
        $result4        = array_merge($notices, $result3);

        //$return         = array_merge($result, $result3);
        $return         = array_merge($result, $result4);


        foreach ($return as $key => $part) {
           $sort[$key]  = strtotime($part['whats_date']);
        }

        array_multisort($sort, SORT_DESC, $return);
        return $return;
    }

    /***Eevent AJAX Pagination with search filters ***/

    function event_listing_AJAX($params = array())
    {
        $institute=$params['search']['institute_check'];
        $location=$params['search']['location_check'];
        $interest=$params['search']['evetype_check'];
        $source=$params['search']['audtype_check'];
        $fromDate=$params['search']['from_date'];
        $toDate=$params['search']['to_date'];
        $event_sec=$params['search']['event_sec'];
        $sub_institutes=$params['search']['sub_institute_check'];

        $all_selected_institutes = $this->get_all_selected_institutes($institute);
        $all_subinstitutes_list = $this->get_all_subinstitutes_list($institute);

        //filter data by searched keywords
        if(!empty($params['search']['keywords']) AND $params['search']['keywords']!='undefined'){
            $this->db->like('event.event_name',$params['search']['keywords']);
        }
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }

        // if(!empty($institute) AND $institute!='undefined'){
        //     $this->db->where("FIND_IN_SET(`edu_institute_dir`.`INST_ID`, ('$institute'))");
            
        // }

        if(strstr($_SERVER['HTTP_HOST'], 'stage-university.somaiya.edu') OR $_SERVER['SERVER_NAME'] == 'www.somaiya.edu')
        {
            $this->db->where('edu_institute_dir.COMES_UNDER_UNIVERSITY','Y');
        }

        if(!empty($sub_institutes) AND $sub_institutes!='undefined'){
            $this->db->where("edu_institute_dir.INST_ID IN ($sub_institutes)");
            
        }
        else
        {
            if(!empty($institute) AND $institute!='undefined'){
                if(!empty($all_selected_institutes) AND $all_selected_institutes!='undefined'){
                    $this->db->where("edu_institute_dir.INST_ID IN ($all_selected_institutes)");

                }
                else
                {
                    $this->db->where("edu_institute_dir.INST_ID IN ($institute)");
                }
            }
        }

        if(!empty($location) AND $location!='undefined'){
            $this->db->where("event.location_id IN ($location)");
            
        }
        if(!empty($interest) AND $interest!='undefined') { 
            $this->db->where("event.event_type IN ($interest)");   
          
        } 
        if(!empty($source) AND $source!='undefined') { 
            $this->db->where("event.audience_type IN ($source)");   
          
        } 
        
        if(!empty($fromDate) AND $fromDate!='undefined' AND !empty($toDate) AND $toDate!='undefined') {
            $start_date = $fromDate.' 00:00:00';
            $end_date   = $toDate.' 23:59:59';
            $this->db->where('event.to_date BETWEEN "'.$start_date.'" and "'.$end_date.'"');
        }
        else
        {
            if($event_sec == 'upcoming')
            {
                //$this->db->where('event.to_date >=', date('Y-m-d ').' 00:00:00');
                //$this->db->order_by('event.to_date',"ASC");
                if(!empty($fromDate) AND $fromDate!='undefined')
                {
                    //$this->db->where("(DATE_FORMAT(event.from_date,'%Y-%m-%d') >= '".date('Y-m-d',strtotime($fromDate))."' OR DATE_FORMAT(event.from_date,'%Y-%m-%d')='0000-00-00')"); 
                    $this->db->where("(DATE_FORMAT(event.to_date,'%Y-%m-%d') >= '".date('Y-m-d',strtotime($fromDate))."' OR DATE_FORMAT(event.to_date,'%Y-%m-%d')='0000-00-00')"); 
                }
                elseif(!empty($toDate) AND $toDate!='undefined')
                {
                    $this->db->where("(DATE_FORMAT(event.to_date,'%Y-%m-%d') >= '".date('Y-m-d',strtotime($toDate))."' OR DATE_FORMAT(event.to_date,'%Y-%m-%d')='0000-00-00')"); 
                }
                else
                {
                    $this->db->where("(DATE_FORMAT(event.to_date,'%Y-%m-%d') >= '".date('Y-m-d')."' OR DATE_FORMAT(event.to_date,'%Y-%m-%d')='0000-00-00')"); 
                }

            }
            elseif($event_sec == 'past')
            {
                //$this->db->where('event.to_date <', date('Y-m-d ').' 00:00:00');
                //$this->db->order_by('event.to_date',"DESC");

                if(!empty($fromDate) AND $fromDate!='undefined')
                {
                    //$this->db->where("(DATE_FORMAT(event.from_date,'%Y-%m-%d') <= '".date('Y-m-d',strtotime($fromDate))."' OR DATE_FORMAT(event.from_date,'%Y-%m-%d')='0000-00-00')");
                    $this->db->where("(DATE_FORMAT(event.to_date,'%Y-%m-%d') <= '".date('Y-m-d',strtotime($fromDate))."' OR DATE_FORMAT(event.to_date,'%Y-%m-%d')='0000-00-00')"); 
                }
                elseif(!empty($toDate) AND $toDate!='undefined')
                {
                    $this->db->where("(DATE_FORMAT(event.to_date,'%Y-%m-%d') <= '".date('Y-m-d',strtotime($toDate))."' OR DATE_FORMAT(event.to_date,'%Y-%m-%d')='0000-00-00')"); 
                }
                else
                {
                    $this->db->where("(DATE_FORMAT(event.to_date,'%Y-%m-%d') <= '".date('Y-m-d')."' OR DATE_FORMAT(event.to_date,'%Y-%m-%d')='0000-00-00')"); 
                }
            }
        }


        $this->db->select('*,GROUP_CONCAT(DISTINCT(edu_institute_dir.INST_NAME)) AS institute_namenew');
        $this->db->from('event_new event');
        $this->db->join('eventcontents_new',"eventcontents_new.event_id = event.event_id");
        $this->db->join('event_type',"event.event_type=event_type.event_type_id",'left');
        $this->db->join('event_audience_type',"event.audience_type=event_audience_type.audience_type_id",'left');

        $this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID,event.institute_id)",'left');
        $this->db->join('locations',"locations.location_id=event.location_id",'left');
        $this->db->where('eventcontents_new.language_id',$_SESSION["language"]["language_id"]);
        $this->db->where('event.public',1);
        $this->db->order_by('event.to_date',"DESC");
        $this->db->group_by("event.event_id");
        $query = $this->db->get();
        $result= ($query->num_rows() > 0)?$query->result_array():FALSE;
        $i=0;
        foreach ($result as $value) {
             $result[$i]['language']=$params['search']['lang'];
             $i++;
        } 
        return $result; 
         
    }

    /* Display Announcement Listing Page */

    function announcement_listing()
    {
         
        $this->db->select('*,GROUP_CONCAT(edu_institute_dir.INST_NAME) AS institute_namenew,announcement.date AS newvaluedate');
        $this->db->from('announcement_new announcement');
        $this->db->join('contentsannouncement_new',"contentsannouncement_new.announcement_id=announcement.announcement_id");
        $this->db->join('edu_institute_dir',"FIND_IN_SET(edu_institute_dir.INST_ID, announcement.institute_id)",'left');
        $this->db->join('category',"category.category_id=announcement.category_id",'left');
        $this->db->where('contentsannouncement_new.language_id',$_SESSION["language"]["language_id"]);
        $this->db->where('announcement.public',1);
        $this->db->order_by('announcement.date',"DESC");
        $this->db->group_by("announcement.announcement_id");
        $this->db->limit(4);
        $query = $this->db->get();
        return $query->result_array();
    }

    function announcement_category()
    {
        $this->db->select('DISTINCT(announcement.category_id) AS category_id, category.category_name');
        $this->db->from('announcement_new announcement');
        $this->db->join('category',"category.category_id=announcement.category_id",'left');
        $this->db->where('category.public',1);
        $this->db->order_by('category_name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }


    /* Display Announcement View Page */

    function viewAnnouncement($announcement_id)
    {
        
        $this->db->select('*');
        $this->db->from('announcement_new announcement');
        $this->db->join('contentsannouncement_new',"contentsannouncement_new.announcement_id=announcement.announcement_id");
        $this->db->join('category',"category.category_id=announcement.category_id",'left');
        $this->db->where('announcement.public',1);
        $this->db->where('announcement.announcement_id',$announcement_id);
        $this->db->order_by('announcement.announcement_id',"DESC");

        $query = $this->db->get();
        return $query->result_array();
    }


    /******** LATEST NEWS SECTION *********/


    public function getAnnouncementHome()
    {
                
        $sql = "SELECT a.announcement_id, a.title as whats_name, a.date as whats_date, c.description, a.image
                FROM announcement_new a
                INNER JOIN contentsannouncement_new c ON c.announcement_id = a.announcement_id
                WHERE a.public = 1
                ORDER BY a.date DESC";

        $query = $this->db->query($sql);
        $result = [];
        foreach ($query->result_array() as $key => $value) {
            $push['id']         = $value['announcement_id'];
            $push['name']       = $value['whats_name'];
            $push['date']       = $value['whats_date'];
            $push['type']       = 'Announcement';
            $push['description']= $value['description'];
            $push['image']      = $value['image'];
            $result[]           = $push;
        }
        return $result;
    }

    public function getMediaCoverageHome()
    {
        
        $sql = "SELECT m.mediacoverage_id, m.title as whats_name, m.date as whats_date, c.description, m.image
                FROM mediacoverage_new m
                INNER JOIN contentsmediacoverage_new c ON c.mediacoverage_id = m.mediacoverage_id
                WHERE m.public = 1
                ORDER BY m.date DESC";

        $query =$this->db->query($sql);
        $result = [];
        foreach ($query->result_array() as $key => $value) {
            $push['id']         = $value['mediacoverage_id'];
            $push['name']       = $value['whats_name'];
            $push['date']       = $value['whats_date'];
            $push['type']       = 'Media Coverage';
            $push['description']= $value['description'];
            $push['image']      = $value['image'];
            $result[]           = $push;
        }
        return $result;
    }

    function getLatestnewsHome()
    {
        $announcement   = $this->getAnnouncementHome();
        $mediacoverage  = $this->getMediaCoverageHome();

        $result         = array_merge($mediacoverage, $announcement);

        //$return         = array_merge($result, $result3);
        $return         = array_merge($result);


        foreach ($return as $key => $part) {
           $sort[$key]  = strtotime($part['date']);
        }

        array_multisort($sort, SORT_DESC, $return);
        return $return;
    }


    /***Announcement AJAX Pagination with search filters ***/

    function announcement_listing_AJAX($params = array())
    {
        $interest=$params['search']['category_check'];
        $fromDate=$params['search']['from_date'];
        $toDate=$params['search']['to_date'];

        //filter data by searched keywords
        if(!empty($params['search']['keywords']) AND $params['search']['keywords']!='undefined'){
            $this->db->like('announcement.title',$params['search']['keywords']);
        }
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }

        if(!empty($interest) AND $interest!='undefined') { 
            $this->db->where("announcement.category_id IN ($interest)");   
          
        } 
        if(!empty($fromDate) AND $fromDate!='undefined' AND !empty($toDate) AND $toDate!='undefined') { 
            $this->db->where("(DATE(`announcement`.`date`) BETWEEN '$fromDate' AND '$toDate')");            
        } 
        else
        {
            if(!empty($fromDate) AND $fromDate!='undefined')
            {
                $this->db->where("(DATE_FORMAT(announcement.date,'%Y-%m-%d') >= '".date('Y-m-d',strtotime($fromDate))."' OR DATE_FORMAT(announcement.date,'%Y-%m-%d')='0000-00-00')"); 
            }

            if(!empty($toDate) AND $toDate!='undefined')
            {
                $this->db->where("(DATE_FORMAT(announcement.date,'%Y-%m-%d') <= '".date('Y-m-d',strtotime($toDate))."' OR DATE_FORMAT(announcement.date,'%Y-%m-%d')='0000-00-00')"); 
            }
        }

        $this->db->select('*,announcement.date AS newvaluedate');
        $this->db->from('announcement_new announcement');
        $this->db->join('contentsannouncement_new',"contentsannouncement_new.announcement_id=announcement.announcement_id");
        $this->db->join('category',"category.category_id=announcement.category_id",'left');
        $this->db->where('contentsannouncement_new.language_id',$_SESSION["language"]["language_id"]);
        $this->db->where('announcement.public',1);
        $this->db->order_by('announcement.date',"DESC");
        $this->db->group_by("announcement.announcement_id");
        $query = $this->db->get();
        $result= ($query->num_rows() > 0)?$query->result_array():FALSE;
        $i=0;
        foreach ($result as $value) {
             $result[$i]['language']=$params['search']['lang'];
             $i++;
        } 
        return $result;       
    }


    function latestAnnouncement_AJAX($params = array())
    {   
        $interest=$params['search']['category_check'];

        //filter data by searched keywords
        if(!empty($params['search']['keywords']) AND $params['search']['keywords']!='undefined'){
            $this->db->like('announcement.title',$params['search']['keywords']);
        }
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        } 

        if(!empty($interest) AND $interest!='undefined') { 
            $this->db->like('announcement.badge',$interest);          
        }

        $this->db->select('announcement.date AS date,announcement.announcement_id as id, announcement.image as image, announcement.badge as badge, announcement.title as title, contentsannouncement_new.description as description');
        $this->db->from('announcement_new announcement');
        $this->db->join('contentsannouncement_new',"contentsannouncement_new.announcement_id=announcement.announcement_id");
        $this->db->where('contentsannouncement_new.language_id',$_SESSION["language"]["language_id"]);
        $this->db->where('announcement.public',1);
        $this->db->order_by('announcement.date',"DESC");
        $this->db->group_by("announcement.announcement_id");
        $query = $this->db->get();
        // $str = $this->db->last_query();
        // echo "<pre>"; print_r($str); exit;
        $result= ($query->num_rows() > 0)?$query->result_array():FALSE;
        $i=0;
        foreach ($result as $value) {
             $result[$i]['language']=$params['search']['lang'];
             $i++;
        } 
        return $result;       
    }

    function latestMediaCoverage_AJAX($params = array())
    {
        $interest=$params['search']['category_check'];

        //filter data by searched keywords
        if(!empty($params['search']['keywords']) AND $params['search']['keywords']!='undefined'){
            $this->db->like('mediacoverage.title',$params['search']['keywords']);
        }
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        } 

        if(!empty($interest) AND $interest!='undefined') { 
            $this->db->like('mediacoverage.badge',$interest);          
        }

        $this->db->select('mediacoverage.date AS date,mediacoverage.mediacoverage_id as id, mediacoverage.image as image, mediacoverage.badge as badge, mediacoverage.title as title, contentsmediacoverage_new.description as description');
        $this->db->from('mediacoverage_new mediacoverage');
        $this->db->join('contentsmediacoverage_new',"contentsmediacoverage_new.mediacoverage_id=mediacoverage.mediacoverage_id");
        $this->db->where('contentsmediacoverage_new.language_id',$_SESSION["language"]["language_id"]);
        $this->db->where('mediacoverage.public',1);
        $this->db->order_by('mediacoverage.date',"DESC");
        $this->db->group_by("mediacoverage.mediacoverage_id");
        $query = $this->db->get();
        // $str = $this->db->last_query();
        // echo "<pre>"; print_r($str); exit;
        $result= ($query->num_rows() > 0)?$query->result_array():FALSE;
        $i=0;
        foreach ($result as $value) {
             $result[$i]['language']=$params['search']['lang'];
             $i++;
        } 
        return $result;       
    }

    function latestNews_AJAX($params = array())
    {   
        $interest=$params['search']['category_check'];
        
        if($interest == 'Announcement')
        {
            $result   = $this->latestAnnouncement_AJAX($params);
        }
        elseif($interest == 'MediaCoverage')
        {
            $result  = $this->latestMediaCoverage_AJAX($params);
        }
        else
        {   
            //$result   = $this->latestAnnouncement_AJAX($params);
            $announcement   = $this->latestAnnouncement_AJAX($params);
            $mediacoverage  = $this->latestMediaCoverage_AJAX($params);
            $result         = array_merge($mediacoverage, $announcement);
        }
        return $result;       
    }

    function latestNews_AJAX_one($params = array())
    {   
        // echo "<pre>";print_r($params);exit;
        $interest=$params['search']['category_check'];

        $query = "(SELECT announcement.date AS date,announcement.announcement_id as id, announcement.image as image, announcement.badge as badge, announcement.title as title, contentsannouncement_new.description as description";
        $query = $query." FROM announcement_new announcement ";
        $query = $query." LEFT JOIN contentsannouncement_new ON contentsannouncement_new.announcement_id = announcement.announcement_id ";
        $query = $query." WHERE announcement.public=1";
        if(!empty($interest) AND $interest!='undefined') 
        { 
            $query = $query." AND announcement.badge LIKE '".$interest."'";
            // $query = $this->db->like('announcement.badge',$interest);           
        }
        if(!empty($params['search']['keywords']) AND $params['search']['keywords']!='undefined')
        {
            $query = $query." AND announcement.title LIKE '".$params['search']['keywords']."'";
            // $query = $this->db->like('announcement.title',$params['search']['keywords']);
        }
        // $query = $query." ORDER BY announcement.date DESC";
        $query = $query.") UNION (";
        $query = $query."SELECT mediacoverage.date AS date,mediacoverage.mediacoverage_id as id, mediacoverage.image as image, mediacoverage.badge as badge, mediacoverage.title as title, contentsmediacoverage_new.description as description";
        $query = $query." FROM mediacoverage_new mediacoverage ";
        $query = $query." LEFT JOIN contentsmediacoverage_new ON contentsmediacoverage_new.mediacoverage_id = mediacoverage.mediacoverage_id ";
        $query = $query." WHERE mediacoverage.public=1";
        if(!empty($interest) AND $interest!='undefined') 
        { 
            $query = $query." AND mediacoverage.badge LIKE '".$interest."'";
            // $query = $this->db->like('mediacoverage.badge',$interest);          
        }
        if(!empty($params['search']['keywords']) AND $params['search']['keywords']!='undefined')
        {
            $query = $query." AND mediacoverage.title LIKE '".$params['search']['keywords']."'";
            // $query = $this->db->like('mediacoverage.title',$params['search']['keywords']);
        }
        // $query = $query." ORDER BY mediacoverage.date DESC";
        $query = $query.")";
        $query = $query." ORDER BY 1 DESC ";

        // if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
        //     echo "<br>test 1";
        //     $query = $query."limit ".$params['limit'].",".$params['start'];
        //     //$this->db->limit($params['limit'],$params['start']);
        // }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
        //     echo "<br>test 2";
        //     $query = $query."limit ".$params['limit'];
        //     //$this->db->limit($params['limit']);
        // }
        // else
        // {
        //     echo "<br>test 3";
        // }
        if(array_key_exists("start",$params) && array_key_exists("limit",$params))
        {
            $query = $query."limit ".$params['start'].','.$params['limit'];
        }
        $finalquery= $this->db->query($query);
        $result = $finalquery->result_array();
        // echo "<pre>";print_r($result);exit;
        // $str = $this->db->last_query();
        // echo "<pre>"; print_r($str); 
        // exit;
        return $result;       
    }

    /* Display Media Coverage View Page */

    function viewMediaCoverage($mediacoverage_id)
    {
        
        $this->db->select('*');
        $this->db->from('mediacoverage_new mediacoverage');
        $this->db->join('contentsmediacoverage_new',"contentsmediacoverage_new.mediacoverage_id=mediacoverage.mediacoverage_id");
        $this->db->join('category',"category.category_id=mediacoverage.category_id",'left');
        $this->db->join('mediacoverage_source',"mediacoverage_source.id=mediacoverage.source",'left');
        $this->db->where('contentsmediacoverage_new.language_id',$_SESSION["language"]["language_id"]);
        $this->db->where('mediacoverage.public',1);
        $this->db->where('mediacoverage.mediacoverage_id',$mediacoverage_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /***Video AJAX Pagination with search filters ***/

    function video_listing_AJAX($params = array())
    {
        $category       = $params['search']['category_check'];
        $fromDate       = $params['search']['from_date'];
        $toDate         = $params['search']['to_date'];

        //filter data by searched keywords
        if(!empty($params['search']['keywords']) AND $params['search']['keywords']!='undefined'){
            $this->db->like('video_management.video_text',$params['search']['keywords']);
        }
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }

        // if(!empty($institute) AND $institute!='undefined'){
        //     $this->db->where("FIND_IN_SET(`edu_institute_dir`.`INST_ID`, ('$institute'))");
            
        // }

        if(!empty($category) AND $category!='undefined'){
            $this->db->where("video_management.category IN ($category)");
            
        }
              
        if(!empty($fromDate) AND $fromDate!='undefined' AND !empty($toDate) AND $toDate!='undefined') { 
           //$this->db->where("(DATE(`video_management`.`created_date`) BETWEEN '$fromDate' AND '$toDate')");
            $this->db->where("(DATE(`video_management`.`date`) BETWEEN '$fromDate' AND '$toDate')");             
        }   
        else
        {
            
            if(!empty($fromDate) AND $fromDate!='undefined')
            {
                $this->db->where("(DATE_FORMAT(video_management.date,'%Y-%m-%d') >= '".date('Y-m-d',strtotime($fromDate))."' OR DATE_FORMAT(video_management.date,'%Y-%m-%d')='0000-00-00')"); 
            }

            if(!empty($toDate) AND $toDate!='undefined')
            {
                $this->db->where("(DATE_FORMAT(video_management.date,'%Y-%m-%d') <= '".date('Y-m-d',strtotime($toDate))."' OR DATE_FORMAT(video_management.date,'%Y-%m-%d')='0000-00-00')"); 
            }
        }

        $this->db->select("*");
        $this->db->from('video_management_new video_management');
        $this->db->where('video_management.public',1);
        $this->db->order_by('video_management.date','DESC');
        $query = $this->db->get();

        $result= ($query->num_rows() > 0)?$query->result_array():FALSE;
        $i=0;
        foreach ($result as $value) {
             $result[$i]['language']=$params['search']['lang'];
             $i++;
        }         
        return $result; 

    }
    
}