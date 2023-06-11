<?php

namespace App\Http\Controllers\DomPDF;

use App\Models\Salary;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use DB;

class DomPDFController extends Controller
{
    public function getUserFromSalary($id)
    {
        return Salary::where('user_id', $id)
            ->with('user')
            ->first();
    }
    public function viewPDF($id)
    {
        $data = $this->getUserFromSalary($id);
        $title = 'Slip Gaji '.$data->user->nama;
        // return response()->json([
        //     'data' => $res,
        // ]);

        $pdf = Pdf::loadView('pdf.paycheck',compact('data','title'));
        return $pdf->stream();
    }
    public function downloadPDF()
    {
        return;
    }
}
