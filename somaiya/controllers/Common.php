<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Common extends Somaiya_Controller {

    public function __construct(){
        parent::__construct('frontend');
        $this->load->library('email');
        // $this->load->library("pagination");
        // $this->load->model('media-coverage');
        $this->load->library("Ajax_pagination");
        $this->perPage = 10;
    }

    public function events()
    {
    	$this->data['event_institute'] = $this->Somaiya_general_model->event_institute();
    	// echo "<pre>";print_r($this->data['event_institute']);exit();
        $this->data['event_type'] = $this->Somaiya_general_model->event_type();
        $this->data['audience_type'] = $this->Somaiya_general_model->audience_type();
        $this->data['event_location'] = $this->Somaiya_general_model->event_location();
    	$this->load->view('common/events', $this->data);
    }

    public function view_events()
    {
    	$this->load->view('common/view-events', $this->data);
    }
}