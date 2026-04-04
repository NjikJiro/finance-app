<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
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
        
        // 0. LOGIKA SIKLUS DINAMIS
        $user = $this->db->get_where('users', ['id' => $user_id])->row();
        $cycle_day = (int)($user->cycle_date ?? 1);
        $today = new DateTime();
        if ((int)$today->format('d') < $cycle_day) {
            $start_date = date('Y-m-', strtotime('-1 month')) . str_pad($cycle_day, 2, '0', STR_PAD_LEFT);
        } else {
            $start_date = date('Y-m-') . str_pad($cycle_day, 2, '0', STR_PAD_LEFT);
        }
        $end_date = date('Y-m-d', strtotime($start_date . ' +1 month -1 day'));

        // 1. HITUNG SALDO TOTAL (AKURAT DENGAN TRANSFER)
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
        $data['saldo_atm']   = ($res['in_atm'] + $res['tr_in_atm']) - ($res['out_atm'] + $res['tr_out_atm']);
        $data['saldo_tunai'] = ($res['in_cash'] + $res['tr_in_cash']) - ($res['out_cash'] + $res['tr_out_cash']);
        $data['saldo']       = $data['saldo_atm'] + $data['saldo_tunai'];

        // 2. RINGKASAN SIKLUS
        $this->db->select("SUM(CASE WHEN tipe = 'pendapatan' THEN jumlah ELSE 0 END) as pendapatan_bulan,
                           SUM(CASE WHEN tipe = 'pengeluaran' THEN jumlah ELSE 0 END) as pengeluaran_bulan");
        $this->db->where(['user_id' => $user_id, 'tanggal >=' => $start_date, 'tanggal <=' => $end_date]);
        $siklus_ini = $this->db->get('transaksi')->row_array();
        $data['pendapatan_bulan']  = $siklus_ini['pendapatan_bulan'] ?? 0;
        $data['pengeluaran_bulan'] = $siklus_ini['pengeluaran_bulan'] ?? 0;
        $data['surplus']           = $data['pendapatan_bulan'] - $data['pengeluaran_bulan'];

        // 3. DATA DONUT CHART
        $data['pemasukan_kategori']   = $this->get_chart_data_cycle($user_id, 'pendapatan', $start_date, $end_date);
        $data['pengeluaran_kategori'] = $this->get_chart_data_cycle($user_id, 'pengeluaran', $start_date, $end_date);

        // 4. DATA FILTER LINE CHART
        // A. 7 Hari Terakhir
        $start_7d = date('Y-m-d', strtotime('-6 days'));
        $this->db->select("SUM(CASE WHEN tipe='pendapatan' THEN jumlah WHEN tipe='pengeluaran' THEN -jumlah ELSE 0 END) as saldo_lalu");
        $this->db->where(['user_id' => $user_id, 'tanggal <' => $start_7d]);
        $data['base_7days'] = (float)($this->db->get('transaksi')->row()->saldo_lalu ?? 0);
        $this->db->select("tanggal as label, SUM(CASE WHEN tipe='pendapatan' THEN jumlah WHEN tipe='pengeluaran' THEN -jumlah ELSE 0 END) as selisih");
        $this->db->where(['user_id' => $user_id, 'tanggal >=' => $start_7d]);
        $this->db->group_by('tanggal')->order_by('tanggal', 'ASC');
        $data['raw_7days'] = $this->db->get('transaksi')->result_array();

        // B. 1 Bulan Terakhir
        $start_1m = date('Y-m-d', strtotime('-1 month'));
        $this->db->select("SUM(CASE WHEN tipe='pendapatan' THEN jumlah WHEN tipe='pengeluaran' THEN -jumlah ELSE 0 END) as saldo_lalu");
        $this->db->where(['user_id' => $user_id, 'tanggal <' => $start_1m]);
        $data['base_1month'] = (float)($this->db->get('transaksi')->row()->saldo_lalu ?? 0);
        $this->db->select("tanggal as label, SUM(CASE WHEN tipe='pendapatan' THEN jumlah WHEN tipe='pengeluaran' THEN -jumlah ELSE 0 END) as selisih");
        $this->db->where(['user_id' => $user_id, 'tanggal >=' => $start_1m]);
        $this->db->group_by('tanggal')->order_by('tanggal', 'ASC');
        $data['raw_1month'] = $this->db->get('transaksi')->result_array();

        // C. 6 Bulan Terakhir
        $start_6m = date('Y-m-01', strtotime('-5 months'));
        $this->db->select("SUM(CASE WHEN tipe='pendapatan' THEN jumlah WHEN tipe='pengeluaran' THEN -jumlah ELSE 0 END) as saldo_lalu");
        $this->db->where(['user_id' => $user_id, 'tanggal <' => $start_6m]);
        $data['base_6months'] = (float)($this->db->get('transaksi')->row()->saldo_lalu ?? 0);
        $this->db->select("DATE_FORMAT(tanggal, '%b %Y') as label, SUM(CASE WHEN tipe='pendapatan' THEN jumlah WHEN tipe='pengeluaran' THEN -jumlah ELSE 0 END) as selisih, MIN(tanggal) as urutan");
        $this->db->where(['user_id' => $user_id, 'tanggal >=' => $start_6m]);
        $this->db->group_by('label')->order_by('urutan', 'ASC');
        $data['raw_6months'] = $this->db->get('transaksi')->result_array();

        // 5. TREND BAR CHART & ANGGARAN
        $this->db->select("DATE_FORMAT(tanggal, '%b %Y') AS periode, 
                           SUM(CASE WHEN tipe = 'pendapatan' THEN jumlah ELSE 0 END) AS pendapatan,
                           SUM(CASE WHEN tipe = 'pengeluaran' THEN jumlah ELSE 0 END) AS pengeluaran,
                           MIN(tanggal) as urutan");
        $this->db->where(['user_id' => $user_id, 'tanggal >=' => $start_6m]);
        $this->db->group_by('periode')->order_by('urutan', 'ASC');
        $data['bulanan_6'] = $this->db->get('transaksi')->result_array();

        $this->db->select('a.*, k.nama_kategori')->from('anggaran a')->join('kategori k', 'k.id = a.kategori_id');
        $this->db->where(['a.user_id' => $user_id, 'a.bulan_tahun' => date('Y-m', strtotime($end_date))]);
        $data['daftar_anggaran'] = $this->db->get()->result();
        foreach ($data['daftar_anggaran'] as $ang) {
            $this->db->select_sum('jumlah')->where(['kategori_id' => $ang->kategori_id, 'user_id' => $user_id, 'tanggal >=' => $start_date, 'tanggal <=' => $end_date]);
            $ang->total_terpakai = $this->db->get('transaksi')->row()->jumlah ?? 0;
        }

        // 6. TRANSAKSI TERBARU & PERSENTASE
        $this->db->select('t.*, k.nama_kategori')->from('transaksi t')->join('kategori k', 'k.id = t.kategori_id', 'left');
        $this->db->where('t.user_id', $user_id)->order_by('t.tanggal', 'DESC')->order_by('t.id', 'DESC')->limit(5);
        $data['recent_transactions'] = $this->db->get()->result();

        $start_lalu = date('Y-m-d', strtotime($start_date . ' -1 month'));
        $end_lalu   = date('Y-m-d', strtotime($start_lalu . ' +1 month -1 day'));
        $this->db->select("SUM(CASE WHEN tipe = 'pendapatan' THEN jumlah ELSE 0 END) - SUM(CASE WHEN tipe = 'pengeluaran' THEN jumlah ELSE 0 END) as surplus_lalu");
        $this->db->where(['user_id' => $user_id, 'tanggal >=' => $start_lalu, 'tanggal <=' => $end_lalu]);
        $surplus_lalu = $this->db->get('transaksi')->row()->surplus_lalu ?? 0;
        $data['persen_surplus'] = ($surplus_lalu != 0) ? (($data['surplus'] - $surplus_lalu) / abs($surplus_lalu)) * 100 : ($data['surplus'] > 0 ? 100 : 0);

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('dashboard', $data);
        $this->load->view('templates/footer');
    }

    private function get_chart_data_cycle($user_id, $tipe, $start, $end) {
        $this->db->select('k.nama_kategori, SUM(t.jumlah) as total')->from('transaksi t')->join('kategori k', 'k.id = t.kategori_id');
        $this->db->where(['t.user_id' => $user_id, 't.tipe' => $tipe, 't.tanggal >=' => $start, 't.tanggal <=' => $end]);
        $this->db->group_by('k.id');
        return $this->db->get()->result_array();
    }
}