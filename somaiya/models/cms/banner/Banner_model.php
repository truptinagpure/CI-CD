<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Banner_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_banner_list($conditions=[])
    {
        $this->db->select('*');
        $this->db->from('banner_images');

        if(!empty($conditions))
        {
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        $this->db->where('public !=', '-1');
        $this->db->order_by('image_id', 'DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    function _insert($data) {
        $response['status']         = 'failed';
        $table                      = 'banner_images';
        
        $res                        = $this->db->insert($table, $data);
        
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

    function _update($col, $val, $updatedata) {
        $response['status']         = 'error';
        $table                      = 'banner_images';
        
        $this->db->where($col, $val);
        $update                     = $this->db->update($table, $updatedata);

        if($update)
        {
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

    function delete_image($id, $update)
    {
        
        $this->db->where('image_id', $id);
        $this->db->update('banner_images', $update);

        return $this->db->affected_rows();
    }

    function _delete($col, $val) {
            
        $update['public']            = -1;
        //$update['updated_date']      = date('Y-m-d H:i:s');
        $update['user_id']           = $this->session->userdata('user_id');

        $table      = 'banner_images';
        $this->db->where($col, $val);
        //$res        = $this->db->delete($table);
        $res        = $this->db->update($table,$update);
        $error      = $res ? 0 : 1;
        $message    = $res ? 'Record Successfully deleted' : 'Unable to delete record, please try again';
        $res        = ['error' => $error, 'message' => $message];
        
        return $res;
    }

    function get_banners_data($conditions=[], $limit='', $offset=0, $allcount='')
    {
        $order          = '';
        //$where          = '1=1 AND b.institute_id ='.$this->session->userdata['sess_institute_id'];
        $where          = '1=1';
        $like_sql       = '';
        $limit_offset   = '';

        // Like
        if(isset($_GET['search']) && !empty($_GET['search']) && $_GET['search'] != 'undefined')
        {
            $term       = $_GET['search'];
            $like_sql   = ' AND
                            (
                                b.banner_text LIKE "%'.$term.'%" ESCAPE "!"
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

        // default where condition expect admin
        if(!empty($_GET['custom_search']['banner_institute']))
        {
            $banner_institute   = isset($_GET['custom_search']['banner_institute']) ? $_GET['custom_search']['banner_institute'] : [];

            $bi_find_or    = '(';
            $bi_space_or   = '';
            foreach ($banner_institute as $bikey => $bivalue) {
                if($bikey > 0)
                {
                    $bi_space_or = ' OR ';
                }
                $bi_find_or .= $bi_space_or.'FIND_IN_SET('.$bivalue.', b.institute_id)';
            }
            $bi_find_or  .= ')';
            $where      .= ' AND '.$bi_find_or;
        }
        else
        {
            if($this->session->userdata('user_id') == 1 && $this->session->userdata['sess_institute_id'] != 50)
            {
               $where .= ' AND FIND_IN_SET('.$this->session->userdata['sess_institute_id'].',b.institute_id)'; 
            }

            if($this->session->userdata('user_id') != 1 )
            {
                $where .= ' AND FIND_IN_SET('.$this->session->userdata['sess_institute_id'].',b.institute_id)';
            }
        }
        
        
        // Custom Filter
        if(isset($_GET['custom_search']) && !empty($_GET['custom_search']))
        {
            $status             = isset($_GET['custom_search']['status']) ? $_GET['custom_search']['status'] : '';
            $valid_upto         = isset($_GET['custom_search']['valid_upto']) ? $_GET['custom_search']['valid_upto'] : '';      
            $banner_institute   = isset($_GET['custom_search']['banner_institute']) ? $_GET['custom_search']['banner_institute'] : [];
            

            if(!empty($valid_upto))
            {
                $where      .= ' AND b.valid_upto <= "'.$valid_upto.'"';
            }
            
            if($status != '')
            {
                $where  .= ' AND b.public IN ('.implode(',', $status).')';
            }  

            // if(!empty($banner_institute))
            // {
            //     $bi_find_or    = '(';
            //     $bi_space_or   = '';
            //     foreach ($banner_institute as $bikey => $bivalue) {
            //         if($bikey > 0)
            //         {
            //             $bi_space_or = ' OR ';
            //         }
            //         $bi_find_or .= $bi_space_or.'FIND_IN_SET('.$bivalue.', b.institute_id)';
            //     }
            //     $bi_find_or  .= ')';
            //     $where      .= ' AND '.$bi_find_or;
            // }    
        }

        // Order
        if(isset($_GET['order']) && !empty($_GET['order']) && isset($_GET['sort']) && !empty($_GET['sort']))
        {
            /*if($_GET['sort'] == 'created_on')
            {
                $sort_by = 'u.created_on';
            }*/
            if($_GET['sort'] == 'banner_text')
            {
                $sort_by = 'b.banner_text';
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
            $order       = 'ORDER BY b.image_id DESC';
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
                    SELECT DISTINCT(b.image_id), b.banner_text, b.image, b.valid_upto, b.public, b.row_order FROM banner_images b
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

    function get_banner_details($id='')
    {
        $this->db->select('*');
        $this->db->from('banner_images');
        $this->db->where('image_id', $id);
        $this->db->where('public !=', '-1');
        $query = $this->db->get();
        return $query->row_array();
    }

    function change_banner_status($id='', $status)
    {
        // if($status == -1)
        // {
        //     $this->db->where('image_id', $id);
        //     $this->db->delete('banner_images'); 

        //     return 1;
        // }
        // else
        // {
            $update['public']           = $status;
            $update['user_id']          = $this->session->userdata('user_id');
            //$update['modified_on']      = date('Y-m-d H:i:s');
            //$update['modified_by']      = $this->session->userdata('user_id');

            $this->db->where('image_id', $id);
            $this->db->update('banner_images', $update);

            return $this->db->affected_rows();
        //}
        
    }

    function get_all_institute_list()
    {
        $this->db->select("INST_ID,INST_NAME");
        $this->db->from('edu_institute_dir');
        $this->db->where('ENABLE_DISABLE','E');
        $this->db->order_by('INST_NAME','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
}