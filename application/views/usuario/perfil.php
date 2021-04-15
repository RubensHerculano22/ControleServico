<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="card card-info card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="https://franquia.globalmedclinica.com.br/wp-content/uploads/2016/01/investidores-img-02-01.png" alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center"><?= $info->nome." ".$info->sobrenome ?></h3>
                    <p class="text-muted text-center">Membro desde <?= formata_data_info($info->data_criacao_br) ?></p>

                    <ul class="list-group list-group-unbordered mb-3 text-center">
                        <li class="list-group-item tabs" id="dados">
                            <i class="fas fa-user-edit"></i>
                            <b>Perfil</b>
                        </li>
                        <li class="list-group-item tabs" id="favoritos">
                            <i class="fas fa-heart"></i>
                            <b>Favoritos</b>
                        </li>
                        <li class="list-group-item tabs" id="pedidos">
                            <i class="fas fa-list"></i>
                            <b>Contratos</b>
                        </li>
                        <li class="list-group-item tabs" id="cadastrado">
                            <i class="fas fa-edit"></i>
                            <b>Cadastrados por você</b>
                        </li>
                    </ul>
                    
                    <a href="<?= base_url("Usuario/logout") ?>" class="btn btn-warning btn-block"><i class="fas fa-sign-out-alt"></i> <b>Sair</b></a>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="card card-info card-outline">
                <div class="card-body box-profile">
                    <div class="tab-content" id="vert-tabs-tabContent">
                        <div class="tab-pane text-left fade <?= $identificador == "dados" || $identificador == null ? "show active" : "" ?>" id="dados_tab" role="tabpanel">
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nome</label>
                                        <input type="text" class="form-control" id="nome" value="<?= $info->nome ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Sobrenome</label>
                                        <input type="text" class="form-control" id="sobrenome" value="<?= $info->sobrenome ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="text" class="form-control" id="sobrenome" value="<?= $info->email ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Telefone</label>
                                        <input type="text" class="form-control" id="telefone" value="<?= $info->telefone ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Celular</label>
                                        <input type="text" class="form-control" id="celular" value="<?= $info->celular ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Enredeço</label>
                                        <input type="text" class="form-control" value="<?= $info->endereco.", ".$info->numero.", ".$info->bairro.", ".$info->cidade." - ".$info->estado->nome ?>" id="endereco" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 bloc_eye">
                                    <i class="fas fa-eye float-right icon_eyes"></i>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">CPF</label>
                                        <input type="text" class="form-control" id="cpf" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Data Nascimento</label>
                                        <input type="text" class="form-control" id="data_nascimento" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <a href="<?= base_url("Usuario/index/".$info->id) ?>" class="btn btn-warning float-right"><i class="fas fa-edit"></i> Editar Dados</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade <?= $identificador == "favoritos" ? "show active" : "" ?>" id="favoritos_tab" role="tabpanel">
                            <?php foreach($favoritos as $key => $item): ?>
                                <div class="row">
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <?php if($item->img): ?>
                                            <img src="data:<?= $item->img->tipo_imagem ?>;base64,<?= $item->img->img ?>" class="img-fluid mb-2" alt="white sample" style="max-width: 170px; max-height: 120px">
                                        <?php else: ?>
                                            <img src="https://levecrock.com.br/wp-content/uploads/2020/05/Produto-sem-Imagem-por-Enquanto.jpg" class="img-fluid mb-2" alt="white sample" style="max-width: 170px; max-height: 120px">
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-7 col-sm-7 col-xs-12 p-3">
                                        <h4 class="text-center"><?= $item->usuario->nome." - ".$item->servico->nome." - ".$item->categoria->nome ?></h4>
                                        <p class="text-justify pt-2"><?= $item->servico->descricao_curta ?></p>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-12 align-self-center text-center">
                                        <a href="<?= base_url("Servico/detalhes/".$item->servico->nome."/".$item->id_servico) ?>" class="btn btn-warning btn-block">Ver mais</a>
                                    </div>
                                </div>
                                <?php if($key < (count($favoritos) - 1)): ?>
                                    <hr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <div class="tab-pane fade <?= $identificador == "pedidos" ? "show active" : "" ?>" id="pedidos_tab" role="tabpanel">
                            Lista de Serviço Contratos
                        </div>
                        <div class="tab-pane fade <?= $identificador == "cadastrado" ? "show active" : "" ?>" id="cadastrado_tab" role="tabpanel"> <!-- eu -->
                            <?php foreach($cadastrados as $key => $item): ?>
                                <div class="row">
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <?php if($item->img): ?>
                                            <img src="data:<?= $item->img->tipo_imagem ?>;base64,<?= $item->img->img ?>" class="img-fluid mb-2" alt="white sample" style="max-width: 170px; max-height: 120px">
                                        <?php else: ?>
                                            <img src="https://levecrock.com.br/wp-content/uploads/2020/05/Produto-sem-Imagem-por-Enquanto.jpg" class="img-fluid mb-2" alt="white sample" style="max-width: 170px; max-height: 120px">
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-7 col-sm-7 col-xs-12 p-3">
                                        <h4 class="text-center"><?= $item->usuario->nome." - ".$item->nome." - ".$item->categoria->nome ?></h4>
                                        <p class="text-justify pt-2"><?= $item->descricao_curta ?></p>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-12 align-self-center text-center">
                                        <a href="<?= base_url("Servico/gerenciar_produto/".$item->id) ?>" class="btn btn-warning btn-block">Gerenciar</a>
                                    </div>
                                </div>
                                <?php if($key < (count($cadastrados) - 1)): ?>
                                    <hr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <input type="hidden" id="cpf_hidden" value="<?= $info->cpf ?>" />
                        <input type="hidden" id="data_nascimento_hidden" value="<?= $info->data_nascimento ?>" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>