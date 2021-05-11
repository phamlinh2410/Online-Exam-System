<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HomePage_model extends CI_Model {

    public $variable;

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function checkNewPassword($email, $currentPassword, $newPassword) {
        $query = $this->db->select('*')->from('account')->where('Email', $email)->get();
        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                if($row->Password == $currentPassword) {
                    $password = $row->Password;
                    if($currentPassword != $newPassword) {
                        return true;
                    } else {
                        $this->session->set_flashdata('message','Please Enter New Password!');
                        return false;
                    }
                } else {
                    $this->session->set_flashdata('message','Current Password is wrong!');
                    return false;
                }
            }
        }
    }

    public function updatePassword($email, $newPassword) {
        $this->db->where('email', $email);
        $this->db->update('account', array('password' => $newPassword));
    }

    function getExamInfor() {
        $query = $this->db->select('*')->from('examinfor')->join('category', 'examinfor.ExamForm = category.CategoryID')->where('examinfor.Status', 1)->order_by('examinfor.TimeCreated', 'DESC')->get();
        return $query->result();
    }

    function getQuestionsOfExam($examID) {
        $query = $this->db->select('*')->from('exam')->where('ExamID', $examID);
        return $query->result();
    }

    function getQuestion($examID) {
        $questions = $this->db->select('*')->from('question')->join('exam', 'exam.QuestionID = question.QuestionID')->where('exam.ExamID', $examID)->order_by('exam.QuestionID', 'RANDOM')->get();
        return $questions->result();
    }

    function getAnswer($QuestionID) {
        $answers = $this->db->select('*')->from('officalanswer')->where('officalanswer.QuestionID', $QuestionID)->order_by('AnswerID', 'RANDOM')->get();
        return $answers->result();
    }

    function insertRecord($email, $examID, $times, $score, $time) {
        $query = $this->db->select('*')->from('account')->where('Email', $email)->get();
        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $candidateID = $row->AccountID;
            }
            $object = array('CandidateID' => $candidateID, 'ExamID' => $examID, 'Times' => $times, 'Score' => $score, 'Time' => $time);
            $this->db->insert('Record', $object);
        }
    }

    function getResult($email) {
        $query = $this->db->select('*')->from('account')->where('Email', $email)->get();
        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $candidateID = $row->AccountID;
            }
            $record = $this->db->select('*')->from('record')->join('examinfor', 'record.ExamID = examinfor.ExamID')->where('record.CandidateID', $candidateID)->order_by('record.Time', 'DESC')->get();
            return $record->result();
        }
    }

    function getTimesDoTheExam($email, $examID) {
        $query = $this->db->select('*')->from('account')->where('Email', $email)->get();
        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $candidateID = $row->AccountID;
            }
            $record = $this->db->select('*')->from('record')->where(array('CandidateID' => $candidateID, 'ExamID' => $examID))->get();
            if($record->num_rows() > 0) {
                $max = 1;
                foreach ($record->result() as $row) {
                    $times = $row->Times;
                    if($times > $max) {
                        $max = $times;
                    }
                }
                return $max;
            }
        }
    }

    function getDuration($examID) {
        $query = $this->db->select('*')->from('examinfor')->where('ExamID', $examID)->get();
        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $duration = $row->Duration;
            }
            return $duration;
        }
    }

    function checkDoneTheExam($email, $examID) {
        $query = $this->db->select('*')->from('account')->where('Email', $email)->get();
        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $candidateID = $row->AccountID;
            }
            $record = $this->db->select('*')->from('record')->where(array('CandidateID' => $candidateID, 'ExamID' => $examID))->get();
            if($record->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    function getNumberQUestionsOfExam($examID) {
        $query = $this->db->select('*')->from('examinfor')->where('ExamID', $examID)->get();
        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $count = $row->TotalQuestions;
            }
            return $count;
        }
    }

}

/* End of file HomePage_model.php */
/* Location: ./application/models/HomePage_model.php */