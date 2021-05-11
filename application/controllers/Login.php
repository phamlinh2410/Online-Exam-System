<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('encryption');
        $this->load->model('Login_model');
        $this->load->model('Register_model');
    }

    //Login
    public function index() {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[18]');

        //check validation form
        if ($this->form_validation->run()) {
            $email = $this->input->post('email');
            $password = md5($this->input->post('password'));

            //check is account exist and activated
            if($this->Login_model->checkEmailExist($email)) {
                if($this->Login_model->getStatus($email) == 0) {
                    $this->reVerifyMail($email);
                    echo "Your account has not been activated. Check your email to active it!";
                } elseif ($this->Login_model->checkAccountExist($email, $password) == 1) {
                    $array = array(
                        'email' => $email,
                        'password' => $password
                    );

                    //set session
                    $this->session->set_userdata($array);
                    if($this->Login_model->getAccountType($email) == 1) {
                        redirect('Homepage','refresh');
                    } elseif($this->Login_model->getAccountType($email) == 0) {
                        redirect('Admin','refresh');
                    }
                } else {
                    $this->session->set_flashdata('message','Your password is wrong!');
                    $this->load->view('login_view');
                }
            } else {
                $this->session->set_flashdata('message','The account has not been created!');
                $this->load->view('login_view');
            }
            
        } else {
            $this->load->view('login_view');
        }
    }

    public function reVerifyMail($email) {
        $value1 = bin2hex(random_bytes(15));
        $time1 = date('Y-m-d H:i:s');
        $subject = "Please verify email for login";
        $message = "<p>Hi ".$email."</p>
            <p>This is email verification mail from Online Exam system. For complete registration process and login into system. First you want to verify you email by click this <a href='".base_url()."Register/verify_email/".$value1."'>link</a>.</p>
            <p>Once you click this link your email will be verified and you can login into system.</p>
            <p>Thanks,</p>";
        if($this->Login_model->checkTokenExist($email)) {
            $this->Login_model->updateToken($email, $value1, $time1);
        } else {
            $this->Register_model->insertToken($email, 1, $value1, $time1);
        }
        $this->Register_model->sendEmail($email, $subject, $message);
    }

    public function forgotPassword() {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        if ($this->form_validation->run()) {
            $email = $this->input->post('email');
            if($this->Login_model->checkEmailExist($email)) {
                $this->session->set_flashdata('message','Check your email to get link to reset your password!');
                $value = bin2hex(random_bytes(15));
                $time = date('Y-m-d H:i:s');
                $subject = "Link reset your password";
                $message = "<p>Hi ".$email."</p>
                    p>This is email from Online Exam system. For complete registration process and login into system. First you want to reset your password by click this <a href='".base_url()."Login/verifyPassword/".$value."'>link</a>.</p>
                    <p>Once you click this link you can reset your password.</p>
                    <p>Thanks,</p>";
                $this->Register_model->insertToken($email, 2, $value, $time);
                $this->Register_model->sendEmail($email, $subject, $message);
                echo "Check your email to reset your password!";
                $array = array(
                    'value' => $value
                );
                
                $this->session->set_userdata( $array );
            } else {
                $this->session->set_flashdata('message','Your account is not yet registered!');
                $this->load->view('forgotPassword_view');
            }
        } else {
            $this->load->view('forgotPassword_view');
        }
    }

    function verifyPassword() {
        if ($this->uri->segment(3)) {
            $value = $this->uri->segment(3);
            if ($this->Login_model->comfirmPassword($value)) {
                $this->load->view('resetPassword_view');
            } else {
                echo "<h1 align='center'>Invalid Link</h1>";
            }
        }
    }

    public function resetPassword() {
        $value = $this->session->userdata('value');
        $this->form_validation->set_rules('newPassword', 'New Password', 'trim|required|min_length[6]|max_length[18]');
        $this->form_validation->set_rules('rePassword', 'Comfirm New Password', 'trim|required|matches[newPassword]');
        if ($this->form_validation->run()) {
            $newPassword = md5($this->input->post('newPassword'));
            $this->Login_model->updatePassword($value, $newPassword);
            $this->session->unset_userdata('value');
            $this->Login_model->deleteToken($value);
            $this->session->set_flashdata('message','Reset Password successful!');
            redirect('Login','refresh');
        } else {
            $this->load->view('resetPassword_view');
        }
    }

}

/* End of file Register.php */
/* Location: ./application/controllers/Register.php */