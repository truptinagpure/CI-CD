<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api_somaiya_edu_model extends CI_Model
{
    private $api_table;
    function __construct()
    {
        parent::__construct();
        $this->api_table = 'api_somaiya_edu';
    }

    function get_access_token($username, $client_id)
    {
        $query  = $this->db->query('SELECT * from '.$this->api_table.' where username = "'.$username.'" AND client_id = "'.$client_id.'"');
        return $query->row_array();
    }

    function update_access_token($client_id, $update_token_data)
    {
        $update = $this->db->query('
                                    UPDATE `'.$this->api_table.'`
                                    SET `access_token` = "'.$update_token_data['access_token'].'", `expires_in` = "'.$update_token_data['expires_in'].'", `refresh_token` = "'.$update_token_data['refresh_token'].'", `created_date` = "'.$update_token_data['created_date'].'", `expire_date` = "'.$update_token_data['expire_date'].'"
                                    WHERE `client_id` = "'.$client_id.'"
                                ');

        /*$this->db->where('client_id', $client_id);
        $update = $this->db->update($this->api_table, $update_token_data);*/

        if($update)
        {
            return ['error' => 0, 'message' => 'API access token updated successfully'];
        }
        else
        {
            return ['error' => 1, 'message' => 'Unable to update API access token'];
        }
    }
}
