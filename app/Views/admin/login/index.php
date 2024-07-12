<?= $this->extend('admin/template/login'); ?>
<?= $this->Section('content'); ?>

<div class="container">
    <div class="heading"><b>S</b>elamat Datang</div>
    <?= form_open('login/process', ['class' => 'form']); ?>
    <?= csrf_field(); ?>

    <div class="email mb-3">
        <?php 
            $isInvalidUser = session()->getFlashdata('errUsername') ? 'is-invalid' : '';
        ?>
        <input required class="form-control <?= $isInvalidUser ?>" type="text" name="username" id="username" placeholder="Username">
        <?php if (session()->getFlashdata('errUsername')): ?>
            <div class="invalid-feedback">
                <?= session()->getFlashdata('errUsername') ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="password mb-3">
        <?php 
            $isInvalidPassword = session()->getFlashdata('errPassword') ? 'is-invalid' : '';
        ?>
        <input required class="form-control <?= $isInvalidPassword ?>" type="password" name="password" id="password" placeholder="Password">
        <?php if (session()->getFlashdata('errPassword')): ?>
            <div class="invalid-feedback">
                <?= session()->getFlashdata('errPassword') ?>
            </div>
        <?php endif; ?>
    </div>

    <button class="btn btn-dark">Login</button>

    <link rel="stylesheet" href="/asset-user/css/loginstyle.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

    <?= form_close() ?>
</div>


<?= $this->endSection('content'); ?>
