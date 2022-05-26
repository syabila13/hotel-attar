<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Reservasi;


class ReservasiController extends BaseController
{
    public function index()
    {
        return view('reservasi/dashboard-reservasi');
    }

    public function tampilreservasi()
    {
        if (!session()->get('sudahkahLogin')) {
            return redirect()->to('/petugas');
            exit;
        }
        // cek apakah yang login bukan admin ? 
        if (session()->get('level') != 'resepsionis') {
            return redirect()->to('/petugas');
            exit;
        }

        $Datareservasi = new reservasi;

        if ($filter_nama = $this->request->getGet('nama')) {
            $Datareservasi->orLike('nama_tamu', $filter_nama);
        }

        if ($filter_cekin = $this->request->getGet('cekin')) {
            $Datareservasi->orWhere('checkin', $filter_cekin);
        }

        $data['Listreservasi'] = $Datareservasi->findAll();
        return view('reservasi/data', $data);
    }

    public function dashboardreservasi()
    {
        return view('/reservasi/dashboard-reservasi');
    }

    public function invoice($id_reservasi)
    {
        $data['reservasi'] = $this->reservasi
            ->select('reservasi.*, tipe_kamar.tipe, tipe_kamar.harga AS harga_tipe_kamar')
            ->join('tipe_kamar', 'tipe_kamar.id = reservasi.id_tipe_kamar')
            ->find($id_reservasi);
        $data['reservasi']['lama_menginap'] = (strtotime($data['reservasi']['checkout']) - strtotime($data['reservasi']['checkin'])) / 60 / 60 / 24;
        // dd($data);

        return view('reservasi/invoice', $data);
    }

    public function cekin($id_reservasi)
    {
        $this->reservasi->update($id_reservasi, ['status' => 'Check-In']);

        return redirect()->to('/petugas/reservasi/data');
    }

    public function cekout($id_reservasi)
    {
        $this->reservasi->update($id_reservasi, ['status' => 'Check-Out']);
        session()->setFlashdata('kembali', '/petugas/reservasi/data');

        return redirect()->to("/invoice/{$id_reservasi}");
    }

    public function tampilreservasiform()
    {
        $data['fasilitas_hotel'] = $this->fumum->findAll();
        $data['tipe_kamar'] = $this->tipe_kamar->findAll();

        $data['tipe_kamar'] = array_map(function ($tipe_kamar) {
            $tipe_kamar['fasilitas'] = $this->fkamar
                ->where(['id_tipe_kamar' => $tipe_kamar['id']])
                ->find();

            return $tipe_kamar;
        }, $data['tipe_kamar']);

        return view('/reservasi/form', $data);
    }

    public function simpan()
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

        return redirect()->to('/petugas/reservasi/data');
    }

    public function edit($id_reservasi)
    {
        $data['reservasi'] = $this->reservasi->find($id_reservasi);
        $data['tipe_kamar'] = $this->tipe_kamar->findAll();
        return view('reservasi/edit', $data);
    }

    public function update($id_reservasi)
    {
        $data_edit = $this->request->getPost();

        // edit reservasinya
        $id_tipe_kamar = $this->request->getPost('id_tipe_kamar');
        $jml_kamar     = $this->request->getPost('jml_kamar');

        // Harga per malam = harga 1 kamar * jumlah kamar
        $tipe_kamar      = $this->tipe_kamar->find($id_tipe_kamar);
        $harga_kamar     = $tipe_kamar['harga'];
        $harga_per_malam = $harga_kamar * $jml_kamar;
        $data_edit['harga'] = $harga_per_malam;

        // Lama menginap = Selisih Checkin & Checkout = Checkout - Checkin
        // selisih = yang gede - yang kecil
        $check_in      = $this->request->getPost('checkin');
        $check_out     = $this->request->getPost('checkout');
        $lama_menginap = (strtotime($check_out) - strtotime($check_in)) / 60 / 60 / 24;

        // Harga total = harga per-malam * lama menginap
        $total = $harga_per_malam * $lama_menginap;
        $data_edit['total'] = $total;

        $this->reservasi->update($id_reservasi, $data_edit);

        // balikin ketampil data
        return redirect()->to('/petugas/reservasi/data');
    }

    public function batal($id_reservasi)
    {
        $syarat = ['id_reservasi' => $id_reservasi];

        $this->reservasi->where($syarat)->delete();
        session()->setFlashdata('batal', 'Data Reservasi berhasil dibatalkan');
        return redirect()->to('/petugas/reservasi/data');
    }
}
