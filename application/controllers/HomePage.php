<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HomePage extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation', 'session');
        $this->load->model('HomePage_model');
        $this->load->model('Login_model');
        $this->load->model('Admin_model');
    }

    public function index() {
        if($this->session->userdata('email')) {
            $data['examInfor'] = $this->HomePage_model->getExamInfor();
            $this->load->view('user_view', $data);
        } else {
            redirect('Login','refresh');
        }
    }

    public function logout() {
        if($this->session->userdata('email')) {
            $this->session->unset_userdata('email');
        }
        redirect('Login','refresh');
    }

    public function changePassword() {
        $this->form_validation->set_rules('currentPassword', 'Current Password', 'trim|required|min_length[6]|max_length[18]');
        $this->form_validation->set_rules('newPassword', 'New Password', 'trim|required|min_length[6]|max_length[18]');
        $this->form_validation->set_rules('rePassword', 'Comfirm New Password', 'trim|required|matches[newPassword]');
        $email = $this->session->userdata('email');
        $data['accountType'] = $this->Login_model->getAccountType($email);
        if ($this->form_validation->run()) {
            $currentPassword = md5($this->input->post('currentPassword'));
            $newPassword = md5($this->input->post('newPassword'));
            if($this->HomePage_model->checkNewPassword($email, $currentPassword, $newPassword)) {
                $this->HomePage_model->updatePassword($email, $newPassword);
                $this->session->set_flashdata('message','Change Password Successful!');
            }
        }
        $this->load->view('changePassword_view', $data);
    }

    function viewExam() {
        $examID = $this->uri->segment(3);
        $data['questions'] = $this->HomePage_model->getQuestion($examID);
        $data['duration'] = $this->HomePage_model->getDuration($examID);
        $array = array(
            'examID' => $examID
        );
        
        $this->session->set_userdata( $array );
        $this->load->view('exam_view', $data);
    }

    function submitExam() {
        $count = 0;
        $questionIDs = $this->input->post('questionIDs');
        $examID = $this->session->userdata('examID');
        $email = $this->session->userdata('email');
        $time = date('Y-m-d H:i:s');
        $total = $this->HomePage_model->getNumberQUestionsOfExam($examID);
        foreach ($questionIDs as $questionID) {
            if ($this->Admin_model->getFormatQuestion($questionID) == 1) {
                foreach ($this->Admin_model->getCorrectAnswer($questionID) as $correctAnswer) {
                    if($correctAnswer->AnswerID == $this->input->post('question_'.$questionID)) {
                        $count++;
                    }
                }
            } 
            if ($this->Admin_model->getFormatQuestion($questionID) == 2) {
                $choosens = $this->input->post('question_'.$questionID);
                if(isset($choosens) && count($choosens) == count($this->Admin_model->getCorrectAnswer($questionID))) {
                    $temp = 0;
                    foreach ($this->Admin_model->getCorrectAnswer($questionID) as $correctAnswer) {
                        if($this->checkTrueOrFalse($choosens, $correctAnswer->AnswerID)) {
                            $temp++;
                        }
                    }
                    if($temp == count($this->Admin_model->getCorrectAnswer($questionID))) {
                        $count++;
                    }
                }
            }
        }
        $score = round(($count / $total) * 10, 2, PHP_ROUND_HALF_UP);
        if($this->HomePage_model->checkDoneTheExam($email, $examID)) {
            $times = $this->HomePage_model->getTimesDoTheExam($email, $examID) + 1;
        } else {
            $times = 1;
        }
        $this->HomePage_model->insertRecord($email, $examID, $times, $score, $time);
        if($this->session->userdata('examID')) {
            $this->session->unset_userdata('examID');
        }
        $this->session->set_flashdata('message', 'Correct Answers: '.$count."/".$total."<br>".'Your Score: '.$score."/10");
        redirect('HomePage/viewResult');
    }

    function checkTrueOrFalse($checks, $answerID) {
        foreach ($checks as $check) {
            if($check == $answerID) {
                return true;
            }
        }
        return false;
    }

    function viewResult() {
        $email = $this->session->userdata('email');
        $data['records'] = $this->HomePage_model->getResult($email);
        $this->load->view('result_view', $data);
    }

}

/* End of file HomePage.php */
/* Location: ./application/controllers/HomePage.php */