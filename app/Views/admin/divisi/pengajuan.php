<?php if (session()->idlevel == 1 || session()->idlevel == 4 || session()->idlevel == 5 || session()->idlevel == 6) :?>

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
</style>

<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <div class="row g-3 mb-4 align-items-center justify-content-between">
            <div class="col-auto">
                <h1 class="app-page-title mb-0">Pengajuan</h1>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="<?php echo base_url() . "admin/Divisi/index" ?>" class="btn btn-primary me-md-2">kembali ke divisi</a>
            <?php if (session()->idlevel == 1 || session()->idlevel == 4 || session()->idlevel == 5 || session()->idlevel == 6) :?>
                <a href="<?php echo base_url() . "admin/Divisi/tambah" ?>" class="btn btn-primary me-md-2"> + Kirim Surat</a>
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
                                    <?php foreach (array_reverse( $all_data_Pengajuan ) as $slider) : ?>
                                        <tr>
                                            <td><?= $slider->id_req ?></td>
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
                                                <div class="d-grid gap-2" style="align-items: center;">
                                                    <a href="<?= base_url('admin/divisi/Ajukan/' . $slider->id_req) ?>" class="btn btn-primary">Ajukan</a>
                                                    
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


<?= $this->endSection('content') ?>
<?php endif;?>  