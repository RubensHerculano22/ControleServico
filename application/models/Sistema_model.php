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
         //$descricao = "<p>Venha conhecer a confeitaria que serve o seu evento com diversos tipos de doces.</p>
         //<p>Trabalho com: </p>
         //<ul> 
            //<li>Encomendas para Festas;</li>
            //<li>Encomendas Básicas;</li>
            //<li>Entre outros!;</li>
            //<br/>
        //</ul>
             //<p>Contrate-nos</p>
             //<br/>";
        
       //$this->db->set("descricao", $descricao);

        //$this->db->where("id", 1);
        //$this->db->update("Servico");

        $descricao = "<p>No ramo há 10 anos, trabalho com fotos de qualidade, books ou quadros inclusos</p>
        <p>Presto serviços para: </p>
        <ul> 
            <li>Eventos;</li>
            <li>Aniversários;</li>
            <li>Debutantes;</li>
            <li>Formaturas.</li>
            <br/>
        </ul>
            <p>Converse conosco para acertar todos os detalhes sobre o serviço, faça o seu orçamento!</p>
            <br/>";

        $this->db->set("nome", "Fotográfa");
        $this->db->set("ativo", 1);
        $this->db->set("descricao_curta", "Registre os melhores momentos da sua vida, contrate-nos!");
        $this->db->set("descricao", $descricao);
        $this->db->set("data_inclusao", "date('now')", false);
        $this->db->set("id_tipo_servico", 1);
        $this->db->set("valor", "450,00");
        $this->db->set("caucao", "");
        $this->db->set("quantidade_disponivel", );
        $this->db->set("id_categoria", 13);
        $this->db->set("id_usuario", 2);
        $this->db->insert("Servico");

        $this->db->set("id_tipo_pagamento", 8);
        $this->db->set("id_servico", 17);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 3);
        $this->db->set("id_servico", 17);
        $this->db->insert("PagamentoServico");
        
        $this->db->set("id_tipo_pagamento", 5);
        $this->db->set("id_servico", 17);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 7);
        $this->db->set("id_servico", 17);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 9);
        $this->db->set("id_servico", 17);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 15);
        $this->db->set("id_servico", 17);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 13);
        $this->db->set("id_servico", 17);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 20);
        $this->db->set("id_servico", 17);
        $this->db->insert("PagamentoServico");


        $this->db->set("img", "https://images.unsplash.com/photo-1563018259-f7bf99f6b1b0?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80");
        $this->db->set("ativo", 1);
        $this->db->set("principal", 1);//1 ou 0
        $this->db->set("data_insercao", "date('now')", false);
        $this->db->set("id_servico", 17); 
        $this->db->insert("Imagens");

        $this->db->set("img", "https://images.unsplash.com/photo-1457461027293-311fd5a4a6d6?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80");
        $this->db->set("ativo", 1);
        $this->db->set("principal", 0);//1 ou 0
        $this->db->set("data_insercao", "date('now')", false);
        $this->db->set("id_servico", 17);
        $this->db->insert("Imagens");

        //$this->db->set("img", "https://images.unsplash.com/photo-1512099053734-e6767b535838?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=628&q=80");
        //$this->db->set("ativo", 1);
        //$this->db->set("principal", 0);//1 ou 0
        //$this->db->set("data_insercao", "date('now')", false);
        //$this->db->set("id_servico", 17);
        //$this->db->insert("Imagens");

    }

    //<ul> 
        //<li>Encomendas para eventos;</li>
        //<li>Encomendas para aniversários;</li>
        //<li>Entre outros!</li>
    //<br/>
    //</ul>

}