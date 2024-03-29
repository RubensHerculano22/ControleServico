    <div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-sm-4 col-xs-12">
            <div class="card card-outline card-secondary">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="http://www.conectasa.com.br/wp-content/uploads/2020/07/CentralServicos_996x640_servicos.png" alt="User profile picture">
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
                    
                    <a href="<?= base_url("Usuario/logout") ?>" class="btn btn-block" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>"><i class="fas fa-sign-out-alt"></i> <b>Sair</b></a>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-sm-8 col-xs-12">
            <div class="card card-secondary card-outline">
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
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <?php if($info->ativar_conta == 0): ?>
                                            <button class="btn float-left" id="reenviar_email" data-id="<?= $info->id ?>" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>"> Reenviar email de ativação de conta</button>
                                            <?php endif; ?>
                                            <a href="<?= base_url("Usuario/index/".$info->id) ?>" class="btn float-right" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>"><i class="fas fa-edit"></i> Editar Dados</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label>Endereços</label>
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Endereço</th>
                                                <th>Editar</th>
                                                <th>Remover</th>
                                            </tr>
                                        </thead>
                                        <tbody class="linha_tabela">
                                            <?php foreach($info->enderecos as $item): ?>
                                                <tr>
                                                    <td><?= $item->cep ."( ".$item->endereco.", ".($item->complemento != "" ? $item->numero." ".$item->complemento : $item->numero ).".".$item->bairro." - ".$item->cidade.", ".$item->estado. " )" ?></td>
                                                    <td class='text-center'><a href="<?= base_url("Usuario/geren_endereco/".$item->id) ?>" class='btn btn-warning'><i class='fas fa-edit'></i></a></td>
                                                    <td class='text-center'><a href="<?= base_url("Usuario/remove_endereco/$item->id") ?>" class='btn btn-danger'><i class='fas fa-minus-circle'></i></a></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <a href="<?= base_url("Usuario/geren_endereco/") ?>" class="btn mr-3 float-right" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>"><i class="fas fa-plus"></i> Adicionar Endereço</a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade <?= $identificador == "favoritos" ? "show active" : "" ?>" id="favoritos_tab" role="tabpanel">
                            <?php if($favoritos): ?>
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
                                            <a href="<?= base_url("Servico/detalhes/".$item->servico->nome."/".$item->id_servico) ?>" class="btn btn-block" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Ver mais</a>
                                            <button type="button" data-id="<?= $item->id ?>" class="btn btn-danger btn-block remove_favorito" >Remover do Favoritos</button>
                                            <!-- style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>" -->
                                        </div>
                                    </div>
                                    <?php if($key < (count($favoritos) - 1)): ?>
                                        <hr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else:?>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="alert alert-dismissible" style="background-color: <?= $colores->color4 ?>">
                                        Você não possui nenhum serviço favoritado!
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="tab-pane fade <?= $identificador == "pedidos" ? "show active" : "" ?>" id="pedidos_tab" role="tabpanel">
                            <div id="accordion">
                                <div class="card">
                                    <div class="card-header" style="background-color: <?= $colores->color2 ?>">
                                        <h4 class="card-title w-100">
                                            <a class="d-block w-100" data-toggle="collapse" href="#emandamento" style="color: <?= $colores->color5 ?>">
                                                Em Andamento
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="emandamento" class="collapse show">
                                        <div class="card-body">
                                        <?php if($contratados->andamento): ?>
                                            <?php foreach($contratados->andamento as $key => $item): ?>
                                                <div class="row mb-2">
                                                    <div class="col-xl-2 col-lg-6 col-md-4 col-sm-12 col-xs-12">
                                                        <?php if($item->img): ?>
                                                            <img src="data:<?= $item->img->tipo_imagem ?>;base64,<?= $item->img->img ?>" class="img-fluid mb-2" alt="white sample" style="max-width: 170px; max-height: 120px">
                                                        <?php else: ?>
                                                            <img src="https://levecrock.com.br/wp-content/uploads/2020/05/Produto-sem-Imagem-por-Enquanto.jpg" class="img-fluid mb-2" alt="white sample" style="max-width: 170px; max-height: 120px">
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="col-xl-7 col-lg-6 col-md-8 col-sm-12 col-xs-12 p-3">
                                                        <h4 class="text-center"><?= $item->usuario->nome." - ".$item->servico->nome." - ".$item->categoria->nome ?></h4>
                                                        <p class="text-justify pt-2"><?= $item->servico->descricao_curta ?></p>
                                                    </div>
                                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                                        <div class="row">
                                                            <div class="col-md-12 col-sm-12 col-xs-12 align-self-center text-center mt-2">
                                                                <a href="<?= base_url("Usuario/controle_pedido/".$item->status->id_orcamento) ?>" class="btn btn-block"  style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Acompanhar Contratação</a>
                                                            </div>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 align-self-center text-center mt-2">
                                                                <button type="button" class="btn btn-danger btn-block cancela_servico" data-id="<?= $item->status->id_orcamento ?>" <?= ($item->status->id != 7 && $item->status->id != 6 && $item->status->id != 3) ? "" : "disabled" ?>>Cancelar</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <?php if($key < (count($contratados->andamento) - 1)): ?>
                                                    <hr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="alert alert-dismissible" style="background-color: <?= $colores->color4 ?>">
                                                    Você não possui nenhum serviço contratado em andamento!
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" style="background-color: <?= $colores->color2 ?>">
                                        <h4 class="card-title w-100">
                                            <a class="d-block w-100" data-toggle="collapse" href="#concluidas" style="color: <?= $colores->color5 ?>">
                                                Concluidas
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="concluidas" class="collapse show">
                                        <div class="card-body">
                                        <?php if($contratados->concluido): ?>
                                            <?php foreach($contratados->concluido as $key => $item): ?>
                                                <div class="row mb-2">
                                                    <div class="col-xl-2 col-lg-6 col-md-4 col-sm-12 col-xs-12">
                                                        <?php if($item->img): ?>
                                                            <img src="data:<?= $item->img->tipo_imagem ?>;base64,<?= $item->img->img ?>" class="img-fluid mb-2" alt="white sample" style="max-width: 170px; max-height: 120px">
                                                        <?php else: ?>
                                                            <img src="https://levecrock.com.br/wp-content/uploads/2020/05/Produto-sem-Imagem-por-Enquanto.jpg" class="img-fluid mb-2" alt="white sample" style="max-width: 170px; max-height: 120px">
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="col-xl-7 col-lg-6 col-md-8 col-sm-12 col-xs-12 p-3">
                                                        <h4 class="text-center"><?= $item->usuario->nome." - ".$item->servico->nome." - ".$item->categoria->nome ?></h4>
                                                        <p class="text-justify pt-2"><?= $item->servico->descricao_curta ?></p>
                                                    </div>
                                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                                        <div class="row">
                                                            <div class="col-md-12 col-sm-12 col-xs-12 align-self-center text-center mt-2">
                                                                <a href="<?= base_url("Usuario/controle_pedido/".$item->status->id_orcamento) ?>" class="btn btn-block" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Histórico de Contratação</a>
                                                            </div>
                                                            <?php if($item->realizarFeedback == true): ?>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 align-self-center text-center mt-2">
                                                                <a href="<?= base_url("Feedback/index/".$item->id) ?>" class="btn btn-block" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Realizar Feedback</a>
                                                            </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                </div>
                                                <?php if($key < (count($contratados->concluido) - 1)): ?>
                                                    <hr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="alert alert-dismissible" style="background-color: <?= $colores->color4 ?>">
                                                    Você não possui nenhum serviço contratado concluido!
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade <?= $identificador == "cadastrado" ? "show active" : "" ?>" id="cadastrado_tab" role="tabpanel"> <!-- eu -->
                            <?php if($cadastrados): ?>
                                <?php foreach($cadastrados as $key => $item): ?>
                                    <div class="row">
                                        <div class="col-xl-2 col-lg-6 col-md-4 col-sm-12 col-xs-12">
                                            <?php if($item->img): ?>
                                                <img src="data:<?= $item->img->tipo_imagem ?>;base64,<?= $item->img->img ?>" class="img-fluid mb-2" alt="white sample" style="max-width: 170px; max-height: 120px">
                                            <?php else: ?>
                                                <img src="https://levecrock.com.br/wp-content/uploads/2020/05/Produto-sem-Imagem-por-Enquanto.jpg" class="img-fluid mb-2" alt="white sample" style="max-width: 170px; max-height: 120px">
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-xl-7 col-lg-6 col-md-8 col-sm-12 col-xs-12 p-3">
                                            <h4 class="text-center"><?= $item->usuario->nome." - ".$item->nome." - ".$item->categoria->nome ?></h4>
                                            <p class="text-justify pt-2"><?= $item->descricao_curta ?></p>
                                        </div>
                                        <div class="col-md-3 col-sm-12 col-xs-12 align-self-center text-center">
                                            <a href="<?= base_url("Servico/gerenciar_servico/".$item->id) ?>" class="btn btn-block" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Gerenciar</a>
                                        </div>
                                    </div>
                                    <?php if($key < (count($cadastrados) - 1)): ?>
                                        <hr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="alert alert-dismissible" style="background-color: <?= $colores->color4 ?>">
                                        Você não possui nenhum serviço cadastrado!
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <input type="hidden" id="cpf_hidden" value="<?= $info->cpf ?>" />
                        <input type="hidden" id="data_nascimento_hidden" value="<?= $info->data_nascimento ?>" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_orcamento">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sobre o Orçamento</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="submit">
                <div class="modal-body">
                    <div class="row">
                        <table width="100%" class="text-center">
                            <tbody id="bloco_orcamento">
                                
                            </tbody>
                        </table>
                    </div>
                    <hr style="border: 1px solid #000" class="orcamentoResposta d-none">
                    <div class="row text-center orcamentoResposta d-none">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <div class="custom-control custom-radio d-inline">
                                    <input class="custom-control-input custom-control-input-danger" value="1" type="radio" id="aceitar" name="aceite_orcamento" required>
                                    <label for="aceitar" class="custom-control-label">Aceitar Orçamento </label>
                                </div>
                                <div class="custom-control custom-radio d-inline">
                                    <input class="custom-control-input custom-control-input-danger" value="0" type="radio" id="recusar" name="aceite_orcamento" required>
                                    <label for="recusar" class="custom-control-label">Recusar Orçamento</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="nome">Descrição <small>(Opcional)</small></label>
                                <textarea class="form-control" name="descricao_aceite" rows="3" id="descricao_aceite" placeholder="Descrição sobre a decisão"></textarea>
                            </div>
                        </div>

                        <input type="hidden" name="id_orcamento" id="id_orcamento" value=""/>
                    </div>
                </div>
                <div class="modal-footer align-items-end">
                    <button type="submit" class="btn btn-primary orcamentoResposta d-none">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>