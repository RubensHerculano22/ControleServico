<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="card card-danger card-outline">
                <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="https://franquia.globalmedclinica.com.br/wp-content/uploads/2016/01/investidores-img-02-01.png" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?= $info->nome." ".$info->sobrenome ?></h3>

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
                
                <a href="<?= base_url("Usuario/logout") ?>" class="btn btn-danger btn-block"><i class="fas fa-sign-out-alt"></i> <b>Sair</b></a>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="card card-danger card-outline">
                <div class="card-body box-profile">
                    <div class="tab-content" id="vert-tabs-tabContent">
                        <div class="tab-pane text-left fade show active" id="dados_tab" role="tabpanel">
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
                            </div>
                        </div>
                        <div class="tab-pane fade" id="favoritos_tab" role="tabpanel"> <!-- eu -->
                            Lista de Favoritos
                        </div>
                        <div class="tab-pane fade" id="pedidos_tab" role="tabpanel">
                            Pedidos
                        </div>
                        <div class="tab-pane fade" id="cadastrado_tab" role="tabpanel"> <!-- eu -->
                            Lista de serviços cadastrados por você
                        </div>
                        <div class="tab-pane fade" id="suporte_tab" role="tabpanel">
                            Pagina de suporte
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>