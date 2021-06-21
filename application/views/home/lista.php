<div class="container">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 pb-4">
            <!-- <div class="alert alert-info alert-dismissible">
                <h5><i class="icon fas fa-info"></i> Alert!</h5>
                Area para o banner de cadastro
            </div> -->
            <img src="<?= base_url("assets/img/BannerExemplo.png") ?>" class="img-fluid" style="height: 100px;"/>
            <!-- <button type="button" class="btn btn-outline-secondary btn-lg float-right cadastro_servico">Cadastrar um Serviço</a> -->
        </div>
        <!-- <div class="col-xl-2 col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-xs-12">
                    <div id="accordion1">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
                                    Sub Categoria 1
                                </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="collapse show" data-parent="#accordion1">
                                <div class="card-body">
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary">
                                            <input type="checkbox" id="checkboxPrimary1">
                                            <label for="checkboxPrimary1">
                                                Sub da Sub categoria 1
                                            </label>
                                        </div>
                                        <div class="icheck-primary">
                                            <input type="checkbox" id="checkboxPrimary2">
                                            <label for="checkboxPrimary2">
                                                Sub da Sub categoria 1
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-xs-12">
                    <div id="accordion2">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapseSecondary">
                                        Sub Categoria 2
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseSecondary" class="collapse show" data-parent="#accordion2">
                                <div class="card-body">
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary">
                                            <input type="checkbox" id="checkboxPrimary21">
                                            <label for="checkboxPrimary21">
                                                Sub da Sub categoria 1
                                            </label>
                                        </div>
                                        <div class="icheck-primary">
                                            <input type="checkbox" id="checkboxPrimary22">
                                            <label for="checkboxPrimary22">
                                                Sub da Sub categoria 1
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- <div class="col-xl-10 col-lg-9 col-md-12 col-sm-12 col-xs-12"> -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="container-fluid">
                <div class="row">
                    <?php if($cards): ?>
                        <?php foreach($cards as $item): ?>
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-4">
                                <div class="card h-100">
                                    <div class="card-header" style="background-color: <?= $colores->color2 ?>">
                                        <h3 class="card-title" style="color: <?= $colores->color5 ?>"><?= $item->usuario->nome ?> - <?= $item->nome ?></h3>
                                    </div>
                                    <div class="card-body">
                                        <?php if($item->feedback): ?>
                                            <?php for($i=0;$i<(intval ($item->feedback));$i++): ?>
                                                <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                            <?php endfor; ?>
                                            <?php if(($item->feedback)%2 != 0): ?>
                                                <i class="fas fa-star-half-alt fa-1x" style="color: Gold"></i>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <small>Sem Classficação de Feedback</small>
                                        <?php endif; ?>

                                        <span id="fav<?= $item->id ?>">
                                            <?php if(!empty($item->favorito) && $item->favorito->ativo == 1): ?>
                                                <i class="fas fa-heart float-right" onclick="favoritos('<?= $item->id ?>', 'preenchido')" data-tipo="preenchido" style="color: red" id="item<?= $item->id ?>"></i>
                                            <?php else: ?>
                                                <i class="far fa-heart float-right" onclick="favoritos('<?= $item->id ?>', 'vazio')" data-tipo="vazio" style="color: grey" id="item<?= $item->id ?>"></i>
                                            <?php endif; ?>
                                        </span>
                                        <br/>
                                        <p class="text-justify"><?= $item->descricao_curta ?></p>
                                    </div>
                                    <div class="card-footer">
                                        <h3 class="card-title">Avaliação mais recente</h3>
                                        <br/>
                                        <p class="text-justify"><?= $item->ult_feedback ? $item->ult_feedback : "Esse Serviço ainda não possui avaliação" ?></p>
                                        <!--Nome da pessoa que fez a avaliação - Uma avaliação.-->
                                        <a href="<?= base_url("Servico/detalhes/$item->nome/$item->id") ?>" class="btn btn-block btn-outline-secondary">Ver Mais</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="alert alert-dismissible" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">
                                <h5><i class="icon fas fa-exclamation-triangle"></i> Nenhum serviço encontrado!</h5>
                                Você é um prestador de Serviço? Cadastre-se em nosso sistema, totalmente gratuitamente.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-5">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header" style="background-color: <?= $colores->color2 ?>">
                    <h4 class="card-title" style="color: <?= $colores->color5 ?>">Algumas informações sobre o Serviço: <?= $subcategoria?> </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            aaaaaa
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-3 pb-3">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header" style="background-color: <?= $colores->color2 ?>">
                    <h4 class="card-title" style="color: <?= $colores->color5 ?>">Sugestões de outras categorias</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach($lista_categoria as $item): ?>
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                                <a class="links_categorias" href="<?= base_url("Servico/lista/$categoria/$item->nome") ?>"><?= $item->nome ?></a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>