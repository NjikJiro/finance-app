<?php
class Kategori extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'form_validation']);

        if (!$this->session->userdata('user_id')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');

        $this->db->order_by('tipe', 'ASC');
        $data['kategori'] = $this->db
            ->get_where('kategori', ['user_id' => $user_id])
            ->result();
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('kategori/index', $data);
        $this->load->view('templates/footer');
    }

    public function simpan()
    {

        $nama_kategori = $this->input->post('nama_kategori');
        $tipe          = $this->input->post('tipe');
        $user_id       = $this->session->userdata('user_id');

        $data = [
            'user_id'       => $user_id,
            'nama_kategori' => $nama_kategori,
            'tipe'          => $tipe
        ];

        $simpan = $this->db->insert('kategori', $data);
        if ($simpan) {
            // Set pesan sukses
            $this->session->set_flashdata('success', 'Kategori <strong>' . htmlspecialchars($nama_kategori) . '</strong> berhasil disimpan!');
        } else {
            // Set pesan gagal jika terjadi error database
            $this->session->set_flashdata('error', 'Gagal menyimpan kategori.');
        }


        redirect('kategori');
    }

    public function hapus($id)
    {
        $user_id = $this->session->userdata('user_id');

        // Pastikan kategori yang dihapus milik user yang sedang login
        $this->db->where('id', $id);
        $this->db->where('user_id', $user_id);
        $hapus = $this->db->delete('kategori');

        if ($hapus) {
            $this->session->set_flashdata('success', 'Kategori berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus kategori.');
        }

        redirect('kategori');
    }
}
