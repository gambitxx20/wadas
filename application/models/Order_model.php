<?php

class Order_model extends CI_Model {
    
//    nama tabel dan primary key
    private $table = 'order';
    private $pk = 'id';
    
//    tampilkan semua data
    public function showAll() {
        $this->db->select('order.id as order_id,perusahaan.id as id_perusahaan,
         perusahaan.nama as nama_perusahaan,
         barang.id as id_barang,
         barang.nama as nama_barang,
         order.qty_barang as order_qty,
         order.harga_barang as order_harga,
         order.status as status,
         order.created_date as order_date,
         users.id as user_id,
         users.name as user_name,

        ');
        $q = $this->db->join('perusahaan','perusahaan.id = order.id_perusahaan');
        $q = $this->db->join('barang','barang.id = order.id_barang');
        $q = $this->db->join('users','users.id = order.created_by');
        $q = $this->db->order_by('order.id','desc');

        $q = $this->db->get($this->table);
        return $q;
    }

    public function showDaily() {
        $this->db->select('day(created_date) as created_date, sum(total) as total');
        $this->db->group_by('day(order.created_date)'); 
        $q = $this->db->where('month(order.created_date)',date('m'));
        $q = $this->db->order_by('order.id','desc');

        $q = $this->db->get($this->table);
        return $q;
    }
    
    public function getById($id) {
        $q = $this->db->where($this->pk,$id);
        $q = $this->db->get($this->table);
        return $q;
    }
    
    public function add($data) {
        //$db_debug = $this->db->db_debug; 
        
        //$this->db->db_debug = FALSE;
        $this->db->insert($this->table, $data);
        //$this->db->db_debug = $db_debug; 
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