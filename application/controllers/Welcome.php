<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(['form_validation', 'session']);
        $this->load->model('user_model');
    }

    public function index() {
        $this->load->view('home');
    }

    public function registernow() {
        if($this->input->post()) {
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

            if($this->form_validation->run()) {
                $data = [
                    'username' => $this->input->post('username'),
                    'email'    => $this->input->post('email'),
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'status'   => 1
                ];

                $this->user_model->insertuser($data);
                $this->session->set_flashdata('success', 'Registration successful!');
                redirect(base_url('welcome/login'));
            } else {
                $this->session->set_flashdata('error', validation_errors());
                redirect(base_url('welcome/registernow'));
            }
        }
        $this->load->view('registration');
    }

    public function login() {
        $this->load->view('login');
    }

    public function loginnow() {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if($this->form_validation->run()) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->user_model->check_user($email);

            if($user && password_verify($password, $user->password)) {
                $session_data = [
                    'user_id'  => $user->id,
                    'username' => $user->username,
                    'email'    => $user->email
                ];
                $this->session->set_userdata('UserLoginSession', $session_data);
                redirect(base_url('welcome/dashboard'));
            } else {
                $this->session->set_flashdata('error', 'Invalid email or password');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
        }
        redirect(base_url('welcome/login'));
    }

    public function dashboard() {
        if(!$this->session->userdata('UserLoginSession')) {
            redirect(base_url('welcome/login'));
        }
        $this->load->view('dashboard');
    }

    public function logout() {
        $this->session->unset_userdata('UserLoginSession');
        $this->session->sess_destroy();
        redirect(base_url('welcome/login'));
    }
}