<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery_model extends CI_Model {
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }
 function view_data($abc){
        if($abc == 50) {
            $query=$this->db->query("SELECT *, inst.public as publish, ud.public as public
                                 FROM galleries ud 
                                 LEFT JOIN edu_institute_dir as inst
                                 ON ud.gallery_for = inst.INST_ID
                                 LEFT JOIN galleries_type as gal 
                                 ON ud.type_id = gal.id 
                                 ORDER BY ud.g_id DESC");
            return $query->result_array();
        } else {
            $query=$this->db->query("SELECT *, inst.public as publish, ud.public as public
                                 FROM galleries ud 
                                 LEFT JOIN edu_institute_dir as inst
                                 ON ud.gallery_for = inst.INST_ID
                                 LEFT JOIN galleries_type as gal 
                                 ON ud.type_id = gal.id 
                                 WHERE  ud.gallery_for IN ($abc)
                                 ORDER BY ud.g_id DESC");
            return $query->result_array();
        }
    }

    function get_galdata($id){
        $this->db->select('*');
        $this->db->from('galleries');
        $this->db->where('g_id', $id);
        $this->db->where('public !=', '-1');
    
        $query = $this->db->get();
        $return = $query->result_array();
        return count($return)!=0 ? $return[0] : [];

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
     function get_data_image($id){
        $query=$this->db->query("SELECT *
                                 FROM galleries ud 
                                 RIGHT JOIN photos as photo
                                 ON ud.g_id = photo.g_id 
                                 WHERE ud.g_id = $id");
        return $query->result_array();
    }
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
     function get_galtype()
    {
        $this->db->select("*");
        $this->db->from('galleries_type');
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        return $query->result_array();
    }


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

      if($insert_id)
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

     function update_upload_image($user_id,$inputdata,$images,$fileNamefeatured, $all_existing_image_array)
    {
        $this->db->where('g_id', $user_id);
        $update  = $this->db->update('galleries', $inputdata);

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

        if(!empty($all_existing_image_array))
        {
          foreach ($all_existing_image_array as $key1 => $value1) {
            
            $updatedata = array('image_name'=>$value1['image_name'],'image_description'=>$value1['image_description']);
            $this->db->where('id', $value1['image_id']);

            $update  = $this->db->update('photos', $updatedata);

          }
        }


      if($update)
        {
            $response['status']     = 'success';
         //   $response[$col]         = $val;
        }
        else
        {
            $response['status']     = 'error';
            $response['message']    = $this->db->_error_message();
        }
       return $response;

    }
}
?>