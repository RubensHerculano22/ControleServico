<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="card-header" style="background-color: #e36802">
                                <h3 class="card-title text-white">Informações</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8 col-sm-12">
                                        <div class="col-12">
                                            <?php if($info->imagens): ?>
                                                <img src="data:<?= $info->imagens[0]->tipo_imagem ?>;base64,<?= $info->imagens[0]->img ?>" class="product-image" alt="Product Image" style="max-height: 500px;">    
                                            <?php else: ?>
                                                <img src="https://levecrock.com.br/wp-content/uploads/2020/05/Produto-sem-Imagem-por-Enquanto.jpg" class="product-image" alt="Product Image" style="max-width:500px;">
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-12 product-image-thumbs">
                                            <?php if($info->imagens): ?>
                                                <?php foreach($info->imagens as $key => $item): ?>
                                                    <div class="product-image-thumb <?= $key == 0 ? "active" : "" ?>"><img src="data:<?= $item->tipo_imagem ?>;base64,<?= $item->img ?>"  alt="Product Image"></div>        
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="product-image-thumb active"><img src="https://levecrock.com.br/wp-content/uploads/2020/05/Produto-sem-Imagem-por-Enquanto.jpg"  alt="Product Image"></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <h3 class="my-3"><?= $info->nome ?></h3>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                <i class="fas fa-star-half-alt fa-1x" style="color: Gold"></i>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 text-right">
                                                <span id="fav<?= $info->id ?>">
                                                    <?php if(!empty($info->favorito) && $info->favorito->ativo == 1): ?>
                                                        <i class="fas fa-heart float-right" onclick="favoritos('<?= $info->id ?>', 'preenchido')" data-tipo="preenchido" style="color: red" id="item<?= $info->id ?>"></i>
                                                    <?php else: ?>
                                                        <i class="far fa-heart float-right" onclick="favoritos('<?= $info->id ?>', 'vazio')" data-tipo="vazio" style="color: grey" id="item<?= $info->id ?>"></i>
                                                    <?php endif; ?>
                                                </span>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="mt-4">
                                            <h2 class="mb-0">
                                            <?= $info->valor ? "R$: ".$info->valor : "A Combinar" ?>
                                            </h2>
                                        </div>

                                        <?php if($info->quantidade_disponivel): ?>
                                        <div class="mt-2">
                                            <h6><b>Quantidade:</b> <?= $info->quantidade_disponivel ?></h6>
                                        </div>
                                        <?php endif; ?>
                                        <?php if($info->caucao): ?>
                                        <div class="mt-2">
                                            <h5><b>Caução:</b> <?= "R$: ".$info->caucao ?></h5>
                                        </div>
                                        <?php endif; ?>

                                        <div class="mt-4">
                                            <button type="button" id="contratar" class="btn btn-warning btn-block btn-lg" data-toggle="modal" data-target="#modal_contratacao">
                                                <i class="fas fa-handshake"></i>
                                                Contratar
                                            </button>
                                        </div>
                                        <div class="mt-4">
                                            <h6><b>Horários de Funcionamento:</b></h6>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody>
                                                        <?php foreach($info->horario as $item): ?>
                                                        <tr>
                                                            <th><?= $item->dia_semana->titulo ?></th>
                                                            <td><?= $item->texto ?></td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="card-header" style="background-color: #e36802">
                                <h3 class="card-title text-white">Meios de Pagamento</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus text-white"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h6>Cartão de Credito</h6>
                                        <div class="row">
                                            <?php foreach($info->pagamento as $item): ?>
                                                <?php if($item->id_tipo_pagamento == 1): ?>
                                                    <div class="col-md-3 col-sm-4">
                                                        <img class="img-fluid mb-2" src="https://latinoscassinos.com/wp-content/uploads/2019/01/62.png" style="max-width: 150px; max-height: 40px;" />
                                                        <span class="text-muted"><?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                    </div>        
                                                <?php endif; ?>
                                                <?php if($item->id_tipo_pagamento == 2): ?>
                                                    <div class="col-md-3 col-sm-4">
                                                        <img class="img-fluid mb-2" src="https://i.pinimg.com/originals/dd/65/f3/dd65f3c6a80e7bb059d3f2630399826b.jpg" style="max-width: 150px; max-height: 40px;" />
                                                        <span class="text-muted"><?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                    </div> 
                                                <?php endif; ?>
                                                <?php if($item->id_tipo_pagamento == 3): ?>
                                                    <div class="col-md-3 col-sm-4">
                                                        <img class="img-fluid mb-2" src="https://logospng.org/download/cartao-elo/logo-cartao-elo-colorido-fundo-preto-256.png" style="max-width: 150px; max-height: 40px;" />
                                                        <span class="text-muted"><?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                    </div>     
                                                <?php endif; ?>
                                                <?php if($item->id_tipo_pagamento == 4): ?>
                                                    <div class="col-md-3 col-sm-4">
                                                        <img class="img-fluid mb-2" src="https://i2.wp.com/goldlinebrow.com/wp-content/uploads/2018/02/American-Express-icon.png?ssl=1" style="max-width: 150px; max-height: 40px;" />
                                                        <span class="text-muted"><?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if($item->id_tipo_pagamento == 5): ?>
                                                    <div class="col-md-3 col-sm-4">
                                                        <img class="img-fluid mb-2" src="https://logospng.org/download/hipercard/logo-hipercard-256.png" style="max-width: 150px; max-height: 40px;" />
                                                        <span class="text-muted"><?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                    </div>    
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h6 class="">Cartão de Debito</h6>
                                        <div class="row">
                                            <?php foreach($info->pagamento as $item): ?>
                                                <?php if($item->id_tipo_pagamento == 6): ?>
                                                    <div class="col-md-3 col-sm-4">
                                                        <img class="img-fluid mb-2" src="https://latinoscassinos.com/wp-content/uploads/2019/01/62.png" style="max-width: 150px; max-height: 40px;" />
                                                        <span class="text-muted"><?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if($item->id_tipo_pagamento == 7): ?>
                                                    <div class="col-md-3 col-sm-4">
                                                        <img class="img-fluid mb-2" src="https://i.pinimg.com/originals/dd/65/f3/dd65f3c6a80e7bb059d3f2630399826b.jpg" style="max-width: 150px; max-height: 40px;" />
                                                        <span class="text-muted"><?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if($item->id_tipo_pagamento == 8): ?>
                                                    <div class="col-md-3 col-sm-4">
                                                        <img class="img-fluid mb-2" src="https://logospng.org/download/cartao-elo/logo-cartao-elo-colorido-fundo-preto-256.png" style="max-width: 150px; max-height: 40px;" />
                                                        <span class="text-muted"><?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if($item->id_tipo_pagamento == 9): ?>
                                                    <div class="col-md-3 col-sm-4">
                                                        <img class="img-fluid mb-2" src="https://i2.wp.com/goldlinebrow.com/wp-content/uploads/2018/02/American-Express-icon.png?ssl=1" style="max-width: 150px; max-height: 40px;" />
                                                        <span class="text-muted"><?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if($item->id_tipo_pagamento == 10): ?>
                                                    <div class="col-md-3 col-sm-4">
                                                        <img class="img-fluid mb-2" src="https://logospng.org/download/hipercard/logo-hipercard-256.png" style="max-width: 150px; max-height: 40px;" />
                                                        <span class="text-muted"><?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h6 class="">Transferência</h6>
                                        <div class="row">
                                            <?php foreach($info->pagamento as $item): ?>
                                                <?php if($item->id_tipo_pagamento == 11): ?>
                                                    <div class="col-lg-3 col-md-3 col-sm-4">
                                                        <img class="img-fluid mb-2" src="https://logospng.org/download/itau/logo-itau-256.png" style="max-width: 150px; max-height: 40px;" />
                                                        <span class="text-muted">Itau <?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if($item->id_tipo_pagamento == 12): ?>
                                                    <div class="col-lg-3 col-md-3 col-sm-4">
                                                        <img class="img-fluid mb-2" src="https://logospng.org/download/nubank/logo-nu-nubank-roxo-icon-256.png" style="max-width: 150px; max-height: 40px;" />
                                                        <span class="text-muted">Nubank <?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if($item->id_tipo_pagamento == 13): ?>
                                                    <div class="col-lg-3 col-md-3 col-sm-4">
                                                        <img class="img-fluid mb-2" src="https://logospng.org/download/santander/logo-santander-icon-256.png" style="max-width: 150px; max-height: 40px;" />
                                                        <span class="text-muted">Santander <?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if($item->id_tipo_pagamento == 14): ?>
                                                    <div class="col-lg-3 col-md-3 col-sm-4">
                                                        <img class="img-fluid mb-2" src="https://banco.bradesco/favicon.ico" style="max-width: 150px; max-height: 40px;" />
                                                        <span class="text-muted">Bradesco <?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if($item->id_tipo_pagamento == 15): ?>
                                                    <div class="col-lg-3 col-md-3 col-sm-4">
                                                        <img class="img-fluid mb-2" src="https://logospng.org/download/caixa-economica-federal/logo-caixa-economica-federal-256.png" style="max-width: 150px; max-height: 40px;" />
                                                        <span class="text-muted">Caixa <?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if($item->id_tipo_pagamento == 16): ?>
                                                    <div class="col-lg-3 col-md-3 col-sm-4">
                                                        <img class="img-fluid mb-2" src="https://logospng.org/download/mercado-pago/logo-mercado-pago-icone-256.png" style="max-width: 150px; max-height: 40px;" />
                                                        <span class="text-muted">Mercado pago <?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if($item->id_tipo_pagamento == 17): ?>
                                                    <div class="col-lg-3 col-md-3 col-sm-4">
                                                        <img class="img-fluid mb-2" src="https://logospng.org/download/picpay/logo-picpay-256.png" style="max-width: 150px; max-height: 40px;" />
                                                        <span class="text-muted">PicPay <?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if($item->id_tipo_pagamento == 18): ?>
                                                    <div class="col-lg-3 col-md-3 col-sm-4">
                                                        <img class="img-fluid mb-2" src="https://cdn.iconscout.com/icon/free/png-256/paypal-5-226456.png" style="max-width: 150px; max-height: 40px;" />
                                                        <span class="text-muted">PayPal <?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if($item->id_tipo_pagamento == 19): ?>
                                                    <div class="col-lg-3  col-md-3 col-sm-4">
                                                        <img class="img-fluid mb-2" src="https://logospng.org/download/banco-do-brasil/logo-banco-do-brasil-icon-256.png" style="max-width: 150px; max-height: 40px;" />
                                                        <span class="text-muted">Banco do Brasil <?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h6>Outros Meios</h6>
                                        <div class="row">
                                            <?php foreach($info->pagamento as $item): ?>
                                                <?php if($item->id_tipo_pagamento == 20): ?>
                                                    <div class="col-md-2 col-sm-4">
                                                        <img class="img-fluid mb-2" src="https://www.autoimportsweb.com.br/wp-content/uploads/2019/02/ico_boleto.svg" style="max-width: 150px; max-height: 40px;" />
                                                        <span class="text-muted">Boleto <?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="card-header" style="background-color: #e36802">
                                <h3 class="card-title text-white">Descrição</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus text-white"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <?= $info->descricao ?>
                                        <!-- <p class="text-justify"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae condimentum erat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed posuere, purus at efficitur hendrerit, augue elit lacinia arcu, a eleifend sem elit et nunc. Sed rutrum vestibulum est, sit amet cursus dolor fermentum vel. Suspendisse mi nibh, congue et ante et, commodo mattis lacus. Duis varius finibus purus sed venenatis. Vivamus varius metus quam, id dapibus velit mattis eu. Praesent et semper risus. Vestibulum erat erat, condimentum at elit at, bibendum placerat orci. Nullam gravida velit mauris, in pellentesque urna pellentesque viverra. Nullam non pellentesque justo, et ultricies neque. Praesent vel metus rutrum, tempus erat a, rutrum ante. Quisque interdum efficitur nunc vitae consectetur. Suspendisse venenatis, tortor non convallis interdum, urna mi molestie eros, vel tempor justo lacus ac justo. Fusce id enim a erat fringilla sollicitudin ultrices vel metus.</p>
                                        <p class="text-justify"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae condimentum erat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed posuere, purus at efficitur hendrerit, augue elit lacinia arcu, a eleifend sem elit et nunc. Sed rutrum vestibulum est, sit amet cursus dolor fermentum vel. Suspendisse mi nibh, congue et ante et, commodo mattis lacus. Duis varius finibus purus sed venenatis. Vivamus varius metus quam, id dapibus velit mattis eu. Praesent et semper risus. Vestibulum erat erat, condimentum at elit at, bibendum placerat orci. Nullam gravida velit mauris, in pellentesque urna pellentesque viverra. Nullam non pellentesque justo, et ultricies neque. Praesent vel metus rutrum, tempus erat a, rutrum ante. Quisque interdum efficitur nunc vitae consectetur. Suspendisse venenatis, tortor non convallis interdum, urna mi molestie eros, vel tempor justo lacus ac justo. Fusce id enim a erat fringilla sollicitudin ultrices vel metus.</p>
                                        <ul>
                                            <li>Lorem ipsum dolor sit amet</li>
                                            <li>Consectetur adipiscing elit</li>
                                            <li>Integer molestie lorem at massa</li>
                                            <li>Facilisis in pretium nisl aliquet</li>
                                            <li>Nulla volutpat aliquam velit
                                                <ul>
                                                    <li>Phasellus iaculis neque</li>
                                                    <li>Purus sodales ultricies</li>
                                                    <li>Vestibulum laoreet porttitor sem</li>
                                                    <li>Ac tristique libero volutpat at</li>
                                                </ul>
                                            </li>
                                            <li>Faucibus porta lacus fringilla vel</li>
                                            <li>Aenean sit amet erat nunc</li>
                                            <li>Eget porttitor lorem</li>
                                        </ul> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="card-header" style="background-color: #e36802">
                                <h3 class="card-title text-white">Duvidas</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus text-white"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5 class="text-bold">Pergunte ao Prestador</h5>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="pergunta" placeholder="Digite aqui!">
                                            <span class="input-group-append">
                                                <button type="button" id="perguntar" class="btn btn-warning">Perguntar!</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-5">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h3 class="card-title text-bold">Ultimas Realizadas</h3>
                                        <br/>
                                        <br/>
                                        <div class="pergunta">
                                            <?php if($info->perguntas): ?>
                                                <?php foreach($info->perguntas as $item): ?>
                                                <h6 class="text-justify"><?= $item->pergunta ?>.</h6>
                                                <ul>
                                                    <?php if($item->resposta): ?>
                                                        <li><span class="text-muted"><?= $item->resposta ?>.  <small>- <?= formatar($item->data_resposta, "bd2dt") ?></small></span</li>
                                                    <?php else: ?>
                                                        <li><span class="text-muted">Sem resposta ainda!</span</li>
                                                    <?php endif; ?>
                                                </ul>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="callout callout-warning mensagem_pergunta">
                                                    <p>Este Serviço ainda não possui perguntas. Seja o primeiro a realizar.</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="card-header" style="background-color: #e36802">
                                <h3 class="card-title text-white">Opiniões sobre o serviço</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus text-white"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-4 col-sm-3 col-xs-12 text-right">
                                        <h1>4.5</h1>
                                        <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                        <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                        <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                        <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                        <i class="fas fa-star-half-alt fa-1x" style="color: Gold"></i>
                                    </div>
                                    <div class="col-md-6 col-sm-9 col-xs-12">
                                        <table class="table table-borderless table-sm">
                                            <tr>
                                                <td width="26%">5 Estrelas</td>
                                                <td width="70%">
                                                    <div class="progress progress-sm">
                                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    12
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="26%">4 Estrelas</td>
                                                <td width="70%">
                                                    <div class="progress progress-sm">
                                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 10%">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    4
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="26%">3 Estrelas</td>
                                                <td width="70%">
                                                    <div class="progress progress-sm">
                                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 2%">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    1
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="26%">2 Estrelas</td>
                                                <td width="70%">
                                                    <div class="progress progress-sm">
                                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    0
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="26%">1 Estrelas</td>
                                                <td width="70%">
                                                    <div class="progress progress-sm">
                                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    0
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="row">
                                            <div class="col-lg-2 col-md-3 col-sm-3 col">
                                                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                                    <a class="nav-link active" id="vert-tabs-todos-tab" style="color: #e36802" data-toggle="pill" href="#vert-tabs-todos" role="tab" aria-controls="vert-tabs-todos" aria-selected="true">Todos</a>
                                                    <a class="nav-link" id="vert-tabs-positivos-tab" style="color: #e36802" data-toggle="pill" href="#vert-tabs-positivos" role="tab" aria-controls="vert-tabs-positivos" aria-selected="false">Positivas</a>
                                                    <a class="nav-link" id="vert-tabs-negativos-tab" style="color: #e36802" data-toggle="pill" href="#vert-tabs-negativos" role="tab" aria-controls="vert-tabs-negativos" aria-selected="false">Negativas</a>
                                                </div>
                                            </div>
                                            <div class="col-lg-10 col-md-9 col-sm-9 col">
                                                <div class="tab-content" id="vert-tabs-tabContent">
                                                    <div class="tab-pane text-left fade show active" id="vert-tabs-todos" role="tabpanel" aria-labelledby="vert-tabs-todos-tab">
                                                        <div class="pb-4">
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star-half-alt fa-1x" style="color: Gold"></i>

                                                            <h6 class="text-bold">Um titulo para o Feedback</h6>
                                                            <p class="text-justify">Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.</p>
                                                        </div>
                                                        <div class="pb-4">
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star-half-alt fa-1x" style="color: Gold"></i>

                                                            <h6 class="text-bold">Um titulo para o Feedback</h6>
                                                            <p class="text-justify">Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.</p>
                                                        </div>
                                                        <div class="pb-4">
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star-half-alt fa-1x" style="color: Gold"></i>

                                                            <h6 class="text-bold">Um titulo para o Feedback</h6>
                                                            <p class="text-justify">Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.</p>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="vert-tabs-positivos" role="tabpanel" aria-labelledby="vert-tabs-positivos-tab">
                                                        <div class="pb-4">
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star-half-alt fa-1x" style="color: Gold"></i>

                                                            <h6 class="text-bold">Um titulo para o Feedback</h6>
                                                            <p class="text-justify">Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.</p>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="vert-tabs-negativos" role="tabpanel" aria-labelledby="vert-tabs-negativos-tab">
                                                        <div class="pb-4">
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star-half-alt fa-1x" style="color: Gold"></i>

                                                            <h6 class="text-bold">Um titulo para o Feedback</h6>
                                                            <p class="text-justify">Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.</p>
                                                        </div>
                                                        <div class="pb-4">
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                            <i class="fas fa-star-half-alt fa-1x" style="color: Gold"></i>

                                                            <h6 class="text-bold">Um titulo para o Feedback</h6>
                                                            <p class="text-justify">Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <p>Um titulo para um feedback</p> - 
                                        <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                        <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                        <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                        <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                        <i class="fas fa-star-half-alt fa-1x" style="color: Gold"></i> -->
                                        <input type="hidden" value="<?=$info->id ?>" name="id_servico" id="id_servico"/>
                                        <input type="hidden" value="<?= $info->id_usuario ?>" id="id_usuario" />
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

<div class="modal fade" id="modal_contratacao">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Contratação</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="submit">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label for="nome">Data para o Serviço</label>
                                <input type="text" class="form-control data" name="data_servico" id="data_servico" placeholder="Data para o serviço" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask autofocus>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="nome">Hora para o Serviço</label>
                                <input type="text" class="form-control data" name="hora_servico" id="hora_servico" placeholder="Hora para o serviço">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="nome">Descrição</label>
                                <textarea class="form-control" name="descricao" rows="3" id="descricao" placeholder="Descrição sobre o Serviço a ser solicitado"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="endereco_cadastrado">
                                <label class="form-check-label" for="exampleCheck1">Usar endereço cadastrado</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="nome">Endereço</label><small>(Sem o número residencial)</small>
                                <input type="text" class="form-control" name="endereco" id="endereco" placeholder="Endereço">
                            </div>     
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id_servico" id="id_servico" value="<?= $info->id ?>" />
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>