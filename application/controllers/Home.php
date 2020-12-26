<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller{

    function __construct()
    {
        parent:: __construct();
        $this->data = array();
        
        $this->data["header"] = $this->load->view("template/header", $this->data, true);
        $this->data["navbar"] = $this->load->view("template/navbar", $this->data, true);
        $this->data["footer"] = $this->load->view("template/footer", $this->data, true);
    }

    public function index()
    {
        $this->data["content"] = $this->load->view("home/home", $this->data, true);
        $this->load->view("template/content", $this->data);
    }

    public function lista()
    {
        $this->data["breadcrumb"] = (object)array("titulo" => "Lista de Produtos/Serviços", "before" => (object)array("nome" => "Nome da Pagina Anterior", "link" => "Home"), "current" => "Nome da pagina atual");;

        $this->data["content"] = $this->load->view("home/lista", $this->data, true);
        $this->load->view("template/content", $this->data);
    }

}