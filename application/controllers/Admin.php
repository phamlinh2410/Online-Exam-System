<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Admin_model');
        $this->load->model('Login_model');
    }

    public function index() {
        if($this->session->userdata('email')) {
            $email = $this->session->userdata('email');
            if($this->Login_model->getAccountType($email) == 0){
                $data['questions'] = $this->Admin_model->getQuestion();
                $this->load->view('dashboard_view', $data);
            } else {
                redirect('Login','refresh');
            }        
        } else {
            redirect('Login','refresh');
        }
    }

    function dashboard() {
        $data['questions'] = $this->Admin_model->getQuestion();
        $this->load->view('dashboard_view', $data);
    }
    
    function addQuestion() {
        $this->form_validation->set_rules('question_content', 'Question Content', 'required');
        if ($this->form_validation->run()) {
            $questionData = array(
                'CategoryID' => $this->input->post('category'),
                'FormatID' => $this->input->post('format'),
                'QuestionContent' => $this->input->post('question_content'),
                'Status' => '1',
            );
            $id = $this->Admin_model->insertQuestion($questionData);
            
            if($id > 0) {
                $skills = $this->Admin_model->getSkill1();
                foreach($skills as $skill) {
                    $skillPercentData = array(
                        'QuestionID' => $id,
                        'SkillID' => $skill->SkillID,
                        'Percent' => $this->input->post('skill_'.$skill->SkillID),
                        'Status' => '1'
                    );
                    $this->Admin_model->insertSkillPercent($skillPercentData);
                }
                $checks = $this->input->post('checks');
                $answerIDs = $this->input->post('answerIDs');
                foreach ($answerIDs as $answerID) {
                    $trueFalse = 1;
                    if ($this->checkTrueOrFalse($checks, $answerID)) {
                        $trueFalse = 2;
                    }
                    $officalAnswerData = array(
                        'QuestionID' => $id,
                        'AnswerID' => $answerID,
                        'AnswerContent' => $this->input->post('answer_'.$answerID),
                        'TorF' => $trueFalse,
                        'Status' => '1'
                    );
                    $this->Admin_model->insertOfficalAnswer($officalAnswerData);
                }
                redirect('Admin/dashboard');
            }
        } else {
            $data['categories'] = $this->Admin_model->getCategory1();
            $data['formats'] = $this->Admin_model->getFormat1();
            $data['skills'] = $this->Admin_model->getSkill1();
            $this->load->view('add_question_view', $data);
        }
    }

    function checkTrueOrFalse($checks, $answerID) {
        foreach ($checks as $check) {
            if($check == $answerID) {
                return true;
            }
        }
        return false;
    }

    function addCategory() {
        $this->form_validation->set_rules('category_name', 'Category Name', 'required');
        if ($this->form_validation->run()) {
            $categoryData = array(
                'CategoryName' => $this->input->post('category_name'),
                'Status' => 1 
            );
            $this->Admin_model->insertCategory($categoryData);
            redirect('Admin/addCategory');
        } else {
            $data['categories'] = $this->Admin_model->getCategory();
            $this->load->view('add_category_view', $data);
        }
    }

    function addSkill() {
        $this->form_validation->set_rules('skill_name', 'Skill Name', 'required');
        if ($this->form_validation->run()) {
            $skillData = array(
                'SkillName' => $this->input->post('skill_name'),
                'Status' => 1 
            );
            $this->Admin_model->insertSkill($skillData);
            redirect('Admin/addSkill');
        } else {
            $data['skills'] = $this->Admin_model->getSkill();
            $this->load->view('add_skill_view', $data);
        }
    }

    function viewAnswer($QuestionID) {    
        $data['answers'] = $this->Admin_model->getAnswer($QuestionID);
        $this->load->view('answer_view', $data);
    }

    function editQuestion($QuestionID) {
        $data['id'] = $QuestionID; 
        $this->load->view('edit_question_view', $data);
    }

    function createExam(){
        $this->form_validation->set_rules('duration', 'Duration', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('numberOfQuestions', 'Number Of Question', 'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('examName', 'Exam Name', 'required');
        if ($this->form_validation->run()) {
            $examID = random_int(0, 999999999);
            $categoryID = $this->input->post('category');
            $duration = $this->input->post('duration');
            $numberOfQuestions = $this->input->post('numberOfQuestions');
            $examName = $this->input->post('examName');
            $threshold = $this->Admin_model->countQuestionOfCategory($categoryID);
            if($numberOfQuestions <= $threshold) {
                $this->Admin_model->createExam($examID, $categoryID, $numberOfQuestions);
                $this->Admin_model->insertExamInfor($examID, $categoryID, $examName, $duration, $numberOfQuestions);
            } else {
                $this->session->set_flashdata('message', 'You must enter total of questions smaller than it in category ('.$threshold.')!');
            }
            redirect('Admin/createExam','refresh');
        } else {
            $data['categories'] = $this->Admin_model->getCategory1();
            $data['examInfor'] = $this->Admin_model->getExamInfor();
            $this->load->view('create_exam_view', $data);
        }
    }

    function viewQuestionsOfExam($examID) {
        $data['questions'] = $this->Admin_model->getQuestionsOfExam($examID);
        $this->load->view('questions_of_exam_view', $data);
    }
    

    function deleteQuestion($questionID) {
        $this->Admin_model->deleteQuestion($questionID);
        redirect('Admin/dashboard','refresh');
    }

    function deleteExam($examID) {
        $this->Admin_model->deleteExam($examID);
        redirect('Admin/createExam','refresh');
    }

}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */