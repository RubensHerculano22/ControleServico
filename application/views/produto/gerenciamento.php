<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="row mb-5">
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="small-box" style="background-color: <?= $colores->color2 ?>">
                        <div class="inner" style="color: <?= $colores->color5 ?>">
                            <h3><?= $info_card->visualizacao ?></h3>

                            <p>Visualização do Mês</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-line" style="color: <?= $colores->color3 ?>"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="small-box" style="background-color: <?= $colores->color2 ?>">
                        <div class="inner" style="color: <?= $colores->color5 ?>">
                            <h3><?= $info_card->contratacoes ?></h3>

                            <p>Contratações</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-handshake" style="color: <?= $colores->color3 ?>"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="small-box" style="background-color: <?= $colores->color2 ?>">
                        <div class="inner" style="color: <?= $colores->color5 ?>">
                            <h3><?= $info_card->andamento ?></h3>

                            <p>Em andamento</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-running" style="color: <?= $colores->color3 ?>"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="small-box "style="background-color: <?= $colores->color2 ?>">
                        <div class="inner" style="color: <?= $colores->color5 ?>">
                            <h3><?= $info_card->orcamentos ?></h3>

                            <p>Orçamentos em aberto</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-comments-dollar" style="color: <?= $colores->color3 ?>"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="card card-tabs">
                        <div class="card-header p-0 pt-1" style="background-color: <?= $colores->color2 ?>">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="tabs_link nav-link text-dark active" id="custom-tabs-one-geral-tab" data-toggle="pill" href="#custom-tabs-one-geral" role="tab" aria-controls="custom-tabs-one-geral" aria-selected="true">Gerenciamento Geral</a>
                                </li>
                                <li class="nav-item">
                                    <a class="tabs_link nav-link text-white" id="custom-tabs-one-perguntas-tab" data-toggle="pill" href="#custom-tabs-one-perguntas" role="tab" aria-controls="custom-tabs-one-perguntas" aria-selected="false">Perguntas no Serviço</a>
                                </li>
                                <li class="nav-item">
                                    <a class="tabs_link nav-link text-white" id="custom-tabs-one-orcamento-tab" data-toggle="pill" href="#custom-tabs-one-orcamento" role="tab" aria-controls="custom-tabs-one-orcamento" aria-selected="false">Orçamento</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-one-geral" role="tabpanel" aria-labelledby="custom-tabs-one-geral-tab">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <a href="<?= base_url("Servico/edita_servico/".$id) ?>" class="btn btn-outline-secondary mr-4">Editar</a>
                                        <a href="<?= base_url("Servico/editar_imagens/".$id) ?>" class="btn btn-outline-secondary mr-4">Editar Imagens</a>
                                        <span class="float-right"><input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-text="Visivel" data-off-text="Invisivel" data-on-color="success"></span>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 mt-5">
                                        <h4>Calendario de Serviço</h4>
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-one-perguntas" role="tabpanel" aria-labelledby="custom-tabs-one-perguntas-tab">
                                <h3 class="card-title ">Lista de Perguntas sem Resposta</h3><br/><br/>
                                <div class="row mb-4">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <table class="table table-striped" style="width:100%">
                                            <thead>
                                                <th width="80%">Texto</th>
                                                <th width="20%">Responder</th>
                                            </thead>
                                            <tbody id="lista_pergunta">
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <h3 class="card-title ">Lista Completa de Perguntas</h3><br/>
                                <div class="row">
                                    <div class="col-md-12 co-sm-12 col-xs-12">
                                        <div class="table-responsive">
                                            <table class="table" id="lista_pergunta_completa" style="width: 100%">
                                                <thead></thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-one-orcamento" role="tabpanel" aria-labelledby="custom-tabs-one-orcamento-tab">
                                <div class="row">
                                    <div class="col-md-12 co-sm-12 col-xs-12">
                                        <div class="table-responsive">
                                            <table class="table" id="lista_orcamentos" style="width: 100%">
                                                <thead></thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" value="<?= $id ?>" id="id_servico"/>
    </div>
</div>

<div class="modal fade" id="modal_resposta">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">
                <h4 class="modal-title">Responder pergunta</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: <?= $colores->color5 ?>">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="submit_pergunta">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="nome">Pergunta</label>
                                <textarea class="form-control" name="pergunta_input" rows="3" id="pergunta_input" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="nome">Resposta</label>
                                <textarea class="form-control" name="resposta" rows="3" id="resposta" placeholder="Resposta a pergunta"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id_pergunta" id="id_pergunta" value="" />
                <div class="modal-footer">
                    <button type="submit" class="btn float-right" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_orcamento">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Orçamento</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="submit_orcamento">
                <div class="modal-body">
                    <div class="row">
                        <table width="100%" class="text-center">
                            <tbody id="bloco_orcamento">
                                
                            </tbody>
                        </table>
                    </div>
                    <hr class="orcamentoResposta d-none">
                    <div class="row orcamentoResposta d-none">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group text-center">
                                <div class="custom-control custom-radio d-inline">
                                    <input class="custom-control-input custom-control-input-danger" value="1" type="radio" id="aceitar" name="solicitacao_pedido"required>
                                    <label for="aceitar" class="custom-control-label">Aceitar Pedido </label>
                                </div>
                                <div class="custom-control custom-radio d-inline">
                                    <input class="custom-control-input custom-control-input-danger" value="0" type="radio" id="recusar" name="solicitacao_pedido" required>
                                    <label for="recusar" class="custom-control-label">Recusar Pedido</label>
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
                </div>
                <input type="hidden" value="" id="id_orcamento" name="id_orcamento"/>
                <div class="modal-footer align-self-end orcamentoResposta d-none" id="button_orcamento">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>