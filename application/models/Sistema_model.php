<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sistema_model extends CI_Model{
    
    function __construct() 
    {
        parent::__construct();        
    }

    /**
     * Lista de todas as categorias, sendo criado indexes com base em seu id pai.
     * @access public
     * @param  string   $dado   Texto a ser verificado.
     * @return object;
    */
    public function listar_categorias()
    {
        $categoria = $this->db->get_where("Categoria", "id_pai = 0")->result();

        $rst = array();

        foreach($categoria as $key => $item)
        {
            $subcategoria = $this->db->get_where("Categoria", "id_pai = $item->id")->result();

            $rst2 = array();
            foreach($subcategoria as  $value)
            {
                $query = $this->db->get_where("Categoria", "id_pai = $value->id")->result();

                $rst2[] = array("id" => $value->id, "nome" => $value->nome, "icon" => $value->icon, "filho" => $query);
            }

            $rst[] = array("id" => $item->id, "nome" => $item->nome, "filho" => $rst2);
        }
        return $rst;
    }

    /**
     * Lista todos padrões de colores do sistema.
     * @access public
     * @return object;
    */
    public function get_colores()
    {
        return $this->db->get_where("Colores", "id = 1")->row();
    }

    /**
     * Registra a vista ao serviço.
     * @access public
     * @param  $id  int Identificador do Serviço
     * @return object;
    */
    public function insere_acesso($id)
    {
        $data = date("Y-m-d H:i:00", strtotime("-5 minutes"));
        $this->dados = $this->session->userdata("dados" . APPNAME);

        if(isset($this->dados->usuario_id) && $this->dados->usuario_id != null)
        {
            $this->db->where("id_usuario = ".$this->dados->usuario_id);
            $this->db->where("data_acesso BETWEEN '".$data."' AND '".date("Y-m-d H:i:s")."'");
            $query = $this->db->get("ControleVisualizacao")->result();

            if(!$query)
            {
                $this->db->set("id_servico", $id);
                $this->db->set("id_usuario", $this->dados->usuario_id);    
                $this->db->set("data_acesso", date("Y-m-d H:i:s"));
    
                $this->db->insert("ControleVisualizacao");
            }
        }
        else
        {
            $this->db->set("id_servico", $id);                
            $this->db->set("data_acesso", date("Y-m-d H:i:s"));

            $this->db->insert("ControleVisualizacao");   
        }
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
     * Realiza o cadastro de favorito do servico ao usuario/realiza o desativamento do favorito para aquele usuario.
     * @access public
     * @param object $texto texto com todos os itens para montagem do email
     * @return object;
    */
    public function envia_email($texto)
    {
        $remetente["email"] = "nextoyou@nextoyou.com.br";
        $remetente["nome"] = "NextoYou";
        $destinatario["email"] = $texto->email;
        $destinatario["assunto"] = $texto->titulo;
        $destinatario["mensagem"]["titulo"] = $texto->titulo;
        $destinatario["mensagem"]["mensagem"] = $texto->msg;
        $destinatario["mensagem"]["link"] = $texto->link;
        $destinatario["mensagem"]["texto_link"] = $texto->texto_link;
        $destinatario["mensagem"]["cid"] = $texto->cid;
        
        $mail = $this->sistema->enviar_email((object)$remetente, (object)$destinatario); 
        //  $mail = true;
        if($mail)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Realiza a verificação no texto, para maior segurança.
     * @access public
     * @param  string   $dado   Texto a ser verificado.
     * @return boolean;
    */
    public function verifica_seguranca($dado)
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

    /**
     * Monta os itens para notificação
     * @access public
     * @return array;
    */
    public function monta_notificacao()
    {
        $this->dados = $this->session->userdata("dados" . APPNAME);
        
        $notificacao = array();
        if($this->dados)
            $notificacao = array_merge($this->notificacao_usuario($this->dados->usuario_id), $this->notificacao_prestador($this->dados->usuario_id));

        sort($notificacao);

        return $notificacao;
    }

    /**
     * Realiza a montagem dos itens para notificação para o usuario comum
     * @access public
     * @param  int   $id   Identificador do Usuario.
     * @return array
    */
    public function notificacao_usuario($id)
    {
        $notificacao = array();

        $item = (object)array("time" => "", "texto" => "", "icon" => "", "link" => "");

        //Verifica se o usuario está ativo no sistema
        $queryAtivacao = $this->db->get_where("Usuario", "id = $id")->row();
        if($queryAtivacao->ativar_conta == 0)
        {
            $item->time = $queryAtivacao->data_criacao;
            $item->texto = "Você precisa ativar a conta ainda";
            $item->icon = "fas fa-check";
            $item->link = base_url("Usuario/perfil/dados");
            $notificacao[] = $item;
        }

        $hoje = date("Y-m-d");
        $anterior = date("Y-m-d", strtotime("-3 days"));

        //Verifica se possui perguntas que foram respondidas nos ultimos 3 dias
        $queryPergunta = $this->db->get_where("Perguntas", "id_usuario = '$id' AND DATE(data_resposta) BETWEEN '$anterior' AND '$hoje'")->result();
        foreach($queryPergunta as $value)
        {
            $query = $this->db->get_where("Servico", "id = $value->id_servico")->row();

            $item->time = $queryPergunta->data_resposta;
            $item->texto = "Sua pergunta no serviço: $query->nome foi respondida pelo Prestador";
            $item->icon = "far fa-comment-dots";
            $item->link = base_url("Servico/detalhes/$query->nome/$query->id");

            $notificacao[] = $item;
        }

        $this->db->select("C.*, S.nome");
        $this->db->join("Servico S", "S.id = O.id_servico");
        $this->db->join("ContrataServico C", "C.id_orcamento = O.id AND C.ativo = 1");
        $this->db->where("O.id_usuario = $id");
        $this->db->where("(C.status = 2 OR C.status = 7)");
        $queryServico = $this->db->get("Orcamento O")->result();
        foreach($queryServico as $value)
        {
            //Verifica se o Prestador gerou um Orçamento para o Cliente
            if($value->status == 2)
            {
                $item->time = $value->data_alteracao;
                $item->texto = "O prestador gerou o Orçamento para o serviço que você solicitou";
                $item->icon = "fas fa-pen";
                $item->link = base_url("Usuario/controle_pedido/$value->id_orcamento");

                $notificacao[] = $item;
            }
            //Realiza aviso para o cliente que já está disponivel para ele realizar feedback
            else
            {
                $queryFeedback = $this->db->get_where("Feedback", "id_orcamento = $value->id_orcamento")->row();
                if(!$queryFeedback)
                {
                    $item->time = $value->data_alteracao;
                    $item->texto = "O serviço foi realizado, diga para o prestador o que você achou do serviço!";
                    $item->icon = "fas fa-envelope-open-text";
                    $item->link = base_url("Feedback/index/$value->id_orcamento");

                    $notificacao[] = $item;
                }
            }
        }

        return $notificacao;
    }

    /**
     * Realiza a montagem dos itens para notificação para o prestador de serviço comum
     * @access public
     * @param  int   $id   Identificador do Usuario.
     * @return array
    */
    public function notificacao_prestador($id)
    {
        $notificacao = array();

        //Consulta todos os serviços cadastrados pelo usuario
        $servico = $this->db->get_where("Servico", "id_usuario = $id")->result();
        
        foreach($servico as $value)
        {
            //Verifica se possui alguma pergunta sem resposta no serviço
            $queryPergunta = $this->db->get_where("Perguntas", "id_servico = '$value->id' AND resposta IS NULL")->row();
            if($queryPergunta)
            {
                $item = (object)array("time" => "", "texto" => "", "icon" => "", "link" => "");

                $item->time = $queryPergunta->data_inclusao;
                $item->texto = "Uma pergunta no serviço: $value->nome foi realizada";
                $item->icon = "fas fa-comment-alt";
                $item->link = base_url("Servico/gerenciar_servico/$value->id");
    
                $notificacao[] = $item;
            }

            $this->db->select("C.*, S.nome");
            $this->db->join("Servico S", "S.id = O.id_servico");
            $this->db->join("ContrataServico C", "C.id_orcamento = O.id AND C.ativo = 1");
            $this->db->where("O.id_servico = $value->id");
            $this->db->where("(C.status = 1 OR C.status = 4 OR C.status = 5)");
            $queryServico = $this->db->get("Orcamento O")->result();
            foreach($queryServico as $row)
            {
                //Verifica se o Serviço possui algum orçamento em aberto
                if($row->status == 1)
                {
                    $item = (object)array("time" => "", "texto" => "", "icon" => "", "link" => "");

                    $item->time = $row->data_alteracao;
                    $item->texto = "Um cliente solicitou um Orçamento";
                    $item->icon = "fas fa-comment-dollar";
                    $item->link = base_url("Servico/movimentacao/$row->id_orcamento");
    
                    $notificacao[] = $item;
                }
                //Verifica se possui algum serviço disponivel para ser finalizado
                elseif($row->status == 4)
                {
                    $item = (object)array("time" => "", "texto" => "", "icon" => "", "link" => "");

                    $item->time = $row->data_alteracao;
                    $item->texto = "O cliente aceitou o Orçamento, clique para definir como realizado";
                    $item->icon = "fas fa-clipboard-check";
                    $item->link = base_url("Servico/movimentacao/$row->id_orcamento");
    
                    $notificacao[] = $item;
                }
                //Verifica se o possui algum orçamento que foi recusado
                else
                {
                    $queryFeedback = $this->db->get_where("Feedback", "id_orcamento = $row->id_orcamento")->row();
                    if(!$queryFeedback)
                    {
                        $item = (object)array("time" => "", "texto" => "", "icon" => "", "link" => "");

                        $item->time = $row->data_alteracao;
                        $item->texto = "O cliente recusou o orçamento, acessa para realizar outro";
                        $item->icon = "fas fa-handshake-alt-slash";
                        $item->link = base_url("Servico/movimentacao/$row->id_orcamento");
    
                        $notificacao[] = $item;
                    }
                }
            }
        }

        return $notificacao;
    }
}