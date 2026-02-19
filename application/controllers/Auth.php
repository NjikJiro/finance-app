<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    public function login()
    {
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }

        $this->load->view('auth/login');
    }

    public function process()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->db->get_where('users', ['username' => $username])->row();

        if ($user && password_verify($password, $user->password)) {

            $data = [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'logged_in' => true
            ];

            $this->session->set_userdata($data);
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Username atau password salah');
            redirect('auth/login');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
