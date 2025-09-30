<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title'] = 'Dashboard';
        $data['service'] = count($this->db->get('tb_service')->result());
        $data['kendaraan'] = count($this->db->get('tb_kendaraan')->result());
        $data['teknisi'] = count($this->db->get('tb_teknisi')->result());
        $data['supir'] = count($this->db->get('tb_supir')->result());

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('dashboard', $data);
        $this->load->view('template/footer');
    }
}