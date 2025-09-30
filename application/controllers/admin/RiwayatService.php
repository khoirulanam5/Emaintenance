<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RiwayatService extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['ServiceModel']);
        isadmin();
    }

    public function index() {
        $data['title'] = 'Riwayat Service Kendaraan';
        $data['riwayat'] =  $this->ServiceModel->getHistory()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/riwayat_service', $data);
        $this->load->view('template/footer');
    }

    public function print() {
        $data['riwayat'] =  $this->ServiceModel->getHistory()->result();

        $this->load->view('admin/print', $data);
    }
}