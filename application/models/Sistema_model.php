<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sistema_model extends CI_Model{
    
    function __construct() 
    {
        parent::__construct();
            
    }

    public function get_categorias()
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
        $descricao = "<p>Salão indicado para festas com capacidade de 15 a 30 pessoas.</p>
                      <p>Festas infantis nas idades abaixo:</p>
                    <ul>
                        <li>Festa para crianças de 1 a 5 anos;</li>
                        <li>Festa para crianças de 6 a 9 anos;</li>
                        <li>Festa para crianças de 10 a 14 anos.</li>
                    </ul>
                    <br/>
                    <p>Preços a negociar no momento da locação.";

        $this->db->set("nome", "Salão de Festas Infantis");
        $this->db->set("ativo", 1);
        $this->db->set("descricao_curta", "Salão de Festas voltadas para o público infantil, espaço para 15 a 30 pessoas.");
        $this->db->set("descricao", $descricao);
        $this->db->set("data_inclusao", "date('now')", false);
        $this->db->set("id_tipo_servico", 2);
        $this->db->set("valor", "289,90");
        $this->db->set("caucao", "72,50");
        $this->db->set("quantidade_disponivel", 1);
        $this->db->set("id_categoria", 2);
        $this->db->set("id_usuario", 2);
        $this->db->insert("Servico");

        $this->db->set("id_tipo_pagamento", 5);
        $this->db->set("id_servico", 7);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 15);
        $this->db->set("id_servico", 7);
        $this->db->insert("PagamentoServico");
        
        $this->db->set("id_tipo_pagamento", 1);
        $this->db->set("id_servico", 7);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 18);
        $this->db->set("id_servico", 7);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 16);
        $this->db->set("id_servico", 7);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 12);
        $this->db->set("id_servico", 7);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 19);
        $this->db->set("id_servico", 7);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 3);
        $this->db->set("id_servico", 7);
        $this->db->insert("PagamentoServico");


        $this->db->set("img", "https://images.unsplash.com/photo-1543325768-b7c960228a24?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80");
        $this->db->set("ativo", 1);
        $this->db->set("principal", 1);//1 ou 0
        $this->db->set("data_insercao", "date('now')", false);
        $this->db->set("id_servico", 7);
        $this->db->insert("Imagens");

        $this->db->set("img", "https://images.unsplash.com/photo-1568989357443-057c03fb10fc?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80");
        $this->db->set("ativo", 1);
        $this->db->set("principal", 0);//1 ou 0
        $this->db->set("data_insercao", "date('now')", false);
        $this->db->set("id_servico", 7);
        $this->db->insert("Imagens");
    }

}