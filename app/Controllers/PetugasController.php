<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Petugas;
use App\Models\Kamar;
use App\Models\FKamar;
use App\Models\Fumum;

class PetugasController extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function login()
    {
        $Datapetugas = new Petugas;
        $syarat = [
            'username' => $this->request->getPost('txtUsername'),
            'password' => md5($this->request->getPost('txtPassword'))
        ];
        $Userpetugas = $Datapetugas->where($syarat)->find();
        if (count($Userpetugas) == 1) {
            $session_data = [
                'username' => $Userpetugas[0]['username'],
                'id_petugas' => $Userpetugas[0]['id_petugas'],
                'level' => $Userpetugas[0]['level'],
                'sudahkahLogin' => TRUE
            ];
            session()->set($session_data);
            if (session()->get('level') == 'admin') {
                return redirect()->to('/petugas/dashboard');
            } else {
                return redirect()->to('/reservasi/dashboard-reservasi');
            }
        } else {
            session()->setFlashdata('salahlogin', 'username atau password');
            return redirect()->to('/petugas');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/petugas');
    }

    public function tampilKamar()
    {
        if (!session()->get('sudahkahLogin')) {
            return redirect()->to('/kamar');
            exit;
        }
        // cek apakah yang login bukan admin ? 
        if (session()->get('level') != 'admin') {
            return redirect()->to('/petugas/kamar/dashboard');
            exit;
        }
        $Datakamar = new kamar;
        $data['ListKamar'] = $Datakamar
            ->join('tipe_kamar', 'tipe_kamar.id=id_tipe_kamar')
            ->findAll();

        return view('kamar/tampil-kamar', $data);
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function tambahKamar()
    {
        if (!session()->get('sudahkahLogin')) {
            return redirect()->to('/kamar');
            exit;
        }
        // cek apakah yang login bukan admin ?
        if (session()->get('level') != 'admin') {
            return redirect()->to('/petugas/kamar/dashboard');
            exit;
        }
        return view('Kamar/tambah');
    }

    public function simpanKamar()
    {
        if (!session()->get('sudahkahLogin')) {
            return redirect()->to('/petugas');
            exit;
        }
        // cek apakah yang login bukan admin ?
        if (session()->get('level') != 'admin') {
            return redirect()->to('/petugas');
            exit;
        }
        helper(['form']);

        // $fileFoto = $this->request->getFile('foto');
        // $fileFoto->move(WRITEPATH . '../public/gambar');
        $DataKamar = new Kamar;
        $datanya = [
            'no_kamar' => $this->request->getPost('no_kamar'),
            'id_tipe_kamar' => $this->request->getPost('id_tipe_kamar'),
            // 'foto'=>$fileFoto->getName(),
            //'deskripsi'=>$this->request->getPost('deskripsi'),
            // 'harga'=>$this->request->getPost('harga')
        ];
        $DataKamar->insert($datanya);
        return redirect()
            ->to('/petugas/kamar')
            ->with('pesan', 'Kamar berhasil ditambahkan');
    }

    public function editKamar($idKamar)
    {
        // cek apakah sudah login ?
        if (!session()->get('sudahkahLogin')) {
            return redirect()->to('/petugas');
            exit;
        }
        // cek apakah yang login bukan admin ?
        if (session()->get('level') != 'admin') {
            return redirect()->to('/petugas/dashboard');
            exit;
        }
        // cek apakah yang login bukan admin ?
        if (session()->get('level') != 'admin') {
            return redirect()->to('/petugas/dashboard');
            exit;
        }
        $DataKamar = new Kamar;
        $data['detailkamar'] = $DataKamar->where('id_kamar', $idKamar)->findAll();

        return view('Kamar/edit-kamar', $data);
    }

    public function updatekamar()
    {
        // cek apakah sudah login
        if (!session()->get('sudahkahLogin')) {
            return redirect()->to('/kamar');
            exit;
        }
        // cek apakah yang login bukan admin ?
        if (session()->get('level') != 'admin') {
            return redirect()->to('/petugas/dashboard');
            exit;
        }
        $Datakamar = new Kamar;

        $dataupdate = [
            'id_tipe_kamar' => $this->request->getPost('id_tipe_kamar'),
            // 'foto'=>'tes',//$fileFoto->getName(),
            // 'deskripsi'=>$this->request->getPost('txtdeskripsi'),
            // 'harga'=>$this->request->getPost('harga')
        ];
        $Datakamar->update($this->request->getPost('id_kamar'), $dataupdate);

        // $type=$this->request->getPost('type_kamar');
        // $des=$this->request->getPost('deskripsi');
        // $harga=$this->request->getPost('harga');
        // $id=$this->request->getPost('no_kamar');

        // echo $harga."harga<br>";
        // echo $id."id<br>";
        // echo $des."deskripsi<br>";
        // echo $type."type<br>";

        return redirect()
            ->to('/petugas/kamar')
            ->with('pesan', 'Kamar berhasil di edit');
    }

    public function hapuskamar($idKamar)
    {
        // cek apakah sudah login
        if (!session()->get('sudahkahLogin')) {
            return redirect()->to('/kamar');
            exit;
        }
        // cek apakah yang login bukan admin ?
        if (session()->get('level') != 'admin') {
            return redirect()->to('/petugas/dashboard');
            exit;
        }
        $kamar = new Kamar;
        $syarat = ['id_kamar' => $idKamar];
        $infoFile = $kamar->where($syarat)->find();
        //hapus foto
        // unlink('gambar/' .$infoFile[0]['foto']);
        $kamar->where('id_kamar', $idKamar)->delete();
        return redirect()
            ->to('/petugas/kamar')
            ->with('pesan', 'Kamar berhasil di hapus');
    }

    // crud fasilitas kamar 
    public function tampilfkamar()
    {
        if (!session()->get('sudahkahLogin')) {
            return redirect()->to('/petugas/dashboard');
            exit;
        }
        // cek apakah yang login bukan admin ? 
        if (session()->get('level') != 'admin') {
            return redirect()->to('/fkamar/tampil-fkamar');
            exit;
        }
        $DataFkamar = new FKamar;
        $data['ListFKamar'] = $DataFkamar
            ->select('*, fasilitas_kamar.deskripsi')
            ->join('tipe_kamar', 'tipe_kamar.id=id_tipe_kamar')
            ->findAll();

        return view('fkamar/tampil-fkamar', $data);
    }

    public function tambahfKamar()
    {
        if (!session()->get('sudahkahLogin')) {
            return redirect()->to('/petugas');
            exit;
        }
        // cek apakah yang login bukan admin ?
        if (session()->get('level') != 'admin') {
            return redirect()->to('/petugas/dashboard');
            exit;
        }
        $kamarModel = new Kamar;
        $data = [
            'kamar' => $kamarModel->findAll()
        ];
        return view('fkamar/tambah-fkamar', $data);
    }

    public function simpanFKamar()
    {
        if (!session()->get('sudahkahLogin')) {
            return redirect()->to('/petugas');
            exit;
        }
        // cek apakah yang login bukan admin ?
        if (session()->get('level') != 'admin') {
            return redirect()->to('/petugas');
            exit;
        }
        helper(['form']);

        $DataFKamar = new FKamar;
        $datanya = [
            'id_fkamar' => $this->request->getPost('id_fkamar'),
            'nama_fkamar' => $this->request->getPost('nama_fkamar'),
            'id_tipe_kamar' => $this->request->getPost('tipe_kamar'),
            'deskripsi' => $this->request->getPost('deskripsi')
        ];
        $DataFKamar->insert($datanya);
        return redirect()
            ->to('/petugas/fkamar/tampil')
            ->with('pesan', 'Fasilitas Kamar berhasil di tambahkan');
    }

    public function editFKamar($idFKamar)
    {
        // cek apakah sudah login ?
        if (!session()->get('sudahkahLogin')) {
            return redirect()->to('/petugas');
            exit;
        }
        // cek apakah yang login bukan admin ?
        if (session()->get('level') != 'admin') {
            return redirect()->to('/petugas/dashboard');
            exit;
        }
        // cek apakah yang login bukan admin ?
        if (session()->get('level') != 'admin') {
            return redirect()->to('/petugas/dashboard');
            exit;
        }
        $DataFKamar = new FKamar;
        $data['detailfkamar'] = $DataFKamar->where('id_fkamar', $idFKamar)->findAll();

        return view('fkamar/edit-fkamar', $data);
    }

    public function updatefkamar()
    {
        // cek apakah sudah login
        if (!session()->get('sudahkahLogin')) {
            return redirect()->to('/petugas');
            exit;
        }
        // cek apakah yang login bukan admin ?
        if (session()->get('level') != 'admin') {
            return redirect()->to('/petugas/dashboard');
            exit;
        }
        $Datafkamar = new FKamar;

        $dataupdate = [
            'id_tipe_kamar' => $this->request->getPost('tipe_kamar'),
            'nama_fkamar' => $this->request->getPost('nama_fkamar'),
            // 'foto'=>'tes',//$fileFoto->getName(),
            'deskripsi' => $this->request->getPost('txtdeskripsi'),
        ];
        $Datafkamar->update($this->request->getPost('id_fkamar'), $dataupdate);

        // $type=$this->request->getPost('type_kamar');
        // $des=$this->request->getPost('deskripsi');
        // $harga=$this->request->getPost('harga');
        // $id=$this->request->getPost('no_kamar');

        // echo $harga."harga<br>";
        // echo $id."id<br>";
        // echo $des."deskripsi<br>";
        // echo $type."type<br>";

        return redirect()
            ->to('/petugas/fkamar/tampil')
            ->with('pesan', 'Fasilitas Kamar berhasil di edit');
    }

    public function hapusfkamar($idFKamar)
    {
        // cek apakah sudah login
        if (!session()->get('sudahkahLogin')) {
            return redirect()->to('/petugas');
            exit;
        }
        // cek apakah yang login bukan admin ?
        if (session()->get('level') != 'admin') {
            return redirect()->to('/petugas/dashboard');
            exit;
        }
        $datafkamar = new FKamar;
        $syarat = ['id_fkamar' => $idFKamar];
        $infoFile = $datafkamar->where($syarat)->find();
        //hapus foto
        $datafkamar->where('id_fkamar', $idFKamar)->delete();
        return redirect()
            ->to('/petugas/fkamar/tampil')
            ->with('pesan', 'Fasilitas Kamar berhasil di hapus');
    }

    // crud fasilitas hotel 
    public function tampilfumum()
    {
        if (!session()->get('sudahkahLogin')) {
            return redirect()->to('/petugas/dashboard');
            exit;
        }
        // cek apakah yang login bukan admin ? 
        if (session()->get('level') != 'admin') {
            return redirect()->to('/fumum/tampil-fumum');
            exit;
        }
        $DataFumum = new Fumum;
        $data['ListFumum'] = $DataFumum->findAll();
        //    $data['joinKamar'] = $DataFkamar->join_kamar();
        return view('fumum/tampil-fumum', $data);
    }

    public function tambahfumum()
    {
        if (!session()->get('sudahkahLogin')) {
            return redirect()->to('/petugas');
            exit;
        }
        // cek apakah yang login bukan admin ?
        if (session()->get('level') != 'admin') {
            return redirect()->to('/petugas/dashboard');
            exit;
        }
        $kamarModel = new Fumum;
        $data = [
            'kamar' => $kamarModel->findAll()
        ];
        return view('fumum/tambah-fumum', $data);
    }

    public function simpanFumum()
    {
        if (!session()->get('sudahkahLogin')) {
            return redirect()->to('/petugas');
            exit;
        }
        // cek apakah yang login bukan admin ?
        if (session()->get('level') != 'admin') {
            return redirect()->to('/petugas');
            exit;
        }
        helper(['form']);

        $fileFoto = $this->request->getFile('foto');
        $fileFoto->move(WRITEPATH . '../public/gambar');
        $DataFumum = new Fumum;
        $datanya = [
            'nama_fasilitas_hotel' => $this->request->getPost('nama_fasilitas_hotel'),
            'foto' => $fileFoto->getName(),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ];
        $DataFumum->insert($datanya);
        return redirect()
            ->to('/petugas/fumum/tampil')
            ->with('pesan', 'Fasilitas Umum berhasil di simpan');
    }

    public function editFumum($idFumum)
    {
        // cek apakah sudah login ?
        if (!session()->get('sudahkahLogin')) {
            return redirect()->to('/petugas');
            exit;
        }
        // cek apakah yang login bukan admin ?
        if (session()->get('level') != 'admin') {
            return redirect()->to('/petugas/dashboard');
            exit;
        }
        // cek apakah yang login bukan admin ?
        if (session()->get('level') != 'admin') {
            return redirect()->to('/petugas/dashboard');
            exit;
        }
        $DataFumum = new Fumum;
        $data['detailfumum'] = $DataFumum->where('id_hotel', $idFumum)->findAll();

        return view('fumum/edit-fumum', $data);
    }

    public function updatefumum()
    {
        // cek apakah sudah login
        if (!session()->get('sudahkahLogin')) {
            return redirect()->to('/petugas');
            exit;
        }
        // cek apakah yang login bukan admin ?
        if (session()->get('level') != 'admin') {
            return redirect()->to('/petugas/dashboard');
            exit;
        }
        $fileFoto = $this->request->getFile('foto');
        $fileFoto->move(WRITEPATH . '../public/gambar');

        $Datafumum = new Fumum;

        $dataupdate = [
            //'type_fkamar'=>$this->request->getPost('type_fkamar'),
            'nama_n' => $this->request->getPost('nama_fhotel'),
            'foto' => $fileFoto->getName(),
            'deskripsi' => $this->request->getPost('txtdeskripsi'),
        ];
        $Datafumum->update($this->request->getPost('id_hotel'), $dataupdate);

        // $type=$this->request->getPost('type_kamar');
        // $des=$this->request->getPost('deskripsi');
        // $harga=$this->request->getPost('harga');
        // $id=$this->request->getPost('no_kamar');

        // echo $harga."harga<br>";
        // echo $id."id<br>";
        // echo $des."deskripsi<br>";
        // echo $type."type<br>";

        return redirect()
            ->to('/petugas/fumum/tampil')
            ->with('pesan', 'Fasilitas Umum berhasil di edit');
    }

    public function hapusfumum($idFumum)
    {
        // cek apakah sudah login
        if (!session()->get('sudahkahLogin')) {
            return redirect()->to('/petugas');
            exit;
        }

        // cek apakah yang login bukan admin ?
        if (session()->get('level') != 'admin') {
            return redirect()->to('/petugas/dashboard');
            exit;
        }

        $datafumum = new Fumum;
        $syarat = ['id_hotel' => $idFumum];
        $infoFile = $datafumum->where($syarat)->find();
        //hapus foto
        $datafumum->where('id_hotel', $idFumum)->delete();
        return redirect()
            ->to('/petugas/fumum/tampil')
            ->with('pesan', 'Fasilitas Umum berhasil di hapus');
    }
}
