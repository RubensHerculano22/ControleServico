<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback_model extends CI_Model{
    
    function __construct() 
    {
        parent::__construct();
        $this->dados = $this->session->userdata("dados" . APPNAME);
    }

    /**
     * Consulta as informações do Serviço para o Feedback
     * @access public
     * @param  int   $id   Identificador do Orçamento.
     * @return object;
    */
    public function get_servico_info($id)
    {
        $info = $this->db->get_where("Orcamento", "id = $id")->row();

        $info->servico = $this->db->get_where("Servico", "id = $info->id_servico")->row();

        $info->imagem = $this->db->get_where("Imagens", "id_servico = '$info->id_servico' AND principal = 1")->row();

        $info->contratacao = $this->db->get_where("ContrataServico", "id_orcamento = '$id' AND status = 1")->last_row();

        return $info;
    }

    /**
     * Cadastra um feedback no serviço
     * @access public
     * @return object;
    */
    public function cadastra_feedback()
    {
        $rst = (object)array("rst" => false, "msg" => "");
        $data = (object)$this->input->post();

        $this->db->set("quantidade_estrelas", $data->avaliacao);
        $this->db->set("titulo", $data->titulo);
        $this->db->set("descricao", $data->descricao);
        $this->db->set("descricao", $data->descricao);
        $this->db->set("data_inclusao", date("Y-m-d H:i:s"));
        $this->db->set("id_orcamento", $data->id_orcamento);

        if($this->db->insert("Feedback"))
        {
            $this->db->select("U.email, S.nome, S.id");
            $this->db->join("Usuario U", "U.id = S.id_usuario");
            $this->db->join("Orcamento O", "O.id_servico = S.id");
            $this->db->where("O.id = '$data->id_orcamento'");
            $query = $this->db->get("Servico S")->row();
            $texto = (object)array();

            $texto->email = strtolower($query->email);
            $texto->titulo = "Contratação do Serviço";
            $texto->link = base_url("Servico/detalhes/$query->nome/$query->id");
            $texto->texto_link = "Ver Serviço";
            $texto->msg = "Opa, tudo certo? <br/> O cliente realizou um feedback em seu serviço.<br/> Para visualizar o feedback, clique no botão abaixo.";
            $texto->cid = "";

            $this->m_sistema->envia_email($texto);

            $rst->rst = true;
            $rst->msg = "Feedback realizado com sucesso";
        }
        else
        {
            $rst->msg = "Erro ao realizar o feedback, tente novamente mais tarde";
        }

        return $rst;
    }
}