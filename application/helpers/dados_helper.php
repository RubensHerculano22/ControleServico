<?php

    function get_estados()
    {
        return array(
            (object)array("id" => "1", "nome" => "Acre", "sigla" => "AC"),
            (object)array("id" => "2", "nome" => "Alagoas", "sigla" => "AL"),
            (object)array("id" => "3", "nome" => "Amapá", "sigla" => "AP"),
            (object)array("id" => "4", "nome" => "Amazonas", "sigla" => "AM"),
            (object)array("id" => "5", "nome" => "Bahia", "sigla" => "BA"),
            (object)array("id" => "6", "nome" => "Ceará", "sigla" => "CE"),
            (object)array("id" => "7", "nome" => "Espírito Santo", "sigla" => "ES"),
            (object)array("id" => "8", "nome" => "Goiás", "sigla" => "GO"),
            (object)array("id" => "9", "nome" => "Maranhão", "sigla" => "MA"),
            (object)array("id" => "10", "nome" => "Mato Grosso", "sigla" => "MT"),
            (object)array("id" => "11", "nome" => "Mato Grosso do Sul", "sigla" => "MS"),
            (object)array("id" => "12", "nome" => "Minas Gerais", "sigla" => "MG"),
            (object)array("id" => "13", "nome" => "Pará", "sigla" => "PA"),
            (object)array("id" => "14", "nome" => "Paraíba", "sigla" => "PB"),
            (object)array("id" => "15", "nome" => "Paraná", "sigla" => "PR"),
            (object)array("id" => "16", "nome" => "Pernambuco", "sigla" => "PE"),
            (object)array("id" => "17", "nome" => "Piauí", "sigla" => "PI"),
            (object)array("id" => "18", "nome" => "Rio de Janeiro", "sigla" => "RJ"),
            (object)array("id" => "19", "nome" => "Rio Grande do Norte", "sigla" => "RN"),
            (object)array("id" => "20", "nome" => "Rio Grande do Sul", "sigla" => "RS"),
            (object)array("id" => "21", "nome" => "Rondônia", "sigla" => "RO"),
            (object)array("id" => "22", "nome" => "Roraima", "sigla" => "RR"),
            (object)array("id" => "23", "nome" => "Santa Catarina", "sigla" => "SC"),
            (object)array("id" => "24", "nome" => "São Paulo", "sigla" => "SP"),
            (object)array("id" => "25", "nome" => "Sergipe", "sigla" => "SE"),
            (object)array("id" => "26", "nome" => "Tocantins", "sigla" => "TO"),
            (object)array("id" => "27", "nome" => "Distrito Federal", "sigla" => "DF"),
        );
    }

    function get_estados_id($id)
    {
        $estado = get_estados();
        
        return $estado[$id-1];
    }

    function palavra_proibidas()
    {
        return array(
            "select",
            "delete",
            "update",
            "insert",
            "alter",
            "join",
            "order",
            "group",
            "function",
            "and",
            "add",
            "--",
            "continue",
            "break",
            "case",
            "into",
            "if",
            "having",
            "from",
            "kill",
            "like",
            "ignore",
            "primary",
            "read",
            "rename",
            "replace",
            "return",
            "references",
            "regexp",
            "schema",
            "sql",
            "table",
            "then",
            "unlock",
            "while",
            "where",
            "when",
            "values",
            "varchar"
        );
    }

?>