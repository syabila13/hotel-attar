<?= $this->extend('reservasi/dashboard-reservasi'); ?>
<?= $this->section('content'); ?>
<h2>Form Reservasi</h2>
<div class="container-sm">
    <div class="row">
        <div class="col-8 justify-content-center">
            <form action="/petugas/reservasi/add" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <!-- 
            1. nik
            2. nama tamu
            3. email tamu 
            4. check in 
            5. check out
            6. jumlah kamar
          -->
                    <form action="/pesan" method="POST" id="formPesan">

                        <div class="mb-3">
                            <label class="form-label" for="nik">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Tamu</label>
                            <input type="text" class="form-control" id="nama" name="nama">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="email">Email Tamu</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="tipe_kamar">Tipe Kamar</label>
                            <select id="tipe_kamar" class="form-control" name="tipe_kamar">
                                <option selected>Pilih tipe kamar...</option>
                                <?php foreach ($tipe_kamar as $tk) : ?>
                                    <option value="<?= $tk['id'] ?>"><?= $tk['tipe'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label class="form-label" for="check_in">Check In</label>
                                <input type="date" class="form-control" id="check_in" name="check_in">
                            </div>

                            <div class="col">
                                <label class="form-label" for="checkout">Check Out</label>
                                <input type="date" class="form-control" id="checkout" name="check_out">
                            </div>
                        </div>

                        <div class="col">
                            <label class="form-label" for="jumlah">Jumlah Kamar</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah">
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Kirim</button>
                    </form>
                </div>
        </div>
    </div>

    <?= $this->endSection(); ?>