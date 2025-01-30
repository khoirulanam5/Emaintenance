<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index() {
        $this->load->view('landing/header');
        $this->load->view('auth/login');
        $this->load->view('landing/footer');
    }

    public function login() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == false) {
            redirect('auth');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $cek = $this->db->get_where("tb_user", ["username" => $username, "password" => $password])->row();

                if(!empty($cek)) {
                    // Ambil id_teknisi jika role adalah teknisi
                    $id_teknisi = null;
                    if ($cek->role == 'teknisi') {
                        $teknisi = $this->db->get_where('tb_teknisi', ['id_user' => $cek->id_user])->row();
                        $id_teknisi = $teknisi ? $teknisi->id_teknisi : null;
                    }

                    // Ambil id_supir jika role adalah supir
                    $id_supir = null;
                    if ($cek->role == 'supir') {
                        $supir = $this->db->get_where('tb_supir', ['id_user' => $cek->id_user])->row();
                        $id_supir = $supir ? $supir->id_supir : null;
                    }

                    $ses = [
                        'id_user' => $cek->id_user,
                        'nama' => $cek->nama,
                        'username' => $cek->username,
                        'password' => $cek->password,
                        'no_hp' => $cek->no_hp,
                        'role' => $cek->role,
                        'id_teknisi' => $id_teknisi,
                        'id_supir' => $id_supir
                    ];
                    
                    $this->session->set_userdata($ses);

                    if ($cek->role == 'admin maintenance') {
                        $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Login Berhasil', icon:'success'})</script>");
                        redirect('dashboard');
                    } else if ($cek->role == 'teknisi') {
                        $this->session->set_flashdata("pesan","<script>Swal.fire({title:'Berhasil', text:'Login Berhasil!', icon:'success'})</script>");
                        redirect('dashboard');
                    } else {
                        $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Login Berhasil', icon:'success'})</script>");
                        redirect('dashboard');
                    }
                } else {
                    $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Gagal', text:'username / password salah', icon:'error'})</script>");
                    redirect('auth');
                }
        }   
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }
}