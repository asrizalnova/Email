<?php if (session()->idlevel == 2 || session()->idlevel == 1) : ?>
<?= $this->extend('admin/template/template'); ?>
<?= $this->section('content'); ?>

<style>
    /* Style untuk pop up */
    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Warna latar belakang transparan dengan kegelapan 50% */
        display: none;
    }

    .popup-content {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }
   
    .status-box {
        border: 2px solid red;
        padding: 10px;
        display: inline-block;
        font-size: 14px;
        color: red;
        font-weight: bold;
        border-radius: 5px;
        background-color: #fdd;
    }
    .status-accepted {
    color: green;
    font-weight: bold;
}

.status-rejected {
    color: red;
    font-weight: bold;
}

    
</style>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Status Surat</h1>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="<?php echo base_url() . "admin/slider/index" ?>" class="btn btn-primary me-md-2">Surat Masuk</a>
            <?php if (session()->idlevel == 2 || session()->idlevel == 1) :?>
                <a href="<?php echo base_url() . "admin/slider/tambah" ?>" class="btn btn-primary me-md-2"> + Kirim Surat</a>
                <?php endif;?>
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
                                    <th class="text-center" valign="middle">Komentar</th>
                                    <th class="text-center" valign="middle">Tanggapan</th>
                                    <th class="text-center" valign="middle">Surat</th>
                                    <th class="text-center" valign="middle">Status</th>
                                    <th class="text-center" valign="middle">Waktu</th>
                                    <th class="text-center" valign="middle">Signature</th>
                                    <th class="text-center" valign="middle">Aksi</th>
                                </tr>
                            </thead>
                            <tbody style="text-align: center;">
                                <?php foreach ($all_data_pimpinan as $tampilProduk) : ?>
                                    <tr>
                                        <td><?= $tampilProduk->id ?></td>
                                        <td><?= $tampilProduk->instansi_ditujukan ?></td>
                                        <td><?= $tampilProduk->keterangan ?></td>
                                        <td><?= $tampilProduk->komentar ?></td>
                                        <td><?= $tampilProduk->tanggapan ?></td>
                                        <td>
                                            <a href="<?= base_url() . 'asset-user/images/' . $tampilProduk->file ?>" target="_blank"><?= $tampilProduk->file ?></a>
                                        </td>
                                        <td style="color: <?= $tampilProduk->status === 'Diterima oleh Atasan' ? '#00FF00' : ($tampilProduk->status === 'Ditolak oleh Atasan' ? 'red' : 'inherit') ?>; font-weight: bold;">
    <?= $tampilProduk->status ?>
</td>


                                        <td><?= $tampilProduk->waktu ?></td>
                                        <td>  <?php if (empty($tampilProduk->signature)) : ?>
                                            <div class="status-box">
                                                Belum Disetujui
                                            </div>

                                            <?php else : ?>
                                                <img src="<?= base_url($tampilProduk->signature) ?>" alt="Signature" style="max-width: 100px;">
                                            <?php endif; ?>
                                        </td>
                                          
                                            <td valign="middle">
                                                <div class="d-grid gap-2" style="align-items: center;">
                                                    <button class="btn btn-primary" onclick="document.getElementById('popup<?=  $tampilProduk->id  ?>').style.display = 'block'">Disposisi</button>
                                                </div>
                                            </td>
                                        </tr>
                                        
                                    </tr>
                                  
                                    <div id="popup<?= $tampilProduk->id ?>" class="popup-overlay">
    <div class="popup-content">
        <span class="close" onclick="document.getElementById('popup<?= $tampilProduk->id ?>').style.display = 'none'">&times;</span>
        <h2>Disposisi ke Divisi</h2>
        <select class="form-control" onchange="submitDisposisi(this.value)">
                                                    <option value="">-- Pilih Divisi --</option>
                                                    <option value="<?= base_url('admin/Pimpinanctrl/disposisi/' . $tampilProduk->id) ?>">Disposisi ke Divisi Marketing</option>
                                                    <option value="<?= base_url('admin/Pimpinanctrl/divisi02/' . $tampilProduk->id) ?>">Disposisi ke Divisi HR</option>
                                                    <option value="<?= base_url('admin/Pimpinanctrl/divisi03/' . $tampilProduk->id) ?>">Disposisi ke Divisi Umum</option>
                                                </select>
    </div>
</div>


                                        <script>
                                            function submitDisposisi(url) {
                                                if (url !== '') {
                                                    window.location.href = url;
                                                }
                                            }
                                        </script>
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
<?php endif; ?>
