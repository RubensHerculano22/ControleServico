<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends CI_Controller{

    //listar_categorias muda no sistema_model
    function __construct()
    {
        parent:: __construct();
        $this->data = array();

        $this->dados = $this->session->userdata("dados" . APPNAME);
        $this->data["dados"] = $this->dados;
        
        $this->load->model("Feedback_model", "m_feedback");
        $this->load->model("Servico_model", "m_servico");

        $local = str_replace("TCC/", "", $_SERVER["REQUEST_URI"]);
        $local = str_replace("tcc/", "", $local);
        
        $this->session->set_userdata(array("local" => $local));
        $this->data["local"] = $local;
        $this->data["cidade"] = $this->session->userdata("cidade");

        $this->data["categorias"] = $this->m_sistema->listar_categorias();
        $this->data["estados"] = $this->m_servico->get_estados();

        $this->data["colores"] = $this->m_sistema->get_colores();

        $this->data["header"] = $this->load->view("template/header", $this->data, true);
        $this->data["navbar"] = $this->load->view("template/navbar", $this->data, true);
        $this->data["sidebar"] = $this->load->view("template/sidebar", $this->data, true);
        $this->data["footer"] = $this->load->view("template/footer", $this->data, true);
    }

    public function index($id)
    {
        $this->data["id"] = $id;
        $this->data["servico"] = $this->m_feedback->get_servico_info($id);

        $this->data["breadcrumb"] = (object)array("titulo" => "Feedback", "before" => array((object) array("nome" => "Home", "link" => "Servico")), "current" => "Feedback de Serviço");
        $this->data["javascript"] = [
            base_url("assets/js/feedback/home.js")
        ];

        $this->data["content"] = $this->load->view("feedback/home", $this->data, true);
        $this->load->view("template/content", $this->data);
    }

    public function cadastra_feedback()
    {
        $rst = $this->m_feedback->cadastra_feedback();
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }
    
}