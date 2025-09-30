<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['ServiceModel', 'AsetModel', 'KendaraanModel', 'SupirModel', 'TeknisiModel']);
        issupir();
    }

    public function index() {
        $data['title'] = 'Data Service Kendaraan';
        $data['service'] = $this->ServiceModel->getSupir()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('supir/service', $data);
        $this->load->view('template/footer');
    }

    public function add() {
        $data['title'] = 'Tambah Service Kendaraan';
        $data['kendaraan'] = $this->AsetModel->getReady()->result();

        $this->form_validation->set_rules('id_kendaraan', 'ID Kendaraan', 'required');
        $this->form_validation->set_rules('uraian', 'Uraian', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('supir/tambah_service', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'id_service' => $this->ServiceModel->generateId(),
                'id_kendaraan' => $this->input->post('id_kendaraan'),
                'id_supir' => $this->session->userdata('id_supir'),
                'kode' => $this->ServiceModel->generateKode(),
                'uraian' => $this->input->post('uraian'),
                'tgl_service' => date('Y-m-d H:i:s')
            ];
            $save = $this->ServiceModel->save($data);

            if ($save) {
                // Cari no_polisi dari tabel tb_aset_kendaraan berdasarkan id_kendaraan
                $result = $this->AsetModel->getByNopol()->row();

                if ($result) {
                    // Update is_ready di tb_kendaraan berdasarkan no_polisi
                    $this->KendaraanModel->NotReady($result->no_polisi);
                }
                // Update is_ready di tb_supir
                $this->SupirModel->nonactive($id_supir);

                $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data kendaraan akan di service', icon:'success'})</script>");
            } else {
                $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Maaf', text:'Gagal saat menginput data', icon:'warning'})</script>");
            }
            redirect('supir/service');
        }
    }

        public function delete($id_service) {
            // Ambil data id_kendaraan, id_supir, dan id_teknisi dari tb_service berdasarkan id_service
            $service = $this->ServiceModel->getId($id_service)->row();
        
            if ($service) {
                // Update is_ready menjadi 1 di tabel tb_kendaraan
                $kendaraan = $this->AsetModel->getNoPolisiByIdKendaraan($service->id_kendaraan)->row();

                if ($kendaraan) {
                    $this->KendaraanModel->update($kendaraan->no_polisi);
                }
        
                // Update is_ready menjadi 1 di tabel tb_teknisi
                $this->TeknisiModel->update($service->id_teknisi);
        
                // Update is_ready menjadi 1 di tabel tb_supir
                $this->SupirModel->update($service->id_supir);
            }
        
            // Hapus data service dari tabel tb_service
            $delete = $this->ServiceModel->delete($id_service);
        
            if ($delete) {
                $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data Service berhasil dihapus', icon:'success'})</script>");
            } else {
                $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Gagal', text:'Terjadi kesalahan saat menghapus data', icon:'error'})</script>");
            }
            redirect('supir/service');
        }
    }