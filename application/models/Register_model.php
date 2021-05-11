<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register_model extends CI_Model {

	public $variable;

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	//Add account data to account table
    public function insertAccount($name, $email, $password, $accountType, $status) {
        $object = array('Name' => $name, 'Email' => $email, 'Password' => $password, 'AccountType' => $accountType, 'Status' => $status);
        $this->db->insert('account', $object);
    }

    //Set token
    public function insertToken($email, $action, $value, $time) {
        $query = $this->db->select('AccountID')->from('account')->where(array('Email' => $email))->get()->result()[0];
        foreach ($query as $key) {
            $accountID = $key;
        }
        $object = array('AccountID' => $accountID, 'action' => $action, 'value' => $value, 'time' => $time);
        $this->db->insert('token', $object);
    }

    //Check token of verify email action
    public function verify_email($value) {
        $query = $this->db->get('token');
        if($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                if($row->Value == $value && $row->Action == 1) {
                    $id = $row->AccountID;
                    $time = $row->Time;
                } else {
                    return false;
                }
            }
            $now = date('Y-m-d H:i:s');
            $deadline = strtotime($now) - strtotime($time);
            //check time to live of varify link is 10 minute
            if($deadline <= 600) {
                $this->db->where('accountID', $id);
                $this->db->where('status', '0');
                $query2 = $this->db->get('account');
                //Update status: 0->1 when click in verify link
                if($query2->num_rows() > 0) {
                    $data = array('status'  => '1');
                    $this->db->where('accountID', $id);
                    $this->db->update('account', $data);
                    return true;
                } 
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function sendEmail($email, $subject, $message) {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => '**your email**',
            'smtp_pass' => '**your password**',
            'charset' => 'utf-8',
            'mailtype' => 'html',
            'wordwrap' => TRUE,
        );
        $this->load->library('email', $config);
        $this->email->from('**your email**', 'Admin');
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->set_newline("\r\n");
        $this->email->send();
    }

}

/* End of file Register_model.php */
/* Location: ./application/models/Register_model.php */