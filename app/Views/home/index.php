<?= $this->extend('home/template'); ?>
<?= $this->section('content'); ?>

<!-- TEST SLIDER img -->
<?= $this->include('home/slider'); ?>

<!-- Search Bar Start -->
<div class="container-fluid search-bar position-relative" style="top: -50%; transform: translateY(-50%);">
    <div class="container">
        <div class="position-relative rounded-pill w-100 mx-auto p-5" style="background: rgba(19, 53, 123, 0.8);">
            <!-- Mulai Form -->
            <form id="searchForm" action="<?= base_url('Search/search') ?>" method="GET" class="w-100" onsubmit="return validateForm()">
                <input class="form-control border-0 rounded-pill w-100 py-3 ps-4 pe-5" type="text" name="keyword" id="keyword" placeholder="Masukkan Kode Redeem">
                <button type="submit" class="btn btn-primary rounded-pill py-2 px-4 position-absolute me-2" style="top: 50%; right: 46px; transform: translateY(-50%);">Search</button>
            </form>
            <!-- Akhir Form -->
        </div>
    </div>
</div>
<!-- Search Bar End -->

<script>
function validateForm() {
    var keyword = document.getElementById("keyword").value;
    if (keyword == "") {
        alert("Silahkan masukkan kode redeem dahulu");
        return false;
    }
    return true;
}
</script>

<?= $this->endSection('content') ?>
