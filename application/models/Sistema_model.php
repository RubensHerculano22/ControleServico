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
        $descricao = "<p>materiais para diferentes temas</p>
                    <ul>
                        <li>Ben 10</li>
                        <li>Tinker bell</li>
                        <li>Moana</li>
                        <li>Frozen</li>
                        <li>Galinha Pintadinha</li>
                        <li>Peixonauta</li>
                    </ul>
                    <br/>
                    <p>E muitos outros.</p>";

        $this->db->set("nome", "Materiais para festar de crianaças");
        $this->db->set("ativo", 1);
        $this->db->set("descricao_curta", "Materiais perfeitos para festa de crianças entre 0 a 5 anos, materiais para varios temas.");
        $this->db->set("descricao", $descricao);
        $this->db->set("data_inclusao", "date('now')", false);
        $this->db->set("id_tipo_servico", 2);
        $this->db->set("valor", "150,00");
        $this->db->set("caucao", "50,00");
        $this->db->set("quantidade_disponivel", 7);
        $this->db->set("id_categoria", 11);
        $this->db->set("id_usuario", 1);
        $this->db->insert("Servico");

        $this->db->set("id_tipo_pagamento", 9);
        $this->db->set("id_servico", 6);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 17);
        $this->db->set("id_servico", 6);
        $this->db->insert("PagamentoServico");
        
        $this->db->set("id_tipo_pagamento", 8);
        $this->db->set("id_servico", 6);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 12);
        $this->db->set("id_servico", 6);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 2);
        $this->db->set("id_servico", 6);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 4);
        $this->db->set("id_servico", 6);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 13);
        $this->db->set("id_servico", 6);
        $this->db->insert("PagamentoServico");

        $this->db->set("id_tipo_pagamento", 20);
        $this->db->set("id_servico", 6);
        $this->db->insert("PagamentoServico");



        $this->db->set("img", "Link do endereco da imagem");
        $this->db->set("ativo", 1);
        $this->db->set("principal", 1);//1 ou 0
        $this->db->set("data_insercao", "date('now')", false);
        $this->db->set("id_servico", 6);
        $this->db->insert("Imagens");

        $this->db->set("img", "Link do endereco da imagem");
        $this->db->set("ativo", 1);
        $this->db->set("principal", 1);//1 ou 0
        $this->db->set("data_insercao", "date('now')", false);
        $this->db->set("id_servico", 6);
        $this->db->insert("Imagens");
    }

}