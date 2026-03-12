<div class="d-flex gap-2 mb-3">
    <a class="btn btn-success" href="/reportes/export?format=excel">Exportar Excel</a>
    <a class="btn btn-primary" href="/reportes/export?format=word">Exportar Word</a>
    <a class="btn btn-warning" href="/reportes/export?format=ppt">Exportar PowerPoint</a>
</div>
<div class="card"><div class="card-body">
<table class="table table-striped"><thead><tr><th>Folio</th><th>Cliente</th><th>Abogado</th><th>Semáforo</th><th>Vencimiento</th></tr></thead><tbody>
<?php foreach ($rows as $row): ?><tr><td><?= e($row['folio']) ?></td><td><?= e($row['cliente']) ?></td><td><?= e($row['abogado']) ?></td><td><?= e($row['semaforo']) ?></td><td><?= e($row['fecha_vencimiento']) ?></td></tr><?php endforeach; ?>
</tbody></table>
</div></div>
