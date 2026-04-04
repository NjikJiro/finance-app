<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Listrik extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'form_validation']);

        // Proteksi login
        if (!$this->session->userdata('user_id')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $bulan_ini = date('Y-m');

        // 1. Ambil data kWh terakhir untuk Card Sisa Listrik
        $this->db->order_by('tanggal', 'DESC');
        $data['latest'] = $this->db->get_where('listrik', ['user_id' => $user_id], 1)->row();

        // 2. Ambil Histori untuk Tabel (Ambil agak banyak untuk DataTables)
        $this->db->order_by('tanggal', 'DESC');
        $data['histori'] = $this->db->get_where('listrik', ['user_id' => $user_id])->result();

        // 3. HITUNG RATA-RATA REALISTIS
        // Ambil total pemakaian bulan ini
        $this->db->select_sum('kwh_terpakai');
        $this->db->where('user_id', $user_id);
        $this->db->where('DATE_FORMAT(tanggal, "%Y-%m") =', $bulan_ini);
        $total_kwh = $this->db->get('listrik')->row()->kwh_terpakai ?? 0;

        // Hitung berapa hari yang sudah ada inputnya (Unique Days)
        $this->db->select("COUNT(DISTINCT(DATE(tanggal))) as jumlah_hari");
        $this->db->where('user_id', $user_id);
        $this->db->where('DATE_FORMAT(tanggal, "%Y-%m") =', $bulan_ini);
        $jumlah_hari = $this->db->get('listrik')->row()->jumlah_hari ?? 0;

        // Hitung rata-rata & Estimasi sisa hari
        $data['avg_per_hari'] = ($jumlah_hari > 0) ? $total_kwh / $jumlah_hari : 0;
        $data['hari_tercatat'] = $jumlah_hari;
        
        $latest_kwh = $data['latest']->kwh_sisa ?? 0;
        $data['estimasi_sisa_hari'] = ($data['avg_per_hari'] > 0) ? floor($latest_kwh / $data['avg_per_hari']) : 0;

        // 4. Data untuk Line Chart (Sisa kWh 10 input terakhir, urutkan ASC untuk grafik)
        $subquery = "(SELECT * FROM listrik WHERE user_id = $user_id ORDER BY tanggal DESC LIMIT 10) as t";
        $this->db->select('*');
        $this->db->from($subquery);
        $this->db->order_by('tanggal', 'ASC');
        $data['chart_data'] = $this->db->get()->result();

        // View Load
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('listrik/index', $data);
        $this->load->view('templates/footer');
    }

    public function simpan()
    {
        $user_id = $this->session->userdata('user_id');
        $kwh_input = $this->input->post('kwh_sisa');
        $tgl = $this->input->post('tanggal_input');
        $jam = $this->input->post('jam_input');
        $datetime_input = $tgl . ' ' . $jam . ':00';

        // LOGIKA PERHITUNGAN PEMAKAIAN
        // Cari data tepat 1 baris SEBELUM tanggal input (untuk selisih)
        $this->db->where('user_id', $user_id);
        $this->db->where('tanggal <', $datetime_input);
        $this->db->order_by('tanggal', 'DESC');
        $prev_data = $this->db->get('listrik', 1)->row();

        $terpakai = 0;
        // Hanya hitung selisih jika input baru lebih kecil dari sisa sebelumnya (artinya ada pemakaian)
        // Jika input baru lebih besar, berarti user sedang isi ulang token (top-up)
        if ($prev_data && $kwh_input < $prev_data->kwh_sisa) {
            $terpakai = $prev_data->kwh_sisa - $kwh_input;
        }

        $insert_data = [
            'user_id'      => $user_id,
            'kwh_sisa'     => $kwh_input,
            'kwh_terpakai' => $terpakai,
            'tanggal'      => $datetime_input
        ];

        if ($this->db->insert('listrik', $insert_data)) {
            $this->session->set_flashdata('success', 'Data kWh berhasil dicatat!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data.');
        }

        redirect('listrik');
    }

    public function hapus($id)
    {
        $user_id = $this->session->userdata('user_id');
        
        // Safety check: hanya hapus jika milik user yang login
        $this->db->where(['id' => $id, 'user_id' => $user_id]);
        if ($this->db->delete('listrik')) {
            $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }

        redirect('listrik');
    }
}