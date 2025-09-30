<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class TeknisiModel extends CI_Model {

    private $_table = 'tb_teknisi';

    public function generateId() {
        $unik = 'TK';
        $kode = $this->db->query("SELECT MAX(id_teknisi) LAST_NO FROM tb_teknisi WHERE id_teknisi LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 2, 3);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%03s", $urutan);
        return $kode;
    }

    public function save($teknisi) {
        return $this->db->insert($this->_table, $teknisi);
    }

    public function edit($id_user, $teknisi) {
        $this->db->where('id_user', $id_user);
        return $this->db->update($this->_table, $teknisi);
    }

    public function delete($id_user) {
        $this->db->trans_start();
        $this->db->where('id_teknisi', $id_user);
        $this->db->delete($this->_table);
    
        $this->db->where('id_user', $id_user);
        $this->db->delete('tb_user');
        return $this->db->trans_complete();
    }

    public function update($id_teknisi) {
        $this->db->set('is_ready', 1);
        $this->db->where('id_teknisi', $id_teknisi);
        return $this->db->update($this->_table);
    }

    public function NotReady() {
        $this->db->set('is_ready', 0);
        $this->db->where('id_teknisi', $this->input->post('id_teknisi'));
        return $this->db->update($this->_table);
    }

    public function getAll() {
        $this->db->select('tb_teknisi.*, tb_user.*');
        $this->db->from($this->_table);
        $this->db->join('tb_user', 'tb_teknisi.id_user = tb_user.id_user');
        return $this->db->get();
    }

    public function getReady() {
        $this->db->select('tb_teknisi.*, tb_user.*');
        $this->db->from($this->_table);
        $this->db->join('tb_user', 'tb_teknisi.id_user = tb_user.id_user');
        $this->db->where('tb_teknisi.is_ready', 1);
        return $this->db->get();
    }
}