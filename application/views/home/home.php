<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div id="bannerhome" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#bannerhome" data-slide-to="0" class="active"></li>
                    <li data-target="#bannerhome" data-slide-to="1"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="<?= base_url("assets/img/Banner.png") ?>" alt="First slide" style="max-height: 750px;">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="<?= base_url("assets/img/Banner2.png") ?>" alt="Second slide" style="max-height: 750px;">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#bannerhome" role="button" data-slide="prev">
                    <span class="carousel-control-custom-icon" aria-hidden="true">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#bannerhome" role="button" data-slide="next">
                    <span class="carousel-control-custom-icon" aria-hidden="true">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
    <div class="row pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 co-xs-12">
                    <h3 class="text-title">Com Altas Avaliações</h3>
                </div> 
                <div class="row">
                    <?php foreach($feedback as $item): ?>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-xs-12 pb-4">
                            <div class="card h-100">
                                <div class="card-header" style="background-color: #e36802">
                                    <h3 class="card-title text-white"><?= $item->usuario->nome ?> - <?= $item->nome ?></h3>
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
                                    <a href="<?= base_url("Servico/detalhes/$item->nome/$item->id") ?>" class="btn btn-block btn-outline-primary">Ver Mais</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-5">
        <div class="col-md-12 col-sm-12 col-xs-12" style="background-color: #f1f1f1;">
            <div class="container pb-5">
                <p class="text-center pt-5" style="font-size: 32px;">O que é <span style="color: #FF4500;">NextoYou?</span></p>
                <p class="text-center pl-5 pr-5"><span style="color: #FF4500;">NextoYou</span> tem como objetivo tornar confortável a relação cliente x prestador e que nossos clientes tenham tudo que necessita em um único 
                sistema, e o melhor de tudo: Tudo bem perto de Você!</p>
                <div class="row pb-5 pt-5">
                    <div class="col-md-4 col-sm-12 co-xs-12 text-center">
                        <img class="img-fluid mb-2 rounded-circle" style="max-width: 100px; max-height: 100px;" src="<?= base_url("assets/img/social.png") ?>" />
                        <h5 class="title">Comunicação direto com o prestador</h5>
                        <p class="text-muted">Tenha a possibilidade de conversar diretamente com os prestadores e tirar todas as suas dúvidas!</p> 
                    </div>
                    <div class="col-md-4 col-sm-12 co-xs-12 text-center">
                        <img class="img-fluid mb-2 rounded-circle" style="max-width: 100px; max-height: 100px;" src="<?= base_url("assets/img/lista_check.png") ?>" />
                        <h5 class="title">Serviços na palma da mão</h5>
                        <p class="text-muted">Uma lista enorme de serviços em um piscar de olhos!</p>
                    </div>
                    <div class="col-md-4 col-sm-12 co-xs-12 text-center">
                        <img class="img-fluid mb-2 rounded-circle" style="max-width: 150px; max-height: 150px;" src="<?= base_url("assets/img/certificado.png") ?>" />
                        <h5 class="title">Avalição de cada um dos serviços</h5>
                        <p class="text-muted">A comunidade contribui com as avaliações e recomendaremos os mais avaliados para você!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div class="col-md-12 col-sm-12 col-xs-12">
                    <div id="avaliacao" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#avaliacao" data-slide-to="0" class="active"></li>
                            <li data-target="#avaliacao" data-slide-to="1"></li>
                            <li data-target="#avaliacao" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="card h-100">
                                            <div class="card-header">
                                                <h3 class="card-title">Primeiro nome da pessoa - Nome do Serviço</h3>
                                            </div>
                                            <div class="card-body">
                                                <i class="fas fa-star" style="color: Gold"></i>
                                                <i class="fas fa-star-half-alt" style="color: Gold"></i>
                                                <i class="far fa-star" style="color: Gold"></i>
                                                <i class="far fa-star" style="color: Gold"></i>
                                                <i class="far fa-star" style="color: Gold"></i> <small class="text-muted">(Media de Avaliação)</small>
                                                <br/>
                                                <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                            </div>
                                            <div class="card-footer">
                                                <h3 class="card-title">Avaliação mais recente</h3>
                                                <br/>
                                                <p class="text-justify">Nome da pessoa que fez a avaliação - Uma avaliação.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="card h-100">
                                            <div class="card-header">
                                                <h3 class="card-title">Primeiro nome da pessoa - Nome do Serviço</h3>
                                            </div>
                                            <div class="card-body">
                                                <i class="fas fa-star" style="color: Gold"></i>
                                                <i class="fas fa-star" style="color: Gold"></i>
                                                <i class="fas fa-star" style="color: Gold"></i>
                                                <i class="fas fa-star" style="color: Gold"></i>
                                                <i class="fas fa-star" style="color: Gold"></i>  <small class="text-muted">(Media de Avaliação)</small>
                                                <br/>
                                                <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                                            </div>
                                            <div class="card-footer">
                                                <h3 class="card-title">Avaliação mais recente</h3>
                                                <br/>
                                                <p class="text-justify">Nome da pessoa que fez a avaliação - Uma avaliação.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="card h-100">
                                            <div class="card-header">
                                                <h3 class="card-title">Primeiro nome da pessoa - Nome do Serviço</h3>
                                            </div>
                                            <div class="card-body">
                                                <i class="fas fa-star" style="color: Gold"></i>
                                                <i class="fas fa-star" style="color: Gold"></i>
                                                <i class="fas fa-star-half-alt" style="color: Gold"></i>
                                                <i class="far fa-star" style="color: Gold"></i>
                                                <i class="far fa-star" style="color: Gold"></i> <small class="text-muted">(Media de Avaliação)</small>
                                                <br/>
                                                <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                            </div>
                                            <div class="card-footer">
                                                <h3 class="card-title">Avaliação mais recente</h3>
                                                <br/>
                                                <p class="text-justify">Nome da pessoa que fez a avaliação - Uma avaliação.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="card h-100">
                                            <div class="card-header">
                                                <h3 class="card-title">Primeiro nome da pessoa - Nome do Serviço</h3>
                                            </div>
                                            <div class="card-body">
                                                <i class="fas fa-star" style="color: Gold"></i>
                                                <i class="fas fa-star-half-alt" style="color: Gold"></i>
                                                <i class="far fa-star" style="color: Gold"></i>
                                                <i class="far fa-star" style="color: Gold"></i>
                                                <i class="far fa-star" style="color: Gold"></i> <small class="text-muted">(Media de Avaliação)</small>
                                                <br/>
                                                <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                            </div>
                                            <div class="card-footer">
                                                <h3 class="card-title">Avaliação mais recente</h3>
                                                <br/>
                                                <p class="text-justify">Nome da pessoa que fez a avaliação - Uma avaliação.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="card h-100">
                                            <div class="card-header">
                                                <h3 class="card-title">Primeiro nome da pessoa - Nome do Serviço</h3>
                                            </div>
                                            <div class="card-body">
                                                <i class="fas fa-star" style="color: Gold"></i>
                                                <i class="fas fa-star" style="color: Gold"></i>
                                                <i class="fas fa-star" style="color: Gold"></i>
                                                <i class="fas fa-star" style="color: Gold"></i>
                                                <i class="fas fa-star" style="color: Gold"></i>  <small class="text-muted">(Media de Avaliação)</small>
                                                <br/>
                                                <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                                            </div>
                                            <div class="card-footer">
                                                <h3 class="card-title">Avaliação mais recente</h3>
                                                <br/>
                                                <p class="text-justify">Nome da pessoa que fez a avaliação - Uma avaliação.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="card h-100">
                                            <div class="card-header">
                                                <h3 class="card-title">Primeiro nome da pessoa - Nome do Serviço</h3>
                                            </div>
                                            <div class="card-body">
                                                <i class="fas fa-star" style="color: Gold"></i>
                                                <i class="fas fa-star" style="color: Gold"></i>
                                                <i class="fas fa-star-half-alt" style="color: Gold"></i>
                                                <i class="far fa-star" style="color: Gold"></i>
                                                <i class="far fa-star" style="color: Gold"></i> <small class="text-muted">(Media de Avaliação)</small>
                                                <br/>
                                                <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                            </div>
                                            <div class="card-footer">
                                                <h3 class="card-title">Avaliação mais recente</h3>
                                                <br/>
                                                <p class="text-justify">Nome da pessoa que fez a avaliação - Uma avaliação.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="card h-100">
                                            <div class="card-header">
                                                <h3 class="card-title">Primeiro nome da pessoa - Nome do Serviço</h3>
                                            </div>
                                            <div class="card-body">
                                                <i class="fas fa-star" style="color: Gold"></i>
                                                <i class="fas fa-star-half-alt" style="color: Gold"></i>
                                                <i class="far fa-star" style="color: Gold"></i>
                                                <i class="far fa-star" style="color: Gold"></i>
                                                <i class="far fa-star" style="color: Gold"></i> <small class="text-muted">(Media de Avaliação)</small>
                                                <br/>
                                                <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                            </div>
                                            <div class="card-footer">
                                                <h3 class="card-title">Avaliação mais recente</h3>
                                                <br/>
                                                <p class="text-justify">Nome da pessoa que fez a avaliação - Uma avaliação.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="card h-100">
                                            <div class="card-header">
                                                <h3 class="card-title">Primeiro nome da pessoa - Nome do Serviço</h3>
                                            </div>
                                            <div class="card-body">
                                                <i class="fas fa-star" style="color: Gold"></i>
                                                <i class="fas fa-star" style="color: Gold"></i>
                                                <i class="fas fa-star" style="color: Gold"></i>
                                                <i class="fas fa-star" style="color: Gold"></i>
                                                <i class="fas fa-star" style="color: Gold"></i>  <small class="text-muted">(Media de Avaliação)</small>
                                                <br/>
                                                <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                                            </div>
                                            <div class="card-footer">
                                                <h3 class="card-title">Avaliação mais recente</h3>
                                                <br/>
                                                <p class="text-justify">Nome da pessoa que fez a avaliação - Uma avaliação.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="card h-100">
                                            <div class="card-header">
                                                <h3 class="card-title">Primeiro nome da pessoa - Nome do Serviço</h3>
                                            </div>
                                            <div class="card-body">
                                                <i class="fas fa-star" style="color: Gold"></i>
                                                <i class="fas fa-star" style="color: Gold"></i>
                                                <i class="fas fa-star-half-alt" style="color: Gold"></i>
                                                <i class="far fa-star" style="color: Gold"></i>
                                                <i class="far fa-star" style="color: Gold"></i> <small class="text-muted">(Media de Avaliação)</small>
                                                <br/>
                                                <p class="text-justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                            </div>
                                            <div class="card-footer">
                                                <h3 class="card-title">Avaliação mais recente</h3>
                                                <br/>
                                                <p class="text-justify">Nome da pessoa que fez a avaliação - Uma avaliação.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#avaliacao" role="button" data-slide="prev">
                            <span class="carousel-control-custom-icon" aria-hidden="true">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#avaliacao" role="button" data-slide="next">
                            <span class="carousel-control-custom-icon" aria-hidden="true">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div> -->