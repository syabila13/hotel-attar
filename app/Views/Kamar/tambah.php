<?= $this->extend('Dashboard'); ?>

<?= $this->section('content'); ?>

<div class="container-sm">
    <div class="row">
        <div class="col-8 justify-content-center">
            <form action="/petugas/kamar/add" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="form-group">
                    <h1 class="display-6">Tambah Kamar</h1>
                    <hr>
                    <label for="NoKamar" class="form-label">No.Kamar</label>
                    <input type="text" class="form-control " name="no_kamar" id="" placeholder="Masukkan nomor kamar" value="<?= old('no_kamar'); ?>">
                </div>

                <label for="" class="form-label mt-3">Tipe Kamar</label>
                <select class=" form-control " name="id_tipe_kamar" id="">
                    <option value="1">Superior</option>
                    <option value="2">Deluxe</option>
                </select>
                <!-- <label for="" class="form-label mt-3">Foto</label>
                <input type="file" class="form-control" name="foto" id="" aria-describedby="emailHelpId" placeholder="">
                <div class="mt-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Tambahkan deskripsi" name="deskripsi"></textarea>
                </div> -->

                <!-- <label for="" class="form-label mt-3">Harga</label>
                <input type="text" class="form-control" name="harga" id="" aria-describedby="emailHelpId" placeholder="Masukkan harga kamar"> -->

                <button type="submit" class="btn btn-primary mt-3">Kirim</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>