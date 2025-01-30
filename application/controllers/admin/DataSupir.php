<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataSupir extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function index() {
        $data['title'] = 'Data Supir';
        $this->db->select('tb_supir.*, tb_user.*');
        $this->db->from('tb_supir');
        $this->db->join('tb_user', 'tb_supir.id_user = tb_user.id_user');
        $data['supir'] = $this->db->get()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/data_supir', $data);
        $this->load->view('template/footer');
    }

    public function generateIdSupir(){
        $unik = 'SP';
        $kode = $this->db->query("SELECT MAX(id_supir) LAST_NO FROM tb_supir WHERE id_supir LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 2, 3);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%03s", $urutan);
        return $kode;
      }

    public function generateIdUser(){
        $unik = 'US';
        $kode = $this->db->query("SELECT MAX(id_user) LAST_NO FROM tb_user WHERE id_user LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 2, 3);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%03s", $urutan);
        return $kode;
      }

    public function add() {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('no_hp', 'Nomer HP', 'required|is_unique[tb_user.no_hp]');
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[tb_user.username]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('is_ready', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Maaf', text:'Username sudah digunakan', icon:'warning'})</script>");
            redirect('admin/datasupir');
        } else {
            $user = [
                'id_user' => $this->generateIdUser(),
                'nama' => $this->input->post('nama'),
                'no_hp' => $this->input->post('no_hp'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'role' => 'supir'
            ];
            $this->db->insert('tb_user', $user);

            $id_user = $user['id_user'];

            $supir = [
                'id_supir' => $this->generateIdSupir(),
                'id_user' => $id_user,
                'is_ready' => $this->input->post('is_ready')
            ];
            $this->db->insert('tb_supir', $supir);

            $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data supir berhasil ditambahkan', icon:'success'})</script>");
            redirect('admin/datasupir');
        }
    }

    public function edit($id_user) {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('no_hp', 'Nomer HP', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('is_ready', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Maaf', text:'Username sudah digunakan', icon:'warning'})</script>");
            redirect('admin/datasupir');
        } else {
            $id = $this->input->post('id_user');

            $user = [
                'nama' => $this->input->post('nama'),
                'no_hp' => $this->input->post('no_hp'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'role' => 'supir'
            ];
            $this->db->where('id_user', $id);
            $this->db->update('tb_user', $user);

            $supir = [
                'id_user' => $id,
                'is_ready' => $this->input->post('is_ready')
            ];
            $this->db->where('id_user', $id);
            $this->db->update('tb_supir', $supir);

            $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data supir berhasil diupdate', icon:'success'})</script>");
            redirect('admin/datasupir');
        }
    }

    public function delete($id_user) {
        $this->db->trans_start();
        $this->db->where('id_supir', $id_user);
        $this->db->delete('tb_supir');
    
        $this->db->where('id_user', $id_user);
        $this->db->delete('tb_user');
        $this->db->trans_complete();
    
        if ($this->db->trans_status() == FALSE) {
            $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Gagal', text:'Data supir gagal dihapus', icon:'error'})</script>");
        } else {
            $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data supir berhasil dihapus', icon:'success'})</script>");
        }
        redirect('admin/datasupir');
    }
}