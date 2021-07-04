<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perguntas_model extends CI_Model{
    
    function __construct() 
    {
        parent::__construct();
            
    }

    /** Perguntas do Serviço */
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

            if($this->m_sistema->verifica_seguranca($data->pergunta))
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
                $query = $this->db->get_where("Servico", "id = '$data->id_servico'")->row();
                $queryUsuario = $this->db->get_where("Usuario", "id = $data->id_usuario")->row();

                $texto = (object)array();

                $hash = $this->sistema->encrypt_decrypt("encrypt", "Servico/gerenciar_servico/$data->id_servico");

                $texto->email = strtolower($queryUsuario->email);
                $texto->titulo = "Nova pergunta cadastrada";
                $texto->link = base_url("Usuario/page_redirect/$hash");
                $texto->texto_link = "Responder pergunta";
                $texto->msg = "Opa, tudo certo? <br/> Uma nova pergunta foi cadastrar em seu serviço: $query->nome. <br/> Caso queira responder agora clique no botão abaixo.";
                $texto->cid = "";
                $this->m_sistema->envia_email($texto);

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
         * Realiza o cadastrado de perguntas no serviço.
         * @access public
         * @param int $id identificador do serviço
         * @param string $resposta texto para lista apenas respostas vazias
         * @return object;
        */
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

        /**
         * Realiza a resposta a perguntas do sistema.
         * @access public
         * @return object;
        */
        public function responder_pergunta()
        {
            $rst = (object)array("rst" => true, "msg" => "");
            $data = (object)$this->input->post();

            $this->db->set("resposta", $data->resposta);
            $this->db->set("data_resposta", date('Y-m-d H:i:s'));
            
            $this->db->where("id = $data->id_pergunta");
            if($this->db->update("Perguntas"))
            {
                $queryPergunta = $this->db->get_where("Perguntas", "id = '$data->id_pergunta'")->row();
                $query = $this->db->get_where("Servico", "id = '$queryPergunta->id_servico'")->row();
                $queryUsuario = $this->db->get_where("Usuario", "id = $queryPergunta->id_usuario")->row();

                $texto = (object)array();

                $texto->email = strtolower($queryUsuario->email);
                $texto->titulo = "Resposta a sua Pergunta";
                $texto->link = base_url("Servico/detalhes/$query->nome/$query->id");
                $texto->texto_link = "Ver Serviço";
                $texto->msg = "Opa, tudo certo? <br/> Uma resposta a sua pergunta no serviço: $query->nome, foi cadastrada <br/> Caso queira ver diretamente no serviço clique no botão abaixo.";
                $texto->cid = "";

                $this->m_sistema->envia_email($texto);

                $rst->rst = true;
                $rst->msg = "Resposta realizada com sucesso!";
            }
            else
                $rst->msg = "Erro ao realizar resposta ao pergunta";

            return $rst;
        }

    /** Fim Perguntas do Serviço */

}