<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class SupirModel extends CI_Model {

    private $_table = 'tb_supir';

    public function generateId() {
        $unik = 'SP';
        $kode = $this->db->query("SELECT MAX(id_supir) LAST_NO FROM tb_supir WHERE id_supir LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 2, 3);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%03s", $urutan);
        return $kode;
    }

    public function save($supir) {
        return $this->db->insert($this->_table, $supir);
    }

    public function edit($id_user, $supir) {
        $this->db->where('id_user', $id_user);
        return $this->db->update($this->_table, $supir);
    }

    public function delete($id_user) {
        $this->db->trans_start();
        $this->db->where('id_supir', $id_user);
        $this->db->delete($this->_table);
    
        $this->db->where('id_user', $id_user);
        $this->db->delete('tb_user');
        return $this->db->trans_complete();
    }

    public function update($id_supir) {
        $this->db->set('is_ready', 1);
        $this->db->where('id_supir', $id_supir);
        return $this->db->update($this->_table);
    }

    public function NotReady() {
        $this->db->set('is_ready', 0);
        $this->db->where('id_supir', $this->input->post('id_supir'));
        return $this->db->update($this->_table);
    }

    public function nonactive($id_supir) {
        $this->db->set('is_ready', 0);
        $this->db->where('id_supir', $id_supir);
        return $this->db->update($this->_table);
    }

    public function getAll() {
        $this->db->select('tb_supir.*, tb_user.*');
        $this->db->from($this->_table);
        $this->db->join('tb_user', 'tb_supir.id_user = tb_user.id_user');
        return $this->db->get();
    }

    public function getReady() {
        $this->db->select('tb_supir.*, tb_user.*');
        $this->db->from($this->_table);
        $this->db->join('tb_user', 'tb_supir.id_user = tb_user.id_user');
        $this->db->where('tb_supir.is_ready', 1);
        return $this->db->get();
    }
}