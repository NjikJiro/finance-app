<?php
class Anggaran extends CI_Controller
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
        $bulan_ini = date('Y-m');

        // Ambil data anggaran bulan ini
        $this->db->select('a.*, k.nama_kategori');
        $this->db->from('anggaran a');
        $this->db->join('kategori k', 'k.id = a.kategori_id');
        $this->db->where(['a.user_id' => $user_id, 'a.bulan_tahun' => $bulan_ini]);
        $daftar_anggaran = $this->db->get()->result();

        // Hitung realisasi pengeluaran untuk setiap anggaran
        foreach ($daftar_anggaran as $ang) {
            $this->db->select_sum('jumlah');
            $this->db->where([
                'kategori_id' => $ang->kategori_id,
                'user_id' => $user_id,
                'DATE_FORMAT(tanggal, "%Y-%m") =' => $bulan_ini
            ]);
            $realisasi = $this->db->get('transaksi')->row();
            $ang->total_terpakai = $realisasi->jumlah ?? 0;
        }

        $data['daftar_anggaran'] = $daftar_anggaran;

        // Dropdown kategori khusus pengeluaran
        $data['kategori_pengeluaran'] = $this->db->get_where('kategori', [
            'user_id' => $user_id,
            'tipe' => 'pengeluaran'
        ])->result();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('anggaran/index', $data);
        $this->load->view('templates/footer');
    }

    public function simpan()
    {
        // 1. Validasi input sederhana
        $this->form_validation->set_rules('kategori_id', 'Kategori', 'required');
        $this->form_validation->set_rules('nominal_target', 'Nominal Target', 'required|numeric|greater_than[0]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Input tidak valid. Pastikan nominal berupa angka.');
            redirect('anggaran');
        }

        $user_id = $this->session->userdata('user_id');
        $kategori_id = $this->input->post('kategori_id');
        $nominal_target = $this->input->post('nominal_target');
        $bulan_tahun = date('Y-m'); // Format: 2026-02 (sesuai bulan berjalan)

        // 2. Cek apakah anggaran untuk kategori ini sudah pernah diatur bulan ini
        $cek_existing = $this->db->get_where('anggaran', [
            'user_id'     => $user_id,
            'kategori_id' => $kategori_id,
            'bulan_tahun' => $bulan_tahun
        ])->row();

        $data = [
            'user_id'        => $user_id,
            'kategori_id'    => $kategori_id,
            'nominal_target' => $nominal_target,
            'bulan_tahun'    => $bulan_tahun
        ];

        if ($cek_existing) {
            // Jika sudah ada, kita update nominalnya
            $this->db->where('id', $cek_existing->id);
            $simpan = $this->db->update('anggaran', $data);
            $pesan = "Anggaran berhasil diperbarui!";
        } else {
            // Jika belum ada, kita masukkan data baru
            $simpan = $this->db->insert('anggaran', $data);
            $pesan = "Anggaran baru berhasil ditetapkan!";
        }

        // 3. Beri notifikasi ke user
        if ($simpan) {
            $this->session->set_flashdata('success', $pesan);
        } else {
            $this->session->set_flashdata('error', 'Terjadi kesalahan saat menyimpan data.');
        }

        redirect('anggaran');
    }

    public function hapus($id)
    {
        $user_id = $this->session->userdata('user_id');

        // Pastikan anggaran yang dihapus adalah milik user yang sedang login
        $this->db->where(['id' => $id, 'user_id' => $user_id]);
        $this->db->delete('anggaran');

        $this->session->set_flashdata('success', 'Anggaran berhasil dihapus.');
        redirect('anggaran');
    }
}
