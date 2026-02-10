<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Customer;
use App\Models\Maintenance;
use App\Models\Operator;
use App\Models\Rental;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function getCar(Request $request)
{
    $keySearch = $request->input('search');

    $cars = Car::select(
            'id',
            'brand',
            'model',
            'plate_number',
            'color',
            'year',
            'status',
            'price_per_day',
            'image'
        )
        ->withAvg('ratings', 'rating')      // ⭐ rata-rata rating
        ->withCount('ratings')              // ⭐ jumlah rating
        ->when($keySearch, function ($query, $keySearch) {
            $query->where(function ($q) use ($keySearch) {
                $q->where('brand', 'like', "%$keySearch%")
                    ->orWhere('model', 'like', "%$keySearch%")
                    ->orWhere('plate_number', 'like', "%$keySearch%")
                    ->orWhere('color', 'like', "%$keySearch%")
                    ->orWhere('year', 'like', "%$keySearch%")
                    ->orWhere('status', 'like', "%$keySearch%");
            });
        })
        ->orderBy('id', 'desc')
        ->get();

    return inertia('App/CarList', [
        'cars' => $cars
    ]);
}


    public function dashboard()
    {
        $totalCar = Car::get()->count();
        $totalCustomer = Customer::get()->count();
        $totalTransaction = Rental::get()->count();
        $totalOperator = Operator::get()->count();
        $totalMaintenance = Maintenance::get()->count();

        $recentTransactions = Rental::with(['customer', 'car'])
            ->latest()
            ->take(5)
            ->get();

        return inertia('Admin/Dashboard', [
            'totalCar' => $totalCar,
            'totalCustomer' => $totalCustomer,
            'totalTransaction' => $totalTransaction,
            'totalOperator' => $totalOperator,
            'recentTransactions' => $recentTransactions,
            'totalMaintenance' => $totalMaintenance
        ]);
    }
}
