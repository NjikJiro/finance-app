<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'form_validation']);
        // Proteksi: Hanya ID 1 (Renjiro) yang bisa masuk
        if ($this->session->userdata('user_id') != 1) {
            redirect('dashboard');
        }
    }

    public function index()
    {
        $data['users'] = $this->db->get('users')->result();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('users/index', $data);
        $this->load->view('templates/footer');
    }

    public function simpan_edit()
    {
        $id = $this->input->post('id');
        $nama = $this->input->post('nama'); // Tambahan field Nama
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $data = [
            'nama'     => $nama,
            'username' => $username
        ];

        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->db->where('id', $id);
        if ($this->db->update('users', $data)) {
            $this->session->set_flashdata('success', 'Data user berhasil diperbarui!');
        }
        redirect('users');
    }

    public function hapus($id)
    {
        // Cegah admin menghapus dirinya sendiri
        if ($id == 1) {
            $this->session->set_flashdata('error', 'Admin utama tidak bisa dihapus!');
            redirect('users');
        }

        $this->db->where('id', $id);
        if ($this->db->delete('users')) {
            $this->session->set_flashdata('success', 'User berhasil dihapus.');
        }
        redirect('users');
    }

    public function tambah()
    {
        $nama = $this->input->post('nama');
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // Cek apakah username sudah ada
        $cek = $this->db->get_where('users', ['username' => $username])->row();
        if ($cek) {
            $this->session->set_flashdata('error', 'Username sudah digunakan!');
            redirect('users');
        }

        $data = [
            'nama'       => $nama,
            'username'   => $username,
            'password'   => password_hash($password, PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->db->insert('users', $data)) {
            $this->session->set_flashdata('success', 'User baru berhasil ditambahkan!');
        }
        redirect('users');
    }

    // Tambahkan di dalam class Users
    public function toggle_maintenance()
    {
        $current_status = $this->db->get_where('settings', ['key' => 'maintenance_mode'])->row()->value;
        $new_status = ($current_status == 'on') ? 'off' : 'on';

        $this->db->where('key', 'maintenance_mode');
        $this->db->update('settings', ['value' => $new_status]);

        redirect('dashboard');
    }
}
