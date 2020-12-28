<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller{

    function __construct()
    {
        parent:: __construct();
        $this->data = array();
        
        $this->data["header"] = $this->load->view("template/header", $this->data, true);
        $this->data["navbar"] = $this->load->view("template/navbar", $this->data, true);
        $this->data["footer"] = $this->load->view("template/footer", $this->data, true);
        //Não esquecer de fazer o termo para utilizar o endereço e os dados dos clientes.
    }

    public function cadastro()
    {
        $this->data["content"] = $this->load->view("usuario/form", $this->data, true);
        $this->load->view("template/content", $this->data);
    }

}