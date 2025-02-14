<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Email_lib
	{
		private $ci;
		private $senderName;
		private $senderEmail;
		private $source;

		public function __construct() {
	        $this->ci 				= get_instance();
	        $this->senderName 		= 'Somaiya Vidyavihar';
	        $this->senderEmail 		= 'noreply@somaiya.edu';
	        $this->source 			= 'Somaiya Vidyavihar';
	        
	    }

	    function send($email_data)
	    {
	    	return $this->ci->api_somaiya_edu->send_email(json_encode([
	                                                    'EmailList' => [
	                                                        [
	                                                            'Subject'       => $email_data['subject'],
	                                                            'emailBody'     => $email_data['message'],
	                                                            'emailAddress'  => $email_data['to'],
	                                                            'fileName'      => isset($email_data['attachment']) ? $email_data['attachment'] : '',
	                                                            'SenderName'    => $this->senderName,
	                                                            'SenderEmail'   => $this->senderEmail,
	                                                            'replyTo'       => isset($email_data['replyTo']) ? $email_data['replyTo'] : '',
	                                                            'cc'       		=> isset($email_data['cc']) ? $email_data['cc'] : '',
	                                                        ]
	                                                    ],
	                                                    'InstantFlag'   => isset($email_data['instant_flag']) ? $email_data['instant_flag'] : 'Y',
	                                                    'Source'        => $this->source,
	                                                ]));
	        /*$this->ci->load->config('email');
	        $this->ci->load->library('email');
	        $this->ci->email->clear();
	        $this->ci->email->from('noreply@somaiya.edu', 'K.J. Somaiya Hospital & Research Center');
	        $this->ci->email->to($email_data['to']);
	        $this->ci->email->subject($email_data['subject']);
	        $this->ci->email->message($email_data['message']);

	        if($this->ci->email->send())
	        {
            	$response = ['error' => 0, 'message' => 'Email sent'];
	        }
	        else
	        {
	            // show_error($this->ci->email->print_debugger());
	            $response = ['error' => 1, 'message' => 'Unable to send an email'];
	        }
	    	return $response;*/
	    }
	}