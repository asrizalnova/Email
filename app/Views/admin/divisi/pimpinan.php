<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<?php
// Sort data by id in descending order
usort($all_data_pimpinan, function($a, $b) {
    return $b->id - $a->id; // Sort by id in descending order
});
?>

<style>
    body { font-family: Arial, sans-serif; }
    .modal { display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4); }
    .modal-content { background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 600px; }
    .close, .close-response { color: #aaa; float: right; font-size: 28px; font-weight: bold; }
    .close:hover, .close:focus, .close-response:hover, .close-response:focus { color: black; text-decoration: none; cursor: pointer; }
    #signature-pad { border: 1px solid #ccc; width: 100%; height: 200px; }
    .button-container { display: flex; justify-content: space-between; margin-top: 10px; }
    .btn-clear { background-color: red; color: white; border: none; padding: 10px 20px; cursor: pointer; }
    .btn-save { background-color: green; color: white; border: none; padding: 10px 20px; cursor: pointer; }
</style>

<!-- Modal for Signature -->
<div id="signatureModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Tanda Tangan</h2>
        <canvas id="signature-pad"></canvas>
        
        <div class="button-container">
            <button id="clear" class="btn-clear">Bersihkan</button>
            <button id="save" class="btn-save">Simpan</button>
        </div>

        <form id="signature-form" method="POST" action="<?= base_url('admin/pimpinan/save-signature') ?>">
            <input type="hidden" name="signature" id="signature">
            <input type="hidden" name="id" id="entityId">
        </form>
    </div>
</div>

<!-- Modal for Response -->
<div id="responseModal" class="modal">
    <div class="modal-content">
        <span class="close-response">&times;</span>
        <h2>Beri Tanggapan</h2>
        <form id="response-form" method="POST" action="<?= base_url('admin/pimpinan/save-response') ?>">
            <input type="hidden" name="id" id="response-id">
            <textarea name="tanggapan" id="response-text" rows="4" cols="50"></textarea>
            <button type="submit" class="btn btn-sm btn-success">Simpan Tanggapan</button>
        </form>
    </div>
</div>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Pimpinan</h1>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                
            </div>
        </div>
        <?php if (session()->has('success')) : ?>
                <div class="alert alert-success">
                    <?= session('success') ?>
                </div>
            <?php endif; ?>
            <div id="divisi-list"></div>
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
                                    <th class="text-center" valign="middle">Signature</th>
                                    <th class="text-center" valign="middle">Tanggapan</th>
                                    <th class="text-center" valign="middle">Aksi</th>
                                </tr>
                            </thead>
                            <tbody style="text-align: center;">
                                <?php foreach ($all_data_pimpinan as $tampilProduk) : ?>
                                    <tr>
                                        <td><?= $tampilProduk->id ?></td>
                                        <td><?= $tampilProduk->instansi_ditujukan ?></td>
                                        <td><?= $tampilProduk->keterangan ?></td>
                                        <td>
                                            <a href="<?= base_url() . 'asset-user/images/' . $tampilProduk->file ?>" target="_blank"><?= $tampilProduk->file ?></a>
                                        </td>
                                        <td><?= $tampilProduk->status ?></td>
                                        <td><?= $tampilProduk->waktu ?></td>
                                        <td>
                                            <?php if (empty($tampilProduk->signature)) : ?>
                                                <button class="btn btn-sm btn-primary add-signature" data-id="<?= $tampilProduk->id ?>">Terima</button>
                                                <form action="<?= base_url('admin/pimpinan/reject') ?>" method="post" style="display: inline;">
                                                    <input type="hidden" name="id" value="<?= $tampilProduk->id ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger reject-button">Tolak</button>
                                                </form>
                                            <?php else : ?>
                                                <img src="<?= base_url($tampilProduk->signature) ?>" alt="Signature" style="max-width: 100px;">
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <!-- Tampilkan tanggapan jika ada -->
                                            <?php if (!empty($tampilProduk->tanggapan)) : ?>
                                                <p><?= $tampilProduk->tanggapan ?></p>
                                            <?php else : ?>
                                                <!-- Tambahkan tombol untuk memberi tanggapan -->
                                                <button class="btn btn-sm btn-primary add-response" data-id="<?= $tampilProduk->id ?>">Beri Tanggapan</button>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <form action="<?= base_url('admin/pimpinan/reset') ?>" method="post" style="display: inline;">
                                                <input type="hidden" name="id" value="<?= $tampilProduk->id ?>">
                                                <button type="submit" class="btn btn-sm btn-warning">Ubah Keputusan</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div><!--//table-responsive-->
                </div><!--//app-card-body-->
            </div><!--//app-card-->
        </div><!--//tab-pane-->

        <div class="tab-content" id="orders-table-tab-content">
            
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    var signatureModal = document.getElementById("signatureModal");
    var responseModal = document.getElementById("responseModal");
    var signatureClose = document.getElementsByClassName("close")[0];
    var responseClose = document.getElementsByClassName("close-response")[0];
    var canvas = document.getElementById('signature-pad');
    var signaturePad = new SignaturePad(canvas);
    var clearButton = document.getElementById('clear');
    var saveButton = document.getElementById('save');
    var signatureInput = document.getElementById('signature');
    var entityIdInput = document.getElementById('entityId');
    var responseForm = document.getElementById("response-form");
    var responseIdInput = document.getElementById("response-id");
    var responseTextInput = document.getElementById("response-text");

    document.querySelectorAll('.add-signature').forEach(item => {
        item.addEventListener('click', event => {
            openSignatureModal(item.getAttribute('data-id'));
        });
    });

    document.querySelectorAll('.add-response').forEach(item => {
        item.addEventListener('click', event => {
            openResponseModal(item.getAttribute('data-id'));
        });
    });

    function openSignatureModal(id) {
        entityIdInput.value = id;
        signatureModal.style.display = "block";
        resizeCanvas();
        signaturePad.clear();
    }

    function openResponseModal(id) {
        responseIdInput.value = id;
        responseModal.style.display = "block";
    }

    signatureClose.onclick = function() {
        signatureModal.style.display = "none";
    }

    responseClose.onclick = function() {
        responseModal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == signatureModal) {
            signatureModal.style.display = "none";
        }
        if (event.target == responseModal) {
            responseModal.style.display = "none";
        }
    }

    clearButton.addEventListener('click', function() {
        signaturePad.clear();
    });

    saveButton.addEventListener('click', function() {
        if (!signaturePad.isEmpty()) {
            signatureInput.value = signaturePad.toDataURL('image/png');
            document.getElementById('signature-form').submit();
        } else {
            alert("Tanda tangan kosong!");
        }
    });

    responseForm.addEventListener("submit", function(event) {
        if (!responseTextInput.value.trim()) {
            alert("Tanggapan tidak boleh kosong!");
            event.preventDefault();
        }
    });

    function resizeCanvas() {
        var ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }

    window.onresize = resizeCanvas;
    resizeCanvas();
</script>

<?= $this->endSection(); ?>
