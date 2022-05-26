<?= $this->include('Layout/Header'); ?>
<!-- Awal Konten Aplikasi -->
<main role="main" class="flex-shrink-0">
    <div class="container-fluid mx 3">
        <h1 class="display-6 text-success">
            <marquee>Selamat Datang di Hotel Attar </marquee><strong><?= session()->get('id_kamar'); ?></strong>
        </h1>
        <?= $this->renderSection('content') ?>
    </div>
</main>
<?= $this->include('Layout/Footer'); ?>