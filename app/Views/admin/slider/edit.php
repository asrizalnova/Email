<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Edit Surat</h1>
        <hr class="mb-4">
        <div class="row g-4 settings-section">
            <div class="app-card app-card-settings shadow-sm p-4">
                <div class="card-body">
                    <form action="<?= base_url('admin/slider/proses_edit/' . $sliderData->id_SM) ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" id="id_SK" name="id_SK" value="<?= $sliderData->id_SM ?>" hidden>
                                <div class="mb-3">
                                    <label class="form-label">Nama Instansi Asal<br><span class="custom-color custom-label">nama instansi asal hanya boleh mengandung huruf dan angka</span></label>
                                    <input type="text" class="form-control" id="nama_produk_in" name="nama_produk_in" value="<?= $sliderData->instansi_pengirim; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Perihal <br><span class="custom-color custom-label">nama perihal hanya boleh mengandung huruf dan angka</span></label>
                                    <input type="text" class="form-control" id="nama_produk_en" name="nama_produk_en" value="<?= $sliderData->keperluan; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Komentar</label>
                                    <textarea class="form-control" id="komentar" name="komentar" rows="4"><?= $sliderData->komentar; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">File Surat</label>
                                    <input type="file" class="form-control" id="surat" name="surat" onchange="previewFile()">
                                    <div id="previewContainer"></div>
                                    <?= $validation->getError('surat') ?>
                                </div>
                                <p>*File maksimal berukuran 2 Mb</p>
                                <p>*File harus berekstensi pdf/docx</p>
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
            </div><!--//app-card-->
        </div><!--//row-->

        <hr class="my-4">
    </div><!--//container-fluid-->
</div><!--//app-content-->

<?= $this->endSection('content'); ?>
