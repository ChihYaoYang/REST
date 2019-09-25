<?php

class Integrante_model extends CI_Model {
    const table = 'integrante';
    
    public function get() {
        // $query = $this->db->get(self::table);
        // return $query->result();
        $this->db->select('integrante.*, equipe.nome as nome_equipe');
        $this->db->from('integrante');
        $this->db->join('equipe', 'equipe.id=integrante.id_equipe', 'inner');
        $query = $this->db->get();
        return $query->result();
    }
    public function getOne($id) {
        if ($id > 0) {
            $this->db->where('id', $id);
            $query = $this->db->get(self::table);
            return $query->row(0);
        } else {
            return false;
        }
    }
    public function insert($data = array()) {
        $this->db->insert(self::table, $data);
        return $this->db->affected_rows();
    }
    public function delete($id) {
        if ($id > 0) {
            $this->db->where('id', $id);
            $this->db->delete(self::table);
            return $this->db->affected_rows();
        } else {
            return false;
        }
    }

    public function update($id, $data = array()) {
        if ($id > 0) {
            $this->db->where('id', $id);
            $this->db->update(self::table, $data);
            return $this->db->affected_rows();
        } else {
            return false;
        }
    }
}
?>