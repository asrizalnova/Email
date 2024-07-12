<?= $this->extend('home/template'); ?>
<?= $this->section('content'); ?>


<div class="container-fluid page-header py-5" style="background-image: url('<?= base_url('asset-user/img/destination-2.jpg');?>');">
    <div class="container text-center py-5">
        <h3 class="display-2 text-white mb-4 animated slideInDown">
            Hasil dari "<?= esc($keyword); ?>"
        </h3>
    </div>
</div>

<div class="container mt-5 mb-5">
    <?php if (empty($results)): ?>
        <div class="alert alert-warning" role="alert" style="padding: 150px; font-size: 25px; font-style: bold; color: black; text-align: center;">
            Tidak ada hasil yang ditemukan "<?= esc($keyword); ?>"
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover" style="text-align: center;">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Code</th>
                        <th scope="col">Instansi Pengirim</th>
                        <th scope="col">Keperluan</th>
                        <th scope="col">Surat</th>
                        <th scope="col">Waktu</th>
                        <th scope="col">Status</th>
                        <th scope="col">File</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $result): ?>
                        <tr style="font-size: 18px;">
                            <td><?= esc($result->code); ?></td>
                            <td><?= esc($result->instansi_pengirim); ?></td>
                            <td><?= esc($result->keperluan); ?></td>
                            <td><?= esc($result->surat); ?></td>
                            <td><?= esc($result->waktu); ?></td>
                            <td><?= esc($result->status); ?></td>
                            <td style="<?php echo $result->surat && pathinfo('asset-user/images/' . esc($result->surat), PATHINFO_EXTENSION) == 'docx' ? 'height: 300px;' : '' ?>">
                                <?php if (!empty($result->surat)): ?>
                                    <?php
                                    // Determine the file path and extension
                                    $file_path = 'asset-user/images/' . esc($result->surat);
                                    $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);

                                    // Handle different file types
                                    if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                        <!-- Display image file -->
                                        <img src="<?= base_url($file_path); ?>" class="img-fluid" alt="Surat Image" style="max-width: 200px; max-height: 200px;">
                                        <br>
                                        <a href="<?= base_url($file_path); ?>" class="btn btn-primary mt-2" target="_blank">Lihat secara penuh</a>
                                    <?php elseif ($file_extension === 'pdf'): ?>
                                        <!-- Embed PDF file -->
                                        <embed src="<?= base_url($file_path); ?>" type="application/pdf" width="100%" height="600px">
                                        <br>
                                        <a href="<?= base_url($file_path); ?>" class="btn btn-primary mt-2" target="_blank">Lihat secara penuh</a>
                                    <?php elseif ($file_extension === 'docx'): ?>
                                        <!-- Display message for DOCX files -->
                                        <div>
                                            File tipe DOCX tidak memiliki pratinjau. Silahkan tekan <a href="<?= base_url($file_path); ?>" class="btn btn-primary" target="_blank">lihat secara penuh</a> untuk mengunduh file.
                                        </div>
                                    <?php else: ?>
                                        <!-- Link to download other file types -->
                                        <a href="<?= base_url($file_path); ?>" class="btn btn-primary" target="_blank">View File</a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    No File
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection('content') ?>
