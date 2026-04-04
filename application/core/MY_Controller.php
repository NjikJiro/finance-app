<?php
class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Di dalam __construct()
        $m_status = $this->db->get_where('settings', ['key' => 'maintenance_mode'])->row()->value;

        if ($m_status == 'on' && $this->session->userdata('user_id') != 1) {
            // Tambahkan TRUE sebagai parameter ketiga agar view dikembalikan sebagai string
            // Lalu gunakan die() untuk mencetaknya dan menghentikan script saat itu juga
            die($this->load->view('errors/error_maintenance', '', TRUE));
        }
    }

    protected function get_current_period()
    {
        $cycle_date = (int) $this->db->get_where('settings', ['key' => 'cycle_start_date'])->row()->value;
        $today_date = (int) date('d');
        $today_month = (int) date('m');
        $today_year = (int) date('Y');

        if ($today_date >= $cycle_date) {
            // Jika sudah melewati tanggal gajian, awal adalah bulan ini
            $start = date("$today_year-$today_month-$cycle_date");
            $end = date('Y-m-d', strtotime("$start +1 month -1 day"));
        } else {
            // Jika belum gajian, awal adalah bulan lalu
            $start = date('Y-m-d', strtotime("$today_year-$today_month-$cycle_date -1 month"));
            $end = date('Y-m-d', strtotime("$start +1 month -1 day"));
        }

        return ['start' => $start, 'end' => $end];
    }
}
