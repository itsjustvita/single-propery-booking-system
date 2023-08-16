<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;


class YearCalendar extends Component
{
    public $year;
    public $months = [];


    public function mount()
    {
        Carbon::setLocale('de');
        $this->year = now()->year;
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
                $monthData[] = [
                    'day' => $j,
                    'weekday' => $currentDate->isoFormat('ddd'),
                    'offset' => $j == 1 ? $currentDate->isoWeekday() : null
                ];
            }
            $this->months[$date->translatedFormat('F')] = $monthData;
        }
    }



    public function render()
    {
        return view('livewire.year-calendar');
    }
}
