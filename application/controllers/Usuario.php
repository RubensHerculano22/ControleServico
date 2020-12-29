<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller{

    function __construct()
    {
        parent:: __construct();
        $this->data = array();
        
        $this->load->model("Usuario_model", "m_usuario");

        $this->data["header"] = $this->load->view("template/header", $this->data, true);
        $this->data["navbar"] = $this->load->view("template/navbar", $this->data, true);
        $this->data["footer"] = $this->load->view("template/footer", $this->data, true);
        //Não esquecer de fazer o termo para utilizar o endereço e os dados dos clientes.
    }

    public function index($id = null)
    {
        $titulo = $id != null ? "Atualizando dados de cadastro" : "Formulário de Cadastro";
        $this->data["breadcrumb"] = (object)array("titulo" => $titulo, "before" => array((object)array("nome" => "Home", "link" => "Home")), "current" => $titulo);

        $this->data["usuario"] = $this->m_usuario->get_usuario();

        $this->data["javascript"] = [
            base_url("assets/js/usuario/form.js")
        ];

        $this->data["content"] = $this->load->view("usuario/form", $this->data, true);
        $this->load->view("template/content", $this->data);
    }

    public function autentifica()
    {
        $rst = $this->m_usuario->geren_usuario();
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

}