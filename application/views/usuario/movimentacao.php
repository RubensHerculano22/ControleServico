<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 pt-5">
            <div class="card">
                <div class="card-header" style="background-color: <?= $colores->color2 ?>">
                    <h3 class="card-title" style="color: <?= $colores->color5 ?>"">Acompanhamento de Pedido de Serviço</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                                <?php foreach($info as $key => $item): ?>
                                    <div class="row">
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
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Descrição do Orçamento</label>
                                                <textarea class="form-control" rows="3" readonly><?= $item->descricao ?></textarea>
                                            </div>
                                        </div>
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
                                        <hr class="m-3">
                                    <?php endif; ?>
                                <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <a href="<?= base_url("Usuario/perfil/pedidos") ?>" class="btn float-left" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Voltar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>