<?php
/**
 * Created by Somaiya Team.
 * User: Somaiya
 * Date: 9/16/2016
 * Time: 1:03 AM
 * Project: Somaiya Vidyavihar
 * Website: http://www.Somaiya.com
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Sidebarmenu_permissions extends Somaiya_Controller {
    private $permission_method_ids;
    private $permission_page_ids;

    function __construct()
    {
          parent::__construct('backend');
        $this->load->model('cms/sidebar_module/Sidebarmenu_permissions_model', 'sidebarmenu_permissions_model');
                $this->load->model('cms/sidebar_module/Sidebar_module_model', 'sidebar_module_model');
        $user_id = $this->session->userdata['user_id'];
        $this->data['institutes'] = $this->Somaiya_general_admin_model->get_all_institute();
        $default_institute_id = $this->config->item('default_institute_id');
      //  validate_permissions('', '', '', 'notallowed');
    }

    function index()
    {// missing use
        $this->data['main_menu_type'] = "user_management";
        $this->data['sub_menu_type'] = "Sidemodlue_permissions";
        $this->data['child_menu_type'] = "Sidemodlue_permissions";
        $this->data['sub_child_menu_type'] = "";
        validate_permissions('Sidebarmenu_permissions', 'index', $this->config->item('method_for_view'));




        //session data
        $instituteID  = $this->session->userdata('sess_institute_id');
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
        $inst_id = $instituteID ? $instituteID : $default_institute_id;
        $status=-1;
        validate_permissions('Sidebarmenu_permissions', 'index', $this->config->item('method_for_view'), $inst_id);
        $this->data['data_list']=$this->sidebarmenu_permissions_model->view_page_permissions($status);
        $this->data['title'] = _l("Sidebarmenu_permissions",$this);
        $this->data['page'] = "Sidebarmenu_permissions";
        $this->data['content']=$this->load->view('cms/sidebarmenu_permissions'.'/index',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }



    function edit($id='')
    {
        $this->data['main_menu_type'] = "user_management";
        $this->data['sub_menu_type'] = "Sidemodlue_permissions";
        $this->data['child_menu_type'] = "Sidemodlue_permissions";
        $this->data['sub_child_menu_type'] = "";
         $save_data                  = [];
         //$this->load->model('Modulepermissions_model');
        $instituteID  = $this->session->userdata('sess_institute_id');
        $this->data['institute_name']       = $this->session->userdata['sess_institute_name'];
        $this->data['institute_short_name'] = $this->session->userdata['sess_institute_short_name'];
        $inst_id = $instituteID ? $instituteID : $default_institute_id;
        validate_permissions('Sidebarmenu_permissions', 'edit', $this->config->item('method_for_edit'), $inst_id);
         if($id!='')
        {//$this->data['main_menu_type'] = "user_management";
            $this->data['data']         = $this->sidebarmenu_permissions_model->edit_permission($id);
             $instituteid=$this->data['data']['pr_inst_id'];
            if($this->data['data']==null)
            {
                $msg                    = ['error' => 0, 'message' => 'Permission not found'];
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url()."module_permissions/view_permissions");
            }

            if(isset($this->data['data']['permissions']) && !empty($this->data['data']['permissions']))
            {
                //$this->data['main_menu_type'] = "user_management";
                $this->data['permissions'] = explode(',', $this->data['data']['permissions']);
            }
           // $this->data['select_all_data'] = explode(',', $this->data['data']['select_all']);
        }
        // echo "<pre>";print_r($this->data['select_all_data']);exit;



        if($this->input->post())
        {
              $save_data['institute_id']         = $this->input->post('pr_inst_id');

                $save_data['permission']    = implode(',', array_values(array_filter($this->input->post('module_id'))));


            $sql = 'SELECT pr_id FROM module_permission WHERE 1=1 AND institute_id="'.$save_data['institute_id'].'" ';
            $result = $this->common_model->custom_query($sql);
            if(isset($result[0]['pr_id']) && !empty($result[0]['pr_id']))
            {
                $id                          = $result[0]['pr_id'];
            }

            if($this->sidebarmenu_permissions_model->save_module_permission($save_data, $id))
            {
                $msg                    = ['error' => 0, 'message' => 'Module permissions successfully saved'];
            }
            else
            {
                $msg                    = ['error' => 0, 'message' => 'Unable to save module permissions'];
            }


 $this->session->set_flashdata('requeststatus', $msg);
            redirect(base_url().'cms/sidebarmenu_permissions/index/');
      }
          $this->data['pr_id']            = $id;
        $this->data['title']            = _l("Page Permissions",$this);
        // $this->data['menu_data']        = $this->nested_menu(50);
        $this->data['institutes_list']  = $this->Somaiya_general_admin_model->get_all_institute();
        $this->data['content']      = $this->load->view('cms/sidebarmenu_permissions'.'/form',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);
    }


/*    function edit_permissions($id='')
    {
       // $this->data['main_menu_type'] = "user_management";
        $this->data['sub_menu_type'] = "application_permissions";
        $this->data['child_menu_type'] = "application_permissions";
        $this->data['sub_child_menu_type'] = "";

        $per_action = $id ? $this->config->item('method_for_edit') : $this->config->item('method_for_add');
        validate_permissions('Permissions', 'edit_permissions', $per_action);

        $this->data['permissions']      = [];
        $this->data['select_all_data']  = [];

        if($id!='')
        {
             $this->data['data']         = $this->sidebarmenu_permissions_model->edit_permission($id);
            $group=$this->data['data']['pr_group_id'];
            $instituteid=$this->data['data']['pr_inst_id'];
            if($this->data['data']==null)
            {
                $msg                    = ['error' => 0, 'message' => 'Permission not found'];
                $this->session->set_flashdata('requeststatus', $msg);
                redirect(base_url()."permissions/view_permissions");
            }

            if(isset($this->data['data']['permissions']) && !empty($this->data['data']['permissions']))
            {
                $this->data['permissions'] = explode(',', $this->data['data']['permissions']);
            }
            $this->data['select_all_data'] = explode(',', $this->data['data']['select_all']);
        }
        // echo "<pre>";print_r($this->data['select_all_data']);exit;

        $this->data['title']            = _l("Permissions",$this); 
        $this->data['module']           = $this->Usermodule_model->view_usermodule();
        $this->data['groups']           = $this->Somaiya_general_admin_model->get_all_groups();
        $this->data['institutes_list']  = $this->Somaiya_general_admin_model->get_all_institute();
        $this->permission_method_ids    = [];
        $this->data['methods']          = $this->get_nested_modules();






        if($this->input->post())
        {
            $allowed_method_ids         = [];
            $save_data                  = [];
            $save_data['pr_group_id']   = isset($_POST['pr_group_id']) ? $_POST['pr_group_id'] : '';
            $save_data['pr_inst_id']    = isset($_POST['pr_inst_id']) ? $_POST['pr_inst_id'] : '';
            $save_data['select_all']    = implode(',', array_values(array_filter($this->input->post('selectall'))));

            foreach ($this->permission_method_ids as $key => $value) {
                if(isset($_POST['method-'.$value['pm_id']]) && $_POST['method-'.$value['pm_id']] == 1)
                {
                    $allowed_method_ids[] = $value['pm_id'];
                }
                // $save_data['methods'][$value['pm_id']] = isset($_POST['method-'.$value['pm_id']]) ? $_POST['method-'.$value['pm_id']] : 0;
            }

            $save_data['permissions']   = !empty($allowed_method_ids) ? implode(',', $allowed_method_ids) : '';

            $sql = 'SELECT pr_id FROM user_permissions WHERE 1=1 AND pr_group_id="'.$save_data['pr_group_id'].'" AND pr_inst_id="'.$save_data['pr_inst_id'].'"';
            $result = $this->common_model->custom_query($sql);
            if(isset($result[0]['pr_id']) && !empty($result[0]['pr_id']))
            {
                $id                          = $result[0]['pr_id'];
            }

            if($this->Permissions_model->add_permission($save_data, $id))
            {
                $msg                    = ['error' => 0, 'message' => 'Permissions successfully saved'];
            }
            else
            {
                $msg                    = ['error' => 0, 'message' => 'Unable to save permissions'];
            }
            $this->session->set_flashdata('requeststatus', $msg);
            redirect(base_url().'permissions/view_permissions/');
        }

        $this->data['content']=$this->load->view('permissions'.'/permissions_edit',$this->data,true);
        $this->load->view($this->mainTemplate,$this->data);    
    }
*/
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

    function add_permissions($id=null)
    {
        if ($this->Permissions_model->add_permission($_POST["data"],$id))
        {
            $this->session->set_flashdata('success', _l('Updated Permission',$this));
        }
        else
        {
            $this->session->set_flashdata('error', _l('Updated Permission error. Please try later',$this));
        }
        redirect(base_url()."permissions/view_permissions/");
    }

    function appenduser()
    { 
        $group_id = $_POST['pr_group_id'];

        $query=$this->db->query("SELECT u.user_id,u.fullname FROM users u LEFT JOIN groups g ON u.group_id=g.group_id WHERE u.group_id=".$group_id."");
        $rowCount = $query->num_rows();
            
        if($rowCount > 0){
            echo '<option value="">Select Group</option>';
            foreach ($query->result() as $row) { 
                echo '<option value="'.$row->user_id.'">'.$row->fullname.'</option>';
            }
        }else{
            echo '<option value="">Users not available</option>';
        }
    }

    function appendpages()
    { 
        $institute_id = $_POST['pr_inst_id'];

        $query=$this->db->query("SELECT p.page_id,p.page_name FROM page p LEFT JOIN edu_institute_dir i ON p.institute_id=i.INST_ID WHERE i.INST_ID=".$institute_id."");
        $rowCount = $query->num_rows();
            
        if($rowCount > 0){
            echo '<option value="">Select Group</option>';
            foreach ($query->result() as $row) { 
                echo '<option value="'.$row->page_id.'">'.$row->page_name.'</option>';
            }
        }else{
            echo '<option value="">Pages not available</option>';
        }
    }

    function custom_unique_permissions($post, $func)
    {
        $this->form_validation->set_message('custom_unique_username', "Username already exist");

        $result = TRUE;
        if(!empty($post))
        {
            $pr_id          = isset($post['pr_id']) ? $post['pr_id'] : '';
            $pr_group_id    = isset($post['pr_group_id']) ? $post['pr_group_id'] : '';
            $pr_inst_id     = isset($post['pr_inst_id']) ? $post['pr_inst_id'] : '';
            $pr_user_id     = isset($post['pr_user_id']) ? $post['pr_user_id'] : '';
            $pr_valid_from  = isset($post['pr_valid_from']) ? $post['pr_valid_from'] : '';
            $pr_valid_upto  = isset($post['pr_valid_upto']) ? $post['pr_valid_upto'] : '';

            $sql            = 'SELECT * FROM user_permissions WHERE 1=1';

            if(!empty($pr_group_id))
            {
                $sql .= ' AND pr_group_id="'.$pr_group_id.'"';
            }
            if(!empty($pr_inst_id))
            {
                $sql .= ' AND pr_inst_id="'.$pr_inst_id.'"';
            }
            if(!empty($pr_user_id))
            {
                $sql .= ' AND pr_user_id="'.$pr_user_id.'"';
            }
            if(!empty($pr_id))
            {
                $sql .= ' AND pr_id != "'.$pr_id.'"';
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

    function ajax_check_permissions()
    {
        if($this->input->post())
        {
            $result = $this->custom_unique_permissions($this->input->post(), '');
            echo $result;exit;
        }
    }

    
    function view_module_permissions()
    {
     //   $this->load->model('Modulepermissions_model');
      // $this->data['main_menu_type'] = "user_management";
        $this->data['sub_menu_type'] = "page_permissions";
        $this->data['child_menu_type'] = "page_permissions";
        $this->data['sub_child_menu_type'] = "";

        $this->data['data_list']    = $this->sidebarmenu_permissions_model->view_page_permissions();
        $this->data['title']        = _l("Page Permissions",$this);
        $this->data['page']         = "Page Permissions";
        $this->data['content']      = $this->load->view('cms/sidebarmenu_permissions'.'/index',$this->data,true);
        $this->load->view($this->mainTemplate, $this->data);
    }






    function delete_permissions($id=0)
    {
        $this->common_model->set_table('module_permission');
        $response = $this->common_model->_delete('pr_id', $id);
        $this->session->set_flashdata('requeststatus', ['error' => $response['error'], 'message' => $response['message']]);
        redirect(base_url()."module_permissions/view_module_permissions/");
    }

    function get_menu_table()
    {

     //   $this->load->model('Modulepermissions_model');
        if($this->input->post('pr_id'))
        {
            $pr_id                              = $this->input->post('pr_id');
            //$inst_id                            = $this->input->post('inst_id');
            $this->data['add_permissions']      = 0;
            $this->data['edit_permissions']     = [];
           
            $this->data['view_permissions']     = [];
            $this->data['select_all_data']      = [];
$status=1;
            if($pr_id!='')
            {
                $this->data['pagedata']             = $this->sidebarmenu_permissions_model->edit_module_permission($pr_id);
 
               
   if(!empty($this->data['pagedata']))
      {
                    if(isset($this->data['pagedata']['permission']) && !empty($this->data['pagedata']['permission']))
                    {
                        
                        $this->data['view_permissions'] = explode(',', $this->data['pagedata']['permission']);

                    }
                }





            }
             //$this->load->model('Sidebarmodule_model');//comment ask how they loaded module
            $this->data['data_list'] =  $this->sidebar_module_model->view_sidebarmodule1($status);
        
            $html  = $this->load->view('cms/sidebarmenu_permissions'.'/page_permissions_table', $this->data, true);
            echo $html;exit;
        }
    }

  

}
