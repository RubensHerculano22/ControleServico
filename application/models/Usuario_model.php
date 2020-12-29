<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model{
    
    function __construct() 
    {
        parent::__construct();
            
    }

    public function get_usuario()
    {
        $query = $this->db->get("Usuario")->result();

        return $query;
    }

    public function autentifica($email, $senha)
    {
        $query = $this->db->get_where("Usuario", "email = $email AND senha = '".md5($senha)."'")->result();

        return $query;
    }

    public function geren_usuario()
    {
        $data = (object)$this->input->post();
        $rst = (object)array("rst" => false, "msg" => "");

        echo '<pre>';
        print_r($data);
        echo '</pre>';
        exit;

        $this->db->set("nome", $data->nome);
        $this->db->set("sobrenome", $data->sobrenome);
        $this->db->set("cpf", somente_numeros($data->cpf));
        $this->db->set("data_nascimento", formatar($data->data_nascimento, "dt2bd"));
        $this->db->set("telefone", somente_numeros($data->telefone));
        $this->db->set("celular", somente_numeros($data->celular));
        $this->db->set("endereco", $data->endereco);
        $this->db->set("numero", $data->numero);
        $this->db->set("bairro", $data->bairro);
        $this->db->set("cidade", $data->cidade);
        $this->db->set("estado", $data->estado);
        $this->db->set("email", $data->email);
        $this->db->set("senha", md5($data->senha));

        if($data->id)
        {
            $this->db->where("id", $data->id);
            if($this->db->update("Usuario"))
            {
                $rst->rst = true;
                $rst->msg = "Dados da conta atualizados com sucesso";
            }
            else
            {
                $rst->msg = "Ocorreu um erro ao tentar atualizar os dados, tente novamente mais tarde";
            }
        }
        else
        {
            if($this->db->insert("Usuario"))
            {
                $rst->rst = true;
                $rst->msg = "Cadastro realizado com sucesso, por favor verifique seu email para confirmar a conta.";
            }
            else
            {
                $rst->msg = "Erro ao realizar o cadastro, tente novamente mais tarde.";
            }
        }

        return $rst;
    }



}