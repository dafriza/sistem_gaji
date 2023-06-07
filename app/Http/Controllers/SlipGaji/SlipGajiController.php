<?php

namespace App\Http\Controllers\SlipGaji;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SlipGajiController extends Controller
{
    public function totalPresensiKaryawan()
    {
        DB::select(DB::raw('SELECT status_presensi, u.name, count(status_presensi) FROM `kehadiran` k
        JOIN users u on k.user_id = u.id
        where status_presensi ='.$name.'
        group by status_presensi,u.name;'));
    }
    public function index()
    {
        $title = 'Slip Gaji Karyawan';
        $hadir = DB::select(DB::raw('SELECT status_presensi, u.name, count(status_presensi) FROM `kehadiran` k
        JOIN users u on k.user_id = u.id
        where status_presensi = "hadir"
        group by status_presensi,u.name;'));
        dd($res);
        return view('Karyawan.slip_gaji',compact('title'));
    }
}
