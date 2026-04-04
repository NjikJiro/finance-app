<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends MY_Controller
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

        $this->db->select('t.*, k.nama_kategori');
        $this->db->from('transaksi t');
        $this->db->join('kategori k', 'k.id = t.kategori_id', 'left');
        $this->db->where('t.user_id', $user_id);
        $this->db->order_by('t.tanggal', 'DESC');
        $this->db->order_by('t.id', 'DESC');

        $data['transaksi'] = $this->db->get()->result();

        $data['kategori'] = $this->db->where('user_id', $user_id)
            ->order_by('nama_kategori', 'ASC')
            ->get('kategori')
            ->result();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/index', $data);
        $this->load->view('templates/footer');
    }

    public function simpan()
    {
        $this->form_validation->set_rules('kategori_id', 'Kategori', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('sumber', 'Sumber Dana', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('transaksi');
        }

        $user_id     = $this->session->userdata('user_id');
        $kategori_id = $this->input->post('kategori_id');

        $kategori = $this->db->get_where('kategori', ['id' => $kategori_id, 'user_id' => $user_id])->row();

        $jumlah_raw = $this->input->post('jumlah');
        $jumlah_clean = str_replace('.', '', $jumlah_raw); // Hapus titik jika ada

        if ($kategori) {
            $data = [
                'user_id'     => $user_id,
                'kategori_id' => $kategori_id,
                'tipe'        => $kategori->tipe,
                'sumber'      => $this->input->post('sumber'),
                'jumlah'      => $jumlah_clean,
                'tanggal'     => $this->input->post('tanggal'),
                'keterangan'  => $this->input->post('keterangan')
            ];

            if ($this->db->insert('transaksi', $data)) {
                $this->session->set_flashdata('success', 'Transaksi <strong>' . htmlspecialchars($kategori->nama_kategori) . '</strong> berhasil dicatat!');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan ke database.');
            }
        } else {
            $this->session->set_flashdata('error', 'Kategori tidak ditemukan.');
        }

        redirect('transaksi');
    }

    public function proses_transfer()
    {
        $user_id = $this->session->userdata('user_id');
        $dari    = $this->input->post('dari_sumber');
        $ke      = $this->input->post('ke_sumber');
        $jumlah  = $this->input->post('jumlah');
        $tanggal = $this->input->post('tanggal');

        if ($dari == $ke) {
            $this->session->set_flashdata('error', 'Sumber asal dan tujuan tidak boleh sama.');
            redirect('transaksi');
        }

        $this->db->trans_start();

        // 1. Baris Pengurangan (Tipe 'transfer')
        $this->db->insert('transaksi', [
            'user_id'     => $user_id,
            'kategori_id' => 0,
            'tipe'        => 'transfer',
            'sumber'      => $dari,
            'jumlah'      => $jumlah,
            'tanggal'     => $tanggal,
            'keterangan'  => 'Transfer keluar ke ' . strtoupper($ke)
        ]);

        // 2. Baris Penambahan (Tipe 'transfer')
        $this->db->insert('transaksi', [
            'user_id'     => $user_id,
            'kategori_id' => 0,
            'tipe'        => 'transfer',
            'sumber'      => $ke,
            'jumlah'      => $jumlah,
            'tanggal'     => $tanggal,
            'keterangan'  => 'Transfer masuk dari ' . strtoupper($dari)
        ]);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Gagal memproses transfer.');
        } else {
            $this->session->set_flashdata('success', 'Transfer Rp ' . number_format($jumlah, 0, ',', '.') . ' berhasil!');
        }
        redirect('transaksi');
    }

    public function hapus($id)
    {
        $id = $this->db->escape_str($id);
        $user_id = $this->session->userdata('user_id');

        if ($this->db->delete('transaksi', ['id' => $id, 'user_id' => $user_id])) {
            $this->session->set_flashdata('success', 'Transaksi berhasil dihapus.');
        }
        redirect('transaksi');
    }
}
