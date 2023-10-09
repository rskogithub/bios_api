<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T_kes_senddata extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // is_login();
        $this->load->model('T_kes_senddata_model');
        $this->load->library('form_validation');
        // $this->load->library('datatables');
        // $this->db2 = $this->load->database('simrsko', TRUE);
    }

    public function index()
    {

        $date_from = date('Y-m-d', strtotime("-1 days"));
        $date_to = date('Y-m-d', strtotime("-1 days"));

        echo $date_from;
        echo $date_to;
        // $result_lab_parameter = $this->T_kes_senddata_model->get_count();
        // foreach ($result_lab_parameter as $row) {
        //     $data_lab_para = array(
        //         'tgl_transaksi' => $row->create_date,
        //         'nama_layanan' => $row->nama_tindakan,
        //         'jumlah' => $row->ttl,
        //     );
        //     $this->T_kes_senddata_model->insert_data($data_lab_para);
        // }
    }
}

/* End of file T_kes_lay_pasien_rajal.php */