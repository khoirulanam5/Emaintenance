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
        $this->db->where('tb_service.id_supir', $this->session->userdata('id_supir'));
        $data['service'] = $this->db->get()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('supir/service', $data);
        $this->load->view('template/footer');
    }

    public function generateKode(){
        $unik = 'SVC';
        $kode = $this->db->query("SELECT MAX(kode) LAST_NO FROM tb_service WHERE kode LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 3, 6);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%06s", $urutan);
        return $kode;
    }

    public function generateIdService(){
        $unik = 'SR';
        $kode = $this->db->query("SELECT MAX(id_service) LAST_NO FROM tb_service WHERE id_service LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 2, 3);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%03s", $urutan);
        return $kode;
      }

    public function add() {
        $data['title'] = 'Tambah Service Kendaraan';
        
        $this->db->select('tb_aset_kendaraan.*, tb_kendaraan.*');
        $this->db->from('tb_aset_kendaraan');
        $this->db->join('tb_kendaraan', 'tb_aset_kendaraan.no_polisi = tb_kendaraan.no_polisi');
        $this->db->where('tb_kendaraan.is_ready', 1);
        $data['kendaraan'] = $this->db->get()->result();
        
        $this->db->select('tb_supir.*, tb_user.*');
        $this->db->from('tb_supir');
        $this->db->join('tb_user', 'tb_supir.id_user = tb_user.id_user');
        $this->db->where('tb_supir.is_ready', 1);
        $data['supir'] = $this->db->get()->result();

        $this->db->select('tb_teknisi.*, tb_user.*');
        $this->db->from('tb_teknisi');
        $this->db->join('tb_user', 'tb_teknisi.id_user = tb_user.id_user');
        $this->db->where('tb_teknisi.is_ready', 1);
        $data['teknisi'] = $this->db->get()->result();

        $this->form_validation->set_rules('id_kendaraan', 'ID Kendaraan', 'required');
        $this->form_validation->set_rules('uraian', 'Uraian', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('supir/tambah_service', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'id_service' => $this->generateIdService(),
                'id_kendaraan' => $this->input->post('id_kendaraan'),
                'id_supir' => $this->session->userdata('id_supir'),
                'kode' => $this->generateKode(),
                'uraian' => $this->input->post('uraian'),
                'tgl_service' => date('Y-m-d H:i:s')
            ];
            $insert = $this->db->insert('tb_service', $data);

            if ($insert) {

                // Cari no_polisi dari tabel tb_aset_kendaraan berdasarkan id_kendaraan
                $this->db->select('no_polisi');
                $this->db->from('tb_aset_kendaraan');
                $this->db->where('id_kendaraan', $this->input->post('id_kendaraan'));
                $result = $this->db->get()->row();

                if ($result) {
                    // Update is_ready di tb_kendaraan berdasarkan no_polisi
                    $this->db->set('is_ready', 0);
                    $this->db->where('no_polisi', $result->no_polisi);
                    $this->db->update('tb_kendaraan');
                }

                // Update is_ready di tb_supir
                $this->db->set('is_ready', 0);
                $this->db->where('id_supir', $id_supir);
                $this->db->update('tb_supir');

                $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data kendaraan akan di service', icon:'success'})</script>");
            } else {
                $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Maaf', text:'Gagal saat menginput data', icon:'warning'})</script>");
            }
            redirect('supir/service');
        }
    }

        public function delete($id_service) {
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
        
            // Hapus data service dari tabel tb_service
            $this->db->where('id_service', $id_service);
            $delete = $this->db->delete('tb_service');
        
            if ($delete) {
                $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data Service berhasil dihapus', icon:'success'})</script>");
            } else {
                $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Gagal', text:'Terjadi kesalahan saat menghapus data', icon:'error'})</script>");
            }
            redirect('supir/service');
        }
    }