<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends MY_Controller // Pastikan sesuai dengan nama file atau ganti ke MY_Controller jika ada base controller
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
        $data['user'] = $this->db->get_where('users', ['id' => $user_id])->row();

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('profile_v', $data);
        $this->load->view('templates/footer');
    }

    public function update_action()
    {
        $user_id = $this->session->userdata('user_id');
        $nama = $this->input->post('nama');
        $cycle_date = $this->input->post('cycle_date');
        $password = $this->input->post('password');

        if ($cycle_date > 28) {
            $this->session->set_flashdata('error', 'Maksimal tanggal siklus adalah 28.');
            redirect('profile');
        }

        $data = [
            'nama' => $nama,
            'cycle_date' => $cycle_date
        ];

        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->db->where('id', $user_id);
        $this->db->update('users', $data);

        $this->session->set_userdata('user_name', $nama);
        $this->session->set_flashdata('success', 'Profil berhasil diperbarui!');
        redirect('profile');
    }

    public function print_laporan()
    {
        $user_id = $this->session->userdata('user_id');
        $periode = $this->input->get('periode');

        if (!$periode) redirect('profile');

        $user = $this->db->get_where('users', ['id' => $user_id])->row();
        $data['user'] = $user;
        $cycle_day = (int)$user->cycle_date;

        $date_input = new DateTime($periode . '-01');
        if ($cycle_day > 1) {
            $date_input->modify('-1 month');
        }

        $start_date = $date_input->format('Y-m') . '-' . str_pad($cycle_day, 2, '0', STR_PAD_LEFT);
        $end_date = date('Y-m-d', strtotime($start_date . ' +1 month -1 day'));

        $data['periode_text'] = date('d M Y', strtotime($start_date)) . ' - ' . date('d M Y', strtotime($end_date));

        // 3. SALDO AWAL
        $res_awal = $this->db->select("SUM(CASE WHEN tipe='pendapatan' THEN jumlah WHEN tipe='pengeluaran' THEN -jumlah ELSE 0 END) as saldo")
            ->where(['user_id' => $user_id, 'tanggal <' => $start_date])
            ->get('transaksi')->row();
        $data['saldo_awal'] = (float)($res_awal->saldo ?? 0);

        // 4. TREND HARIAN
        $data['daily_trend'] = $this->db->select("tanggal, SUM(CASE WHEN tipe='pendapatan' THEN jumlah WHEN tipe='pengeluaran' THEN -jumlah ELSE 0 END) as selisih")
            ->where(['user_id' => $user_id, 'tanggal >=' => $start_date, 'tanggal <=' => $end_date])
            ->group_by('tanggal')->order_by('tanggal', 'ASC')
            ->get('transaksi')->result_array();

        // 5. DISTRIBUSI KATEGORI (FIXED: Menambahkan Pemasukan)
        $data['pengeluaran_kategori'] = $this->db->select('k.nama_kategori, SUM(t.jumlah) as total')
            ->from('transaksi t')->join('kategori k', 'k.id = t.kategori_id')
            ->where(['t.user_id' => $user_id, 't.tipe' => 'pengeluaran', 't.tanggal >=' => $start_date, 't.tanggal <=' => $end_date])
            ->group_by('k.nama_kategori')->get()->result_array();

        $data['pemasukan_kategori'] = $this->db->select('k.nama_kategori, SUM(t.jumlah) as total')
            ->from('transaksi t')->join('kategori k', 'k.id = t.kategori_id')
            ->where(['t.user_id' => $user_id, 't.tipe' => 'pendapatan', 't.tanggal >=' => $start_date, 't.tanggal <=' => $end_date])
            ->group_by('k.nama_kategori')->get()->result_array();

        // 6. DAFTAR TRANSAKSI
        $this->db->select('transaksi.*, kategori.nama_kategori'); // Memastikan nama kategori terbawa ke tabel
        $this->db->join('kategori', 'kategori.id = transaksi.kategori_id', 'left');
        $this->db->where(['transaksi.user_id' => $user_id, 'tanggal >=' => $start_date, 'tanggal <=' => $end_date]);
        $this->db->order_by('tanggal', 'ASC');
        $data['transaksi'] = $this->db->get('transaksi')->result();

        // 7. RINGKASAN TOTAL
        $this->db->select('SUM(CASE WHEN tipe = "pendapatan" THEN jumlah ELSE 0 END) as total_masuk, SUM(CASE WHEN tipe = "pengeluaran" THEN jumlah ELSE 0 END) as total_keluar');
        $this->db->where(['user_id' => $user_id, 'tanggal >=' => $start_date, 'tanggal <=' => $end_date]);
        $data['ringkasan'] = $this->db->get('transaksi')->row();

        $this->load->view('print_laporan_v', $data);
    }
}