<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Base_Controller {

    function __construct() {
        parent::__construct();
        
        $this->page_data = array();

        $this->load->model("Admin_model");
    }

    function index(){
        $this->load->view("admin/header");
        $this->load->view("admin/admin/all",$this->page_data);
        $this->load->view("admin/footer");
    }
    function all(){
        $this->load->view("admin/header");
        $this->load->view("admin/admin/all",$this->page_data);
        $this->load->view("admin/footer");
    }

    function add(){
        $this->load->view("admin/header");
        $this->load->view("admin/admin/add",$this->page_data);
        $this->load->view("admin/footer");
    }
    
    function detail(){
        $this->load->view("admin/header");
        $this->load->view("admin/admin/detail",$this->page_data);
        $this->load->view("admin/footer");
    }
    function edit(){
        $this->load->view("admin/header");
        $this->load->view("admin/admin/edit",$this->page_data);
        $this->load->view("admin/footer");
    }

}
