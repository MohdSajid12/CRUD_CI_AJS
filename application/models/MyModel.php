<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyModel extends CI_Model {

    public function insertRecord($data) {
        $this->db->insert('crud', $data);
    }

    
    public function getRecords()
    {
        $this->db->select('*');
        $q = $this->db->get('crud');
        $results = $q->result_array();
    
        return $results;
    }

    public function updateRecord($data)
    {
        $this->db->where('id', $data['id']);
        return $this->db->update('crud', $data);
    }

    public function deleteRecord($data)
    {
        $this->db->where('id', $data['id']);
        return $this->db->delete('crud');
    }
}
