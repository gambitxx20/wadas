<?php

class Users_model extends CI_Model {
    
//    nama tabel dan primary key
    private $table = 'users';
    private $pk = 'id';
    
//    tampilkan semua data
    public function showAll() {
        $q = $this->db->select('id,name,username');
        $q = $this->db->order_by($this->pk,'desc');

        $q = $this->db->get($this->table);
        return $q;
    }
    
    public function getByUsername($username) {
        $q = $this->db->select('id,name,username');
        $q = $this->db->where('username',$username);
        $q = $this->db->get($this->table);
        return $q;
    }

    public function userLogin($username,$password){
        $q = $this->db->select('id,name,username');
        $q = $this->db->where('username',$username);
        $q = $this->db->where('password',$password);
        $q = $this->db->get($this->table);
        return $q;   
    }

    public function getById($id) {
        $q = $this->db->select('id,name,username');
        $q = $this->db->where($this->pk,$id);
        $q = $this->db->get($this->table);
        return $q;
    }
    
    public function add($data) {
        $db_debug = $this->db->db_debug; 
        
        $this->db->db_debug = FALSE;
        $this->db->insert($this->table, $data);
        $this->db->db_debug = $db_debug; 
    }
    
    public function update($id,$data) {
        $this->db->where($this->pk, $id);
        $this->db->update($this->table, $data); 
    }
    
    public function delete($id) {
        $this->db->where($this->pk, $id);
        $this->db->delete($this->table); 
    }

    
}