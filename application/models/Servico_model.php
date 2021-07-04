<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servico_model extends CI_Model{
    
    function __construct() 
    {
        parent::__construct();
        $this->dados = $this->session->userdata("dados" . APPNAME);
    }

    /** Consultas basicas */

        /**
         * Consulta todas as categorias principais.
         * @access public
         * @return object;
        */
        public function get_categorias_principais()
        {
            $query = $this->db->get_where("Categoria", "id_pai = 0")->result();

            return $query;
        }

        /**
         * Consulta todas as subscategorias de uma categoria especifica.
         * @access public
         * @param  int $id identificador da categoria
         * @return object;
        */
        public function get_subcategorias($id)
        {
            $lista_categoria = array();
            
            $query = $this->db->get_where("Categoria", "id_pai = '$id'")->result();

            foreach($query as $item)
            {
                $lista = (object)array("id" => $item->id, "nome" => $item->nome, "filhos");
                $lista->filhos = $this->db->get_where("Categoria", "id_pai = '$item->id'")->result();

                $lista_categoria[] = $lista;
            }

            return $lista_categoria;
        }

        /**
         * Consulta todos os tipos de forma de pagamento.
         * @access public
         * @return object;
        */
        public function get_pagamento()
        {
            $result = $this->db->query('SELECT DISTINCT forma_pagamento FROM TipoPagamento')->result();

            foreach($result as $item)
            {
                $item->tipos = $this->db->get_where("TipoPagamento", "forma_pagamento = '$item->forma_pagamento'")->result();
            }

            return $result;
        }

        /**
         * Consulta todos os estados brasileiros.
         * @access public
         * @return object;
        */
        public function get_estados()
        {
            $query = $this->db->get("Estados")->result();

            return $query;
        }

        /**
         * Consulta o estado a partir da sigla.
         * @access public
         * @param  string $sigla  Sigla do Estado
         * @return object;
        */
        public function get_estado_sigla($sigla)
        {
            $query = $this->db->get_where("Estados", "sigla = '$sigla'")->row();

            return $query;
        }

        /**
         * Consulta o estado a partir do nome.
         * @access public
         * @param  string $nome  Nome do Estado
         * @return int;
        */
        public function get_estado_nome($nome)
        {
            $query = $this->db->get_where("Estados", "nome = '$nome'")->row();

            return $query->id;
        }

        /**
         * Consulta todas as cidades de um estado
         * @access public
         * @param  int $id Identificador de um Estado
         * @return array;
        */
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

        /**
         * Consulta uma cidade.
         * @access public
         * @param  int $id_cidade Idenficador de Cidade
         * @return object;
        */
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

        /**
         * Consulta uma cidade.
         * @access public
         * @param  string $nome Nome da Cidade
         * @return int;
        */
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
         * Lista todos os horarios.
         * @access public
         * @return object;
        */
        public function lista_horarios()
        {
            return $this->db->get("ListaHorario")->result();
        }

    /** Fim Consultas basicas */

    /** Card */

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

        public function get_descricao_categoria($categoria)
        {
            //consulta o id da categoria.
            $query = $this->db->get_where("Categoria", "nome = '$categoria'")->row();

            return $query->descricao;
        }

        /**
         * Retorna os serviços com os ultimos 6 feedbacks.
         * @access public
         * @return array;
        */
        public function get_ult_feedbacks()
        {
            $query_servico = $this->db->get_where("Servico", "ativo = 1")->result();

            $result = array();
            if($query_servico)
            {
                $lista_feedback = array();
                foreach($query_servico as $item)
                {
                    $lista_feedback[] = array($this->media_feedback($item->id), $item);
                }
    
                //ordena o array em ordem descrescente
                arsort($lista_feedback);
                $lista_feedback = array_values($lista_feedback);        

                $maximo = count($lista_feedback) > 6 ? 6 : count($lista_feedback);
                if($lista_feedback)
                {
                    for($i=0; $i<$maximo;$i++)
                    {
                        $servico = $lista_feedback[$i][1];
                        $servico = $this->db->get_where("Servico", "id = $servico->id")->row();
        
                        $result[] = $this->get_card($servico);
                    }
                }
            }
            
            return $result;
        }

        /**
         * Retorna todos os serviços com nome de acordo com o termo digitado
         * @access public
         * @param string $pesquisa Termo a ser buscado
         * @return array;
        */
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

                    //Verifica se ja possui essa categoria no array
                    if($verif == 0)
                    {
                        $categoria = $this->db->get_where("Categoria", "id = '$item->id_categoria'")->row();
                        $categoria->itens = array($item);
                        $result[] = $categoria;    
                    }
                }
                else
                {
                    //Consulta a categoria do serviço
                    $categoria = $this->db->get_where("Categoria", "id = '$item->id_categoria'")->row();
                    $categoria->itens = array($item);
                    $result[] = $categoria;
                }
            }

            foreach($result as $item)
            {
                foreach($item->itens as $value)
                {
                    //Pega as informações do serviço para compor o card
                    $value = $this->get_card($value);
                }
            }

            return $result;
        }

    /** Fim Card */

    /** Detalhes do Serviço */

        /**
         * Registra o email da pessoa para ser avisada quando o serviço estiver disponivel.
         * @access public
         * @return object;
        */
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
         * Consulta todas as informações de um serviço especifico.
         * @access public
         * @param  int   $id_servico   identificador do Serviço.
         * @return object
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
            $query->perguntas = $this->m_perguntas->get_perguntas($query->id, "");

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

            return $query;
        }

        /**
         * Realiza a consulta da media do feedback do serviço
         * @access private
         * @param  int   $id_servico   identificador do Serviço.
         * @return float
        */
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

        /**
         * Realiza a contagem de estrelas
         * @access private
         * @param  int   $id_servico   identificador do Serviço.
         * @param  int   $quantidade   quantidade de estrelas.
         * @return int
        */
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

        /**
         * Pega todos os horarios disponiveis do serviço
         * @access public
         * @param  int   $id_servico   identificador do Serviço.
         * @return object
        */
        public function get_data_disponiveis($id_servico)
        {
            $query = $this->db->get_where("HorarioServico", "id_servico = $id_servico")->result();

            return $query;
        }

        /**
         * Lista todos os horarios disponiveis do serviço
         * @access public
         * @return object
        */
        public function get_horarios_disponiveis()
        {
            $data = (object)$this->input->post();

            $query_horarios = $this->db->get_where("HorarioServico", "id_servico = '$data->id_servico' AND dia_semana = '$data->dia_semana'")->row();

            if($query_horarios)
            {
                $horarios_ocupados = array();

                //Consulta todos os horarios que ja está sendo utilizados
                $id_orcamento = $this->db->get_where("Orcamento", "id_servico = '$data->id_servico'")->result();
                foreach($id_orcamento as $item)
                {
                    $valor = $this->get_horarios_indisponiveis($item->id, $data->data);
                    if($valor)
                        $horarios_ocupados[] = $valor;
                }

                //Monta o where para excluir os horarios que ja está sendo utilizados
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

        /**
         * Lista todos os horarios disponiveis do serviço
         * @access public
         * @param int $id_orcamento Identificador do Orçamento
         * @param string $data data no formato d/m/y
         * @return string
        */
        private function get_horarios_indisponiveis($id_orcamento, $data)
        {

            $query = $this->db->get_where("ContrataServico", "id_orcamento = '$id_orcamento' AND ativo = 1")->row();
            if($query)
            {

                //Verifica se são os status de em andamento
                if(($query->status == 1 || $query->status == 2 || $query->status == 4 || $query->status == 5))
                {
                    $this->db->order_by("id", "desc");
                    $queryOcupado = $this->db->get_where("ContrataServico", "id_orcamento = $id_orcamento AND status = 1 AND data_servico = '".formatar($data, "dt2bd")."'")->row();

                    if($queryOcupado)
                    {
                        $split = explode(":", $queryOcupado->hora_servico);
                        //Verifica se é depois das 23h para corrigir as horas
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

                        //Verifica se é antes das 00h para corrigir as horas
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
            }

            return null;
        }

    /** Fim Detalhes Serviço */

    /** Gerenciamento do Serviço */

        /**
         * Consulta o status do serviço.
         * @access public
         * @param  int $id Identificador do Serviço
         * @return int;
        */
        public function get_visibilidade($id)
        {
            $query = $this->db->get_where("Servico", "id = $id")->row();

            return $query->ativo;
        }

        /**
         * Realiza troca de status do serviço.
         * @access public
         * @return boolean;
        */
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

        /**
         * Cadastra um Serviço.
         * @access public
         * @return object;
        */
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
            $this->db->set("id_usuario", $this->dados->usuario_id);

            //Verifica se a opção de local especifico foi marcada
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
            
            //Verifica se algum valor para o serviço foi inserido
            if($data->valor)
            {
                $valor_T = explode(" ", $data->valor);
                $valor_V = explode(".", $valor_T[1]);
                $valor = str_replace(",", ".", $valor_V[0]);
                $this->db->set("valor", $valor.",".$valor_V[1]);
            }

            //Verifica se o é um Aluguel de Equipamento
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

            if($this->db->insert("Servico"))
            {
                $id = $this->db->insert_id();
                $rst->id = $id;

                $this->set_img($id);

                //Verifica se possui formas de pagamentos
                if($data->lista_tipo_pagamento)
                {
                    $this->set_pagamento($id);
                }

                //Verifica se possui horarios de funcionamento
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

        /**
         * Insere as imagens cadastradas no serviço.
         * @access private
         * @param   int $id Identificador do Serviço
        */
        private function set_img ($id)
        {
            $files = $this->session->userdata("files".APPNAME);
        
            //Verifica se possui imagens
            if($files)
            {
                $this->session->set_userdata("files".APPNAME, "");
                for($count = 0; $count < count($files); $count++)
                {
                    $query = $this->db->get_where("Imagens", "id_servico = $id AND principal = 1")->row();
                    //Verifica se o serviço ja possui imagens
                    if(empty($query))
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

                //realiza a limpeza da pasta auxiliar
                limpa_uploads();
            }
        }

        /**
         * Insere as formas de pagamento
         * @access private
         * @param int $id Identificador do Serviço
        */
        private function set_pagamento($id)
        {
            $data = (object)$this->input->post();
            
            //Lista as formas de pagamento
            $lista_ini = explode(",", $data->lista_tipo_pagamento);

            $lista_c = array();

            foreach($lista_ini as $value)
            {
                //Lista as informações individuais de pagamento
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
        }

        /**
         * Insere os horarios de funcionamento
         * @access private
         * @param int $id Identificador do Serviço
        */
        private function set_horario($id)
        {
            $data = (object)$this->input->post();
            
            //Lista os horarios de funcionamento
            $lista_ini = explode(",", $data->lista_tipo_horario);
            
            $lista_c = array();

            foreach($lista_ini as $value)
            {
                //Lista as informações individuais de horario
                $lista_c = explode("/", $value);
                
                if($lista_c)
                {
                    $this->db->set("dia_semana", $lista_c[0]);
                    $this->db->set("texto", $lista_c[1]." às ".$lista_c[2]);
                    $this->db->set("id_servico", $id);

                    $this->db->insert("HorarioServico");
                }
            }
        }

        /**
         * Editar as informações do Serviço.
         * @access public
         * @return object;
        */
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

            //Verifica se a opção de local especifico foi marcada
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

            //Verifica se algum valor para o serviço foi inserido
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

            //Verifica se o é um Aluguel de Equipamento
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

        /**
         * Insere os horarios de funcionamento
         * @access private
         * @param int $id identificador do Serviço
         * @return object;
        */
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
            $this->db->join("ContrataServico C", "O.id = C.id_orcamento AND C.status = 7");
            $contratacoes = $this->db->get_where("Orcamento O", "O.id_servico = $id")->result();
            $rst->contratacoes = count($contratacoes);

            $this->db->select("O.id");
            $this->db->join("ContrataServico C", "O.id = C.id_orcamento AND C.ativo = 1 AND (C.status != 7 OR C.status != 3)");
            $andamento = $this->db->get_where("Orcamento O", "O.id_servico = $id")->result();
            $rst->andamento = count($andamento);

            $this->db->select("O.id");
            $this->db->join("ContrataServico C", "O.id = C.id_orcamento AND C.ativo = 1 AND (C.status = 1 OR C.status = 5)");
            $orcamentos = $this->db->get_where("Orcamento O", "O.id_servico = $id")->result();
            $rst->orcamentos = count($orcamentos);
            
            return $rst;
        }

        /**
         * Lista todas as imagens daquele serviço
         * @access public
         * @param int $id identificador do Serviço
         * @return object;
        */
        public function get_imagens($id)
        {
            $query = $this->db->get_where("Imagens", "id_servico = '$id'")->result();

            return $query;
        }

        /**
         * Realiza a inserção e alteração de imagens
         * @access public
         * @return object;
        */
        public function insere_imagem()
        {
            $rst = (object)array("rst" => false, "msg" => "");
            $data = (object)$this->input->post();
            
            $files = $this->session->userdata("files".APPNAME);

            $this->session->set_userdata("files".APPNAME, "");

            //Verifica se é update ou insert
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

        /**
         * Realizar a definição de uma imagem principal
         * @access public
         * @return object;
        */
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

        /**
         * Realizar a definição de uma imagem como ativo ou inativo
         * @access public
         * @return object;
        */
        public function troca_ativo()
        {
            $rst = (object)array("rst" => false, "msg" => "");
            $data = (object)$this->input->post();

            //Verifica se é para definir como ativa
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

                //Verifica se a imagem que será desativada é principal
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

        /**
         * Realiza a exclução da imagem
         * @access public
         * @return object;
        */
        public function exclui_imagem()
        {
            $rst = (object)array("rst" => false, "msg" => "", "subtexto" => "");
            $data = (object)$this->input->post();

            $query = $this->db->get_where("Imagens", "id = $data->id_imagem")->row();

            //Verifica se é principal
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

        /**
         * Consulta todos os serviços pendentes
         * @access public
         * @param   int $id Identificador do Serviço
         * @return array;
        */
        public function get_dias_agendados($id)
        {
            $lista = array();

            $this->db->select("C.*");
            $this->db->join("ContrataServico C", "C.id_orcamento = O.id AND (C.status = 4 OR C.status = 7) AND ativo = 1");
            $query_horarios = $this->db->get_where("Orcamento O", "O.id_servico = '$id'")->result();

            foreach($query_horarios as $item)
            {
                $this->db->order_by("id", "desc");
                $queryServico = $this->db->get_where("ContrataServico", "id_orcamento = '$item->id_orcamento' AND status = 1")->row();

                $this->db->select("nome");
                $this->db->join("Orcamento O", "O.id_usuario = U.id");
                $this->db->where("O.id = $item->id_orcamento");
                $queryUsuario = $this->db->get("Usuario U")->row();

                $queryServico->solicitante = $queryUsuario->nome;
                $queryServico->status_atual = $item->status;

                $split = explode(":", $queryServico->hora_servico);
                //Verifica se é depois das 23h para corrigir as horas
                if($split[0] + 2 >23)
                {
                    if($split[0] + 1 == 24)
                        $queryServico->hora_final =  "00:".$split[1];
                    else
                        $queryServico->hora_final =  "01:".$split[1];
                }
                else
                {
                    $queryServico->hora_final =  ($split[0] + 2).":".$split[1];
                }

                $lista[] = $queryServico;
            }

            return $lista;
        }

    /** Fim Gerenciamento do Serviço */

    

    /** Contratação do Serviço */
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
                    $this->db->select("U.email");
                    $this->db->join("Usuario U", "U.id = S.id_usuario");
                    $query = $this->db->get_where("Servico S", "S.id = $data->id_servico")->row();

                    $texto = (object)array();

                    $hash = $this->sistema->encrypt_decrypt("encrypt", "Servico/gerenciar_servico/$data->id_servico");

                    $texto->email = strtolower($query->email);
                    $texto->titulo = "Contratação do Serviço";
                    $texto->link = base_url("Usuario/page_redirect/$hash");
                    $texto->texto_link = "Ver Pedido";
                    $texto->msg = "Opa, tudo certo? <br/> Seu serviço foi contratado.<br/> O Pedido está esperando por uma resposta <br/> Caso queira ver diretamente o pedido, clique no botão abaixo.";
                    $texto->cid = "";

                    $this->m_sistema->envia_email($texto);

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

        /**
         * Consulta todos os orçamento de um serviço
         * @access public
         * @param int $id Identificador do Serviço
         * @return object;
        */
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

        /**
         * Consulta todos as movimentações de um Orcamento
         * @access public
         * @param int $id Identificador do Orçamento
         * @return object;
        */
        public function get_info_orcamentos($id)
        {
            $this->db->order_by("id", "desc");
            $query = $this->db->get_where("ContrataServico", "id_orcamento = $id")->result();

            foreach($query as $item)
            {
                $this->db->select("id_servico");
                $item->id_servico = $this->db->get_where("Orcamento", "id = $id")->row()->id_servico;
                $item->status = $this->db->get_where("OrcamentoStatus", "id = $item->status")->row();

                //Verifica se o status é igual a Orçamento aceito
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

        /**
         * Realiza um resposta a movimentação
         * @access public
         * @return object;
        */
        public function resposta_orcamento()
        {
            $rst = (object)array("rst" => false, "msg" => "");
            $data = (object)$this->input->post();

            $status = 0;

            $this->db->set("ativo", 0);
            $this->db->where("id_orcamento", $data->id_orcamento);
            if($this->db->update("ContrataServico"))
            {
                //Verifica se foi aceito
                if($data->aceite_orcamento == 1)
                {
                    $this->db->set("status", 2);
                    $status = 2;
                }
                //Verifica se foi recusado
                elseif($data->aceite_orcamento == 0)
                {
                    $this->db->set("status", 3);
                    $status = 3;
                }

                $this->db->set("data_alteracao", date("Y-m-d H:i:s"));
                $this->db->set("id_orcamento", $data->id_orcamento);
                $this->db->set("id_usuario", $this->dados->usuario_id);
                $this->db->set("ativo", 1);

                //Verifica se possui valor de orçamento
                if($data->orcamento)
                    $this->db->set("orcamento", $data->orcamento);

                //Verifica se possui descrição para orçamento
                if($data->descricao_orcamento)
                    $this->db->set("descricao", $data->descricao_orcamento);

                if($this->db->insert("ContrataServico"))
                {
                    //Consulta o email do Usuario
                    $this->db->select("U.email");
                    $this->db->join("Usuario U", "U.id = O.id_usuario");
                    $query = $this->db->get_where("Orcamento O", "O.id = $data->id_orcamento")->row();

                    $texto = (object)array();

                    $hash = $this->sistema->encrypt_decrypt("encrypt", "Usuario/controle_pedido/$data->id_orcamento");

                    $texto->email = strtolower($query->email);
                    $texto->titulo = "Contratação do Serviço";
                    $texto->link = base_url("Usuario/page_redirect/$hash");
                    $texto->texto_link = "Ver Pedido";
                    $texto->msg = "Opa, tudo certo? <br/> O serviço que você solicitou lhe enviou uma resposta.<br/> Caso queira ver diretamente o andamento, clique no botão abaixo.";
                    $texto->cid = "";

                    $this->m_sistema->envia_email($texto);

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

        /**
         * Realiza um resposta a movimentação
         * @access public
         * @param int $id Identificador do Orçamento
         * @return object;
        */
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

                    $this->db->select("U.email");
                    $this->db->join("Usuario U", "U.id = O.id_usuario");
                    $query = $this->db->get_where("Orcamento O", "O.id = $id")->row();

                    $texto = (object)array();

                    $hash = $this->sistema->encrypt_decrypt("encrypt", "Usuario/controle_pedido/$id");

                    $texto->email = strtolower($query->email);
                    $texto->titulo = "Contratação do Serviço";
                    $texto->link = base_url("Usuario/page_redirect/$hash");
                    $texto->texto_link = "Ver Pedido";
                    $texto->msg = "Opa, tudo certo? <br/> O serviço que você havia solicitado foi cancelado pelo Prestador<br/> Caso queira ver diretamente mais informações, clique no botão abaixo.";
                    $texto->cid = "";

                    $this->m_sistema->envia_email($texto);

                    return true;
                }
            }

            return false;
        }

        /**
         * Defini o serviço como realizado
         * @access public
         * @param int $id Identificador do Orçamento
         * @return object;
        */
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
    
                    $this->db->select("U.email");
                    $this->db->join("Usuario U", "U.id = S.id_usuario");
                    $this->db->join("Orcamento O", "O.id_servico = S.id");
                    $this->db->where("O.id = $id");
                    $query = $this->db->get("Servico S")->row();
                    $texto = (object)array();
    
                    $hash = $this->sistema->encrypt_decrypt("encrypt", "Feedback/index/$id");
    
                    $texto->email = strtolower($query->email);
                    $texto->titulo = "Contratação do Serviço";
                    $texto->link = base_url("Usuario/page_redirect/$hash");
                    $texto->texto_link = "Ver Pedido";
                    $texto->msg = "Opa, tudo certo? <br/> Espero que o serviço tenha sido efetuado com satisfação e excelencia.<br/> Bom agora que o serviço foi realizado, você poderia realizar um feedback do serviço para o prestador? <br/> Para realizar o feedback, clique no botão abaixo.";
                    $texto->cid = "";
    
                    $this->m_sistema->envia_email($texto);
    
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

    /** Fim Contratação do Serviço */
}