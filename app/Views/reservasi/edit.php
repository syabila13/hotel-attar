<?= $this->extend('reservasi/dashboard-reservasi'); ?>
<?= $this->section('content'); ?>
<h2>Form Reservasi</h2>
<div class="container-sm">
    <div class="row">
        <div class="col-8 justify-content-center">
            <form action="/petugas/reservasi/edit/<?= $reservasi['id_reservasi'] ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <!-- 
                    1. nik
                    2. nama tamu
                    3. email tamu 
                    4. check in 
                    5. check out
                    6. jumlah kamar
                -->
                <div class="mb-3">
                    <label class="form-label" for="nik">NIK</label>
                    <input type="text" class="form-control" id="nik" name="nik" value="<?= $reservasi['nik'] ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="nama">Nama Tamu</label>
                    <input type="text" class="form-control" id="nama_tamu" name="nama_tamu" value="<?= $reservasi['nama_tamu'] ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="email">Email Tamu</label>
                    <input type="email" class="form-control" id="email_tamu" name="email_tamu" value="<?= $reservasi['email_tamu'] ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="tipe_kamar">Tipe Kamar</label>
                    <select id="tipe_kamar" class="form-control" name="id_tipe_kamar">
                        <option selected disabled>Pilih tipe kamar...</option>
                        <?php foreach ($tipe_kamar as $tk) : ?>
                            <option value="<?= $tk['id'] ?>" <?= ($tk['id'] == $reservasi['id_tipe_kamar']) ? 'selected' : '' ?>><?= $tk['tipe'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col">
                        <label class="form-label" for="check_in">Check In</label>
                        <input type="date" class="form-control" id="checkin" name="checkin" value="<?= $reservasi['checkin'] ?>">
                    </div>

                    <div class="col">
                        <label class="form-label" for="checkout">Check Out</label>
                        <input type="date" class="form-control" id="checkout" name="checkout" value="<?= $reservasi['checkout'] ?>">
                    </div>
                </div>

                <div class="mb-3 form-group">
                    <label class="form-label" for="jumlah">Jumlah Kamar</label>
                    <input type="number" class="form-control" id="jumlah" name="jml_kamar" value="<?= $reservasi['jml_kamar'] ?>">
                </div>

                <a href="/petugas/reservasi/data" class="btn btn-danger">Kembali</a>
                <button type="submit" class="btn btn-primary">Edit</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>