<div class="row g-3">
    <?php foreach (['activos'=>'Expedientes activos','cerrados'=>'Expedientes cerrados','verdes'=>'Expedientes verdes','amarillos'=>'Expedientes amarillos','rojos'=>'Expedientes rojos'] as $k => $label): ?>
        <div class="col-md-4 col-xl-2">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <div class="h3"><?= (int)($stats[$k] ?? 0) ?></div>
                    <small><?= e($label) ?></small>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
