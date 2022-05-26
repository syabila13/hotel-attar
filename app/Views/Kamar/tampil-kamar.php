<?= $this->extend('Dashboard') ?>
<?= $this->section('content') ?>
<div class="container">
    <h2>Data Kamar</h2>
    <p>
        <a href="/petugas/kamar/tambah" class="btn btn-primary btn-sm">Tambah Kamar
        </a>
    </p>
    <?php if ($pesan = session('pesan')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $pesan ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif ?>
    <table class="table table-sm table-hovered">
        <thead class="bg-light text-center">
            <tr>
                <th>No</th>
                <th>No Kamar</th>
                <th>tipe Kamar</th>
                <th>Aksi</th>
                <!-- <th>Harga</th>
                <th>foto</th>
                <th>Deskripsi</th> -->

            </tr>
        </thead>
        <tbody>
            <?php
            $htmlData = null;
            $nomor = null;
            foreach ($ListKamar as $row) {
                $nomor++;
                $htmlData = '<tr>';
                $htmlData .= '<td>' . $nomor . '</td>';
                $htmlData .= '<td>' . $row['no_kamar'] . '</td>';
                $htmlData .= '<td>' . $row['tipe'] . '</td>';
                // $htmlData .='<td>'.$row['harga'].'</td>';
                // $htmlData .='<td><img src="/gambar/'.$row['foto'].'" width="250px"></td>';
                //  $htmlData .='<td>'.$row['deskripsi'].'</td>';
                $htmlData .= '<td class="text-center">';
                // if ($kamar_tersedia < 1) {
                //     return redirect()->to('/')->with('pesan-danger', 'Kamar yang anda pesan tidak tersedia');
                // }

                // if ($kamar_tersedia < $jml_kamar) {
                //     return redirect()->to('/')->with('pesan-danger', 'Jumlah Kamar yang anda pesan melebihi jumlah kamar yang tersedia');
                // }
                $htmlData .= '<a
                href="/petugas/kamar/edit/' . $row['id_kamar'] . '" class="btn btn-info
                btn-sm mr-1">Edit</a>';
                $htmlData .= '<a
                href="/petugas/kamar/hapus/' . $row['id_kamar'] . '" class="btn
                btn-danger btn-sm">Hapus</a>';
                $htmlData .= '</td>';

                $htmlData .= '</tr>';
                echo $htmlData;
            } ?>
        </tbody>
    </table>
</div>

<?php echo $this->endSection(); ?>