<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servico extends CI_Controller{

    //listar_categorias muda no sistema_model
    function __construct()
    {
        parent:: __construct();
        $this->data = array();
     
        // $this->m_sistema->inseri_servico();

        $this->dados = $this->session->userdata("dados" . APPNAME);
        $this->data["dados"] = $this->dados;
        
        $this->load->model("Servico_model", "m_servico");

        $local = str_replace("TCC/", "", $_SERVER["REQUEST_URI"]);
        $this->session->set_userdata(array("local" => $local));
        $this->data["local"] = $local;

        $this->data["categorias"] = $this->m_sistema->listar_categorias();

        $this->data["header"] = $this->load->view("template/header", $this->data, true);
        $this->data["navbar"] = $this->load->view("template/navbar", $this->data, true);
        $this->data["footer"] = $this->load->view("template/footer", $this->data, true);
    }

    public function index()
    {
        $this->data["content"] = $this->load->view("home/home", $this->data, true);
        $this->load->view("template/content", $this->data);
    }

    public function lista($categoria = null, $subcategoria = null)
    {
        $categoria = urldecode($categoria);
        $subcategoria = urldecode($subcategoria);

        $this->data["categoria"] = $categoria;
        $this->data["subcategoria"] = $subcategoria;
        $this->data["cards"] = $this->m_servico->servico_categoria($categoria, $subcategoria);
        $this->data["lista_categoria"] = $this->m_servico->get_subcategoria($categoria, $subcategoria);

        $this->data["breadcrumb"] = (object)array("titulo" => "Lista de Produtos/Serviços", "before" => array((object) array("nome" => "Home", "link" => "Home"), (object)array("nome" => "$categoria", "link" => "Home/lista/$categoria/$subcategoria")), "current" => "$subcategoria");

        $this->data["content"] = $this->load->view("home/lista", $this->data, true);
        $this->load->view("template/content", $this->data);
    }

    public function detalhes($servico, $id_servico)
    {
        $this->data["info"] = $this->m_servico->get_info_servico($id_servico);

        $this->data["breadcrumb"] = (object)array("titulo" => "Detalhes de Produtos/Serviços", "before" => array((object)array("nome" => "Home", "link" => "Home"), (object)array("nome" => "".$this->data["info"]->subcategoria->nome, "link" => "Home/lista/".$this->data["info"]->categoria->nome."/".$this->data["info"]->subcategoria->nome)), "current" => "".$this->data["info"]->nome);
        $this->data["javascript"] = [
            base_url("assets/js/home/detalhes.js")
        ];

        $this->data["content"] = $this->load->view("home/detalhes", $this->data, true);
        $this->load->view("template/content", $this->data);
    }

    public function cadastrar_pergunta()
    {
        $rst = $this->m_servico->cadastrar_pergunta();
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function favorita_servico()
    {
        $rst = $this->m_servico->favorita_servico();
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function datas_disponiveis($id_servico)
    {
        $rst = $this->m_servico->datas_disponiveis($id_servico);
    }

    public function contrata_servico()
    {
        $rst = $this->m_servico->contrata_servico();
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

}