<?php $currentPage = 'dashboard'; ?>
<h1>Dashboard</h1>
<p>Welcome, <?= \App\Core\Session::get('user_name') ?>!</p>
<p>Your role: <?= \App\Core\Session::get('user_role') ?></p>

<div class="mt-4">
    <a href="/logout" class="btn btn-danger">
        <i class="fas fa-sign-out-alt me-2"></i>Logout
    </a>
</div>

<div class="mt-4">
    <a href="/logout" class="btn btn-danger">
        <i class="fas fa-sign-out-alt me-2"></i>Logout
    </a>
</div>