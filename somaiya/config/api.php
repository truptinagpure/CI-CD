<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$config['api_base_url'] 	= 'https://api.somaiya.edu/api/v1/';
	$config['api_credentials'] 	= [
									'username' 	=> 'WebsiteUser', //'Tester',
									'client_id' => 'zhwaQyzW', //'XA9D6uAG',
								];
	$config['api_uri'] 			= [
									'refresh_token' => str_replace('api/v1/', '', $config['api_base_url']) .'token',
									'send_email' 	=> $config['api_base_url'].'email/sendEmail',
								];