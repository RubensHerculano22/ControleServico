<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-light-navy">
    <!-- Brand Logo -->
    <a href="<?= base_url("Servico") ?>" class="brand-link" style="background-color: <?= $colores->color1 ?>">
      <img src="<?= base_url("assets/img/logo_fundo.jpg") ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light" style="color: <?= $colores->color4 ?>">NEXTOYOU</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= base_url("assets/img/logo_transparent.png") ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div> -->

      <div class="form-inline mt-3">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Procurar" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" class="nav-link cadastro_servico">
              <i class="nav-icon fas fa-tools" style="color: <?= $colores->color1 ?>"></i>
              <p>Cadastrar Serviço</p>
            </a>
          </li>
          
          <?php foreach($categorias as $principal): ?>
            <li class="nav-header"><?= mb_strtoupper ($principal["nome"]) ?></li>
            <?php if($principal["filho"]): ?>
              <?php foreach($principal["filho"] as $filho1): ?>
                <li class="nav-item">
                  <a href="<?= isset($filho1["filho"]) && $filho1["filho"] ? "#" : base_url("Servico/lista/".$principal["nome"].'/'.$filho1["nome"]) ?>" class="nav-link">
                    <?= $filho1["icon"] ? $filho1["icon"] : '<i class="nav-icon fas fa-circle"></i>' ?>
                    <p>
                      <?= $filho1["nome"] ?>
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <?php if($filho1["filho"]) ?>
                  <ul class="nav nav-treeview ml-1">
                    <?php foreach($filho1["filho"] as $filho2): ?>
                      <li class="nav-item">
                        <a href="<?= isset($filho2->filho) && $filho2->filho ? "#" : base_url("Servico/lista/".$filho1["nome"].'/'.$filho2->nome) ?>" class="nav-link">
                        <i class="fas fa-angle-double-right nav-icon"></i>
                          <p>
                            <?= $filho2->nome ?>
                            <?php if(isset($filho2->filho) && $filho2->filho): ?>
                            <i class="right fas fa-angle-left"></i>
                            <?php endif; ?>
                          </p>
                        </a>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                </li>
              <?php endforeach; ?>
            <?php endif; ?>
            </li>
          <?php endforeach; ?>
          <!-- <?php foreach($categorias as $principal): ?>
          <li class="nav-item">
            <a href="<?= $principal["filho"] ? "#" : base_url("Servico/lista/".$principal["nome"]) ?>" class="nav-link">
              <i class="nav-icon fas fa-circle"></i>
              <p>
                <?= $principal["nome"] ?>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <?php if($principal["filho"]): ?>
                <ul class="nav nav-treeview ml-1">
                  <?php foreach($principal["filho"] as $filho1): ?>
                    <li class="nav-item">
                      <a href="<?= isset($filho1["filho"]) && $filho1["filho"] ? "#" : base_url("Servico/lista/".$principal["nome"].'/'.$filho1["nome"]) ?>" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                        <p>
                          <?= $filho1["nome"] ?>
                          <?php if(isset($filho1["filho"]) && $filho1["filho"]): ?>
                          <i class="right fas fa-angle-left"></i>
                          <?php endif; ?>
                        </p>
                      </a>
                      <?php if($filho1["filho"]): ?>
                        <ul class="nav nav-treeview ml-1">
                          <?php foreach($filho1["filho"] as $filho2): ?>
                            <li class="nav-item">
                            <a href="<?= isset($filho2->filho) && $filho2->filho ? "#" : base_url("Servico/lista/".$filho1["nome"].'/'.$filho2->nome) ?>" class="nav-link">
                            <i class="far fa-dot-circle nav-icon"></i>
                              <p>
                                <?= $filho2->nome ?>
                                <?php if(isset($filho2->filho) && $filho2->filho): ?>
                                  <i class="right fas fa-angle-left"></i>
                                <?php endif; ?>
                              </p>
                            </a>
                            </li>
                          <?php endforeach; ?>
                        </ul>
                      <?php endif; ?>
                    </li>
                  <?php endforeach; ?>
                </ul>
            <?php endif; ?>
          </li>
          <?php endforeach; ?> -->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>