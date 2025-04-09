<?php
class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insertuser($data) {
        return $this->db->insert('users', $data);
    }

    public function check_user($email) {
        $this->db->where('email', $email);
        $this->db->where('status', 1);
        return $this->db->get('users')->row();
    }
}