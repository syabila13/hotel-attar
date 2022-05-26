<?= $this->extend('reservasi/dashboard-reservasi') ?>
<?= $this->section('content') ?>
<div class="container-fluid mx-4">
    <h2>Data Reservasi</h2>

    <div class="row align-items-center">
        <div class="col-auto">
            <form action="" method="GET" class="mb-2">
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <input type="text" class="form-control" placeholder="Masukkan nama Tamu" name="nama">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" type="submit" id="cari-nama">Cari nama</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-auto">
            <form action="" method="GET" class="mb-2">
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <input type="date" class="form-control" name="cekin">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" type="submit" id="cari-tanggal">Cari tanggal cekin</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- <p>
    <a href="/petugas/fhotel/tambah" class="btn btn-primary
    btn-sm">Tambah Fasilitas Hotel</a>
</p> -->
    <?php if (session()->getFlashdata('batal')) : ?>
        <div class="col-6">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <div class="fw-light"><strong><?= session()->getFlashdata('batal'); ?></strong></div>
            </div>
        </div>
    <?php endif; ?>
    <table class="table table-sm table-hovered">
        <thead class="bg-light text-center">
            <tr>
                <th>No</th>
                <th>Nama Tamu</th>
                <th>Email Tamu</th>
                <th>Cek-in</th>
                <th>Cek-Out</th>
                <th>Jumlah Kamar</th>
                <th>Harga/malam</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 1 ?>
            <?php foreach ($Listreservasi as $row) { ?>
                <tr class="text-center">
                    <td><?= $nomor++ ?></td>
                    <td><?= $row['nama_tamu'] ?></td>
                    <td><?= $row['email_tamu'] ?></td>
                    <td><?= $row['checkin'] ?></td>
                    <td><?= $row['checkout'] ?></td>
                    <td><?= $row['jml_kamar'] ?></td>
                    <td><?= $row['harga'] ?></td>
                    <td><?= $row['total'] ?></td>
                    <td><?= $row['status'] ?></td>
                    <td class="text-center">
                        <a href="/petugas/reservasi/cekin/<?= $row['id_reservasi'] ?>" class="btn btn-info btn-sm mr-1">cek-in</a>
                        <a href="/petugas/reservasi/cekout/<?= $row['id_reservasi'] ?>" class="btn btn-success btn-sm mr-1">cek-out</a>
                        <a href="/petugas/reservasi/edit/<?= $row['id_reservasi'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="/petugas/reservasi/batal/<?= $row['id_reservasi'] ?>" class="btn btn-danger btn-sm">Batal</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php echo $this->endSection(); ?>