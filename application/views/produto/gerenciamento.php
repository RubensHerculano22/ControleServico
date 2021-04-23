<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="row mb-5">
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>150</h3>

                            <p>Visualização do Mês</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>150</h3>

                            <p>Contratações</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>150</h3>

                            <p>Em andamento</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-running"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>150</h3>

                            <p>Orçamentos em aberto</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-comments-dollar"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header" style="background-color: #e36802">
                    <h3 class="card-title text-white">Gerenciamento Geral</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <button type="button" class="btn btn-outline-info mr-4">Editar</button>
                            <button type="button" class="btn btn-outline-info mr-4">Pré Visualizar</button>
                            <button type="button" class="btn btn-outline-info mr-4">Orçamento em Aberto</button>
                            <span class="float-right"><input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-text="Visivel" data-off-text="Invisivel" data-on-color="success"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header" style="background-color: #e36802">
                    <h3 class="card-title text-white">Perguntas no Serviço</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 co-sm-12 col-xs-12 text-right">
                            <button type="button" id="ver_lista" class="btn bg-gradient-info btn-sm">Ver Lista Completa</button>
                        </div>
                    </div>
                    <br/>
                    <div class="row" id="lista_pergunta">
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 lcp_bloc d-none">
            <div class="card">
                <div class="card-header" style="background-color: #e36802">
                    <h3 class="card-title text-white">Lista Completa de Perguntas</h3>
                </div>
                <div class="card-body">
                    <div class="row" id="lcp">
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header" style="background-color: #e36802">
                    <h3 class="card-title text-white">Mensagens</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 co-sm-12 col-xs-12">
                            <table class="table" id="lista_mensagem">
                                <thead></thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header" style="background-color: #e36802">
                    <h3 class="card-title text-white">Orçamentos</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 co-sm-12 col-xs-12">
                            <table class="table" id="lista_orcamentos">
                                <thead></thead>
                                <tbody></tbody>
                            </table>
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
            <div class="modal-header">
                <h4 class="modal-title">Responder pergunta</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_orcamento">
    <div class="modal-dialog">
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
                        <div class="col-md-6 col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label for="nome">Data para o Serviço</label>
                                <input type="text" class="form-control data" name="data_servico" id="data_servico" placeholder="Data para o serviço" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask readonly>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="nome">Hora para o Serviço</label>
                                <input type="text" class="form-control data" name="hora_servico" id="hora_servico" placeholder="Hora para o serviço" readonly>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="nome">Descrição</label>
                                <textarea class="form-control" name="descricao" rows="3" id="descricao" placeholder="Descrição sobre o Serviço a ser solicitado" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="nome">Endereço</label>
                                <input type="text" class="form-control" name="endereco" id="endereco" placeholder="Endereço" readonly>
                            </div>     
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input custom-control-input-danger" type="radio" id="aceitar" name="solicitacao_pedido"required>
                                    <label for="aceitar" class="custom-control-label">Aceitar Pedido </label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input custom-control-input-danger" type="radio" id="recusar" name="solicitacao_pedido" required>
                                    <label for="recusar" class="custom-control-label">Recusar Pedido</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="nome">Orçamento</label>
                                <input type="text" class="form-control" name="orcamento" id="orcamento" placeholder="Valor de Orçamento" required>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="nome">Descrição</label>
                                <textarea class="form-control" name="descricao_orcamento" rows="3" id="descricao_orcamento" placeholder="Descrição sobre o Orçamento do Pedido"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>