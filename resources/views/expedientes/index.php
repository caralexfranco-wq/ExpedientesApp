<div class="d-flex justify-content-between mb-3"><h5>Listado de expedientes</h5><a class="btn btn-primary" href="/expedientes/create">Alta</a></div>
<div class="card"><div class="card-body">
<table class="table table-sm table-hover"><thead><tr><th>Folio</th><th>Número</th><th>Cliente</th><th>Abogado</th><th>Materia</th><th>Vencimiento</th><th>Días</th><th>Semáforo</th></tr></thead><tbody>
<?php foreach ($expedientes as $e): ?>
<tr>
    <td><?= e($e['folio']) ?></td><td><?= e($e['numero_expediente']) ?></td><td><?= e($e['cliente']) ?></td><td><?= e($e['abogado']) ?></td><td><?= e($e['materia']) ?></td><td><?= e($e['fecha_vencimiento']) ?></td><td><?= (int)$e['dias_restantes'] ?></td>
    <td><span class="badge semaforo-<?= strtolower($e['semaforo']) ?>"><?= e($e['semaforo']) ?></span></td>
</tr>
<?php endforeach; ?>
</tbody></table>
</div></div>
