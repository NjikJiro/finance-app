<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Anggaran extends MY_Controller
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
        
        // 0. LOGIKA SIKLUS DINAMIS
        $user = $this->db->get_where('users', ['id' => $user_id])->row();
        $cycle_day = (int)($user->cycle_date ?? 1);
        
        $today = new DateTime();
        $current_day = (int)$today->format('d');
        
        // Menentukan awal siklus (Start Date)
        if ($current_day < $cycle_day) {
            $start_date = date('Y-m-', strtotime('-1 month')) . str_pad($cycle_day, 2, '0', STR_PAD_LEFT);
        } else {
            $start_date = date('Y-m-') . str_pad($cycle_day, 2, '0', STR_PAD_LEFT);
        }
        
        // Menentukan akhir siklus (H-1 sebelum gajian berikutnya)
        $end_date = date('Y-m-d', strtotime($start_date . ' +1 month -1 day'));
        
        // 1. HITUNG SISA HARI (Termasuk hari ini sampai akhir siklus)
        $end_dt = new DateTime($end_date);
        $diff = $today->diff($end_dt);
        
        // Jika hari ini sudah melewati end_date (kasus ganti bulan), set minimal 1
        $data['sisa_hari'] = ($today > $end_dt) ? 1 : $diff->days + 1;

        // Label periode anggaran (YYYY-MM dari end_date sebagai ID Unik Anggaran)
        $label_periode = date('Y-m', strtotime($end_date));

        // 2. AMBIL DATA ANGGARAN
        $this->db->select('a.*, k.nama_kategori');
        $this->db->from('anggaran a');
        $this->db->join('kategori k', 'k.id = a.kategori_id');
        $this->db->where(['a.user_id' => $user_id, 'a.bulan_tahun' => $label_periode]);
        $daftar_anggaran = $this->db->get()->result();

        // 3. HITUNG REALISASI TRANSAKSI DALAM SIKLUS
        foreach ($daftar_anggaran as $ang) {
            $this->db->select_sum('jumlah');
            $this->db->where([
                'kategori_id' => $ang->kategori_id,
                'user_id' => $user_id,
                'tanggal >=' => $start_date,
                'tanggal <=' => $end_date
            ]);
            $realisasi = $this->db->get('transaksi')->row();
            $ang->total_terpakai = $realisasi->jumlah ?? 0;
        }

        // Data untuk View
        $data['daftar_anggaran'] = $daftar_anggaran;
        $data['kategori_pengeluaran'] = $this->db->get_where('kategori', [
            'user_id' => $user_id,
            'tipe' => 'pengeluaran'
        ])->result();
        
        $data['periode_text'] = date('d M', strtotime($start_date)) . ' - ' . date('d M Y', strtotime($end_date));

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('anggaran/index', $data);
        $this->load->view('templates/footer');
    }

    public function simpan()
    {
        $this->form_validation->set_rules('kategori_id', 'Kategori', 'required');
        $this->form_validation->set_rules('nominal_target', 'Nominal Target', 'required|numeric|greater_than[0]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Input tidak valid.');
            redirect('anggaran');
        }

        $user_id = $this->session->userdata('user_id');
        $user = $this->db->get_where('users', ['id' => $user_id])->row();
        $cycle_day = (int)($user->cycle_date ?? 1);
        
        $today = new DateTime();
        $current_day = (int)$today->format('d');

        // Samakan logika label_periode dengan index
        if ($current_day < $cycle_day) {
            $end_date_ref = date('Y-m-') . str_pad($cycle_day - 1, 2, '0', STR_PAD_LEFT);
        } else {
            $end_date_ref = date('Y-m-', strtotime('+1 month')) . str_pad($cycle_day - 1, 2, '0', STR_PAD_LEFT);
        }
        $bulan_tahun = date('Y-m', strtotime($end_date_ref));

        $kategori_id = $this->input->post('kategori_id');
        $nominal_target = $this->input->post('nominal_target');

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
            $this->db->where('id', $cek_existing->id);
            $simpan = $this->db->update('anggaran', $data);
            $pesan = "Anggaran siklus ini diperbarui!";
        } else {
            $simpan = $this->db->insert('anggaran', $data);
            $pesan = "Anggaran siklus baru ditetapkan!";
        }

        if ($simpan) {
            $this->session->set_flashdata('success', $pesan);
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan anggaran.');
        }
        
        redirect('anggaran');
    }

    public function hapus($id)
    {
        $user_id = $this->session->userdata('user_id');
        $this->db->where(['id' => $id, 'user_id' => $user_id]);
        if ($this->db->delete('anggaran')) {
            $this->session->set_flashdata('success', 'Anggaran berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus anggaran.');
        }
        redirect('anggaran');
    }
}