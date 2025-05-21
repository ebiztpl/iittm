<?php
class Worklog_model extends CI_Model {

    protected $table = 'work_log';

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function get_all() {
        return $this->db->get($this->table)->result();
    }
    
}
