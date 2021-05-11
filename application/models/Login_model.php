<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

    public $variable;

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function checkEmailExist($email) {
        $result = $this->db->select('email')->from('account')->where(array('email' => $email))->get()->result();
        if(count($result) == 1) {
            return true;
        } else {
            return false;
        }
    }

    //Check is account exist
    public function checkAccountExist($email, $password) {
        $result = $this->db->select('email')->from('account')->where(array('email' => $email, 'password' => $password))->get()->result();
        return count($result);
    }

    public function getID($email) {
        $query = $this->db->get('account');
        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                if($row->Email == $email) {
                    $id = $row->AccountID;
                }
            }
        }
        return $id;
    }

    //Get status from account table
    public function getStatus($email) {
        $query = $this->db->select('status')->from('account')->where(array('email' => $email))->get()->result()[0];
        foreach ($query as $key) {
            $status = $key;
        }
        return $status;
    }

    public function getAccountType($email) {
        $query = $this->db->select('AccountType')->from('account')->where(array('email' => $email))->get()->result()[0];
        foreach ($query as $key) {
            $accountType = $key;
        }
        return $accountType;
    }

    //update value and time to Token table
    public function updateToken($email, $value1, $time1) {
        $query = $this->db->get('account');
        if($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                if($row->Email == $email) {
                    $id = $row->AccountID;
                }
            }
            $data = array(
                'value' => $value1,
                'time' => $time1
            );
            $this->db->where('accountID', $id);
            $this->db->update('token', $data);
        }
    }

    //Delete token
    public function deleteToken($value) {
        $this->db->where('value', $value);
        $this->db->delete('token');
    }

    public function checkTokenExist($email) {
        $id = $this->getID($email);
        $query = $this->db->get('token');
        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                if($row->AccountID == $id && $row->Action == '1') {
                    return true;
                }
            }
        } else {
            return false;
        }
    }

    //Check token of forgot password action
    public function comfirmPassword($value) {
        $query = $this->db->get('token');
        if($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                if($row->Value == $value && $row->Action == 2) {
                    $id = $row->AccountID;
                    $time = $row->Time;
                }
            }
            $now = date('Y-m-d H:i:s');
            $deadline = strtotime($now) - strtotime($time);
            //Check time to live of forgot password link is 10 minute
            if($deadline <= 600) {
                return true; 
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //Update new password
    public function updatePassword($value, $newPassword) {
        $query = $this->db->get('token');
        if($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                if($row->Value == $value) {
                    $id = $row->AccountID;
                }
            }
            $this->db->where('accountID', $id);
            $this->db->update('account', array('password' => $newPassword));
        }
    }

}

/* End of file Login_model.php */
/* Location: ./application/models/Login_model.php */