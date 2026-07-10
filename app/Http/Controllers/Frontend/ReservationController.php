<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ReservationRequest;
use App\Models\DiningTable;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function create()
    {
        return view('frontend.reservation.create', [
            'tables' => DiningTable::available()->orderBy('name')->get(),
        ]);
    }

    public function store(ReservationRequest $request)
    {
        if ($request->filled('dining_table_id')) {
            $exists = Reservation::where('dining_table_id', $request->dining_table_id)
                ->where('reservation_date', $request->reservation_date)
                ->where('reservation_time', $request->reservation_time)
                ->whereIn('status', ['pending', 'confirmed'])
                ->exists();

            if ($exists) {
                return back()->withErrors(['dining_table_id' => 'This table is already reserved for that date and time.'])->withInput();
            }
        }

        Reservation::create($request->validated());

        return redirect()->route('frontend.reservation.create')->with('success', 'Reservation request submitted. We will confirm shortly.');
    }
}
