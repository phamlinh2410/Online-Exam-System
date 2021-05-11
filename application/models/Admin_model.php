<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public $variable;

    public function __construct() {
        parent::__construct();
    }

    function getCategory() {
        $this->db->select('*');
        $this->db->from('category');
        $this->db->order_by('category.CategoryID', 'DESC');
        $categories = $this->db->get();
        return $categories->result(); 
    }

    function getFormat() {
        $this->db->select('*');
        $this->db->from('format');
        $formats = $this->db->get();
        return $formats->result(); 
    }

    function getSkill() {
        $this->db->select('*');
        $this->db->from('skill');
        $this->db->order_by('skill.SkillID', 'DESC');
        $skills = $this->db->get();
        return $skills->result(); 
    }

    function getCategory1() {
        $this->db->select('*');
        $this->db->from('category');
        $this->db->where('category.Status', '1');
        $this->db->order_by('category.CategoryID', 'ASC');
        $categories = $this->db->get();
        return $categories->result(); 
    }

    function getFormat1() {
        $this->db->select('*');
        $this->db->from('format');
        $this->db->where('format.Status', '1');
        $this->db->order_by('format.FormatID', 'ASC');
        $formats = $this->db->get();
        return $formats->result(); 
    }

    function getSkill1() {
        $this->db->select('*');
        $this->db->from('skill');
        $this->db->where('skill.Status', '1');
        $this->db->order_by('skill.SkillID', 'ASC');
        $skills = $this->db->get();
        return $skills->result(); 
    }

    function getQuestion() {
        $this->db->select('question.QuestionID, category.CategoryName, format.FormatName, question.QuestionContent, question.Status');
        $this->db->from('question');
        $this->db->join('category', 'category.CategoryID = question.CategoryID');
        $this->db->join('format', 'format.FormatID = question.FormatID');
        $this->db->where('question.Status', 1);
        $this->db->order_by('question.QuestionID', 'DESC');
        $questions = $this->db->get();
        return $questions->result();
    }

    function getFormatQuestion($QuestionID) {
        $this->db->select('*');
        $this->db->from('question');
        $this->db->where('question.QuestionID', $QuestionID);
        return $this->db->get()->row()->FormatID;
    }

    function getAnswer($QuestionID) {
        $this->db->select('*');
        $this->db->from('officalanswer');
        $this->db->where('officalanswer.QuestionID', $QuestionID);
        $answers = $this->db->get();
        return $answers->result();
    }

    function insertQuestion($data) {
        $this->db->insert('question', $data);
        return $this->db->insert_id();
    }

    function insertCategory($data) {
        $this->db->insert('category', $data);  
    }

    function insertSkill($data) {
        $this->db->insert('skill', $data);  
    }

    function insertSkillPercent($data) {
        $this->db->insert('skillpercent', $data);
    }

    function insertofficalAnswer($data) {
        $this->db->insert('officalanswer', $data);
    }

    function createExam($examID, $categoryID, $numberOfQuestions) {
        $exam = $this->db->select('*')->from('category c')->join('question q', 'c.CategoryID = q.CategoryID')->where(array('c.CategoryID' => $categoryID, 'q.Status' => 1))->order_by('q.QuestionID', 'RANDOM')->limit($numberOfQuestions)->get();
        if($exam->num_rows() > 0) {
            foreach ($exam->result() as $row) {
                $questionID = $row->QuestionID;
                $object = array('ExamID' => $examID, 'QuestionID' => $questionID);
                $this->db->insert('Exam', $object);
            }
        }
    }

    function insertExamInfor($examID ,$categoryID, $examName, $duration, $numberOfQuestions) {
        $timeCreated = date('Y-m-d H:i:s');
        $object = array('CandidateID' => 1, 'ExamID' => $examID,  'ExamName' => $examName, 'ExamForm' => $categoryID, 'Duration' => $duration, 'TotalQuestions' => $numberOfQuestions, 'Duration' => $duration, 'TimeCreated' => $timeCreated, 'Status' => 1);
        $this->db->insert('examinfor', $object);
    }

    function getExamInfor() {
        $query = $this->db->select('*')->from('examinfor')->join('category', 'examinfor.ExamForm = category.CategoryID')->where('examinfor.Status', 1)->order_by('examinfor.TimeCreated', 'DESC')->get();
        return $query->result();
    }

    function getQuestionsOfExam($examID) {
        $questions = $this->db->select('*')->from('question')->join('category', 'category.CategoryID = question.CategoryID')->join('format', 'format.FormatID = question.FormatID')->join('exam', 'exam.QuestionID = question.QuestionID')->where('ExamID', $examID)->get();
        return $questions->result();
    }

    function countQuestionOfCategory($categoryID) {
        $query = $this->db->select('*')->from('question')->where(array('CategoryID' => $categoryID, 'Status' => 1))->get()->result();
        return count($query);
    }

    function getCorrectAnswer($QuestionID) {
        $this->db->select('*');
        $this->db->from('officalanswer');
        $this->db->where('officalanswer.QuestionID', $QuestionID);
        $this->db->where('officalanswer.TorF', 2);
        return $this->db->get()->result();
    }

    function deleteQuestion($questionID) {
        $object = array('Status' => 0);
        $this->db->where('QuestionID', $questionID);
        $this->db->update('question', $object);
    }

    function deleteExam($examID) {
        $object = array('Status' => 0);
        $this->db->where('ExamID', $examID);
        $this->db->update('examinfor', $object);
    }
}

/* End of file Admin_model.php */
/* Location: ./application/models/Admin_model.php */