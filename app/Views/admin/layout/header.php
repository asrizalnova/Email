<header class="app-header fixed-top">
    <div class="app-header-inner">
        <div class="container-fluid py-2">
            <div class="app-header-content">
                <div class="row justify-content-between align-items-center">

                    <div class="col-auto">
                        <a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" role="img">
                                <title>Menu</title>
                                <path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="search-mobile-trigger d-sm-none col">
                        <i class="search-mobile-trigger-icon fa-solid fa-magnifying-glass"></i>
                    </div>
                    <div class="app-utilities col-auto">
                            <!-- <img src="<?= base_url('assets/images/user.png') ?>" alt="user profile" style="width: 40px; height: 40px;"> -->
                            <p style="font-size: larger;">Selamat datang <?= session()->get('namauser'); ?></p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?= $this->include('admin/layout/navbar'); ?>
</header>
