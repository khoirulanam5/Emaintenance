<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class ServiceModel extends CI_Model {

    private $_table = 'tb_service';

    public function generateId() {
        $unik = 'SR';
        $kode = $this->db->query("SELECT MAX(id_service) LAST_NO FROM tb_service WHERE id_service LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 2, 3);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%03s", $urutan);
        return $kode;
    }

    public function generateKode() {
        $unik = 'SVC';
        $kode = $this->db->query("SELECT MAX(kode) LAST_NO FROM tb_service WHERE kode LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 3, 6);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%06s", $urutan);
        return $kode;
    }

    public function save($data) {
        return $this->db->insert($this->_table, $data);
    }

    public function edit($id_service, $data) {
        $this->db->where('id_service', $id_service);
        return $this->db->update($this->_table, $data);
    }

    public function end($id_service) {
        $this->db->set('status', 'Selesai');
        $this->db->where('id_service', $id_service);
        return $this->db->update($this->_table);
    }

    public function delete($id_service) {
        $this->db->where('id_service', $id_service);
        return $this->db->delete($this->_table);
    }

    public function getAll() {
        $this->db->select('tb_service.*, tb_aset_kendaraan.*, tb_kendaraan.*, teknisi_user.nama AS nama_teknisi, supir_user.nama AS nama_supir');
        $this->db->from($this->_table);
        $this->db->join('tb_aset_kendaraan', 'tb_service.id_kendaraan = tb_aset_kendaraan.id_kendaraan', 'LEFT');
        $this->db->join('tb_kendaraan', 'tb_aset_kendaraan.no_polisi = tb_kendaraan.no_polisi', 'LEFT');
        $this->db->join('tb_teknisi', 'tb_service.id_teknisi = tb_teknisi.id_teknisi', 'LEFT');
        $this->db->join('tb_supir', 'tb_service.id_supir = tb_supir.id_supir', 'LEFT');
        $this->db->join('tb_user AS teknisi_user', 'tb_teknisi.id_user = teknisi_user.id_user', 'LEFT');
        $this->db->join('tb_user AS supir_user', 'tb_supir.id_user = supir_user.id_user', 'LEFT');
        $this->db->where('tb_service.status', NULL);
        return $this->db->get();
    }

    public function getSupir() {
        $this->db->select('tb_service.*, tb_aset_kendaraan.*, tb_kendaraan.*, teknisi_user.nama AS nama_teknisi, supir_user.nama AS nama_supir');
        $this->db->from($this->_table);
        $this->db->join('tb_aset_kendaraan', 'tb_service.id_kendaraan = tb_aset_kendaraan.id_kendaraan', 'LEFT');
        $this->db->join('tb_kendaraan', 'tb_aset_kendaraan.no_polisi = tb_kendaraan.no_polisi', 'LEFT');
        $this->db->join('tb_teknisi', 'tb_service.id_teknisi = tb_teknisi.id_teknisi', 'LEFT');
        $this->db->join('tb_supir', 'tb_service.id_supir = tb_supir.id_supir', 'LEFT');
        $this->db->join('tb_user AS teknisi_user', 'tb_teknisi.id_user = teknisi_user.id_user', 'LEFT');
        $this->db->join('tb_user AS supir_user', 'tb_supir.id_user = supir_user.id_user', 'LEFT');
        $this->db->where('tb_service.id_supir', $this->session->userdata('id_supir'));
        return $this->db->get();
    }

    public function getTeknisi() {
        $this->db->select('tb_service.*, tb_aset_kendaraan.*, tb_kendaraan.*, teknisi_user.nama AS nama_teknisi, supir_user.nama AS nama_supir');
        $this->db->from($this->_table);
        $this->db->join('tb_aset_kendaraan', 'tb_service.id_kendaraan = tb_aset_kendaraan.id_kendaraan', 'LEFT');
        $this->db->join('tb_kendaraan', 'tb_aset_kendaraan.no_polisi = tb_kendaraan.no_polisi', 'LEFT');
        $this->db->join('tb_teknisi', 'tb_service.id_teknisi = tb_teknisi.id_teknisi', 'LEFT');
        $this->db->join('tb_supir', 'tb_service.id_supir = tb_supir.id_supir', 'LEFT');
        $this->db->join('tb_user AS teknisi_user', 'tb_teknisi.id_user = teknisi_user.id_user', 'LEFT');
        $this->db->join('tb_user AS supir_user', 'tb_supir.id_user = supir_user.id_user', 'LEFT');
        $this->db->where('tb_service.id_teknisi', $this->session->userdata('id_teknisi'));
        $this->db->where('tb_service.status', NULL);
        return $this->db->get();
    }

    public function getHistory() {
        $this->db->select('tb_service.*, tb_aset_kendaraan.*, tb_kendaraan.*, teknisi_user.nama AS nama_teknisi, supir_user.nama AS nama_supir');
        $this->db->from($this->_table);
        $this->db->join('tb_aset_kendaraan', 'tb_service.id_kendaraan = tb_aset_kendaraan.id_kendaraan', 'LEFT');
        $this->db->join('tb_kendaraan', 'tb_aset_kendaraan.no_polisi = tb_kendaraan.no_polisi', 'LEFT');
        $this->db->join('tb_teknisi', 'tb_service.id_teknisi = tb_teknisi.id_teknisi', 'LEFT');
        $this->db->join('tb_supir', 'tb_service.id_supir = tb_supir.id_supir', 'LEFT');
        $this->db->join('tb_user AS teknisi_user', 'tb_teknisi.id_user = teknisi_user.id_user', 'LEFT');
        $this->db->join('tb_user AS supir_user', 'tb_supir.id_user = supir_user.id_user', 'LEFT');
        $this->db->where('tb_service.status', 'Selesai');
        return $this->db->get();
    }

    public function getById($id_service) {
        $this->db->select('tb_service.*, tb_aset_kendaraan.id_kendaraan, tb_supir.id_supir, tb_teknisi.id_teknisi');
        $this->db->from($this->_table);
        $this->db->join('tb_aset_kendaraan', 'tb_service.id_kendaraan = tb_aset_kendaraan.id_kendaraan', 'LEFT');
        $this->db->join('tb_supir', 'tb_service.id_supir = tb_supir.id_supir', 'LEFT');
        $this->db->join('tb_teknisi', 'tb_service.id_teknisi = tb_teknisi.id_teknisi', 'LEFT');
        $this->db->where('tb_service.id_service', $id_service);
        return $this->db->get();
    }

    public function getId($id_service) {
        $this->db->select('id_kendaraan, id_supir, id_teknisi');
        $this->db->from($this->_table);
        $this->db->where('id_service', $id_service);
        return $this->db->get();
    }
}