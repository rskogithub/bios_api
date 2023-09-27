<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Message;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T_kes_layanan_model extends CI_Model
{

    public $table = 't_kes_lay_pasien_rajal';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
        $this->db2 = $this->load->database('simrsko', TRUE);

        $client = new Client();
        $response = $client->request(
            'POST',
            'https://training-bios2.kemenkeu.go.id/api/token',
            [
                'form_params' => [
                    'satker' => '415670',
                    'key' => 'liLUUX5GwITpoFHDP7PxIJlOwkO5kysz'
                ]
            ]
        )->getBody()->getContents();
        $token = (json_decode($response, true));
        $get_token = $token['token'];

        $this->_client = new Client([
            'base_uri' => 'https://training-bios2.kemenkeu.go.id/api/ws/',
            'headers' => [
                'Token' => $get_token,
            ]
        ]);
    }

    function insert_kes_lay_forensik($data)
    {
        $response = $this->_client->request('POST', 'kesehatan/layanan/forensik', [
            'form_params' => $data
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        $return_data = array(
            'tgl_transaksi' => $data['tgl_transaksi'],
            'jumlah' => $data['jumlah'],
            'message' => $result['message'],
            'user' => 'CRON',
            'create_date' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('t_kes_lay_forensik', $return_data);
    }

    function insert_kes_lay_kunjungan_rajal($data)
    {
        $response = $this->_client->request('POST', 'kesehatan/layanan/pasien_ralan', [
            'form_params' => $data
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        $return_data = array(
            'tgl_transaksi' => $data['tgl_transaksi'],
            'jumlah' => $data['jumlah'],
            'message' => $result['message'],
            'user' => 'CRON',
            'create_date' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('t_kes_lay_kunjungan_rajal', $return_data);
    }

    function insert_kes_lay_pasien_bpjs_nonbpjs($data)
    {
        $response = $this->_client->request('POST', 'kesehatan/layanan/bpjs_nonbpbjs', [
            'form_params' => $data
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        $return_data = array(
            'tgl_transaksi' => $data['tgl_transaksi'],
            'jumlah_bpjs' => $data['jumlah_bpjs'],
            'jumlah_non_bpjs' => $data['jumlah_non_bpjs'],
            'message' => $result['message'],
            'user' => 'CRON',
            'create_date' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('t_kes_lay_pasien_bpjs_nonbpjs', $return_data);
    }

    function insert_kes_lay_pasien_igd($data)
    {
        $response = $this->_client->request('POST', 'kesehatan/layanan/pasien_igd', [
            'form_params' => $data
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        $return_data = array(
            'tgl_transaksi' => $data['tgl_transaksi'],
            'jumlah' => $data['jumlah'],
            'message' => $result['message'],
            'user' => 'CRON',
            'create_date' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('t_kes_lay_pasien_igd', $return_data);
    }

    function insert_kes_lay_pasien_rajal($data)
    {
        $response = $this->_client->request('POST', 'kesehatan/layanan/pasien_ralan_poli', [
            'form_params' => $data
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        $return_data = array(
            'tgl_transaksi' => $data['tgl_transaksi'],
            'jumlah' => $data['jumlah'],
            'nama_poli' => $data['nama_poli'],
            'message' => $result['message'],
            'user' => 'CRON',
            'create_date' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('t_kes_lay_pasien_rajal', $return_data);
    }

    function insert_kes_lay_pasien_ranap($data)
    {
        $response = $this->_client->request('POST', 'kesehatan/layanan/pasien_ranap', [
            'form_params' => $data
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        $return_data = array(
            'tgl_transaksi' => $data['tgl_transaksi'],
            'kode_kelas' => $data['kode_kelas'],
            'jumlah' => $data['jumlah'],
            'message' => $result['message'],
            'user' => 'CRON',
            'create_date' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('t_kes_lay_pasien_ranap', $return_data);
    }

    function insert_kes_lay_tindakan_operasi($data)
    {
        $response = $this->_client->request('POST', 'kesehatan/layanan/operasi', [
            'form_params' => $data
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        $return_data = array(
            'tgl_transaksi' => $data['tgl_transaksi'],
            'klasifikasi_operasi' => $data['klasifikasi_operasi'],
            'jumlah' => $data['jumlah'],
            'message' => $result['message'],
            'user' => 'CRON',
            'create_date' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('t_kes_lay_tindakan_operasi', $return_data);
    }

    function insert_kes_lay_lab_parameter($data)
    {
        $response = $this->_client->request('POST', 'kesehatan/layanan/laboratorium_detail', [
            'form_params' => $data
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        $return_data = array(
            'tgl_transaksi' => $data['tgl_transaksi'],
            'jumlah' => $data['jumlah'],
            'nama_layanan' => $data['nama_layanan'],
            'message' => $result['message'],
            'user' => 'CRON',
            'create_date' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('t_kes_lay_lab_parameter', $return_data);
    }

    function insert_kes_lay_lab_sampel($data)
    {
        $response = $this->_client->request('POST', 'kesehatan/layanan/laboratorium', [
            'form_params' => $data
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        $return_data = array(
            'tgl_transaksi' => $data['tgl_transaksi'],
            'jumlah' => $data['jumlah'],
            'message' => $result['message'],
            'user' => 'CRON',
            'create_date' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('t_kes_lay_lab_sampel', $return_data);
    }

    function insert_kes_lay_radiologi($data)
    {
        $response = $this->_client->request('POST', 'kesehatan/layanan/radiologi', [
            'form_params' => $data
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        $return_data = array(
            'tgl_transaksi' => $data['tgl_transaksi'],
            'jumlah' => $data['jumlah'],
            'message' => $result['message'],
            'user' => 'CRON',
            'create_date' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('t_kes_lay_radiologi', $return_data);
    }

    function get_count_kunjungan_rajal()
    {
        $yesterday = date('Y-m-d', strtotime("-1 days"));

        $this->db2->select('COUNT(DISTINCT a.noreg) as ttl');
        $this->db2->from('zx_t_pendaftaran a');
        $this->db2->join('zx_m_poli_sub b', 'a.kode_poli_sub = b.kode_poli_sub');
        $this->db2->where('a.tgl_reg', $yesterday);
        $this->db2->where_in('b.kode_poli_sub', ['ANK', 'PD', 'GG', 'JW01', 'GZ', 'PR', 'RM', 'UM01', 'NK01', 'SRF', 'NPZ03', 'JW02', 'JW03', 'JW04', 'GRT', 'PSI', 'ANK01', 'PD01', 'GG01', 'PR01', 'RM01', 'UM02', 'SRF01', 'NPZ04', 'JW05', 'JW06', 'GRT01', 'PSI01', 'NK03', 'PRJ']);
        return $this->db2->get()->row();
    }

    function get_count_pasien_bpjs()
    {
        $yesterday = date('Y-m-d', strtotime("-1 days"));

        $this->db2->select('COUNT(DISTINCT a.noreg) as ttl');
        $this->db2->from('zx_t_pendaftaran a');
        $this->db2->join('zx_m_poli_sub b', 'a.kode_poli_sub = b.kode_poli_sub');
        $this->db2->where('a.tgl_reg', $yesterday);
        $this->db2->where_in('b.kode_poli_sub', ['ANK', 'PD', 'GG', 'JW01', 'GZ', 'PR', 'RM', 'UM01', 'NK01', 'SRF', 'NPZ03', 'JW02', 'JW03', 'JW04', 'GRT', 'PSI', 'ANK01', 'PD01', 'GG01', 'PR01', 'RM01', 'UM02', 'SRF01', 'NPZ04', 'JW05', 'JW06', 'GRT01', 'PSI01', 'NK03', 'PRJ']);
        $this->db2->where('a.kode_bayar', 'BPJS');
        return $this->db2->get()->row();
    }

    function get_count_pasien_nonbpjs()
    {
        $yesterday = date('Y-m-d', strtotime("-1 days"));

        $this->db2->select('COUNT(DISTINCT a.noreg) as ttl');
        $this->db2->from('zx_t_pendaftaran a');
        $this->db2->join('zx_m_poli_sub b', 'a.kode_poli_sub = b.kode_poli_sub');
        $this->db2->where('a.tgl_reg', $yesterday);
        $this->db2->where_in('b.kode_poli_sub', ['ANK', 'PD', 'GG', 'JW01', 'GZ', 'PR', 'RM', 'UM01', 'NK01', 'SRF', 'NPZ03', 'JW02', 'JW03', 'JW04', 'GRT', 'PSI', 'ANK01', 'PD01', 'GG01', 'PR01', 'RM01', 'UM02', 'SRF01', 'NPZ04', 'JW05', 'JW06', 'GRT01', 'PSI01', 'NK03', 'PRJ']);
        $this->db2->where('a.kode_bayar !=', 'BPJS');
        return $this->db2->get()->row();
    }

    function get_count_pasien_igd()
    {
        $yesterday = date('Y-m-d', strtotime("-1 days"));

        $this->db2->select('COUNT(DISTINCT a.noreg) as ttl');
        $this->db2->from('zx_t_pendaftaran a');
        $this->db2->join('zx_m_poli_sub b', 'a.kode_poli_sub = b.kode_poli_sub');
        $this->db2->where('a.tgl_reg', $yesterday);
        $this->db2->where_in('b.kode_poli_sub', ['IGD']);
        return $this->db2->get()->row();
    }

    function get_count_pasien_rajal()
    {
        $yesterday = date('Y-m-d', strtotime("-1 days"));

        $this->db2->select('COUNT(DISTINCT a.noreg) as ttl,b.nama_poli_sub');
        $this->db2->from('zx_t_pendaftaran a');
        $this->db2->join('zx_m_poli_sub b', 'a.kode_poli_sub = b.kode_poli_sub');
        $this->db2->where('a.tgl_reg', $yesterday);
        $this->db2->where_in('b.kode_poli_sub', ['ANK', 'PD', 'GG', 'JW01', 'GZ', 'PR', 'RM', 'UM01', 'NK01', 'SRF', 'NPZ03', 'JW02', 'JW03', 'JW04', 'GRT', 'PSI', 'ANK01', 'PD01', 'GG01', 'PR01', 'RM01', 'UM02', 'SRF01', 'NPZ04', 'JW05', 'JW06', 'GRT01', 'PSI01', 'NK03', 'PRJ']);
        $this->db2->group_by('a.kode_poli_sub');
        return $this->db2->get()->result();
    }

    function get_count_pasien_ranap()
    {
        $this->db2->select('COUNT(DISTINCT a.noreg) as ttl,c.kode_kelas');
        $this->db2->from('zx_t_admission a');
        $this->db2->join('zx_t_admission_ruang b', 'a.noreg = b.noreg');
        $this->db2->join('zx_m_kelas c', 'b.kode_kelas = c.kode_kelas');
        $this->db2->where('b.perawatan_flag', 'RAWAT');
        $this->db2->group_by('c.kode_kelas');
        return $this->db2->get()->result();
    }

    function get_count_layanan_lab_parameter()
    {
        $yesterday = date('Y-m-d', strtotime("-1 days"));

        $this->db2->select('COUNT(DISTINCT a.no_order) as ttl,a.nama_tindakan');
        $this->db2->from('zx_t_bill a');
        $this->db2->join('zx_hasil_lab b', 'a.no_order = b.no_order');
        $this->db2->where('a.kode_group', 'LAB');
        $this->db2->where('date(a.create_date)', $yesterday);
        $this->db2->group_by('a.kode_tindakan');
        return $this->db2->get()->result();
    }

    function get_count_layanan_lab_sampel()
    {
        $yesterday = date('Y-m-d', strtotime("-1 days"));

        $this->db2->select('COUNT(DISTINCT a.no_order) as ttl');
        $this->db2->from('zx_t_bill a');
        $this->db2->join('zx_hasil_lab b', 'a.no_order = b.no_order');
        $this->db2->where('a.kode_group', 'LAB');
        $this->db2->where('date(a.create_date)', $yesterday);
        return $this->db2->get()->row();
    }

    function get_count_layanan_rad()
    {
        $yesterday = date('Y-m-d', strtotime("-1 days"));

        $this->db2->select('COUNT(DISTINCT a.noreg) as ttl');
        $this->db2->from('zx_t_bill a');
        $this->db2->join('zx_t_radiologi_order b', 'a.noreg = b.PATIENT_UID');
        $this->db2->where('a.kode_group', 'RAD');
        $this->db2->where('date(a.create_date)', $yesterday);
        return $this->db2->get()->result();
    }
}

/* End of file T_kes_lay_pasien_rajal_model.php */
/* Location: ./application/models/T_kes_lay_pasien_rajal_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-04-12 08:25:44 */
/* http://harviacode.com */