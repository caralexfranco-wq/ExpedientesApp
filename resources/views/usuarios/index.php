<?php use App\Services\CsrfService; ?>
<div class="card mb-4"><div class="card-body">
    <h5>Alta de usuario</h5>
    <form method="post" action="/usuarios" class="row g-2">
        <input type="hidden" name="_csrf" value="<?= e(CsrfService::token()) ?>">
        <div class="col-md-3"><input class="form-control" name="nombre" placeholder="Nombre" required></div>
        <div class="col-md-3"><input class="form-control" name="email" type="email" placeholder="Email" required></div>
        <div class="col-md-2"><input class="form-control" name="telefono" placeholder="Teléfono"></div>
        <div class="col-md-2"><select class="form-select" name="rol_id"><option value="1">ADMINISTRADOR</option><option value="2">CAPTURISTA</option><option value="3">CONSULTOR</option></select></div>
        <div class="col-md-2"><input class="form-control" name="password" type="password" placeholder="Password" required></div>
        <div class="col-12"><button class="btn btn-success">Guardar</button></div>
    </form>
</div></div>
<div class="card"><div class="card-body">
    <table class="table table-bordered"><thead><tr><th>Nombre</th><th>Email</th><th>Rol</th></tr></thead><tbody>
    <?php foreach ($usuarios as $u): ?><tr><td><?= e($u['nombre']) ?></td><td><?= e($u['email']) ?></td><td><?= e($u['rol']) ?></td></tr><?php endforeach; ?>
    </tbody></table>
</div></div>
