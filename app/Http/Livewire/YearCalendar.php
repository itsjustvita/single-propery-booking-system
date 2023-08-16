<?php

namespace App\Http\Livewire;

use App\Models\Booking;
use Livewire\Component;
use Carbon\Carbon;


class YearCalendar extends Component
{
    public $year;
    public $months = [];
    public $bookedDates = [];

    public function mount()
    {
        Carbon::setLocale('de');
        $this->year = now()->year;
        $this->loadBookings();
        $this->generateCalendar();
    }

    public function updatedYear()
    {
        $this->generateCalendar();
    }

    private function generateCalendar()
    {
        $this->months = [];
        for ($i = 1; $i <= 12; $i++) {
            $date = Carbon::create($this->year, $i, 1);
            $daysInMonth = $date->daysInMonth;
            $monthData = [];
            for ($j = 1; $j <= $daysInMonth; $j++) {
                $currentDate = Carbon::create($this->year, $i, $j);
                $formattedDate = $currentDate->format('Y-m-d');
                $monthData[] = [
                    'day' => $j,
                    'weekday' => $currentDate->isoFormat('ddd'),
                    'offset' => $j == 1 ? $currentDate->isoWeekday() : null,
                    'booked' => in_array($formattedDate, $this->bookedDates)  // check if the date is booked
                ];
            }
            $this->months[$date->translatedFormat('F')] = $monthData;
        }
    }


    private function loadBookings()
    {
        $this->bookedDates = Booking::whereYear('start_date', $this->year)
            ->pluck('start_date')
            ->all();
    }

    public function render()
    {
        return view('livewire.year-calendar');
    }
}
