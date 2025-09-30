<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class KendaraanModel extends CI_Model {

    private $_table = 'tb_kendaraan';

    public function generateId() {
        $unik = 'POL';
        $kode = $this->db->query("SELECT MAX(no_polisi) LAST_NO FROM tb_kendaraan WHERE no_polisi LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 3, 6);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%06s", $urutan);
        return $kode;
    }

    public function save($data) {
        return $this->db->insert($this->_table, $data);
    }

    public function edit($no_polisi, $data) {
        $this->db->where('no_polisi', $no_polisi);
        return $this->db->update($this->_table, $data);
    }

    public function delete($no_polisi) {
        $this->db->where('no_polisi', $no_polisi);
        return $this->db->delete($this->_table);
    }

    public function update($no_polisi) {
        $this->db->set('is_ready', 1);
        $this->db->where('no_polisi', $no_polisi);
        return $this->db->update($this->_table);
    }

    public function NotReady($no_polisi) {
        $this->db->set('is_ready', 0);
        $this->db->where('no_polisi', $no_polisi);
        return $this->db->update($this->_table);
    }

    public function getAll() {
        return $this->db->get($this->_table);
    }
}