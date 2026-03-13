<?php use App\Services\CsrfService; ?>
<div class="container" style="max-width:420px; margin-top:10vh;">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="mb-3">Acceso al sistema</h3>
            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= e($_SESSION['error']) ?></div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            <form method="post" action="<?= e(url('/login')) ?>">
                <input type="hidden" name="_csrf" value="<?= e(CsrfService::token()) ?>">
                <div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" required></div>
                <div class="mb-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required></div>
                <button class="btn btn-primary w-100">Entrar</button>
            </form>
        </div>
    </div>
</div>
