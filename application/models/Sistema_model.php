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

}