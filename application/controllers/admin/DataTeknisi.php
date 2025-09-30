<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataTeknisi extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['UserModel', 'TeknisiModel']);
        isadmin();
    }

    public function index() {
        $data['title'] = 'Data Teknisi';
        $data['teknisi'] = $this->TeknisiModel->getAll()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/data_teknisi', $data);
        $this->load->view('template/footer');
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
            $data = [
                'id_user' => $this->UserModel->generateId(), 
                'nama' => $this->input->post('nama'),
                'no_hp' => $this->input->post('no_hp'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'role' => 'teknisi'
            ];
            $this->UserModel->save($data);
            $id_user = $data['id_user'];

            $teknisi = [
                'id_teknisi' => $this->TeknisiModel->generateId(),
                'id_user' => $id_user,
                'is_ready' => $this->input->post('is_ready')
            ];
            $this->TeknisiModel->save($teknisi);

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
            $data = [
                'nama' => $this->input->post('nama'),
                'no_hp' => $this->input->post('no_hp'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'role' => 'teknisi'
            ];
            $this->UserModel->edit($id_user, $data);

            $teknisi = [
                'id_user' => $id_user,
                'is_ready' => $this->input->post('is_ready')
            ];
            $this->TeknisiModel->edit($id_user, $teknisi);

            $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data teknisi berhasil diupdate', icon:'success'})</script>");
            redirect('admin/datateknisi');
        }
    }

    public function delete($id_user) {
        $this->TeknisiModel->delete($id_user);
    
        $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data teknisi berhasil dihapus', icon:'success'})</script>");
        redirect('admin/datateknisi');
    }
}