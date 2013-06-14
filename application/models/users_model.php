<?php

/**
 * Users_model 
 * 
 * sample users model
 */
class Users_model extends CI_Model {
    public function get($id) {
        $query = $this->db->get_where('users', array('id' => $id));

        if ($query->num_rows() == 0) {
            return false;
        }

        return $query->row();
    }

    public function all() {
        $query = $this->db->get('users');

        return $query->result();
    }

    public function add($name) {
        $this->db->insert('users', array('name' => $name));

        return $this->db->insert_id();
    }

    public function update($user) {
        $this->db->where('id', $user->id);
        $this->db->update('users', array('name' => $user->name));
    }

    public function delete($id) {
        $this->db->delete('users', array('id' => $id));
    }
}
