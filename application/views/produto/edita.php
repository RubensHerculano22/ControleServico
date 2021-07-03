<div class="container">
    <div class="row">
        <div class="col-sm-12 col-xs-12 col-xs-12">
            <div class="card card-default">
                <div class="card-header" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">
                    <h3 class="card-title">Formulário de Edição de Serviço</h3>
                </div>
                <form id="submit">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <small class="text-danger">* Obrigatorios</small><br/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="valor">Nome</label><small class="text-danger"> *</small>
                                    <input type="text" class="form-control" name="nome" value="<?= $info->nome ?>" id="nome" placeholder="Nome">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Descrição Curta(Atrativa)</label><small class="text-danger"> *</small>
                                    <textarea class="form-control" rows="2" id="descricao_curta" name="descricao_curta" placeholder="Descrição Curta (Atrativa)"><?= $info->descricao_curta ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label>Categoria Principal</label><small class="text-danger"> *</small>
                                    <select class="custom-select" name="categoria_principal" id="categoria_principal">
                                        <?php foreach($categoria as $item): ?>
                                            <option value="<?= $item->id ?>" <?= $item->id == $info->categoria_pai->id ? "selected" : "" ?>><?= $item->nome ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-5 col-xs-12 categoria_especifica">
                                <div class="form-group">
                                    <label>Categoria Especifica</label><small class="text-danger"> *</small>
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
                            <div class="col-md-4 col-sm-3 col-xs-12">
                                <div class="form-group">
                                    <label for="valor">Valor</label>
                                    <input type="text" class="form-control preco" name="valor" value="<?= !empty($info->valor_D) ? $info->valor_D : "" ?>" id="valor" placeholder="Valor">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group tipo_servico">
                                    <label for="valor">Tipo de Serviço</label><small class="text-danger"> *</small>
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
                            <div class="col-md-4 col-sm-4 col-xs-12 aluguel_equipamento <?= $info->id_tipo_servico == "2" ? "" : "d-none" ?>">
                                <div class="form-group">
                                    <label for="quantidade">Quantidade Disponivel</label><small class="text-danger"> *</small>
                                    <input type="number" class="form-control" name="quantidade" value="<?= @$info->quantidade_disponivel ?>" id="quantidade" placeholder="Quantidade">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 aluguel_equipamento <?= $info->id_tipo_servico == "2" ? "" : "d-none" ?>">
                                <div class="form-group">
                                    <label for="caucao">Caução</label>
                                    <input type="text" class="form-control preco" name="caucao" value="<?= @$info->caucao_D ?>" id="caucao" placeholder="Caução"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-sm-12 mb-2">
                                <label>Possui estabelecimento local?</label>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="local_servico" name="local" val="1" <?= !empty($info->cep) ? "checked" : "" ?>>
                                    <label class="form-check-label" for="local_servico">Sim</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12 area_servico <?= !empty($info->cep) ? "d-none" : "" ?>">
                                <div class="form-group">
                                    <label for="estado">Estado</label><small class="text-danger"> *</small>
                                    <select class="form-control select2bs4" id="estado" name="estado_select">
                                        <?php foreach($estados as $item): ?>
                                            <option value="<?= $item->id ?>" ><?= $item->nome." - ".$item->sigla ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="hidden" value="<?= $info->estado->id ?>" id="id_estado" />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12 area_servico <?= !empty($info->cep) ? "d-none" : "" ?>">
                                <div class="form-group">
                                    <label for="estado">Cidade</label><small class="text-danger"> *</small>
                                    <select class="form-control select2bs4" id="cidade" name="cidade_select">
                                        <?php foreach($cidade as $item): ?>
                                            <option class="option_cidades" value="<?= $item->ID ?>"><?= $item->Nome ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="hidden" value="<?= $info->cidade->ID ?>" id="id_cidade" />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12 local_especifico <?= empty($info->cep) ? "d-none" : "" ?>">
                                <div class="form-group">
                                    <label for="endereco">CEP</label><small class="text-danger"> *</small>
                                    <input type="text" class="form-control endereco_input" name="cep" id="cep" value="<?= $info->cep ?>" placeholder="CEP">
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-9 col-xs-12 local_especifico <?= empty($info->cep) ? "d-none" : "" ?>">
                                <div class="bloc_pesquisa">
                                    <br/>
                                    <button type="button" class="btn mt-2" onclick="pesquisa_cep()" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>"><i class="fas fa-search-location"></i> Pesquisar</button>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 local_especifico <?= empty($info->cep) ? "d-none" : "" ?>">
                                <div class="form-group">
                                    <label for="estado">Estado</label>
                                    <input type="text" class="form-control endereco_input" id="estado_input" name="estado" value="<?= (!empty($info->cep) ? $info->estado->nome : "") ?>" placeholder="Estado" readonly>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 local_especifico <?= empty($info->cep) ? "d-none" : "" ?>">
                                <div class="form-group">
                                    <label for="cidade">Cidade</label>
                                    <input type="text" class="form-control" id="cidade_input" value="<?= (!empty($info->cep) ? $info->cidade->Nome : "") ?>" name="cidade" placeholder="Cidade" readonly>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 local_especifico <?= empty($info->cep) ? "d-none" : "" ?>">
                                <div class="form-group">
                                    <label for="bairro">Bairro</label>
                                    <input type="text" class="form-control" id="bairro_input" value="<?= $info->bairro ?>" name="bairro" placeholder="Bairro" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 local_especifico <?= empty($info->cep) ? "d-none" : "" ?>">
                                <div class="form-group">
                                    <label for="endereco">Endereço</label>
                                    <input type="text" class="form-control" id="endereco_input" value="<?= $info->endereco ?>" name="endereco" placeholder="Endereço" readonly>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12 local_especifico <?= empty($info->cep) ? "d-none" : "" ?>">
                                <div class="form-group">
                                    <label for="numero">Numero</label><small class="text-danger"> *</small>
                                    <input type="number" class="form-control endereco_input" id="numero_input" value="<?= $info->numero ?>" name="numero" placeholder="Numero">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 local_especifico <?= empty($info->cep) ? "d-none" : "" ?>">
                                <div class="form-group">
                                    <label for="complemento">Complemento</label>
                                    <input type="text" class="form-control" id="complemento_input" value="<?= $info->complemento ?>" name="complemento" placeholder="Complemento">
                                </div>
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
                                                <option value="2">2x vezes</option>
                                                <option value="3">3x vezes</option>
                                                <option value="4">4x vezes</option>
                                                <option value="5">5x vezes</option>
                                                <option value="6">6x vezes</option>
                                                <option value="7">7x vezes</option>
                                                <option value="8">8x vezes</option>
                                                <option value="9">9x vezes</option>
                                                <option value="10">10x vezes</option>
                                                <option value="11">11x vezes</option>
                                                <option value="12">12x vezes</option>
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
                                        <button class="btn btn-block" id="adicionar_meio_pagamento" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Adicionar Meio de Pagamento</button>
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
                                            <select class="form-control select2bs4" name="horario_inicio" id="horario_inicio" data-placeholder="Inicio do Funcionamento">
                                                <?php foreach($horarios as $item): ?>
                                                    <option value="<?= $item->horario ?>"><?= $item->horario ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="valor">Final</label>
                                            <select class="form-control select2bs4" name="horario_fim" id="horario_fim" data-placeholder="Final do Funcionamento">
                                                <?php foreach($horarios as $item): ?>
                                                    <option value="<?= $item->horario ?>"><?= $item->horario ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 co-sm-12 col-xs-12 pl-5 pr-5">
                                        <br/>
                                        <button class="btn btn-block" id="adicionar_horario" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Adicionar Horario</button>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 pt-4" id="lista_de_horario">
                                        <ol class="list-group list-group-numbered" id="lista_horario">
                                            <?php foreach($info->horario as $key => $item): ?>
                                                <li class="list-group-item list_group_horario" id="li_horario_<?= $key ?>" data-id="<?= $item->dia_semana->id."/".explode(" ", $item->texto)[0]."/".explode(" ", $item->texto)[2] ?>"><?= $item->dia_semana->titulo." / ".explode(" ", $item->texto)[0]." - ".explode(" ", $item->texto)[2] ?><span class="float-right"><button class="btn btn-danger" type="button" onclick="exclui_meio_pagamento('li_horario_<?= $key ?>')"><i class="fas fa-times"></i></button></span></li>
                                            <?php endforeach; ?>
                                        </ol>
                                    </div>
                                    <input type="hidden" value="" id="lista_horario_input" name="lista_tipo_horario"/>
                                    <input type="hidden" value="<?= count($info->horario) ?>" id="quantidade_horario" />
                                </div>        
                            </div>
                        </div>
                        <div class="row pt-5">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label for="valor">Descrição Completa do serviço <small>(Serviço que possuem maior descrição com muito recursos visuais costumam ter maior contratação)</small></label><small class="text-danger"> *</small>
                                <textarea id="summernote" name="descricao_completa">
                                    <?= $info->descricao ?>
                                </textarea>
                            </div>
                        </div>
                        <input type="hidden" name="id_servico" value="<?= $info->id ?>" id="id_servico" />
                    </div>
                    <div class="card-footer justify-content-between">
                        <a href="<?= base_url("Servico/gerenciar_servico/$id") ?>" class="btn float-left" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Voltar</a>
                        <button type="submit" class="btn float-right" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>