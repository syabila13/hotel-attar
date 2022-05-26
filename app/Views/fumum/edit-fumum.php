<?= $this->extend('Dashboard'); ?>

<?= $this->section('content'); ?>

<div class="container-sm">
    <div class="row">
        <div class="col-8 justify-content-center">
            <form action="/petugas/fumum/update" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="form-group">
                    <h1 class="display-6">Edit fasilitas Hotel</h1>
                    <hr>
                    <label for="Namafasilitas" class="form-label">Nama Fasilitas</label>
                    <input type="text" class="form-control" name="nama_fasilitas_hotel" value="<?= $detailfumum[0]['nama_fasilitas_hotel'] ?>" readonly>
                    <input type="hidden" class="form-control" name="id_hotel" value="<?= $detailfumum[0]['id_hotel'] ?>" readonly>
                </div>
                <img src="/gambar/<?= $detailfumum[0]['foto'] ?>" alt="" width="300" right="300">
                <div class="form-group">
                    <label for="" class="form-label mt-3">Foto</label>
                    <input type="file" class="form-control" rows="3" name="foto" id="" aria-describedby="emailHelpId" placeholder=""></textarea>
                </div>

                <div class="mt-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Deskripsi</label>
                    <textarea type="text" class="form-control" rows="3" name="txtdeskripsi"><?= $detailfumum[0]['deskripsi'] ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Kirim</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>