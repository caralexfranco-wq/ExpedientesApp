<?php use App\Services\CsrfService; ?>
<div class="card"><div class="card-body">
<form method="post" action="<?= e(url('/expedientes')) ?>" class="row g-3">
    <input type="hidden" name="_csrf" value="<?= e(CsrfService::token()) ?>">
    <div class="col-md-3"><label class="form-label">Número de expediente</label><input class="form-control" name="numero_expediente" required></div>
    <div class="col-md-3"><label class="form-label">Cliente</label><select class="form-select" name="cliente_id"><?php foreach ($clientes as $c): ?><option value="<?= (int)$c['id'] ?>"><?= e($c['nombre']) ?></option><?php endforeach; ?></select></div>
    <div class="col-md-3"><label class="form-label">Abogado responsable</label><select class="form-select" name="abogado_responsable_id"><?php foreach ($abogados as $a): ?><option value="<?= (int)$a['id'] ?>"><?= e($a['nombre']) ?></option><?php endforeach; ?></select></div>
    <div class="col-md-3"><label class="form-label">Tipo asunto</label><input class="form-control" name="tipo_asunto" required></div>
    <div class="col-md-3"><label class="form-label">Materia</label><select class="form-select" name="materia"><?php foreach ($materias as $m): ?><option><?= e($m) ?></option><?php endforeach; ?></select></div>
    <div class="col-md-3"><label class="form-label">Autoridad</label><input class="form-control" name="autoridad" required></div>
    <div class="col-md-3"><label class="form-label">Fecha inicio</label><input class="form-control" type="date" name="fecha_inicio" required></div>
    <div class="col-md-3"><label class="form-label">Fecha vencimiento</label><input class="form-control" type="date" name="fecha_vencimiento" required></div>
    <div class="col-md-3"><label class="form-label">% avance</label><input class="form-control" type="number" name="porcentaje_avance" min="0" max="100" value="0"></div>
    <div class="col-md-3 form-check mt-4"><input class="form-check-input" type="checkbox" name="requiere_convenio" id="conv"><label class="form-check-label" for="conv">Requiere convenio</label></div>
    <div class="col-md-3 form-check mt-4"><input class="form-check-input" type="checkbox" name="requiere_amparo" id="amp"><label class="form-check-label" for="amp">Requiere amparo</label></div>
    <div class="col-12"><textarea class="form-control" name="descripcion" placeholder="Descripción"></textarea></div>
    <div class="col-12"><textarea class="form-control" name="notas" placeholder="Notas"></textarea></div>
    <div class="col-12"><button class="btn btn-success btn-lg">Guardar expediente</button></div>
</form>
</div></div>
