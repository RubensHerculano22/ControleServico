<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="card-header" style="background-color: <?= $colores->color2 ?>">
                                <h3 class="card-title" style="color: <?= $colores->color5 ?>">Informações</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-7 col-sm-12">
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
                                    <div class="col-md-5 col-sm-12">
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                            <?php if($info->media_feedback): ?>
                                                <?php for($i=0;$i<intval($info->media_feedback);$i++): ?>
                                                    <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                <?php endfor; ?>
                                                <?php if(($info->media_feedback*2)%2 != 0): ?>
                                                    <i class="fas fa-star-half-alt fa-1x" style="color: Gold"></i>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <small>Sem Classficação de Feedback</small>
                                            <?php endif; ?>
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
                                        <?php if(isset($info->disponibilidade) && $info->disponibilidade == 0): ?>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="alert alert-warning" >
                                                    <h5><i class="icon fas fa-info"></i> Sem Disponibilidade</h5>
                                                    Todos os Equipamentos estão em utilização, quer ser avisado quando estiver disponivel? 
                                                </div>
                                                <button type="button" class="btn btn-block" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>" data-toggle="modal" data-target="#modal_avise_me" >
                                                    <i class="fas fa-clipboard"></i>
                                                    Avise me quando estiver disponivel
                                                </button>
                                            </div>
                                        </div>
                                        <hr>
                                        <?php endif; ?>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <h3 class="my-3"><?= $info->nome ?><span class="h6"><?= " - ".($info->id_tipo_servico == 1 ? "Prestador de Serviço" : "Aluguel de Equipamento" ) ?></span></h3>
                                                <?php if($info->endereco): ?>
                                                    <h6><?= $info->endereco.($info->complemento ? ", ".$info->complemento : "").", ".$info->numero.", ".$info->bairro." - ".$info->cidade->Nome.", ".$info->estado->nome."(".$info->estado->sigla.")" ?></h6>
                                                <?php else: ?>
                                                    <h6><?= $info->cidade->Nome.", ".$info->estado->nome."(".$info->estado->sigla.")" ?></h6>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php if((isset($info->disponibilidade) && $info->disponibilidade == 1) || $info->id_tipo_servico == 1): ?>
                                        <hr>
                                        <div class="row">
                                            <?php if($info->caucao && $info->quantidade_disponivel): ?>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="mt-2">
                                                        <h6><b>Quantidade Disponivel:</b> <?= ($info->quantidade_disponivel - $info->quantidade_contratada) ?></h6>
                                                    </div>    
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="mt-2">
                                                        <h6><b>Caução:</b> <?= "R$: ".$info->caucao ?></h6>
                                                    </div>    
                                                </div>
                                            <?php endif; ?>
                                            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                                <?= $info->valor ? "<h3 class='mb-0'>R$: ".$info->valor."</h3>" : "<h2 class='mb-0'>A Combinar</h2>" ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <hr>
                                        <div class="mt-4">
                                            <h6><b>Horários de Funcionamento:</b></h6>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
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
                                        <?php if((isset($info->disponibilidade) && $info->disponibilidade == 1) || $info->id_tipo_servico == 1): ?>
                                        <div class="mt-4">
                                            <button type="button" id="contratar" class="btn btn-warning btn-block btn-lg" data-toggle="modal" data-target="#modal_contratacao">
                                                <i class="fas fa-handshake"></i>
                                                Contratar
                                            </button>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <!-- 
                                    https://latinoscassinos.com/wp-content/uploads/2019/01/62.png
                                    https://i.pinimg.com/originals/dd/65/f3/dd65f3c6a80e7bb059d3f2630399826b.jpg
                                    https://logospng.org/download/cartao-elo/logo-cartao-elo-colorido-fundo-preto-256.png
                                    https://i2.wp.com/goldlinebrow.com/wp-content/uploads/2018/02/American-Express-icon.png?ssl=1
                                    https://logospng.org/download/hipercard/logo-hipercard-256.png
                                    https://latinoscassinos.com/wp-content/uploads/2019/01/62.png
                                    https://i.pinimg.com/originals/dd/65/f3/dd65f3c6a80e7bb059d3f2630399826b.jpg
                                    https://logospng.org/download/cartao-elo/logo-cartao-elo-colorido-fundo-preto-256.png
                                    https://i2.wp.com/goldlinebrow.com/wp-content/uploads/2018/02/American-Express-icon.png?ssl=1
                                    https://logospng.org/download/hipercard/logo-hipercard-256.png
                                    https://logospng.org/download/itau/logo-itau-256.png
                                    https://logospng.org/download/nubank/logo-nu-nubank-roxo-icon-256.png
                                    https://logospng.org/download/santander/logo-santander-icon-256.png
                                    https://banco.bradesco/favicon.ico
                                    https://logospng.org/download/caixa-economica-federal/logo-caixa-economica-federal-256.png
                                    https://logospng.org/download/mercado-pago/logo-mercado-pago-icone-256.png
                                    https://logospng.org/download/picpay/logo-picpay-256.png
                                    https://cdn.iconscout.com/icon/free/png-256/paypal-5-226456.png
                                    https://logospng.org/download/banco-do-brasil/logo-banco-do-brasil-icon-256.png
                                    https://www.autoimportsweb.com.br/wp-content/uploads/2019/02/ico_boleto.svg
                                -->
                                <div class="row mt-3 mb-3">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                        <h4 class="text-bold" style="color: <?= $colores->color1 ?>">Meios de Pagamento</h4>
                                    </div>
                                    <?php if($info->tipo_pagamento->credito == 1): ?>
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
                                                            <img class="img-fluid mb-2" src="https://latinoscassinos.com/wp-content/uploads/2019/01/62.png" style="max-width: 150px; max-height: 40px;" />
                                                            <span class="text-muted"><?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                        </div> 
                                                    <?php endif; ?>
                                                    <?php if($item->id_tipo_pagamento == 3): ?>
                                                        <div class="col-md-3 col-sm-4">
                                                            <img class="img-fluid mb-2" src="https://latinoscassinos.com/wp-content/uploads/2019/01/62.png" style="max-width: 150px; max-height: 40px;" />
                                                            <span class="text-muted"><?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                        </div>     
                                                    <?php endif; ?>
                                                    <?php if($item->id_tipo_pagamento == 4): ?>
                                                        <div class="col-md-3 col-sm-4">
                                                            <img class="img-fluid mb-2" src="https://latinoscassinos.com/wp-content/uploads/2019/01/62.png" style="max-width: 150px; max-height: 40px;" />
                                                            <span class="text-muted"><?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if($item->id_tipo_pagamento == 5): ?>
                                                        <div class="col-md-3 col-sm-4">
                                                            <img class="img-fluid mb-2" src="https://latinoscassinos.com/wp-content/uploads/2019/01/62.png" style="max-width: 150px; max-height: 40px;" />
                                                            <span class="text-muted"><?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                        </div>    
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($info->tipo_pagamento->debito == 1): ?>
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
                                                            <img class="img-fluid mb-2" src="https://latinoscassinos.com/wp-content/uploads/2019/01/62.png" style="max-width: 150px; max-height: 40px;" />
                                                            <span class="text-muted"><?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if($item->id_tipo_pagamento == 8): ?>
                                                        <div class="col-md-3 col-sm-4">
                                                            <img class="img-fluid mb-2" src="https://latinoscassinos.com/wp-content/uploads/2019/01/62.png" style="max-width: 150px; max-height: 40px;" />
                                                            <span class="text-muted"><?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if($item->id_tipo_pagamento == 9): ?>
                                                        <div class="col-md-3 col-sm-4">
                                                            <img class="img-fluid mb-2" src="https://latinoscassinos.com/wp-content/uploads/2019/01/62.png" style="max-width: 150px; max-height: 40px;" />
                                                            <span class="text-muted"><?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if($item->id_tipo_pagamento == 10): ?>
                                                        <div class="col-md-3 col-sm-4">
                                                            <img class="img-fluid mb-2" src="https://latinoscassinos.com/wp-content/uploads/2019/01/62.png" style="max-width: 150px; max-height: 40px;" />
                                                            <span class="text-muted"><?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($info->tipo_pagamento->transferencia == 1): ?>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h6 class="">Transferência</h6>
                                            <div class="row">
                                                <?php foreach($info->pagamento as $item): ?>
                                                    <?php if($item->id_tipo_pagamento == 11): ?>
                                                        <div class="col-lg-3 col-md-3 col-sm-4">
                                                            <img class="img-fluid mb-2" src="https://latinoscassinos.com/wp-content/uploads/2019/01/62.png" style="max-width: 150px; max-height: 40px;" />
                                                            <span class="text-muted">Itau <?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if($item->id_tipo_pagamento == 12): ?>
                                                        <div class="col-lg-3 col-md-3 col-sm-4">
                                                            <img class="img-fluid mb-2" src="https://latinoscassinos.com/wp-content/uploads/2019/01/62.png" style="max-width: 150px; max-height: 40px;" />
                                                            <span class="text-muted">Nubank <?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if($item->id_tipo_pagamento == 13): ?>
                                                        <div class="col-lg-3 col-md-3 col-sm-4">
                                                            <img class="img-fluid mb-2" src="https://latinoscassinos.com/wp-content/uploads/2019/01/62.png" style="max-width: 150px; max-height: 40px;" />
                                                            <span class="text-muted">Santander <?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if($item->id_tipo_pagamento == 14): ?>
                                                        <div class="col-lg-3 col-md-3 col-sm-4">
                                                            <img class="img-fluid mb-2" src="https://latinoscassinos.com/wp-content/uploads/2019/01/62.png" style="max-width: 150px; max-height: 40px;" />
                                                            <span class="text-muted">Bradesco <?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if($item->id_tipo_pagamento == 15): ?>
                                                        <div class="col-lg-3 col-md-3 col-sm-4">
                                                            <img class="img-fluid mb-2" src="https://latinoscassinos.com/wp-content/uploads/2019/01/62.png" style="max-width: 150px; max-height: 40px;" />
                                                            <span class="text-muted">Caixa <?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if($item->id_tipo_pagamento == 16): ?>
                                                        <div class="col-lg-3 col-md-3 col-sm-4">
                                                            <img class="img-fluid mb-2" src="https://latinoscassinos.com/wp-content/uploads/2019/01/62.png" style="max-width: 150px; max-height: 40px;" />
                                                            <span class="text-muted">Mercado pago <?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if($item->id_tipo_pagamento == 17): ?>
                                                        <div class="col-lg-3 col-md-3 col-sm-4">
                                                            <img class="img-fluid mb-2" src="https://latinoscassinos.com/wp-content/uploads/2019/01/62.png" style="max-width: 150px; max-height: 40px;" />
                                                            <span class="text-muted">PicPay <?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if($item->id_tipo_pagamento == 18): ?>
                                                        <div class="col-lg-3 col-md-3 col-sm-4">
                                                            <img class="img-fluid mb-2" src="https://latinoscassinos.com/wp-content/uploads/2019/01/62.png" style="max-width: 150px; max-height: 40px;" />
                                                            <span class="text-muted">PayPal <?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if($item->id_tipo_pagamento == 19): ?>
                                                        <div class="col-lg-3  col-md-3 col-sm-4">
                                                            <img class="img-fluid mb-2" src="https://latinoscassinos.com/wp-content/uploads/2019/01/62.png" style="max-width: 150px; max-height: 40px;" />
                                                            <span class="text-muted">Banco do Brasil <?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($info->tipo_pagamento->boleto == 1): ?>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h6>Outros Meios</h6>
                                            <div class="row">
                                                <?php foreach($info->pagamento as $item): ?>
                                                    <?php if($item->id_tipo_pagamento == 20): ?>
                                                        <div class="col-md-2 col-sm-4">
                                                            <img class="img-fluid mb-2" src="https://latinoscassinos.com/wp-content/uploads/2019/01/62.png" style="max-width: 150px; max-height: 40px;" />
                                                            <span class="text-muted">Boleto <?= ($item->vezes != 1 ? $item->vezes."x" : "à vista").($item->juros == 1 ? " com juros" : " sem juros") ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="row mt-3 mb-3">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                        <h4 class="text-bold" style="color: <?= $colores->color1 ?>">Descrição</h4>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <?= $info->descricao ?>
                                    </div>
                                </div>
                                <div class="row mt-3 mb-3">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                        <h4 class="text-bold" style="color: <?= $colores->color1 ?>">Duvidas</h4>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <h5 class="text-bold">Pergunte ao Prestador</h5>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="pergunta" placeholder="Digite aqui!">
                                                    <span class="input-group-append">
                                                        <button type="button" id="perguntar" class="btn" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Perguntar!</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row pt-5">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <h5 class="text-bold">Ultimas Realizadas</h5>
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
                                                        <div class="alert mensagem_pergunta" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">
                                                            <p>Este Serviço ainda não possui perguntas. Seja o primeiro a realizar.</p>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3 mb-3">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                        <h4 class="text-bold" style="color: <?= $colores->color1 ?>">Opiniões sobre o serviço</h4>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="row text-center">
                                            <div class="col-md-4 col-sm-3 col-xs-12 text-right">
                                                <h1><?= $info->media_feedback ?></h1>
                                                <?php if($info->media_feedback): ?>
                                                    <?php for($i=0;$i<intval($info->media_feedback);$i++): ?>
                                                        <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                    <?php endfor; ?>
                                                    <?php if(($info->media_feedback*2)%2 != 0): ?>
                                                        <i class="fas fa-star-half-alt fa-1x" style="color: Gold"></i>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <small>Sem Classficação de Feedback</small>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-md-6 col-sm-9 col-xs-12">
                                                <table class="table table-borderless table-sm">
                                                    <?php for($i=5;$i>0;$i--): ?>
                                                    <tr>
                                                        <td width="26%"><?= $i ?> Estrelas</td>
                                                        <td width="70%">
                                                            <div class="progress progress-sm">
                                                                <?php if($info->estrelas_feedback[0] > 0): ?>
                                                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: <?= ($info->estrelas_feedback[$i]/$info->estrelas_feedback[0])*100 ?>%">
                                                                <?php else: ?>
                                                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                                <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?= $info->estrelas_feedback[$i] ?>
                                                        </td>
                                                    </tr>
                                                    <?php endfor; ?>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="row">
                                                    <div class="col-lg-2 col-md-3 col-sm-3 col">
                                                        <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                                            <a class="nav-link active" id="vert-tabs-todos-tab" style="color: <?= $colores->color2 ?>" data-toggle="pill" href="#vert-tabs-todos" role="tab" aria-controls="vert-tabs-todos" aria-selected="true">Todos</a>
                                                            <a class="nav-link" id="vert-tabs-positivos-tab" style="color: <?= $colores->color2 ?>" data-toggle="pill" href="#vert-tabs-positivos" role="tab" aria-controls="vert-tabs-positivos" aria-selected="false">Positivas</a>
                                                            <a class="nav-link" id="vert-tabs-negativos-tab" style="color: <?= $colores->color2 ?>" data-toggle="pill" href="#vert-tabs-negativos" role="tab" aria-controls="vert-tabs-negativos" aria-selected="false">Negativas</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-10 col-md-9 col-sm-9 col">
                                                        <div class="tab-content" id="vert-tabs-tabContent">
                                                            <div class="tab-pane text-left fade show active" id="vert-tabs-todos" role="tabpanel" aria-labelledby="vert-tabs-todos-tab">
                                                                <?php foreach($info->feedback as $item): ?>
                                                                <div class="pb-4">
                                                                    <div class="row">
                                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                                            <h6 class="text-bold"><?= $item[1]->titulo ?></h6>
                                                                        </div>
                                                                        <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                                                                            <h6 ><b><?= $item[0]->nome." ".$item[0]->sobrenome ?></b> -  <?= $item[1]->data_br ?></h6>
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                                        <?php for($i=0;$i<(intval ($item[1]->quantidade_estrelas/2));$i++): ?>
                                                                            <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                                        <?php endfor; ?>
                                                                        <?php if(($item[1]->quantidade_estrelas)%2 != 0): ?>
                                                                            <i class="fas fa-star-half-alt fa-1x" style="color: Gold"></i>
                                                                        <?php endif; ?>
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                                            <p class="text-justify"><?= $item[1]->descricao ?></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                            <div class="tab-pane fade" id="vert-tabs-positivos" role="tabpanel" aria-labelledby="vert-tabs-positivos-tab">
                                                                <?php foreach($info->feedback as $item): ?>
                                                                    <?php if($item[1]->quantidade_estrelas >=5 ): ?>
                                                                        <div class="pb-4">
                                                                            <div class="row">
                                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                    <h6 class="text-bold"><?= $item[1]->titulo ?></h6>
                                                                                </div>
                                                                                <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                                                                                    <h6 ><b><?= $item[0]->nome." ".$item[0]->sobrenome ?></b> -  <?= $item[1]->data_br ?></h6>
                                                                                </div>
                                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                                <?php for($i=0;$i<(intval ($item[1]->quantidade_estrelas/2));$i++): ?>
                                                                                    <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                                                <?php endfor; ?>
                                                                                <?php if(($item[1]->quantidade_estrelas)%2 != 0): ?>
                                                                                    <i class="fas fa-star-half-alt fa-1x" style="color: Gold"></i>
                                                                                <?php endif; ?>
                                                                                </div>
                                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                                    <p class="text-justify"><?= $item[1]->descricao ?></p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </div>
                                                            <div class="tab-pane fade" id="vert-tabs-negativos" role="tabpanel" aria-labelledby="vert-tabs-negativos-tab">
                                                                <?php foreach($info->feedback as $item): ?>
                                                                    <?php if($item[1]->quantidade_estrelas < 5 ): ?>
                                                                        <div class="pb-4">
                                                                            <div class="row">
                                                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                    <h6 class="text-bold"><?= $item[1]->titulo ?></h6>
                                                                                </div>
                                                                                <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                                                                                    <h6 ><b><?= $item[0]->nome." ".$item[0]->sobrenome ?></b> -  <?= $item[1]->data_br ?></h6>
                                                                                </div>
                                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                                <?php for($i=0;$i<(intval ($item[1]->quantidade_estrelas/2));$i++): ?>
                                                                                    <i class="fas fa-star fa-1x" style="color: Gold"></i>
                                                                                <?php endfor; ?>
                                                                                <?php if(($item[1]->quantidade_estrelas)%2 != 0): ?>
                                                                                    <i class="fas fa-star-half-alt fa-1x" style="color: Gold"></i>
                                                                                <?php endif; ?>
                                                                                </div>
                                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                                    <p class="text-justify"><?= $item[1]->descricao ?></p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
    </div>
</div>

<div class="modal fade" id="modal_contratacao">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">
                <h4 class="modal-title">Contratação</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="submit">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-3 col-xs-12">
                            <div class="form-group">
                                <label for="nome">Data para o Serviço</label>
                                <input type="text" class="form-control data" name="data_servico" id="data_servico" placeholder="Data para o serviço">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="nome">Hora para o Serviço</label>
                                <select class="form-control select2bs4" name="horario_servico" id="horario_servico" data-placeholder="Horario do Serviço">
                                </select>
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
                                <input type="checkbox" class="form-check-input" name="endereco_cadastrado" id="endereco_cadastrado">
                                <label class="form-check-label" for="exampleCheck1">Usar um endereço diferente</label>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 endereco_cadastro">
                            <div class="form-group">
                                <label for="nome">Endereço</label><small></small>
                                <select class="form-control select2bs4" name="endereco_select" id="endereco" data-placeholder="Endereço">
                                    <?php foreach($endereco as $item): ?>
                                        <option value="<?= $item->endereco_completo ?>"><?= $item->endereco_completo ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>     
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12 d-none local_especifico">
                            <div class="form-group">
                                <label for="endereco">CEP</label><small class="text-danger"> *</small>
                                <input type="text" class="form-control endereco_input" name="cep" id="cep" value="" placeholder="CEP">
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12 d-none local_especifico">
                            <div class="bloc_pesquisa">
                                <br/>
                                <button type="button" class="btn mt-2" onclick="pesquisa_cep()" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>"><i class="fas fa-search-location"></i> Pesquisar</button>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 d-none local_especifico">
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <input type="text" class="form-control endereco_input" id="estado_input" name="estado" value="" placeholder="Estado" readonly>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 d-none local_especifico">
                            <div class="form-group">
                                <label for="cidade">Cidade</label>
                                <input type="text" class="form-control" id="cidade_input" value="" name="cidade" placeholder="Cidade" readonly>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 d-none local_especifico">
                            <div class="form-group">
                                <label for="bairro">Bairro</label>
                                <input type="text" class="form-control" id="bairro_input" value="" name="bairro" placeholder="Bairro" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 d-none local_especifico">
                            <div class="form-group">
                                <label for="endereco">Endereço</label>
                                <input type="text" class="form-control" id="endereco_input" value="" name="endereco" placeholder="Endereço" readonly>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12 d-none local_especifico">
                            <div class="form-group">
                                <label for="numero">Numero</label><small class="text-danger"> *</small>
                                <input type="number" class="form-control endereco_input" id="numero_input" value="" name="numero" placeholder="Numero">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 d-none local_especifico">
                            <div class="form-group">
                                <label for="complemento">Complemento</label>
                                <input type="text" class="form-control" id="complemento_input" value="" name="complemento" placeholder="Complemento">
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id_servico" id="id_servico" value="<?= $info->id ?>" />
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_avise_me">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">
                <h4 class="modal-title">Avise me quando estiver disponivel</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="submit_avise_me">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="nome">Email para aviso</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="E-mail para aviso" autofocus>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id_servico" id="id_servico" value="<?= $info->id ?>" />
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>