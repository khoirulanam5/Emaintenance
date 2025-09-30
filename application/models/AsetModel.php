<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class AsetModel extends CI_Model {

    private $_table = 'tb_aset_kendaraan';

    public function generateId() {
        $unik = 'KD';
        $kode = $this->db->query("SELECT MAX(id_kendaraan) LAST_NO FROM tb_aset_kendaraan WHERE id_kendaraan LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 2, 3);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%03s", $urutan);
        return $kode;
    }

    public function generateAset() {
        $unik = 'AST';
        $kode = $this->db->query("SELECT MAX(no_aset) LAST_NO FROM tb_aset_kendaraan WHERE no_aset LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 3, 3);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%03s", $urutan);
        return $kode;
    }

    public function save($data) {
        return $this->db->insert($this->_table, $data);
    }

    public function edit($id_kendaraan, $data) {
        $this->db->where('id_kendaraan', $id_kendaraan);
        return $this->db->update($this->_table, $data);
    }

    public function delete($id_kendaraan) {
        $this->db->where('id_kendaraan', $id_kendaraan);
        return $this->db->delete($this->_table);
    }

    public function getAll() {
        return $this->db->get($this->_table);
    }

    public function getById($id_kendaraan) {
        return $this->db->get_where($this->_table, ['id_kendaraan' => $id_kendaraan]);
    }

    public function getDetail($id_kendaraan) {
        $this->db->select('tb_aset_kendaraan.*, tb_kendaraan.*');
        $this->db->from($this->_table);
        $this->db->join('tb_kendaraan', 'tb_aset_kendaraan.no_polisi = tb_kendaraan.no_polisi');
        $this->db->where('tb_aset_kendaraan.id_kendaraan', $id_kendaraan);
        return $this->db->get();
    }

    public function getReady() {
        $this->db->select('tb_aset_kendaraan.*, tb_kendaraan.*');
        $this->db->from($this->_table);
        $this->db->join('tb_kendaraan', 'tb_aset_kendaraan.no_polisi = tb_kendaraan.no_polisi');
        $this->db->where('tb_kendaraan.is_ready', 1);
        return $this->db->get();
    }

    public function getByNoPolisi($id_kendaraan) {
        $this->db->select('no_polisi');
        $this->db->from($this->_table);
        $this->db->where('id_kendaraan', $id_kendaraan);
        return $this->db->get();
    }

    public function getByNopol() {
        $this->db->select('no_polisi');
        $this->db->from($this->_table);
        $this->db->where('id_kendaraan', $this->input->post('id_kendaraan'));
        return $this->db->get();
    }

    public function getNoPolisiByIdKendaraan($id_kendaraan) {
        $this->db->select('no_polisi');
        $this->db->from($this->_table);
        $this->db->where('id_kendaraan', $id_kendaraan);
        return $this->db->get();
    }
}