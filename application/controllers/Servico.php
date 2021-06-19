<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servico extends CI_Controller{

    //listar_categorias muda no sistema_model
    function __construct()
    {
        parent:: __construct();
        $this->data = array();
        
        // cria_pasta();

        $this->dados = $this->session->userdata("dados" . APPNAME);
        $this->data["dados"] = $this->dados;
        
        $this->data["local"] = $this->session->userdata("local");;

        $this->load->model("Servico_model", "m_servico");

        $this->data["categorias"] = $this->m_sistema->listar_categorias();

        $this->data["cidade"] = $this->session->userdata("cidade");
        $this->data["estados"] = $this->m_servico->get_estados();

        $this->data["colores"] = $this->m_sistema->get_colores();

        $this->data["header"] = $this->load->view("template/header", $this->data, true);
        $this->data["navbar"] = $this->load->view("template/navbar", $this->data, true);
        $this->data["sidebar"] = $this->load->view("template/sidebar", $this->data, true);
        $this->data["footer"] = $this->load->view("template/footer", $this->data, true);
    }

    public function index()
    {
        $local = str_replace("TCC/", "", $_SERVER["REQUEST_URI"]);
        $local = str_replace("tcc/", "", $local);
        
        $this->session->set_userdata(array("local" => $local));
        $this->data["local"] = $local;

        $this->data["feedback"] = $this->m_servico->get_ult_feedbacks();

        $this->data["content"] = $this->load->view("home/home", $this->data, true);
        $this->load->view("template/content", $this->data);
    }

    public function lista($categoria = null, $subcategoria = null)
    {
        $local = str_replace("TCC/", "", $_SERVER["REQUEST_URI"]);
        $local = str_replace("tcc/", "", $local);
        
        $this->session->set_userdata(array("local" => $local));
        $this->data["local"] = $local;

        $categoria = urldecode($categoria);
        $subcategoria = urldecode($subcategoria);

        $this->data["categoria"] = $categoria;
        $this->data["subcategoria"] = $subcategoria;
        $this->data["cards"] = $this->m_servico->servico_categoria($subcategoria);
        $this->data["lista_categoria"] = $this->m_servico->get_subcategoria($categoria, $subcategoria);

        $this->data["breadcrumb"] = (object)array("titulo" => "Lista de Produtos/Serviços", "before" => array((object) array("nome" => "Home", "link" => "Servico"), (object)array("nome" => "$categoria", "link" => "Servico/lista/$categoria/$subcategoria")), "current" => "$subcategoria");
        $this->data["javascript"] = [
            base_url("assets/js/home/lista.js")
        ];

        $this->data["content"] = $this->load->view("home/lista", $this->data, true);
        $this->load->view("template/content", $this->data);
    }

    public function detalhes($servico, $id_servico)
    {
        $local = str_replace("TCC/", "", $_SERVER["REQUEST_URI"]);
        $local = str_replace("tcc/", "", $local);
        
        $this->session->set_userdata(array("local" => $local));
        $this->data["local"] = $local;

        $this->m_servico->insere_acesso($id_servico);
        $this->data["info"] = $this->m_servico->get_info_servico($id_servico);

        $this->data["breadcrumb"] = (object)array("titulo" => "Detalhes de Produtos/Serviços", "before" => array((object)array("nome" => "Home", "link" => "Servico"), (object)array("nome" => "".$this->data["info"]->subcategoria->nome, "link" => "Servico/lista/".$this->data["info"]->categoria->nome."/".$this->data["info"]->subcategoria->nome)), "current" => "".$this->data["info"]->nome);
        $this->data["javascript"] = [
            base_url("assets/js/home/detalhes.js")
        ];

        $this->data["content"] = $this->load->view("home/detalhes", $this->data, true);
        $this->load->view("template/content", $this->data);
    }

    public function cadastrar_produto()
    {
        $this->data["categoria"] = $this->m_servico->get_categorias_principais();
        $this->data["pagamento"] = $this->m_servico->get_pagamento();
        $this->data["estados"] = $this->m_servico->get_estados();

        $this->data["horarios"] = $this->m_servico->lista_horarios();
        $this->data["lista_cidade"] = $this->m_servico->get_cidades($this->data["cidade"]->id_estado);
        
        $this->data["breadcrumb"] = (object)array("titulo" => "Cadastro de Produtos/Serviços", "before" => array((object)array("nome" => "Home", "link" => "Servico")), "current" => "Cadastrando novo Serviço");
        $this->data["javascript"] = [
            base_url("assets/js/produto/formulario.js"),
            base_url("assets/js/produto/plugins.js")
        ];

        $this->data["content"] = $this->load->view("produto/formulario", $this->data, true);
        $this->load->view("template/content", $this->data);
    }

    public function gerenciar_servico($id)
    {
        if(!isset($this->dados->usuario_id))
            redirect(base_url("Servico"));

        $this->data["id"] = $id;

        $this->data["info_card"] = $this->m_servico->get_info_card($id);

        $this->data["breadcrumb"] = (object)array("titulo" => "Gerenciamento do Serviço", "before" => array((object)array("nome" => "Home", "link" => "Servico")), "current" => "Gerenciamento do Serviço");
        $this->data["javascript"] = [
            base_url("assets/js/produto/gerenciamento.js")
        ];

        $this->data["content"] = $this->load->view("produto/gerenciamento", $this->data, true);
        $this->load->view("template/content", $this->data);
    }

    public function movimentacao($id)
    {
        $this->data["id"] = $id;
        $this->data["info"] = $this->m_servico->get_info_orcamentos($id);

        // echo '<pre>';
        // print_r($this->data["info"]);
        // echo '</pre>';
        // exit;
        $this->data["javascript"] = [
            base_url("assets/js/produto/movimentacao.js")
        ];

        $this->data["breadcrumb"] = (object)array("titulo" => "Acompanhamento do Pedido do Serviço", "before" => array((object)array("nome" => "Home", "link" => "Servico"), (object)array("nome" => "Gerenciamento de Serviço", "link" => "Servico/gerenciar_servico/".$this->data["info"][0]->id_servico)), "current" => "Acompanhamento do Pedido do Serviço");

        $this->data["content"] = $this->load->view("produto/movimentacao", $this->data, true);
        $this->load->view("template/content", $this->data);
    }
    
    public function edita_servico($id)
    {
        $this->data["id"] = $id;
        $this->data["info"] = $this->m_servico->get_info_servico($id);
        $this->data["categoria"] = $this->m_servico->get_categorias_principais();
        $this->data["lista_subcategoria"] = $this->m_servico->get_subcategorias($this->data["info"]->categoria_pai->id);
        $this->data["pagamento"] = $this->m_servico->get_pagamento();
        $this->data["estados"] = $this->m_servico->get_estados();
        $this->data["cidade"] = $this->m_servico->get_cidades($this->data["info"]->estado->id);
        $this->data["horarios"] = $this->m_servico->lista_horarios();

        // echo '<pre>';
        // print_r($this->data["info"]);
        // echo '</pre>';
        // exit;

        $this->data["breadcrumb"] = (object)array("titulo" => "Editar Informações do Serviço", "before" => array((object)array("nome" => "Home", "link" => "Servico")), "current" => "Editar Informações do Serviço");
        $this->data["javascript"] = [
            base_url("assets/js/produto/edita.js")
        ];

        $this->data["content"] = $this->load->view("produto/edita", $this->data, true);
        $this->load->view("template/content", $this->data);
    }

    public function editar_imagens($id)
    {
        $this->data["id"] = $id;
        $this->data["imagem"] = $this->m_servico->get_imagens($id);

        $this->data["breadcrumb"] = (object)array("titulo" => "Editar Imagens do Serviço", "before" => array((object)array("nome" => "Home", "link" => "Servico")), "current" => "Editar Imagens do Serviço");
        $this->data["javascript"] = [
            base_url("assets/js/produto/edita_imagem.js")
        ];

        $this->data["content"] = $this->load->view("produto/edita_imagem", $this->data, true);
        $this->load->view("template/content", $this->data);
    }

    public function pesquisa($pesquisa)
    {
        $this->data["pesquisa"] = urldecode($pesquisa);

        $this->data["cards"] = $this->m_servico->pesquisa_servico($pesquisa);

        $this->data["breadcrumb"] = (object)array("titulo" => "Pesquisa Personalizada", "before" => array((object)array("nome" => "Home", "link" => "Servico")), "current" => "Pesquisa Personalizada");
        $this->data["javascript"] = [
            base_url("assets/js/pesquisa/pesquisa.js")
        ];

        $this->data["content"] = $this->load->view("pesquisa/pesquisa", $this->data, true);
        $this->load->view("template/content", $this->data);
    }

    public function get_cep()
    {
        $rst = $this->sistema->get_cep();
        if(!isset($rst->erro))
        {
            $rst->estado = $this->m_servico->get_estado_sigla($rst->uf);
        }

        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
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

    public function contrata_servico()
    {
        $rst = $this->m_servico->contrata_servico();
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function get_subcategorias($id)
    {
        $rst = $this->m_servico->get_subcategorias($id);
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function cadastro_servico()
    {
        $rst = $this->m_servico->cadastro_servico();
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function get_perguntas($id, $resposta = false)
    {
        $rst = $this->m_servico->get_perguntas($id, $resposta);
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function responder_pergunta()
    {
        $rst = $this->m_servico->responder_pergunta();
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function get_orcamentos($id)
    {
        $rst = $this->m_servico->get_orcamentos($id);
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function resposta_orcamento()
    {
        $rst = $this->m_servico->resposta_orcamento();
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function visibilidade()
    {
        $rst = $this->m_servico->visibilidade();
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function get_visibilidade($id)
    {
        $rst = $this->m_servico->get_visibilidade($id);
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function get_cidades($id)
    {
        $rst = $this->m_servico->get_cidades($id);
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function cancela_servico($id)
    {
        $rst = $this->m_servico->cancela_servico($id);
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function troca_cidade($id_estado, $id_cidade)
    {
        $this->session->set_userdata(array("cidade" => (object)array("id_estado" => $id_estado, "id_cidade" => $id_cidade)));

        echo json_encode(true, JSON_UNESCAPED_UNICODE);
    }

    public function editar_servico()
    {
        $rst = $this->m_servico->editar_servico();
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function insere_imagem()
    {
        $this->set_files();
        $rst = $this->m_servico->insere_imagem();
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function troca_principal()
    {
        $rst = $this->m_servico->troca_principal();
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function troca_ativo()
    {
        $rst = $this->m_servico->troca_ativo();
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function exclui_imagem()
    {
        $rst = $this->m_servico->exclui_imagem();
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function servico_realizado($id)
    {
        $rst = $this->m_servico->servico_realizado($id);
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function set_files()
    {

        move_uploaded_file($_FILES["file"]["tmp_name"], APPPATH."..\assets\uploads"."\\".$_FILES["file"]["name"]);

        $path = APPPATH."..\assets\uploads"."\\".$_FILES["file"]["name"];

        $arquivo = array(
            "name" => $_FILES["file"]["name"],
            "type" => $_FILES["file"]["type"],
            "path" => $path,
            "tmp_name" => $_FILES["file"]["tmp_name"],
            "size" => $_FILES["file"]["size"],
            "erro" => $_FILES["file"]["error"]
        );

        $files = $this->session->userdata("files". APPNAME);
        
        if(!$files)
            $files = array();

        $files[] = $arquivo;
        $this->session->set_userdata(array("files". APPNAME => $files));
        unset($_FILES["file"]);
    }

}