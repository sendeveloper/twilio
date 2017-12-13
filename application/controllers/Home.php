<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// require_once('./vendor/autoload.php');
// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 */
	private $server_email = "twilio@email.com";
	private $twilio_number = "twilio_number";

	private $twilio_live_sid = "LIVE";
	private $twilio_live_token = "LIVE";

	private $twilio_test_sid = "TEST";
	private $twilio_test_token = "TEST";

	private $twilio_current_sid = "";
	private $twilio_current_token = "";

	private $phoneCannotFindMessage = "Sorry, we don’t seem to have your phone number in our database.  Can you please submit your email?  In the next message, please submit your email address ONLY";
	private $emailAuthenticateMessage = "Thank you, you are now authenticated to submit tickets.  Please type in the body of your ticket only.";
	private $ticketSuccessMessage = "Your ticket has been received!  Someone will be in touch with you soon.  No need to text back, otherwise you’ll end up creating another ticket.  Thank you!";

	private $authenticateKey = "jfdrydhrk7437";

	function __construct()
    {
        // Call the Model constructor    
        parent::__construct();

        $this->setTwilioMode('test');
        // $this->setTwilioMode('live');
       	$this->load->model('phones');
       	$this->load->model('emails');
    }
	public function index()
	{
		$get = $this->input->get();
		if (isset($get['key']) && $get['key'] == $this->authenticateKey)
			$this->load->view('home/index');
		else
			$this->load->view('404.php');
	}
	public function postMessage() {
		$posts = $this->input->post();
		if (isset($posts['phone']) && isset($posts['msg']))
		{
			$phone = $posts['phone'];
			$msg = $posts['msg'];
			if ($this->phones->findPhoneNumber($phone))
			{
				$result = $this->sendSms($phone, $msg);
				if ($result['ret'] == true)
					$ret = array("res" => true, "msg" => "You have successfully sent");
				else
					$ret = array("res" => false, "msg" => $result['msg']);
			}
			else
			{
				$ret = array("res" => false, "msg" => $this->phoneCannotFindMessage);
			}
		}
		else{
			$ret = array("Access denied");
		}
		echo json_encode($ret);
	}
	public function postEmail() {
		$posts = $this->input->post();
		if (isset($posts['email']) && isset($posts['phone']))
		{
			$email = $posts['email'];
			$phone = $posts['phone'];
			$this->emails->addEmail($email, $phone);
			$ret = array("res" => true, "msg" => $this->emailAuthenticateMessage);
		}
		else{
			$ret = array("Access denied");
		}
		echo json_encode($ret);
	}
	public function postTicket() {
		$posts = $this->input->post();
		if (isset($posts['email']) && isset($posts['ticket']))
		{
			$email = $posts['email'];
			$ticket = $posts['ticket'];
			if ($this->emails->findEmail($email)){
				$this->sendEmail($email, $ticket);
				$ret = array("res" => true, "msg" => $this->ticketSuccessMessage);
			}else
				$ret = array("res" => false, "msg" => "Sorry, your email is not authenticated");
		}
		else{
			$ret = array("Access denied");
		}
		echo json_encode($ret);
	}
	private function sendSms($phone_number, $msg) {
		if ($this->twilio_current_sid != '' && $this->twilio_current_token != '')
		{
			$client = new Client($this->twilio_current_sid, $this->twilio_current_token);
			try {
				$client->account->messages->create(
					$phone_number,
					array(
						'from' => $this->twilio_number,
						// 'from' => '+15005550006',
						'body' => $msg
					)
				);
				return array('ret' => true, 'msg' => 'success');
			} catch (Exception $e) {
				$errMsg = $e->getMessage();
				log_message("debug", $errMsg);
				return array('ret' => false, 'msg' => $errMsg);
			}
		}
	}
	private function sendEmail($email, $ticket)
	{
		$subject = "$email has just sent a ticket";
        $message = "$ticket";

        $sending_info = array();
        $sending_info['to_email'] = $this->server_email;
        $sending_info['from_email'] = $email;
		$this->sendEmailNow($email, $subject, $message, $sending_info);	
	}
	private function sendEmailNow($email,$subject,$message,$sending_info){
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf8' . "\r\n";
		$headers .= 'To: ' . $sending_info['to_email'] . "\r\n";
		$headers .= 'From: ' . $sending_info['from_email'] . "\r\n";

        @mail($email, $subject, $message, $headers);
	}
	private function setTwilioMode($mode){
    	if ($mode == 'test')
    	{
    		$this->twilio_current_sid = $this->twilio_test_sid;
    		$this->twilio_current_token = $this->twilio_test_token;
    	}
    	else if ($mode == 'live')
    	{
    		$this->twilio_current_sid = $this->twilio_live_sid;
    		$this->twilio_current_token = $this->twilio_live_token;
    	}
    	else
    		return false;
    }
}
