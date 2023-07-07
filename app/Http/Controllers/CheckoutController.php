<?php

namespace App\Http\Controllers;

use App\Models\CarParking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout.index');
    }

    public function checkout(Request $request) {
        $uniqueCode = $request->get('unique_code');
        $time = Carbon::now()->format('Y-m-d H:i:s');
        $car = $this->isCarParking($uniqueCode);

        if ($car) {
            if ($car->time_out) {
                return back()->with('success', 'This ticket is already payout.');
            }
            $price = $this->getPrice($car, $time);
            $body = [
                'price' => $price,
                'time_out' => $time,
                'status_parking' => 'parking_out',
            ];
            $car->update($body);
            return back()->with('success', 'Success');
        }

        $body = [
            'unique_code' => Uuid::uuid4()->toString(),
            'car_number_plate' => 'unknown',
            'time_in' => $time,
            'time_out' => $time,
            'status_parking' => 'fine',
        ];

        CarParking::create($body);
        return back()->with('success', 'Your car is fined, because you parking without get ticket');
    }

    private function isCarParking(string $uniqueCode): CarParking|null
    {
        $car = CarParking::where(
            [
                'unique_code' => $uniqueCode
            ]
        )->first();

        if (is_null($car)) {
            return null;
        }

        return $car;
    }

    private function getPrice(CarParking $car, String $timeOut): float
    {
        $timeIn = Carbon::createFromTimeString($car->time_in);
        $timeOut = Carbon::createFromTimeString($timeOut);
        $timeParkingInSeconds = $timeIn->diffInSeconds($timeOut);
        $timeParkingPrice = ceil($timeParkingInSeconds / 3600) * 3000;

        return $timeParkingPrice;
    }
}
