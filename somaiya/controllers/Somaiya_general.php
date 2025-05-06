<?php
/**
 * Created by Somaiya.
 * User: Somaiya
 * Date: 9/15/2015
 * Time: 8:30 PM
 * Project: Somaiya Vidyavihar 
 * Website: http://www.somaiya.com
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Somaiya_general extends Somaiya_Controller {

    function __construct()
    {   
        header("Access-Control-Allow-Origin: *");
        parent::__construct('frontend');
        $this->load->library('email');        
        $this->load->library("Ajax_pagination");
        $this->perPage = 10;
        $this->data['id_of_institute'] = $this->config->item('somaiya_institute_id');
        $this->load->helper('module');
        $this->load->helper('captcha');
    }

    // Set system language from URL
    public function preset($lang)
    {
        $language = $this->Somaiya_general_model->getLanguageByCode($lang);
        if($language!=0){
            $_SESSION["language"] = $language;
            $this->data["lang"] = $lang;
        }else{
            $language = $this->Somaiya_general_model->getLanguageDefault();
            if($language!=0){
                redirect(base_url().$language["code"]);
            }else{
                exit("Didn't found eny language!");
            }
        }
        $this->lang->load($lang, $language["language_name"]);
        $_SERVER['DOCUMENT_ROOT'] = dirname(dirname(dirname(__FILE__)));
        $this->data['lang_url'] = $_SERVER["REQUEST_URI"];
        $this->data['action'] = $_SERVER["REQUEST_URI"];
        $this->data['redirect'] = $_SERVER["REQUEST_URI"];

        $this->data['settings'] =  $this->Somaiya_general_model->getWebsiteInfo();
        $this->data['settings']["options"] =  $this->Somaiya_general_model->getWebsiteInfoOptions($language["language_id"]);
        $this->data['settings']["company"] =  isset($this->data['settings']["options"]["company"])?$this->data['settings']["options"]["company"]:$this->data['settings']["company"];
        $_SESSION['settings']=$this->data['settings'];

        /* Session institute id set for emergency notices */
        $_SESSION['emergency_institute_id']=1;

        /*** Emergency Module function start*/
        $institute_id = $this->data['id_of_institute'];
        $this->data["banner_listing"] = $this->Somaiya_general_model->get_homepage_banner($institute_id);

        $this->data['languages'] = $this->Somaiya_general_model->getLanguages();
        foreach ($this->data['languages'] as &$value) 
        {
            $url_array = explode("/",$this->data["lang_url"]);
            $url_array[array_search($lang,$url_array)]=$value["code"];
            $value["lang_url"] = implode("/",$url_array);
        }

        $this->data['link_contact'] = base_url()."contact";
    }

    // Homepage
    function index($ln=null)
    {  

        $this->preset($ln);
        if($ln == '') 
        {
            if (!$this->input->is_ajax_request())
            {
                //echo "cant access url directly";  
                show_404(); // Output "Page not found" error.
                exit();
            }
        } 
        $this->load->library('spyc');
        $page_type = spyc_load_file(getcwd()."/page_type.yml") ;
        $pages_render = array();
        $pages = $this->Somaiya_general_model->getPreviewPages();
        foreach ($pages as $item) 
        {
            $extension_data["page_data"] = $item;
            $extension_data["lang"] = $ln;
            $extension_data["settings"] = $this->data["settings"];
            $extension_data["preview_limit"] = $limit = get_extension_limit_preview($item["page_type"],$page_type);
            if(check_extension_order_preview($item["page_type"],$page_type))
            {
                $extension_data["data"] = $this->Somaiya_general_model->getExtensionsByPageId($item["page_id"],"extension_order","ASC",$limit!=0?$limit:null);
            }else{
                $extension_data["data"] = $this->Somaiya_general_model->getExtensionsByPageId($item["page_id"],"created_date","DESC",$limit!=0?$limit:null);
            }
            foreach ($extension_data["data"] as &$val) 
            {
                if(isset($val['extension_more'])) { $val['extension_more'] = spyc_load($val['extension_more']); }
            }

            $page_header = $item['title_caption'];
            $page_body = $this->load->view($page_type[$item["page_type"]]["theme_preview"],$extension_data,true);

            array_push($pages_render,array(
                "title"=>$page_header,
                "body"=>$page_body
            ));
        }

        $this->data['pages']            = $pages_render;
        $this->data['newsann']          = $this->Somaiya_general_model->announcement_listing();
        $this->data['latestnews']       = $this->Somaiya_general_model->getLatestnewsHome();
        // echo "<pre>";print_r($this->data['latestnews']);exit;

        $this->data['title']            = "Home";
        $this->data['keywords']         = isset($this->data['settings']["options"]["site_keyword"])?$this->data['settings']["options"]["site_keyword"]:"";
        $this->data['description']      = isset($this->data['settings']["options"]["site_description"])?$this->data['settings']["options"]["site_description"]:"";
        $this->data['content']          = $this->load->view($this->mainTemplate.'/home',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data,'');
    }

    // Pages content page
    function page($lang,$id=null)
    {
        $this->preset($lang);
        $this->load->library('spyc');
        $page_type = spyc_load_file(getcwd()."/page_type.yml");
         // If requested URL is in friendly URL format
        if($this->uri->segment(3))
        {
            $slug=$this->uri->segment(2)."/".$this->uri->segment(3);
        }
        else
        {
            $slug=$this->uri->segment(2);
        }

        // If requested URL is in /page/3 format
        $this->load->helper('url');

        if($this->uri->segment(2)=="page"){
            $id1 = $this->uri->segment(3);
            $page = $this->Somaiya_general_model->getPageSlug($id1);
            $slug=$page['slug'];
        
            // Redirect User to new formed URL : basepath()+lang()+$page
            redirect(base_url().$lang.'/'.$slug);
        }


        // $id1=$this->uri->segment(3);  
        $page = $this->Somaiya_general_model->getPageDetail($slug,$this->data['id_of_institute']);
        $id=$page['page_id'];
        if(!allowed_theme_page($page["page_type"],$page_type)){
            // show_404();
            $this->load->view('/common/404');
        }
        $order_by="created_date"; $sort="DESC";
        if(check_extension_order_preview($page["page_type"],$page_type)){ $order_by="extension_order"; $sort="ASC"; }
        if(isset($page_type[$page["page_type"]]["dynamic"])){
            // start code for page content  histpry 
                if(isset($_GET['pch_id']) && !empty($_GET['pch_id']) && is_numeric($_GET['pch_id']))
                {
                    $pch_id = $_GET['pch_id'];
                    $page_content_history_data = $this->Somaiya_general_model->get_page_content_history_data_by_id($pch_id,$id);
                    $page["body"] = $page_content_history_data;                 
                }
                else
                {
                    $page["body"] = $this->Somaiya_general_model->getExtensionsByPageId($id,$order_by,$sort,10,(isset($_GET["offset"]) && is_numeric($_GET["offset"]))?$_GET["offset"]:0);
                }
                // end code for page content  histpry 
                
        }else{
                // start code for page content  histpry 
                if(isset($_GET['pch_id']) && !empty($_GET['pch_id']) && is_numeric($_GET['pch_id']))
                {
                    $pch_id = $_GET['pch_id'];
                    $page_content_history_data = $this->Somaiya_general_model->get_page_content_history_data_by_id($pch_id,$id);
                    $page["body"] = $page_content_history_data;                 
                }
                else
                {
                    $page["body"] = $this->Somaiya_general_model->getExtensionsByPageId($id,$order_by,$sort);
                }
                // end code for page content  histpry 
            
        }
        $this->data['data']                             = $page;
        $this->data['title']=$page['title_caption'];
        $this->data['keyword'] = $this->Somaiya_general_model->getExtensionsByPageId($id);

        if(isset($_GET["ajax"]) && allowed_theme_page_ajax($page["page_type"],$page_type))
        {
            echo $this->load->view('flatlab/'.get_theme_page_ajax($page["page_type"],$page_type),$this->data,true);
        } 
        else 
        {
            if($this->uri->segment(2) == 'public-lectures')
            {
                $this->data['urisegment'] = $this->uri->segment(2);
                $use_template = $this->commonTemplate;
                $this->data['section_title'] = 'Public Lectures';
            }
            else
            {
                $use_template = $this->mainTemplate;
            }
            
            $this->data['view']=get_theme_page($page["page_type"],$page_type);
            $this->data['content']=$this->load->view($use_template.'/'.$this->data['view'],$this->data,true);
            $this->load->view($use_template,$this->data,'');
        }
    }

    // Sitemap 
    function siteMapXML()
    {
        header("Content-type: text/xml");
        $this->load->view('/somaiya_general/sitemap.xml');
    }


    /* These functions are used for the ajax functionality for the Announcement page */

    function announcement_ajax()
    {   
        if (!$this->input->is_ajax_request())
        {
            //echo "cant access url directly";  
            show_404(); // Output "Page not found" error.
            exit();
        }

        $conditions = array();

        //calc offset number
        $page2 = $this->security->xss_clean($this->input->post('page_no'));

        if(!$page2){
            $offset = 0;
        }else{
            $offset = $page2;
        }   

        //set conditions for search
        $keywords = $this->security->xss_clean($this->input->post('keywords'));
        $sortBy = $this->security->xss_clean($this->input->post('sortBy'));
        $categories = $this->security->xss_clean($this->input->post('category_check'));
        $fdate = $this->security->xss_clean($this->input->post('from_date'));
        $tdate = $this->security->xss_clean($this->input->post('to_date'));
        $lang1 = $this->security->xss_clean($this->input->post('lang'));


        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        if(!empty($categories)){
            $conditions['search']['category_check'] = $categories;
        }
        if(!empty($fdate)){
            $conditions['search']['from_date'] = $fdate;
        }
        if(!empty($tdate)){
            $conditions['search']['to_date'] = $tdate;
        }
        if(!empty($lang1)){
            $conditions['search']['lang'] = $lang1;
        }
      
        $custconditions = [];
        $pp = $this->Somaiya_general_model->announcement_listing_AJAX($conditions,$custconditions);  
        if(!empty($pp)){$annCount = count($pp); }

        //pagination configuration
        $config['target']      = '#refined';
        $config['base_url'] = base_url().'/en/latest-news';
        $config['total_rows']  = $annCount;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';

        $this->ajax_pagination->initialize($config);
       //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;  

        // if(!empty($keywords) OR !empty($categories) OR !empty($fdate) OR !empty($tdate)){
        $this->data['ann_count']=$annCount;
        // }else {
        //     $this->data['ann_count']=0;
        // }   

        $this->data['announcement_listing_AJAX'] = $this->Somaiya_general_model->announcement_listing_AJAX($conditions);
        $this->load->view($this->mainTemplate.'/'.'page_type/ajax-pagination-announcement',$this->data,false);
    }


    function latestNews_ajax()
    {   
        if (!$this->input->is_ajax_request())
        {
            //echo "cant access url directly";  
            show_404(); // Output "Page not found" error.
            exit();
        }

        $conditions = array();

        //calc offset number
        $page2 = $this->security->xss_clean($this->input->post('page_no'));

        if(!$page2){
            $offset = 0;
        }else{
            $offset = $page2;
        }   

        //set conditions for search
        $keywords = $this->security->xss_clean($this->input->post('keywords'));
        $sortBy = $this->security->xss_clean($this->input->post('sortBy'));
        $categories = $this->security->xss_clean($this->input->post('category_check'));
        $lang1 = $this->security->xss_clean($this->input->post('lang'));


        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        if(!empty($categories)){
            $conditions['search']['category_check'] = $categories;
        }
        if(!empty($lang1)){
            $conditions['search']['lang'] = $lang1;
        }
      
        $pp = $this->Somaiya_general_model->latestNews_AJAX_one($conditions);
        if(!empty($pp)){$newsCount = count($pp); }

        //pagination configuration
        $config['target']       = '#refined';
        $config['base_url']     = base_url().'/en/latest-news';
        $config['total_rows']   = $newsCount;
        $config['per_page']     = 12;
        $config['link_func']    = 'searchFilter';

        $this->ajax_pagination->initialize($config);
       //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = 12;  

        // if(!empty($keywords) OR !empty($categories) OR !empty($fdate) OR !empty($tdate)){
        // if(!empty($keywords) OR !empty($categories)){
            $this->data['news_count']=$newsCount;
        // }else {
        //     $this->data['news_count']=0;
        // }   
        // echo "<pre>";print_r($conditions);exit();
        $this->data['latestNews_AJAX'] = $this->Somaiya_general_model->latestNews_AJAX_one($conditions);
        // echo "<pre>";print_r($this->data['latestNews_AJAX']);exit;
        $this->load->view($this->mainTemplate.'/'.'page_type/ajax-pagination-latestnews',$this->data,false);
    }


    /* This function is to view the single Announcement post by passing the '$announcement_id' */

    function view_announcement($lang,$announcement_id)
    {
        $this->preset($lang);
        $instituteid = 1;
        $announcement_id = $this->security->xss_clean($announcement_id);
        if( view_announcement($instituteid,$announcement_id,$this->Somaiya_general_model,$lang))
        {
            $this->data['content']=$this->load->view($this->mainTemplate.'/view-announcement',$this->data,true);
            $this->load->view($this->mainTemplate,$this->data,'');
        }
        else
        {
            $this->load->view('/common/404');
        }
    }

    /* This function is to view the single Media Coverage post by passing the '$mediacoverage_id' */

    function view_media_coverage($lang,$mediacoverage_id)
    {
        $this->preset($lang);
        $alias = $this->security->xss_clean($this->uri->segment(3));
        $mediacoverage_id = $this->security->xss_clean($mediacoverage_id);
        
        if( view_media_coverage($alias,$mediacoverage_id,$this->Somaiya_general_model,$lang))
        {
        $this->data['content']=$this->load->view($this->mainTemplate.'/view-media-coverage',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data,'');
        }
        else
        {
            $this->load->view('/common/404');
        }
    }

    /* These functions are used for the ajax functionality for the Video page */

    function video_ajax_new()
    {   
        if (!$this->input->is_ajax_request())
        {
            //echo "cant access url directly";  
            show_404(); // Output "Page not found" error.
            exit();
        }

        $conditions = array();

        //calc offset number
        $page2 = $this->security->xss_clean($this->input->post('page_no'));

        if(!$page2){
            $offset = 0;
        }else{
            $offset = $page2;
        }   

        //set conditions for search
        $keywords       = $this->security->xss_clean($this->input->post('keywords'));
        $category       = $this->security->xss_clean($this->input->post('category_check'));
        $fdate          = $this->security->xss_clean($this->input->post('from_date'));
        $tdate          = $this->security->xss_clean($this->input->post('to_date'));
        $lang1          = $this->security->xss_clean($this->input->post('lang'));


        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($category)){
            $conditions['search']['category_check'] = $category;
        }
        if(!empty($fdate)){
            $conditions['search']['from_date'] = $fdate;
        }
        if(!empty($tdate)){
            $conditions['search']['to_date'] = $tdate;
        }
        if(!empty($lang1)){
            $conditions['search']['lang'] = $lang1;
        }

        $pp = $this->Somaiya_general_model->video_listing_AJAX($conditions);  
        if(!empty($pp)){$videoCount = count($pp); }

        //pagination configuration
        $config['target']       = '#refined';
        $config['base_url']     = base_url().'/en/videos';
        $config['total_rows']   = $videoCount;
        $config['per_page']     = $this->perPage;
        $config['link_func']    = 'searchFilter';

        $this->ajax_pagination->initialize($config);
       //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;  

         if(!empty($keywords) OR !empty($category) OR !empty($fdate) OR !empty($tdate)){
             $this->data['video_count']=$videoCount;
        }else {
            $this->data['video_count']=0;
        }   

        $this->data['video_listing_AJAX1'] = $this->Somaiya_general_model->video_listing_AJAX($conditions);
        // echo "<pre>";print_r($this->data['video_listing_AJAX1']);exit;
        $this->load->view($this->mainTemplate.'/'.'page_type/ajax-pagination-video',$this->data,false);
    }

}