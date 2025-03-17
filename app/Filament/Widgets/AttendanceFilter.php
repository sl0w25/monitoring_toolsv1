<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use App\Models\LocationInfo;
use Filament\Widgets\Widget;

class AttendanceFilterWidget extends Widget
{
    protected static string $view = 'filament.widgets.attendance-filter-widget';

    public $barangay = null;
    public $municipality = null;
    public $province = null;

    public $attendances = [];

    public function updated($property)
    {
        $this->filterAttendances();
    }

    public function filterAttendances()
    {
        $query = Attendance::query();

        if ($this->province) {
            $query->whereHas('locationInfo', function ($q) {
                $q->where('province', $this->province);
            });
        }

        if ($this->municipality) {
            $query->whereHas('locationInfo', function ($q) {
                $q->where('municipality', $this->municipality);
            });
        }

        if ($this->barangay) {
            $query->where('barangay', $this->barangay);
        }

        $this->attendances = $query->latest()->get();
    }

    public function mount()
    {
        $this->filterAttendances();
    }
}
