<?php

namespace App\Http\Controllers\Presensi;
use Alert;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    public function index()
    {
        return view('Karyawan.presensi');
    }
    public function store(Request $request)
    {
        if ($request->presensi == 'hadir') {
            Kehadiran::create([
                'status_presensi' => 'hadir',
                'waktu_presensi' => now(),
                'deskripsi' => "bekerja di kantor",
                'user_id' => getUserId(),
            ]);
            return redirect()->route('presensi.index')->with('success','Success Presensi!');
        } elseif ($request->presensi == 'pulang') {
            Kehadiran::create([
                'status_presensi' => 'pulang',
                'waktu_presensi' => now(),
                'deskripsi' => "pulang di kantor",
                'user_id' => getUserId(),
            ]);
            return redirect()->route('presensi.index')->with('success','Success Presensi!');
        } elseif ($request->presensi == 'izin'){
            Kehadiran::create([
                'status_presensi' => 'izin',
                'waktu_presensi' => now(),
                'deskripsi' => $request->deskripsi,
                'user_id' => getUserId()
            ]);
            return redirect()->route('presensi.index')->with('success','Success Presensi!');
        } elseif ($request->presensi == 'cuti'){
            Kehadiran::create([
                'status_presensi' => 'cuti',
                'waktu_presensi' => now(),
                'deskripsi' => $request->deskripsi,
                'user_id' => getUserId()
            ]);
            return redirect()->route('presensi.index')->with('success','Success Presensi!');
        }
    }

}
