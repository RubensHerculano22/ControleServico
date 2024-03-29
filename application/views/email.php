<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <title>NextoYou - Sistema para cadastro e contratação de Serviço</title>
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
                            <td align="center" bgcolor="#C9EEF2" style="padding: 40px 0 30px 0;">
                                <img src="cid:<?= $cid ?>" alt="Banner NextoYou" width="200" height="200" style="display: block;" />
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#FFFFFF" style="padding: 40px 30px 40px 30px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td style="color: #091B26; font-family: Arial, sans-serif; font-size: 20px; line-height: 20px;">
                                            <b><?= $titulo ?></b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 20px 0 30px 0; color: #091B26; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
											<?=  $mensagem ?>
                                            <?php if(isset($texto_link) && !empty($texto_link)): ?>
                                            <br/><br/><br/>
											<a href="<?= $link ?>" target="_blank" style="padding: 8px 12px; border: 1px solid #54828C;border-radius: 2px;font-family: Helvetica, Arial, sans-serif;font-size: 14px; color: #000000;text-decoration: none;font-weight:bold;display: inline-block; background-color: #54828C; display: flex; align-items: center; justify-content: center;">
												<span class="display: flex; align-items: center; justify-content: center;"><?= $texto_link ?></span>
											</a>
                                            <?php endif; ?>
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
                            <td bgcolor="#254B59" style="padding: 30px 30px 30px 30px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td style="padding: 20px 0 30px 0; color: #F0F2F0; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                            Muito Obrigade! por utilizar nosso site e espero que você esteja tendo uma otima experiência.<br/>
											Caso possua alguma duvida ou sugestão, nos envie uma email no seguinte endereço: <b style="color: #091B26">teste@teste.com</b>.
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