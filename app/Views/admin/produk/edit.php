<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">Edit Surat</h1>
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
                    <form action="<?= base_url('admin/produk/proses_edit/' . $produkData->id_SK) ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" id="id_SK" name="id_SK" value="<?= $produkData->id_SK ?>" hidden>
                                <div class="mb-3">
                                    <label class="form-label">Nama Instansi Asal <br><span class="custom-color custom-label">nama produk hanya boleh mengandung huruf dan angka</span></label>
                                    <input type="text" class="form-control" id="nama_produk_in" name="nama_produk_in" value="<?= $produkData->instansi_ditujukan; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Perihal <br><span class="custom-color custom-label">nama produk hanya boleh mengandung huruf dan angka</span></label>
                                    <input type="text" class="form-control" id="nama_produk_en" name="nama_produk_en" value="<?= $produkData->keperluan; ?>">
                                </div>
                                <div class="mb-3" style="display: none;">
                                    <label class="form-label">Waktu</label>
                                    <input type="text" class="form-control tiny" id="deskripsi_produk_en" name="deskripsi_produk_en"><?= $produkData->waktu; ?></input>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">File Surat</label>
                                    <input type="file" class="form-control" id="surat_keluar" name="surat_keluar" onchange="previewFile()">
                                    <div id="previewContainer"></div>
                                    <?= $validation->getError('surat_keluar') ?>
                                </div>
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

<?= $this->endSection('content') ?>
<script>
    function previewFile() {
        const previewContainer = document.getElementById('previewContainer');
        const file = document.querySelector('input[type=file]').files[0];
        const reader = new FileReader();

        if (file) {
            reader.readAsDataURL(file);
            reader.onloadend = function () {
                if (file.type === 'application/pdf') {
                    const preview = document.createElement('embed');
                    preview.setAttribute('width', '100%');
                    preview.setAttribute('height', '500px');
                    preview.setAttribute('src', reader.result);
                    previewContainer.innerHTML = '';
                    previewContainer.appendChild(preview);
                } else if (file.type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                    previewContainer.innerHTML = `<p>Preview for DOCX files is not supported. <a href="${reader.result}" target="_blank" rel="noopener noreferrer">Download</a></p>`;
                } else {
                    previewContainer.innerHTML = '<p>Preview is not available for this file type.</p>';
                }
            }
        }
    }
</script>
