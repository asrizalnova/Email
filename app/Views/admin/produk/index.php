<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>


<!-- index.php -->

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Surat Keluar</h1>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="<?php echo base_url() . "admin/produk/tambah" ?>" class="btn btn-primary me-md-2"> + Tambah Surat</a>
                <button type="button" class="btn btn-primary me-md-2" data-bs-toggle="modal" data-bs-target="#emailFormModal">Kirim Email kode redeem</button>

            </div>
        </div>
        <div class="tab-content" id="orders-table-tab-content">
            <?php if (session()->has('success')) : ?>
                <div class="alert alert-success">
                    <?= session('success') ?>
                </div>
            <?php endif; ?>
            <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
                <div class="app-card app-card-orders-table shadow-sm mb-5">
                    <div class="app-card-body">
                        <div class="table-responsive">
                            <table class="table app-table-hover mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th class="text-center" valign="middle">ID</th>
                                        <th class="text-center" valign="middle">Nama Instansi</th>
                                        <th class="text-center" valign="middle">Keperluan</th>
                                        <th class="text-center" valign="middle">Surat</th>
                                        <th class="text-center" valign="middle">Status</th>
                                        <th class="text-center" valign="middle">Waktu</th>
                                        <th class="text-center" valign="middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center;">
                                    <?php foreach ($all_data_produk as $tampilProduk) : ?>
                                        <tr>
                                            <td><?= $tampilProduk->id_SK ?></td>
                                            <td><?= $tampilProduk->instansi_ditujukan ?></td>
                                            <td><?= $tampilProduk->keperluan ?></td>
                                            <td>
                                                <a href="<?= base_url() . 'asset-user/images/' . $tampilProduk->surat_keluar ?>" target="_blank"><?= $tampilProduk->surat_keluar ?></a>
                                            </td>
                                            <td><?= $tampilProduk->status ?></td>
                                            <td><?= $tampilProduk->waktu ?></td>
                                            <td valign="middle">
                                                <div class="d-grid gap-2">
                                                <a href="<?= base_url('admin/produk/delete') . '/' . $tampilProduk->id_SK ?>" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $tampilProduk->id_SK ?>">Hapus</a>
                                                    <a href="<?= base_url('admin/produk/edit') . '/' . $tampilProduk->id_SK ?>" class="btn btn-primary">Edit</a>
                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#emailModal<?= $tampilProduk->id_SK ?>">Kirim Email</button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div><!--//table-responsive-->
                    </div><!--//app-card-body-->
                </div><!--//app-card-->
            </div><!--//tab-pane-->
        </div><!--//tab-content-->
    </div><!--//container-fluid-->
</div><!--//app-content-->


<!-- Modal for Email -->
<?php $reversed_data_produk = array_reverse($all_data_produk); ?>
<?php foreach ($reversed_data_produk as $tampilProduk) : ?>
    <div class="modal fade" id="emailModal<?= $tampilProduk->id_SK ?>" tabindex="-1" aria-labelledby="emailModalLabel<?= $tampilProduk->id_SK ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="<?= base_url('admin/produk/email') ?>" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="emailModalLabel<?= $tampilProduk->id_SK ?>">Kirim Email</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_SK" value="<?= $tampilProduk->id_SK ?>">
                        <input type="hidden" name="existing_file" value="<?= $tampilProduk->surat_keluar ?>">
                        <div class="mb-3">
                            <label for="email_tujuan" class="form-label">Email Tujuan</label>
                            <input type="email" class="form-control" id="email_tujuan" name="email_tujuan" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="isi_pesan" class="form-label">Isi Pesan</label>
                            <textarea class="form-control" id="isi_pesan" name="isi_pesan" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="existing_file_display" class="form-label">File yang sudah ada:</label>
                            <p id="existing_file_display"><?= $tampilProduk->surat_keluar ?></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>




<?php foreach ($all_data_produk as $tampilProduk) : ?>
    <!-- Modal Konfirmasi Delete -->
    <div class="modal fade" id="deleteModal<?= $tampilProduk->id_SK ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $tampilProduk->id_SK ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel<?= $tampilProduk->id_SK ?>">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="<?= base_url('admin/produk/delete') . '/' . $tampilProduk->id_SK ?>" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Tombol Hapus -->
<?php endforeach; ?>

<!-- Modal for Email Form -->
<div class="modal fade" id="emailFormModal" tabindex="-1" aria-labelledby="emailFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url('admin/produk/send_email') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="emailFormModalLabel">Kirim Email</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="email_tujuan" class="form-label">Email Tujuan</label>
                        <input type="email" class="form-control" id="email_tujuan" name="email_tujuan" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="isi_pesan" class="form-label">Isi Pesan</label>
                        <textarea class="form-control" id="isi_pesan" name="isi_pesan" rows="3" required></textarea>
                    </div>
                    <input type="hidden" name="existing_file" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>




<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>



<?= $this->endSection('content') ?>