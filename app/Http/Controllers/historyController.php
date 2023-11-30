<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\datadht;
use App\Models\ledstatus;
use App\Models\fanstatus;
session_start();
class historyController extends Controller 
{
    public function history()
    {
        $ledstatus = ledstatus::orderBy('id', 'desc')->get(); 
        $fanstatus = fanstatus::orderBy('id', 'desc')->get();
        $datadht = datadht::orderBy('id', 'desc')->get();
        $dataToView = [
            'ledstatus' => $ledstatus,
            'fanstatus' => $fanstatus,
            'datadht' => $datadht
        ];

        // Truyền mảng dữ liệu vào hàm view
        return view('pages.history', $dataToView);
    }
    public function search(Request $request)
    {
        $data = $request->all();
        $datax = $data['daysearch'];

        $ledstatus = ledstatus::where('day', $data['daysearch'])->get();
        $fanstatus = fanstatus::where('day', $data['daysearch'])->get();
        $datadht = datadht::where('day', $data['daysearch'])->get();

        // Gộp dữ liệu cần truyền vào một mảng duy nhất
        $dataToView = [
            'ledstatus' => $ledstatus,
            'fanstatus' => $fanstatus,
            'datadht' => $datadht,
            'datax' => $datax, // Thêm datax vào mảng dữ liệu để truyền vào view
        ];

        // Truyền mảng dữ liệu vào hàm view
        return view('pages.search', $dataToView);
    }
}
