<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller{

    function __construct()
    {
        parent:: __construct();
        $this->data = array();
        
        cria_pasta();

        $this->dados = $this->session->userdata("dados" . APPNAME);
        $this->data["dados"] = $this->dados;
        $this->local = $this->session->userdata("local");
        $this->data["local"] = $this->local;

        $this->load->model("Servico_model", "m_servico");
        
        $this->data["categorias"] = $this->m_sistema->listar_categorias();
        $this->data["cidade"] = $this->session->userdata("cidade");
        $this->data["estados"] = $this->m_servico->get_estados();

        $this->data["colores"] = $this->m_sistema->get_colores();

        $this->load->model("Usuario_model", "m_usuario");

        $this->data["header"] = $this->load->view("template/header", $this->data, true);
        $this->data["navbar"] = $this->load->view("template/navbar", $this->data, true);
        $this->data["sidebar"] = $this->load->view("template/sidebar", $this->data, true);
        $this->data["footer"] = $this->load->view("template/footer", $this->data, true);
        //Não esquecer de fazer o termo para utilizar o endereço e os dados dos clientes.
    }

    public function index($id = null)
    {
        $titulo = $id != null ? "Atualizando dados de cadastro" : "Formulário de Cadastro";
        $this->data["breadcrumb"] = (object)array("titulo" => $titulo, "before" => array((object)array("nome" => "Home", "link" => "Home")), "current" => $titulo);

        $this->data["usuario"] = $this->m_usuario->info_usuario($id);

        $this->data["javascript"] = [
            base_url("assets/js/usuario/form.js")
        ];

        $this->data["content"] = $this->load->view("usuario/form", $this->data, true);
        $this->load->view("template/content", $this->data);
    }

    public function perfil($id = null)
    {
        if(!$this->data["dados"])
            redirect(base_url());
        $this->data["breadcrumb"] = (object)array("titulo" => "Perfil", "before" => array((object)array("nome" => "Home", "link" => "Home")), "current" => "Perfil - Informações de Usuário");

        $this->data["info"] = $this->m_usuario->info_usuario($this->data["dados"]->usuario_id);
        $this->data["identificador"] = $id;

        $this->data["favoritos"] = $this->m_usuario->get_favoritos();
        $this->data["cadastrados"] = $this->m_usuario->get_servicos_cadastrados();
        $this->data["contratados"] = $this->m_usuario->get_servicos_contratos();
        
        // echo '<pre>';
        // print_r($this->data["contratados"]);
        // echo '</pre>';
        // exit;

        $this->troca_local($id);

        $this->data["javascript"] = [
            base_url("assets/js/usuario/perfil.js")
        ];

        $this->data["content"] = $this->load->view("usuario/perfil", $this->data, true);
        $this->load->view("template/content", $this->data);
    }

    public function login()
    {
        $this->data["breadcrumb"] = (object)array("titulo" => "Autentificação", "before" => array((object)array("nome" => "Home", "link" => "Home")), "current" => "Autentificação");

        $this->data["javascript"] = [
            base_url("assets/js/usuario/autentificacao.js")
        ];

        $this->data["content"] = $this->load->view("usuario/autentificacao", $this->data, true);
        $this->load->view("template/content", $this->data);
    }

    public function geren_endereco($id = null)
    {
        if(!$this->data["dados"])
            redirect(base_url());
        $titulo = $id != null ? "Atualizando dados de endereço" : "Cadastro de Endereço";
        $this->data["breadcrumb"] = (object)array("titulo" => $titulo, "before" => array((object)array("nome" => "Home", "link" => "Home")), "current" => $titulo);

        $this->data["id"] = $id;
        $this->data["endereco"] = $this->m_usuario->get_endereco($id);

        $this->data["javascript"] = [
            base_url("assets/js/usuario/endereco.js")
        ];

        $this->data["content"] = $this->load->view("usuario/endereco", $this->data, true);
        $this->load->view("template/content", $this->data);
    }

    public function controle_pedido($id)
    {
        $this->data["breadcrumb"] = (object)array("titulo" => "Movimentação de Contratação de Serviço", "before" => array((object)array("nome" => "Home", "link" => "Home"), (object)array("nome" => "Perfil", "link" => "Usuario/perfil/pedidos")), "current" => "Movimentação de Contratação de Serviço");
        $this->data["id"] = $id;

        $this->data["info"] = $this->m_usuario->get_orcamentos($id);

        // echo '<pre>';
        // print_r($this->data["info"]);
        // echo '</pre>';
        // exit;

        $this->data["javascript"] = [
            base_url("assets/js/usuario/movimentacao.js")
        ];

        $this->data["content"] = $this->load->view("usuario/movimentacao", $this->data, true);
        $this->load->view("template/content", $this->data);
    }

    public function remove_endereco($id)
    {
        $rst = $this->m_usuario->remove_endereco($id);
        if($rst == true)
        {
            redirect(base_url("Usuario/perfil/dados"));
        }
    }

    public function logout()
    {
        $dados = $this->session->userdata("dados" . APPNAME);
        $this->session->unset_userdata(array("is_logged", "dados" . APPNAME));
        redirect(base_url());
    }

    public function salva_usuario()
    {
        $rst = $this->m_usuario->salva_usuario();
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function salva_endereco()
    {
        $rst = $this->m_usuario->salva_endereco();
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function autentifica()
    {
        $rst = $this->m_usuario->autentifica();
        if($rst->logged)
        {
            //Salva na sessão os dados do usuario logado
            $this->session->set_userdata(array("is_logged" => true, "dados" . APPNAME => $rst));
            $rst->local = $this->session->userdata("local");
        }
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function resposta_orcamento()
    {
        $rst = $this->m_usuario->resposta_orcamento();
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function get_orcamentos($id)
    {
        $rst = $this->m_usuario->get_orcamentos($id);
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function cancela_servico($id)
    {
        $rst = $this->m_usuario->cancela_servico($id);
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function desfavoritar($id)
    {
        $rst = $this->m_usuario->desfavoritar($id);
        echo json_encode($rst, JSON_UNESCAPED_UNICODE);
    }

    public function troca_local($id)
    {
        $local = "Usuario/perfil/".$id;
        $this->session->set_userdata(array("local" => $local));
        $this->data["local"] = $local;
    }

}