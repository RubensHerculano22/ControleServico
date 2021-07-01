<nav class="main-header navbar navbar-expand navbar-dark" style="background-color: <?= $colores->color1 ?>">

    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button" data-enable-remember="true"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

      <div class="input-group input-group-sm ml-auto" style="width: 50%">
        <input class="form-control form-control-navbar" type="search" placeholder="Procure por um Serviço, equipamento..." aria-label="Search" id="input_search_bar">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit" id="button_search_bar">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#modalLocalizacao">
          <i class="fas fa-exchange-alt"></i>
        </a>
      </li>
      <?php if(!isset($dados) || empty($dados)): ?>
        <a href="<?= base_url("Usuario") ?>" class='nav-link dropdown'>Criar conta</a>
        <a href="<?= base_url("Usuario/login") ?>" class='nav-link dropdown'>Autentificar</a>
      <?php else: ?>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <!-- <img src="https://www.microlins.com.br/galeria/repositorio/images/noticias/como-posicionar-melhor-seu-perfil-no-linkedin/02-Como-posicionar-melhor-seu-perfil-do-Linkedin.png" class="user-image img-circle elevation-2" alt="User Image"> -->
          <span class="d-none d-md-inline"><?= $dados->nome." ".$dados->sobrenome ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <li style="background-color: <?= $colores->color1 ?>">
            <div class="text-center pt-3">
              <img src="https://i.pinimg.com/736x/6f/1e/fb/6f1efb3e2f7ddb6f6b9a3dbefabe0c67.jpg" class="img-circle elevation-2" alt="User Image" style="max-width: 75px;">
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12 p-4">
                <p class="text-center">
                  <span style="color: <?= $colores->color5 ?>"><?= $dados->nome." ".$dados->sobrenome ?></span>
                  <br/>
                  <small style="color: <?= $colores->color5 ?>">Membro desde <?= formata_data_info($dados->data_criacao) ?></small>
                </p>
              </div>
            </div>
          </li>
          <li class="user-body">
            <a href="<?= base_url("Usuario/perfil/dados") ?>" class="btn btn-default btn-flat btn-block">Minhas Informações</a>
            <a href="<?= base_url("Usuario/perfil/cadastrado") ?>" class="btn btn-default btn-flat btn-block">Meus Serviços</a>
            <a href="<?= base_url("Usuario/perfil/favoritos") ?>" class="btn btn-default btn-flat btn-block">Lista de favoritos</a>
            <a href="<?= base_url("Usuario/perfil/pedidos") ?>" class="btn btn-default btn-flat btn-block">Serviços contratos</a>
            <a href="<?= base_url("Usuario/logout/$local") ?>" class="btn btn-default btn-flat btn-block">Sair</a>
          </li>
        </ul>
      </li>
      <?php endif; ?>
    </ul>
</nav>

<div class="modal fade" id="modalLocalizacao" <?= empty($cidade) ? 'data-backdrop="static"' : '' ?> style="display: none;" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Região dos Serviços</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <?php if(empty($cidade)): ?>
              <div class="alert alert-dismissible" style="background-color: <?= $colores->color2 ?>; color: <?= $colores->color5 ?>">
                Por favor, selecione uma cidade para filtrar os serviços no sistema.
              </div>
            <?php endif; ?>
          </div>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              <label>Estado</label>
              <select class="form-control select2bs4" id="estado_atual" name="estado_atual">
                  <?php foreach($estados as $item): ?>
                      <option value="<?= $item->id ?>" <?= $cidade && $cidade->id_estado == $item->id ? "selected" : false ?>><?= $item->nome." - ".$item->sigla ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              <label>Cidade</label>
              <select class="form-control select2bs4" id="cidade_atual" name="cidade_atual">
                
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer float-right">
        <button type="button" class="btn" id="troca_cidade" style="background-color: <?= $colores->color2 ?>"><span style="color: <?= $colores->color5 ?>"><?= empty($cidade) ? "Definir Região" : "Trocar Região" ?></span></button>
      </div>
    </div>
  </div>
</div>