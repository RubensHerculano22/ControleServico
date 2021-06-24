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
        $data = date("Y-m-d H:i:00", strtotime("-5 minutes"));

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

    public function avise_me()
    {
        $rst = (object)array("rst" => false, "msg" => "");
        $data = (object)$this->input->post();

        $query = $this->db->get_where("AviseMe", "id_servico = '$data->id_servico' AND email = '$data->email' AND avisado = 0")->row();
        if($query)
        {
            $rst->msg = "Seu email já está cadastrado para ser avisado neste serviço";
        }
        else
        {
            $this->db->set("email", $data->email);
            $this->db->set("id_servico", $data->id_servico);
    
            if($this->db->insert("AviseMe"))
            {
                $rst->rst = true;
            }
            else
            {
                $rst->msg = "Erro ao salvar o email";
            }
        }

        return $rst;
    }

    /**
     * Consulta todos os dados para o card.
     * @access private
     * @param  object   $servico   Dados da Tabela de Serviço.
     * @return object;
    */
    private function get_card($servico)
    {
        //Consulta os dados do usuario que cadastrou aquele serviço.
        $this->db->select("nome, sobrenome");
        $servico->usuario = $this->db->get_where("Usuario", "id = '$servico->id_usuario'")->row();

        //Consulta os dados de feedback para montar o nivel.
        $servico->feedback = $this->media_feedback($servico->id);

        //Consulta do Ultimo feedaback
        $this->db->select("F.*");
        $this->db->join("Orcamento O", "O.id_servico = '$servico->id'");
        $this->db->order_by("data_inclusao", "desc");
        $query_ult_feedback = $this->db->get_where("Feedback F", "F.id_orcamento = O.id")->row();     
        if($query_ult_feedback)           
            $servico->ult_feedback = strlen ($query_ult_feedback->descricao) > 100 ? substr($query_ult_feedback->descricao, 0, 100)." ..." : $query_ult_feedback->descricao;
        else
        {
            $servico->ult_feedback = "";
        }

        //Verifica se está logado para realizar a consulta se o servico está no favoritos do usuario.
        if(!empty($this->dados))
            $servico->favorito = $this->db->get_where("Favoritos", "id_servico = '$servico->id' AND id_usuario = '".$this->dados->usuario_id."'")->row();
        else
            $servico->favorito = array();

        return $servico;
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
        $cidade = $this->session->userdata("cidade");
        $rst = array();
        if($subcategoria && $cidade)
        {
            //Consulta o id que corresponde aquela subcategoria
            $query = $this->db->get_where("Categoria", "nome = '$subcategoria'")->row();

            //Consulta todos os serviço que são daquela subcategoria
            $rst = $this->db->get_where("Servico", "ativo = 1 AND id_categoria = '$query->id' AND cidade = '$cidade->id_cidade'")->result();
            foreach($rst as $item)
            {
                $item = $this->get_card($item);
            }
        }

        return $rst;
    }

    public function get_ult_feedbacks()
    {
        $query_servico = $this->db->get_where("Servico", "ativo = 1")->result();

        $lista_feedback = array();
        foreach($query_servico as $item)
        {
            $lista_feedback[] = array($this->media_feedback($item->id), $item);
        }

        arsort($lista_feedback);
        $lista_feedback = array_values($lista_feedback);        

        $result = array();
        for($i=0; $i<6;$i++)
        {
            $servico = $lista_feedback[$i][1];
            $servico = $this->db->get_where("Servico", "id = $servico->id")->row();

            $result[] = $this->get_card($servico);
        }

        return $result;
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

        $query->tipo_pagamento = (object)array("credito" => 0, "debito" => 0, "transferencia" => 0, "boleto" => 0);
        foreach($query->pagamento as $item)
        {
            $item->tipo_pagamento = $this->db->get_where("TipoPagamento", "id = $item->id_tipo_pagamento")->row();
            if($item->tipo_pagamento->forma_pagamento == "Crédito")
                $query->tipo_pagamento->credito = 1;
            elseif($item->tipo_pagamento->forma_pagamento == "Débito")
                $query->tipo_pagamento->debito = 1;
            elseif($item->tipo_pagamento->forma_pagamento == "Transferência/Pix")
                $query->tipo_pagamento->transferencia = 1;
            elseif($item->tipo_pagamento->forma_pagamento == "Outros")
                $query->tipo_pagamento->boleto = 1;
        }

        //Consulta todas as perguntas cadastradas naquele serviço.
        $query->perguntas = $this->db->get_where("Perguntas", "id_servico = '$query->id'")->result();

        //Consulta a sub da subcategoria do serviço.
        $query->subcategoria = $this->db->get_where("Categoria", "id = $query->id_categoria")->row();

        //Consulta a subcategoria do serviço.
        $query->categoria = $this->db->get_where("Categoria", "id = ".$query->subcategoria->id_pai)->row();

        //Consulta a categoria do serviço.
        $query->categoria_pai = $this->db->get_where("Categoria", "id = ".$query->categoria->id_pai)->row();

        //Consulta os horarios
        $this->db->order_by("dia_semana", "asc");
        $query->horario = $this->db->get_where("HorarioServico", "id_servico = '$query->id'")->result();
        foreach($query->horario as $item)
        {
            $item->dia_semana = $this->db->get_where("Horario", "id = $item->dia_semana")->row();
        }

        //Consulta o estado
        $query->estado = $this->db->get_where("Estados", "id = '$query->estado'")->row();

        //Consulta a cidade
        $query->cidade = $this->get_cidades_id($query->cidade);

        //Consulta todas as imagens cadastradas no serviço.
        $this->db->order_by("principal", "desc");
        $query->imagens = $this->db->get_where("Imagens", "id_servico = '$query->id' and ativo = 1")->result();

        //Formata o valor para o formato br
        if($query->valor)
        {
            $valor_V = explode(",", $query->valor);
            $valor = str_replace(".", ",", $valor_V[0]);
            if(isset($valor_V[1]))
                $query->valor_D = $valor.".".$valor_V[1];
            else
            {
                $query->valor = $valor.",00";
                $query->valor_D = $valor.".00";
            }
                
        }

        //Formata o valor para o formato br
        if($query->caucao)
        {
            $valor_V = explode(",", $query->caucao);
            $valor = str_replace(".", ",", $valor_V[0]);
            if(isset($valor_V[1]))
                $query->caucao_D = $valor.".".$valor_V[1];
            else
            {
                $query->caucao = $valor.",00";
                $query->caucao_D = $valor.".00";
            }
        }


        //consulta a lista de Orçamentos daquele serviço
        $lista_orcamento = $this->db->get_where("Orcamento", "id_servico = $id_servico")->result();
        
        $lista_feedback = array();
        foreach($lista_orcamento as $item)
        {
            $usuario = $this->db->get_where("Usuario", "id = $item->id_usuario")->row();
            $feedback = $this->db->get_where("Feedback", "id_orcamento = $item->id")->row();
            if($feedback != null && $usuario != null)
            {
                // $media_feedback += $feedback->quantidade_estrelas;
                list($data, $hora) = explode(" ", $feedback->data_inclusao);
                $feedback->data_br = formatar($data, "bd2dt");
                $lista_feedback[] = array($usuario, $feedback);
            }
        }

        if($query->id_tipo_servico == 2)
        {
            $quant_contrata_servico = 0;
            
            foreach($lista_orcamento as $item)
            {
                $contrata_servico = $this->db->get_where("ContrataServico", "id_orcamento = '$item->id' AND ativo = 1 AND status NOT IN ('3', '6', '7')")->result();

                if($contrata_servico)
                    $quant_contrata_servico++;
            }

            $query->quantidade_contratada = $quant_contrata_servico;

            if($quant_contrata_servico >= $query->quantidade_disponivel)
                $query->disponibilidade = 0;
            else
                $query->disponibilidade = 1;
        }

        //consulta a media de feedback do serviço
        $query->media_feedback = $this->media_feedback($id_servico);

        //Montagem da Quantidade de estrela por nivel
        $query->estrelas_feedback = array("0" => 0, "1" => 0, "2" => 0, "3" => 0, "4" => 0, "5" => 0);
        for($i=1;$i<=5;$i++)
            $query->estrelas_feedback[0] += $query->estrelas_feedback[$i] = $this->quantidade_estrelas($id_servico, ($i*2));
    

        //Pagina de detalhes
        $query->feedback = $lista_feedback;

        //Verifica se está logado para realizar a consulta se o servico está no favoritos do usuario.
        if(!empty($this->dados))
            $query->favorito = $this->db->get_where("Favoritos", "id_servico = '$query->id' AND id_usuario = '".$this->dados->usuario_id."'")->row();
        else
            $query->favorito = array();

        // echo '<pre>';
        // print_r($query);
        // echo '</pre>';
        // exit;

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
        $this->db->set("data_inclusao", date('Y-m-d H:i:s'));
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
            if(!isset($data->endereco_cadastrado))
                $this->db->set("endereco", $data->endereco_select);
            else
            {
                $endereco = $data->cep." - ".$data->endereco.($data->complemento ? ", ".$data->complemento : "").", ".$data->numero.", ".$data->bairro." - ".$data->cidade.", ".$data->estado;
                $this->db->set("endereco", $endereco);
            }

            $this->db->set("id_orcamento", $id_orcamento);
            $this->db->set("status", 1);
            $this->db->set("ativo", 1);
            $this->db->set("id_usuario", $this->dados->usuario_id);
            $this->db->set("data_servico", formatar($data->data_servico, "dt2bd"));
            $this->db->set("hora_servico", $data->horario_servico);
            $this->db->set("descricao", $data->descricao);
            $this->db->set("data_alteracao", date("Y-m-d H:i:s"));

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

    public function get_subcategorias($id)
    {
        $lista_categoria = array();
        $data = (object)$this->input->post();
        
        $query = $this->db->get_where("Categoria", "id_pai = '$id'")->result();

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

    public function get_estados()
    {
        $query = $this->db->get("Estados")->result();

        return $query;
    }

    public function get_estado_sigla($sigla)
    {
        $query = $this->db->get_where("Estados", "sigla = $sigla")->row();

        return $query;
    }

    public function get_cidades($id)
    {
        $json = file_get_contents(base_url("assets/Cidades.json"));
        $data = json_decode($json);

        $lista = array();
        foreach($data as $item)
        {
            if($item->Estado == $id)
                $lista[] = $item;
        }

        return $lista;
    }

    public function get_cidades_id($id_cidade)
    {
        $json = file_get_contents(base_url("assets/Cidades.json"));
        $data = json_decode($json);

        foreach($data as $item)
        {
            if($item->ID == $id_cidade)
                return $item;
        }
    }

    public function lista_horarios()
    {
        return $this->db->get("ListaHorario")->result();
    }

    public function cadastro_servico()
    {
        $rst = (object)array("rst" => true, "msg" => "", "id" => 0);
        $data = (object)$this->input->post();

        $this->db->set("nome", $data->nome);
        $this->db->set("descricao_curta", $data->descricao_curta);
        $this->db->set("descricao", $data->descricao_completa);
        $this->db->set("ativo", 1);
        $this->db->set("data_inclusao", date("Y-m-d H:i:s"));
        $this->db->set("data_atualizacao", date("Y-m-d H:i:s"));
        $this->db->set("id_tipo_servico", $data->tipo_servico);
        $this->db->set("id_categoria", $data->categoria_especifica);

        if(isset($data->local) && $data->local == "on")
        {
            $this->db->set("cep", $data->cep);
            $this->db->set("estado", $this->get_estado_nome($data->estado));
            $this->db->set("cidade", $this->get_cidade_nome($data->cidade));
            $this->db->set("bairro", $data->bairro);
            $this->db->set("endereco", $data->endereco);
            $this->db->set("numero", somente_numeros($data->numero));
            $this->db->set("complemento", $data->complemento);
        }
        else
        {
            $this->db->set("estado", $data->estado_select);
            $this->db->set("cidade", $data->cidade_select);
        }
        
        if($data->valor)
        {
            $valor_T = explode(" ", $data->valor);
            $valor_V = explode(".", $valor_T[1]);
            $valor = str_replace(",", ".", $valor_V[0]);
            $this->db->set("valor", $valor.",".$valor_V[1]);
        }
        if($data->tipo_servico == 2)
        {
            $this->db->set("quantidade_disponivel", $data->quantidade);
            if($data->caucao)
            {
                $valor_T = explode(" ", $data->caucao);
                $valor_V = explode(".", $valor_T[1]);
                $valor = str_replace(",", ".", $valor_V[0]);
                $this->db->set("caucao", $valor.",".$valor_V[1]);
            }
        }
        $this->db->set("id_usuario", $this->dados->usuario_id);

        if($this->db->insert("Servico"))
        {
            $rst->id = $id = $this->db->insert_id();

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
                $this->db->set("data_insercao", date("Y-m-d H:i:s"));
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

        $this->db->order_by("data_inclusao", "desc");
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
        $this->db->set("data_resposta", date('Y-m-d H:i:s'));
        
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

    public function get_orcamentos($id)
    {
        $this->db->select("O.*");
        $this->db->join("ContrataServico C", "C.ativo = 1 AND O.id = C.id_orcamento");
        $rst = $this->db->get_where("Orcamento O", "O.id_servico = $id")->result();
        foreach($rst as $item)
        {

            $this->db->order_by("id", "desc");
            $queryInicialStatus = $this->db->get_where("ContrataServico", "id_orcamento = '$item->id' AND status = 1")->row();
            $item->descricao = $queryInicialStatus->descricao;
            $item->data_servico = formatar($queryInicialStatus->data_servico, "bd2dt");
            $item->hora_servico = $queryInicialStatus->hora_servico;

            $item->usuario = $this->db->get_where("Usuario", "id = $item->id_usuario")->row();

            $item->solicitacao = $this->db->get_where("ContrataServico", "id_orcamento = '$item->id' AND ativo = 1")->row();
            $item->solicitacao->data_alteracao = formatar($item->solicitacao->data_alteracao, "bd2dt");
            $item->solicitacao->status = $this->db->get_where("OrcamentoStatus", "id = ".$item->solicitacao->status)->row();
        }

        return $rst;
    }

    public function get_info_orcamentos($id)
    {
        $this->db->order_by("id", "desc");
        $query = $this->db->get_where("ContrataServico", "id_orcamento = $id")->result();

        foreach($query as $item)
        {
            $this->db->select("id_servico");
            $item->id_servico = $this->db->get_where("Orcamento", "id = $id")->row()->id_servico;
            $item->status = $this->db->get_where("OrcamentoStatus", "id = $item->status")->row();

            if($item->status->id == 4)
            {
                $this->db->order_by("id", "desc");
                $queryInfo = $this->db->get_where("ContrataServico", "id_orcamento = '$id' AND status = 1")->row();

                $item->data_servico = $queryInfo->data_servico;
                $item->hora_servico = $queryInfo->hora_servico;
            }

            if(isset($item->data_servico) && !empty($item->data_servico))
                $item->data_servico = formatar($item->data_servico, "bd2dt");

            $item->data_alteracao = formatar($item->data_alteracao, "bd2dt");
            
            $this->db->select("id, nome");
            $item->usuario = $this->db->get_where("Usuario", "id = $item->id_usuario")->row();
        }

        return $query;
    }

    public function resposta_orcamento()
    {
        $rst = (object)array("rst" => false, "msg" => "");
        $data = (object)$this->input->post();

        $this->db->set("ativo", 0);
        $this->db->where("id_orcamento", $data->id_orcamento);
        if($this->db->update("ContrataServico"))
        {
            if($data->aceite_orcamento == 1)
                $this->db->set("status", 2);
            elseif($data->aceite_orcamento == 0)
                $this->db->set("status", 3);

            $this->db->set("id_orcamento", $data->id_orcamento);
            $this->db->set("id_usuario", $this->dados->usuario_id);
            $this->db->set("ativo", 1);

            if($data->orcamento)
                $this->db->set("orcamento", $data->orcamento);

            $this->db->set("data_alteracao", date("Y-m-d H:i:s"));
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

    public function get_endereco()
    {
        if($this->dados)
        {
            $query = $this->db->get_where("Enderecos", "id_usuario = ".$this->dados->usuario_id)->result();
        
            foreach($query as $item)
            {
                //Consulta o estado
                $item->estado = $this->db->get_where("Estados", "id = '$item->estado'")->row();
    
                //Consulta a cidade
                $item->cidade = $this->get_cidades_id($item->cidade);
                $item->endereco_completo = $item->cep." - ".$item->endereco.($item->complemento ? ", ".$item->complemento : "").", ".$item->numero.", ".$item->bairro." - ".$item->cidade->Nome.", ".$item->estado->nome."(".$item->estado->sigla.")";
            }

            return $query;
        }
        else
        {
            return (object)array();
        }

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
        $this->db->join("ContrataServico C", "O.id = C.id_orcamento AND C.ativo = 1 AND (C.status = 1 OR C.status = 5)");
        $orcamentos = $this->db->get_where("Orcamento O", "O.id_servico = $id")->result();
        $rst->orcamentos = count($orcamentos);
        
        return $rst;
    }

    public function cancela_servico($id)
    {
        $dados = $this->session->userdata("dados" . APPNAME);

        $this->db->set("ativo", 0);
        $this->db->where("id_orcamento = '$id'");
        if($this->db->update("ContrataServico"))
        {
            $this->db->set("id_orcamento", $id);
            $this->db->set("status", 6);
            $this->db->set("ativo", 1);
            $this->db->set("id_usuario", $dados->usuario_id);
            $this->db->set("data_alteracao", date("Y-m-d h:i:s"));

            if($this->db->insert("ContrataServico"))
            {
                return true;
            }
        }

        return false;
    }

    public function editar_servico()
    {
        $rst = (object)array("rst" => false, "msg" => "", "id" => 0);
        $data = (object)$this->input->post();

        $this->db->set("nome", $data->nome);
        $this->db->set("descricao_curta", $data->descricao_curta);
        $this->db->set("descricao", $data->descricao_completa);
        $this->db->set("data_atualizacao", date("Y-m-d H:i:s"));
        $this->db->set("id_tipo_servico", $data->tipo_servico);
        $this->db->set("id_categoria", $data->categoria_especifica);
        $this->db->set("estado", $data->estado);
        $this->db->set("cidade", $data->cidade);
        if(isset($data->local) && $data->local)
        {
            $this->db->set("cep", $data->cep);
            $this->db->set("estado", $this->get_estado_nome($data->estado));
            $this->db->set("cidade", $this->get_cidade_nome($data->cidade));
            $this->db->set("bairro", $data->bairro);
            $this->db->set("endereco", $data->endereco);
            $this->db->set("numero", somente_numeros($data->numero));
            $this->db->set("complemento", $data->complemento);
        }
        else
        {
            $this->db->set("estado", $data->estado_select);
            $this->db->set("cidade", $data->cidade_select);
            $this->db->set("cep", "");
            $this->db->set("bairro", "");
            $this->db->set("endereco", "");
            $this->db->set("numero", "");
            $this->db->set("complemento", "");
            $this->db->set("endereco", "");
        }

        if($data->valor)
        {
            $valor_T = explode(" ", $data->valor);
            $valor_V = explode(".", $valor_T[1]);
            $valor = str_replace(",", ".", $valor_V[0]);
            $this->db->set("valor", $valor.",".$valor_V[1]);
        }
        else
        {
            $this->db->set("valor", "");
        }

        if($data->tipo_servico == 2)
        {
            $this->db->set("quantidade_disponivel", $data->quantidade);
            if($data->caucao)
            {
                $valor_T = explode(" ", $data->caucao);
                $valor_V = explode(".", $valor_T[1]);
                $valor = str_replace(",", ".", $valor_V[0]);
                $this->db->set("caucao", $valor.",".$valor_V[1]);
            }
        }
        else
        {
            $this->db->set("quantidade_disponivel", 0);
            $this->db->set("caucao", "");
        }

        $this->db->where("id", $data->id_servico);
        if($this->db->update("Servico"))
        {
            $rst->id = $id = $data->id_servico;

            if($data->lista_tipo_pagamento)
            {
                $this->db->where("id_servico", $id);
                if($this->db->delete("PagamentoServico"))
                {
                    $this->set_pagamento($id);
                }
            }

            if($data->lista_tipo_horario)
            {
                $this->db->where("id_servico", $id);
                if($this->db->delete("HorarioServico"))
                {
                    $this->set_horario($id);
                }
            }

            $rst->rst = true;
            $rst->msg = "Serviço editado com sucesso!";
        }

        return $rst;
    }

    public function get_imagens($id)
    {
        $query = $this->db->get_where("Imagens", "id_servico = '$id'")->result();

        return $query;
    }

    public function insere_imagem()
    {
        $rst = (object)array("rst" => false, "msg" => "");
        $data = (object)$this->input->post();
        
        $files = $this->session->userdata("files".APPNAME);

        $this->session->set_userdata("files".APPNAME, "");

        if($data->id_imagem)
        {
            $this->db->set("nome", $files[0]["name"]);
            $this->db->set("tipo_imagem", $files[0]["type"]);
            $this->db->set("data_insercao", date("Y-m-d H:i:s"));
            $this->db->set("img", base64_encode(file_get_contents($files[0]["path"])));

            $this->db->where("id", $data->id_imagem);
            if($this->db->update("Imagens"))
            {
                $rst->rst = true;
                $rst->msg = "Imagem alterada com sucesso";
            }
            else
            {
                $rst->msg = "Erro ao alterar a imagem";
            }
        }
        else
        {
            if(isset($data->principal) && !empty($data->principal))
            {
                $this->db->set("principal", 0);
    
                $this->db->where("id_servico", $data->id_servico);
                $this->db->update("Imagens");
    
                $this->db->set("principal", 1);
            }
            else
            {
                $this->db->set("principal", 0);
            }
    
            $this->db->set("ativo", 1);
            $this->db->set("id_servico", $data->id_servico);
            $this->db->set("nome", $files[0]["name"]);
            $this->db->set("tipo_imagem", $files[0]["type"]);
            $this->db->set("data_insercao", date("Y-m-d H:i:s"));
            $this->db->set("img", base64_encode(file_get_contents($files[0]["path"])));
    
            if($this->db->insert("Imagens"))
            {
                $rst->rst = true;
                $rst->msg = "Imagem inserida com sucesso";
            }
            else
            {
                $rst->msg = "Erro ao inserir a imagem";
            }
        }

        return $rst;
    }

    public function troca_principal()
    {
        $rst = (object)array("rst" => false, "msg" => "");
        $data = (object)$this->input->post();

        $this->db->set("principal", 0);

        $this->db->where("id_servico", $data->id_servico);
        if($this->db->update("Imagens"))
        {
            $this->db->set("principal", 1);

            $this->db->where("id", $data->id_imagem);
            if($this->db->update("Imagens"))
            {
                $rst->rst = true;
                $rst->msg = "Imagem definida como principal";
            }
            else
            {
                $rst->msg = "Erro ao definir como principal";
            }
        }
        else
        {
            $rst->msg = "Erro ao definir como principal";
        }

        return $rst;
    }

    public function troca_ativo()
    {
        $rst = (object)array("rst" => false, "msg" => "");
        $data = (object)$this->input->post();

        if($data->ativo == "true")
        {
            $this->db->set("ativo", 1);

            $this->db->where("id", $data->id_imagem);
            if($this->db->update("Imagens"))
            {
                $rst->rst = true;
                $rst->msg = "Imagem definida como ativa";
            }
            else
            {
                $rst->msg = "Erro ao definir imagem como ativa";
            }
        }
        else
        {
            $query = $this->db->get_where("Imagens", "id = $data->id_imagem")->row();

            if($query->principal == 1)
            {
                $rst->msg = "Erro ao definir imagem como desativada, pois a imagem é a principal do serviço";
            }
            else
            {
                $this->db->set("ativo", 0);

                $this->db->where("id", $data->id_imagem);
                if($this->db->update("Imagens"))
                {
                    $rst->rst = true;
                    $rst->msg = "Imagem definida como desativada";
                }
                else
                {
                    $rst->msg = "Erro ao definir imagem como desativada";
                }
            }
        }

        return $rst;
    }

    public function exclui_imagem()
    {
        $rst = (object)array("rst" => false, "msg" => "", "subtexto" => "");
        $data = (object)$this->input->post();

        $query = $this->db->get_where("Imagens", "id = $data->id_imagem")->row();

        if($query->principal == 1)
        {
            $rst->msg = "Está imagem está definida como principal.";
            $rst->subtexto = "Altere a imagem principal, antes de tentar excluir está imagem";
        }
        else
        {
            $this->db->where("id", $data->id_imagem);
            if($this->db->delete("Imagens"))
            {
                $rst->rst = true;
                $rst->msg = "Imagem deletada com sucesso";
            }
        }

        return $rst;
    }

    public function pesquisa_servico($pesquisa)
    {

        $this->db->where("nome LIKE '%$pesquisa%'");
        $query = $this->db->get("Servico")->result();

        $result = array();

        foreach($query as $item)
        {
            if(count($result) > 0)
            {
                $verif = 0;
                foreach($result as $value)
                {
                    if($value->id == $item->id_categoria)
                    {
                        $verif = 1;
                        $value->itens[] = $item;
                    }
                }

                if($verif == 0)
                {
                    $categoria = $this->db->get_where("Categoria", "id = '$item->id_categoria'")->row();
                    $categoria->itens = array($item);
                    $result[] = $categoria;    
                }
            }
            else
            {
                $categoria = $this->db->get_where("Categoria", "id = '$item->id_categoria'")->row();
                $categoria->itens = array($item);
                $result[] = $categoria;
            }
        }

        foreach($result as $item)
        {
            foreach($item->itens as $value)
            {
                $value = $this->get_card($value);
            }
        }

        return $result;
    }

    public function servico_realizado($id)
    {
        $rst = (object)array("rst" => false, "msg" => "");
        $dados = $this->session->userdata("dados" . APPNAME);
        
        $this->db->set("ativo", 0);

        $this->db->where("id_orcamento", $id);
        if($this->db->update("ContrataServico"))
        {
            $this->db->set("id_orcamento", $id);
            $this->db->set("status", 7);
            $this->db->set("id_usuario", $dados->usuario_id);
            $this->db->set("ativo", 1);
            $this->db->set("data_alteracao", date("Y-m-d H:i:s"));
    
            if($this->db->insert("ContrataServico"))
            {
                $rst->rst = true;
                $rst->msg = "Serviço definido como realizado";
            }
            else
            {
                $rst->msg = "Erro ao definir serviço como realizado";
            }
        }
        else
        {
            $rst->msg = "Erro ao definir serviço como realizado";
        }

        return $rst;
    }

    private function media_feedback($id_servico)
    {
        $orcamentos = $this->db->get_where("Orcamento", "id_servico = $id_servico")->result();

        $feedback = 0;
        $count = 0;

        foreach($orcamentos as $item)
        {
            $query = $this->db->get_where("Feedback", "id_orcamento = $item->id")->row();
            if($query)
            {
                $feedback += $query->quantidade_estrelas;
                $count++;
            }
        }

        if($count>0)
            $media = (($feedback)/$count)/2;
        else
            $media = 0;
        
        return $media;
    }

    private function quantidade_estrelas($id_servico, $quantidade)
    {
        $orcamentos = $this->db->get_where("Orcamento", "id_servico = $id_servico")->result();

        $count = 0;

        foreach($orcamentos as $item)
        {
            $query = $this->db->get_where("Feedback", "id_orcamento = $item->id AND (quantidade_estrelas = $quantidade OR quantidade_estrelas = ".($quantidade - 1).")")->row();
            if($query)
            {
                $count++;
            }
        }
        
        return $count;
    }

    public function get_data_disponiveis($id_servico)
    {
        $query = $this->db->get_where("HorarioServico", "id_servico = $id_servico")->result();

        return $query;
    }

    public function get_horarios_disponiveis()
    {
        $data = (object)$this->input->post();

        $query_horarios = $this->db->get_where("HorarioServico", "id_servico = '$data->id_servico' AND dia_semana = '$data->dia_semana'")->row();

        if($query_horarios)
        {
            $horarios_ocupados = array();

            $id_orcamento = $this->db->get_where("Orcamento", "id_servico = '$data->id_servico'")->result();
            foreach($id_orcamento as $item)
            {
                $valor = $this->get_horarios_indisponiveis($item->id, $data->data);
                if($valor)
                    $horarios_ocupados[] = $valor;
            }
            $where = "";
            if($horarios_ocupados)
            {
                $where = "(";

                foreach($horarios_ocupados as $key => $item)
                {
                    if($key > 0)
                        $where .= " AND ";

                    $where .= $item;
                }

                $where .= ")";
            }

            $horario_split = explode(" às ", $query_horarios->texto);

            $this->db->where("horario BETWEEN '$horario_split[0]' AND '$horario_split[1]'");

            if($where)
                $this->db->where($where, null, false);

            $query_select_horario = $this->db->get("ListaHorario")->result();

            return $query_select_horario;
        }

        return (object)array();
    }

    private function get_horarios_indisponiveis($id_orcamento, $data)
    {

        $query = $this->db->get_where("ContrataServico", "id_orcamento = $id_orcamento AND ativo = 1")->row();
        
        if(($query->status == 1 || $query->status == 2 || $query->status == 4 || $query->status == 5))
        {
            $this->db->order_by("id", "desc");
            $queryOcupado = $this->db->get_where("ContrataServico", "id_orcamento = $id_orcamento AND status = 1 AND data_servico = '".formatar($data, "dt2bd")."'")->row();

            if($queryOcupado)
            {
                $split = explode(":", $queryOcupado->hora_servico);
                if($split[0] + 2 >23)
                {
                    if($split[0] + 1 == 24)
                        $novo_horario_final =  "00:".$split[1];
                    else
                        $novo_horario_final =  "01:".$split[1];
                }
                else
                {
                    $novo_horario_final =  ($split[0] + 2).":".$split[1];
                }
                if($split[0] - 2 < 0)
                {
                    if($split[0] - 1 == -1)
                        $novo_horario_comeco =  "23:".$split[1];
                    else
                        $novo_horario_comeco =  "22:".$split[1];
                }
                else
                {
                    $novo_horario_comeco =  ($split[0] - 2).":".$split[1];
                }
                
                return " horario NOT BETWEEN '$novo_horario_comeco' AND '$novo_horario_final' ";
            }
        }

        return null;
    }

    public function get_estado_nome($nome)
    {
        $query = $this->db->get_where("Estados", "nome = '$nome'")->row();

        return $query->id;
    }

    public function get_cidade_nome($nome)
    {
        $json = file_get_contents(base_url("assets/Cidades.json"));
        $data = json_decode($json);

        foreach($data as $item)
        {
            if($item->Nome == $nome)
                return $item->ID;
        }
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