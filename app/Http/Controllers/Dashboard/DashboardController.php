<?php

namespace App\Http\Controllers\Dashboard;
use Auth;
use App\Models\User;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    private $dasbor;
    public function getStatusPresensi($nama, $status)
    {
        return Kehadiran::selectRaw('count(status_presensi) as ' . $nama)
            ->where('status_presensi', 'like', $status)
            ->where('created_at', 'like', '2023-06-%')
            ->groupBy('user_id')
            ->orderBy('waktu_presensi', 'asc')
            ->get();
    }
    public function countPresensi($data)
    {
        $number = 0;
        foreach ($data as $key => $value) {
            $number += $value['total'];
        }
        return $number;
    }
    public function dasborKaryawan()
    {
        $date = getDateNowParse();
        $weekdays = $this->countDays($date['year'], $date['month'], [0, 6]);
        $presensi = Kehadiran::where('user_id', '=', getUserId())
            ->where('waktu_presensi', 'like', '2023-06-% 07:20:%')
            ->get();
        $izin = Kehadiran::where('user_id', '=', getUserId())
            ->where('status_presensi', '=', 'izin')
            ->get();
        $cuti = Kehadiran::where('user_id', '=', getUserId())
            ->where('status_presensi', '=', 'cuti')
            ->get();
        $izin_cuti = Kehadiran::where('user_id', '=', getUserId())
            ->whereIn('status_presensi', ['izin', 'cuti'])
            ->orderBy('waktu_presensi', 'asc')
            ->get();
        $title = 'Dashboard '.Auth::user()->name;
        return compact('weekdays', 'presensi', 'izin', 'cuti', 'izin_cuti','title');
    }
    public function dasborHRD()
    {
        $date = getDateNowParse();
        $presensi = $this->countPresensi($this->getStatusPresensi('total', 'hadir'));
        $izin = $this->countPresensi($this->getStatusPresensi('total', 'izin'));
        $cuti = $this->countPresensi($this->getStatusPresensi('total', 'cuti'));
        $weekdays = $this->countDays($date['year'], $date['month'], [0, 6]);
        $total_karyawan = User::count();
        $total_presensi = $weekdays * $total_karyawan;
        $title = 'Dashboard '.Auth::user()->name;

        return compact('presensi', 'izin', 'cuti', 'total_presensi','title');
    }
    public function index()
    {
        if (Auth::user()->hasRole('karyawan')) {
            $this->dasbor = $this->dasborKaryawan();
        } elseif (Auth::user()->hasRole('hrd')) {
            $this->dasbor = $this->dasborHRD();
        }

        // dd($this->total_presensi);
        return view('Karyawan.dashboard', $this->dasbor);
    }
    public function countDays($year, $month, $ignore)
    {
        $count = 0;
        $counter = mktime(0, 0, 0, $month, 1, $year);
        while (date('n', $counter) == $month) {
            if (in_array(date('w', $counter), $ignore) == false) {
                $count++;
            }
            $counter = strtotime('+1 day', $counter);
        }
        return $count;
        // echo countDays(2013, 1, array(0, 6)); // 23
    }
    public function getDataKehadiranKaryawan()
    {
        if (Auth::user()->hasRole('karyawan')) {
            $presensi = count(Kehadiran::where('user_id', '=', getUserId())
                ->where('waktu_presensi', 'like', '2023-06-% 07:20:%')
                ->get());
            $izin = count(Kehadiran::where('user_id', '=', getUserId())
                ->where('status_presensi', '=', 'izin')
                ->get());
            $cuti = count(Kehadiran::where('user_id', '=', getUserId())
                ->where('status_presensi', '=', 'cuti')
                ->get());
        }else if(Auth::user()->hasRole('hrd')){
            $presensi = $this->countPresensi($this->getStatusPresensi('total', 'hadir'));
            $izin = $this->countPresensi($this->getStatusPresensi('total', 'izin'));
            $cuti = $this->countPresensi($this->getStatusPresensi('total', 'cuti'));
        }
        return response()->json(['total_presensi' => $presensi,
        'total_izin' => $izin,
        'total_cuti' => $cuti]);
    }
}
