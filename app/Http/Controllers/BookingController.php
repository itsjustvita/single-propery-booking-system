<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // BookingController.php

    public function store(Request $request) {
        $user_id = auth()->user()->id;
        $data = $request->validate([
            'start_date' => 'required|date'
        ]);

        $data['user_id'] = 1;
        $data['end_date'] = date('Y-m-d', strtotime($data['start_date']. ' + 1 days'));

        Booking::create($data);

        return redirect()->back()->with('success', 'Buchung erfolgreich erstellt!');
    }

}
