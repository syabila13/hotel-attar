<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['fasilitas_hotel'] = $this->fumum->findAll();
        $data['tipe_kamar'] = $this->tipe_kamar->findAll();

        $data['tipe_kamar'] = array_map(function ($tipe_kamar) {
            $tipe_kamar['fasilitas'] = $this->fkamar
                ->where(['id_tipe_kamar' => $tipe_kamar['id']])
                ->find();

            return $tipe_kamar;
        }, $data['tipe_kamar']);

        return view('hotel', $data);
    }
}
