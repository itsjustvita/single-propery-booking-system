<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // BookingController.php

    public function store(Request $request) {
        $user_id = auth()->user()->id;

        $dates = explode('bis', $request->input('start_date'));
        $start_date = trim($dates[0]);
        $end_date = trim($dates[1]);

        $start_date_formatted = date('Y-m-d', strtotime($start_date));
        $end_date_formatted = date('Y-m-d', strtotime($end_date));

        $request->merge([
            'start_date' => $start_date_formatted,
            'end_date' => $end_date_formatted,
        ]);

        $data = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $data['user_id'] = $user_id;

        Booking::create($data);

        return redirect()->back()->with('success', 'Buchung erfolgreich erstellt!');
    }

}
