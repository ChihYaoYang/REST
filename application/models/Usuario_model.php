<?php

class Usuario_model extends CI_Model {
    
    public function get() {
        $query = $this->db->get('usuario');
        return $query->result();
    }
    public function insert($data = array()) {
        $this->db->insert('usuario', $data);
        return $this->db->affected_rows();
    }
    public function delete($id) {
        if ($id > 0) {
            $this->db->where('id', $id);
            $this->db->delete('usuario');
            return $this->db->affected_rows();
        } else {
            return false;
        }
    }

    public function update($id, $data = array()) {
        if ($id > 0) {
            $this->db->where('id', $id);
            $this->db->update('usuario', $data);
            return $this->db->affected_rows();
        } else {
            return false;
        }
    }
}
?>