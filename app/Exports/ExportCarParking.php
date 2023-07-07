<?php

namespace App\Exports;

use App\Models\CarParking;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportCarParking implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $startDate;
    protected $endDate;

    function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $entries = new CarParking();
        if ($this->startDate) {
            $entries = $entries->where('time_in', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $entries = $entries->where('time_in', '<=', date('Y-m-d', strtotime($this->endDate . ' + 1 day')));
        }

        $data = $this->getTableHeader();
        $column = array_map(function ($entry) {
            return $entry['name'];
        }, $data);

        $entries = $entries->select($column)->get();
        return $entries;
    }

    public function headings(): array
    {
        $data = $this->getTableHeader();
        return array_map(function ($entry) {
            return $entry['label'];
        }, $data);
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
