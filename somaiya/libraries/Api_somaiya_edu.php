<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Api_somaiya_edu
	{
		private $ci;
		private $api_username;
		private $api_client_id;

		public function __construct() {
	        $this->ci 				= get_instance();
	        $this->ci->load->model('api_somaiya_edu_model');
	        $this->api_username 	= $this->ci->config->item('api_credentials')['username'];
	        $this->api_client_id 	= $this->ci->config->item('api_credentials')['client_id'];
	        
	    }

	    function get_access_token()
	    {
	    	$response 						= ['error' => 1, 'message' => 'Unable to get API access token'];
	        $api_token_data 				= $this->ci->api_somaiya_edu_model->get_access_token($this->api_username, $this->api_client_id);
	        if(!empty($api_token_data))
	        {
	        	$access_token 				= $api_token_data['access_token'];
		        $expire_date 				= $api_token_data['expire_date'];
		        
		        $current_date 				= new DateTime();
		        $expire_date  				= new DateTime(date("Y-m-d", strtotime($expire_date)));

		        if($current_date > $expire_date)
		        {
		            $refresh_token 			= $api_token_data['refresh_token'];
		            $client_id 				= $api_token_data['client_id'];
		            $grant_type 			= "refresh_token";

		            $post_data 				= [
				            					'refresh_token' => $refresh_token,
				            					'client_id' 	=> $client_id,
				            					'grant_type' 	=> 'refresh_token',
				            				];
		            $response       		= curl_post_data([
					                                            'url'       => $this->ci->config->item('api_uri')['refresh_token'],
					                                            'post_data' => http_build_query($post_data),
					                                            'header'    => [
		                                                                        'Content-Type: application/x-www-form-urlencoded',
		                                                                    ]
					                                        ]);

		            if(isset($response['result']->access_token) && !empty($response['result']->access_token))
		            {
		            	$token_data 		= (array)$response['result'];
		            	$access_token 		= $token_data['access_token'];

			            $update_token_data 	= [
			            						'access_token' 	=> $access_token,
			            						'expires_in' 	=> $token_data['expires_in'],
			            						'refresh_token' => $token_data['refresh_token'],
			            						'created_date' 	=> date('Y-m-d h:i:s',strtotime($token_data['.issued'])),
			            						'expire_date' 	=> date('Y-m-d h:i:s',strtotime($token_data['.expires']))
			            					];
    					$response 			= $this->ci->api_somaiya_edu_model->update_access_token($client_id, $update_token_data);

    					if($response['error'] == 0)
    					{
    						$response['access_token'] = $access_token;
    					}
		            }
		            else
		            {
		            	if(isset($response['result']->error) && !empty($response['result']->error))
		            	{
		            		$response 		= ['error' => 1, 'message' => 'Somaiya Edu API Error: '.$response['result']->error];
		            	}
		            }
		        }
		        else
		        {
		        	$response 				= ['error' => 0, 'message' => 'Success', 'access_token' => $access_token];
		        }
	        }
	        else
	        {
	            $response 					= ['error' => 1, 'message' => 'API token does not exists'];
	        }
	    	return $response;
	    }

	    function send_email($request)
	    {
	    	try
		    {
	            $response 					= $this->get_access_token();
	            if($response['error'] == 0)
	            {
	            	$response       		= curl_post_data([
					                                            'url'       => $this->ci->config->item('api_uri')['send_email'],
					                                            'post_data' => $request,
					                                            'header'    => [
		                                                                        'Content-Type: application/json',
		                                                                        'Authorization: Bearer '.$response['access_token']
		                                                                    ]
					                                        ]);
	            	if($response['error'] == 0)
	            	{
	            		if(isset($response['result']->status) && $response['result']->status == 'SUCCESS')
	            		{
	            			$response 		= ['error' => 0, 'message' => 'Email sent'];
	            		}
	            		else
	            		{
	            			$response 		= ['error' => 1, 'message' => 'Unable to send an Email'];
	            		}
	            	}
	            }
	            return $response;
            }
		    catch(Exception $e)
		    {
		        return ['error' => 1, 'message' => 'Exception Error : '.$e->getMessage()];
		    }
	    }
	}