<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Message;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T_kes_senddata_model extends CI_Model
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
            'https://bios.kemenkeu.go.id/api/token',
            [
                'form_params' => [
                    'satker' => '415670',
                    'key' => 'RzMss9waUcqzeCJ3D4PNYbCGfmq3ojdv'
                ]
            ]
        )->getBody()->getContents();
        $token = (json_decode($response, true));
        $get_token = $token['token'];

        $this->_client = new Client([
            'base_uri' => 'https://bios.kemenkeu.go.id/api/ws/',
            'headers' => [
                'Token' => $get_token,
            ]
        ]);
    }

    function insert_data($data)
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

    function get_count()
    {
        $date_from = date('Y-m-d', strtotime("-1 days"));
        $date_to = date('Y-m-d', strtotime("-1 days"));

        $this->db2->select('date(a.create_date) as create_date,COUNT(DISTINCT a.no_order) as ttl,a.nama_tindakan');
        $this->db2->from('zx_t_bill a');
        $this->db2->join('zx_hasil_lab b', 'a.no_order = b.no_order');
        $this->db2->where('a.kode_group', 'LAB');
        $this->db2->where('date(a.create_date) >=', $date_from);
        $this->db2->where('date(a.create_date) <=', $date_to);
        $this->db2->group_by('date(a.create_date),a.kode_tindakan');
        return $this->db2->get()->result();
    }
}

/* End of file T_kes_lay_pasien_rajal_model.php */
/* Location: ./application/models/T_kes_lay_pasien_rajal_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-04-12 08:25:44 */
/* http://harviacode.com */