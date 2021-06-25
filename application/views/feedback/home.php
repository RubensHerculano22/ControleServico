<div class="container-fluid p-5">
    <div class="row">
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="card">
                <div class="card-header" style="background-color: <?= $colores->color2 ?>">
                    <h3 class="card-title" style="color: <?= $colores->color5 ?>">Feedback do Serviço</h3>
                </div>
                <form id="submit">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="nome">Titulo</label>
                                    <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Titulo para o Feedback" autofocus>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group clearfix">
                                    <label for="nome">Avaliação do Serviço</label></br>
                                    <?php for($i=1;$i<=10;$i++): ?>
                                    <div class="icheck-info d-inline pl-3">
                                        <input type="radio" name="avaliacao" value="<?= $i ?>" id="avaliacao<?= $i ?>">
                                        <label for="avaliacao<?= $i ?>"><?= $i ?></label>
                                    </div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="nome">Descrição</label>
                                    <textarea class="form-control" name="descricao" rows="3" id="descricao" placeholder="Descrição sobre o Feedback realizado"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_orcamento" value="<?= $id ?>" />
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
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="card">
                <div class="card-header" style="background-color: <?= $colores->color2 ?>">
                    <h3 class="card-title" style="color: <?= $colores->color5 ?>">Serviço</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <h5>Informações do Serviço</h5>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <img src="data:<?= $servico->imagem->tipo_imagem ?>;base64,<?= $servico->imagem->img ?>" class="product-image" alt="Product Image" style="max-height: 500px;">    
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 mt-3">
                            <h4 class="text-center"><?= $servico->servico->nome ?></h4>
                        </div>
                    </div>
                    <hr>
                    <h5>Informações do Pedido</h5>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <p><b>Data Serviço:</b> <?= formatar($servico->contratacao->data_servico, "bd2dt") ?></p>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <p><b>Horario Serviço:</b> <?= $servico->contratacao->hora_servico ?></p>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <p class="text-justify"><b>Detalhes do pedido:</b> <?= $servico->contratacao->descricao ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>