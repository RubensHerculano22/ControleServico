<!DOCTYPE html>
<html>

<head>
    <?= $header ?>
</head>

<body class="layout-fixed">

    <?= $navbar ?>

    <div class="content-wrapper">
        <?php if(isset($breadcrumb) AND $breadcrumb): ?>
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h1 class="m-0"><?= $breadcrumb->titulo ?></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <?php foreach($breadcrumb->before as $item): ?>
                                    <li class="breadcrumb-item"><a href="<?= base_url($item->link) ?>"><?= $item->nome ?></a></li>
                                <?php endforeach; ?>
                                <li class="breadcrumb-item active"><?= $breadcrumb->current ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Main content -->
        <section class="content">
            <?= $content ?>
        </section>
        <!-- /.content -->
    </div>
    <footer class="main-footer">
        <strong>Copyright &copy; 2020 <a href="https://adminlte.io">Nome do Site</a>.</strong> Todos os direitos reservados.
    </footer>
    <?= $footer ?>
    <?php if(isset($javascript) && !empty($javascript)): ?>
        <?php foreach($javascript as $js): ?>
            <script src="<?= $js . "?v=" . time() ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>

</html>
