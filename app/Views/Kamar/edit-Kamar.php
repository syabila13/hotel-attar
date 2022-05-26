<?= $this->extend('Dashboard'); ?>

<?= $this->section('content'); ?>

<div class="container-sm">
    <div class="row">
        <div class="col-8 justify-content-center">
            <form action="/petugas/kamar/update" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="form-group">
                    <h1 class="display-6">Edit Kamar</h1>
                    <hr>
                    <label for="NoKamar" class="form-label">No.Kamar</label>
                    <input type="text" class="form-control" name="no_kamar" value="<?= $detailkamar[0]['no_kamar'] ?>"   readonly>
                    <input type="hidden" class="form-control" name="id_kamar" value="<?= $detailkamar[0]['id_kamar'] ?>"   readonly>
                </div>

                <label for="" class="form-label mt-3">Tipe Kamar</label>
                <select class=" form-control " name="id_tipe_kamar" id="">
                    <option value="1">Superior</option>
                    <option value="2">Deluxe</option>
                </select>

                <!-- <label for="" class="form-label mt-3">Foto</label>
                <input type="file" value="<//?= $detailkamar[0]['foto'] ?>" class="form-control" name="foto" aria-describedby="emailHelpId" >

                <div class="mt-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Deskripsi</label>
                    <textarea type="text"class="form-control" rows="3" name="txtdeskripsi" ><//?= $detailkamar[0]['deskripsi'] ?></textarea>
                </div>

                <label for="" class="form-label mt-3">Harga</label>
                <input type="text" class="form-control" name="harga" value="<//?= $detailkamar[0]['harga'] ?>" aria-describedby="emailHelpId" placeholder="Masukkan harga kamar"> -->

                <button type="submit" class="btn btn-primary mt-3">Kirim</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>