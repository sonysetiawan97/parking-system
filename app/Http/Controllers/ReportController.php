<?php

namespace App\Http\Controllers;

use App\Exports\ExportCarParking;
use App\Models\CarParking;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportUsers;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        if ($endDate && $startDate) {
            if ($startDate > $endDate) {
                return back()->with('error', 'Tanggal berakhir tidak bisa lebih besar dibandingkan tanggal mulai');
            }
        }

        $tableHeader = $this->getTableHeader();
        $entries = new CarParking();
        if ($startDate) {
            $entries = $entries->where('time_in', '>=', $startDate);
        }
        if ($endDate) {
            $entries = $entries->where('time_in', '<=', date('Y-m-d', strtotime($endDate . ' + 1 day')));
        }

        $entries = $entries->get();


        $data = [
            'tableHeader' => $tableHeader,
            'tableEntries' => $entries,
            'params' => $request->all(),
        ];

        return view('report.index', $data);
    }

    public function report(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        if ($endDate && $startDate) {
            if ($startDate > $endDate) {
                return back()->with('error', 'Tanggal berakhir tidak bisa lebih besar dibandingkan tanggal mulai');
            }
        }

        return Excel::download(new ExportCarParking($startDate, $endDate), 'car_parking.xlsx');
    }

    private function getTableHeader(): array
    {
        return [
            [
                'name' => 'unique_code',
                'label' => 'Kode Unik',
            ],
            [
                'name' => 'car_number_plate',
                'label' => 'No Polisi',
            ],
            [
                'name' => 'time_in',
                'label' => 'Jam Masuk',
            ],
            [
                'name' => 'time_out',
                'label' => 'Jam Keluar',
            ],
            [
                'name' => 'price',
                'label' => 'Harga',
            ],
            [
                'name' => 'status_parking',
                'label' => 'Status',
            ],
        ];
    }
}
