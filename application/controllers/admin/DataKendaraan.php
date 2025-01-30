<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataKendaraan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function index() {
        $data['title'] = "Data Kendaraan";
        $data['kendaraan'] = $this->db->get('tb_kendaraan')->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/data_kendaraan', $data);
        $this->load->view('template/footer');
    }

    public function generateNoPol(){
        $unik = 'POL';
        $kode = $this->db->query("SELECT MAX(no_polisi) LAST_NO FROM tb_kendaraan WHERE no_polisi LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 3, 6);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%06s", $urutan);
        return $kode;
      }

    public function add() {
        $this->form_validation->set_rules('no_polisi', 'Nomer Polisi', 'required');
        $this->form_validation->set_rules('merk', 'Merk', 'required');
        $this->form_validation->set_rules('type', 'Type', 'required');
        $this->form_validation->set_rules('is_ready', 'is_ready', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Maaf', text:'Ada yang salah, Periksa inputan kembali', icon:'warning'})</script>");
            redirect('admin/datakendaraan');
        } else {

            // Konfigurasi upload
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/img/kendaraan/';
            $this->load->library('upload', $config);
            $this->upload->do_upload('foto');
            $image = $this->upload->data('file_name');

            $data = [
                'no_polisi' => $this->input->post('no_polisi'),
                'merk' => $this->input->post('merk'),
                'type' => $this->input->post('type'),
                'foto' => $image,
                'is_ready' => $this->input->post('is_ready')
            ];
            $this->db->insert('tb_kendaraan', $data);
            $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data kendaraan berhasil ditambahkan', icon:'success'})</script>");
            redirect('admin/datakendaraan');
        }
    }
    
    public function edit($no_polisi) {
        $this->form_validation->set_rules('merk', 'Merk', 'required');
        $this->form_validation->set_rules('type', 'Type', 'required');
        $this->form_validation->set_rules('is_ready', 'is_ready', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Maaf', text:'Ada yang salah, Periksa inputan kembali', icon:'warning'})</script>");
            redirect('admin/datakendaraan');
        } else {
            $no_polisi = $this->input->post('no_polisi');

            // Konfigurasi upload
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/img/kendaraan/';
            $this->load->library('upload', $config);
            $this->upload->do_upload('foto');
            $image = $this->upload->data('file_name');

            $data = [
                'no_polisi' => $no_polisi,
                'merk' => $this->input->post('merk'),
                'type' => $this->input->post('type'),
                'foto' => $image,
                'is_ready' => $this->input->post('is_ready')
            ];
            $this->db->where('no_polisi', $no_polisi);
            $this->db->update('tb_kendaraan', $data);

            $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data kendaraan berhasil diupdate', icon:'success'})</script>");
            redirect('admin/datakendaraan');
        }
    }

    public function delete($no_polisi) {
        $this->db->where('no_polisi', $no_polisi);
        $this->db->delete('tb_kendaraan');
        $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data kendaraan berhasil dihapus', icon:'success'})</script>");
        redirect('admin/datakendaraan');
    }
}