<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sistema_model extends CI_Model{
    
    function __construct() 
    {
        parent::__construct();
            
    }

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

                $rst2[] = array("id" => $value->id, "nome" => $value->nome, "filho" => $query);
            }

            $rst[] = array("id" => $item->id, "nome" => $item->nome, "filho" => $rst2);
        }

        return $rst;
    }

    public function inseri_servico()
    {
        $descricao = "<p>Boleira, entre em contato conosco para diversos tipos de encomenda!</p>
                    <p>Serviços voltados para:</p>
                    <ul>
                        <li>Encomendas para eventos;</li>
                        <li>Encomendas para aniversários;</li>
                        <li>Entre outros!</li>
                    </ul>
                    <br/>";

        $this->db->set("nome", "Boleira - Bolos de Qualidade");
        $this->db->set("ativo", 1);
        $this->db->set("descricao_curta", "Bolos de diversos sabores e tamanhos, para todos os gostos!");
        $this->db->set("descricao", $descricao);
        $this->db->set("data_inclusao", "date('now')", false);
        $this->db->set("id_tipo_servico", 1);
        $this->db->set("valor", "");
        $this->db->set("caucao", "");
        $this->db->set("quantidade_disponivel", );
        $this->db->set("id_categoria", 8);
        $this->db->set("id_usuario", 2);
        $this->db->insert("Servico");

        $this->db->set("id_tipo_pagamento", 4);
        $this->db->set("id_servico", 15);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 3);
        $this->db->set("id_servico", 15);
        $this->db->insert("PagamentoServico");
        
        $this->db->set("id_tipo_pagamento", 10);
        $this->db->set("id_servico", 15);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 8);
        $this->db->set("id_servico", 15);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 12);
        $this->db->set("id_servico", 15);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 19);
        $this->db->set("id_servico", 15);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 16);
        $this->db->set("id_servico", 15);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 17);
        $this->db->set("id_servico", 15);
        $this->db->insert("PagamentoServico");


        $this->db->set("img", "https://images.unsplash.com/photo-1562777717-dc6984f65a63?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=334&q=80");
        $this->db->set("ativo", 1);
        $this->db->set("principal", 1);//1 ou 0
        $this->db->set("data_insercao", "date('now')", false);
        $this->db->set("id_servico", 15);
        $this->db->insert("Imagens");

        $this->db->set("img", "https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=680&q=80");
        $this->db->set("ativo", 1);
        $this->db->set("principal", 0);//1 ou 0
        $this->db->set("data_insercao", "date('now')", false);
        $this->db->set("id_servico", 15);
        $this->db->insert("Imagens");

    }

}