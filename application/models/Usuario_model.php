<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model{
    
    function __construct() 
    {
        parent::__construct();
            
    }

    private $loginData = array(
        "logged" => false, 
        "error" => "",     
        "nome" => "",
        "sobrenome" => "",
        "email" => "", 
        "data_criacao" => "",
        "usuario_id" => 0,
        "ativacao" => 0,
    );

    /** Consultas Basicas */

        /**
         * Consulta o estado a partir do Identificador.
         * @access public
         * @param  int $nome  Identificador do Estado
         * @return string;
        */
        public function get_estado_id($id)
        {
            $query = $this->db->get_where("Estados", "id = '$id'")->row();

            return $query->nome;
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
         * Consulta uma cidade.
         * @access public
         * @param  int $id Identificador da Cidade
         * @return string;
        */
        public function get_cidade_id($id)
        {
            $json = file_get_contents(base_url("assets/Cidades.json"));
            $data = json_decode($json);

            foreach($data as $item)
            {
                if($item->ID == $id)
                    return $item->Nome;
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

    /** Fim Consultas Basicas */

    /** Perfil */

        /**
         * Consulta todas as informações do usuario.
         * @access public
         * @param  int   $id   identificador do Usuario.
         * @return object;
        */
        public function info_usuario($id)
        {
            $query = $this->db->get_where("Usuario", "id = $id")->row();

            if($query)
            {
                $query->enderecos = $this->db->get_where("Enderecos", "id_usuario = $id")->result();
                foreach($query->enderecos as $item)
                {
                    $item->estado = $this->get_estado_id($item->estado);
                    $item->cidade = $this->get_cidade_id($item->cidade);
                }

                $query->cpf = formatar($query->cpf, "cpf");
                $query->telefone = formatar($query->telefone, "fone");
                $query->celular = formatar($query->celular, "fone");
                $query->data_nascimento = formatar($query->data_nascimento, "bd2dt");
                $query->data_criacao_br = formatar(transforma_datatime_to_date($query->data_criacao), "bd2dt");
            }

            return $query;
        }

        /**
         * Consulta todos os serviços que foram favoritados pelo usuario
         * @access public
         * @return object;
        */
        public function get_favoritos()
        {
            $dados = $this->session->userdata("dados" . APPNAME);

            $favoritos = $this->db->get_where("Favoritos", "ativo = 1 AND id_usuario = $dados->usuario_id")->result();

            foreach($favoritos as $item)
            {
                $this->db->select("nome, descricao_curta, id_categoria, id_usuario");
                $item->servico = $this->db->get_where("Servico", "id = $item->id_servico")->row();
                
                $this->db->select("nome");
                $item->categoria = $this->db->get_where("Categoria", "id = ".$item->servico->id_categoria)->row();

                $this->db->select("nome");
                $item->usuario = $this->db->get_where("Usuario", "id = ".$item->servico->id_usuario)->row();

                $this->db->select("tipo_imagem, img");
                $item->img = $this->db->get_where("Imagens", "principal = 1 AND id_servico = $item->id_servico")->row();
            }

            return $favoritos;
        }

        /**
         * Consulta todos os serviços que foram cadastros pelo Usuario
         * @access public
         * @return object;
        */
        public function get_servicos_cadastrados()
        {
            $dados = $this->session->userdata("dados" . APPNAME);

            $this->db->select("id, nome, descricao_curta, id_categoria, id_usuario");
            $servico = $this->db->get_where("Servico", "id_usuario = $dados->usuario_id")->result();

            foreach($servico as $item)
            {
                $this->db->select("nome");
                $item->categoria = $this->db->get_where("Categoria", "id = ".$item->id_categoria)->row();

                $this->db->select("nome");
                $item->usuario = $this->db->get_where("Usuario", "id = ".$item->id_usuario)->row();

                $this->db->select("tipo_imagem, img");
                $item->img = $this->db->get_where("Imagens", "principal = 1 AND id_servico = $item->id")->row();
            }

            return $servico;
        }

        /**
         * Consulta todos os serviços que foram contratados pelo Usuario
         * @access public
         * @return object;
        */
        public function get_servicos_contratos()
        {
            $rst = (object)array("andamento" => array(), "concluido" => array());
            $dados = $this->session->userdata("dados" . APPNAME);

            $contrato = $this->db->get_where("Orcamento", "id_usuario = $dados->usuario_id")->result();

            foreach($contrato as $item)
            {
                $this->db->select("nome, ativo, descricao_curta, id_tipo_servico, id_categoria, id_usuario");
                $item->servico = $this->db->get_where("Servico", "id = $item->id_servico")->row();
                
                $this->db->select("tipo_imagem, img");
                $item->img = $this->db->get_where("Imagens", "id_servico = $item->id_servico AND principal = 1 AND ativo = 1")->row();

                $this->db->select("nome");
                $item->categoria = $this->db->get_where("Categoria", "id = ".$item->servico->id_categoria)->row();

                $this->db->select("nome");
                $item->usuario = $this->db->get_where("Usuario", "id = ".$item->servico->id_usuario)->row();
                
                $this->db->select("O.*, C.id_orcamento");
                $this->db->join("OrcamentoStatus O", "O.id = C.status");
                $item->status = $this->db->get_where("ContrataServico C", "C.id_orcamento = $item->id AND C.ativo = 1")->row();

                $feedback = $this->db->get_where("Feedback", "id_orcamento = '$item->id'")->row();

                if($item->status == "7" && empty($feedback))//verificar se tem feedback
                    $item->realizarFeedback = true;
                else
                    $item->realizarFeedback = false;

                if($item->status->id == 1 || $item->status->id == 2 || $item->status->id == 4 || $item->status->id == 5)
                    $rst->andamento[] = $item;
                else
                    $rst->concluido[] = $item;
            }

            return $rst;
        }

        /**
         * Desfavorita o Serviço
         * @access public
         * @param int $id Identificador do Favorito
         * @return boolean;
        */
        public function desfavoritar($id)
        {
            $this->db->set("ativo", 0);

            $this->db->where("id", $id);
            if($this->db->update("Favoritos"))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        
    /** Fim Perfil */

    /** Endereço */

        /**
         * Consulta todos os Endereços do Usuario
         * @access public
         * @return object
        */
        public function get_enderecos()
        {
            if($this->dados)
            {
                $query = $this->db->get_where("Enderecos", "id_usuario = ".$this->dados->usuario_id)->result();
                foreach($query as $item)
                {
                    //Consulta o estado
                    $item->estado = $this->db->get_where("Estados", "id = '$item->estado'")->row();

                    //Consulta a cidade
                    $item->cidade = $this->get_cidade_id($item->cidade);
                    $item->endereco_completo = $item->cep." - ".$item->endereco.($item->complemento ? ", ".$item->complemento : "").", ".$item->numero.", ".$item->bairro." - ".$item->cidade.", ".$item->estado->nome."(".$item->estado->sigla.")";
                }

                return $query;
            }
            else
            {
                return (object)array();
            }
        }
        /**
         * Consulta as informações do endereço.
         * @access public
         * @param  int   $id   identificador do Endereço.
         * @return object;
        */
        public function get_endereco($id)
        {
            $query = $this->db->get_where("Enderecos", "id = $id")->row();
            if($query)
            {
                $query->estado = $this->get_estado_id($query->estado);
                $query->cidade = $this->get_cidade_id($query->cidade);
            }

            return $query; 
        }

        /**
         * Insere e Atualiza os dados de endereço do Usuario
         * @access public
         * @return object;
        */
        public function salva_endereco()
        {
            $data = (object)$this->input->post();
            $rst = (object)array("rst" => 0, "msg" => "");
            $this->dados = $this->session->userdata("dados" . APPNAME);

            $this->db->set("cep", $data->cep);
            $this->db->set("endereco", $data->endereco);
            $this->db->set("numero", somente_numeros($data->numero));
            $this->db->set("bairro", $data->bairro);
            $this->db->set("estado", $this->get_estado_nome($data->estado));
            $this->db->set("cidade", $this->get_cidade_nome($data->cidade));
            $this->db->set("complemento", $data->complemento);
            $this->db->set("id_usuario", $this->dados->usuario_id);

            if($data->id)
            {
                $this->db->where("id = '$data->id'");
                if($this->db->update("Enderecos"))
                {
                    $rst->rst = 1;
                    $rst->msg = "Endereço atualizado com sucesso";
                }
                else
                {
                    $rst->rst = 0;
                    $rst->msg = "Erro ao atualiza o endereco";
                }
            }
            else
            {
                if($this->db->insert("Enderecos"))
                {
                    $rst->rst = 1;
                    $rst->msg = "Endereço inserido com sucesso";
                }
                else
                {
                    $rst->rst = 0;
                    $rst->msg = "Erro ao inserir o endereco";
                }
            }

            return $rst;
        }

        /**
         * Remove o Endereço
         * @access public
         * @param int $id Identificador do Endereço
         * @return boolean;
        */
        public function remove_endereco($id)
        {
            $this->db->where("id = $id");
            if($this->db->delete("Enderecos"))
            {
                return true;
            }
            else
            {
                return false;
            }
        }

    /** Fim Endereço */

    /** Usuario */

        /**
         * Realiza a autentificação no sistema.
         * @access public
         * @return object;
        */
        public function autentifica()
        {
            $data = (object)$this->input->post();
            $loginData = (object)$this->loginData;

            if($this->m_sistema->verifica_seguranca($data->email))
            {
                $loginData->logged = false;
                $loginData->error = "Palavra utilizada para o acesso é proibida!";

                return $loginData;
            }
            if($this->m_sistema->verifica_seguranca($data->senha))
            {
                $loginData->logged = false;
                $loginData->error = "Palavra utilizada para o acesso é proibida!";

                return $loginData;
            }

            //Realiza a consulta a partir dos dados digitados pelo usuario.
            $query = $this->db->get_where("Usuario", "email = '".strtolower($data->email)."' AND senha = '".md5($data->senha)."'")->row();

            if(!$query)
            {
                $loginData->error = "Email e/ou Senha está incorreto.";
            }
            else
            {
                $loginData->usuario_id = $query->id;
                $loginData->nome = $query->nome;
                $loginData->sobrenome = $query->sobrenome;
                $loginData->email = strtolower($query->email);
                $loginData->data_criacao = formatar($query->data_insercao, "bd2dt");
                $loginData->data_autentificacao = date("d-m-Y h:i:s");
                $loginData->logged = true;
                $loginData->ativacao = $query->ativar_conta;
            }

            return $loginData;
        }

        /**
         * Realiza o cadastro e a edição dos usuarios no sistema.
         * @access public
         * @return object;
        */
        public function salva_usuario()
        {
            $data = (object)$this->input->post();
            $rst = (object)array("rst" => 0, "msg" => "");

            $json_enderecos = explode(" - ", $data->enderecos);
            
            for($i=0;$i<count($json_enderecos);$i++)
            {
                //Lista de Endereço
                $enderecos[$i] = json_decode($json_enderecos[$i]);
            }

            //verifica se não está sendo inserido nenhum tipo de sql inject
            if($this->m_sistema->verifica_seguranca($data->senha))
            {
                $rst->msg = "Palavra utilizada na senha é proibida!";
                return $rst;
            }

            //verifica se não está sendo inserido nenhum tipo de sql inject
            if($this->m_sistema->verifica_seguranca($data->email))
            {
                $rst->msg = "Palavra utilizada no email é proibida!";
                return $rst;
            }

            //verifica se possui um usuario para ser editado e verifica se o email já não está sendo utilizado quando for realizar o cadastro.
            if(!empty($data->id_usuario) || $this->verifica_email(strtolower($data->email)))
            {
                $this->db->set("nome", $data->nome);
                $this->db->set("sobrenome", $data->sobrenome);
                $this->db->set("cpf", somente_numeros($data->cpf));
                $this->db->set("data_nascimento", formatar($data->data_nascimento, "dt2bd"));

                if($data->telefone)
                    $this->db->set("telefone", somente_numeros($data->telefone));

                if($data->celular)
                    $this->db->set("celular", somente_numeros($data->celular));
                
                $this->db->set("email", strtolower($data->email));

                //Verifica se a senha também será alterada.
                if($data->senha)
                    $this->db->set("senha", md5($data->senha));

                //Verifica se será uma edição ou inserção
                if(isset($data->id_usuario) && $data->id_usuario)
                {
                    $this->db->where("id", $data->id_usuario);
                    if($this->db->update("Usuario"))
                    {
                        $dados = $this->session->userdata("dados" . APPNAME);
                        if($dados)
                        {
                            $dados->nome = $data->nome;
                            $dados->sobrenome = $data->sobrenome;
                            $dados->email = strtolower($data->email);

                            $this->session->set_userdata(array("is_logged" => true, "dados" . APPNAME => $dados));   
                        }

                        $rst->rst = 4;
                        $rst->msg = "Dados da conta atualizados com sucesso";
                    }
                    else
                    {
                        $rst->msg = "Ocorreu um erro ao tentar atualizar os dados, tente novamente mais tarde";
                    }
                }
                else
                {
                    $this->db->set("data_insercao", date("Y-m-d H:i:s"));
                    $this->db->set("data_criacao", date("Y-m-d H:i:s"));
                    if($this->db->insert("Usuario"))
                    {
                        $id_usuario = $this->db->insert_id();
                        $erro = 1;
                        foreach($enderecos as $item)
                        {
                            $this->db->set("cep", $item->cep);
                            $this->db->set("endereco", $item->endereco);
                            $this->db->set("numero", somente_numeros($item->numero));
                            $this->db->set("bairro", $item->bairro);
                            $this->db->set("estado", $this->get_estado_nome($item->estado));
                            $this->db->set("cidade", $this->get_cidade_nome($item->cidade));
                            $this->db->set("complemento", $item->complemento);
                            $this->db->set("id_usuario", $id_usuario);

                            if(!$this->db->insert("Enderecos"))
                            {
                                $erro = 0;
                            }
                        }

                        if($erro == 1)
                        {
                            $texto = (object)array();

                            $texto->email = strtolower($data->email);
                            $texto->titulo = "Novo cadastro de usuario";
                            $texto->link = base_url("Usuario/ativa_conta/$id_usuario");
                            $texto->texto_link = "Ativar Conta";
                            $texto->msg = "Opa, tudo certo? <br/> Você acaba de realizar o cadastro em nosso sistema. <br/> Para uma utilização mais completa de nosso sistema, ative sua conta.";
                            $texto->cid = "";

                            $erro = $this->m_sistema->envia_email($texto);

                            if($erro == true)
                            {
                                $rst->rst = 1;
                                $rst->msg = "Cadastro realizado com sucesso";
                            }
                            else
                            {
                                $rst->msg = "Erro ao enviar o email, para ativação da conta, tente novamente mais tarde, ou acesse seu perfil e solicite novamente o envio do email.";
                            }
                        }
                        else
                        {
                            $rst->msg = "Erro ao cadastrar o Usuario";
                        }
                    }
                    else
                    {
                        $rst->msg = "Erro ao realizar o cadastro, tente novamente mais tarde.";
                    }
                }
            }
            else
            {
                $rst->rst = 0;
                $rst->msg = "O Email digitado já está cadastrado no sistema.";
            }

            return $rst;
        }

        /**
         * Realiza o envio do email para troca de senha
         * @access public
         * @return object;
        */
        public function troca_senha()
        {
            $rst = (object)array("rst" => false, "msg" => "");
            $data = (object)$this->input->post();

            $query = $this->db->get_where("Usuario", "email = '".strtolower($data->email)."'")->row();

            //Verifica se o email é cadastrado no sistema
            if($query)
            {
                $codigo = $this->sistema->gerar_senha();

                $this->db->set("id_usuario", $query->id);
                $this->db->set("ativo", 1);
                $this->db->set("codigo", $codigo);
                $this->db->set("data_solicitacao", date("Y-m-d h:i:s"));

                if($this->db->insert("EsqueciSenha"))
                {
                    //Enviar email aqui

                    $texto = (object)array();
                    $texto->email = strtolower($data->email);
                    $texto->titulo = "Recuperação de Senha";
                    $texto->link = "";
                    $texto->texto_link = "";
                    $texto->msg = "Opa, tudo certo? <br/> Aqui está seu codigo de verificação para recuperar sua senha: <br/> <h3>$codigo</h3>";
                    $texto->cid = "";
        
                    $erro = $this->m_sistema->envia_email($texto);

                    $rst->rst = true;
                    $rst->msg = "Um codigo para realizar a recuperação da senha, foi enviado para seu email.";
                }
                else
                {
                    $rst->msg = "Erro ao tentar recuperar a senha, tente novamente mais tarde";
                }
            }
            else
            {
                $rst->msg = "Este email não foi registrado no sistema";
            }

            return $rst;
        }

        /**
         * Realiza a troca de senha
         * @access public
         * @return object;
        */
        public function verifica_codigo()
        {
            $data = (object)$this->input->post();

            if($data->id_usuario)
            {
                $rst = (object)array("rst" => false, "msg" => "");
                $this->db->set("senha", md5($data->senha));

                $this->db->where("id", $data->id_usuario);
                if($this->db->update("Usuario"))
                {
                    $this->db->set("ativo", 0);
                    $this->db->set("data_troca", date("Y-m-d h:i:s"));

                    $this->db->where("id_usuario = $data->id_usuario AND ativo = 1");
                    if($this->db->update("EsqueciSenha"))
                    {
                        $rst->rst = true;
                        $rst->msg = "Senha atualizada com sucesso";
                    }
                    else
                    {
                        $rst->msg = "Erro ao tentar atualizar a senha";
                    }
                }
                else
                {
                    $rst->msg = "Erro ao tentar atualizar a senha";
                }

                return  $rst;
            }
            else
            {
                $query = $this->db->get_where("EsqueciSenha", "codigo = '$data->codigo' AND ativo = 1")->row();

                if($query)
                {
                    $query->rst = null;
                    return $query;
                }
                else
                {
                    return null;
                }
            }
        }

        /**
         * Realiza a ativação da conta
         * @access public
         * @param int $id Identificador do Usuario
         * @return boolean;
        */
        public function ativa_conta($id)
        {
            $this->db->set("ativar_conta", 1);
            $this->db->set("data_ativacao", date("Y-m-d h:i:s"));

            $this->db->where("id", $id);
            if($this->db->update("Usuario"))
            {
                $dados = $this->session->userdata("dados" . APPNAME);
                if($dados)
                {
                    $dados->ativacao = 1;
                    $this->session->set_userdata(array("is_logged" => true, "dados" . APPNAME => $dados));   
                }

                return true;
            }
            else
            {
                return false;
            }
        }

        /**
         * Realiza o reenvio do email para ativação da conta
         * @access public
         * @param int $id Identificador do Usuario
         * @return boolean;
        */
        public function reenviar_email($id)
        {
            $rst = (object)array("rst" => false, "msg" => "");
            $query = $this->db->get_where("Usuario", "id = $id")->row();

            if($query)
            {
                $texto = (object)array();
                $texto->email = strtolower($query->email);
                $texto->titulo = "Novo cadastro de usuario";
                $texto->link = base_url("Usuario/ativa_conta/$query->id");
                $texto->texto_link = "Ativar Conta";
                $texto->msg = "Opa, tudo certo? <br/> Você solicitou que o envio do email para ativação da conta seja realizada, aqui estamos nos ;D";
                $texto->cid = "";

                $erro = $this->m_sistema->envia_email($texto);
                if($erro == 1)
                {
                    $rst->rst = true;
                    $rst->msg = "Email de ativação reenviado com sucesso";
                }
                else
                {
                    $rst->msg = "Erro ao reenviar email de ativação";    
                }
            }
            else
            {
                $rst->msg = "Erro ao reenviar email de ativação";
            }

            return $rst;
        }

        /**
         * Realiza a verificação se o email já está cadastrado no sistema.
         * @access private
         * @param  string   $email   email do usuario.
         * @return boolean;
        */
        private function verifica_email($email)
        {
            $query = $this->db->get_where("Usuario", "email = '$email'")->row();

            if($query)
            {
                return false;
            }
            else
            {
                return true;
            }
        }

    /** Fim Usuario */

    /** Orçamento */

        /**
         * Consulta as informações de Orçamento
         * @access public
         * @param int $id Idenfiticador do Orçamento
         * @return object;
        */
        public function get_orcamentos($id)
        {
            $this->db->order_by("id", "desc");
            $query = $this->db->get_where("ContrataServico", "id_orcamento = $id")->result();

            foreach($query as $item)
            {
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

                $item->id_servico = $this->db->get_where("Orcamento", "id = $id")->row()->id_servico;
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
            $dados = $this->session->userdata("dados" . APPNAME);

            $this->db->set("ativo", 0);
            $this->db->where("id_orcamento", $data->id_orcamento);
            if($this->db->update("ContrataServico"))
            {
                if($data->aceite_orcamento == 1)
                    $this->db->set("status", 4);
                else
                    $this->db->set("status", 5);

                if($data->descricao_aceite)
                    $this->db->set("descricao", $data->descricao_aceite);
                
                $this->db->set("id_orcamento", $data->id_orcamento);
                $this->db->set("data_alteracao", date("Y-m-d h:i:s"));
                $this->db->set("ativo", 1);
                $this->db->set("id_usuario", $dados->usuario_id);

                if($this->db->insert("ContrataServico"))
                {
                    $rst->rst = true;
                    if($data->aceite_orcamento == 1)
                        $rst->msg = "Serviço fechado com sucesso!";
                    else
                        $rst->msg = "Orçamento recusado com sucesso, aviso foi enviado ao Prestador.";

                    $this->db->select("U.email");
                    $this->db->join("Servico S", "S.id = O.id_servico");
                    $this->db->join("Usuario U", "U.id = S.id_usuario");
                    $query = $this->db->get_where("Orcamento O", "O.id = $data->id_orcamento")->row();

                    $texto = (object)array();

                    $hash = $this->sistema->encrypt_decrypt("encrypt", "Servico/movimentacao/$data->id_orcamento");

                    $texto->email = strtolower($query->email);
                    $texto->titulo = "Contratação do Serviço";
                    $texto->link = base_url("Usuario/page_redirect/$hash");
                    $texto->texto_link = "Ver Pedido";
                    $texto->msg = "Opa, tudo certo? <br/> O serviço que você solicitou lhe enviou uma resposta.<br/> Caso queira ver diretamente o andamento, clique no botão abaixo.";
                    $texto->cid = "";

                    $this->m_sistema->envia_email($texto);
                }
                else
                {
                    $rst->msg = "Erro ao realizar o fechamento do sucesso!";
                }
            }

            return $rst;
        }

        /**
         * Cancela o Serviço
         * @access public
         * @param int $id Identificador do Orçamento
         * @return boolean;
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
                    $this->db->join("Servico S", "S.id = O.id_servico");
                    $this->db->join("Usuario U", "U.id = S.id_usuario");
                    $query = $this->db->get_where("Orcamento O", "O.id = $id")->row();

                    $texto = (object)array();

                    $hash = $this->sistema->encrypt_decrypt("encrypt", "Servico/movimentacao/$id");

                    $texto->email = strtolower($query->email);
                    $texto->titulo = "Contratação do Serviço";
                    $texto->link = base_url("Usuario/page_redirect/$hash");
                    $texto->texto_link = "Ver Pedido";
                    $texto->msg = "Opa, tudo certo? <br/> O serviço que havia sido solicitado foi cancelado pelo Usuario<br/> Caso queira ver diretamente o mais informações, clique no botão abaixo.";
                    $texto->cid = "";

                    $this->m_sistema->envia_email($texto);

                    return true;
                }
            }

            return false;
        }

    /** Fim Orçamento */

}