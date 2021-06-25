<div class="<?= ($info[0]->status->id == 1 || $info[0]->status->id == 5) ? "container-fluid" : "container" ?>">
    <div class="row">
        <div class="<?= ($info[0]->status->id == 1 || $info[0]->status->id == 5) ? "col-md-8 col-sm-8" : "col-md-12 col-sm-12" ?> col-xs-12 pt-2">
            <div class="card">
                <div class="card-header" style="background-color: <?= $colores->color2 ?>">
                    <h3 class="card-title" style="color: <?= $colores->color5 ?>"">Acompanhamento de Pedido de Serviço</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <?php foreach($info as $key => $item): ?>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="float-right">
                                            <small><i class="far fa-clock"></i> &nbsp;<?= $item->data_alteracao ?></small>
                                        </div>
                                    </div>
                                    <?php if($item->status->id == 1): ?>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Data para o Serviço</label>
                                                <input type="text" class="form-control" value="<?= $item->data_servico ?>" readonly/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Horario do Serviço</label>
                                                <input type="text" class="form-control" value="<?= $item->hora_servico ?>" readonly/>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Descrição do Serviço</label>
                                                <textarea class="form-control" rows="3" readonly><?= $item->descricao ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Endereço</label>
                                                <input type="text" class="form-control" value="<?= $item->endereco ?>" readonly/>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($item->status->id == 2): ?>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Status do Pedido</label>
                                                <br/><i class="fas fa-chevron-right"></i> Orçamento Gerado
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Orçamento</label>
                                                <input type="text" class="form-control" value="<?= $item->orcamento ?>" readonly/>
                                            </div>
                                        </div>
                                        <?php if($item->descricao): ?>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Descrição do Orçamento</label>
                                                <textarea class="form-control" rows="3" readonly><?= $item->descricao ?></textarea>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if($item->status->id == 3): ?>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Status do Pedido</label>
                                                <br/><i class="fas fa-chevron-right"></i> Serviço Recusado
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Descrição do Orçamento</label>
                                                <textarea class="form-control" rows="3" readonly><?= $item->descricao ?></textarea>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($item->status->id == 4): ?>
                                        <div class="col-md-12 col-sm-12 col-xs-12 mt-4">
                                            <div class="alert alert-dismissible" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">
                                                <h5><i class="icon fas fa-check"></i> Confirmado</h5>
                                                O Serviço foi aceito por ambas as partes, e será realizado no dia: <?= $item->data_servico ?> horário: <?= $item->hora_servico ?>
                                            </div>
                                        </div>
                                        <?php if($key == 0): ?>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <button type="button" class="btn float-right finalizado" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Definir serviço como realizado</button>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if($item->status->id == 5): ?>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Status do Pedido</label>
                                                <br/><i class="fas fa-chevron-right"></i> Serviço Recusado
                                                <small>(No aguardo de uma nova resposta do Prestador)</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Descrição do Orçamento</label>
                                                <textarea class="form-control" rows="3" readonly><?= $item->descricao ?></textarea>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($item->status->id == 6): ?>
                                        <div class="col-md-12 col-sm-12 col-xs-12 mt-4">
                                            <div class="alert alert-danger  alert-dismissible">
                                                <h5><i class="icon fas fa-check"></i> Cancelado</h5>
                                                O serviço foi cancelado por: <?= $item->usuario->nome ?>, na data: <?= $item->data_alteracao ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($item->status->id == 7): ?>
                                        <div class="col-md-12 col-sm-12 col-xs-12 mt-4">
                                            <div class="alert alert-success alert-dismissible">
                                                <h5><i class="icon fas fa-check"></i> Concluido</h5>
                                                O Serviço foi concluido na data: <?= $item->data_alteracao ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if($key < (count($info) - 1)): ?>
                                    <hr class="m-3" style="background-color: #C9EEF2">
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <a href="<?= base_url("Servico/gerenciar_servico/".$info[0]->id_servico) ?>" class="btn float-left" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Voltar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12 pt-2 <?= ($info[0]->status->id == 1 || $info[0]->status->id == 5) ? "" : "d-none" ?>">
            <div class="card">
                <div class="card-header" style="background-color: <?= $colores->color2 ?>">
                    <h3 class="card-title" style="color: <?= $colores->color5 ?>"">Resposta ao pedido</h3>
                </div>
                <form id="submit">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group text-center">
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
                                    <label for="nome">Orçamento</label>
                                    <input type="text" class="form-control preco" name="orcamento" id="orcamento" value="" placeholder="Valor de Orçamento">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="nome">Descrição <small>(Opcional)</small></label>
                                    <textarea class="form-control" name="descricao_orcamento" rows="3" id="descricao_orcamento" placeholder="Descrição sobre o Orçamento do Pedido"></textarea>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id_orcamento" id="id_orcamento" value="<?= $id ?>"/>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <button type="submit" class="btn float-right" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Salvar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>