<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|   example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|   http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|   $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|   $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|   $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes with
| underscores in the controller and method URI segments.
|
| Examples: my-controller/index -> my_controller/index
|       my-controller/my-method -> my_controller/my_method
*/
$route['default_controller'] = "Somaiya_general";
$route['404_override'] = 'errors/error404';


if(isset($varsha)){
} else {
    $route['([a-z][a-z])/page/([0-9]+)'] = 'Somaiya_general/page/$1/$2';
}

/***** SVV SITE FRONTEND *****/

require_once(BASEPATH.'database/DB.php'); 
$db =& DB();


// if ($_SERVER['SERVER_NAME'] == 'www.somaiya.com' OR strstr($_SERVER['HTTP_HOST'], 'stage.somaiya.com')) 
// {   
    $route['([a-z][a-z])']                                                  = 'Somaiya_general/index/$1';
    $query = $db->get_where( 'page',array('institute_id'=>1) );
    $result = $query->result();
    foreach( $result as $row )
    {
        $route[ '([a-z][a-z])/'.$row->slug .'/(:num)' ] = 'Somaiya_general/page/$1';
        $route[ '([a-z][a-z])/'.$row->slug ] = 'Somaiya_general/page/$1';
    }
    $route['([a-z][a-z])/sitemap.xml']                          = 'Somaiya_general/siteMapXML/$1';
    $route['([a-z][a-z])/view-news/([0-9]+)']                   = 'Somaiya_general/view_announcement/$1/$2';
    $route['([a-z][a-z])/view-media-coverage/([0-9]+)']         = 'Somaiya_general/view_media_coverage/$1/$2';
// }


/***** SVV SITE BACKEND *****/

$route['admin-sign']                                                    = "Somaiya_admin_sign/index";
$route['admin-sign/login']                                              = "Somaiya_admin_sign/login";
$route['admin-sign/logout']                                             = "Somaiya_admin_sign/logout";
$route['admin']                                                         = "Somaiya_general_admin/index";
$route['admin']                                                         = "Somaiya_general_admin/index";
$route['admin/(.*)']                                                    = "Somaiya_general_admin/$1";
$route['admin-sign/ajax/(:any)']                                        = 'Institute_category/myformAjax';
$route['translate_uri_dashes']                                          = FALSE;