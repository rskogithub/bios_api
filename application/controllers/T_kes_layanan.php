<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T_kes_layanan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // is_login();
        $this->load->model('T_kes_layanan_model');
        $this->load->library('form_validation');
        // $this->load->library('datatables');
        // $this->db2 = $this->load->database('simrsko', TRUE);
    }

    public function index()
    {
        $yesterday = date('Y-m-d', strtotime("-1 days"));
        // JUMLAH DATA LAYANAN FORENSIK

        $data_forensik = array(
            'tgl_transaksi' => $yesterday,
            'jumlah' => 0,
        );
        $this->T_kes_layanan_model->insert_kes_lay_forensik($data_forensik);

        // JUMLAH KUNJUNGAN RAWAT JALAN
        $result_kunjungan_rajal = $this->T_kes_layanan_model->get_count_kunjungan_rajal();

        $data_kunj_rajal = array(
            'tgl_transaksi' => $yesterday,
            'jumlah' => $result_kunjungan_rajal->ttl,
        );
        $this->T_kes_layanan_model->insert_kes_lay_kunjungan_rajal($data_kunj_rajal);

        // JUMLAH PASIEN BPJS & NON BPJS
        $result_pasien_bpjs = $this->T_kes_layanan_model->get_count_pasien_bpjs();
        $result_pasien_nonbpjs = $this->T_kes_layanan_model->get_count_pasien_nonbpjs();


        $data_bpjs_nonbpjs = array(
            'tgl_transaksi' => $yesterday,
            'jumlah_bpjs' => $result_pasien_bpjs->ttl,
            'jumlah_non_bpjs' => $result_pasien_nonbpjs->ttl,
        );
        $this->T_kes_layanan_model->insert_kes_lay_pasien_bpjs_nonbpjs($data_bpjs_nonbpjs);

        // JUMLAH PASIEN IGD
        $result_pasien_igd = $this->T_kes_layanan_model->get_count_pasien_igd();


        $data_igd = array(
            'tgl_transaksi' => $yesterday,
            'jumlah' => $result_pasien_igd->ttl,
        );
        $this->T_kes_layanan_model->insert_kes_lay_pasien_igd($data_igd);

        // JUMLAH PASIEN RAJAL
        $result_pasien_rajal = $this->T_kes_layanan_model->get_count_pasien_rajal();

        foreach ($result_pasien_rajal as $row) {
            $yesterday_rajal = date('Y-m-d', strtotime("-1 days"));
            $data_rajal = array(
                'tgl_transaksi' => $yesterday_rajal,
                'jumlah' => $row->ttl,
                'nama_poli' => $row->nama_poli_sub,
            );
            $this->T_kes_layanan_model->insert_kes_lay_pasien_rajal($data_rajal);
        }

        // JUMLAH PASIEN RANAP
        $result_pasien_ranap = $this->T_kes_layanan_model->get_count_pasien_ranap();
        foreach ($result_pasien_ranap as $row) {
            $yesterday_ranap = date('Y-m-d', strtotime("-1 days"));
            $data_ranap = array(
                'tgl_transaksi' => $yesterday_ranap,
                'kode_kelas' => $row->kode_kelas,
                'jumlah' => $row->ttl,
            );
            $this->T_kes_layanan_model->insert_kes_lay_pasien_ranap($data_ranap);
        }

        // JUMLAH PASIEN OPERASI
        $data_operasi = array(
            'tgl_transaksi' => $yesterday,
            'klasifikasi_operasi' => 'TIDAK ADA',
            'jumlah' => '0',
        );
        $this->T_kes_layanan_model->insert_kes_lay_tindakan_operasi($data_operasi);

        // JUMLAH LAYANAN LAB PARAMETER
        $result_lab_parameter = $this->T_kes_layanan_model->get_count_layanan_lab_parameter();
        foreach ($result_lab_parameter as $row) {
            $yesterday_lab_para = date('Y-m-d', strtotime("-1 days"));
            $data_lab_para = array(
                'tgl_transaksi' => $yesterday_lab_para,
                'nama_layanan' => $row->nama_tindakan,
                'jumlah' => $row->ttl,
            );
            $this->T_kes_layanan_model->insert_kes_lay_lab_parameter($data_lab_para);
        }

        // JUMLAH LAYANAN LAB SAMPEL
        $result_lab_sampel = $this->T_kes_layanan_model->get_count_layanan_lab_sampel();
        $data_lab_sam = array(
            'tgl_transaksi' => $yesterday,
            'jumlah' => $result_lab_sampel->ttl,
        );
        $this->T_kes_layanan_model->insert_kes_lay_lab_sampel($data_lab_sam);

        // JUMLAH LAYANAN RAD
        $result_rad = $this->T_kes_layanan_model->get_count_layanan_rad();
        foreach ($result_rad as $row) {
            $yesterday_rad = date('Y-m-d', strtotime("-1 days"));
            $data_rad = array(
                'tgl_transaksi' => $yesterday_rad,
                'jumlah' => $row->ttl,
            );
            $this->T_kes_layanan_model->insert_kes_lay_radiologi($data_rad);
        }
    }
}

/* End of file T_kes_lay_pasien_rajal.php */