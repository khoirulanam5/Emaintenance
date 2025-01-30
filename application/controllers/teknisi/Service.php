<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function index() {
        $data['title'] = 'Data Service Kendaraan';
        
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
        $this->db->where('tb_service.id_teknisi', $this->session->userdata('id_teknisi'));
        $this->db->where('tb_service.status', NULL);
        $data['service'] =  $this->db->get()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('teknisi/service', $data);
        $this->load->view('template/footer');
    }

    public function edit($id_service) {
        $data['title'] = 'Edit Service Kendaraan';
    
        // Ambil data service berdasarkan id_service
        $this->db->select('tb_service.*, tb_aset_kendaraan.id_kendaraan, tb_supir.id_supir, tb_teknisi.id_teknisi');
        $this->db->from('tb_service');
        $this->db->join('tb_aset_kendaraan', 'tb_service.id_kendaraan = tb_aset_kendaraan.id_kendaraan', 'LEFT');
        $this->db->join('tb_supir', 'tb_service.id_supir = tb_supir.id_supir', 'LEFT');
        $this->db->join('tb_teknisi', 'tb_service.id_teknisi = tb_teknisi.id_teknisi', 'LEFT');
        $this->db->where('tb_service.id_service', $id_service);
        $data['service'] = $this->db->get()->row();
    
        if (!$data['service']) {
            $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Gagal', text:'Data tidak ditemukan', icon:'error'})</script>");
            redirect('teknisi/service');
        }
    
        // Ambil data kendaraan yang ready
        $this->db->select('tb_aset_kendaraan.*, tb_kendaraan.*');
        $this->db->from('tb_aset_kendaraan');
        $this->db->join('tb_kendaraan', 'tb_aset_kendaraan.no_polisi = tb_kendaraan.no_polisi');
        $this->db->where('tb_kendaraan.is_ready', 1);
        $data['kendaraan'] = $this->db->get()->result();
    
        // Ambil data supir yang ready
        $this->db->select('tb_supir.*, tb_user.*');
        $this->db->from('tb_supir');
        $this->db->join('tb_user', 'tb_supir.id_user = tb_user.id_user');
        $this->db->where('tb_supir.is_ready', 1);
        $data['supir'] = $this->db->get()->result();
    
        // Ambil data teknisi yang ready
        $this->db->select('tb_teknisi.*, tb_user.*');
        $this->db->from('tb_teknisi');
        $this->db->join('tb_user', 'tb_teknisi.id_user = tb_user.id_user');
        $this->db->where('tb_teknisi.is_ready', 1);
        $data['teknisi'] = $this->db->get()->result();
    
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
            $no_polisi = $this->db->select('no_polisi')->from('tb_aset_kendaraan')->where('id_kendaraan', $old_service->id_kendaraan)->get()->row()->no_polisi;

            if ($no_polisi) {
            // Update kolom is_ready di tabel tb_kendaraan berdasarkan no_polisi
            $this->db->set('is_ready', 1);
            $this->db->where('no_polisi', $no_polisi);
            $this->db->update('tb_kendaraan');
            }
    
            $this->db->set('is_ready', 1);
            $this->db->where('id_supir', $old_service->id_supir);
            $this->db->update('tb_supir');
    
            $this->db->set('is_ready', 1);
            $this->db->where('id_teknisi', $old_service->id_teknisi);
            $this->db->update('tb_teknisi');
    
            // Update data service
            $data_update = [
                'id_kendaraan' => $this->input->post('id_kendaraan'),
                'id_supir' => $this->input->post('id_supir'),
                'id_teknisi' => $this->input->post('id_teknisi'),
                'uraian' => $this->input->post('uraian'),
                'tgl_service' => $this->input->post('tgl_service'),
                'tgl_setelah_service' => $this->input->post('tgl_setelah_service')
            ];
            $this->db->where('id_service', $id_service);
            $update = $this->db->update('tb_service', $data_update);
    
            if ($update) {
                // Update is_ready untuk kendaraan, supir, dan teknisi yang baru
                // Ambil no_polisi berdasarkan id_kendaraan dari input
                $no_polisi = $this->db->select('no_polisi')->from('tb_aset_kendaraan')->where('id_kendaraan', $this->input->post('id_kendaraan'))->get()->row()->no_polisi;

                if ($no_polisi) {
                // Update is_ready menjadi 0 di tabel tb_kendaraan berdasarkan no_polisi
                $this->db->set('is_ready', 0);
                $this->db->where('no_polisi', $no_polisi);
                $this->db->update('tb_kendaraan');
                }
    
                $this->db->set('is_ready', 0);
                $this->db->where('id_supir', $this->input->post('id_supir'));
                $this->db->update('tb_supir');
    
                $this->db->set('is_ready', 0);
                $this->db->where('id_teknisi', $this->input->post('id_teknisi'));
                $this->db->update('tb_teknisi');
    
                $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data service berhasil diupdate', icon:'success'})</script>");
            } else {
                $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Gagal', text:'Terjadi kesalahan saat mengupdate data', icon:'error'})</script>");
            }
            redirect('teknisi/service');
        }
    }    

    public function end($id_service) {
        // Ambil data id_kendaraan, id_supir, dan id_teknisi dari tb_service berdasarkan id_service
        $this->db->select('id_kendaraan, id_supir, id_teknisi');
        $this->db->from('tb_service');
        $this->db->where('id_service', $id_service);
        $service_data = $this->db->get()->row();
    
        if ($service_data) {

            // Update is_ready menjadi 1 di tabel tb_kendaraan
            $this->db->select('no_polisi');
            $this->db->from('tb_aset_kendaraan');
            $this->db->where('id_kendaraan', $service_data->id_kendaraan);
            $kendaraan = $this->db->get()->row();
            if ($kendaraan) {
                $this->db->set('is_ready', 1);
                $this->db->where('no_polisi', $kendaraan->no_polisi);
                $this->db->update('tb_kendaraan');
            }
    
            // Update is_ready menjadi 1 di tabel tb_teknisi
            $this->db->set('is_ready', 1);
            $this->db->where('id_teknisi', $service_data->id_teknisi);
            $this->db->update('tb_teknisi');
    
            // Update is_ready menjadi 1 di tabel tb_supir
            $this->db->set('is_ready', 1);
            $this->db->where('id_supir', $service_data->id_supir);
            $this->db->update('tb_supir');
        }
    
        $this->db->set('status', 'Selesai');
        $this->db->where('id_service', $id_service);
        $end = $this->db->update('tb_service');
    
        if ($end) {
            $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Horee!!', text:'Kendaraan sudah diperbaiki dan siap di operasikan kembali', icon:'success'})</script>");
        } else {
            $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Gagal', text:'Terjadi kesalahan', icon:'error'})</script>");
        }
        redirect('teknisi/service');
    }
}