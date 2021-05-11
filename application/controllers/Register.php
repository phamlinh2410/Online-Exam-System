<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('encryption');
        $this->load->model('Login_model');
        $this->load->model('Register_model');
        $this->load->model('HomePage_model');
    }

    //Register
    public function index() {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[account.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[18]');
        $this->form_validation->set_rules('rePassword', 'Comfirm Password', 'trim|required|matches[password]');

        //get input
        if ($this->form_validation->run()) {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $password = md5($this->input->post('password'));
            $value = bin2hex(random_bytes(15));
            $time = date('Y-m-d H:i:s');
            $subject = "Please verify email for login";
            $message = "<p>Hi ".$name."</p>
                <p>This is email verification mail from Online Exam system. For complete registration process and login into system. First you want to verify you email by click this <a href='".base_url()."Register/verify_email/".$value."'>link</a>.</p>
                <p>Once you click this link your email will be verified and you can login into system.</p>
                <p>Thanks,</p>";

            $this->Register_model->insertAccount($name, $email, $password, 1, 0);
            $this->Register_model->insertToken($email, 1, $value, $time);
            $this->Register_model->sendEmail($email, $subject, $message);
            $this->session->set_flashdata('message','Your account has been created. Check your email to active it');
            // echo "Your account has been created. Check your email to active it!";
            redirect('Register','refresh');
        } else {
            $this->load->view('register_view');
        }
    }

    function verify_email() {
        if($this->uri->segment(3)) {
            $value = $this->uri->segment(3);
            if($this->Register_model->verify_email($value)) {
                echo '<h1 align="center">Your account has been successfully verified, now you can login! <a href="'.base_url().'Login">here</a></h1>';
            } else {
                echo "<h1 align='center'>Invalid Link</h1>";
            }
            $this->Login_model->deleteToken($value);
        }
        $this->Login_model->deleteToken($value);
    }
    
}

/* End of file Register.php */
/* Location: ./application/controllers/Register.php */