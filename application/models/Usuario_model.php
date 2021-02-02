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
        $query = $this->db->get_where("Usuario", "email = '$data->email' AND senha = '".md5($data->senha)."'")->row();

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
            $this->db->set("endereco", $data->endereco);
            $this->db->set("numero", somente_numeros($data->numero));
            $this->db->set("bairro", $data->bairro);
            $this->db->set("cidade", $data->cidade);
            $this->db->set("estado", $data->estado);
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
                    $rst->rst = 1;
                    $rst->msg = "Cadastro realizado com sucesso";
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