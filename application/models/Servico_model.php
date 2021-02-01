<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servico_model extends CI_Model{
    
    function __construct() 
    {
        parent::__construct();
        $this->dados = $this->session->userdata("dados" . APPNAME);
    }

    //Faz a função que ele lista apenas a categoria se necessário.
    /**
     * Realiza a consulta de todos os servico que estão naquela subcategoria.
     * @access public
     * @param  string   $subcategoria   Nome da subcategoria.
     * @return object;
    */
    public function servico_categoria($subcategoria)
    {
        $rst = array();
        if($subcategoria)
        {
            //Consulta o id que corresponde aquela subcategoria
            $query = $this->db->get_where("Categoria", "nome = '$subcategoria'")->row();

            //Consulta todos os serviço que são daquela subcategoria
            $rst = $this->db->get_where("Servico", "ativo = 1 AND id_categoria = $query->id")->result();

            foreach($rst as $item)
            {
                //Consulta os dados do usuario que cadastrou aquele serviço.
                $this->db->select("nome, sobrenome");
                $item->usuario = $this->db->get_where("Usuario", "id = '$item->id_usuario'")->row();

                //Consulta os dados de feedback para montar o nivel.
                $this->db->group_by("id", "desc");
                $item->feedback = $this->db->get_where("Feedback", "id_servico = '$item->id'")->result();

                //Verifica se está logado para realizar a consulta se o servico está no favoritos do usuario.
                if(!empty($this->dados))
                    $item->favorito = $this->db->get_where("Favoritos", "id_servico = '$item->id' AND id_usuario = '".$this->dados->usuario_id."'")->row();
                else
                    $item->favorito = array();
            }
        }

        return $rst;
    }

    /**
     * Realiza a consulta de todas as subcategorias que estão dentro da categoria, com excecão do subcategoria que já está sendo acessada.
     * @access public
     * @param  string   $categoria   Nome da categoria.
     * @param  string   $subcategoria   Nome da subcategoria.
     * @return object;
    */
    public function get_subcategoria($categoria, $subcategoria = null)
    {
        //consulta o id da categoria.
        $query = $this->db->get_where("Categoria", "nome = '$categoria'")->row();

        if($subcategoria != null)
            //Verifica ignora a subcategoria que já está sendo acessada.
            $this->db->where("nome != '$subcategoria'");
        
        $rst = $this->db->get_where("Categoria", "id_pai = '$query->id'")->result();

        return $rst;
    }

    /**
     * Consulta todas as informações de um serviço especifico.
     * @access public
     * @param  int   $id_servico   identificador do Serviço.
     * @return object;
    */
    public function get_info_servico($id_servico)
    {
        //Consulta os dados do Serviço
        $query = $this->db->get_where("Servico", "id = '$id_servico'")->row();

        //Consulta todas as formas de pagamento cadastradas no serviço.
        $query->pagamento = $this->db->get_where("PagamentoServico", "id_servico = '$query->id'")->result();

        //Consulta todas as perguntas cadastradas naquele serviço.
        $query->perguntas = $this->db->get_where("Perguntas", "id_servico = '$query->id'")->result();

        //Consulta a subcategoria do serviço.
        $query->subcategoria = $this->db->get_where("Categoria", "id = $query->id_categoria")->row();

        //Consulta a categoria do serviço.
        $query->categoria = $this->db->get_where("Categoria", "id = ".$query->subcategoria->id_pai)->row();

        //Consulta todas as imagens cadastradas no serviço.
        $this->db->order_by("principal", "desc");
        $query->imagens = $this->db->get_where("Imagens", "id_servico = '$query->id' and ativo = 1")->result();

        //Verifica se está logado para realizar a consulta se o servico está no favoritos do usuario.
        if(!empty($this->dados))
            $query->favorito = $this->db->get_where("Favoritos", "id_servico = '$query->id' AND id_usuario = '".$this->dados->usuario_id."'")->row();
        else
            $query->favorito = array();

        return $query;
    }

    /**
     * Realiza o cadastrado de perguntas no serviço.
     * @access public
     * @return object;
    */
    public function cadastrar_pergunta()
    {
        //post da pergunta, o identificador do servico e do usuario que realizou.
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

    /**
     * Realiza o cadastro de favorito do servico ao usuario/realiza o desativamento do favorito para aquele usuario.
     * @access public
     * @return object;
    */
    public function favorita_servico()
    {
        $data = (object)$this->input->post();
        $rst = (object)array("rst" => 0);
        
        //Verifica qual o tipo de ação que será tomada.
        if($data->tipo == "preenchido")
        {
            //Desabilita o favorito naquele serviço.
            $this->db->set("ativo", 0);

            $this->db->where("id_servico = '$data->id_servico' AND '".$this->dados->usuario_id."'");
            if($this->db->update("Favoritos"))
                $rst->rst = 2;
            else
                $rst->rst = 0;
        }
        else if($data->tipo == "vazio")
        {
            //Consulta se o aquele usuario ja havia favoritado aquele serviço antes.
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

    public function datas_disponiveis()
    {
        $periodo = array();

        return $periodo;
    }

    /**
     * Realiza o cadastro da solicitação de contratação de serviço.
     * @access public
     * @return object;
    */
    public function contrata_servico()
    {
        $data = (object)$this->input->post();
        $rst = (object)array("rst" => false, "msg" => "");

        //verifica se o campo de utilizar o endereço cadastrado, está selecionado
        if(!isset($data->endereco))
        {
            //Consulta os dados de endereço do usuario.
            $this->db->select("endereco, bairro, cidade, estado");
            $query = $this->db->get_where("Usuario", "id = ".$this->dados->usuario_id)->row();

            //Consulta o nome do estado, a partir de seu id.
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

    /**
     * Realiza a verificação no texto, para maior segurança.
     * @access private
     * @param  string   $dado   Texto a ser verificado.
     * @return boolean;
    */
    private function verifica_seguranca($dado)
    {
        //Consulta todas as palavras cadastradas que estão proibidas de serem utilizadas.
        $palavras = palavra_proibidas();
        foreach($palavras as $item)
        {
            $pattern = '/' . $item . '/';
            //Verifica se as palavras proibidas estão contidas na string.
            if(preg_match($pattern, strtolower($dado)) > 0)
                return true;
        }

        return false;
    }
}