<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['ServiceModel', 'AsetModel', 'KendaraanModel', 'TeknisiModel', 'SupirModel']);
        isteknisi();
    }

    public function index() {
        $data['title'] = 'Data Service Kendaraan';
        $data['service'] =  $this->ServiceModel->getTeknisi()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('teknisi/service', $data);
        $this->load->view('template/footer');
    }

    public function edit($id_service) {
        $data['title'] = 'Edit Service Kendaraan';
    
        // Ambil data service berdasarkan id_service
        $data['service'] = $this->ServiceModel->getById($id_service)->row();
    
        if (!$data['service']) {
            $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Gagal', text:'Data tidak ditemukan', icon:'error'})</script>");
            redirect('teknisi/service');
        }
    
        // Ambil data kendaraan yang ready
        $data['kendaraan'] = $this->AsetModel->getReady()->result();
    
        // Ambil data supir yang ready
        $data['supir'] = $this->SupirModel->getReady()->result();
    
        // Ambil data teknisi yang ready
        $data['teknisi'] = $this->TeknisiModel->getReady()->result();
    
        // Validasi form
        $this->form_validation->set_rules('uraian', 'Uraian', 'required');
        $this->form_validation->set_rules('tgl_setelah_service', 'Tanggal Service Selesai', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('teknisi/edit_service', $data);
            $this->load->view('template/footer');
        } else {
            $old_service = $data['service'];
            // Ambil no_polisi berdasarkan id_kendaraan dari tabel tb_aset_kendaraan
            $no_polisi = $this->AsetModel->getByNoPolisi($old_service->id_kendaraan)->row()->no_polisi;

            if ($no_polisi) {
            // Update kolom is_ready di tabel tb_kendaraan berdasarkan no_polisi
            $this->KendaraanModel->update($no_polisi);
            }
            // Update supir
            $this->SupirModel->update($old_service->id_supir);
            // Update teknisi
            $this->TeknisiModel->update($old_service->id_teknisi);
    
            // Update data service
            $data = [
                'id_kendaraan' => $this->input->post('id_kendaraan'),
                'id_supir' => $this->input->post('id_supir'),
                'id_teknisi' => $this->input->post('id_teknisi'),
                'uraian' => $this->input->post('uraian'),
                'tgl_service' => $this->input->post('tgl_service'),
                'tgl_setelah_service' => $this->input->post('tgl_setelah_service')
            ];
            $update = $this->ServiceModel->edit($id_service, $data);
    
            if ($update) {
                // Ambil no_polisi berdasarkan id_kendaraan dari input
                $no_polisi = $this->AsetModel->getByNopol()->row()->no_polisi;

                if ($no_polisi) {
                // Update is_ready menjadi 0 di tabel tb_kendaraan berdasarkan no_polisi
                $this->KendaraanModel->NotReady($no_polisi);
                }
                // Update supir
                $this->SupirModel->NotReady();
                // Update teknisi
                $this->TeknisiModel->NotReady();
    
                $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data service berhasil diupdate', icon:'success'})</script>");
            } else {
                $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Gagal', text:'Terjadi kesalahan saat mengupdate data', icon:'error'})</script>");
            }
            redirect('teknisi/service');
        }
    }    

    public function end($id_service) {
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
    
        // Update status di tabel service
        $end = $this->ServiceModel->end($id_service);
    
        if ($end) {
            $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Horee!!', text:'Kendaraan sudah diperbaiki dan siap di operasikan kembali', icon:'success'})</script>");
        } else {
            $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Gagal', text:'Terjadi kesalahan', icon:'error'})</script>");
        }
        redirect('teknisi/service');
    }
}