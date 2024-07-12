<?= $this->extend('admin/template/template'); ?>
<?= $this->Section('content'); ?>

<div class="app-content pt-3 p-md-3 p-lg-4">
	<div class="container-xl">
		<h1 class="app-page-title">Lihat User</h1>
		<?php if (!empty(session()->getFlashdata('error'))) : ?>
			<div class="alert alert-danger" role="alert">
				<h4>Error</h4>
				<p><?php echo session()->getFlashdata('error'); ?></p>
			</div>
		<?php endif; ?>
		<?php if (session()->has('success')) : ?>
			<div class="alert alert-success">
				<?= session('success') ?>
			</div>
		<?php endif; ?>
		<div class="row gy-4">
		<div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
                <div class="app-card app-card-orders-table shadow-sm mb-5">
                    <div class="app-card-body">
                        <div class="table-responsive">
                            <table class="table app-table-hover mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th class="text-center" valign="middle">ID User</th>
                                        <th class="text-center" valign="middle">Jabatan</th>
                                        <th class="text-center" valign="middle">Username</th>
                                        <th class="text-center" valign="middle">Password</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($all_data_profil as $tampilProfil) : ?>
                                        <tr style="text-align: center;">
                                            <td><?= $tampilProfil['id_user'] ?></td>
                                            <td><?= $tampilProfil['useridlevel'] ?></td>
                                            <td><?= $tampilProfil['username'] ?></td>
                                            <td style="border: none;">
                                                <span id="hiddenPassword"><?= str_repeat('*', strlen($tampilProfil['password'])) ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div><!--//table-responsive-->
                    </div><!--//app-card-body-->
                </div><!--//app-card-->
            </div><!--//tab-pane-->
		</div><!--//row-->
	</div><!--//container-xl-->
</div><!--//app-content-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var hiddenPasswords = document.querySelectorAll("#hiddenPassword");
        hiddenPasswords.forEach(function(hiddenPassword) {
            hiddenPassword.textContent = "*".repeat(hiddenPassword.textContent.length);
        });
    });
</script>


<?= $this->endSection('content') ?>