View Dashboard

<div class="row clearfix">
    <div class="col-xs-12">        
        <div class="card">             
            <div class="body" id="clienteContent">
                <ul class="nav nav-tabs tab-nav-right" role="tablist">
                    <li role="presentation" class="<?= (empty($tab) || $tab && $tab == "equipamento" || $dados->group_id == 3 ) ? "active" : "" ?>"><a href="#equipamento" class="clipanel" data-toggle="tab">EQUIPAMENTOS</a></li>
                    <?php if($dados->group_id != '3'): ?>
                        <?php if($dados->group_id != '4'): ?>
                            <?php if($dados->group_id != '6'): ?>
                                <li role="presentation" class="<?= ($tab && $tab == "cliente") ? "active" : "" ?>"><a href="#cliente" class="clipanel" data-toggle="tab">LICENÇA</a></li>
                                <li role="presentation" class="<?= ($tab && $tab == "suprimentos") ? "active" : "" ?>"><a href="#suprimentos" class="clipanel" data-toggle="tab">SUPRIMENTOS</a></li>
                            <?php endif; ?>
                        <!--<li role="presentation" class="<?= ($tab && $tab == "auditoria") ? "active" : "" ?>"><a href="#auditoria" class="clipanel" data-toggle="tab">AUDITORIA DE CONTADORES</a></li>-->
                        <li role="presentation" class="<?= ($tab && $tab == "auditoria_contadores") ? "active" : "" ?>"><a href="#auditoria_contadores" class="clipanel" data-toggle="tab">AUDITORIA DE CONTADORES</a></li>
                        <li role="presentation" class="<?= ($tab && $tab == "auditoria_suprimentos") ? "active" : "" ?>"><a href="#auditoria_suprimentos" class="clipanel" data-toggle="tab">AUDITORIA DE SUPRIMENTOS</a></li>
                        <?php endif;?>
                        <?php if($dados->group_id != '6'): ?>
                            <li role="presentation" class="<?= ($tab && $tab == "auditoria_equipamentos") ? "active" : "" ?>"><a href="#auditoria_equipamentos" class="clipanel" data-toggle="tab">AUDITORIA DE EQUIPAMENTOS</a></li>
                            <li role="presentation" class="<?= ($tab && $tab == "usuario_cliente") ? "active" : "" ?>"><a href="#usuario_cliente" class="clipanel" data-toggle="tab">USUARIO DO CLIENTE</a></li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
                <div class="tab-content">                    
                    <div role="tabpanel" class="tab-pane fade active in" id="page">                
                        <div class='alert alert-info'><img src='<?= base_url("images/loading.gif") ?>' height='26' /> Carregando informações...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



Controller


public function listar($tab = false)
    {   
        $this->data["post"] = (object)$this->input->post();
        
        if($this->dados->group_id == 3)
        {
            $tab = "equipamento";
        }
        
        if(!$tab)
        {
            if($this->session->TAB)
                $tab = $this->session->TAB;
            else
                $tab = "equipamento";                    
        }
        
        $this->session->TAB = $tab;
        
        if($tab == "cliente")
        {
            $this->data['cliente'] = $this->m_cliente->get_cliente($this->input->post("id"));
        }
        elseif($tab == "equipamento")
        {
            $this->data["template"] = $this->m_cliente->get_template();
            $this->data["template_cliente"] = $this->m_cliente->get_templates($this->input->post("id"));
            $this->data["template_list"] = $this->m_cliente->get_template_list();
        }
        elseif($tab == "auditoria")
        {
            $this->data["equipamentos"] = $this->m_cliente->get_equipamentos_cliente($this->input->post("id"));
            //$this->data["template_cliente"] = $this->m_cliente->get_templates($this->input->post("id"));
            //$this->data["template_list"] = $this->m_cliente->get_template_list();
        }
        elseif($tab == "suprimentos")
        {
            $this->data["equipamentos"] = $this->m_cliente->get_equipamentos_cliente_ativo($this->input->post("id"));
        }
        elseif($tab == "auditoria_contadores")
        {
            $this->data["equipamentos"] = $this->m_cliente->get_equipamentos_cliente($this->input->post("id"));
            //$this->data["template_cliente"] = $this->m_cliente->get_templates($this->input->post("id"));
            //$this->data["template_list"] = $this->m_cliente->get_template_list();
        }
        elseif($tab == "auditoria_suprimentos")
        {
            $this->data["equipamentos"] = $this->m_cliente->get_equipamentos_cliente($this->input->post("id"));
        }
        elseif($tab == "auditoria_equipamentos")
        {
            $this->data["equipamentos"] = $this->m_cliente->get_equipamentos_cliente($this->input->post("id"));
        }
        elseif($tab == "usuario_cliente")
        {
            $this->data['cliente'] = $this->m_cliente->get_licenca($this->input->post("id"));
        }
        
        $this->load->view("cliente/dashboard_$tab", $this->data);
        
        /*$this->data['titulo'] = "Clientes";
        $this->data['local'] = "Lista geral de Clientes cadastrados no sistema";
        $this->data['bc'] = (object) array("icon" => "users", "titulo" => "Clientes", "local" => "Lista");

        $this->data['js'] = $this->load->view('cliente/js/lista', $this->data, true);
        $this->data['header'] = $this->load->view('template/header', $this->data, TRUE);
        $this->data['navbar'] = $this->load->view('template/navbar', $this->data, TRUE);
        $this->data['sidebar'] = $this->load->view('template/sidebar', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('template/footer', $this->data, TRUE);
        $this->data['content'] = $this->load->view('cliente/lista_cliente', $this->data, TRUE);

        $this->load->view('template/conteudo', $this->data);*/
    }


    Script

    <script>
var postTabData = {id: "<?= $painel->id ?>"};
var loading = "";
    
$(document).ready(function(){
    loading = $("#page").html();

    $('a[data-toggle=tab]').on('shown.bs.tab', function (e) {
        var destino = $(e.target).attr("href");        
        $("#page").html(loading);
        $.post("<?= base_url("cliente/listar") ?>/" + destino.replace("#",""), postTabData, function(page) {
            $("#page").html(page);
        });
    });
    
    // Carrega a pagina principal
    $.post("<?= base_url("cliente/listar") ?>", postTabData, function(page) {
        $("#page").html(page);        
    });
});
</script>


