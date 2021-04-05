<?php

// Funcao que formata os campos para serem mostrados ou salvos
function formatar($string, $tipo = "")
{
    if(empty($string))
        return false;
    
    // Limpa texto deixando somewnte os numeros
    $string = preg_replace("#[^0-9]#", "", $string);
    
    // Caso nao informe o tipo, detecta alguns padroes
    if (!$tipo)
    {
        switch (strlen($string))
        {
            case 10: 	$tipo = 'fone'; break;
            case 8: 	$tipo = 'cep';  break;
            case 11: 	$tipo = 'cpf';  break;
            case 14:    $tipo = 'cnpj'; break;
        }
    }
    
    // Formata no tipo escolhido
    switch($tipo)
    {
        case 'fone':
            if(strlen($string) == 10)
                $string = '(' . substr($string, 0, 2) . ') ' . substr($string, 2, 4) . '-' . substr($string, 6);
            else
                $string = '(' . substr($string, 0, 2) . ') ' . substr($string, 2, 5) . '-' . substr($string, 7);
            break;
        case 'cep':
            $string = substr($string, 0, 5) . '-' . substr($string, 5, 3);
            break;
        case 'cpf':
            $string = substr($string, 0, 3) . '.' . substr($string, 3, 3) . '.' . substr($string, 6, 3) . '-' . substr($string, 9, 2);
            break;
        case 'cnpj':
            $string = substr($string, 0, 2) . '.' . substr($string, 2, 3) . '.' . substr($string, 5, 3) . '/' . substr($string, 8, 4) . '-' . substr($string, 12, 2);
            break;
        case 'mo2bd':
            $string = substr($string, 0, strlen($string)-2) .'.'. substr($string, -2);
            break;
        case 'dt2bd':
            if(strlen($string) == 8)
                $string = substr($string, -4) . '-' . substr($string, 2, 2) . '-' . substr($string, 0, 2);
            else
                $string = substr($string, 4, 4) . '-' . substr($string, 2, 2) . '-' . substr($string, 0, 2) . ' ' . substr($string, 8, 2) . ':' . substr($string, 10, 2) . ':' . substr($string, -2);
            break;
        case 'bd2dt':
            if(strlen($string) == 8)
                $string = substr($string, -2) . '/' . substr($string, 4, 2) . '/' . substr($string, 0, 4);
            else
                $string = substr($string, 6, 2) . '/' . substr($string, 4, 2) . '/' . substr($string, 0, 4) . ' ' . substr($string, 8, 2) . ':' . substr($string, 10, 2) . ':' . substr($string, -2);
            break;
    }
    return $string;
}

function somente_numeros($string)
{
    return preg_replace("#[^0-9]#", "", $string);
}


function meses($mes)
{
    $arr = array("1" => "Janeiro", "2" => "Fevereiro", "3" => "Março", "4" => "Abril", "5" => "Maio", "6" => "Junho"
                ,"7" => "Julho", "8" => "Agosto", "9" => "Setembro", "10" => "Outubro", "11" => "Novembro", "12" => "Dezembro");
    return $arr[$mes];
}

function mask($string, $mascara)
{
    $string = str_replace(" ","",$string);
    for($i=0;$i<strlen($string);$i++)
    {
        $mascara[strpos($mascara,"#")] = $string[$i];
    }
    return $mascara;
}

function mb_str_pad( $input, $pad_length, $pad_string = ' ', $pad_type = STR_PAD_RIGHT)
{
    //$diff = strlen( $input ) - mb_strlen( $input );
    //return str_pad( $input, $pad_length + $diff, $pad_string, $pad_type );
    
    /*$string = $input;
    $string = preg_replace("/[áàâãä]/", "a", $string);
    $string = preg_replace("/[ÁÀÂÃÄ]/", "A", $string);
    $string = preg_replace("/[éèê]/", "e", $string);
    $string = preg_replace("/[ÉÈÊ]/", "E", $string);
    $string = preg_replace("/[íì]/", "i", $string);
    $string = preg_replace("/[ÍÌ]/", "I", $string);
    $string = preg_replace("/[óòôõö]/", "o", $string);
    $string = preg_replace("/[ÓÒÔÕÖ]/", "O", $string);
    $string = preg_replace("/[úùü]/", "u", $string);
    $string = preg_replace("/[ÚÙÜ]/", "U", $string);
    $string = preg_replace("/ç/", "c", $string);
    $string = preg_replace("/Ç/", "C", $string);
    $string = preg_replace("/[][><}{)(:;,!?*%~^`&#@]/", " ", $string);
    return str_pad($string, $pad_length, $pad_string, $pad_type);*/
    
    $conversao = array('á' => 'a','à' => 'a','ã' => 'a','â' => 'a', 'é' => 'e',
    'ê' => 'e', 'í' => 'i', 'ï'=>'i', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', "ö"=>"o",
    'ú' => 'u', 'ü' => 'u', 'ç' => 'c', 'ñ'=>'n', 'Á' => 'A', 'À' => 'A', 'Ã' => 'A',
    'Â' => 'A', 'É' => 'E', 'Ê' => 'E', 'Í' => 'I', 'Ï'=>'I', "Ö"=>"O", 'Ó' => 'O',
    'Ô' => 'O', 'Õ' => 'O', 'Ú' => 'U', 'Ü' => 'U', 'Ç' =>'C', 'Ñ'=>'N');
    $string = $input; //Substitua pela string que desejas converter
    $string = strtr($string, $conversao); //Irá exibir "Abracao"
    return str_pad($string, $pad_length, $pad_string, $pad_type);
}

function formata_data_info($data)
{
    $info = explode("/", $data);
    $mes = troca_mes($info[1]);
    
    return $mes.".".$info[2];
}

function troca_mes($mes)
{
    switch($mes)
    {
        case 1:
            return 'Jan';
        break;
        case 2:
            return 'Fev';
        break;
        case 3:
            return 'Mar';
        break;
        case 4:
            return 'Abril';
        break;
        case 5:
            return 'Maio';
        break;
        case 6:
            return 'Jun';
        break;
        case 7:
            return 'Jul';
        break;
        case 8:
            return 'Ago';
        break;
        case 9:
            return 'Set';
        break;
        case 10:
            return 'Out';
        break;
        case 11:
            return 'Nov';
        break;
        case 12:
            return 'Dez';
        break;
    }
}

function limpa_uploads ()
{
    $files = glob('./assets/uploads/*'); // get all file names
    foreach ($files as $file) { // iterate files
        if (is_file($file)) 
        {
            unlink($file); // delete file 
        }
    }
}

/* End of file formatacao_helper.php */
/* Location: ./application/helpers/formatacao_helper.php */