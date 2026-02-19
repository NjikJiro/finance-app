<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');

        if (!$this->session->userdata('user_id')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $tahun   = date('Y');
        $bulan   = date('m');
        $periode_sekarang = date('Y-m');

        // 1. HITUNG SALDO TERPISAH (AKURAT DENGAN TRANSFER)
        $this->db->select("
            SUM(CASE WHEN sumber = 'atm' AND tipe = 'pendapatan' THEN jumlah ELSE 0 END) as in_atm,
            SUM(CASE WHEN sumber = 'atm' AND tipe = 'pengeluaran' THEN jumlah ELSE 0 END) as out_atm,
            SUM(CASE WHEN sumber = 'atm' AND tipe = 'transfer' AND keterangan LIKE 'Transfer masuk%' THEN jumlah ELSE 0 END) as tr_in_atm,
            SUM(CASE WHEN sumber = 'atm' AND tipe = 'transfer' AND keterangan LIKE 'Transfer keluar%' THEN jumlah ELSE 0 END) as tr_out_atm,

            SUM(CASE WHEN sumber = 'tunai' AND tipe = 'pendapatan' THEN jumlah ELSE 0 END) as in_cash,
            SUM(CASE WHEN sumber = 'tunai' AND tipe = 'pengeluaran' THEN jumlah ELSE 0 END) as out_cash,
            SUM(CASE WHEN sumber = 'tunai' AND tipe = 'transfer' AND keterangan LIKE 'Transfer masuk%' THEN jumlah ELSE 0 END) as tr_in_cash,
            SUM(CASE WHEN sumber = 'tunai' AND tipe = 'transfer' AND keterangan LIKE 'Transfer keluar%' THEN jumlah ELSE 0 END) as tr_out_cash
        ");
        $this->db->where('user_id', $user_id);
        $res = $this->db->get('transaksi')->row_array();

        // Perhitungan Saldo Final
        $data['saldo_atm']   = ($res['in_atm'] + $res['tr_in_atm']) - ($res['out_atm'] + $res['tr_out_atm']);
        $data['saldo_tunai'] = ($res['in_cash'] + $res['tr_in_cash']) - ($res['out_cash'] + $res['tr_out_cash']);
        $data['saldo']       = $data['saldo_atm'] + $data['saldo_tunai'];

        // 2. RINGKASAN BULAN INI
        $this->db->select("
            SUM(CASE WHEN tipe = 'pendapatan' THEN jumlah ELSE 0 END) as pendapatan_bulan,
            SUM(CASE WHEN tipe = 'pengeluaran' THEN jumlah ELSE 0 END) as pengeluaran_bulan
        ");
        $this->db->where(['user_id' => $user_id, 'MONTH(tanggal)' => $bulan, 'YEAR(tanggal)' => $tahun]);
        $bulan_ini = $this->db->get('transaksi')->row_array();

        $data['pendapatan_bulan']  = $bulan_ini['pendapatan_bulan'] ?? 0;
        $data['pengeluaran_bulan'] = $bulan_ini['pengeluaran_bulan'] ?? 0;
        $data['surplus']           = $data['pendapatan_bulan'] - $data['pengeluaran_bulan'];

        // 3. DATA CHART
        $data['pemasukan_kategori']   = $this->get_chart_data($user_id, 'pendapatan', $bulan, $tahun);
        $data['pengeluaran_kategori'] = $this->get_chart_data($user_id, 'pengeluaran', $bulan, $tahun);

        // 4. TREND 6 BULAN
        $this->db->select("DATE_FORMAT(tanggal, '%b %Y') AS periode, 
                           SUM(CASE WHEN tipe = 'pendapatan' THEN jumlah ELSE 0 END) AS pendapatan,
                           SUM(CASE WHEN tipe = 'pengeluaran' THEN jumlah ELSE 0 END) AS pengeluaran");
        $this->db->where('user_id', $user_id);
        $this->db->where('tanggal >=', date('Y-m-01', strtotime('-5 months')));
        $this->db->group_by('periode');
        $this->db->order_by('tanggal', 'ASC');
        $data['bulanan_6'] = $this->db->get('transaksi')->result_array();

        // 5. ANGGARAN
        $this->db->select('a.*, k.nama_kategori');
        $this->db->from('anggaran a');
        $this->db->join('kategori k', 'k.id = a.kategori_id');
        $this->db->where(['a.user_id' => $user_id, 'a.bulan_tahun' => $periode_sekarang]);
        $data['daftar_anggaran'] = $this->db->get()->result();

        foreach ($data['daftar_anggaran'] as $ang) {
            $this->db->select_sum('jumlah');
            $this->db->where(['kategori_id' => $ang->kategori_id, 'user_id' => $user_id, 'DATE_FORMAT(tanggal, "%Y-%m") =' => $periode_sekarang]);
            $ang->total_terpakai = $this->db->get('transaksi')->row()->jumlah ?? 0;
        }

        // 6. AMBIL 5 TRANSAKSI TERBARU
        $this->db->select('t.*, k.nama_kategori');
        $this->db->from('transaksi t');
        $this->db->join('kategori k', 'k.id = t.kategori_id', 'left');
        $this->db->where('t.user_id', $user_id);
        $this->db->order_by('t.tanggal', 'DESC');
        $this->db->order_by('t.id', 'DESC');
        $this->db->limit(5);
        $data['recent_transactions'] = $this->db->get()->result();

        // --- Tambahkan ini di dalam method index() ---
        $bulan_lalu = date('m', strtotime('-1 month'));
        $tahun_lalu = date('Y', strtotime('-1 month'));

        $this->db->select("SUM(CASE WHEN tipe = 'pendapatan' THEN jumlah ELSE 0 END) - SUM(CASE WHEN tipe = 'pengeluaran' THEN jumlah ELSE 0 END) as surplus_lalu");
        $this->db->where(['user_id' => $user_id, 'MONTH(tanggal)' => $bulan_lalu, 'YEAR(tanggal)' => $tahun_lalu]);
        $surplus_lalu = $this->db->get('transaksi')->row()->surplus_lalu ?? 0;

        $data['persen_surplus'] = 0;
        if ($surplus_lalu != 0) {
            $data['persen_surplus'] = (($data['surplus'] - $surplus_lalu) / abs($surplus_lalu)) * 100;
        } elseif ($data['surplus'] > 0) {
            $data['persen_surplus'] = 100;
        }

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('dashboard', $data);
        $this->load->view('templates/footer');
    }

    private function get_chart_data($user_id, $tipe, $bulan, $tahun)
    {
        $this->db->select('k.nama_kategori, SUM(t.jumlah) as total');
        $this->db->from('transaksi t');
        $this->db->join('kategori k', 'k.id = t.kategori_id');
        $this->db->where(['t.user_id' => $user_id, 't.tipe' => $tipe, 'MONTH(t.tanggal)' => $bulan, 'YEAR(t.tanggal)' => $tahun]);
        $this->db->group_by('k.id');
        return $this->db->get()->result_array();
    }
}
