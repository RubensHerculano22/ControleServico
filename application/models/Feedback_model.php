<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback_model extends CI_Model{
    
    function __construct() 
    {
        parent::__construct();
        $this->dados = $this->session->userdata("dados" . APPNAME);
    }

    public function get_servico_info($id)
    {
        $info = $this->db->get_where("Orcamento", "id = $id")->row();

        $info->servico = $this->db->get_where("Servico", "id = $info->id_servico")->row();

        $info->imagem = $this->db->get_where("Imagens", "id_servico = '$info->id_servico' AND principal = 1")->row();

        $info->contratacao = $this->db->get_where("ContrataServico", "id_orcamento = '$id' AND status = 1")->last_row();

        return $info;
    }

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