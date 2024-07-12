<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Divisi Umum</h1>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="<?php echo base_url() . "admin/divisi/pengajuan" ?>" class="btn btn-primary me-md-2">status pengajuan</a>
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
        <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
                <div class="app-card app-card-orders-table shadow-sm mb-5">
                    <div class="app-card-body">
                        <div class="table-responsive">
                            <table class="table app-table-hover mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th class="text-center" valign="middle">No</th>
                                        <th class="text-center" valign="middle">Nama Instansi</th>
                                        <th class="text-center" valign="middle">Keperluan</th>
                                        <th class="text-center" valign="middle">Surat</th>
                                        <th class="text-center" valign="middle">Status</th>
                                        <th class="text-center" valign="middle">Waktu</th>
                                    </tr>
                                </thead>

                                <tbody style="text-align: center;">
                                    <?php foreach ( $all_data_divisi_tiga as $tampilProduk) : ?>
                                            <td><?= $tampilProduk->id_divisi03 ?></td>
                                            <td><?= $tampilProduk->instansi_pengirim ?></td>
                                            <td><?= $tampilProduk->keperluan ?></td>
                                            <td>
                                                <a href="<?= base_url() . 'asset-user/images/' . $tampilProduk->surat ?>" target="_blank"><?= $tampilProduk->surat ?></a>
                                            </td>
                                            <td><?= $tampilProduk->status ?></td>
                                            <td><?= $tampilProduk->waktu ?></td>
                                          
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div><!--//table-responsive-->
                    </div><!--//app-card-body-->
                </div><!--//app-card-->
            </div><!--//tab-pane-->

        <div class="tab-content" id="orders-table-tab-content">
            <?php if (session()->has('success')) : ?>
                <div class="alert alert-success">
                    <?= session('success') ?>
                </div>
            <?php endif; ?>
            <div id="divisi-list"></div>
        </div>
    </div>
</div>

<?= $this->endSection('content') ?>


