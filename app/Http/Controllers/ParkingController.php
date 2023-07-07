<?php

namespace App\Http\Controllers;

use App\Models\CarParking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class ParkingController extends Controller
{
    public function index()
    {
        return view('parking.index');
    }

    public function create(Request $request)
    {
        $carNumberPlate = $request->get('car_number_plate');
        $time = Carbon::now()->format('Y-m-d H:i:s');
        $car = $this->isCarParking($carNumberPlate);
        $message = '';

        if ($car) {
            $price = $this->getPriceFine();
            $body = [
                'price' => $price,
                'time_out' => $time,
                'status_parking' => 'fine',
            ];
            $car->update($body);
            $message .= 'Your car is fined, because you didn\'t pay before, ';
        }

        $body = [
            'unique_code' => Uuid::uuid4()->toString(),
            'car_number_plate' => $carNumberPlate,
            'time_in' => $time,
            'status_parking' => 'parking',
        ];

        CarParking::create($body);
        $message .= 'Your ticket generated';
        return back()->with('success', $message);
    }

    private function isCarParking(string $carNumberPlate): CarParking|null
    {
        $car = CarParking::where(
            [
                'car_number_plate' => $carNumberPlate
            ]
        )->whereNull('time_out')->first();

        if (is_null($car)) {
            return null;
        }

        return $car;
    }

    private function getPriceFine() : float {
        return 50000;
    }
}
