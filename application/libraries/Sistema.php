<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sistema {

    /**
     * Classe de validacao do sistema
     *
     */
    private $CI;

    // -- Construtor
    public function __construct() {
        $this->CI = & get_instance();
    }

    public function encrypt_decrypt($action, $string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = '!NextoYou@If#';
        $secret_iv = '#If@NextoYou!';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return rtrim($output, "=");
    }

    public function enviar_email($remetente, $destinatario) {
       
        $this->CI->load->library('email');

        $this->CI->email->clear(TRUE);

        $mail_config['smtp_crypto'] = 'tls';
        $mail_config['protocol'] = 'smtp';
        $mail_config['_smtp_auth'] = TRUE;
        $mail_config["smtp_host"] = "smtp.gmail.com";
        $mail_config["smtp_user"] = "rubens.herculano04@gmail.com";
        $mail_config["smtp_pass"] = "ifspsmtp";
        $mail_config["smtp_port"] = "587";
        $mail_config['charset'] = 'utf-8';
        $mail_config["mailtype"] = "html";
        $mail_config['crlf'] = "\r\n";
        $mail_config['newline'] = "\r\n";
        $this->CI->email->initialize($mail_config);

        $this->CI->email->from($remetente->email, "NextoYou");
        $this->CI->email->to($destinatario->email);
        
        $this->CI->email->subject(html_entity_decode($destinatario->assunto));
        $this->CI->email->attach(base_url("assets/img/logo.png"));
        $destinatario->mensagem["cid"] = $this->CI->email->attachment_cid(base_url("assets/img/logo.png"));
        $msg = $this->CI->load->view("email", $destinatario->mensagem, TRUE);
        $this->CI->email->message($msg);
        
        $resposta = $this->CI->email->send();

        if ($resposta) {
            // echo $this->CI->email->print_debugger();
            return TRUE;
        } else {
            // echo $this->CI->email->print_debugger();
            return FALSE;
        }
    }

    public function gerar_senha() {
        $str = md5(date("sYmdHi"));
        $sen = substr($str, rand(0, 15), 6);
        return $sen;
    }

    public function get_cep()
    {
        $data = (object)$this->CI->input->post();
        $result = json_decode(file_get_contents("https://viacep.com.br/ws/".$data->cep."/json/"));
        
        return $result;
    }

}
