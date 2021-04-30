<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servico_model extends CI_Model{
    
    function __construct() 
    {
        parent::__construct();
        $this->dados = $this->session->userdata("dados" . APPNAME);
    }

    public function get_visibilidade($id)
    {
        $query = $this->db->get_where("Servico", "id = $id")->row();

        return $query->ativo;
    }

    public function insere_acesso($id)
    {
        $data = date("Y-m-d h:i:00", strtotime("-1 minutes"));

        if(isset($this->dados->usuario_id) && $this->dados->usuario_id != null)
        {
            $this->db->where("id_usuario = ".$this->dados->usuario_id);
            $this->db->where("data_acesso BETWEEN '".$data."' AND '".date("Y-m-d h:i:s")."'");
            $query = $this->db->get("ControleVisualizacao")->result();

            if(!$query)
            {
                $this->db->set("id_servico", $id);
                $this->db->set("id_usuario", $this->dados->usuario_id);    
                $this->db->set("data_acesso", date("Y-m-d h:i:s"));
    
                $this->db->insert("ControleVisualizacao");
            }
        }
        else
        {
            $this->db->set("id_servico", $id);                
            $this->db->set("data_acesso", date("Y-m-d h:i:s"));

            $this->db->insert("ControleVisualizacao");   
        }

        
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

        //Consulta os horarios
        $query->horario = $this->db->get_where("HorarioServico", "id_servico = '$query->id'")->result();
        foreach($query->horario as $item)
        {
            $item->dia_semana = $this->db->get_where("Horario", "id = $item->dia_semana")->row();
        }

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

    /**
     * Realiza o cadastro da solicitação de contratação de serviço.
     * @access public
     * @return object;
    */
    public function contrata_servico()
    {
        $data = (object)$this->input->post();
        $rst = (object)array("rst" => false, "msg" => "");

        $this->db->set("id_servico", $data->id_servico);
        $this->db->set("id_usuario", $this->dados->usuario_id);

        if($this->db->insert("Orcamento"))
        {
            $id_orcamento = $this->db->insert_id();

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

            $this->db->set("id_orcamento", $id_orcamento);
            $this->db->set("status", 1);
            $this->db->set("ativo", 1);
            $this->db->set("id_usuario", $this->dados->usuario_id);
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
        }

        return $rst;
    }

    public function get_categorias_principais()
    {
        $query = $this->db->get_where("Categoria", "id_pai = 0")->result();

        return $query;
    }

    public function get_subcategorias()
    {
        $lista_categoria = array();
        $data = (object)$this->input->post();
        
        $query = $this->db->get_where("Categoria", "id_pai = '$data->categoria'")->result();

        foreach($query as $item)
        {
            $lista = (object)array("id" => $item->id, "nome" => $item->nome, "filhos");
            $lista->filhos = $this->db->get_where("Categoria", "id_pai = '$item->id'")->result();

            $lista_categoria[] = $lista;
        }

        return $lista_categoria;
    }

    public function get_pagamento()
    {
        $result = $this->db->query('SELECT DISTINCT forma_pagamento FROM TipoPagamento')->result();

        foreach($result as $item)
        {
            $item->tipos = $this->db->get_where("TipoPagamento", "forma_pagamento = '$item->forma_pagamento'")->result();
        }

        return $result;
    }

    public function cadastro_servico()
    {
        $rst = (object)array("rst" => true, "msg" => "");
        $data = (object)$this->input->post();

        $this->db->set("nome", $data->nome);
        $this->db->set("descricao_curta", $data->descricao_curta);
        $this->db->set("descricao", $data->descricao_completa);
        $this->db->set("ativo", 1);
        $this->db->set("data_inclusao", date("Y-m-d h:i:s"));
        $this->db->set("data_atualizacao", date("Y-m-d h:i:s"));
        $this->db->set("id_tipo_servico", $data->tipo_servico);
        $this->db->set("id_categoria", $data->categoria_especifica);
        if($data->valor)
            $this->db->set("valor", str_replace(".", ",", explode(" ", $data->valor)[1]));
        if($data->tipo_servico == 2)
        {
            $this->db->set("quantidade_disponivel", $data->quantidade);
            $this->db->set("caucao", str_replace(".", ",", explode(" ", $data->caucao)[1]));
        }
        $this->db->set("id_usuario", $this->dados->usuario_id);

        if($this->db->insert("Servico"))
        {
            $id = $this->db->insert_id();

            $this->set_img($id);

            if($data->lista_tipo_pagamento)
            {
                $this->set_pagamento($id);
            }

            if($data->lista_tipo_horario)
            {
                $this->set_horario($id);
            }

            $rst->rst = true;
        }
        else
        {
            $rst->rst = false;
            $rst->msg = "Erro ao inserir o Serviço";
        }

        return $rst;
    }

    public function set_img ($id)
    {
        $files = $this->session->userdata("files".APPNAME);
      
        if($files)
        {
            $this->session->set_userdata("files".APPNAME, "");
            $query = $this->db->get_where("Imagens", "id_servico = $id AND principal = 1")->row();
            for($count = 0; $count < count($files); $count++)
            {
                if($count == 0 && empty($query))
                    $this->db->set("principal", 1);
                else
                    $this->db->set("principal", 0);

                $this->db->set("id_servico", $id);
                $this->db->set("ativo", 1);
                $this->db->set("nome", $files[$count]["name"]);
                $this->db->set("tipo_imagem", $files[$count]["type"]);
                $this->db->set("data_insercao", date("Y-m-d h:i:s"));
                $this->db->set("img", base64_encode(file_get_contents($files[$count]["path"])));

                $this->db->insert("Imagens");
            }

            limpa_uploads();
        }
    }

    private function set_pagamento($id)
    {
        $data = (object)$this->input->post();
        
        $lista_ini = explode(",", $data->lista_tipo_pagamento);

        $lista_c = array();

        foreach($lista_ini as $value)
        {
            $lista_c = explode("/", $value);

            if($lista_c)
            {
                $this->db->set("id_tipo_pagamento", $lista_c[0]);
                $this->db->set("vezes", $lista_c[1]);
                $this->db->set("juros", $lista_c[2]);
                $this->db->set("id_servico", $id);

                $this->db->insert("PagamentoServico");
            }
        }
        //colocar um log
    }

    private function set_horario($id)
    {
        $data = (object)$this->input->post();
        
        $lista_ini = explode(",", $data->lista_tipo_horario);
        
        $lista_c = array();

        foreach($lista_ini as $value)
        {
            $lista_c = explode("/", $value);
            
            if($lista_c)
            {
                $this->db->set("dia_semana", $lista_c[0]);
                $this->db->set("texto", $lista_c[1]." às ".$lista_c[2]);
                $this->db->set("id_servico", $id);

                $this->db->insert("HorarioServico");
            }
        }
        //colocar um log
    }

    public function get_perguntas($id, $resposta)
    {
        if($resposta == "false")
            $this->db->where("resposta IS NULL");

        $query = $this->db->get_where("Perguntas", "id_servico = $id")->result();

        foreach($query as $item)
        {
            $item->data_inclusao_br = formatar($item->data_inclusao, "bd2dt");
            $item->data_resposta_br = formatar($item->data_resposta, "bd2dt");

            $this->db->select("nome, sobrenome");
            $item->usuario_pergunta = $this->db->get_where("Usuario", "id = $item->id_usuario")->row();
        }

        return $query;
    }

    public function responder_pergunta()
    {
        $rst = (object)array("rst" => true, "msg" => "");
        $data = (object)$this->input->post();

        $this->db->set("resposta", $data->resposta);
        $this->db->set("data_resposta", date("Y-m-d"));
        
        $this->db->where("id = $data->id_pergunta");
        if($this->db->update("Perguntas"))
        {
            $rst->rst = true;
            $rst->msg = "Resposta realizada com sucesso!";
        }
        else
            $rst->msg = "Erro ao realizar resposta ao pergunta";

        return $rst;
    }

    /**
     * Consulta as ultimas mensagens do Serviço.
     * @access public
     * @param  int   $id   Identificador do Serviço.
     * @return object;
    */
    public function get_mensangens($id)
    {
        //$query = $this->db->get_where("");

        //return $query;
        return (object)array();
    }

    public function get_orcamentos($id)
    {
        $this->db->select("O.*");
        $this->db->join("ContrataServico C", "C.ativo = 1 AND O.id = C.id_orcamento");
        $rst = $this->db->get_where("Orcamento O", "O.id_servico = $id")->result();
        foreach($rst as $item)
        {
            $this->db->order_by("status", "asc");
            $item->solicitacao = $this->db->get_where("ContrataServico", "id_orcamento = '$item->id'")->result();
            $item->usuario = $this->db->get_where("Usuario", "id = $item->id_usuario")->row();
            
            if(isset($item->data_servico) && !empty($item->data_servico))
                $item->data_servico = formatar($item->data_servico, "bd2dt");

            foreach($item->solicitacao as $value)
            {
                $value->status = $this->db->get_where("OrcamentoStatus", "id = ".$value->status)->row();
                $value->data_alteracao = formatar($value->data_alteracao, "bd2dt");
            }
        }

        return $rst;
    }

    public function resposta_orcamento()
    {
        $rst = (object)array("rst" => false, "msg" => "");
        $data = (object)$this->input->post();

        $this->db->set("ativo", 0);
        $this->db->where("id_orcamento", $data->id_orcamento);
        if($this->db->update("ContrataServico"))
        {
            if($data->solicitacao_pedido == 1)
                $this->db->set("status", 2);
            elseif($data->solicitacao_pedido == 2)
                $this->db->set("status", 3);

            $this->db->set("id_orcamento", $data->id_orcamento);
            $this->db->set("id_usuario", $this->dados->usuario_id);
            $this->db->set("ativo", 1);
            $this->db->set("orcamento", $data->orcamento);
            if($data->descricao_orcamento)
                $this->db->set("descricao", $data->descricao_orcamento);

            if($this->db->insert("ContrataServico"))
            {
                $rst->rst = true;
                $rst->msg = "Resposta do Orçamento enviado";
            }
            else
            {
                $rst->msg = "Erro ao enviar resposta do Orçamento";
            }
        }

        return $rst;
    }

    public function visibilidade()
    {
        $data = (object)$this->input->post();

        $this->db->set("ativo", $data->visivel);

        $this->db->where("id", $data->servico);
        if($this->db->update("Servico"))
            return true;
        else
            return false;
    }

    public function get_info_card($id)
    {
        $rst = (object)array("visualizacao" => 0, "contratacoes" => 0, "andamento" => 0, "orcamentos" => 0);

        $ultimo_dia = date('t');
        $inicio_mes = date('Y-m-01');
        $fim_mes = date('Y-m-'.$ultimo_dia);

        $this->db->where("DATE(data_acesso) BETWEEN '$inicio_mes' AND '$fim_mes'");
        $visualizacao = $this->db->get_where("ControleVisualizacao", "id_servico = $id")->result();
        $rst->visualizacao = count($visualizacao);

        $this->db->select("O.id");
        $this->db->join("ContrataServico C", "O.id = C.id_orcamento AND C.ativo = 1 AND C.status = 4");
        $contratacoes = $this->db->get_where("Orcamento O", "O.id_servico = $id")->result();
        $rst->contratacoes = count($contratacoes);

        $this->db->select("O.id");
        $this->db->join("ContrataServico C", "O.id = C.id_orcamento AND C.ativo = 1 AND (C.status != 4 OR C.status != 5 AND C.status != 3)");
        $andamento = $this->db->get_where("Orcamento O", "O.id_servico = $id")->result();
        $rst->andamento = count($andamento);

        $this->db->select("O.id");
        $this->db->join("ContrataServico C", "O.id = C.id_orcamento AND C.ativo = 1 AND C.status = 1");
        $orcamentos = $this->db->get_where("Orcamento O", "O.id_servico = $id")->result();
        $rst->orcamentos = count($orcamentos);
        
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