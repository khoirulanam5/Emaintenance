<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataSupir extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['UserModel', 'SupirModel']);
        isadmin();
    }

    public function index() {
        $data['title'] = 'Data Supir';
        $data['supir'] = $this->SupirModel->getAll()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('admin/data_supir', $data);
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
            redirect('admin/datasupir');
        } else {
            $data = [
                'id_user' => $this->UserModel->generateId(),
                'nama' => $this->input->post('nama'),
                'no_hp' => $this->input->post('no_hp'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'role' => 'supir'
            ];
            $this->UserModel->save($data);
            $id_user = $data['id_user'];

            $supir = [
                'id_supir' => $this->SupirModel->generateId(),
                'id_user' => $id_user,
                'is_ready' => $this->input->post('is_ready')
            ];
            $this->SupirModel->save($supir);

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
            $data = [
                'nama' => $this->input->post('nama'),
                'no_hp' => $this->input->post('no_hp'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'role' => 'supir'
            ];
            $this->UserModel->edit($id_user, $data);

            $supir = [
                'id_user' => $id_user,
                'is_ready' => $this->input->post('is_ready')
            ];
            $this->SupirModel->edit($id_user, $supir);

            $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data supir berhasil diupdate', icon:'success'})</script>");
            redirect('admin/datasupir');
        }
    }

    public function delete($id_user) {
        $this->SupirModel->delete($id_user);
    
        $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data supir berhasil dihapus', icon:'success'})</script>");
        redirect('admin/datasupir');
    }
}