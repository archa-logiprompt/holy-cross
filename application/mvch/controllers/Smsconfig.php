<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Smsconfig extends Admin_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        if (!$this->rbac->hasPrivilege('sms_setting', 'can_edit')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'System Settings');
        $this->session->set_userdata('sub_menu', 'smsconfig/index');
        $data['title'] = 'SMS Config List';
        $sms_result = $this->smsconfig_model->get();
        $data['statuslist'] = $this->customlib->getStatus();
        $data['smslist'] = $sms_result;
        $this->load->view('layout/header', $data);
        $this->load->view('smsconfig/smsList', $data);
        $this->load->view('layout/footer', $data);
    }
	
	
	public function a4add() {

        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('a4add_user', 'Username', 'required');
        $this->form_validation->set_rules('a4add_password', 'Password', 'required');
        $this->form_validation->set_rules('a4add_sender_id', 'Sender ID', 'required');
        if ($this->form_validation->run()) {
              
			  $admin=$this->session->userdata('admin');
            $data = array(
			     'centre_id'=>$admin['centre_id'],
                'type' => 'a4add',
                'username' => $this->input->post('a4add_user'),
                'password' => $this->input->post('a4add_password'),
                'api_id' => $this->input->post('a4add_sender_id'),
                'is_active' => $this->input->post('a4add_status'),
            );
            $this->smsconfig_model->add($data);
            echo json_encode(array('st' => 0, 'msg' => "Record updated successfully"));
        } else {

            $data = array(
                'a4add_user' => form_error('a4add_user'),
                'a4add_password' => form_error('a4add_password'),
                'a4add_sender_id' => form_error('a4add_sender_id')
            );

            echo json_encode(array('st' => 1, 'msg' => $data));
        }
    }

    public function clickatell() {

        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('clickatell_user', 'Username', 'required');
        $this->form_validation->set_rules('clickatell_password', 'Password', 'required');
        $this->form_validation->set_rules('clickatell_api_id', 'Api ID', 'required');
        if ($this->form_validation->run()) {
            $admin=$this->session->userdata('admin');
            $data = array(
			    'centre_id'=>$admin['centre_id'],
                'type' => 'clickatell',
                'username' => $this->input->post('clickatell_user'),
                'password' => $this->input->post('clickatell_password'),
                'api_id' => $this->input->post('clickatell_api_id'),
                'is_active' => $this->input->post('clickatell_status'),
            );
            $this->smsconfig_model->add($data);
            echo json_encode(array('st' => 0, 'msg' => "Record updated successfully"));
        } else {

            $data = array(
                'clickatell_user' => form_error('clickatell_user'),
                'clickatell_password' => form_error('clickatell_password'),
                'clickatell_api_id' => form_error('clickatell_api_id')
            );

            echo json_encode(array('st' => 1, 'msg' => $data));
        }
    }

    public function twilio() {

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('twilio_account_sid', 'Account ID', 'required');
        $this->form_validation->set_rules('twilio_auth_token', 'Auth Token', 'required');
        $this->form_validation->set_rules('twilio_sender_phone_number', 'Phone Number', 'required');

        if ($this->form_validation->run()) {
             $admin=$this->session->userdata('admin');
            $data = array(
			'centre_id'=>$admin['centre_id'],
                'type' => 'twilio',
                'api_id' => $this->input->post('twilio_account_sid'),
                'password' => $this->input->post('twilio_auth_token'),
                'contact' => $this->input->post('twilio_sender_phone_number'),
                'is_active' => $this->input->post('twilio_status')
            );
            $this->smsconfig_model->add($data);
            echo json_encode(array('st' => 0, 'msg' => "Record updated successfully"));
        } else {

            $data = array(
                'twilio_account_sid' => form_error('twilio_account_sid'),
                'twilio_auth_token' => form_error('twilio_auth_token'),
                'twilio_sender_phone_number' => form_error('twilio_sender_phone_number')
            );

            echo json_encode(array('st' => 1, 'msg' => $data));
        }
    }

    public function custom() {

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('name', 'Name', 'required');


        if ($this->form_validation->run()) {
           $admin=$this->session->userdata('admin');

            $data = array(
			'centre_id'=>$admin['centre_id'],
                'type' => 'custom',
                'name' => $this->input->post('name'),
                'is_active' => $this->input->post('custom_status')
            );
            $this->smsconfig_model->add($data);
            echo json_encode(array('st' => 0, 'msg' => "Record updated successfully"));
        } else {

            $data = array(
                'name' => form_error('name'),
            );

            echo json_encode(array('st' => 1, 'msg' => $data));
        }
    }

    public function msgnineone() {

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('authkey', 'Auth Key', 'required');
        $this->form_validation->set_rules('senderid', 'Sender ID', 'required');



        if ($this->form_validation->run()) {
            $admin=$this->session->userdata('admin');
            $data = array(
			'centre_id'=>$admin['centre_id'],
                'type' => 'msg_nineone',
                'authkey' => $this->input->post('authkey'),
                'senderid' => $this->input->post('senderid'),
                'is_active' => $this->input->post('msg_nineone_status')
            );
            $this->smsconfig_model->add($data);
            echo json_encode(array('st' => 0, 'msg' => "Record updated successfully"));
        } else {

            $data = array(
                'authkey' => form_error('authkey'),
                'senderid' => form_error('senderid')
            );

            echo json_encode(array('st' => 1, 'msg' => $data));
        }
    }

    public function smscountry() {

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('smscountry', 'Username', 'required');
        $this->form_validation->set_rules('smscountrypassword', 'Password', 'required');
        $this->form_validation->set_rules('smscountrysenderid', 'Sender ID', 'required');



        if ($this->form_validation->run()) {
            $admin=$this->session->userdata('admin');
            $data = array(
			   'centre_id'=>$admin['centre_id'],
                'type' => 'smscountry',
                'username' => $this->input->post('smscountry'),
                'password' => $this->input->post('smscountrypassword'),
                'senderid' => $this->input->post('smscountrysenderid'),
                'is_active' => $this->input->post('smscountry_status')
            );
            $this->smsconfig_model->add($data);
            echo json_encode(array('st' => 0, 'msg' => "Record updated successfully"));
        } else {

            $data = array(
                'smscountry' => form_error('smscountry'),
                'smscountrypassword' => form_error('smscountrypassword'),
                'smscountrysenderid' => form_error('smscountrysenderid'),
            );

            echo json_encode(array('st' => 1, 'msg' => $data));
        }
    }

    public function textlocal() {

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('text_local', 'Username', 'required');
        $this->form_validation->set_rules('text_localpassword', 'Password', 'required');
        $this->form_validation->set_rules('text_localsenderid', 'Sender ID', 'required');


        if ($this->form_validation->run()) {
           $admin=$this->session->userdata('admin');
            $data = array(
			'centre_id'=>$admin['centre_id'],
                'type' => 'text_local',
                'username' => $this->input->post('text_local'),
                'password' => $this->input->post('text_localpassword'),
                'senderid' => $this->input->post('text_localsenderid'),
                'is_active' => $this->input->post('text_local_status')
            );
            $this->smsconfig_model->add($data);
            echo json_encode(array('st' => 0, 'msg' => "Record updated successfully"));
        } else {

            $data = array(
                'text_local' => form_error('text_local'),
                'text_localpassword' => form_error('text_localpassword'),
                'text_localsenderid' => form_error('text_localsenderid'),
            );

            echo json_encode(array('st' => 1, 'msg' => $data));
        }
    }

}

?>