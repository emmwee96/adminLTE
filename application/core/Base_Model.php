<?php

class Base_Model extends CI_Model
{

    /* --------------------------------------------------------------
     * VARIABLES
     * ------------------------------------------------------------ */

    /**
     * This model's default database table. Automatically
     * guessed by pluralising the model name.
     */
    protected $table_name;
    /**
     * This model's default primary key or unique identifier.
     * Used by the get(), update() and () functions.
     */
    protected $primary_key;
    /**
     * This model's default user updated ID. Default is zero
     */
    protected $user_id = 0;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('inflector');
        $this->_fetch_table();
        $this->_fetch_table_primary_key();
    }

    /**
     * Guess the table name by the model name
     */
    private function _fetch_table()
    {
        if ($this->table_name == null) {
            $this->table_name = preg_replace('/(_m|_model)?$/', '', strtolower(get_class($this)));
        }
    }

    /**
     * Guess the table name by the model name + '_id'
     */
    private function _fetch_table_primary_key()
    {
        if ($this->primary_key == null) {
            $this->primary_key = preg_replace('/(_m|_model)?$/', '', strtolower(get_class($this))) . '_id';
        }
    }

    function debug($data)
    {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        die();
    }

    function get_all()
    {
        $this->db->select("*");
        $this->db->from($this->table_name);

        $query = $this->db->get();

        return $query->result_array();
    }

    function get_all_with_role()
    {
        $this->db->select("*, role.role AS role");
        $this->db->from($this->table_name);
        $this->db->join("role", $this->table_name . ".role_id = role.role_id", "left");
        $this->db->where("deleted", 0);

        $query = $this->db->get();

        return $query->result_array();
    }

    function get_where($where)
    {
        $this->db->select("*");
        $this->db->from($this->table_name);
        $this->db->where($where);

        $query = $this->db->get();

        return $query->result_array();
    }

    function get_where_with_role($where)
    {
        $this->db->select("*, role.role AS role");
        $this->db->from($this->table_name);
        $this->db->join("role", $this->table_name . ".role_id = role.role_id", "left");
        $this->db->where("deleted", 0);
        $this->db->where($where);

        $query = $this->db->get();

        return $query->result_array();
    }

    function get_where_and_primary_is_not($where, $primary_key)
    {
        $this->db->select("*");
        $this->db->from($this->table_name);
        $this->db->where($this->primary_key . "!=" . $primary_key);
        $this->db->where($where);

        $query = $this->db->get();

        return $query->result_array();
    }

    function insert($data)
    {
        $this->db->insert($this->table_name, $data);

        return $this->db->insert_id();
    }

    function update_where($where, $data)
    {
        $this->db->where($where);
        $this->db->update($this->table_name, $data);

        return $this->db->insert_id();
    }

    function soft_delete($primary_key)
    {
        $data = array(
            "deleted" => 1
        );

        $this->db->where($this->primary_key, $primary_key);
        $this->db->update($this->table_name, $data);
    }

    function hard_delete($primary_key)
    {
        $this->db->where($this->primary_key, $primary_key);
        $this->db->delete($this->table_name);
    }

    function soft_delete_where($where)
    {
        $this->db->where($where);
        $this->db->update($this->table_name, $data);
    }

    function hard_delete_where($where)
    {
        $this->db->where($where);
        $this->db->delete($this->table_name);
    }

    function login($username, $password)
    {

        $this->db->select("*");
        $this->db->from($this->table_name);
        $this->db->where("username = ", $username);
        $this->db->join("role", $this->table_name . ".role_id = role.role_id", "left");
        $this->db->where("password = SHA2(CONCAT(salt,'" . $password . "'),512)");

        $query = $this->db->get();

        return $query->result_array();
    }
}
