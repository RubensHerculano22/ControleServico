<div class="container">
    <div class="row">
        <div class="col-sm-12 col-xs-12 col-xs-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Formulário de Cadastro de Serviço</h3>
                </div>
                <form id="submit">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="valor">Nome</label>
                                    <input type="text" class="form-control" name="nome" value="<?= $info->nome ?>" id="nome" placeholder="Nome">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Descrição Curta(Atrativa)</label>
                                    <textarea class="form-control" rows="2" name="descricao_curta" placeholder="Descrição Curta (Atrativa)"><?= $info->descricao_curta ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <label>Categoria Principal</label>
                                    <select class="custom-select" name="categoria_principal" id="categoria_principal">
                                        <?php foreach($categoria as $item): ?>
                                            <option value="<?= $item->id ?>" <?= $item->id == $info->categoria_pai->id ? "selected" : "" ?>><?= $item->nome ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12 categoria_especifica">
                                <div class="form-group">
                                    <label>Categoria Especifica</label>
                                    <select class="custom-select" name="categoria_especifica" id="categoria_especifica">
                                        <?php foreach($lista_subcategoria as $item): ?>
                                            <optgroup label='<?= $item->nome ?>' classe='optremove'>
                                                <?php foreach($item->filhos as $value): ?>
                                                    <option value="<?= $value->id ?>" <?= $value->id == $info->subcategoria->id ? "selected" : "" ?>><?= $value->nome ?></option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="estado">Estado</label>
                                    <select class="form-control select2bs4" id="estado" name="estado">
                                        <?php foreach($estados as $item): ?>
                                            <option value="<?= $item->id ?>" ><?= $item->nome." - ".$item->sigla ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <input type="hidden" value="<?= $info->estado->id ?>" id="id_estado" />
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="cidade">Cidade</label>
                                    <select class="form-control select2bs4" id="cidade" name="cidade" >
                                    <?php foreach($cidade as $item): ?>
                                            <option value="<?= $item->ID ?>" ><?= $item->Nome ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <input type="hidden" value="<?= $info->cidade->ID ?>" id="id_cidade" />
                            </div>
                            <div class="col-md-4 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label for="valor">Valor</label>
                                    <input type="text" class="form-control preco" name="valor" value="<?= $info->valor_D ?>" id="valor" placeholder="Valor">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group tipo_servico">
                                    <label for="valor">Tipo de Serviço</label>
                                    <div class="form-check">
                                        <input class="form-check-input" value="1" type="radio" name="tipo_servico" <?= $info->id_tipo_servico == "1" ? "checked" : "" ?>>
                                        <label class="form-check-label">Prestação de Serviço</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" value="2" type="radio" name="tipo_servico" <?= $info->id_tipo_servico == "2" ? "checked" : "" ?>>
                                        <label class="form-check-label">Aluguel de Equipamento</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-4 col-xs-12 aluguel_equipamento <?= $info->id_tipo_servico == "2" ? "" : "d-none" ?>">
                                <div class="form-group">
                                    <label for="quantidade">Quantidade Disponivel</label>
                                    <input type="number" class="form-control" name="quantidade" value="<?= $info->quantidade_disponivel ?>" id="quantidade" placeholder="Quantidade">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-4 col-xs-12 aluguel_equipamento <?= $info->id_tipo_servico == "2" ? "" : "d-none" ?>">
                                <div class="form-group">
                                    <label for="caucao">Caução</label>
                                    <input type="text" class="form-control preco" name="caucao" value="<?= $info->caucao ?>" id="caucao" placeholder="Caução">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-4 col-sm-12">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="local_servico" name="local" val="1" <?= !empty($info->endereco) ? "checked" : "" ?>>
                                    <label class="form-check-label" for="local_servico">Caso o Serviço seja executado em um local especifico</label>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12 <?= !empty($info->endereco) ? "" : "d-none" ?>" id="endereco_input">
                                <label for="endereco">Endereço</label>
                                <input type="text" class="form-control" name="endereco" value="<?= $info->endereco ?>" id="endereco" placeholder="Endereço"/>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label>Formas de Pagamento</label>
                                            <select class="form-control select2bs4" name="pagamento" id="pagamento" data-placeholder="Formas de Pagamento" style="width: 100%;">
                                                <?php foreach($pagamento as $item): ?>
                                                    <optgroup label="<?= $item->forma_pagamento ?>">
                                                        <?php foreach($item->tipos as $value): ?>
                                                            <option value="<?= $value->id ?>"><?= $value->nome ?></option>
                                                        <?php endforeach; ?>
                                                    </optgroup>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label>Limite de Vezes</label>
                                            <select class="form-control select2bs4" name="vezes" id="vezes" data-placeholder="Quantidade de Vezes" style="width: 100%;">
                                                <option value="1">À vista</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                        </div>               
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group tipo_servico">
                                            <label for="valor">Tipo</label>
                                            <div class="form-check">
                                                <input class="form-check-input" value="1" type="radio" id="juros1" name="juros">
                                                <label class="form-check-label">Com Juros</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" value="2" type="radio" id="juros2" name="juros">
                                                <label class="form-check-label">Sem Juros</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 co-sm-12 col-xs-12 pl-5 pr-5">
                                        <br/>
                                        <button class="btn btn-info btn-block" id="adicionar_meio_pagamento">Adicionar Meio de Pagamento</button>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 pt-4" id="lista_pag">
                                        <ol class="list-group list-group-numbered" id="lista_pagamento">
                                            <?php foreach($info->pagamento as $key => $item): ?>
                                                <li class="list-group-item list_group_pagamento" id="li_meio_<?= $key ?>" data-id="<?= $item->id_tipo_pagamento."/".$item->vezes."/".$item->juros ?>"><?= $item->tipo_pagamento->nome." - ".($item->vezes == "0" ? "à Vista": $item->vezes."x")." ".($item->juros == "0" ? " Com Juros" : "Sem Juros") ?><span class="float-right"><button class="btn btn-danger" type="button" onclick="exclui_meio_pagamento('li_meio_<?= $key ?>')"><i class="fas fa-times"></i></button></span></li>
                                            <?php endforeach; ?>
                                        </ol>
                                    </div>
                                    <input type="hidden" value="" id="lista_pagamento_input" name="lista_tipo_pagamento"/>
                                    <input type="hidden" value="<?= count($info->pagamento) ?>" id="quantidade_meio_pagamento" />
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label>Dia da Semana</label>
                                            <select class="form-control select2bs4" name="dia_semana" id="dia_semana" data-placeholder="Dia da Semana" style="width: 100%;">
                                                <option value="1">Domingo</option>
                                                <option value="2">Segunda-Feira</option>
                                                <option value="3">Terça-Feira</option>
                                                <option value="4">Quarta-Feira</option>
                                                <option value="5">Quinta-Feira</option>
                                                <option value="6">Sexta-Feira</option>
                                                <option value="7">Sabado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="valor">Inicio</label>
                                            <input type="text" class="form-control" name="horario_inicio" id="horario_inicio" placeholder="Inicio do Funcionamento" data-inputmask='"mask": "99:99"' data-mask>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="valor">Final</label>
                                            <input type="text" class="form-control" name="horario_fim" id="horario_fim" placeholder="Final do Funcionamento" data-inputmask='"mask": "99:99"' data-mask>
                                        </div>
                                    </div>
                                    <div class="col-md-12 co-sm-12 col-xs-12 pl-5 pr-5">
                                        <br/>
                                        <button class="btn btn-info btn-block" id="adicionar_horario">Adicionar Horario</button>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 pt-4" id="lista_de_horario">
                                        <ol class="list-group list-group-numbered" id="lista_horario">
                                        </ol>
                                    </div>
                                    <input type="hidden" value="" id="lista_horario_input" name="lista_tipo_horario"/>
                                    <input type="hidden" value="<?= count($info->horario) ?>" id="quantidade_horario" />
                                </div>        
                            </div>
                        </div>
                        <div class="row pt-5">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label for="valor">Descrição Completa do serviço <small>(Serviço que possuem maior descrição com muito recursos visuais costumam ter maior contratação)</small></label>
                                <textarea id="summernote" name="descricao_completa">
                                    <?= $info->descricao ?>
                                </textarea>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-footer justify-content-between">
                        <a href="<?= base_url("Servico/gerenciar_servico/$id") ?>" class="btn btn-info">Voltar</a>
                        <button type="submit" class="btn btn-info ">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>