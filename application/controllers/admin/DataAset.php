<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataAset extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function index() {
        $data['title'] = 'Data Aset Kendaraan';
        $data['aset'] = $this->db->get('tb_aset_kendaraan')->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/data_aset', $data);
        $this->load->view('template/footer');
    }

    public function generateIdKendaraan(){
        $unik = 'KD';
        $kode = $this->db->query("SELECT MAX(id_kendaraan) LAST_NO FROM tb_aset_kendaraan WHERE id_kendaraan LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 2, 3);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%03s", $urutan);
        return $kode;
      }

    public function generateIdAset(){
        $unik = 'AST';
        $kode = $this->db->query("SELECT MAX(no_aset) LAST_NO FROM tb_aset_kendaraan WHERE no_aset LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 3, 3);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%03s", $urutan);
        return $kode;
      }

    public function add() {
        $data['title'] = 'Tambah Aset Kendaraan';
        $data['kendaraan'] = $this->db->get('tb_kendaraan')->result();

        $this->form_validation->set_rules('no_polisi', 'Nomer Polisi', 'required|is_unique[tb_aset_kendaraan.no_polisi]');
        $this->form_validation->set_rules('no_rangka', 'Nomer Rangka', 'required|is_unique[tb_aset_kendaraan.no_rangka]');
        $this->form_validation->set_rules('no_mesin', 'Nomer Mesin', 'required|is_unique[tb_aset_kendaraan.no_mesin]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('admin/tambah_aset', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'id_kendaraan' => $this->generateIdKendaraan(),
                'no_aset' => $this->generateIdAset(),
                'no_polisi' => $this->input->post('no_polisi'),
                'no_rangka' => $this->input->post('no_rangka'),
                'no_mesin' => $this->input->post('no_mesin'),
                'masa_pajak' => $this->input->post('masa_pajak'),
                'masa_stnk' => $this->input->post('masa_stnk'),
                'masa_asuransi' => $this->input->post('masa_asuransi'),
                'tgl_service_rutin' => $this->input->post('tgl_service_rutin'),
                'thn_pembuatan' => $this->input->post('thn_pembuatan'),
                'thn_pengadaan' => $this->input->post('thn_pengadaan')
            ];
            $insert = $this->db->insert('tb_aset_kendaraan', $data);
            if ($insert) {
                $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data aset kendaraan berhasil ditambahkan', icon:'success'})</script>");
            } else {
                $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Gagal', text:'Data aset kendaraan gagal ditambahkan', icon:'danger'})</script>");
            }
            redirect('admin/dataaset');
        }
    }

    public function edit($id_kendaraan) {
        $data['title'] = 'Edit Aset Kendaraan';
        $data['aset'] = $this->db->get_where('tb_aset_kendaraan', ['id_kendaraan' => $id_kendaraan])->result();
        $data['kendaraan'] = $this->db->get('tb_kendaraan')->result();
    
        // Tambahkan validasi form
        $this->form_validation->set_rules('no_aset', 'Nomer Aset', 'required');
        $this->form_validation->set_rules('no_polisi', 'Nama Kendaraan', 'required');
        $this->form_validation->set_rules('no_rangka', 'Nomer Rangka', 'required');
        $this->form_validation->set_rules('no_mesin', 'Nomer Mesin', 'required');
        $this->form_validation->set_rules('masa_pajak', 'Masa Pajak', 'required');
        $this->form_validation->set_rules('masa_stnk', 'Masa STNK', 'required');
        $this->form_validation->set_rules('masa_asuransi', 'Masa Asuransi', 'required');
        $this->form_validation->set_rules('tgl_service_rutin', 'Tanggal Service Rutin', 'required|integer');
        $this->form_validation->set_rules('thn_pembuatan', 'Tahun Pembuatan', 'required');
        $this->form_validation->set_rules('thn_pengadaan', 'Tahun Pengadaan', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('admin/edit_aset', $data);
            $this->load->view('template/footer');
        } else {
            $id_kendaraan = $this->input->post('id_kendaraan');
    
            $data = [
                'id_kendaraan' => $id_kendaraan,
                'no_aset' => $this->input->post('no_aset'),
                'no_polisi' => $this->input->post('no_polisi'),
                'no_rangka' => $this->input->post('no_rangka'),
                'no_mesin' => $this->input->post('no_mesin'),
                'masa_pajak' => $this->input->post('masa_pajak'),
                'masa_stnk' => $this->input->post('masa_stnk'),
                'masa_asuransi' => $this->input->post('masa_asuransi'),
                'tgl_service_rutin' => $this->input->post('tgl_service_rutin'),
                'thn_pembuatan' => $this->input->post('thn_pembuatan'),
                'thn_pengadaan' => $this->input->post('thn_pengadaan')
            ];
    
            $this->db->where('id_kendaraan', $id_kendaraan);
            $update = $this->db->update('tb_aset_kendaraan', $data);
    
            if ($update) {
                $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data aset kendaraan berhasil diupdate', icon:'success'})</script>");
            } else {
                $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Gagal', text:'Data aset kendaraan gagal diupdate', icon:'error'})</script>");
            }
            redirect('admin/dataaset');
        }
    }
    
    public function detail($id_kendaraan) {
        $data['title'] = 'Detail Aset Kendaraan';
        $this->db->select('tb_aset_kendaraan.*, tb_kendaraan.*');
        $this->db->from('tb_aset_kendaraan');
        $this->db->join('tb_kendaraan', 'tb_aset_kendaraan.no_polisi = tb_kendaraan.no_polisi');
        $this->db->where('tb_aset_kendaraan.id_kendaraan', $id_kendaraan);
        $data['aset'] = $this->db->get()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/detail_aset', $data);
        $this->load->view('template/footer');
    }

    public function delete($id_kendaraan) {
        $this->db->where('id_kendaraan', $id_kendaraan);
        $this->db->delete('tb_aset_kendaraan');
        $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data aset kendaraan berhasil dihapus', icon:'success'})</script>");
        redirect('admin/dataaset');
    }
}