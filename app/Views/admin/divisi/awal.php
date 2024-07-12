<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1>Divisi</h1>
            </div>
        </div>
        <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle me-md-2" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Lihat Divisi
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <?php if (session()-> idlevel == 1 || session()->idlevel == 4) :?>
                    <li><a class="dropdown-item" href="<?php echo base_url() . "admin/divisi/index" ?>">Divisi Marketing</a></li>
                <?php endif;?>
                <?php if (session()-> idlevel == 1 || session()->idlevel == 5) :?>
                    <li><a class="dropdown-item" href="<?php echo base_url() . "admin/divisi/divisi02" ?>">Divisi Human Resource</a></li>
                <?php endif;?>
                <?php if (session()-> idlevel == 1 || session()->idlevel == 6) :?>
                    <li><a class="dropdown-item" href="<?php echo base_url() . "admin/divisi/divisi03" ?>">Divisi Umum</a></li>
                <?php endif;?>
                    <!-- Jika Anda memiliki opsi lain untuk ditampilkan dalam dropdown, Anda bisa menambahkan elemen <li> tambahan di sini -->
                </ul>
            </div>
    </div>
</div>

<?= $this->endSection(); ?>
