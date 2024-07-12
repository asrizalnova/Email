<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Tambahkan Surat</h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="app-card app-card-settings shadow-sm p-4">
                <div class="card-body">
                    
                    <?php if (!empty(session()->getFlashdata('error'))) : ?>
                        <div class="alert alert-danger" role="alert">
                            <h4>Error</h4>
                            <p><?php echo session()->getFlashdata('error'); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    
                    <form action="<?= base_url('admin/slider/proses_tambah') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                      
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Nama Instansi Asal<br><span class="custom-color custom-label">nama instansi asal hanya boleh mengandung huruf dan angka</span></label>
                                    <input type="text" class="form-control" id="nama_produk_in" name="nama_produk_in" value="<?= old('nama_produk_in') ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Perihal<br><span class="custom-color custom-label">nama perihal hanya boleh mengandung huruf dan angka</span></label>
                                    <input type="text" class="form-control" id="nama_produk_en" name="nama_produk_en" value="<?= old('nama_produk_en') ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Saran/Komentar<br><span class="custom-color custom-label">nama perihal hanya boleh mengandung huruf dan angka</span></label>
                                    <input type="text" class="form-control" id="komentar" name="komentar" value="<?= old('komentar') ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">File Surat</label>
                                    <input class="form-control <?= ($validation->hasError('surat')) ? 'is-invalid' : '' ?>" type="file" id="surat" name="surat">
                                    <?= $validation->getError('surat') ?>
                                </div>
                                <p>*File maksimal berukuran 2 Mb</p>
                                <p>*File harus berekstensi pdf/docx</p>
                                <div class="mb-3" style="display: none;">
                                    <label class="form-label">Status <br><span class="custom-color custom-label">Status surat</span></label>
                                    <input type="text" class="form-control" id="status" name="status" value="Telah Dikirim" readonly>
                                </div>

                                <!-- Tambahan: Input untuk menampilkan kode redeem -->
                                <div class="mb-3">
                                    <label class="form-label">Kode Redeem</label>
                                    <input type="text" class="form-control" id="redeem_code" name="redeem_code" value="<?= $redeem_code ?? '' ?>" readonly>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                            <div class="col">
                                <?php if (!empty(session()->getFlashdata('success'))) : ?>
                                    <div class="alert alert-success" role="alert">
                                        <?php echo session()->getFlashdata('success') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!--//app-card-->
    </div><!--//row-->

    <hr class="my-4">
</div><!--//container-fluid-->

<?= $this->endSection('content') ?>