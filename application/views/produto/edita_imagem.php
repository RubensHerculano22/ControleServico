<div class="container">
    <div class="row">
        <div class="col-sm-12 col-xs-12 col-xs-12">
            <div class="card">
                <div class="card-header" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">
                    <h3 class="card-title">Formulário de Edição de Imagens do Serviço</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-5">
                            <button type="button" class="btn" data-toggle="modal" data-target="#modalImagem" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Adicionar nova Imagem</button>
                        </div>
                        <?php foreach($imagem as $key => $item): ?>
                            <div class="col-md-4 col-sm-4 col-xs-12 text-center pb-4">
                                <img src="data:<?= $item->tipo_imagem ?>;base64,<?= $item->img ?>" class="img-thumbnail mb-2" alt="<?= $item->nome ?>" title="<?= $item->nome ?>" style="max-height:180px;"/>
                                <div class="form-group">
                                    <input type="checkbox" name="principal_switch" id="principal<?= $key ?>" <?= $item->principal == 1 ? "checked" : "" ?> data-id="<?= $item->principal ?>" data-imagem="<?= $item->id ?>" data-bootstrap-switch data-off-color="danger" data-on-text="Principal" data-on-color="success">
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="ativo_switch" id="ativo<?= $key ?>" <?= $item->ativo == 1 ? "checked" : "" ?> data-id="<?= $item->principal ?>" data-imagem="<?= $item->id ?>" data-bootstrap-switch data-off-color="danger" data-on-text="Ativo" data-on-color="success" data-off-text="Desativado">
                                </div>
                                <button type="button" class="btn btn-outline-secondary" onclick="editaImagem(<?= $item->id ?>)"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-outline-danger" onclick="removeImagem(<?= $item->id ?>)"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url("Servico/gerenciar_servico/".$id) ?>" class="btn" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalImagem" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">
                <h4 class="modal-title" id="titulo_modal">Cadastrar nova Imagem</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="submit">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input arquivo" name="file" id="nova_imagem">
                                    <label class="custom-file-label" for="nova_imagem">Escolha um Arquivo</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 principal_input">
                            <div class="form-group">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" class="custom-control-input" name="principal" id="nova_imagem_principal">
                                    <label class="custom-control-label" for="nova_imagem_principal">Principal</label>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="id_servico" value="<?= $id ?>" name="id_servico" />
                        <input type="hidden" id="id_imagem" value="" name="id_imagem" />
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>