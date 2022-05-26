<?= $this->extend('Dashboard'); ?>

<?= $this->section('content'); ?>

<div class="container-sm">
    <div class="row">
        <div class="col-8 justify-content-center">
            <form action="/petugas/fkamar/update/" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="form-group">
                    <h1 class="display-6">Edit fasilitas Kamar</h1>
                    <hr>
                    <label for="Namafasilitas" class="form-label">Nama Fasilitas</label>
                    <input type="text" class="form-control" name="nama_fkamar" value="<?= $detailfkamar[0]['nama_fkamar'] ?>"   readonly>
                    <input type="hidden" class="form-control" name="id_fkamar" value="<?= $detailfkamar[0]['id_fkamar'] ?>"   readonly>
                </div>

                <label for="" class="form-label mt-3">Tipe Kamar</label>
                <select class=" form-control " name="tipe_kamar" id="">
                    <option value="1">Superior</option>
                    <option value="2">Deluxe</option>
                </select>
                
                <div class="mt-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Deskripsi</label>
                    <textarea type="text"class="form-control" rows="3" name="txtdeskripsi" ><?= $detailfkamar[0]['deskripsi'] ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Kirim</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>