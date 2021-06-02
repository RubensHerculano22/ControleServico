<div class="container p-5">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pesquisa Personalizada</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                    <?php if($cards): ?>
                        <?php foreach($cards as $item): ?>
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-4">
                                <div class="card h-100">
                                    <div class="card-header" style="background-color: #e36802">
                                        <h3 class="card-title text-white"><?= $item->usuario->nome ?> - <?= $item->nome ?></h3>
                                    </div>
                                    <div class="card-body">
                                        <i class="fas fa-star" style="color: Gold"></i>
                                        <i class="fas fa-star-half-alt" style="color: Gold"></i>
                                        <i class="far fa-star" style="color: Gold"></i>
                                        <i class="far fa-star" style="color: Gold"></i>
                                        <i class="far fa-star" style="color: Gold"></i> <small class="text-muted">(Media de Avaliação)</small>

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
                                        <p class="text-justify"><?= $item->feedback ? $item->feedback : "Esse Serviço ainda não possui avaliação" ?></p>
                                        <!--Nome da pessoa que fez a avaliação - Uma avaliação.-->
                                        <a href="<?= base_url("Servico/detalhes/$item->nome/$item->id") ?>" class="btn btn-block btn-outline-primary">Ver Mais</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>