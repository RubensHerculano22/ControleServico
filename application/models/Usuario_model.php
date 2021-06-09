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
    );

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
            $query->estado = $this->get_estado_id($query->estado);
            $query->cidade = $this->get_cidade_id($query->cidade);

            $query->cpf = formatar($query->cpf, "cpf");
            $query->telefone = formatar($query->telefone, "fone");
            $query->celular = formatar($query->celular, "fone");
            $query->data_nascimento = formatar($query->data_nascimento, "bd2dt");
            $query->data_criacao_br = formatar(transforma_datatime_to_date($query->data_criacao), "bd2dt");
        }

        return $query;
    }

    /**
     * Realiza a autentificação no sistema.
     * @access public
     * @return object;
    */
    public function autentifica()
    {
        $data = (object)$this->input->post();
        $loginData = (object)$this->loginData;

        if($this->verifica_seguranca($data->email))
        {
            $loginData->logged = false;
            $loginData->error = "Palavra utilizada para o acesso é proibida!";

            return $loginData;
        }
        if($this->verifica_seguranca($data->senha))
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
            $loginData->email = $query->email;
            $loginData->data_criacao = formatar($query->data_insercao, "bd2dt");
            $loginData->data_autentificacao = date("d-m-Y h:i:s");
            $loginData->logged = true;
        }

        return $loginData;
    }

    /**
     * Realiza o cadastro de usuario no sistema.
     * @access public
     * @return object;
    */
    public function salva_usuario()
    {
        $data = (object)$this->input->post();
        $rst = (object)array("rst" => 0, "msg" => "");

        $enderecos = explode(" - ", $data->enderecos);
        
        for($i=0;$i<count($enderecos);$i++)
        {
            $enderecos[$i] = json_decode($enderecos[$i]);
        }

        //verifica se possui um usuario para ser editado e verifica se o email já não está sendo utilizado quando for realizar o cadastro.
        if($this->verifica_seguranca($data->senha))
        {
            $rst->msg = "Palavra utilizada na senha é proibida!";
            return $rst;
        }

        if($this->verifica_seguranca($data->email))
        {
            $rst->msg = "Palavra utilizada no email é proibida!";
            return $rst;
        }

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
                $this->db->set("data_insercao", "date('now')", false);
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
                        $rst->rst = 1;
                        $rst->msg = "Cadastro realizado com sucesso";
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
            $rst->rst = 2;
            $rst->msg = "O Email digitado já está cadastrado no sistema.";
        }

        return $rst;
    }

    public function get_endereco($id)
    {
        return $this->db->get_where("Enderecos", "id = $id")->row();
    }

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

    public function get_servicos_contratos()
    {
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
        }

        // echo '<pre>';
        // print_r($contrato);
        // echo '</pre>';
        // exit;

        return $contrato;
    }

    public function get_orcamentos($id)
    {
        $query = $this->db->get_where("ContrataServico", "id_orcamento = $id")->result();

        foreach($query as $item)
        {
            $item->status = $this->db->get_where("OrcamentoStatus", "id = $item->status")->row();

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
            }
            else
            {
                $rst->msg = "Erro ao realizar o fechamento do sucesso!";
            }
        }

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

    public function get_estado_id($id)
    {
        $query = $this->db->get_where("Estados", "id = '$id'")->row();

        return $query->nome;
    }

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

    /**
     * Realiza a verificação no texto, para maior segurança.
     * @access private
     * @param  string   $dado   Texto a ser verificado.
     * @return boolean;
    */
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