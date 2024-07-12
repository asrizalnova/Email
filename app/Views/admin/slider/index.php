<?php if (session()->idlevel == 2 || session()->idlevel == 1) : ?>
<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

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

    .modal-backdrop {
        z-index: 1040 !important;
    }
    .modal-dialog {
        margin: 2px auto;
        z-index: 1100 !important;
    }

    .d-grid {
        display: grid;
        gap: 10px;
    }
</style>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Surat Masuk</h1>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="<?php echo base_url() . "admin/slider/status" ?>" class="btn btn-primary me-md-2">status surat</a>
            <?php if (session()->idlevel == 2 || session()->idlevel == 1) :?>
                <a href="<?php echo base_url() . "admin/slider/tambah" ?>" class="btn btn-primary me-md-2"> + Kirim Surat</a>
                <?php endif;?>
            </div>
           
           
            </br>

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
                        <form action="<?= base_url('admin/slider/cariByRedeemKode') ?>" method="GET" class="mb-3">
    <!-- <div class="input-group">
        <input type="text" class="form-control" placeholder="Masukkan Redeem Kode" name="redeem_code">
        <button class="btn btn-primary" type="submit">Cari</button>
    </div>
</form> -->


                            <table class="table app-table-hover mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th class="text-center" valign="middle">ID</th>
                                        <th class="text-center" valign="middle">Instansi Pengirim</th>
                                        <th class="text-center" valign="middle">Ditujukan Kepada</th>
                                        <th class="text-center" valign="middle">Saran</th>
                                        <th class="text-center" valign="middle">File Surat</th>
                                        <th class="text-center" valign="middle">Status</th>
                                        <th class="text-center" valign="middle">Waktu Pengirim</th>
                                        <th class="text-center" valign="middle">Code Redeem</th>
                                        <th class="text-center" valign="middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center;">
                                <?php foreach (array_reverse($all_data_slider) as $slider) : ?>
                                    <tr>
                                        <!-- Existing table data -->
                                        <td><?= $slider->id_SM ?></td>
                                        <td><?= $slider->instansi_pengirim ?></td>
                                        <td><?= $slider->keperluan ?></td>
                                        <td><?= $slider->komentar ?></td>
                                        <td>
                                            <a href="<?= base_url('asset-user/images/' . $slider->surat) ?>" target="_blank"><?= $slider->surat ?></a>
                                        </td>
                                        <td><?= $slider->status ?></td>
                                        <td><?= $slider->waktu ?></td>
                                        <td><?= $slider->code ?></td>
                                        
                                        <td valign="middle">
                                            <div class="d-grid gap-2 d-md-grid" style="grid-template-columns: 1fr 1fr;">
                                                <a href="<?= base_url('admin/slider/baca/' . $slider->id_SM) ?>" class="btn btn-warning mb-2">Baca</a>
                                                <a href="<?= base_url('admin/slider/salinKePimpinan/' . $slider->id_SM) ?>" class="btn btn-primary mb-2">Ajukan</a>
                                                <a href="<?= base_url('admin/slider/edit/' . $slider->id_SM) ?>" class="btn btn-info mb-2">Edit</a>
                                                <a href="<?= base_url('admin/slider/delete') . '/' . $slider->id_SM ?>" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $slider->id_SM ?>">Hapus</a>
                                            </div>
                                        </td>


                                    </tr>
                                <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php foreach ($all_data_slider as $slider) : ?>
  <div class="modal fade" id="deleteModal<?= $slider->id_SM ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $slider->id_SM ?>" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel<?= $slider->id_SM ?>">Konfirmasi Hapus</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Apakah Anda yakin ingin menghapus data ini?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <a href="<?= base_url('admin/slider/delete/' . $slider->id_SM) ?>" class="btn btn-danger">Hapus</a>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>



                        </div><!--//table-responsive-->
                        </div><!--//app-card-body-->
                        </div><!--//container-fluid-->
                        </div><!--//app-content-->
                        </div><!--//app-wrapper-->

                        <!--tampilan pop-up -->



                        <?php if (session()->has('success')) : ?>
    <div class="alert alert-success">
        <?= session('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->has('error')) : ?>
    <div class="alert alert-danger">
        <?= session('error') ?>
    </div>
<?php endif; ?>




<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>


<?= $this->endSection('content') ?>
<?php endif; ?>