<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model{
    
    function __construct() 
    {
        parent::__construct();
        $this->dados = $this->session->userdata("dados" . APPNAME);
    }

    //Faz a função que ele lista apenas a categoria se necessário.
    public function get_cards($categoria, $subcategoria)
    {
        $rst = array();
        if($subcategoria)
        {
            $query = $this->db->get_where("Categoria", "nome = '$subcategoria'")->row();

            $rst = $this->db->get_where("Servico", "ativo = 1 AND id_categoria = $query->id")->result();

            foreach($rst as $item)
            {
                $this->db->select("usu.nome, usu.sobrenome");
                $this->db->join("Usuario usu", "usu.id = usuSer.id_usuario");
                $item->usuario = $this->db->get_where("UsuarioServico usuSer", "usuSer.id_servico = '$item->id'")->row();

                $this->db->group_by("id", "desc");
                $item->feedback = $this->db->get_where("Feedback", "id_servico = '$item->id'")->row();

                if(!empty($this->dados))
                    $item->favorito = $this->db->get_where("Favoritos", "id_servico = '$item->id' AND id_usuario = '".$this->dados->usuario_id."'")->row();
                else
                    $item->favorito = array();
            }
        }

        return $rst;
    }

    public function get_subcategoria($categoria, $subcategoria = null)
    {
        $query = $this->db->get_where("Categoria", "nome = '$categoria'")->row();

        if($subcategoria != null)
            $this->db->where("nome != '$subcategoria'");
        $rst = $this->db->get_where("Categoria", "id_pai = '$query->id'")->result();

        return $rst;
    }

    public function get_servico_info($id)
    {
        $query = $this->db->get_where("Servico", "id = '$id'")->row();

        $query->usuario_servico = $this->db->get_where("UsuarioServico", "id_servico = '$query->id'")->row();   
        $query->pagamento = $this->db->get_where("PagamentoServico", "id_servico = '$query->id'")->result();

        if(!empty($this->dados))
            $query->favorito = $this->db->get_where("Favoritos", "id_servico = '$query->id' AND id_usuario = '".$this->dados->usuario_id."'")->row();
        else
            $query->favorito = array();

        $this->db->order_by("principal", "desc");
        $query->imagens = $this->db->get_where("Imagens", "id_servico = '$query->id' and ativo = 1")->result();
        $query->perguntas = $this->db->get_where("Perguntas", "id_servico = '$query->id'")->result();

        

        return $query;
    }

    public function perguntar()
    {
        $data = (object)$this->input->post();
        $rst = (object)array("rst" => false, "msg" => "", "pergunta" => "");

        if($this->verifica_seguranca($data->pergunta))
        {
            $rst->msg = "Palavra utilizada para o acesso é proibida!";

            return $rst;
        }

        $this->db->set("pergunta", $data->pergunta);
        $this->db->set("data_inclusao", "date('now')", false);
        $this->db->set("id_servico", $data->id_servico);
        $this->db->set("id_usuario", $this->dados->usuario_id);
        $this->db->set("id_usuario_servico", $data->id_usuario);

        if($this->db->insert("Perguntas"))
        {
            $rst->rst = true;
            $rst->msg = "Pergunta registrada com sucesso, quando houver uma resposta, você será notificado!";
        }
        else
        {
            $rst->msg = "Erro ao registrar a pergunta, tente novamente mais tarde.";
        }

        return $rst;
    }

    public function favoritar()
    {
        $data = (object)$this->input->post();
        $rst = (object)array("rst" => 0);
        
        if($data->tipo == "preenchido")
        {
            $this->db->set("ativo", 0);

            $this->db->where("id_servico = '$data->id_servico' AND '".$this->dados->usuario_id."'");
            if($this->db->update("Favoritos"))
                $rst->rst = 2;
            else
                $rst->rst = 0;
        }
        else if($data->tipo == "vazio")
        {
            $query = $this->db->get_where("Favoritos", "id_servico = '$data->id_servico' AND id_usuario = '".$this->dados->usuario_id."'")->row();

            if($query)
            {
                $this->db->set("ativo", 1);

                $this->db->where("id = '$query->id'");
                if($this->db->update("Favoritos"))
                    $rst->rst = 1;
                else
                    $rst->rst = 0;
            }
            else
            {
                $this->db->set("data_inclusao", "date('now')", false);
                $this->db->set("data_inclusao", "date('now')", false);
                $this->db->set("ativo", 1);
                $this->db->set("id_servico", $data->id_servico);
                $this->db->set("id_usuario", $this->dados->usuario_id);

                if($this->db->insert("Favoritos"))
                    $rst->rst = 1;
                else
                    $rst->rst = 0;
            }
        }

        return $rst;
    }

    public function get_servico_favorito()
    {
        $query = $this->db->get_where("Favoritos", "id_usuario = ".$this->dados->usuario_id." AND ativo = 1")->result();

        echo '<pre>';
        print_r($query);
        echo '</pre>';
        exit;
    }

    public function contrata_servico()
    {
        $data = (object)$this->input->post();
        $rst = (object)array("rst" => false, "msg" => "");

        if(!isset($data->endereco))
        {
            $this->db->select("endereco, bairro, cidade, estado");
            $query = $this->db->get_where("Usuario", "id = ".$this->dados->usuario_id)->row();

            $estado = get_estados_id($query->estado);

            $data->endereco = $query->endereco.", ".$query->bairro." - ".$query->cidade.", ".$estado->nome."";
        }

        $this->db->set("id_servico", $data->id_servico);
        $this->db->set("id_solicitante", $this->dados->usuario_id);
        $this->db->set("data_servico", formatar($data->data_servico, "dt2bd"));
        $this->db->set("hora_servico", $data->hora_servico);
        $this->db->set("descricao", $data->descricao);
        $this->db->set("endereco", $data->endereco);

        if($this->db->insert("ContrataServico"))
        {
            $rst->rst = true;
            $rst->msg = "Solicitação de serviço enviado para o Prestador";
        }
        else
        {
            $rst->msg = "Erro ao solicitar o serviço, tente novamente mais tarde.";
        }

        return $rst;
    }

    private function verifica_seguranca($dado)
    {
        $palavras = palavra_proibidas();
        foreach($palavras as $item)
        {
            $pattern = '/' . $item . '/';

            if(preg_match($pattern, strtolower($dado)) > 0)
                return true;
        }

        return false;
    }
}