<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RiwayatService extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function index() {
        $data['title'] = 'Riwayat Service Kendaraan';

        $this->db->select('
        tb_service.*,
        tb_aset_kendaraan.*,
        tb_kendaraan.*,
        teknisi_user.nama AS nama_teknisi,
        supir_user.nama AS nama_supir
        ');
        $this->db->from('tb_service');
        $this->db->join('tb_aset_kendaraan', 'tb_service.id_kendaraan = tb_aset_kendaraan.id_kendaraan', 'LEFT');
        $this->db->join('tb_kendaraan', 'tb_aset_kendaraan.no_polisi = tb_kendaraan.no_polisi', 'LEFT');
        $this->db->join('tb_teknisi', 'tb_service.id_teknisi = tb_teknisi.id_teknisi', 'LEFT');
        $this->db->join('tb_supir', 'tb_service.id_supir = tb_supir.id_supir', 'LEFT');
        $this->db->join('tb_user AS teknisi_user', 'tb_teknisi.id_user = teknisi_user.id_user', 'LEFT');
        $this->db->join('tb_user AS supir_user', 'tb_supir.id_user = supir_user.id_user', 'LEFT');
        $this->db->where('tb_service.status', 'Selesai');
        $data['riwayat'] =  $this->db->get()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/riwayat_service', $data);
        $this->load->view('template/footer');
    }

    public function print() {
        $this->db->select('
        tb_service.*,
        tb_aset_kendaraan.*,
        tb_kendaraan.*,
        teknisi_user.nama AS nama_teknisi,
        supir_user.nama AS nama_supir
        ');
        $this->db->from('tb_service');
        $this->db->join('tb_aset_kendaraan', 'tb_service.id_kendaraan = tb_aset_kendaraan.id_kendaraan', 'LEFT');
        $this->db->join('tb_kendaraan', 'tb_aset_kendaraan.no_polisi = tb_kendaraan.no_polisi', 'LEFT');
        $this->db->join('tb_teknisi', 'tb_service.id_teknisi = tb_teknisi.id_teknisi', 'LEFT');
        $this->db->join('tb_supir', 'tb_service.id_supir = tb_supir.id_supir', 'LEFT');
        $this->db->join('tb_user AS teknisi_user', 'tb_teknisi.id_user = teknisi_user.id_user', 'LEFT');
        $this->db->join('tb_user AS supir_user', 'tb_supir.id_user = supir_user.id_user', 'LEFT');
        $this->db->where('tb_service.status', 'Selesai');
        $data['riwayat'] =  $this->db->get()->result();

        $this->load->view('admin/print', $data);
    }
}