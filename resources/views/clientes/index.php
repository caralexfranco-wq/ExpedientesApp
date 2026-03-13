<?php use App\Services\CsrfService; ?>
<div class="card mb-4"><div class="card-body">
    <h5>Alta de cliente</h5>
    <form method="post" action="<?= e(url('/clientes')) ?>" class="row g-2">
        <input type="hidden" name="_csrf" value="<?= e(CsrfService::token()) ?>">
        <div class="col-md-4"><input class="form-control" name="nombre" placeholder="Nombre" required></div>
        <div class="col-md-3"><input class="form-control" name="email" type="email" placeholder="Email"></div>
        <div class="col-md-2"><input class="form-control" name="telefono" placeholder="Teléfono"></div>
        <div class="col-md-3"><input class="form-control" name="rfc" placeholder="RFC"></div>
        <div class="col-12"><input class="form-control" name="direccion" placeholder="Dirección"></div>
        <div class="col-12"><button class="btn btn-success">Guardar</button></div>
    </form>
</div></div>
<div class="card"><div class="card-body">
    <table class="table table-striped table-hover"><thead><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>RFC</th></tr></thead><tbody>
        <?php foreach ($clientes as $cliente): ?><tr><td><?= (int)$cliente['id'] ?></td><td><?= e($cliente['nombre']) ?></td><td><?= e($cliente['email']) ?></td><td><?= e($cliente['telefono']) ?></td><td><?= e($cliente['rfc']) ?></td></tr><?php endforeach; ?>
    </tbody></table>
</div></div>
