public function envia_email($texto)
    {
        $remetente["email"] = "rh.movimentacao@reisoffice.com.br";
        $remetente["nome"] = "RH - Movimentação";
        $destinatario["email"] = $texto->email;
        $destinatario["assunto"] = "RH - Movimentação: Solicitação";
        $destinatario["mensagem"]["solicitante"] = $texto->solicitante;
        $destinatario["mensagem"]["cargo"] = $texto->cargo;
        $destinatario["mensagem"]["status"] = $texto->status;
        $destinatario["mensagem"]["tipo_movimentacao"] = $texto->tipo_movimentacao;
        $destinatario["mensagem"]["mensagem"] = $texto->msg;
        $destinatario["mensagem"]["link"] = $texto->link;
        
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

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sistema de Movimentação</title>
    </head>
    <?php
    $arrContextOptions = array (
        "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    ); 
    ?>
    <body style="margin: 0; padding: 0;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
                        <tr>
                            <td align="center" bgcolor="#fafafa" style="padding: 40px 0 30px 0;">
                                <img src="cid:banner_melhor_parceiro.png" alt="Banner Reis Office" width="300" height="80" style="display: block;" />
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 20px; line-height: 20px;">
                                            <b>Movimentação - Portal do RH</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                            <?= $mensagem ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                    <td width="260" valign="top" style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                        Status: <?= $status ?>
                                                    </td>
                                                    <td style="font-size: 0; line-height: 0;" width="20">
                                                        &nbsp;
                                                    </td>
                                                    <td width="260" valign="top" style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                        Tipo de Movimentação: <?= $tipo_movimentacao ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#009cc2" style="padding: 30px 30px 30px 30px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                            <p>Solicitado por: <?= $solicitante ?></p>
                                            <p>Cargo: <?= $cargo ?></p>
                                        </td>
                                        <td>
                                            &nbsp;&nbsp;
                                        </td>
                                        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                            <p><?= $link ?></p>
                                            <p>&nbsp;</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>


<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>NextoYou - Sistema para cadastro e contratação de Serviço</title>
    </head>
    <body style="margin: 0; padding: 0;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
                        <tr>
                            <td align="center" bgcolor="#C9EEF2" style="padding: 40px 0 30px 0;">
                                <img src="cid:banner_melhor_parceiro.png" alt="Banner Reis Office" width="300" height="80" style="display: block;" />
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#FFFFFF" style="padding: 40px 30px 40px 30px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td style="color: #091B26; font-family: Arial, sans-serif; font-size: 20px; line-height: 20px;">
                                            <b>Cadastro de Usuario - NextoYou</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 20px 0 30px 0; color: #091B26; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                            Muito Obrigado por se cadastrar em nosso site.
											Espero que você aproveite a utilização de nosso sistema.
											
                                        </td>
                                    </tr>
                                    <!-- <tr> -->
                                        <!-- <td> -->
                                            <!-- <table border="0" cellpadding="0" cellspacing="0" width="100%"> -->
                                                <!-- <tr> -->
                                                    <!-- <td width="260" valign="top" style="color: #091B26; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;"> -->
                                                        <!-- Status: status -->
                                                    <!-- </td> -->
                                                    <!-- <td style="font-size: 0; line-height: 0;" width="20"> -->
                                                        <!-- &nbsp; -->
                                                    <!-- </td> -->
                                                    <!-- <td width="260" valign="top" style="color: #091B26; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;"> -->
                                                        <!-- Tipo de Movimentação: movimentacao -->
                                                    <!-- </td> -->
                                                <!-- </tr> -->
                                            <!-- </table> -->
                                        <!-- </td> -->
                                    <!-- </tr> -->
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#091B26" style="padding: 30px 30px 30px 30px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td style="color: #F0F2F0; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                            <p>Solicitado por: solicitante</p>
                                            <p>Cargo: cargo</p>
                                        </td>
                                        <td>
                                            &nbsp;&nbsp;
                                        </td>
                                        <td style="color: #F0F2F0; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                            <p>Linkkkk</p>
                                            <p>&nbsp;</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>