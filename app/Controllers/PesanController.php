<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PesanController extends BaseController
{
    public function pesan()
    {
        // dd($this->request->getPost());
        $id_tipe_kamar = $this->request->getPost('tipe_kamar');
        $jml_kamar     = $this->request->getPost('jumlah');

        // Harga per malam = harga 1 kamar * jumlah kamar
        $tipe_kamar      = $this->tipe_kamar->find($id_tipe_kamar);
        $harga_kamar     = $tipe_kamar['harga'];
        $harga_per_malam = $harga_kamar * $jml_kamar;

        // Lama menginap = Selisih Checkin & Checkout = Checkout - Checkin
        // selisih = yang gede - yang kecil
        $check_in      = $this->request->getPost('check_in');
        $check_out     = $this->request->getPost('check_out');
        $lama_menginap = (strtotime($check_out) - strtotime($check_in)) / 60 / 60 / 24;

        // Harga total = harga per-malam * lama menginap
        $total = $harga_per_malam * $lama_menginap;

        $datanya = [
            'id_tipe_kamar' => $id_tipe_kamar,
            'nik'           => $this->request->getPost('nik'),
            'nama_tamu'     => $this->request->getPost('nama'),
            'email_tamu'    => $this->request->getPost('email'),
            'checkin'       => $check_in,
            'checkout'      => $check_out,
            'jml_kamar'     => $jml_kamar,
            'status'        => 'Pending',
            'harga'         => $harga_per_malam,
            'total'         => $total,
        ];
        $this->reservasi->insert($datanya);
        $id_reservasi = $this->reservasi->db->insertID();

        return redirect()->to('/invoice/' . $id_reservasi);
    }
}
