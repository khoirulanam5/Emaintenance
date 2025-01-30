<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataTeknisi extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function index() {
        $data['title'] = 'Data Teknisi';
        $this->db->select('tb_teknisi.*, tb_user.*');
        $this->db->from('tb_teknisi');
        $this->db->join('tb_user', 'tb_teknisi.id_user = tb_user.id_user');
        $data['teknisi'] = $this->db->get()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/data_teknisi', $data);
        $this->load->view('template/footer');
    }

    public function generateIdTeknisi(){
        $unik = 'TK';
        $kode = $this->db->query("SELECT MAX(id_teknisi) LAST_NO FROM tb_teknisi WHERE id_teknisi LIKE '".$unik."%'")->row()->LAST_NO;
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
            redirect('admin/datateknisi');
        } else {
            $user = [
                'id_user' => $this->generateIdUser(), 
                'nama' => $this->input->post('nama'),
                'no_hp' => $this->input->post('no_hp'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'role' => 'teknisi'
            ];
            $this->db->insert('tb_user', $user);

            $id_user = $user['id_user'];

            $teknisi = [
                'id_teknisi' => $this->generateIdTeknisi(),
                'id_user' => $id_user,
                'is_ready' => $this->input->post('is_ready')
            ];
            $this->db->insert('tb_teknisi', $teknisi);

            $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data teknisi berhasil ditambahkan', icon:'success'})</script>");
            redirect('admin/datateknisi');
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
            redirect('admin/datateknisi');
        } else {
            $id = $this->input->post('id_user');

            $user = [
                'nama' => $this->input->post('nama'),
                'no_hp' => $this->input->post('no_hp'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'role' => 'teknisi'
            ];
            $this->db->where('id_user', $id);
            $this->db->update('tb_user', $user);

            $teknisi = [
                'id_user' => $id,
                'is_ready' => $this->input->post('is_ready')
            ];
            $this->db->where('id_user', $id);
            $this->db->update('tb_teknisi', $teknisi);

            $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data teknisi berhasil diupdate', icon:'success'})</script>");
            redirect('admin/datateknisi');
        }
    }

    public function delete($id_user) {
        $this->db->trans_start();
        $this->db->where('id_teknisi', $id_user);
        $this->db->delete('tb_teknisi');
    
        $this->db->where('id_user', $id_user);
        $this->db->delete('tb_user');
        $this->db->trans_complete();
    
        if ($this->db->trans_status() == FALSE) {
            $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Gagal', text:'Data teknisi gagal dihapus', icon:'error'})</script>");
        } else {
            $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data teknisi berhasil dihapus', icon:'success'})</script>");
        }
        redirect('admin/datateknisi');
    }
}